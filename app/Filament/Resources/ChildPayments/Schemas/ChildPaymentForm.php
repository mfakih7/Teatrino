<?php

namespace App\Filament\Resources\ChildPayments\Schemas;

use App\Enums\PaymentStatus;
use App\Models\Child;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;

class ChildPaymentForm
{
    public static function configure(Schema $schema): Schema
    {
        $currentYear = (int) now()->year;

        return $schema->components([
            Section::make('Payment Details')->schema([
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
                Hidden::make('parent_id')
                    ->required(),
                Select::make('month')
                    ->options(self::monthOptions())
                    ->required()
                    ->default(now()->month)
                    ->live(),
                Select::make('year')
                    ->options(collect(range($currentYear - 2, $currentYear + 2))
                        ->mapWithKeys(fn (int $year) => [$year => (string) $year])
                        ->all())
                    ->required()
                    ->default($currentYear)
                    ->live(),
                TextInput::make('amount')
                    ->numeric()
                    ->required()
                    ->minValue(0)
                    ->step(0.01)
                    ->default(150),
                TextInput::make('currency')
                    ->default('USD')
                    ->maxLength(3)
                    ->required(),
                Select::make('status')
                    ->options(collect(PaymentStatus::cases())->mapWithKeys(
                        fn (PaymentStatus $status) => [$status->value => $status->label()]
                    )->all())
                    ->default(PaymentStatus::Pending->value)
                    ->required(),
                DatePicker::make('due_date'),
                DateTimePicker::make('paid_at'),
                TextInput::make('payment_method')
                    ->maxLength(100),
            ])->columns(2),
            Section::make('Notes')->schema([
                Textarea::make('notes')
                    ->rows(4)
                    ->columnSpanFull(),
            ]),
        ]);
    }

    /**
     * @return array<int, string>
     */
    private static function monthOptions(): array
    {
        return collect(range(1, 12))
            ->mapWithKeys(fn (int $month) => [
                $month => now()->month($month)->format('F'),
            ])
            ->all();
    }
}
