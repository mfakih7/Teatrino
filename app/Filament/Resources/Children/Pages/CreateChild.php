<?php

namespace App\Filament\Resources\Children\Pages;

use App\Filament\Concerns\SyncsChildProfilePhoto;
use App\Filament\Resources\Children\ChildResource;
use Filament\Resources\Pages\CreateRecord;

class CreateChild extends CreateRecord
{
    use SyncsChildProfilePhoto;

    protected static string $resource = ChildResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        unset($data['profile_photo_upload']);

        return $data;
    }

    protected function afterCreate(): void
    {
        $this->syncChildProfilePhoto();
    }
}
