<?php

namespace App\Filament\Resources\HomeContents\Pages;

use App\Filament\Concerns\SyncsUploadedMedia;
use App\Filament\Resources\HomeContents\HomeContentResource;
use App\Models\HomeContent;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Cache;

class ManageHomeContent extends EditRecord
{
    use SyncsUploadedMedia;

    protected static string $resource = HomeContentResource::class;

    protected static ?string $title = 'Home Page Content';

    public function mount(int|string|null $record = null): void
    {
        $this->record = HomeContent::instance();
        $this->authorizeAccess();
        $this->fillForm();
        $this->previousUrl = url()->previous();
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        return $this->fillSingleMediaField($data, 'hero_image_upload', 'hero');
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        return $this->stashSingleMediaUpload($data, 'hero_image_upload');
    }

    protected function afterSave(): void
    {
        $this->syncSingleMediaUpload('hero_image_upload', 'hero');
        Cache::forget('home_content');
    }

    protected function getRedirectUrl(): ?string
    {
        return null;
    }
}
