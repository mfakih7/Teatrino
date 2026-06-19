<?php

namespace App\Models;

use App\Concerns\HasLocalizedFields;
use App\Concerns\HasMedia;
use App\Support\Media\MediaUploader;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class PortfolioItem extends Model
{
    use HasLocalizedFields;
    use HasMedia;

    protected $fillable = [
        'title_en',
        'title_ar',
        'title_fr',
        'description_en',
        'description_ar',
        'description_fr',
        'sort_order',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'sort_order' => 'integer',
        ];
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy('sort_order')->orderByDesc('id');
    }

    public function image(): ?Media
    {
        return $this->primaryMedia('portfolio');
    }

    protected static function booted(): void
    {
        static::deleting(function (self $item): void {
            $uploader = app(MediaUploader::class);
            $item->media->each(fn (Media $media) => $uploader->deleteMedia($media));
        });
    }
}
