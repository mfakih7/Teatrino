import './bootstrap';

document.addEventListener('DOMContentLoaded', () => {
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
});
