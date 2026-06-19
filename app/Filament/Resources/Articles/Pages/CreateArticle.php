<?php

namespace App\Filament\Resources\Articles\Pages;

use App\Filament\Concerns\SyncsUploadedMedia;
use App\Filament\Resources\Articles\ArticleResource;
use Filament\Resources\Pages\CreateRecord;

class CreateArticle extends CreateRecord
{
    use SyncsUploadedMedia;

    protected static string $resource = ArticleResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        return $this->stashSingleMediaUpload($data, 'image_upload');
    }

    protected function afterCreate(): void
    {
        $this->syncSingleMediaUpload('image_upload', 'article');
    }
}
