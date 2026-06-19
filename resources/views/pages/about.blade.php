@extends('layouts.app')

@section('title', $aboutPage?->t('title') ?: __('site.pages.about.title'))

@section('content')
    <x-page-hero
        :title="$aboutPage?->t('title') ?: __('site.pages.about.title')"
        :subtitle="__('site.pages.about.subtitle')"
    />

    @if ($aboutPage?->is_active)
        <section class="teatrino-section teatrino-container max-w-5xl">
            @if ($aboutPage->galleryMedia()->exists())
                @php $gallery = $aboutPage->galleryMedia->take(3); @endphp
                <div class="reveal mb-12 grid gap-4 sm:grid-cols-6 sm:gap-5 lg:mb-16">
                    @foreach ($gallery as $index => $image)
                        <div @class([
                            'overflow-hidden rounded-[var(--radius-teatrino-xl)] shadow-[var(--shadow-teatrino-md)] ring-1 ring-teatrino-charcoal/5',
                            'sm:col-span-4 sm:row-span-2' => $index === 0,
                            'sm:col-span-2' => $index > 0,
                        ])>
                            <x-responsive-image
                                :media="$image"
                                variant="thumbnail"
                                class="w-full object-cover {{ $index === 0 ? 'h-56 sm:h-full sm:min-h-[18rem]' : 'h-44 sm:h-40' }}"
                                sizes="(max-width: 640px) 100vw, 50vw"
                            />
                        </div>
                    @endforeach
                </div>
            @endif

            <div class="teatrino-timeline">
                @if ($aboutPage->hasT('body'))
                    <div class="teatrino-timeline-item reveal">
                        <div class="teatrino-timeline-dot" aria-hidden="true">📖</div>
                        <div class="teatrino-card-flat">
                            <p class="teatrino-eyebrow">{{ __('site.about.story') }}</p>
                            <div class="teatrino-prose mt-4">{!! $aboutPage->t('body') !!}</div>
                        </div>
                    </div>
                @endif

                @if ($aboutPage->hasT('mission'))
                    <div class="teatrino-timeline-item reveal reveal-delay-1">
                        <div class="teatrino-timeline-dot bg-teatrino-teal text-white" aria-hidden="true">🎯</div>
                        <div class="rounded-[var(--radius-teatrino-xl)] border border-teatrino-teal/20 bg-gradient-to-br from-white to-teatrino-teal/5 p-7 shadow-[var(--shadow-teatrino-sm)] sm:p-8">
                            <h2 class="teatrino-heading-md text-teatrino-teal">{{ __('site.about.mission') }}</h2>
                            <p class="mt-4 leading-relaxed text-teatrino-charcoal/80">{{ $aboutPage->t('mission') }}</p>
                        </div>
                    </div>
                @endif

                @if ($aboutPage->hasT('vision'))
                    <div class="teatrino-timeline-item reveal reveal-delay-2">
                        <div class="teatrino-timeline-dot bg-teatrino-coral text-white" aria-hidden="true">🌈</div>
                        <div class="rounded-[var(--radius-teatrino-xl)] border border-teatrino-coral/20 bg-gradient-to-br from-white to-teatrino-coral/5 p-7 shadow-[var(--shadow-teatrino-sm)] sm:p-8">
                            <h2 class="teatrino-heading-md text-teatrino-coral">{{ __('site.about.vision') }}</h2>
                            <p class="mt-4 leading-relaxed text-teatrino-charcoal/80">{{ $aboutPage->t('vision') }}</p>
                        </div>
                    </div>
                @endif
            </div>
        </section>
    @else
        <section class="teatrino-section teatrino-container max-w-3xl">
            <div class="teatrino-empty reveal">
                <div class="teatrino-empty-icon" aria-hidden="true">☂️</div>
                <p class="text-teatrino-charcoal/80">{{ __('site.site.coming_soon') }}</p>
            </div>
        </section>
    @endif
@endsection
