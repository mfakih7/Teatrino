<?php

namespace App\Filament\Resources\Teachers\Pages;

use App\Filament\Concerns\SyncsUploadedMedia;
use App\Filament\Resources\Teachers\TeacherResource;
use Filament\Resources\Pages\CreateRecord;

class CreateTeacher extends CreateRecord
{
    use SyncsUploadedMedia;

    protected static string $resource = TeacherResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        return $this->stashSingleMediaUpload($data, 'image_upload');
    }

    protected function afterCreate(): void
    {
        $this->syncSingleMediaUpload('image_upload', 'teacher');
    }
}
