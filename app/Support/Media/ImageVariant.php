<?php

namespace App\Support\Media;

enum ImageVariant: string
{
    case Original = 'original';
    case Optimized = 'optimized';
    case Thumbnail = 'thumbnail';
    case Webp = 'webp';

    public function pathColumn(): string
    {
        return match ($this) {
            self::Original => 'original_path',
            self::Optimized => 'optimized_path',
            self::Thumbnail => 'thumbnail_path',
            self::Webp => 'webp_path',
        };
    }
}
