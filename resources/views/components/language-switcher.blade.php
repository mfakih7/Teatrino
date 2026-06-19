@php
    $route = request()->route();
    $routeName = $route?->getName();
    $routeParams = $route?->parameters() ?? [];
@endphp

<div class="relative" data-lang-switcher>
    <button
        type="button"
        data-lang-toggle
        class="inline-flex items-center gap-2 rounded-full border border-teatrino-charcoal/10 bg-white px-3 py-2 text-sm font-semibold text-teatrino-charcoal shadow-sm transition hover:bg-teatrino-yellow/20 focus:outline-none focus-visible:ring-2 focus-visible:ring-teatrino-teal"
        aria-haspopup="listbox"
        aria-expanded="false"
    >
        <span aria-hidden="true">{{ $localeMeta['flag'] }}</span>
        <span class="hidden min-[380px]:inline">{{ $localeMeta['native'] }}</span>
        <svg class="h-4 w-4 opacity-60" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
        </svg>
    </button>

    <div
        data-lang-menu
        class="absolute end-0 z-50 mt-2 hidden min-w-[11rem] overflow-hidden rounded-xl border border-teatrino-charcoal/10 bg-white py-1 shadow-lg ring-1 ring-black/5"
        role="listbox"
    >
        @foreach ($supportedLocales as $code => $meta)
            @php
                $href = $routeName && $routeName !== 'locale.switch'
                    ? route($routeName, array_merge($routeParams, ['locale' => $code]))
                    : route('home', ['locale' => $code]);
            @endphp
            <a
                href="{{ $href }}"
                role="option"
                @class([
                    'flex items-center gap-2 px-4 py-2.5 text-sm transition hover:bg-teatrino-yellow/30',
                    'bg-teatrino-teal/10 font-semibold text-teatrino-teal' => $code === $currentLocale,
                    'text-teatrino-charcoal' => $code !== $currentLocale,
                ])
            >
                <span aria-hidden="true">{{ $meta['flag'] }}</span>
                <span>{{ $meta['native'] }}</span>
            </a>
        @endforeach
    </div>
</div>
