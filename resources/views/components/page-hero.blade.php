@props(['title', 'subtitle' => null])

<section class="relative overflow-hidden bg-gradient-to-br from-teatrino-yellow/20 via-white to-teatrino-soft-blue/30">
    <div class="teatrino-glow -end-16 -top-16 h-56 w-56 bg-teatrino-coral/12"></div>
    <div class="teatrino-glow -bottom-10 -start-10 h-48 w-48 bg-teatrino-teal/12"></div>
    <div class="umbrella-gradient-bar absolute inset-x-0 top-0 opacity-90" aria-hidden="true"></div>

    <div class="relative teatrino-container py-14 sm:py-16 md:py-20">
        <div class="reveal max-w-3xl">
            <p class="teatrino-eyebrow">{{ __('site.site.tagline') }}</p>
            <h1 class="teatrino-heading-xl mt-3">{{ $title }}</h1>
            @if ($subtitle)
                <p class="teatrino-lead mt-4 max-w-2xl">{{ $subtitle }}</p>
            @endif
        </div>
    </div>
</section>
