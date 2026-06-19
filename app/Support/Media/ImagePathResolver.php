<?php

namespace App\Support\Media;

use App\Models\Media;

class ImagePathResolver
{
    public function url(Media $media, string $variant = 'optimized'): ?string
    {
        $imageVariant = ImageVariant::tryFrom($variant) ?? ImageVariant::Optimized;
        $path = $media->{$imageVariant->pathColumn()};

        if (! $path && $imageVariant !== ImageVariant::Original) {
            $path = $media->original_path;
        }

        if (! $path) {
            return null;
        }

        return $this->publicUrl($path);
    }

    private function publicUrl(string $path): string
    {
        $path = ltrim(str_replace('\\', '/', $path), '/');
        $basePath = rtrim(parse_url((string) config('app.url'), PHP_URL_PATH) ?: '', '/');

        return ($basePath !== '' ? $basePath.'/' : '/').'storage/'.$path;
    }

    /**
     * @return array{src: ?string, srcset: array<string, string>, webp: ?string}
     */
    public function responsiveSources(Media $media): array
    {
        return [
            'src' => $this->url($media, 'optimized'),
            'srcset' => array_filter([
                'thumbnail' => $this->url($media, 'thumbnail'),
                'optimized' => $this->url($media, 'optimized'),
                'original' => $this->url($media, 'original'),
            ]),
            'webp' => config('media.generate_webp') ? $this->url($media, 'webp') : null,
        ];
    }
}
