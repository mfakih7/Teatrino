<header class="sticky top-0 z-50 border-b border-teatrino-yellow/25 bg-white/90 shadow-sm backdrop-blur-md">
    <div class="teatrino-container flex items-center justify-between gap-3 py-3 sm:gap-4 sm:py-4">
        <a href="{{ route('home', ['locale' => $currentLocale]) }}" class="group flex min-w-0 items-center gap-3">
            @if ($siteSettings->logoUrl())
                <img
                    src="{{ $siteSettings->logoUrl() }}"
                    alt="{{ $siteSettings->t('website_name') ?: 'Teatrino' }}"
                    class="h-11 w-auto max-w-[11rem] object-contain transition group-hover:opacity-90 sm:h-12"
                >
            @else
                <div class="shrink-0 scale-110 sm:scale-125">
                    @include('components.logo')
                </div>
            @endif
            <span class="truncate text-lg font-bold tracking-tight text-teatrino-charcoal sm:text-xl">{{ $siteSettings->t('website_name') ?: 'Teatrino' }}</span>
        </a>

        <nav class="hidden items-center gap-1 lg:flex" aria-label="{{ __('site.nav.home') }}">
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
                        'bg-teatrino-teal text-white shadow-sm shadow-teatrino-teal/20' => request()->routeIs($key),
                        'text-teatrino-charcoal hover:bg-teatrino-yellow/40' => ! request()->routeIs($key),
                    ])
                >
                    {{ __('site.nav.' . $key) }}
                </a>
            @endforeach
        </nav>

        <div class="flex shrink-0 items-center gap-2 sm:gap-3">
            @include('components.language-switcher')

            <button
                id="mobile-nav-toggle"
                type="button"
                class="inline-flex rounded-xl border border-teatrino-charcoal/10 bg-white p-2.5 text-teatrino-charcoal shadow-sm transition hover:bg-teatrino-yellow/20 focus:outline-none focus-visible:ring-2 focus-visible:ring-teatrino-teal lg:hidden"
                aria-label="{{ __('site.nav.menu') }}"
                aria-expanded="false"
                aria-controls="mobile-nav"
            >
                <svg id="mobile-nav-icon-open" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
                <svg id="mobile-nav-icon-close" class="hidden h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
    </div>

    <nav id="mobile-nav" class="nav-mobile-panel hidden px-4 py-4 lg:hidden" aria-label="{{ __('site.nav.menu') }}">
        <div class="flex flex-col gap-1">
            @foreach (['home', 'about', 'portfolio', 'articles', 'contact'] as $key)
                <a
                    href="{{ route($key, ['locale' => $currentLocale]) }}"
                    @class([
                        'rounded-xl px-4 py-3.5 text-sm font-semibold transition',
                        'bg-teatrino-teal/10 text-teatrino-teal ring-1 ring-teatrino-teal/20' => request()->routeIs($key),
                        'text-teatrino-charcoal hover:bg-teatrino-yellow/30' => ! request()->routeIs($key),
                    ])
                >
                    {{ __('site.nav.' . $key) }}
                </a>
            @endforeach
        </div>
    </nav>
</header>
