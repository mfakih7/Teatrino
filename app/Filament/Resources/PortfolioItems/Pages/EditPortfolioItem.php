<?php

namespace App\Filament\Resources\PortfolioItems\Pages;

use App\Filament\Concerns\SyncsUploadedMedia;
use App\Filament\Resources\PortfolioItems\PortfolioItemResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditPortfolioItem extends EditRecord
{
    use SyncsUploadedMedia;

    protected static string $resource = PortfolioItemResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        return $this->fillSingleMediaField($data, 'image_upload', 'portfolio');
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        return $this->stashSingleMediaUpload($data, 'image_upload');
    }

    protected function afterSave(): void
    {
        $this->syncSingleMediaUpload('image_upload', 'portfolio');
    }
}
