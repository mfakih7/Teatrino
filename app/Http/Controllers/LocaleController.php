<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

class LocaleController extends Controller
{
    public function switch(Request $request, string $locale): RedirectResponse
    {
        if (! array_key_exists($locale, config('locales.supported'))) {
            abort(404);
        }

        Session::put('locale', $locale);

        $routeName = $request->string('route')->toString();
        $routeParams = $request->input('params', []);

        if (! is_array($routeParams)) {
            $routeParams = [];
        }

        if ($routeName && Route::has($routeName)) {
            $routeParams['locale'] = $locale;

            return redirect()->route($routeName, $routeParams);
        }

        return redirect()->route('home', ['locale' => $locale]);
    }
}
