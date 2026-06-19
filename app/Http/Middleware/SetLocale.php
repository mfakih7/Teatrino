<?php

namespace App\Http\Middleware;

use App\Models\SiteSetting;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    public function handle(Request $request, Closure $next): Response
    {
        $locale = $request->route('locale')
            ?? Session::get('locale')
            ?? config('locales.default');

        if (! array_key_exists($locale, config('locales.supported'))) {
            abort(404);
        }

        App::setLocale($locale);
        Session::put('locale', $locale);

        View::share([
            'currentLocale' => $locale,
            'localeMeta' => config("locales.supported.{$locale}"),
            'supportedLocales' => config('locales.supported'),
            'siteSettings' => SiteSetting::cached(),
        ]);

        return $next($request);
    }
}
