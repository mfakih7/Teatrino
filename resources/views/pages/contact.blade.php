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
                <div class="reveal rounded-[var(--radius-teatrino-xl)] border border-teatrino-teal/20 bg-gradient-to-br from-teatrino-teal/10 via-white to-white p-7 shadow-[var(--shadow-teatrino-md)] sm:p-9 md:col-span-2">
                    <div class="flex flex-col gap-8 lg:flex-row lg:items-center lg:justify-between">
                        <div class="max-w-xl">
                            <div class="inline-flex h-14 w-14 items-center justify-center rounded-2xl bg-teatrino-teal/15 text-teatrino-teal shadow-[var(--shadow-teatrino-sm)]">
                                <x-site-icon name="whatsapp" class="h-7 w-7" />
                            </div>
                            <h2 class="teatrino-heading-md mt-5">{{ __('site.contact.whatsapp_title') }}</h2>
                            <p class="teatrino-lead mt-3 text-sm sm:text-base">
                                {{ $siteSettings->t('contact_description') ?: __('site.contact.whatsapp_text') }}
                            </p>
                        </div>
                        <a
                            href="{{ $whatsappUrl }}"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="teatrino-btn-secondary shrink-0 self-start lg:self-center"
                        >
                            <x-site-icon name="whatsapp" class="h-5 w-5" />
                            {{ __('site.home.cta_whatsapp') }}
                        </a>
                    </div>
                </div>
            @endif

            @if ($siteSettings->email)
                <div class="teatrino-card reveal reveal-delay-1 p-7 sm:p-8">
                    <div class="inline-flex h-14 w-14 items-center justify-center rounded-2xl bg-teatrino-yellow/35 text-teatrino-charcoal shadow-[var(--shadow-teatrino-sm)]">
                        <x-site-icon name="email" class="h-7 w-7" />
                    </div>
                    <h2 class="teatrino-heading-md mt-5 text-lg">{{ __('site.contact.email_title') }}</h2>
                    <p class="mt-2 text-sm leading-relaxed text-teatrino-charcoal/70">{{ __('site.contact.email_text') }}</p>
                    <a href="mailto:{{ $siteSettings->email }}" class="mt-5 inline-block break-all font-semibold text-teatrino-teal transition hover:underline">
                        {{ $siteSettings->email }}
                    </a>
                </div>
            @endif

            @if (count($activeSocials))
                <div class="teatrino-card reveal reveal-delay-2 p-7 sm:p-8">
                    <h2 class="teatrino-heading-md text-lg">{{ __('site.footer.follow_us') }}</h2>
                    <p class="mt-2 text-sm leading-relaxed text-teatrino-charcoal/70">{{ __('site.contact.social_text') }}</p>
                    <ul class="mt-6 flex flex-wrap gap-3">
                        @foreach ($activeSocials as $social)
                            <li>
                                <a
                                    href="{{ $siteSettings->{$social['key']} }}"
                                    target="_blank"
                                    rel="noopener noreferrer"
                                    aria-label="{{ $social['label'] }}"
                                    class="flex h-12 w-12 items-center justify-center rounded-full border border-teatrino-charcoal/10 bg-teatrino-cream text-teatrino-charcoal shadow-sm transition duration-200 hover:-translate-y-0.5 hover:border-teatrino-teal hover:bg-teatrino-teal/10 hover:text-teatrino-teal hover:shadow-md"
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
            <div class="teatrino-empty reveal mt-6">
                <div class="teatrino-empty-icon" aria-hidden="true">💬</div>
                <p class="text-teatrino-charcoal/60">{{ __('site.site.coming_soon') }}</p>
            </div>
        @endunless
    </section>

    @if ($whatsappUrl)
        <section class="teatrino-section-alt border-t border-teatrino-charcoal/5">
            <div class="teatrino-container">
                <div class="reveal overflow-hidden rounded-[var(--radius-teatrino-xl)] bg-gradient-to-r from-teatrino-teal via-teatrino-teal/90 to-teatrino-soft-blue px-6 py-10 text-center text-white shadow-[var(--shadow-teatrino-lg)] sm:px-10 sm:py-12">
                    <h2 class="text-2xl font-bold tracking-tight sm:text-3xl">{{ __('site.contact.cta_title') }}</h2>
                    <p class="mx-auto mt-3 max-w-xl text-sm leading-relaxed text-white/85 sm:text-base">{{ __('site.contact.cta_text') }}</p>
                    <a href="{{ $whatsappUrl }}" target="_blank" rel="noopener noreferrer" class="mt-6 inline-flex items-center gap-2 rounded-full bg-white px-8 py-3.5 text-sm font-bold text-teatrino-teal shadow-lg transition hover:-translate-y-0.5 hover:shadow-xl">
                        <x-site-icon name="whatsapp" class="h-5 w-5" />
                        {{ __('site.home.cta_whatsapp') }}
                    </a>
                </div>
            </div>
        </section>
    @endif
@endsection
