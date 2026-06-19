<?php

namespace App\Filament\Resources\ChildPayments\Tables;

use App\Enums\PaymentStatus;
use App\Support\Payments\PaymentWhatsApp;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class ChildPaymentsTable
{
    public static function configure(Table $table): Table
    {
        $currentYear = (int) now()->year;

        return $table
            ->defaultSort('year', 'desc')
            ->columns([
                TextColumn::make('child.full_name')
                    ->label('Child')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('parent.full_name')
                    ->label('Parent')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('period_label')
                    ->label('Period')
                    ->sortable(['year', 'month']),
                TextColumn::make('amount')
                    ->formatStateUsing(fn ($state, $record) => number_format((float) $state, 2).' '.$record->currency)
                    ->sortable(),
                TextColumn::make('status')
                    ->badge()
                    ->formatStateUsing(fn (PaymentStatus $state) => $state->label())
                    ->color(fn (PaymentStatus $state) => $state->color()),
                TextColumn::make('due_date')
                    ->date()
                    ->placeholder('—')
                    ->sortable(),
                TextColumn::make('paid_at')
                    ->dateTime()
                    ->placeholder('—')
                    ->sortable()
                    ->toggleable(),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options(collect(PaymentStatus::cases())->mapWithKeys(
                        fn (PaymentStatus $status) => [$status->value => $status->label()]
                    )->all()),
                SelectFilter::make('month')
                    ->options(collect(range(1, 12))->mapWithKeys(
                        fn (int $month) => [$month => now()->month($month)->format('F')]
                    )->all()),
                SelectFilter::make('year')
                    ->options(collect(range($currentYear - 2, $currentYear + 2))
                        ->mapWithKeys(fn (int $year) => [$year => (string) $year])
                        ->all()),
                SelectFilter::make('parent_id')
                    ->label('Parent')
                    ->relationship('parent', 'full_name')
                    ->searchable(),
                SelectFilter::make('child_id')
                    ->label('Child')
                    ->relationship('child', 'full_name')
                    ->searchable(),
            ])
            ->recordActions([
                Action::make('markPaid')
                    ->label('Mark Paid')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->visible(fn ($record) => $record->status !== PaymentStatus::Paid)
                    ->requiresConfirmation()
                    ->action(fn ($record) => $record->markAsPaid()),
                Action::make('markOverdue')
                    ->label('Mark Overdue')
                    ->icon('heroicon-o-exclamation-triangle')
                    ->color('danger')
                    ->visible(fn ($record) => in_array($record->status, [PaymentStatus::Pending, PaymentStatus::Overdue], true))
                    ->requiresConfirmation()
                    ->action(fn ($record) => $record->markAsOverdue()),
                Action::make('whatsappReminder')
                    ->label('WhatsApp Reminder')
                    ->icon('heroicon-o-chat-bubble-left-right')
                    ->color('info')
                    ->visible(fn ($record) => $record->isUnpaid())
                    ->url(fn ($record) => PaymentWhatsApp::reminderUrl($record), shouldOpenInNewTab: true),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
