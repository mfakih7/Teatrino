<?php

namespace App\Filament\Resources\Articles\Pages;

use App\Filament\Concerns\SyncsUploadedMedia;
use App\Filament\Resources\Articles\ArticleResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditArticle extends EditRecord
{
    use SyncsUploadedMedia;

    protected static string $resource = ArticleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        return $this->fillSingleMediaField($data, 'image_upload', 'article');
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        return $this->stashSingleMediaUpload($data, 'image_upload');
    }

    protected function afterSave(): void
    {
        $this->syncSingleMediaUpload('image_upload', 'article');
    }
}
