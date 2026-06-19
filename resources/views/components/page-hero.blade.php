@props(['title', 'subtitle' => null])

<section class="relative overflow-hidden bg-gradient-to-br from-teatrino-yellow/25 via-white to-teatrino-soft-blue/35">
    <div class="pointer-events-none absolute -end-16 -top-16 h-56 w-56 rounded-full bg-teatrino-coral/15 blur-3xl"></div>
    <div class="pointer-events-none absolute -bottom-10 -start-10 h-48 w-48 rounded-full bg-teatrino-teal/15 blur-3xl"></div>
    <div class="umbrella-gradient-bar absolute inset-x-0 top-0 opacity-80" aria-hidden="true"></div>

    <div class="relative teatrino-container py-12 sm:py-16 md:py-20">
        <h1 class="max-w-3xl text-3xl font-bold tracking-tight text-teatrino-charcoal sm:text-4xl md:text-5xl">
            {{ $title }}
        </h1>
        @if ($subtitle)
            <p class="mt-3 max-w-2xl text-base leading-relaxed text-teatrino-charcoal/75 sm:mt-4 sm:text-lg">
                {{ $subtitle }}
            </p>
        @endif
    </div>
</section>
