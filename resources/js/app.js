import './bootstrap';

document.addEventListener('DOMContentLoaded', () => {
    initScrollHeader();
    initMobileNav();
    initLanguageSwitcher();
    initContentModal();
    initRevealAnimations();
});

function initScrollHeader() {
    const header = document.getElementById('site-header');

    if (! header) {
        return;
    }

    const update = () => {
        header.classList.toggle('is-scrolled', window.scrollY > 16);
    };

    update();
    window.addEventListener('scroll', update, { passive: true });
}

function initRevealAnimations() {
    const elements = document.querySelectorAll('.reveal');

    if (! elements.length) {
        return;
    }

    if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
        elements.forEach((el) => el.classList.add('is-visible'));

        return;
    }

    const observer = new IntersectionObserver(
        (entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('is-visible');
                    observer.unobserve(entry.target);
                }
            });
        },
        { rootMargin: '0px 0px -8% 0px', threshold: 0.08 }
    );

    elements.forEach((el) => observer.observe(el));
}

function initMobileNav() {
    const toggle = document.getElementById('mobile-nav-toggle');
    const panel = document.getElementById('mobile-nav');
    const iconOpen = document.getElementById('mobile-nav-icon-open');
    const iconClose = document.getElementById('mobile-nav-icon-close');

    if (! toggle || ! panel) {
        return;
    }

    const setOpen = (open) => {
        panel.classList.toggle('hidden', ! open);
        panel.classList.toggle('is-open', open);
        toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
        iconOpen?.classList.toggle('hidden', open);
        iconClose?.classList.toggle('hidden', ! open);
        document.body.classList.toggle('overflow-hidden', open);
    };

    toggle.addEventListener('click', () => {
        setOpen(panel.classList.contains('hidden'));
    });

    panel.querySelectorAll('a').forEach((link) => {
        link.addEventListener('click', () => setOpen(false));
    });

    document.addEventListener('click', (event) => {
        if (! panel.classList.contains('hidden') && ! toggle.contains(event.target) && ! panel.contains(event.target)) {
            setOpen(false);
        }
    });

    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape' && ! panel.classList.contains('hidden')) {
            setOpen(false);
        }
    });
}

function initLanguageSwitcher() {
    document.querySelectorAll('[data-lang-switcher]').forEach((wrapper) => {
        const button = wrapper.querySelector('[data-lang-toggle]');
        const menu = wrapper.querySelector('[data-lang-menu]');

        if (! button || ! menu) {
            return;
        }

        const setOpen = (open) => {
            menu.classList.toggle('hidden', ! open);
            button.setAttribute('aria-expanded', open ? 'true' : 'false');
        };

        button.addEventListener('click', (event) => {
            event.stopPropagation();
            setOpen(menu.classList.contains('hidden'));
        });

        document.addEventListener('click', (event) => {
            if (! wrapper.contains(event.target)) {
                setOpen(false);
            }
        });

        document.addEventListener('keydown', (event) => {
            if (event.key === 'Escape') {
                setOpen(false);
            }
        });
    });
}

function initContentModal() {
    const modal = document.getElementById('content-modal');

    if (! modal) {
        return;
    }

    const modalTitle = document.getElementById('content-modal-title');
    const modalBody = document.getElementById('content-modal-body');
    const modalMeta = document.getElementById('content-modal-meta');
    const imageWrap = document.getElementById('content-modal-image-wrap');
    const modalImage = document.getElementById('content-modal-image');
    const modalImageWebp = document.getElementById('content-modal-image-webp');
    const modalPanel = modal.querySelector('.modal-panel');

    const closeModal = () => {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
        modal.setAttribute('aria-hidden', 'true');
        document.body.classList.remove('overflow-hidden');
    };

    const openModal = (trigger) => {
        modalTitle.textContent = trigger.dataset.modalTitle || '';
        const templateId = trigger.dataset.modalTemplate;
        const body = trigger.dataset.modalBody || '';
        const isHtml = trigger.dataset.modalHtml === '1';

        if (templateId) {
            const template = document.getElementById(templateId);
            modalBody.innerHTML = template?.innerHTML || '';
        } else if (isHtml) {
            modalBody.innerHTML = body;
        } else {
            modalBody.textContent = body;
        }

        if (trigger.dataset.modalMeta) {
            modalMeta.textContent = trigger.dataset.modalMeta;
            modalMeta.classList.remove('hidden');
        } else {
            modalMeta.classList.add('hidden');
        }

        const image = trigger.dataset.modalImage;
        const webp = trigger.dataset.modalImageWebp;

        if (image) {
            modalImage.src = image;
            modalImage.alt = trigger.dataset.modalTitle || '';
            if (webp) {
                modalImageWebp.srcset = webp;
                modalImageWebp.parentElement.classList.remove('hidden');
            } else {
                modalImageWebp.removeAttribute('srcset');
                modalImageWebp.parentElement.classList.add('hidden');
            }
            imageWrap.classList.remove('hidden');
        } else {
            imageWrap.classList.add('hidden');
            modalImage.removeAttribute('src');
        }

        modal.classList.remove('hidden');
        modal.classList.add('flex');
        modal.setAttribute('aria-hidden', 'false');
        document.body.classList.add('overflow-hidden');
        modalPanel?.scrollTo({ top: 0 });
    };

    document.querySelectorAll('.content-modal-trigger').forEach((trigger) => {
        trigger.addEventListener('click', () => openModal(trigger));
    });

    modal.querySelectorAll('[data-modal-close]').forEach((element) => {
        element.addEventListener('click', closeModal);
    });

    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape' && ! modal.classList.contains('hidden')) {
            closeModal();
        }
    });
}
