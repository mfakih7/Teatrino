<?php

namespace App\Models;

use App\Concerns\HasLocalizedFields;
use App\Concerns\HasMedia;
use App\Concerns\HasSingletonRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class HomeContent extends Model
{
    use HasLocalizedFields;
    use HasMedia;
    use HasSingletonRecord;

    protected $fillable = [
        'hero_title_en',
        'hero_title_ar',
        'hero_title_fr',
        'hero_subtitle_en',
        'hero_subtitle_ar',
        'hero_subtitle_fr',
        'hero_description_en',
        'hero_description_ar',
        'hero_description_fr',
        'cta_portfolio_en',
        'cta_portfolio_ar',
        'cta_portfolio_fr',
        'cta_whatsapp_en',
        'cta_whatsapp_ar',
        'cta_whatsapp_fr',
        'welcome_heading_en',
        'welcome_heading_ar',
        'welcome_heading_fr',
        'explore_heading_en',
        'explore_heading_ar',
        'explore_heading_fr',
        'explore_text_en',
        'explore_text_ar',
        'explore_text_fr',
    ];

    protected static function booted(): void
    {
        static::saved(fn () => Cache::forget('home_content'));
    }

    public static function cached(): self
    {
        return Cache::rememberForever('home_content', function () {
            return static::query()
                ->with(['media' => fn ($query) => $query->where('collection', 'hero')])
                ->firstOrCreate(['id' => 1]);
        });
    }

    public function heroMedia(): ?Media
    {
        return $this->primaryMedia('hero');
    }
}
