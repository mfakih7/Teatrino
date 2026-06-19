<?php

namespace App\Filament\Resources\SiteSettings\Pages;

use App\Filament\Resources\SiteSettings\SiteSettingResource;
use App\Models\SiteSetting;
use Filament\Resources\Pages\EditRecord;

class ManageSiteSetting extends EditRecord
{
    protected static string $resource = SiteSettingResource::class;

    protected static ?string $title = 'Site Settings';

    public function mount(int|string|null $record = null): void
    {
        $this->record = SiteSetting::instance();
        $this->authorizeAccess();
        $this->fillForm();
        $this->previousUrl = url()->previous();
    }

    protected function getRedirectUrl(): ?string
    {
        return null;
    }
}
