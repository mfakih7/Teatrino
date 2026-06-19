<?php

namespace App\Concerns;

use App\Support\Media\InlineImageService;
use Illuminate\Support\Facades\Storage;

trait HasProfilePhotoPaths
{
    public function profilePhotoUrl(string $variant = 'thumbnail'): ?string
    {
        $column = match ($variant) {
            'original' => 'profile_photo_original_path',
            'optimized' => 'profile_photo_optimized_path',
            default => 'profile_photo_thumbnail_path',
        };

        $path = $this->{$column} ?? $this->profile_photo_optimized_path ?? $this->profile_photo_original_path;

        if (! $path) {
            return null;
        }

        return Storage::disk(config('media.disk'))->url($path);
    }

    public function deleteProfilePhoto(): void
    {
        app(InlineImageService::class)->deletePaths($this, 'profile_photo');

        $this->forceFill([
            'profile_photo_original_path' => null,
            'profile_photo_thumbnail_path' => null,
            'profile_photo_optimized_path' => null,
        ])->save();
    }
}
