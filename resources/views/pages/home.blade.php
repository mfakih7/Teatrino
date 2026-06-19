@extends('layouts.app')

@section('title', $homeContent->t('hero_title') ?: __('site.pages.home.title'))

@php
    use App\Support\SiteContact;

    $whatsappUrl = SiteContact::whatsappUrl($siteSettings) ?: route('contact', ['locale' => $currentLocale]);
    $whatsappExternal = (bool) SiteContact::whatsappUrl($siteSettings);
@endphp

@section('content')
    <x-home-hero
        :home-content="$homeContent"
        :portfolio-url="route('portfolio', ['locale' => $currentLocale])"
        :whatsapp-url="$whatsappUrl"
        :whatsapp-external="$whatsappExternal"
    />

    <section class="teatrino-section teatrino-section-muted teatrino-container">
        <div class="reveal mx-auto max-w-2xl text-center">
            <p class="teatrino-eyebrow">{{ __('site.home.badge') }}</p>
            <h2 class="teatrino-heading-lg mt-3">
                {{ $homeContent->t('welcome_heading') ?: __('site.home.welcome_heading') }}
            </h2>
            <p class="teatrino-lead mt-4">
                {{ $siteSettings->t('footer_text') ?: __('site.site.tagline') }}
            </p>
        </div>

        <div class="mt-12 grid gap-5 sm:grid-cols-2 sm:gap-6 lg:grid-cols-3 lg:gap-8">
            @forelse ($featureCards as $index => $feature)
                <article @class(['teatrino-card reveal p-7 sm:p-8', 'reveal-delay-'.min($index + 1, 4)])>
                    <div class="mb-5 inline-flex h-14 w-14 items-center justify-center rounded-2xl bg-gradient-to-br from-teatrino-yellow/55 to-teatrino-soft-pink/45 text-2xl shadow-[var(--shadow-teatrino-sm)]">
                        {{ $feature->icon }}
                    </div>
                    <h3 class="teatrino-heading-md text-lg sm:text-xl">
                        {{ $feature->t('title') }}
                    </h3>
                    @if ($feature->hasT('description'))
                        <p class="mt-3 text-sm leading-relaxed text-teatrino-charcoal/70 sm:text-base">
                            {{ $feature->t('description') }}
                        </p>
                    @endif
                </article>
            @empty
                <div class="teatrino-empty col-span-full reveal">
                    <div class="teatrino-empty-icon" aria-hidden="true">✨</div>
                    <p class="text-teatrino-charcoal/60">{{ __('site.site.coming_soon') }}</p>
                </div>
            @endforelse
        </div>
    </section>

    <section class="teatrino-section teatrino-section-alt border-y border-teatrino-charcoal/5">
        <div class="teatrino-container">
            <div class="reveal mx-auto max-w-2xl text-center">
                <p class="teatrino-eyebrow">{{ __('site.home.stats_eyebrow') }}</p>
                <h2 class="teatrino-heading-md mt-2">{{ __('site.home.stats_title') }}</h2>
            </div>
            <div class="mt-10 grid grid-cols-2 gap-4 sm:gap-6 lg:grid-cols-4">
                @foreach (['families', 'activities', 'languages', 'care'] as $index => $key)
                    <div @class(['teatrino-stat reveal', 'reveal-delay-'.min($index + 1, 4)])>
                        <p class="teatrino-stat-value">{{ __('site.home.stats.'.$key.'.value') }}</p>
                        <p class="teatrino-stat-label">{{ __('site.home.stats.'.$key.'.label') }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section class="teatrino-section teatrino-container">
        <div class="grid items-center gap-12 lg:grid-cols-2 lg:gap-20">
            <div class="reveal space-y-6 text-center lg:text-start">
                <p class="teatrino-eyebrow">{{ __('site.pages.home.cta') }}</p>
                <h2 class="teatrino-heading-lg">
                    {{ $homeContent->t('explore_heading') ?: __('site.home.explore_heading') }}
                </h2>
                <p class="teatrino-lead">
                    {{ $homeContent->t('explore_text') ?: __('site.home.explore_text') }}
                </p>
                <a
                    href="{{ route('about', ['locale' => $currentLocale]) }}"
                    class="teatrino-btn-primary"
                >
                    {{ __('site.pages.home.cta') }}
                    <svg class="h-4 w-4 rtl:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </a>
            </div>

            <div class="grid grid-cols-2 gap-4 sm:gap-5">
                <a
                    href="{{ route('portfolio', ['locale' => $currentLocale]) }}"
                    class="teatrino-card reveal reveal-delay-1 rounded-[var(--radius-teatrino-xl)] bg-gradient-to-br from-teatrino-yellow/50 to-teatrino-yellow/25 p-6 sm:p-8"
                >
                    <p class="text-3xl sm:text-4xl" aria-hidden="true">🎨</p>
                    <p class="mt-4 text-sm font-bold text-teatrino-charcoal sm:text-lg">{{ __('site.nav.portfolio') }}</p>
                    <p class="mt-1.5 text-xs leading-relaxed text-teatrino-charcoal/65 sm:text-sm">{{ __('site.home.card_portfolio') }}</p>
                </a>
                <a
                    href="{{ route('articles', ['locale' => $currentLocale]) }}"
                    class="teatrino-card reveal reveal-delay-2 rounded-[var(--radius-teatrino-xl)] bg-gradient-to-br from-teatrino-teal/25 to-teatrino-soft-blue/35 p-6 sm:p-8"
                >
                    <p class="text-3xl sm:text-4xl" aria-hidden="true">📚</p>
                    <p class="mt-4 text-sm font-bold text-teatrino-charcoal sm:text-lg">{{ __('site.nav.articles') }}</p>
                    <p class="mt-1.5 text-xs leading-relaxed text-teatrino-charcoal/65 sm:text-sm">{{ __('site.home.card_articles') }}</p>
                </a>
            </div>
        </div>
    </section>
@endsection
