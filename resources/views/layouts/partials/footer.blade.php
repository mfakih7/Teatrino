@php
    use App\Support\SiteContact;

    $whatsappUrl = SiteContact::whatsappUrl($siteSettings);
    $activeSocials = SiteContact::activeSocials($siteSettings);
@endphp

<footer class="relative mt-auto overflow-hidden bg-teatrino-charcoal text-white">
    <div class="umbrella-gradient-bar" aria-hidden="true"></div>

    <div class="teatrino-glow start-1/4 top-0 h-64 w-64 -translate-y-1/2 bg-teatrino-teal/10"></div>
    <div class="teatrino-glow end-0 bottom-0 h-72 w-72 bg-teatrino-coral/10"></div>

    <div class="relative teatrino-container py-16 sm:py-20 lg:py-24">
        <div class="grid gap-12 lg:grid-cols-12 lg:gap-16">
            <div class="space-y-6 lg:col-span-5">
                <a href="{{ route('home', ['locale' => $currentLocale]) }}" class="group inline-flex items-center gap-3 transition duration-200 hover:opacity-90">
                    @if ($siteSettings->logoUrl())
                        <img
                            src="{{ $siteSettings->logoUrl() }}"
                            alt="{{ $siteSettings->t('website_name') ?: 'Teatrino' }}"
                            class="h-12 w-auto max-w-[10rem] object-contain"
                        >
                    @else
                        @include('components.logo', ['compact' => true])
                    @endif
                    <span class="text-2xl font-bold tracking-tight">{{ $siteSettings->t('website_name') ?: 'Teatrino' }}</span>
                </a>
                <p class="max-w-sm text-sm leading-7 text-white/65 sm:text-base">
                    {{ $siteSettings->t('footer_text') ?: __('site.site.tagline') }}
                </p>
                @if ($whatsappUrl)
                    <a
                        href="{{ $whatsappUrl }}"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="teatrino-btn-secondary !border-white/20 !bg-white/10 !text-white hover:!border-white hover:!bg-white hover:!text-teatrino-teal"
                    >
                        <x-site-icon name="whatsapp" class="h-5 w-5" />
                        {{ __('site.home.cta_whatsapp') }}
                    </a>
                @endif
            </div>

            <div class="lg:col-span-3">
                <h2 class="text-xs font-bold uppercase tracking-[0.22em] text-teatrino-yellow">
                    {{ __('site.footer.explore') }}
                </h2>
                <ul class="mt-6 space-y-3.5">
                    @foreach (['home', 'about', 'teachers', 'portfolio', 'articles', 'contact'] as $key)
                        <li>
                            <a
                                href="{{ route($key, ['locale' => $currentLocale]) }}"
                                @class([
                                    'group inline-flex items-center gap-2.5 text-sm transition duration-200',
                                    'font-semibold text-white' => request()->routeIs($key),
                                    'text-white/70 hover:translate-x-0.5 hover:text-teatrino-teal rtl:hover:-translate-x-0.5' => ! request()->routeIs($key),
                                ])
                            >
                                <span class="h-1.5 w-1.5 rounded-full bg-teatrino-teal opacity-0 transition group-hover:opacity-100" aria-hidden="true"></span>
                                {{ __('site.nav.'.$key) }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>

            <div class="lg:col-span-4">
                <h2 class="text-xs font-bold uppercase tracking-[0.22em] text-teatrino-yellow">
                    {{ __('site.footer.contact') }}
                </h2>

                <ul class="mt-6 space-y-4">
                    @if ($siteSettings->email)
                        <li>
                            <a
                                href="mailto:{{ $siteSettings->email }}"
                                class="group flex items-center gap-4 text-sm text-white/70 transition duration-200 hover:text-white"
                            >
                                <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-2xl border border-white/10 bg-white/5 text-teatrino-yellow transition duration-200 group-hover:border-teatrino-yellow/40 group-hover:bg-teatrino-yellow/10">
                                    <x-site-icon name="email" class="h-4 w-4" />
                                </span>
                                <span class="break-all leading-relaxed">{{ $siteSettings->email }}</span>
                            </a>
                        </li>
                    @endif

                    @if ($whatsappUrl)
                        <li>
                            <a
                                href="{{ $whatsappUrl }}"
                                target="_blank"
                                rel="noopener noreferrer"
                                class="group flex items-center gap-4 text-sm text-white/70 transition duration-200 hover:text-white"
                            >
                                <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-2xl border border-white/10 bg-white/5 text-teatrino-teal transition duration-200 group-hover:border-teatrino-teal/40 group-hover:bg-teatrino-teal/10">
                                    <x-site-icon name="whatsapp" class="h-4 w-4" />
                                </span>
                                <span>{{ __('site.home.cta_whatsapp') }}</span>
                            </a>
                        </li>
                    @endif
                </ul>

                @if (count($activeSocials))
                    <div class="mt-10">
                        <h3 class="text-xs font-bold uppercase tracking-[0.22em] text-teatrino-yellow">
                            {{ __('site.footer.follow_us') }}
                        </h3>
                        <ul class="mt-5 flex flex-wrap gap-3">
                            @foreach ($activeSocials as $social)
                                <li>
                                    <a
                                        href="{{ $siteSettings->{$social['key']} }}"
                                        target="_blank"
                                        rel="noopener noreferrer"
                                        aria-label="{{ $social['label'] }}"
                                        class="flex h-12 w-12 items-center justify-center rounded-2xl border border-white/15 bg-white/5 text-white/85 shadow-sm transition duration-200 hover:-translate-y-0.5 hover:shadow-lg {{ $social['hover'] }}"
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

        <div class="mt-14 flex flex-col items-center justify-between gap-4 border-t border-white/10 pt-8 text-center sm:flex-row sm:text-start">
            <p class="text-sm text-white/45">
                &copy; {{ date('Y') }} {{ $siteSettings->t('website_name') ?: 'Teatrino' }}. {{ __('site.footer.rights') }}
            </p>
            <p class="text-xs text-white/35">
                {{ __('site.footer.made_with_love') }}
            </p>
        </div>
    </div>
</footer>
