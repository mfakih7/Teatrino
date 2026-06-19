@extends('layouts.app')

@section('title', $siteSettings->t('contact_title') ?: __('site.pages.contact.title'))

@php
    use App\Support\SiteContact;

    $whatsappUrl = SiteContact::whatsappUrl($siteSettings);
    $activeSocials = SiteContact::activeSocials($siteSettings);
@endphp

@section('content')
    <x-page-hero
        :title="$siteSettings->t('contact_title') ?: __('site.pages.contact.title')"
        :subtitle="$siteSettings->t('contact_description') ?: __('site.pages.contact.subtitle')"
    />

    <section class="teatrino-section teatrino-container max-w-5xl">
        <div class="grid gap-5 md:grid-cols-2 md:gap-6 lg:gap-8">
            @if ($whatsappUrl)
                <div class="rounded-3xl border border-teatrino-teal/20 bg-gradient-to-br from-teatrino-teal/10 via-white to-white p-6 shadow-sm sm:p-8 md:col-span-2">
                    <div class="flex flex-col gap-6 sm:flex-row sm:items-center sm:justify-between">
                        <div class="max-w-xl">
                            <div class="inline-flex h-12 w-12 items-center justify-center rounded-2xl bg-teatrino-teal/15 text-teatrino-teal">
                                <x-site-icon name="whatsapp" class="h-6 w-6" />
                            </div>
                            <h2 class="mt-4 text-xl font-bold text-teatrino-charcoal sm:text-2xl">{{ __('site.contact.whatsapp_title') }}</h2>
                            <p class="mt-3 text-sm leading-relaxed text-teatrino-charcoal/75 sm:text-base">
                                {{ $siteSettings->t('contact_description') ?: __('site.contact.whatsapp_text') }}
                            </p>
                        </div>
                        <a
                            href="{{ $whatsappUrl }}"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="teatrino-btn-secondary shrink-0 self-start sm:self-center"
                        >
                            <x-site-icon name="whatsapp" class="h-5 w-5" />
                            {{ __('site.home.cta_whatsapp') }}
                        </a>
                    </div>
                </div>
            @endif

            @if ($siteSettings->email)
                <div class="teatrino-card p-6 sm:p-8">
                    <div class="inline-flex h-12 w-12 items-center justify-center rounded-2xl bg-teatrino-yellow/30 text-teatrino-charcoal">
                        <x-site-icon name="email" class="h-6 w-6" />
                    </div>
                    <h2 class="mt-4 text-lg font-bold text-teatrino-charcoal">{{ __('site.contact.email_title') }}</h2>
                    <p class="mt-2 text-sm text-teatrino-charcoal/70">{{ __('site.contact.email_text') }}</p>
                    <a href="mailto:{{ $siteSettings->email }}" class="mt-4 inline-block break-all font-semibold text-teatrino-teal hover:underline">
                        {{ $siteSettings->email }}
                    </a>
                </div>
            @endif

            @if (count($activeSocials))
                <div class="teatrino-card p-6 sm:p-8">
                    <h2 class="text-lg font-bold text-teatrino-charcoal">{{ __('site.footer.follow_us') }}</h2>
                    <p class="mt-2 text-sm text-teatrino-charcoal/70">{{ __('site.contact.social_text') }}</p>
                    <ul class="mt-5 flex flex-wrap gap-3">
                        @foreach ($activeSocials as $social)
                            <li>
                                <a
                                    href="{{ $siteSettings->{$social['key']} }}"
                                    target="_blank"
                                    rel="noopener noreferrer"
                                    aria-label="{{ $social['label'] }}"
                                    class="flex h-11 w-11 items-center justify-center rounded-full border border-teatrino-charcoal/10 bg-teatrino-cream text-teatrino-charcoal transition hover:border-teatrino-teal hover:bg-teatrino-teal/10 hover:text-teatrino-teal"
                                >
                                    <x-site-icon :name="$social['icon']" class="h-4 w-4" />
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>

        @unless ($whatsappUrl || $siteSettings->email || count($activeSocials))
            <div class="mt-6 rounded-3xl border border-dashed border-teatrino-charcoal/15 bg-white p-10 text-center text-teatrino-charcoal/60">
                {{ __('site.site.coming_soon') }}
            </div>
        @endunless
    </section>
@endsection
