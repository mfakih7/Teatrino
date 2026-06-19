<?php

namespace App\Filament\Resources\ChildPayments;

use App\Filament\Resources\ChildPayments\Pages\CreateChildPayment;
use App\Filament\Resources\ChildPayments\Pages\EditChildPayment;
use App\Filament\Resources\ChildPayments\Pages\ListChildPayments;
use App\Filament\Resources\ChildPayments\Schemas\ChildPaymentForm;
use App\Filament\Resources\ChildPayments\Tables\ChildPaymentsTable;
use App\Models\ChildPayment;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class ChildPaymentResource extends Resource
{
    protected static ?string $model = ChildPayment::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBanknotes;

    protected static ?string $navigationLabel = 'Payments';

    protected static ?string $modelLabel = 'Payment';

    protected static ?int $navigationSort = 12;

    public static function getNavigationGroup(): ?string
    {
        return 'Finance';
    }

    public static function form(Schema $schema): Schema
    {
        return ChildPaymentForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ChildPaymentsTable::configure($table);
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->with(['child', 'parent']);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListChildPayments::route('/'),
            'create' => CreateChildPayment::route('/create'),
            'edit' => EditChildPayment::route('/{record}/edit'),
        ];
    }
}
