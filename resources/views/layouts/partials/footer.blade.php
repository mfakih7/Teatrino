@php
    $whatsappNumber = $siteSettings->whatsapp_number;
    $whatsappUrl = $whatsappNumber
        ? 'https://wa.me/'.preg_replace('/\D+/', '', $whatsappNumber).'?text='.urlencode($siteSettings->whatsapp_message ?? '')
        : route('contact', ['locale' => $currentLocale]);

    $socialPlatforms = [
        ['key' => 'social_facebook', 'icon' => 'facebook', 'label' => 'Facebook', 'hover' => 'hover:border-teatrino-soft-blue hover:bg-teatrino-soft-blue/20 hover:text-teatrino-soft-blue'],
        ['key' => 'social_instagram', 'icon' => 'instagram', 'label' => 'Instagram', 'hover' => 'hover:border-teatrino-coral hover:bg-teatrino-coral/20 hover:text-teatrino-coral'],
        ['key' => 'social_tiktok', 'icon' => 'tiktok', 'label' => 'TikTok', 'hover' => 'hover:border-teatrino-teal hover:bg-teatrino-teal/20 hover:text-teatrino-teal'],
        ['key' => 'social_youtube', 'icon' => 'youtube', 'label' => 'YouTube', 'hover' => 'hover:border-teatrino-yellow hover:bg-teatrino-yellow/20 hover:text-teatrino-yellow'],
    ];

    $activeSocials = collect($socialPlatforms)->filter(fn (array $platform) => filled($siteSettings->{$platform['key']}))->values();
@endphp

<footer class="mt-auto bg-teatrino-charcoal text-white">
    {{-- Umbrella gradient accent --}}
    <div class="h-1 bg-gradient-to-r from-teatrino-yellow via-teatrino-teal via-teatrino-coral to-teatrino-soft-pink" aria-hidden="true"></div>

    <div class="mx-auto max-w-6xl px-4 py-16 sm:px-6 lg:py-20">
        <div class="grid gap-12 sm:grid-cols-2 lg:grid-cols-3 lg:gap-16">
            {{-- Brand --}}
            <div class="space-y-5 sm:col-span-2 lg:col-span-1">
                <a href="{{ route('home', ['locale' => $currentLocale]) }}" class="inline-flex items-center gap-3 transition-opacity hover:opacity-90">
                    @if ($siteSettings->logoUrl())
                        <img
                            src="{{ $siteSettings->logoUrl() }}"
                            alt="{{ $siteSettings->t('website_name') ?? 'Teatrino' }}"
                            class="h-10 w-auto max-w-[9rem] object-contain"
                        >
                    @else
                        @include('components.logo', ['compact' => true])
                    @endif
                    <span class="text-xl font-bold tracking-tight">{{ $siteSettings->t('website_name') ?? 'Teatrino' }}</span>
                </a>
                <p class="max-w-sm text-sm leading-relaxed text-white/65">
                    {{ $siteSettings->t('footer_text') ?? __('site.site.tagline') }}
                </p>
            </div>

            {{-- Explore --}}
            <div>
                <h2 class="text-xs font-bold uppercase tracking-[0.2em] text-teatrino-yellow">
                    {{ __('site.footer.explore') }}
                </h2>
                <ul class="mt-5 space-y-3">
                    @foreach (['home', 'about', 'portfolio', 'articles', 'contact'] as $key)
                        <li>
                            <a
                                href="{{ route($key, ['locale' => $currentLocale]) }}"
                                @class([
                                    'group inline-flex items-center gap-2 text-sm transition',
                                    'font-semibold text-white' => request()->routeIs($key),
                                    'text-white/70 hover:text-teatrino-teal' => ! request()->routeIs($key),
                                ])
                            >
                                <span class="h-1 w-1 rounded-full bg-teatrino-teal opacity-0 transition group-hover:opacity-100" aria-hidden="true"></span>
                                {{ __('site.nav.'.$key) }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>

            {{-- Contact & social --}}
            <div>
                <h2 class="text-xs font-bold uppercase tracking-[0.2em] text-teatrino-yellow">
                    {{ __('site.footer.contact') }}
                </h2>

                <ul class="mt-5 space-y-4">
                    @if ($siteSettings->email)
                        <li>
                            <a
                                href="mailto:{{ $siteSettings->email }}"
                                class="group flex items-center gap-3 text-sm text-white/70 transition hover:text-white"
                            >
                                <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full border border-white/10 bg-white/5 text-teatrino-yellow transition group-hover:border-teatrino-yellow/40 group-hover:bg-teatrino-yellow/10">
                                    <x-site-icon name="email" class="h-4 w-4" />
                                </span>
                                <span class="break-all">{{ $siteSettings->email }}</span>
                            </a>
                        </li>
                    @endif

                    <li>
                        <a
                            href="{{ $whatsappUrl }}"
                            @if ($whatsappNumber) target="_blank" rel="noopener noreferrer" @endif
                            class="group flex items-center gap-3 text-sm text-white/70 transition hover:text-white"
                        >
                            <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full border border-white/10 bg-white/5 text-teatrino-teal transition group-hover:border-teatrino-teal/40 group-hover:bg-teatrino-teal/10">
                                <x-site-icon name="whatsapp" class="h-4 w-4" />
                            </span>
                            <span>{{ __('site.home.cta_whatsapp') }}</span>
                        </a>
                    </li>
                </ul>

                @if ($activeSocials->isNotEmpty())
                    <div class="mt-8">
                        <h3 class="text-xs font-bold uppercase tracking-[0.2em] text-teatrino-yellow">
                            {{ __('site.footer.follow_us') }}
                        </h3>
                        <ul class="mt-4 flex flex-wrap gap-3">
                            @foreach ($activeSocials as $social)
                                <li>
                                    <a
                                        href="{{ $siteSettings->{$social['key']} }}"
                                        target="_blank"
                                        rel="noopener noreferrer"
                                        aria-label="{{ $social['label'] }}"
                                        class="flex h-11 w-11 items-center justify-center rounded-full border border-white/15 bg-white/5 text-white/80 transition duration-200 hover:scale-105 hover:shadow-lg {{ $social['hover'] }}"
                                    >
                                        <x-site-icon :name="$social['icon']" class="h-4 w-4" />
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
        </div>

        {{-- Bottom bar --}}
        <div class="mt-14 flex flex-col items-center justify-between gap-4 border-t border-white/10 pt-8 text-center sm:flex-row sm:text-start">
            <p class="text-sm text-white/45">
                &copy; {{ date('Y') }} {{ $siteSettings->t('website_name') ?? 'Teatrino' }}. {{ __('site.footer.rights') }}
            </p>
            <p class="text-xs text-white/35">
                {{ __('site.footer.made_with_love') }}
            </p>
        </div>
    </div>
</footer>
