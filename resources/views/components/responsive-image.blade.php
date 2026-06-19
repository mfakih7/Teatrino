@props([
    'media' => null,
    'src' => null,
    'webp' => null,
    'alt' => '',
    'class' => '',
    'lazy' => true,
    'sizes' => '100vw',
    'variant' => 'optimized',
    'placeholderIcon' => '🖼️',
])

@php
    $resolvedSrc = $src ?? ($media?->url($variant) ?? $media?->url('optimized') ?? $media?->url('thumbnail'));
    $resolvedWebp = $webp ?? ($variant === 'thumbnail' ? null : $media?->url('webp'));
    $resolvedAlt = $alt ?: ($media?->alt_text ?? '');
@endphp

@if ($resolvedSrc)
    <picture>
        @if ($resolvedWebp)
            <source srcset="{{ $resolvedWebp }}" type="image/webp">
        @endif
        <img
            src="{{ $resolvedSrc }}"
            @if ($lazy)
                loading="lazy"
                decoding="async"
            @endif
            class="{{ $class }}"
            alt="{{ $resolvedAlt }}"
            sizes="{{ $sizes }}"
        >
    </picture>
@else
    <x-image-placeholder :class="$class" :icon="$placeholderIcon" />
@endif
