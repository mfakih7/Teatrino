<div
    id="content-modal"
    class="fixed inset-0 z-[70] hidden items-end justify-center p-0 sm:items-center sm:p-4"
    aria-hidden="true"
>
    <div class="absolute inset-0 bg-teatrino-charcoal/70 backdrop-blur-sm" data-modal-close></div>

    <div class="modal-panel relative w-full sm:max-w-3xl" role="dialog" aria-modal="true" aria-labelledby="content-modal-title">
        <button
            type="button"
            class="absolute end-3 top-3 z-10 rounded-full bg-white/95 p-2.5 text-teatrino-charcoal shadow-md transition hover:bg-teatrino-yellow/50 sm:end-4 sm:top-4"
            data-modal-close
            aria-label="{{ __('site.modal.close') }}"
        >
            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>

        <div id="content-modal-image-wrap" class="hidden aspect-[16/10] overflow-hidden rounded-t-3xl bg-gradient-to-br from-teatrino-soft-blue/30 to-teatrino-yellow/20 sm:aspect-[16/9]">
            <picture>
                <source id="content-modal-image-webp" type="image/webp">
                <img id="content-modal-image" src="" alt="" class="h-full w-full object-cover" loading="lazy" decoding="async">
            </picture>
        </div>

        <div class="p-5 sm:p-8">
            <p id="content-modal-meta" class="hidden text-xs font-semibold uppercase tracking-wide text-teatrino-teal"></p>
            <h2 id="content-modal-title" class="mt-2 pe-10 text-xl font-bold text-teatrino-charcoal sm:text-2xl"></h2>
            <div id="content-modal-body" class="teatrino-prose mt-4"></div>
        </div>
    </div>
</div>
