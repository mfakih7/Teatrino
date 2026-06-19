<div
    id="content-modal"
    class="fixed inset-0 z-[70] hidden items-center justify-center p-4"
    aria-hidden="true"
>
    <div class="absolute inset-0 bg-teatrino-charcoal/70 backdrop-blur-sm" data-modal-close></div>

    <div class="relative max-h-[90vh] w-full max-w-3xl overflow-y-auto rounded-3xl bg-white shadow-2xl" role="dialog" aria-modal="true" aria-labelledby="content-modal-title">
        <button
            type="button"
            class="absolute end-4 top-4 z-10 rounded-full bg-white/90 p-2 text-teatrino-charcoal shadow hover:bg-teatrino-yellow/40"
            data-modal-close
            aria-label="{{ __('site.modal.close') }}"
        >
            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>

        <div id="content-modal-image-wrap" class="hidden aspect-[16/9] overflow-hidden rounded-t-3xl bg-teatrino-cream">
            <picture>
                <source id="content-modal-image-webp" type="image/webp">
                <img id="content-modal-image" src="" alt="" class="h-full w-full object-cover" loading="lazy">
            </picture>
        </div>

        <div class="p-6 sm:p-8">
            <p id="content-modal-meta" class="hidden text-xs font-semibold uppercase tracking-wide text-teatrino-teal"></p>
            <h2 id="content-modal-title" class="mt-2 text-2xl font-bold text-teatrino-charcoal"></h2>
            <div id="content-modal-body" class="prose prose-teatrino mt-4 max-w-none text-teatrino-charcoal/80"></div>
        </div>
    </div>
</div>
