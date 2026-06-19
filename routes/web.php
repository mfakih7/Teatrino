<?php

use App\Http\Controllers\LocaleController;
use App\Http\Controllers\PageController;
use App\Http\Middleware\SetLocale;
use Illuminate\Support\Facades\Route;

Route::get('/locale/{locale}', [LocaleController::class, 'switch'])->name('locale.switch');

$supportedLocales = implode('|', array_keys(config('locales.supported')));

Route::middleware(SetLocale::class)->group(function () use ($supportedLocales) {
    Route::prefix('{locale}')
        ->where(['locale' => $supportedLocales])
        ->group(function () {
            Route::get('/', [PageController::class, 'home'])->name('home');
            Route::get('/about', [PageController::class, 'about'])->name('about');
            Route::get('/portfolio', [PageController::class, 'portfolio'])->name('portfolio');
            Route::get('/articles', [PageController::class, 'articles'])->name('articles');
            Route::get('/contact', [PageController::class, 'contact'])->name('contact');
        });

    Route::get('/', function () {
        $locale = session('locale', config('locales.default'));

        return redirect()->route('home', ['locale' => $locale]);
    });
});
