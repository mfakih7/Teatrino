@props(['portfolioUrl', 'whatsappUrl', 'whatsappExternal' => true, 'homeContent'])

@php
    $heroMedia = $homeContent->heroMedia();
@endphp

<section class="relative overflow-hidden bg-gradient-to-b from-teatrino-yellow/20 via-teatrino-cream to-white">
    <div class="pointer-events-none absolute inset-x-0 bottom-0 flex justify-center" aria-hidden="true">
        <svg
            class="h-auto w-[140%] max-w-none translate-y-[20%] sm:w-[120%] sm:translate-y-[14%] md:w-full md:max-w-5xl md:translate-y-[10%] lg:translate-y-[8%]"
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

    <div class="pointer-events-none absolute -start-16 top-10 h-48 w-48 rounded-full bg-teatrino-coral/15 blur-3xl md:-start-20 md:top-16 md:h-56 md:w-56"></div>
    <div class="pointer-events-none absolute -end-12 top-24 h-52 w-52 rounded-full bg-teatrino-teal/15 blur-3xl md:-end-16 md:top-32 md:h-64 md:w-64"></div>

    <div class="relative teatrino-container pb-16 pt-14 sm:pb-20 sm:pt-16 md:pb-24 md:pt-20 lg:pb-28 lg:pt-24">
        <div class="mx-auto grid max-w-5xl items-center gap-8 md:gap-10 lg:grid-cols-2 lg:gap-12">
            <div class="text-center lg:text-start">
                <p class="mb-4 inline-flex items-center gap-2 rounded-full border border-teatrino-teal/20 bg-white/85 px-4 py-1.5 text-sm font-semibold text-teatrino-teal shadow-sm backdrop-blur-sm sm:mb-5">
                    <span class="text-base" aria-hidden="true">☂️</span>
                    {{ $siteSettings->t('website_name') ?: __('site.home.badge') }}
                </p>

                <h1 class="text-3xl font-bold leading-tight tracking-tight text-teatrino-charcoal sm:text-4xl md:text-5xl lg:text-[3.25rem]">
                    {{ $homeContent->t('hero_title') ?: __('site.pages.home.title') }}
                </h1>

                <p class="mx-auto mt-4 max-w-2xl text-base leading-relaxed text-teatrino-charcoal/75 sm:mt-5 sm:text-lg md:text-xl lg:mx-0">
                    {{ $homeContent->t('hero_subtitle') ?: __('site.pages.home.subtitle') }}
                </p>

                @if ($homeContent->hasT('hero_description'))
                    <p class="mx-auto mt-3 max-w-2xl text-sm leading-relaxed text-teatrino-charcoal/70 sm:text-base lg:mx-0">
                        {{ $homeContent->t('hero_description') }}
                    </p>
                @endif

                <div class="mt-8 flex flex-col items-stretch justify-center gap-3 sm:flex-row sm:items-center sm:gap-4 lg:justify-start">
                    <a href="{{ $portfolioUrl }}" class="teatrino-btn-primary w-full sm:w-auto">
                        {{ $homeContent->t('cta_portfolio') ?: __('site.home.cta_portfolio') }}
                    </a>

                    <a
                        href="{{ $whatsappUrl }}"
                        @if ($whatsappExternal) target="_blank" rel="noopener noreferrer" @endif
                        class="teatrino-btn-secondary w-full sm:w-auto"
                    >
                        <x-site-icon name="whatsapp" class="h-5 w-5" />
                        {{ $homeContent->t('cta_whatsapp') ?: __('site.home.cta_whatsapp') }}
                    </a>
                </div>
            </div>

            <div class="mx-auto w-full max-w-sm md:max-w-md lg:max-w-none">
                @if ($heroMedia)
                    <div class="overflow-hidden rounded-[1.75rem] border-4 border-white shadow-xl shadow-teatrino-charcoal/10 sm:rounded-[2rem]">
                        <x-responsive-image
                            :media="$heroMedia"
                            variant="optimized"
                            placeholder-icon="☂️"
                            class="aspect-[4/3] w-full object-cover sm:aspect-[5/4] lg:aspect-[4/3] lg:h-[22rem]"
                            sizes="(max-width: 1024px) 90vw, 42vw"
                        />
                    </div>
                @else
                    <div class="flex aspect-[4/3] items-center justify-center rounded-[1.75rem] border-4 border-white bg-gradient-to-br from-teatrino-yellow/30 via-white to-teatrino-teal/20 shadow-xl sm:rounded-[2rem] lg:h-[22rem]">
                        <div class="text-center">
                            <div class="mx-auto scale-125">@include('components.logo')</div>
                            <p class="mt-4 text-sm font-semibold text-teatrino-charcoal/60">{{ $siteSettings->t('website_name') ?: 'Teatrino' }}</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>
