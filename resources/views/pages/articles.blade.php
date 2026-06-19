@extends('layouts.app')

@section('title', __('site.pages.articles.title'))

@section('content')
    <x-page-hero
        :title="__('site.pages.articles.title')"
        :subtitle="__('site.pages.articles.subtitle')"
    />

    <section class="mx-auto max-w-6xl px-4 py-16 sm:px-6 sm:py-20">
        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
            @forelse ($articles as $article)
                @php
                    $image = $article->featuredImage();
                @endphp
                <article class="flex h-full flex-col overflow-hidden rounded-3xl border border-teatrino-charcoal/10 bg-white shadow-sm transition hover:-translate-y-1 hover:shadow-md">
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
                        <div class="aspect-[16/10] overflow-hidden bg-teatrino-cream">
                            <x-responsive-image
                                :media="$image"
                                variant="thumbnail"
                                :alt="$article->t('title')"
                                placeholder-icon="📰"
                                class="h-full w-full object-cover"
                                sizes="(max-width: 1024px) 50vw, 33vw"
                            />
                        </div>
                        <div class="flex flex-1 flex-col p-5">
                            @if ($article->published_at)
                                <time class="text-xs font-semibold uppercase tracking-wide text-teatrino-teal" datetime="{{ $article->published_at->toDateString() }}">
                                    {{ $article->published_at->format('M j, Y') }}
                                </time>
                            @endif
                            <h2 class="mt-2 text-lg font-bold text-teatrino-charcoal">{{ $article->t('title') }}</h2>
                            @if ($article->hasT('excerpt'))
                                <p class="mt-2 line-clamp-3 flex-1 text-sm leading-relaxed text-teatrino-charcoal/70">{{ $article->t('excerpt') }}</p>
                            @endif
                            <span class="mt-4 text-sm font-semibold text-teatrino-coral">{{ __('site.articles.read_more') }}</span>
                        </div>
                    </button>
                </article>
            @empty
                <p class="col-span-full text-center text-teatrino-charcoal/60">{{ __('site.site.coming_soon') }}</p>
            @endforelse
        </div>
    </section>

    <x-content-modal />
@endsection
