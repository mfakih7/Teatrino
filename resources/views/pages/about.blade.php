@extends('layouts.app')

@section('title', $aboutPage?->t('title') ?: __('site.pages.about.title'))

@section('content')
    <x-page-hero
        :title="$aboutPage?->t('title') ?: __('site.pages.about.title')"
        :subtitle="__('site.pages.about.subtitle')"
    />

    @if ($aboutPage?->is_active)
        <section class="teatrino-section teatrino-container max-w-5xl">
            @if ($aboutPage->hasT('body'))
                <div class="teatrino-prose rounded-3xl border border-teatrino-charcoal/5 bg-white p-6 shadow-sm sm:p-8 md:p-10">
                    {!! $aboutPage->t('body') !!}
                </div>
            @endif

            @if ($aboutPage->galleryMedia()->exists())
                @php $gallery = $aboutPage->galleryMedia->take(3); @endphp
                <div class="mt-10 grid gap-4 sm:grid-cols-2 md:mt-12 lg:grid-cols-3">
                    @foreach ($gallery as $index => $image)
                        <div @class([
                            'overflow-hidden rounded-3xl shadow-md ring-1 ring-teatrino-charcoal/5',
                            'sm:col-span-2 lg:col-span-1' => $index === 0 && $gallery->count() === 3,
                            'lg:row-span-1' => true,
                        ])>
                            <x-responsive-image
                                :media="$image"
                                variant="thumbnail"
                                class="h-52 w-full object-cover sm:h-56 md:h-64"
                                sizes="(max-width: 640px) 100vw, (max-width: 1024px) 50vw, 33vw"
                            />
                        </div>
                    @endforeach
                </div>
            @endif

            <div class="mt-10 grid gap-5 md:mt-12 md:grid-cols-2 md:gap-6">
                @if ($aboutPage->hasT('mission'))
                    <div class="rounded-3xl border border-teatrino-teal/20 bg-gradient-to-br from-white to-teatrino-teal/5 p-7 shadow-sm sm:p-8">
                        <div class="mb-3 inline-flex h-12 w-12 items-center justify-center rounded-2xl bg-teatrino-teal/15 text-xl" aria-hidden="true">🎯</div>
                        <h2 class="text-xl font-bold text-teatrino-teal">{{ __('site.about.mission') }}</h2>
                        <p class="mt-4 leading-relaxed text-teatrino-charcoal/80">{{ $aboutPage->t('mission') }}</p>
                    </div>
                @endif
                @if ($aboutPage->hasT('vision'))
                    <div class="rounded-3xl border border-teatrino-coral/20 bg-gradient-to-br from-white to-teatrino-coral/5 p-7 shadow-sm sm:p-8">
                        <div class="mb-3 inline-flex h-12 w-12 items-center justify-center rounded-2xl bg-teatrino-coral/15 text-xl" aria-hidden="true">🌈</div>
                        <h2 class="text-xl font-bold text-teatrino-coral">{{ __('site.about.vision') }}</h2>
                        <p class="mt-4 leading-relaxed text-teatrino-charcoal/80">{{ $aboutPage->t('vision') }}</p>
                    </div>
                @endif
            </div>
        </section>
    @else
        <section class="teatrino-section teatrino-container max-w-3xl">
            <div class="rounded-3xl border border-teatrino-teal/20 bg-white p-8 text-center shadow-sm">
                <p class="text-teatrino-charcoal/80">{{ __('site.site.coming_soon') }}</p>
            </div>
        </section>
    @endif
@endsection
