<?php

namespace App\Filament\Resources\ChildWeeklyReports\Schemas;

use App\Filament\Support\ReportStatusOptions;
use App\Models\Child;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;

class ChildWeeklyReportForm
{
    public static function configure(Schema $schema): Schema
    {
        $statusOptions = ReportStatusOptions::all();

        return $schema->components([
            Section::make('Report Details')->schema([
                Select::make('child_id')
                    ->label('Child')
                    ->relationship('child', 'full_name')
                    ->searchable()
                    ->preload()
                    ->required()
                    ->live()
                    ->afterStateUpdated(function ($state, Set $set): void {
                        $set('parent_id', Child::query()->find($state)?->parent_id);
                    }),
                Hidden::make('parent_id')->required(),
                DatePicker::make('week_start_date')
                    ->required()
                    ->default(now()->startOfWeek()),
                DatePicker::make('week_end_date')
                    ->required()
                    ->default(now()->endOfWeek())
                    ->afterOrEqual('week_start_date'),
            ])->columns(2),
            Section::make('Weekly Status')->schema([
                Select::make('eating_status')->options($statusOptions),
                Select::make('sleeping_status')->options($statusOptions),
                Select::make('learning_status')->options($statusOptions),
                Select::make('playing_status')->options($statusOptions),
                Select::make('behavior_status')->options($statusOptions),
                Select::make('mood_status')->options($statusOptions),
            ])->columns(2),
            Section::make('Notes')->schema([
                Textarea::make('activities_summary')->rows(3)->columnSpanFull(),
                Textarea::make('teacher_notes')->rows(3)->columnSpanFull(),
                Textarea::make('health_notes')->rows(3)->columnSpanFull(),
                Textarea::make('recommendations')->rows(3)->columnSpanFull(),
            ]),
        ]);
    }
}
