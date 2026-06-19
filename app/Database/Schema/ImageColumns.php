<?php

namespace App\Database\Schema;

use Illuminate\Database\Schema\Blueprint;

/**
 * Reusable image path columns for future content tables.
 */
class ImageColumns
{
    public static function add(Blueprint $table, string $prefix = 'image'): void
    {
        $table->string("{$prefix}_original_path")->nullable();
        $table->string("{$prefix}_optimized_path")->nullable();
        $table->string("{$prefix}_thumbnail_path")->nullable();
        $table->string("{$prefix}_webp_path")->nullable();
    }

    public static function drop(Blueprint $table, string $prefix = 'image'): void
    {
        $table->dropColumn([
            "{$prefix}_original_path",
            "{$prefix}_optimized_path",
            "{$prefix}_thumbnail_path",
            "{$prefix}_webp_path",
        ]);
    }
}
