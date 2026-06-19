<div
    id="content-modal"
    class="fixed inset-0 z-[70] hidden items-end justify-center p-0 sm:items-center sm:p-4"
    aria-hidden="true"
>
    <div class="modal-backdrop" data-modal-close></div>

    <div class="modal-panel" role="dialog" aria-modal="true" aria-labelledby="content-modal-title">
        <button
            type="button"
            class="absolute end-3 top-3 z-10 rounded-full bg-white/95 p-2.5 text-teatrino-charcoal shadow-[var(--shadow-teatrino-md)] transition duration-200 hover:bg-teatrino-yellow/60 sm:end-4 sm:top-4"
            data-modal-close
            aria-label="{{ __('site.modal.close') }}"
        >
            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>

        <div id="content-modal-image-wrap" class="hidden aspect-[16/10] overflow-hidden rounded-t-[var(--radius-teatrino-xl)] bg-gradient-to-br from-teatrino-soft-blue/30 to-teatrino-yellow/20 sm:aspect-[16/9]">
            <picture>
                <source id="content-modal-image-webp" type="image/webp">
                <img id="content-modal-image" src="" alt="" class="h-full w-full object-cover" loading="lazy" decoding="async">
            </picture>
        </div>

        <div class="p-6 sm:p-8 lg:p-10">
            <p id="content-modal-meta" class="hidden teatrino-eyebrow !text-teatrino-teal"></p>
            <h2 id="content-modal-title" class="teatrino-heading-md mt-2 pe-12"></h2>
            <div id="content-modal-body" class="teatrino-prose mt-5"></div>
        </div>
    </div>
</div>
