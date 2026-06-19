@props(['portfolioUrl', 'whatsappUrl', 'whatsappExternal' => true, 'homeContent'])

@php
    $heroMedia = $homeContent->heroMedia();
@endphp

<section class="relative overflow-hidden bg-gradient-to-b from-teatrino-yellow/25 via-teatrino-cream to-white">
    <div class="pointer-events-none absolute inset-x-0 bottom-0 flex justify-center" aria-hidden="true">
        <svg
            class="h-auto w-[160%] max-w-none translate-y-[18%] sm:w-[130%] sm:translate-y-[12%] md:w-full md:max-w-5xl md:translate-y-[8%]"
            viewBox="0 0 900 420"
            fill="none"
            xmlns="http://www.w3.org/2000/svg"
        >
            <path d="M60 360 Q450 40 840 360 Z" fill="#FFD166" fill-opacity="0.55"/>
            <path d="M120 360 Q450 80 780 360 Z" fill="#2EC4B6" fill-opacity="0.45"/>
            <path d="M180 360 Q450 120 720 360 Z" fill="#E76F51" fill-opacity="0.4"/>
            <path d="M240 360 Q450 160 660 360 Z" fill="#FFB4A2" fill-opacity="0.5"/>
            <path d="M300 360 Q450 200 600 360 Z" fill="#A8DADC" fill-opacity="0.45"/>
            <path d="M430 360 L450 395 L470 360 Z" fill="#2D3436" fill-opacity="0.15"/>
            <line x1="450" y1="395" x2="450" y2="415" stroke="#2D3436" stroke-width="4" stroke-linecap="round" opacity="0.2"/>
        </svg>
    </div>

    <div class="pointer-events-none absolute -start-20 top-16 h-56 w-56 rounded-full bg-teatrino-coral/15 blur-3xl"></div>
    <div class="pointer-events-none absolute -end-16 top-32 h-64 w-64 rounded-full bg-teatrino-teal/15 blur-3xl"></div>

    <div class="relative mx-auto max-w-6xl px-4 pb-28 pt-20 sm:px-6 sm:pb-32 sm:pt-24 md:pb-36 md:pt-28 lg:pt-32">
        <div class="mx-auto grid max-w-5xl items-center gap-10 lg:grid-cols-2">
            <div class="text-center lg:text-start">
                <p class="mb-5 inline-flex items-center gap-2 rounded-full border border-teatrino-teal/20 bg-white/80 px-4 py-1.5 text-sm font-semibold text-teatrino-teal shadow-sm backdrop-blur-sm">
                    <span class="text-base" aria-hidden="true">☂️</span>
                    {{ $siteSettings->t('website_name') ?? __('site.home.badge') }}
                </p>

                <h1 class="text-4xl font-bold leading-tight tracking-tight text-teatrino-charcoal sm:text-5xl md:text-6xl">
                    {{ $homeContent->t('hero_title') ?? __('site.pages.home.title') }}
                </h1>

                <p class="mx-auto mt-6 max-w-2xl text-lg leading-relaxed text-teatrino-charcoal/75 sm:text-xl lg:mx-0">
                    {{ $homeContent->t('hero_subtitle') ?? __('site.pages.home.subtitle') }}
                </p>

                @if ($homeContent->t('hero_description'))
                    <p class="mx-auto mt-4 max-w-2xl text-base leading-relaxed text-teatrino-charcoal/70 lg:mx-0">
                        {{ $homeContent->t('hero_description') }}
                    </p>
                @endif

                <div class="mt-10 flex flex-col items-stretch justify-center gap-4 sm:flex-row sm:items-center lg:justify-start">
                    <a
                        href="{{ $portfolioUrl }}"
                        class="inline-flex items-center justify-center gap-2 rounded-full bg-teatrino-coral px-8 py-4 text-base font-bold text-white shadow-lg shadow-teatrino-coral/30 transition hover:bg-teatrino-coral/90"
                    >
                        {{ $homeContent->t('cta_portfolio') ?? __('site.home.cta_portfolio') }}
                    </a>

                    <a
                        href="{{ $whatsappUrl }}"
                        @if ($whatsappExternal) target="_blank" rel="noopener noreferrer" @endif
                        class="inline-flex items-center justify-center gap-2 rounded-full border-2 border-teatrino-teal bg-white px-8 py-4 text-base font-bold text-teatrino-teal shadow-sm transition hover:bg-teatrino-teal hover:text-white"
                    >
                        {{ $homeContent->t('cta_whatsapp') ?? __('site.home.cta_whatsapp') }}
                    </a>
                </div>
            </div>

            @if ($heroMedia)
                <div class="mx-auto w-full max-w-md overflow-hidden rounded-[2rem] border-4 border-white shadow-xl shadow-teatrino-charcoal/10 lg:max-w-none">
                    <x-responsive-image
                        :media="$heroMedia"
                        variant="optimized"
                        placeholder-icon="☂️"
                        class="h-72 w-full object-cover sm:h-80 lg:h-[22rem]"
                        sizes="(max-width: 1024px) 90vw, 40vw"
                    />
                </div>
            @endif
        </div>
    </div>
</section>
