<?php

namespace App\Filament\Resources\AboutPages\Pages;

use App\Filament\Concerns\SyncsUploadedMedia;
use App\Filament\Resources\AboutPages\AboutPageResource;
use App\Models\AboutPage;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Cache;

class ManageAboutPage extends EditRecord
{
    use SyncsUploadedMedia;

    protected static string $resource = AboutPageResource::class;

    protected static ?string $title = 'About Us Page';

    public function mount(int|string|null $record = null): void
    {
        $this->record = AboutPage::instance();
        $this->authorizeAccess();
        $this->fillForm();
        $this->previousUrl = url()->previous();
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        return $this->fillGalleryMediaField($data, 'gallery_upload', 'gallery');
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        unset($data['gallery_upload']);

        return $data;
    }

    protected function afterSave(): void
    {
        $this->syncGalleryUpload('gallery_upload', 'gallery', 3);
        Cache::forget('about_page');
    }

    protected function getRedirectUrl(): ?string
    {
        return null;
    }
}
