<?php

namespace App\Filament\Resources\PortfolioItems\Pages;

use App\Filament\Concerns\SyncsUploadedMedia;
use App\Filament\Resources\PortfolioItems\PortfolioItemResource;
use Filament\Resources\Pages\CreateRecord;

class CreatePortfolioItem extends CreateRecord
{
    use SyncsUploadedMedia;

    protected static string $resource = PortfolioItemResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        return $this->stashSingleMediaUpload($data, 'image_upload');
    }

    protected function afterCreate(): void
    {
        $this->syncSingleMediaUpload('image_upload', 'portfolio');
    }
}
