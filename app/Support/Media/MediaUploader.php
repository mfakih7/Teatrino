<?php

namespace App\Support\Media;

use App\Models\Media;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MediaUploader
{
    public function __construct(
        private readonly ImageProcessor $processor,
    ) {}

    public function uploadFromFile(UploadedFile $file, Model $model, string $collection, ?string $altText = null, int $sortOrder = 0): Media
    {
        $tempPath = $file->getRealPath() ?: $file->path();

        return $this->uploadFromPath($tempPath, $model, $collection, $altText, $sortOrder);
    }

    public function uploadFromPath(string $absolutePath, Model $model, string $collection, ?string $altText = null, int $sortOrder = 0, bool $replaceCollection = true): Media
    {
        $directory = trim(config('media.base_path'), '/').'/'.Str::slug(class_basename($model)).'/'.$model->getKey();
        $processed = $this->processor->process($absolutePath, $directory);

        if ($replaceCollection) {
            $this->deleteCollection($model, $collection);
        }

        return $model->media()->create([
            'collection' => $collection,
            'original_path' => $processed['original_path'],
            'optimized_path' => $processed['optimized_path'],
            'thumbnail_path' => $processed['thumbnail_path'],
            'webp_path' => $processed['webp_path'],
            'alt_text' => $altText,
            'width' => $processed['width'],
            'height' => $processed['height'],
            'size_bytes' => $processed['size_bytes'],
            'mime_type' => $processed['mime_type'],
            'sort_order' => $sortOrder,
        ]);
    }

    public function uploadFromStoragePath(string $relativePath, Model $model, string $collection, ?string $altText = null, int $sortOrder = 0, bool $replaceCollection = true): Media
    {
        $disk = Storage::disk(config('media.disk'));
        $absolutePath = $disk->path($relativePath);

        return $this->uploadFromPath($absolutePath, $model, $collection, $altText, $sortOrder, $replaceCollection);
    }

    public function deleteCollection(Model $model, string $collection): void
    {
        $model->mediaInCollection($collection)->get()->each(fn (Media $media) => $this->deleteMedia($media));
    }

    public function deleteMedia(Media $media): void
    {
        $disk = Storage::disk(config('media.disk'));

        foreach (['original_path', 'optimized_path', 'thumbnail_path', 'webp_path'] as $column) {
            if ($media->{$column} && $disk->exists($media->{$column})) {
                $disk->delete($media->{$column});
            }
        }

        $media->delete();
    }
}
