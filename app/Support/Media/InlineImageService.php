<?php

namespace App\Support\Media;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class InlineImageService
{
    public function __construct(
        private readonly ImageProcessor $processor,
    ) {}

    public function syncFromStoragePath(Model $model, string $pathPrefix, ?string $relativePath, ?string $directory = null): void
    {
        if (! filled($relativePath)) {
            return;
        }

        $originalColumn = "{$pathPrefix}_original_path";

        if ($model->{$originalColumn} === $relativePath) {
            return;
        }

        $this->deletePaths($model, $pathPrefix);

        $disk = Storage::disk(config('media.disk'));
        $targetDirectory = $directory ?? trim(config('media.base_path'), '/').'/'.Str::slug(class_basename($model)).'/'.$model->getKey();

        $processed = $this->processor->process($disk->path($relativePath), $targetDirectory);

        $model->forceFill([
            "{$pathPrefix}_original_path" => $processed['original_path'],
            "{$pathPrefix}_thumbnail_path" => $processed['thumbnail_path'],
            "{$pathPrefix}_optimized_path" => $processed['optimized_path'],
        ])->save();
    }

    public function deletePaths(Model $model, string $pathPrefix): void
    {
        $disk = Storage::disk(config('media.disk'));

        foreach (['original', 'thumbnail', 'optimized'] as $variant) {
            $column = "{$pathPrefix}_{$variant}_path";
            $path = $model->{$column};

            if ($path && $disk->exists($path)) {
                $disk->delete($path);
            }
        }
    }
}
