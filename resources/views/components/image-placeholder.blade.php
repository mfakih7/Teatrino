@props([
    'class' => '',
    'icon' => '🖼️',
])

<div
    {{ $attributes->merge([
        'class' => 'flex h-full w-full items-center justify-center bg-gradient-to-br from-teatrino-soft-blue/40 to-teatrino-yellow/30 ' . $class,
    ]) }}
    role="img"
    aria-hidden="true"
>
    <span class="text-4xl opacity-80">{{ $icon }}</span>
</div>
