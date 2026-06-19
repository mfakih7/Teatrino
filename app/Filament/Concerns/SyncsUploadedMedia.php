<?php

namespace App\Filament\Concerns;

use App\Support\Media\MediaUploader;

trait SyncsUploadedMedia
{
    protected ?string $pendingSingleMediaUpload = null;

    protected function stashSingleMediaUpload(array $data, string $field): array
    {
        $this->pendingSingleMediaUpload = $this->extractUploadPath($data[$field] ?? null);
        unset($data[$field]);

        return $data;
    }

    protected function syncSingleMediaUpload(string $field, string $collection, ?string $altText = null): void
    {
        $path = $this->pendingSingleMediaUpload
            ?? $this->extractUploadPath($this->form->getState()[$field] ?? null);

        $this->pendingSingleMediaUpload = null;

        if (! $path) {
            return;
        }

        if ($this->record->primaryMedia($collection)?->original_path === $path) {
            return;
        }

        app(MediaUploader::class)->uploadFromStoragePath($path, $this->record, $collection, $altText);
    }

    /**
     * @param  list<string>  $paths
     */
    protected function syncGalleryUpload(string $field, string $collection, int $maxItems = 3): void
    {
        $paths = collect($this->form->getState()[$field] ?? [])
            ->map(fn ($value) => $this->extractUploadPath($value))
            ->filter()
            ->values()
            ->take($maxItems);

        if ($paths->isEmpty()) {
            return;
        }

        $uploader = app(MediaUploader::class);
        $existing = $this->record->mediaInCollection($collection)->get()->keyBy('original_path');

        $paths->each(function (string $path, int $index) use ($uploader, $collection, $existing) {
            if ($existing->has($path)) {
                $existing->get($path)->update(['sort_order' => $index]);

                return;
            }

            $uploader->uploadFromStoragePath($path, $this->record, $collection, null, $index, false);
        });

        $this->record
            ->mediaInCollection($collection)
            ->whereNotIn('original_path', $paths->all())
            ->get()
            ->each(fn ($media) => $uploader->deleteMedia($media));
    }

    protected function extractUploadPath(mixed $value): ?string
    {
        if (is_array($value)) {
            $value = $value[array_key_first($value)] ?? null;
        }

        return filled($value) ? (string) $value : null;
    }

    protected function fillSingleMediaField(array $data, string $field, string $collection): array
    {
        $data[$field] = $this->record->primaryMedia($collection)?->original_path;

        return $data;
    }

    protected function fillGalleryMediaField(array $data, string $field, string $collection): array
    {
        $data[$field] = $this->record
            ->mediaInCollection($collection)
            ->orderBy('sort_order')
            ->pluck('original_path')
            ->all();

        return $data;
    }
}
