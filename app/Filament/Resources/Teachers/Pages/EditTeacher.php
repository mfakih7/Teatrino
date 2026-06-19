<?php

namespace App\Filament\Resources\Teachers\Pages;

use App\Filament\Concerns\SyncsUploadedMedia;
use App\Filament\Resources\Teachers\TeacherResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditTeacher extends EditRecord
{
    use SyncsUploadedMedia;

    protected static string $resource = TeacherResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        return $this->fillSingleMediaField($data, 'image_upload', 'teacher');
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        return $this->stashSingleMediaUpload($data, 'image_upload');
    }

    protected function afterSave(): void
    {
        $this->syncSingleMediaUpload('image_upload', 'teacher');
    }
}
