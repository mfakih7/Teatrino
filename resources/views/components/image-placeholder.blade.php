@props([
    'class' => '',
    'icon' => '🖼️',
])

<div
    {{ $attributes->merge([
        'class' => 'flex h-full min-h-[10rem] w-full items-center justify-center bg-gradient-to-br from-teatrino-soft-blue/35 via-teatrino-cream to-teatrino-yellow/30 ' . $class,
    ]) }}
    role="img"
    aria-hidden="true"
>
    <span class="text-4xl opacity-75 drop-shadow-sm sm:text-5xl">{{ $icon }}</span>
</div>
