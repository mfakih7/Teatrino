@extends('layouts.app')

@section('title', __('site.pages.teachers.title'))

@section('content')
    <x-page-hero
        :title="__('site.pages.teachers.title')"
        :subtitle="__('site.pages.teachers.subtitle')"
    />

    <section class="teatrino-section teatrino-section-muted teatrino-container">
        <div class="reveal mb-10 text-center sm:mb-12">
            <p class="teatrino-eyebrow">{{ __('site.teachers.eyebrow') }}</p>
            <p class="teatrino-lead mx-auto mt-2 max-w-2xl">{{ __('site.teachers.lead') }}</p>
        </div>

        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 sm:gap-7 xl:grid-cols-3">
            @forelse ($teachers as $index => $teacher)
                @php
                    $image = $teacher->image();
                    $accent = ['teal', 'coral', 'yellow', 'soft-blue'][$index % 4];
                @endphp
                <article @class(['teacher-card reveal', 'reveal-delay-'.min(($index % 4) + 1, 4), 'teacher-card--'.$accent])>
                    <div class="teacher-card-photo">
                        <x-responsive-image
                            :media="$image"
                            variant="thumbnail"
                            :alt="$teacher->t('name')"
                            placeholder-icon="👩‍🏫"
                            class="h-full w-full object-cover"
                            sizes="(max-width: 640px) 100vw, (max-width: 1280px) 50vw, 33vw"
                        />
                    </div>

                    <div class="teacher-card-body">
                        <h2 class="teacher-card-name">{{ $teacher->t('name') }}</h2>

                        @if ($teacher->hasT('position'))
                            <p class="teacher-card-position">{{ $teacher->t('position') }}</p>
                        @endif

                        @if ($teacher->hasT('description'))
                            <p class="teacher-card-description">{{ $teacher->t('description') }}</p>
                        @endif

                        @if ($teacher->hasT('education'))
                            <div class="teacher-card-education">
                                <p class="teacher-card-education-label">{{ __('site.teachers.education') }}</p>
                                <p class="teacher-card-education-text">{{ $teacher->t('education') }}</p>
                            </div>
                        @endif
                    </div>
                </article>
            @empty
                <div class="teatrino-empty col-span-full reveal">
                    <div class="teatrino-empty-icon" aria-hidden="true">👩‍🏫</div>
                    <p class="text-teatrino-charcoal/60">{{ __('site.site.coming_soon') }}</p>
                </div>
            @endforelse
        </div>
    </section>
@endsection
