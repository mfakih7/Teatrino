<?php

namespace App\Providers;

use App\Database\Schema\ImageColumns;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Blueprint::macro('imagePaths', function (string $prefix = 'image') {
            /** @var Blueprint $this */
            ImageColumns::add($this, $prefix);
        });

        if ($this->app->environment('local')) {
            URL::forceScheme('http');
        }

        if ($appUrl = config('app.url')) {
            URL::forceRootUrl($appUrl);
        }
    }
}
