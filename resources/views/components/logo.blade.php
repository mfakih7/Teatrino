@props(['compact' => false])

<svg
    {{ $attributes->merge(['class' => ($compact ? 'h-8 w-8' : 'h-10 w-10') . ' shrink-0']) }}
    viewBox="0 0 64 64"
    fill="none"
    xmlns="http://www.w3.org/2000/svg"
    aria-hidden="true"
>
    <path d="M32 8C18 8 8 18 8 32c0 6 2 11.5 5.5 16" stroke="#2D3436" stroke-width="2.5" stroke-linecap="round"/>
    <path d="M32 8c14 0 24 10 24 24 0 6-2 11.5-5.5 16" stroke="#2D3436" stroke-width="2.5" stroke-linecap="round"/>
    <path d="M8 32h48" stroke="#2D3436" stroke-width="2.5" stroke-linecap="round"/>
    <path d="M32 48v8" stroke="#2D3436" stroke-width="2.5" stroke-linecap="round"/>
    <path d="M26 56h12" stroke="#2D3436" stroke-width="2.5" stroke-linecap="round"/>
    <path d="M14 20c6-4 12-6 18-6s12 2 18 6" fill="#FFD166"/>
    <path d="M10 26c8-5 15-8 22-8s14 3 22 8" fill="#2EC4B6"/>
    <path d="M12 32c7-4 13-6 20-6s13 2 20 6" fill="#E76F51"/>
    <path d="M16 38c6-3 11-5 16-5s10 2 16 5" fill="#FFB4A2"/>
    <circle cx="32" cy="32" r="3" fill="#2D3436"/>
</svg>
