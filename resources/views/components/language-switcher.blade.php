@php
    $route = request()->route();
    $routeName = $route?->getName();
    $routeParams = $route?->parameters() ?? [];
@endphp

<div class="relative">
    <button
        type="button"
        class="inline-flex items-center gap-2 rounded-full border border-teatrino-charcoal/10 bg-white px-3 py-1.5 text-sm font-semibold text-teatrino-charcoal shadow-sm hover:bg-teatrino-yellow/20"
        onclick="this.nextElementSibling.classList.toggle('hidden')"
        aria-haspopup="listbox"
        aria-expanded="false"
    >
        <span>{{ $localeMeta['flag'] }}</span>
        <span class="hidden sm:inline">{{ $localeMeta['native'] }}</span>
        <svg class="h-4 w-4 opacity-60" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
        </svg>
    </button>

    <div class="absolute end-0 z-50 mt-2 hidden min-w-[10rem] overflow-hidden rounded-xl border border-teatrino-charcoal/10 bg-white py-1 shadow-lg">
        @foreach ($supportedLocales as $code => $meta)
            @php
                $href = $routeName && $routeName !== 'locale.switch'
                    ? route($routeName, array_merge($routeParams, ['locale' => $code]))
                    : route('home', ['locale' => $code]);
            @endphp
            <a
                href="{{ $href }}"
                @class([
                    'flex items-center gap-2 px-4 py-2 text-sm transition hover:bg-teatrino-yellow/30',
                    'bg-teatrino-teal/10 font-semibold text-teatrino-teal' => $code === $currentLocale,
                ])
            >
                <span>{{ $meta['flag'] }}</span>
                <span>{{ $meta['native'] }}</span>
            </a>
        @endforeach
    </div>
</div>
