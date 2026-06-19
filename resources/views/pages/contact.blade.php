@extends('layouts.app')

@section('title', $siteSettings->t('contact_title') ?? __('site.pages.contact.title'))

@section('content')
    <x-page-hero
        :title="$siteSettings->t('contact_title') ?? __('site.pages.contact.title')"
        :subtitle="$siteSettings->t('contact_description') ?? __('site.pages.contact.subtitle')"
    />

    <section class="mx-auto max-w-xl px-4 py-16 sm:px-6 sm:py-20">
        <div class="rounded-3xl border border-teatrino-coral/20 bg-white p-8 shadow-sm">
            <p class="mb-6 leading-relaxed text-teatrino-charcoal/80">
                {{ $siteSettings->t('contact_description') ?? __('site.site.coming_soon') }}
            </p>
            <div class="space-y-4 text-sm text-teatrino-charcoal/80">
                @if ($siteSettings->email)
                    <p>
                        <span aria-hidden="true">📧</span>
                        <a href="mailto:{{ $siteSettings->email }}" class="font-semibold hover:text-teatrino-teal">{{ $siteSettings->email }}</a>
                    </p>
                @endif
                @php
                    $whatsappNumber = $siteSettings->whatsapp_number;
                    $whatsappUrl = $whatsappNumber
                        ? 'https://wa.me/'.preg_replace('/\D+/', '', $whatsappNumber).'?text='.urlencode($siteSettings->whatsapp_message ?? '')
                        : null;
                @endphp
                @if ($whatsappUrl)
                    <p>
                        <a href="{{ $whatsappUrl }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-2 font-semibold text-teatrino-teal hover:underline">
                            {{ __('site.home.cta_whatsapp') }}
                        </a>
                    </p>
                @endif
            </div>
        </div>
    </section>
@endsection
