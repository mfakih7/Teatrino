<?php

namespace App\Filament\Resources\HomeContents;

use App\Filament\Concerns\HasSingletonResourceUrls;
use App\Filament\Resources\HomeContents\Pages\ManageHomeContent;
use App\Filament\Resources\HomeContents\Schemas\HomeContentForm;
use App\Models\HomeContent;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Illuminate\Database\Eloquent\Model;

class HomeContentResource extends Resource
{
    use HasSingletonResourceUrls;

    protected static ?string $model = HomeContent::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedHome;

    protected static ?string $navigationLabel = 'Home Contents';

    protected static ?string $modelLabel = 'Home Contents';

    protected static ?int $navigationSort = 2;

    public static function getNavigationGroup(): ?string
    {
        return 'Website Content';
    }

    public static function form(Schema $schema): Schema
    {
        return HomeContentForm::configure($schema);
    }

    public static function getPages(): array
    {
        return [
            'edit' => ManageHomeContent::route('/'),
        ];
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function canDelete(Model $record): bool
    {
        return false;
    }
}
