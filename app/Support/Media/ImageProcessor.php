<?php

namespace App\Support\Media;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use RuntimeException;

class ImageProcessor
{
    /**
     * @return array{
     *     original_path: string,
     *     optimized_path: string,
     *     thumbnail_path: string,
     *     webp_path: ?string,
     *     width: int,
     *     height: int,
     *     size_bytes: int,
     *     mime_type: string
     * }
     */
    public function process(string $sourceAbsolutePath, string $directory): array
    {
        if (! extension_loaded('gd')) {
            throw new RuntimeException('GD extension is required for image processing.');
        }

        $image = $this->createImage($sourceAbsolutePath);
        $width = imagesx($image);
        $height = imagesy($image);
        $disk = Storage::disk(config('media.disk'));
        $baseName = (string) Str::uuid();
        $extension = strtolower(pathinfo($sourceAbsolutePath, PATHINFO_EXTENSION)) ?: 'jpg';

        $originalRelative = "{$directory}/{$baseName}-original.{$extension}";
        $optimizedRelative = "{$directory}/{$baseName}-optimized.{$extension}";
        $thumbnailRelative = "{$directory}/{$baseName}-thumbnail.{$extension}";
        $webpRelative = config('media.generate_webp') ? "{$directory}/{$baseName}-optimized.webp" : null;

        $disk->put($originalRelative, file_get_contents($sourceAbsolutePath));

        $optimized = $this->resize($image, config('media.variants.optimized.max_width'), null);
        $this->saveImage($optimized, $disk->path($optimizedRelative), $extension, config('media.variants.optimized.quality'));

        $thumbnail = $this->fitCover($image, config('media.variants.thumbnail.max_width'), config('media.variants.thumbnail.max_height'));
        $this->saveImage($thumbnail, $disk->path($thumbnailRelative), $extension, config('media.variants.thumbnail.quality'));

        if ($webpRelative && function_exists('imagewebp')) {
            $webpImage = $this->resize($image, config('media.variants.optimized.max_width'), null);
            imagewebp($webpImage, $disk->path($webpRelative), config('media.variants.webp.quality'));
            imagedestroy($webpImage);
        }

        imagedestroy($image);
        imagedestroy($optimized);
        imagedestroy($thumbnail);

        return [
            'original_path' => $originalRelative,
            'optimized_path' => $optimizedRelative,
            'thumbnail_path' => $thumbnailRelative,
            'webp_path' => $webpRelative,
            'width' => $width,
            'height' => $height,
            'size_bytes' => $disk->size($originalRelative),
            'mime_type' => $disk->mimeType($originalRelative) ?: 'image/jpeg',
        ];
    }

    /**
     * @return \GdImage
     */
    private function createImage(string $path): \GdImage
    {
        $mime = mime_content_type($path) ?: '';

        $image = match ($mime) {
            'image/jpeg', 'image/jpg' => @imagecreatefromjpeg($path),
            'image/png' => @imagecreatefrompng($path),
            'image/webp' => function_exists('imagecreatefromwebp') ? @imagecreatefromwebp($path) : false,
            'image/gif' => @imagecreatefromgif($path),
            default => false,
        };

        if ($image === false) {
            throw new RuntimeException("Unable to read image at {$path}.");
        }

        return $image;
    }

    /**
     * @return \GdImage
     */
    private function resize(\GdImage $source, int $maxWidth, ?int $maxHeight): \GdImage
    {
        $width = imagesx($source);
        $height = imagesy($source);
        $ratio = min($maxWidth / $width, ($maxHeight ?? $maxWidth) / $height, 1);
        $newWidth = max(1, (int) round($width * $ratio));
        $newHeight = max(1, (int) round($height * $ratio));

        $canvas = imagecreatetruecolor($newWidth, $newHeight);
        $this->preserveTransparency($canvas, $source);
        imagecopyresampled($canvas, $source, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);

        return $canvas;
    }

    /**
     * @return \GdImage
     */
    private function fitCover(\GdImage $source, int $targetWidth, int $targetHeight): \GdImage
    {
        $width = imagesx($source);
        $height = imagesy($source);
        $ratio = max($targetWidth / $width, $targetHeight / $height);
        $resizedWidth = (int) round($width * $ratio);
        $resizedHeight = (int) round($height * $ratio);

        $resized = imagecreatetruecolor($resizedWidth, $resizedHeight);
        $this->preserveTransparency($resized, $source);
        imagecopyresampled($resized, $source, 0, 0, 0, 0, $resizedWidth, $resizedHeight, $width, $height);

        $canvas = imagecreatetruecolor($targetWidth, $targetHeight);
        $this->preserveTransparency($canvas, $source);
        $offsetX = (int) max(0, ($resizedWidth - $targetWidth) / 2);
        $offsetY = (int) max(0, ($resizedHeight - $targetHeight) / 2);
        imagecopy($canvas, $resized, 0, 0, $offsetX, $offsetY, $targetWidth, $targetHeight);
        imagedestroy($resized);

        return $canvas;
    }

    private function preserveTransparency(\GdImage $canvas, \GdImage $source): void
    {
        imagealphablending($canvas, false);
        imagesavealpha($canvas, true);
        $transparent = imagecolorallocatealpha($canvas, 0, 0, 0, 127);
        imagefilledrectangle($canvas, 0, 0, imagesx($canvas), imagesy($canvas), $transparent);
        imagealphablending($canvas, true);
        imagesavealpha($source, true);
    }

    private function saveImage(\GdImage $image, string $path, string $extension, int $quality): void
    {
        match ($extension) {
            'png' => imagepng($image, $path, 6),
            'webp' => imagewebp($image, $path, $quality),
            'gif' => imagegif($image, $path),
            default => imagejpeg($image, $path, $quality),
        };
    }
}
