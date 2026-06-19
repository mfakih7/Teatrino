<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', $currentLocale) }}" dir="{{ $localeMeta['dir'] }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', $siteSettings->t('website_name') ?? config('app.name'))</title>

    <link rel="icon" href="{{ $siteSettings->faviconUrl() }}" type="image/svg+xml">

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=nunito:400,500,600,700|cairo:400,500,600,700" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="flex min-h-screen flex-col bg-teatrino-cream text-teatrino-charcoal antialiased">
    @include('layouts.partials.header')

    <main class="flex-1">
        @yield('content')
    </main>

    @include('layouts.partials.footer')
</body>
</html>
