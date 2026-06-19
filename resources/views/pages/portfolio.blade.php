@extends('layouts.app')

@section('title', __('site.pages.portfolio.title'))

@section('content')
    <x-page-hero
        :title="__('site.pages.portfolio.title')"
        :subtitle="__('site.pages.portfolio.subtitle')"
    />

    <section class="teatrino-section teatrino-container">
        <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 sm:gap-6 lg:grid-cols-3">
            @forelse ($portfolioItems as $item)
                @php $image = $item->image(); @endphp
                <article class="teatrino-card group">
                    <button
                        type="button"
                        class="content-modal-trigger block w-full text-start"
                        data-modal-title="{{ e($item->t('title')) }}"
                        data-modal-body="{{ e($item->t('description')) }}"
                        data-modal-image="{{ $image?->optimized_url }}"
                        data-modal-image-webp="{{ $image?->webp_url }}"
                    >
                        <div class="aspect-[4/3] overflow-hidden bg-gradient-to-br from-teatrino-soft-blue/40 to-teatrino-yellow/30">
                            <x-responsive-image
                                :media="$image"
                                variant="thumbnail"
                                :alt="$item->t('title')"
                                placeholder-icon="🌈"
                                class="h-full w-full object-cover transition duration-500 group-hover:scale-105"
                                sizes="(max-width: 640px) 100vw, (max-width: 1024px) 50vw, 33vw"
                            />
                        </div>
                        <div class="p-5">
                            <h2 class="line-clamp-2 font-bold text-teatrino-charcoal">{{ $item->t('title') }}</h2>
                            @if ($item->hasT('description'))
                                <p class="mt-2 line-clamp-2 text-sm leading-relaxed text-teatrino-charcoal/70">{{ $item->t('description') }}</p>
                            @endif
                        </div>
                    </button>
                </article>
            @empty
                <p class="col-span-full rounded-3xl border border-dashed border-teatrino-charcoal/15 bg-white p-10 text-center text-teatrino-charcoal/60">{{ __('site.site.coming_soon') }}</p>
            @endforelse
        </div>
    </section>

    <x-content-modal />
@endsection
