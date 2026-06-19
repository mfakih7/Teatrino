@extends('layouts.app')

@section('title', __('site.pages.articles.title'))

@section('content')
    <x-page-hero
        :title="__('site.pages.articles.title')"
        :subtitle="__('site.pages.articles.subtitle')"
    />

    <section class="teatrino-section teatrino-container">
        <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 sm:gap-6 lg:grid-cols-3">
            @forelse ($articles as $article)
                @php $image = $article->featuredImage(); @endphp
                <article class="teatrino-card flex h-full flex-col">
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
                                class="h-full w-full object-cover transition duration-300 group-hover:scale-105"
                                sizes="(max-width: 640px) 100vw, (max-width: 1024px) 50vw, 33vw"
                            />
                        </div>
                        <div class="flex flex-1 flex-col p-5">
                            @if ($article->published_at)
                                <time class="text-xs font-semibold uppercase tracking-wide text-teatrino-teal" datetime="{{ $article->published_at->toDateString() }}">
                                    {{ $article->published_at->format('M j, Y') }}
                                </time>
                            @endif
                            <h2 class="mt-2 line-clamp-2 text-lg font-bold text-teatrino-charcoal">{{ $article->t('title') }}</h2>
                            @if ($article->hasT('excerpt'))
                                <p class="mt-2 line-clamp-3 flex-1 text-sm leading-relaxed text-teatrino-charcoal/70">{{ $article->t('excerpt') }}</p>
                            @endif
                            <span class="mt-4 inline-flex items-center gap-1 text-sm font-semibold text-teatrino-coral">
                                {{ __('site.articles.read_more') }}
                                <svg class="h-4 w-4 rtl:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </span>
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
