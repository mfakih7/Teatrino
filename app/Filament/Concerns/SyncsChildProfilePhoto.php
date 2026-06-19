<?php

namespace App\Filament\Concerns;

use App\Support\Media\InlineImageService;

trait SyncsChildProfilePhoto
{
    protected function syncChildProfilePhoto(string $field = 'profile_photo_upload'): void
    {
        $path = $this->extractUploadPath($this->form->getState()[$field] ?? null);

        if (! $path) {
            return;
        }

        if ($this->record->profile_photo_original_path === $path) {
            return;
        }

        app(InlineImageService::class)->syncFromStoragePath(
            $this->record,
            'profile_photo',
            $path,
            trim(config('media.base_path'), '/').'/children/'.$this->record->getKey()
        );

        $this->record->refresh();
    }

    protected function fillChildProfilePhotoField(array $data, string $field = 'profile_photo_upload'): array
    {
        $data[$field] = $this->record->profile_photo_original_path;

        return $data;
    }

    protected function extractUploadPath(mixed $value): ?string
    {
        if (is_array($value)) {
            $value = $value[array_key_first($value)] ?? null;
        }

        return filled($value) ? (string) $value : null;
    }
}
