@props(['title', 'subtitle' => null])

<section class="relative overflow-hidden bg-gradient-to-br from-teatrino-yellow/30 via-white to-teatrino-soft-blue/40">
    <div class="pointer-events-none absolute -end-16 -top-16 h-56 w-56 rounded-full bg-teatrino-coral/20 blur-3xl"></div>
    <div class="pointer-events-none absolute -bottom-10 -start-10 h-48 w-48 rounded-full bg-teatrino-teal/20 blur-3xl"></div>

    <div class="relative mx-auto max-w-6xl px-4 py-16 sm:px-6 sm:py-20">
        <h1 class="max-w-3xl text-4xl font-bold tracking-tight text-teatrino-charcoal sm:text-5xl">
            {{ $title }}
        </h1>
        @if ($subtitle)
            <p class="mt-4 max-w-2xl text-lg text-teatrino-charcoal/80">
                {{ $subtitle }}
            </p>
        @endif
    </div>
</section>
