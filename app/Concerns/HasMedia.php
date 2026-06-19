<?php

namespace App\Concerns;

use App\Models\Media;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait HasMedia
{
    public function media(): MorphMany
    {
        return $this->morphMany(Media::class, 'mediable')->orderBy('sort_order');
    }

    public function mediaInCollection(string $collection): MorphMany
    {
        return $this->media()->where('collection', $collection);
    }

    public function primaryMedia(string $collection = 'default'): ?Media
    {
        if ($this->relationLoaded('media')) {
            return $this->media->where('collection', $collection)->first();
        }

        return $this->mediaInCollection($collection)->first();
    }
}
