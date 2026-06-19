<?php

namespace App\Support\Reports;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class PdfInlineImage
{
    public static function fromStorage(string $disk, ?string $path): ?string
    {
        if (! filled($path) || ! Storage::disk($disk)->exists($path)) {
            return null;
        }

        $contents = Storage::disk($disk)->get($path);
        $mime = Storage::disk($disk)->mimeType($path) ?: self::guessMimeType($path);

        return self::encode($contents, $mime);
    }

    public static function fromPath(?string $absolutePath): ?string
    {
        if (! filled($absolutePath) || ! File::exists($absolutePath)) {
            return null;
        }

        return self::encode(File::get($absolutePath), File::mimeType($absolutePath) ?: self::guessMimeType($absolutePath));
    }

    private static function encode(string $contents, string $mime): string
    {
        return 'data:'.$mime.';base64,'.base64_encode($contents);
    }

    private static function guessMimeType(string $path): string
    {
        return match (strtolower(pathinfo($path, PATHINFO_EXTENSION))) {
            'png' => 'image/png',
            'gif' => 'image/gif',
            'webp' => 'image/webp',
            'svg' => 'image/svg+xml',
            default => 'image/jpeg',
        };
    }
}
