@extends('layouts.app')

@section('title', $homeContent->t('hero_title') ?? __('site.pages.home.title'))

@php
    $whatsappNumber = $siteSettings->whatsapp_number ?: config('site.whatsapp_number');
    $whatsappMessage = $siteSettings->whatsapp_message ?: config('site.whatsapp_message');
    $whatsappUrl = $whatsappNumber
        ? 'https://wa.me/'.preg_replace('/\D+/', '', $whatsappNumber).'?text='.urlencode($whatsappMessage)
        : route('contact', ['locale' => $currentLocale]);
    $whatsappExternal = (bool) $whatsappNumber;
@endphp

@section('content')
    <x-home-hero
        :home-content="$homeContent"
        :portfolio-url="route('portfolio', ['locale' => $currentLocale])"
        :whatsapp-url="$whatsappUrl"
        :whatsapp-external="$whatsappExternal"
    />

    <section class="mx-auto max-w-6xl px-4 py-20 sm:px-6 sm:py-24 lg:py-28">
        <div class="mx-auto max-w-2xl text-center">
            <h2 class="text-3xl font-bold tracking-tight text-teatrino-charcoal sm:text-4xl">
                {{ $homeContent->t('welcome_heading') ?? __('site.home.welcome_heading') }}
            </h2>
            <p class="mt-4 text-lg leading-relaxed text-teatrino-charcoal/75">
                {{ $siteSettings->t('footer_text') ?? __('site.site.tagline') }}
            </p>
        </div>

        <div class="mt-14 grid gap-6 sm:grid-cols-2 lg:grid-cols-3 lg:gap-8">
            @forelse ($featureCards as $feature)
                <article class="group rounded-3xl border border-white bg-white p-8 shadow-sm ring-1 ring-teatrino-charcoal/5 transition hover:-translate-y-1 hover:shadow-md">
                    <div class="mb-5 inline-flex h-14 w-14 items-center justify-center rounded-2xl bg-teatrino-yellow/40 text-2xl">
                        {{ $feature->icon }}
                    </div>
                    <h3 class="text-xl font-bold text-teatrino-charcoal">
                        {{ $feature->t('title') }}
                    </h3>
                    @if ($feature->hasT('description'))
                        <p class="mt-3 leading-relaxed text-teatrino-charcoal/70">
                            {{ $feature->t('description') }}
                        </p>
                    @endif
                </article>
            @empty
                <p class="col-span-full text-center text-teatrino-charcoal/60">{{ __('site.site.coming_soon') }}</p>
            @endforelse
        </div>
    </section>

    <section class="bg-white py-20 sm:py-24 lg:py-28">
        <div class="mx-auto max-w-6xl px-4 sm:px-6">
            <div class="grid items-center gap-12 lg:grid-cols-2 lg:gap-16">
                <div class="space-y-6">
                    <h2 class="text-3xl font-bold tracking-tight text-teatrino-charcoal sm:text-4xl">
                        {{ $homeContent->t('explore_heading') ?? __('site.home.explore_heading') }}
                    </h2>
                    <p class="text-lg leading-relaxed text-teatrino-charcoal/75">
                        {{ $homeContent->t('explore_text') ?? __('site.home.explore_text') }}
                    </p>
                    <a
                        href="{{ route('about', ['locale' => $currentLocale]) }}"
                        class="inline-flex items-center gap-2 rounded-full bg-teatrino-teal px-6 py-3 text-sm font-bold text-white shadow-md shadow-teatrino-teal/25 transition hover:bg-teatrino-teal/90"
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
                        class="rounded-3xl bg-teatrino-yellow/50 p-6 shadow-sm transition hover:bg-teatrino-yellow/70 sm:p-8"
                    >
                        <p class="text-3xl sm:text-4xl" aria-hidden="true">🎨</p>
                        <p class="mt-3 text-base font-bold text-teatrino-charcoal sm:text-lg">{{ __('site.nav.portfolio') }}</p>
                        <p class="mt-1 text-sm text-teatrino-charcoal/65">{{ __('site.home.card_portfolio') }}</p>
                    </a>
                    <a
                        href="{{ route('articles', ['locale' => $currentLocale]) }}"
                        class="rounded-3xl bg-teatrino-teal/20 p-6 shadow-sm transition hover:bg-teatrino-teal/30 sm:p-8"
                    >
                        <p class="text-3xl sm:text-4xl" aria-hidden="true">📚</p>
                        <p class="mt-3 text-base font-bold text-teatrino-charcoal sm:text-lg">{{ __('site.nav.articles') }}</p>
                        <p class="mt-1 text-sm text-teatrino-charcoal/65">{{ __('site.home.card_articles') }}</p>
                    </a>
                </div>
            </div>
        </div>
    </section>
@endsection
