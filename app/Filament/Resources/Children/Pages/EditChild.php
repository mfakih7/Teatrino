<?php

namespace App\Filament\Resources\Children\Pages;

use App\Filament\Concerns\SyncsChildProfilePhoto;
use App\Filament\Resources\Children\ChildResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditChild extends EditRecord
{
    use SyncsChildProfilePhoto;

    protected static string $resource = ChildResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        return $this->fillChildProfilePhotoField($data);
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        unset($data['profile_photo_upload']);

        return $data;
    }

    protected function afterSave(): void
    {
        $this->syncChildProfilePhoto();
    }
}
