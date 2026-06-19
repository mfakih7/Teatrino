<?php

namespace App\Concerns;

trait HasSingletonRecord
{
    public static function instance(): static
    {
        return static::query()->firstOrCreate(['id' => 1]);
    }
}
