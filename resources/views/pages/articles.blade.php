@extends('layouts.app')

@section('title', __('site.pages.articles.title'))

@section('content')
    <x-page-hero
        :title="__('site.pages.articles.title')"
        :subtitle="__('site.pages.articles.subtitle')"
    />

    <section class="teatrino-section teatrino-container">
        @php
            $featured = $articles->first();
            $rest = $articles->skip(1);
        @endphp

        @if ($featured)
            @php $featuredImage = $featured->featuredImage(); @endphp
            <article class="teatrino-card reveal mb-8 overflow-hidden lg:mb-10">
                <template id="article-body-{{ $featured->id }}">{!! $featured->t('body') !!}</template>
                <button
                    type="button"
                    class="content-modal-trigger grid w-full text-start lg:grid-cols-2"
                    data-modal-title="{{ e($featured->t('title')) }}"
                    data-modal-template="article-body-{{ $featured->id }}"
                    data-modal-image="{{ $featuredImage?->optimized_url }}"
                    data-modal-image-webp="{{ $featuredImage?->webp_url }}"
                    data-modal-meta="{{ optional($featured->published_at)?->format('M j, Y') }}"
                >
                    <div class="aspect-[16/10] overflow-hidden bg-gradient-to-br from-teatrino-cream to-teatrino-soft-blue/25 lg:aspect-auto lg:min-h-[20rem]">
                        <x-responsive-image
                            :media="$featuredImage"
                            variant="thumbnail"
                            :alt="$featured->t('title')"
                            placeholder-icon="📰"
                            class="h-full w-full object-cover transition duration-500 hover:scale-[1.02]"
                            sizes="(max-width: 1024px) 100vw, 50vw"
                        />
                    </div>
                    <div class="flex flex-col justify-center p-6 sm:p-8 lg:p-10">
                        <span class="teatrino-eyebrow">{{ __('site.articles.featured') }}</span>
                        @if ($featured->published_at)
                            <time class="mt-3 text-xs font-semibold uppercase tracking-wide text-teatrino-teal" datetime="{{ $featured->published_at->toDateString() }}">
                                {{ $featured->published_at->format('M j, Y') }}
                            </time>
                        @endif
                        <h2 class="teatrino-heading-md mt-3">{{ $featured->t('title') }}</h2>
                        @if ($featured->hasT('excerpt'))
                            <p class="mt-4 line-clamp-4 text-base leading-relaxed text-teatrino-charcoal/70">{{ $featured->t('excerpt') }}</p>
                        @endif
                        <span class="mt-6 inline-flex items-center gap-2 text-sm font-bold text-teatrino-coral">
                            {{ __('site.articles.read_more') }}
                            <svg class="h-4 w-4 rtl:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </span>
                    </div>
                </button>
            </article>
        @endif

        <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 sm:gap-6 lg:grid-cols-3">
            @forelse ($rest as $index => $article)
                @php $image = $article->featuredImage(); @endphp
                <article @class(['teatrino-card reveal flex h-full flex-col', 'reveal-delay-'.min(($index % 4) + 1, 4)])>
                    <template id="article-body-{{ $article->id }}">{!! $article->t('body') !!}</template>
                    <button
                        type="button"
                        class="content-modal-trigger flex h-full flex-col text-start"
                        data-modal-title="{{ e($article->t('title')) }}"
                        data-modal-template="article-body-{{ $article->id }}"
                        data-modal-image="{{ $image?->optimized_url }}"
                        data-modal-image-webp="{{ $image?->webp_url }}"
                        data-modal-meta="{{ optional($article->published_at)?->format('M j, Y') }}"
                    >
                        <div class="aspect-[16/10] overflow-hidden bg-gradient-to-br from-teatrino-cream to-teatrino-soft-blue/20">
                            <x-responsive-image
                                :media="$image"
                                variant="thumbnail"
                                :alt="$article->t('title')"
                                placeholder-icon="📰"
                                class="h-full w-full object-cover transition duration-500 hover:scale-105"
                                sizes="(max-width: 640px) 100vw, (max-width: 1024px) 50vw, 33vw"
                            />
                        </div>
                        <div class="flex flex-1 flex-col p-5 sm:p-6">
                            @if ($article->published_at)
                                <time class="text-xs font-semibold uppercase tracking-wide text-teatrino-teal" datetime="{{ $article->published_at->toDateString() }}">
                                    {{ $article->published_at->format('M j, Y') }}
                                </time>
                            @endif
                            <h2 class="mt-2 line-clamp-2 text-lg font-bold leading-snug text-teatrino-charcoal">{{ $article->t('title') }}</h2>
                            @if ($article->hasT('excerpt'))
                                <p class="mt-2 line-clamp-3 flex-1 text-sm leading-relaxed text-teatrino-charcoal/70">{{ $article->t('excerpt') }}</p>
                            @endif
                            <span class="mt-4 inline-flex items-center gap-1.5 text-sm font-semibold text-teatrino-coral">
                                {{ __('site.articles.read_more') }}
                                <svg class="h-4 w-4 rtl:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </span>
                        </div>
                    </button>
                </article>
            @empty
                @unless ($featured)
                    <div class="teatrino-empty col-span-full reveal">
                        <div class="teatrino-empty-icon" aria-hidden="true">📰</div>
                        <p class="text-teatrino-charcoal/60">{{ __('site.site.coming_soon') }}</p>
                    </div>
                @endunless
            @endforelse
        </div>
    </section>

    <x-content-modal />
@endsection
