<?php

namespace App\Models;

use App\Concerns\HasLocalizedFields;
use App\Concerns\HasMedia;
use App\Concerns\HasSingletonRecord;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class AboutPage extends Model
{
    use HasLocalizedFields;
    use HasMedia;
    use HasSingletonRecord;

    protected $fillable = [
        'title_en',
        'title_ar',
        'title_fr',
        'body_en',
        'body_ar',
        'body_fr',
        'mission_en',
        'mission_ar',
        'mission_fr',
        'vision_en',
        'vision_ar',
        'vision_fr',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    protected static function booted(): void
    {
        static::saved(fn () => Cache::forget('about_page'));
    }

    public static function cached(): ?self
    {
        return Cache::rememberForever('about_page', function () {
            return static::query()
                ->with(['media' => fn ($query) => $query->where('collection', 'gallery')->orderBy('sort_order')])
                ->first();
        });
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public function galleryMedia()
    {
        return $this->mediaInCollection('gallery')->orderBy('sort_order');
    }
}
