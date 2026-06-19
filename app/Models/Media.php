<?php

namespace App\Models;

use App\Support\Media\ImagePathResolver;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Media extends Model
{
    protected $fillable = [
        'mediable_type',
        'mediable_id',
        'collection',
        'original_path',
        'optimized_path',
        'thumbnail_path',
        'webp_path',
        'alt_text',
        'width',
        'height',
        'size_bytes',
        'mime_type',
        'sort_order',
        'metadata',
    ];

    protected function casts(): array
    {
        return [
            'metadata' => 'array',
            'width' => 'integer',
            'height' => 'integer',
            'size_bytes' => 'integer',
            'sort_order' => 'integer',
        ];
    }

    public function mediable(): MorphTo
    {
        return $this->morphTo();
    }

    public function url(string $variant = 'optimized'): ?string
    {
        return app(ImagePathResolver::class)->url($this, $variant);
    }

    public function getThumbnailUrlAttribute(): ?string
    {
        return $this->url('thumbnail');
    }

    public function getOptimizedUrlAttribute(): ?string
    {
        return $this->url('optimized');
    }

    public function getOriginalUrlAttribute(): ?string
    {
        return $this->url('original');
    }

    public function getWebpUrlAttribute(): ?string
    {
        return $this->url('webp');
    }
}
