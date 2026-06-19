<?php

namespace App\Filament\Resources\NurseryParents;

use App\Filament\Resources\NurseryParents\Pages\CreateNurseryParent;
use App\Filament\Resources\NurseryParents\Pages\EditNurseryParent;
use App\Filament\Resources\NurseryParents\Pages\ListNurseryParents;
use App\Filament\Resources\NurseryParents\Pages\ViewNurseryParent;
use App\Filament\Resources\NurseryParents\RelationManagers\ChildrenRelationManager;
use App\Filament\Resources\NurseryParents\Schemas\NurseryParentForm;
use App\Filament\Resources\NurseryParents\Schemas\NurseryParentInfolist;
use App\Filament\Resources\NurseryParents\Tables\NurseryParentsTable;
use App\Models\NurseryParent;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class NurseryParentResource extends Resource
{
    protected static ?string $model = NurseryParent::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedUserGroup;

    protected static ?string $navigationLabel = 'Parents';

    protected static ?string $modelLabel = 'Parent';

    protected static ?string $pluralModelLabel = 'Parents';

    protected static ?int $navigationSort = 10;

    public static function getNavigationGroup(): ?string
    {
        return 'Nursery Management';
    }

    public static function form(Schema $schema): Schema
    {
        return NurseryParentForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return NurseryParentInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return NurseryParentsTable::configure($table);
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->withCount('children');
    }

    public static function getRelations(): array
    {
        return [
            ChildrenRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListNurseryParents::route('/'),
            'create' => CreateNurseryParent::route('/create'),
            'view' => ViewNurseryParent::route('/{record}'),
            'edit' => EditNurseryParent::route('/{record}/edit'),
        ];
    }
}
