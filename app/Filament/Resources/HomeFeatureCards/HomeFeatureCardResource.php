<?php

namespace App\Filament\Resources\HomeFeatureCards;

use App\Filament\Resources\HomeFeatureCards\Pages\CreateHomeFeatureCard;
use App\Filament\Resources\HomeFeatureCards\Pages\EditHomeFeatureCard;
use App\Filament\Resources\HomeFeatureCards\Pages\ListHomeFeatureCards;
use App\Filament\Resources\HomeFeatureCards\Schemas\HomeFeatureCardForm;
use App\Filament\Resources\HomeFeatureCards\Tables\HomeFeatureCardsTable;
use App\Models\HomeFeatureCard;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class HomeFeatureCardResource extends Resource
{
    protected static ?string $model = HomeFeatureCard::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedSparkles;

    protected static ?string $navigationLabel = 'Home Feature Cards';

    protected static ?string $modelLabel = 'Feature Card';

    protected static ?int $navigationSort = 3;

    public static function getNavigationGroup(): ?string
    {
        return 'Website Content';
    }

    public static function form(Schema $schema): Schema
    {
        return HomeFeatureCardForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return HomeFeatureCardsTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListHomeFeatureCards::route('/'),
            'create' => CreateHomeFeatureCard::route('/create'),
            'edit' => EditHomeFeatureCard::route('/{record}/edit'),
        ];
    }
}
