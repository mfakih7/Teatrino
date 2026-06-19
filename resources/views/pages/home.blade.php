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

    <section class="teatrino-section teatrino-container">
        <div class="mx-auto max-w-2xl text-center">
            <h2 class="text-2xl font-bold tracking-tight text-teatrino-charcoal sm:text-3xl md:text-4xl">
                {{ $homeContent->t('welcome_heading') ?: __('site.home.welcome_heading') }}
            </h2>
            <p class="mt-4 text-base leading-relaxed text-teatrino-charcoal/75 sm:text-lg">
                {{ $siteSettings->t('footer_text') ?: __('site.site.tagline') }}
            </p>
        </div>

        <div class="mt-10 grid gap-5 sm:grid-cols-2 sm:gap-6 lg:grid-cols-3 lg:gap-8">
            @forelse ($featureCards as $feature)
                <article class="group teatrino-card p-6 sm:p-8">
                    <div class="mb-4 inline-flex h-14 w-14 items-center justify-center rounded-2xl bg-gradient-to-br from-teatrino-yellow/50 to-teatrino-soft-pink/40 text-2xl shadow-sm">
                        {{ $feature->icon }}
                    </div>
                    <h3 class="text-lg font-bold text-teatrino-charcoal sm:text-xl">
                        {{ $feature->t('title') }}
                    </h3>
                    @if ($feature->hasT('description'))
                        <p class="mt-3 text-sm leading-relaxed text-teatrino-charcoal/70 sm:text-base">
                            {{ $feature->t('description') }}
                        </p>
                    @endif
                </article>
            @empty
                <p class="col-span-full text-center text-teatrino-charcoal/60">{{ __('site.site.coming_soon') }}</p>
            @endforelse
        </div>
    </section>

    <section class="bg-white py-14 sm:py-16 md:py-20">
        <div class="teatrino-container">
            <div class="grid items-center gap-10 lg:grid-cols-2 lg:gap-16">
                <div class="space-y-5 text-center lg:text-start">
                    <h2 class="text-2xl font-bold tracking-tight text-teatrino-charcoal sm:text-3xl md:text-4xl">
                        {{ $homeContent->t('explore_heading') ?: __('site.home.explore_heading') }}
                    </h2>
                    <p class="text-base leading-relaxed text-teatrino-charcoal/75 sm:text-lg">
                        {{ $homeContent->t('explore_text') ?: __('site.home.explore_text') }}
                    </p>
                    <a
                        href="{{ route('about', ['locale' => $currentLocale]) }}"
                        class="inline-flex items-center justify-center gap-2 rounded-full bg-teatrino-teal px-6 py-3 text-sm font-bold text-white shadow-md shadow-teatrino-teal/25 transition hover:bg-teatrino-teal/90"
                    >
                        {{ __('site.pages.home.cta') }}
                        <svg class="h-4 w-4 rtl:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                </div>

                <div class="grid grid-cols-2 gap-3 sm:gap-5">
                    <a
                        href="{{ route('portfolio', ['locale' => $currentLocale]) }}"
                        class="teatrino-card rounded-3xl bg-gradient-to-br from-teatrino-yellow/45 to-teatrino-yellow/25 p-5 hover:shadow-lg sm:p-7"
                    >
                        <p class="text-3xl sm:text-4xl" aria-hidden="true">🎨</p>
                        <p class="mt-3 text-sm font-bold text-teatrino-charcoal sm:text-lg">{{ __('site.nav.portfolio') }}</p>
                        <p class="mt-1 text-xs text-teatrino-charcoal/65 sm:text-sm">{{ __('site.home.card_portfolio') }}</p>
                    </a>
                    <a
                        href="{{ route('articles', ['locale' => $currentLocale]) }}"
                        class="teatrino-card rounded-3xl bg-gradient-to-br from-teatrino-teal/25 to-teatrino-soft-blue/30 p-5 hover:shadow-lg sm:p-7"
                    >
                        <p class="text-3xl sm:text-4xl" aria-hidden="true">📚</p>
                        <p class="mt-3 text-sm font-bold text-teatrino-charcoal sm:text-lg">{{ __('site.nav.articles') }}</p>
                        <p class="mt-1 text-xs text-teatrino-charcoal/65 sm:text-sm">{{ __('site.home.card_articles') }}</p>
                    </a>
                </div>
            </div>
        </div>
    </section>
@endsection
