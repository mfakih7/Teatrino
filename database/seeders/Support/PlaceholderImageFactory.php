<?php

namespace Database\Seeders\Support;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PlaceholderImageFactory
{
    public static function create(string $label, string $hexColor = '#FFD166'): string
    {
        $disk = Storage::disk(config('media.disk'));
        $relativePath = trim(config('media.base_path'), '/').'/seed/'.Str::slug($label).'-'.Str::random(6).'.jpg';
        $absolutePath = $disk->path($relativePath);

        if (! is_dir(dirname($absolutePath))) {
            mkdir(dirname($absolutePath), 0755, true);
        }

        $image = imagecreatetruecolor(1200, 800);
        [$r, $g, $b] = sscanf($hexColor, '#%02x%02x%02x');
        $background = imagecolorallocate($image, $r, $g, $b);
        imagefilledrectangle($image, 0, 0, 1200, 800, $background);
        $textColor = imagecolorallocate($image, 45, 52, 54);
        imagestring($image, 5, 40, 380, $label, $textColor);
        imagejpeg($image, $absolutePath, 90);
        imagedestroy($image);

        return $relativePath;
    }
}
