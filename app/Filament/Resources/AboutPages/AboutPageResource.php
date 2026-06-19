<?php

namespace App\Filament\Resources\AboutPages;

use App\Filament\Concerns\HasSingletonResourceUrls;
use App\Filament\Resources\AboutPages\Pages\ManageAboutPage;
use App\Filament\Resources\AboutPages\Schemas\AboutPageForm;
use App\Models\AboutPage;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Illuminate\Database\Eloquent\Model;

class AboutPageResource extends Resource
{
    use HasSingletonResourceUrls;

    protected static ?string $model = AboutPage::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedInformationCircle;

    protected static ?string $navigationLabel = 'About Us';

    protected static ?string $modelLabel = 'About Us';

    protected static ?int $navigationSort = 4;

    public static function getNavigationGroup(): ?string
    {
        return 'Website Management';
    }

    public static function form(Schema $schema): Schema
    {
        return AboutPageForm::configure($schema);
    }

    public static function getPages(): array
    {
        return [
            'edit' => ManageAboutPage::route('/'),
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
