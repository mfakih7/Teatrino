@extends('layouts.app')

@section('title', $aboutPage?->t('title') ?? __('site.pages.about.title'))

@section('content')
    <x-page-hero
        :title="$aboutPage?->t('title') ?? __('site.pages.about.title')"
        :subtitle="__('site.pages.about.subtitle')"
    />

    @if ($aboutPage?->is_active)
        <section class="mx-auto max-w-5xl px-4 py-16 sm:px-6 sm:py-20">
            @if ($aboutPage->hasT('body'))
                <div class="prose prose-lg max-w-none text-teatrino-charcoal/80 prose-headings:text-teatrino-charcoal">
                    {!! $aboutPage->t('body') !!}
                </div>
            @endif

            @if ($aboutPage->galleryMedia()->exists())
                <div class="mt-12 grid gap-4 sm:grid-cols-3">
                    @foreach ($aboutPage->galleryMedia as $image)
                        <div class="overflow-hidden rounded-3xl shadow-sm ring-1 ring-teatrino-charcoal/5">
                            <x-responsive-image
                                :media="$image"
                                variant="thumbnail"
                                class="h-48 w-full object-cover sm:h-56"
                                sizes="(max-width: 640px) 100vw, 33vw"
                            />
                        </div>
                    @endforeach
                </div>
            @endif

            <div class="mt-12 grid gap-6 md:grid-cols-2">
                @if ($aboutPage->hasT('mission'))
                    <div class="rounded-3xl border border-teatrino-teal/20 bg-white p-8 shadow-sm">
                        <h2 class="text-xl font-bold text-teatrino-teal">{{ __('site.about.mission') }}</h2>
                        <p class="mt-4 leading-relaxed text-teatrino-charcoal/80">{{ $aboutPage->t('mission') }}</p>
                    </div>
                @endif
                @if ($aboutPage->hasT('vision'))
                    <div class="rounded-3xl border border-teatrino-coral/20 bg-white p-8 shadow-sm">
                        <h2 class="text-xl font-bold text-teatrino-coral">{{ __('site.about.vision') }}</h2>
                        <p class="mt-4 leading-relaxed text-teatrino-charcoal/80">{{ $aboutPage->t('vision') }}</p>
                    </div>
                @endif
            </div>
        </section>
    @else
        <section class="mx-auto max-w-3xl px-4 py-16 sm:px-6">
            <div class="rounded-3xl border border-teatrino-teal/20 bg-white p-8 shadow-sm">
                <p class="text-teatrino-charcoal/80">{{ __('site.site.coming_soon') }}</p>
            </div>
        </section>
    @endif
@endsection
