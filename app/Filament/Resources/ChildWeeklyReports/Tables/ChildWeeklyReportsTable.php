<?php

namespace App\Filament\Resources\ChildWeeklyReports\Tables;

use App\Models\ChildWeeklyReport;
use App\Support\Reports\ReportWhatsApp;
use App\Support\Reports\WeeklyReportPdfGenerator;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Storage;

class ChildWeeklyReportsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('week_start_date', 'desc')
            ->columns([
                TextColumn::make('child.full_name')
                    ->label('Child')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('parent.full_name')
                    ->label('Parent')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('week_range_label')
                    ->label('Week')
                    ->sortable(['week_start_date', 'week_end_date']),
                IconColumn::make('pdf_path')
                    ->label('PDF')
                    ->boolean()
                    ->getStateUsing(fn (ChildWeeklyReport $record) => filled($record->pdf_path))
                    ->trueIcon('heroicon-o-document-check')
                    ->falseIcon('heroicon-o-document-minus')
                    ->trueColor('success')
                    ->falseColor('gray'),
                IconColumn::make('sent_at')
                    ->label('Sent')
                    ->boolean()
                    ->trueIcon('heroicon-o-paper-airplane')
                    ->falseIcon('heroicon-o-clock')
                    ->trueColor('info')
                    ->falseColor('warning'),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(),
            ])
            ->filters([
                SelectFilter::make('child_id')
                    ->label('Child')
                    ->relationship('child', 'full_name')
                    ->searchable(),
                SelectFilter::make('parent_id')
                    ->label('Parent')
                    ->relationship('parent', 'full_name')
                    ->searchable(),
                Filter::make('week_start_date')
                    ->schema([
                        DatePicker::make('from')->label('Week starts from'),
                        DatePicker::make('until')->label('Week starts until'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when($data['from'] ?? null, fn (Builder $q, $date) => $q->whereDate('week_start_date', '>=', $date))
                            ->when($data['until'] ?? null, fn (Builder $q, $date) => $q->whereDate('week_start_date', '<=', $date));
                    }),
                TernaryFilter::make('sent')
                    ->label('Sent to parent')
                    ->queries(
                        true: fn (Builder $query) => $query->whereNotNull('sent_at'),
                        false: fn (Builder $query) => $query->whereNull('sent_at'),
                    ),
                Filter::make('pdf_status')
                    ->label('PDF')
                    ->schema([
                        Select::make('status')
                            ->options([
                                'has' => 'Has PDF',
                                'missing' => 'Missing PDF',
                            ]),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return match ($data['status'] ?? null) {
                            'has' => $query->whereNotNull('pdf_path'),
                            'missing' => $query->whereNull('pdf_path'),
                            default => $query,
                        };
                    }),
            ])
            ->recordActions([
                Action::make('generatePdf')
                    ->label('Generate PDF')
                    ->icon('heroicon-o-document-arrow-down')
                    ->color('primary')
                    ->action(function (ChildWeeklyReport $record): void {
                        app(WeeklyReportPdfGenerator::class)->generate($record);

                        Notification::make()
                            ->title('PDF generated')
                            ->success()
                            ->send();
                    }),
                Action::make('viewPdf')
                    ->label('View PDF')
                    ->icon('heroicon-o-eye')
                    ->color('gray')
                    ->visible(fn (ChildWeeklyReport $record) => filled($record->pdf_path))
                    ->url(fn (ChildWeeklyReport $record) => $record->pdf_url, shouldOpenInNewTab: true),
                Action::make('downloadPdf')
                    ->label('Download PDF')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->color('success')
                    ->visible(fn (ChildWeeklyReport $record) => filled($record->pdf_path))
                    ->action(function (ChildWeeklyReport $record) {
                        $generator = app(WeeklyReportPdfGenerator::class);

                        return response()->download(
                            Storage::disk('public')->path($record->pdf_path),
                            $generator->downloadFilename($record)
                        );
                    }),
                Action::make('whatsappParent')
                    ->label('WhatsApp Parent')
                    ->icon('heroicon-o-chat-bubble-left-right')
                    ->color('info')
                    ->visible(fn (ChildWeeklyReport $record) => filled($record->pdf_path) && ReportWhatsApp::parentUrl($record))
                    ->action(function (ChildWeeklyReport $record) {
                        $record->update(['sent_at' => now()]);

                        return redirect()->away(ReportWhatsApp::parentUrl($record));
                    }),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
