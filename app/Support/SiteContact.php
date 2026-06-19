<?php

namespace App\Support;

use App\Models\SiteSetting;

class SiteContact
{
    public static function whatsappUrl(?SiteSetting $settings = null, ?string $message = null): ?string
    {
        $settings ??= SiteSetting::cached();
        $number = $settings->whatsapp_number ?: config('site.whatsapp_number');

        if (! filled($number)) {
            return null;
        }

        $text = $message ?? $settings->whatsapp_message ?? config('site.whatsapp_message', '');

        return 'https://wa.me/'.preg_replace('/\D+/', '', $number).'?text='.urlencode($text);
    }

    /**
     * @return list<array{key: string, icon: string, label: string, hover: string}>
     */
    public static function activeSocials(?SiteSetting $settings = null): array
    {
        $settings ??= SiteSetting::cached();

        $platforms = [
            ['key' => 'social_facebook', 'icon' => 'facebook', 'label' => 'Facebook', 'hover' => 'hover:border-teatrino-soft-blue hover:bg-teatrino-soft-blue/20 hover:text-teatrino-soft-blue'],
            ['key' => 'social_instagram', 'icon' => 'instagram', 'label' => 'Instagram', 'hover' => 'hover:border-teatrino-coral hover:bg-teatrino-coral/20 hover:text-teatrino-coral'],
            ['key' => 'social_tiktok', 'icon' => 'tiktok', 'label' => 'TikTok', 'hover' => 'hover:border-teatrino-teal hover:bg-teatrino-teal/20 hover:text-teatrino-teal'],
            ['key' => 'social_youtube', 'icon' => 'youtube', 'label' => 'YouTube', 'hover' => 'hover:border-teatrino-yellow hover:bg-teatrino-yellow/20 hover:text-teatrino-yellow'],
        ];

        return array_values(array_filter(
            $platforms,
            fn (array $platform) => filled($settings->{$platform['key']})
        ));
    }
}
