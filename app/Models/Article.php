<?php

namespace App\Models;

use App\Concerns\HasLocalizedFields;
use App\Concerns\HasMedia;
use App\Support\Media\MediaUploader;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasLocalizedFields;
    use HasMedia;

    protected $fillable = [
        'title_en',
        'title_ar',
        'title_fr',
        'excerpt_en',
        'excerpt_ar',
        'excerpt_fr',
        'body_en',
        'body_ar',
        'body_fr',
        'published_at',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'published_at' => 'datetime',
        ];
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query
            ->where('is_active', true)
            ->where(function (Builder $builder) {
                $builder
                    ->whereNull('published_at')
                    ->orWhere('published_at', '<=', now());
            });
    }

    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderByDesc('published_at')->orderByDesc('id');
    }

    public function featuredImage(): ?Media
    {
        return $this->primaryMedia('article');
    }

    protected static function booted(): void
    {
        static::deleting(function (self $article): void {
            $uploader = app(MediaUploader::class);
            $article->media->each(fn (Media $media) => $uploader->deleteMedia($media));
        });
    }
}
