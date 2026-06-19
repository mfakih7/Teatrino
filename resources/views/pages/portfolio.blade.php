@extends('layouts.app')

@section('title', __('site.pages.portfolio.title'))

@section('content')
    <x-page-hero
        :title="__('site.pages.portfolio.title')"
        :subtitle="__('site.pages.portfolio.subtitle')"
    />

    <section class="teatrino-section teatrino-section-muted teatrino-container">
        <div class="reveal mb-10 text-center sm:mb-12">
            <p class="teatrino-eyebrow">{{ __('site.portfolio.eyebrow') }}</p>
            <p class="teatrino-lead mx-auto mt-2 max-w-2xl">{{ __('site.portfolio.lead') }}</p>
        </div>

        <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 sm:gap-6 lg:grid-cols-3">
            @forelse ($portfolioItems as $index => $item)
                @php $image = $item->image(); @endphp
                <article @class(['teatrino-card group reveal', 'reveal-delay-'.min(($index % 4) + 1, 4)])>
                    <button
                        type="button"
                        class="content-modal-trigger block w-full text-start"
                        data-modal-title="{{ e($item->t('title')) }}"
                        data-modal-body="{{ e($item->t('description')) }}"
                        data-modal-image="{{ $image?->optimized_url }}"
                        data-modal-image-webp="{{ $image?->webp_url }}"
                    >
                        <div class="portfolio-card-media aspect-[4/3] bg-gradient-to-br from-teatrino-soft-blue/40 to-teatrino-yellow/30">
                            <x-responsive-image
                                :media="$image"
                                variant="thumbnail"
                                :alt="$item->t('title')"
                                placeholder-icon="🌈"
                                class="h-full w-full object-cover transition duration-700 group-hover:scale-110"
                                sizes="(max-width: 640px) 100vw, (max-width: 1024px) 50vw, 33vw"
                            />
                            <div class="portfolio-card-overlay">
                                <p class="portfolio-card-overlay-title">{{ $item->t('title') }}</p>
                                @if ($item->hasT('description'))
                                    <p class="mt-1 line-clamp-2 translate-y-2 text-sm text-white/85 transition duration-300 group-hover:translate-y-0">{{ $item->t('description') }}</p>
                                @endif
                            </div>
                        </div>
                        <div class="p-5 sm:p-6">
                            <h2 class="line-clamp-2 font-bold text-teatrino-charcoal">{{ $item->t('title') }}</h2>
                            @if ($item->hasT('description'))
                                <p class="mt-2 line-clamp-2 text-sm leading-relaxed text-teatrino-charcoal/70">{{ $item->t('description') }}</p>
                            @endif
                        </div>
                    </button>
                </article>
            @empty
                <div class="teatrino-empty col-span-full reveal">
                    <div class="teatrino-empty-icon" aria-hidden="true">🎨</div>
                    <p class="text-teatrino-charcoal/60">{{ __('site.site.coming_soon') }}</p>
                </div>
            @endforelse
        </div>
    </section>

    <x-content-modal />
@endsection
