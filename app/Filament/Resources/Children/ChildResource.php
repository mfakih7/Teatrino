<?php

namespace App\Filament\Resources\Children;

use App\Filament\Resources\Children\Pages\CreateChild;
use App\Filament\Resources\Children\Pages\EditChild;
use App\Filament\Resources\Children\Pages\ListChildren;
use App\Filament\Resources\Children\Pages\ViewChild;
use App\Filament\Resources\Children\Schemas\ChildForm;
use App\Filament\Resources\Children\Schemas\ChildInfolist;
use App\Filament\Resources\Children\Tables\ChildrenTable;
use App\Models\Child;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class ChildResource extends Resource
{
    protected static ?string $model = Child::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedFaceSmile;

    protected static ?string $navigationLabel = 'Children';

    protected static ?string $modelLabel = 'Child';

    protected static ?int $navigationSort = 11;

    public static function getNavigationGroup(): ?string
    {
        return 'Nursery Management';
    }

    public static function form(Schema $schema): Schema
    {
        return ChildForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return ChildInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ChildrenTable::configure($table);
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->with('parent');
    }

    public static function getPages(): array
    {
        return [
            'index' => ListChildren::route('/'),
            'create' => CreateChild::route('/create'),
            'view' => ViewChild::route('/{record}'),
            'edit' => EditChild::route('/{record}/edit'),
        ];
    }
}
