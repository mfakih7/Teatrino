<?php

namespace App\Models;

use App\Concerns\HasLocalizedFields;
use App\Concerns\HasSingletonRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class SiteSetting extends Model
{
    use HasLocalizedFields;
    use HasSingletonRecord;

    protected $fillable = [
        'website_name_en',
        'website_name_ar',
        'website_name_fr',
        'email',
        'logo_path',
        'favicon_path',
        'whatsapp_number',
        'whatsapp_message',
        'social_facebook',
        'social_instagram',
        'social_tiktok',
        'social_youtube',
        'footer_text_en',
        'footer_text_ar',
        'footer_text_fr',
        'contact_title_en',
        'contact_title_ar',
        'contact_title_fr',
        'contact_description_en',
        'contact_description_ar',
        'contact_description_fr',
    ];

    protected static function booted(): void
    {
        static::saved(fn () => Cache::forget('site_settings'));
    }

    public static function cached(): self
    {
        return Cache::rememberForever('site_settings', fn () => static::instance());
    }

    public function logoUrl(): ?string
    {
        if (! $this->logo_path) {
            return null;
        }

        return Storage::disk('public')->url($this->logo_path);
    }

    public function faviconUrl(): string
    {
        if ($this->favicon_path) {
            return Storage::disk('public')->url($this->favicon_path);
        }

        return asset('favicon.svg');
    }

    /**
     * @return array<int, array{label: string, url: string}>
     */
    public function socialLinks(): array
    {
        $links = [
            ['key' => 'social_facebook', 'label' => 'Facebook'],
            ['key' => 'social_instagram', 'label' => 'Instagram'],
            ['key' => 'social_tiktok', 'label' => 'TikTok'],
            ['key' => 'social_youtube', 'label' => 'YouTube'],
        ];

        return collect($links)
            ->filter(fn (array $link) => filled($this->{$link['key']}))
            ->map(fn (array $link) => [
                'label' => $link['label'],
                'url' => (string) $this->{$link['key']},
            ])
            ->values()
            ->all();
    }
}
