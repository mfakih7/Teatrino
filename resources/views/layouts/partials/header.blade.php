<header class="sticky top-0 z-50 border-b border-teatrino-yellow/30 bg-white/90 backdrop-blur-md">
    <div class="mx-auto flex max-w-6xl items-center justify-between gap-4 px-4 py-4 sm:px-6">
        <a href="{{ route('home', ['locale' => $currentLocale]) }}" class="flex items-center gap-3">
            @if ($siteSettings->logoUrl())
                <img
                    src="{{ $siteSettings->logoUrl() }}"
                    alt="{{ $siteSettings->t('website_name') ?? 'Teatrino' }}"
                    class="h-10 w-auto max-w-[10rem] object-contain"
                >
            @else
                @include('components.logo')
            @endif
            <span class="text-xl font-bold tracking-tight text-teatrino-charcoal">{{ $siteSettings->t('website_name') ?? 'Teatrino' }}</span>
        </a>

        <nav class="hidden items-center gap-1 md:flex" aria-label="{{ __('site.nav.home') }}">
            @foreach ([
                'home' => route('home', ['locale' => $currentLocale]),
                'about' => route('about', ['locale' => $currentLocale]),
                'portfolio' => route('portfolio', ['locale' => $currentLocale]),
                'articles' => route('articles', ['locale' => $currentLocale]),
                'contact' => route('contact', ['locale' => $currentLocale]),
            ] as $key => $url)
                <a
                    href="{{ $url }}"
                    @class([
                        'rounded-full px-4 py-2 text-sm font-semibold transition',
                        'bg-teatrino-teal text-white' => request()->routeIs($key),
                        'text-teatrino-charcoal hover:bg-teatrino-yellow/40' => ! request()->routeIs($key),
                    ])
                >
                    {{ __('site.nav.' . $key) }}
                </a>
            @endforeach
        </nav>

        <div class="flex items-center gap-3">
            @include('components.language-switcher')

            <button
                type="button"
                class="inline-flex rounded-lg border border-teatrino-charcoal/10 p-2 md:hidden"
                aria-label="Menu"
                onclick="document.getElementById('mobile-nav').classList.toggle('hidden')"
            >
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>
        </div>
    </div>

    <nav id="mobile-nav" class="hidden border-t border-teatrino-yellow/20 bg-white px-4 py-4 md:hidden">
        <div class="flex flex-col gap-1">
            @foreach (['home', 'about', 'portfolio', 'articles', 'contact'] as $key)
                <a
                    href="{{ route($key, ['locale' => $currentLocale]) }}"
                    @class([
                        'rounded-xl px-4 py-3 text-sm font-semibold transition',
                        'bg-teatrino-teal/10 text-teatrino-teal' => request()->routeIs($key),
                        'text-teatrino-charcoal hover:bg-teatrino-yellow/30' => ! request()->routeIs($key),
                    ])
                >
                    {{ __('site.nav.' . $key) }}
                </a>
            @endforeach
        </div>
    </nav>
</header>
