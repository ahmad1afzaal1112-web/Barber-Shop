/**
 * Kre8 Luxury Barbershop - Gallery Lightbox & Filter System
 */

document.addEventListener('DOMContentLoaded', () => {
    // 1. Category Filter Tabs
    const filterTabs = document.querySelectorAll('.filter-tab');
    const galleryItems = document.querySelectorAll('.gallery-item');

    filterTabs.forEach(tab => {
        tab.addEventListener('click', () => {
            const filterValue = tab.getAttribute('data-filter');

            filterTabs.forEach(t => t.classList.remove('active'));
            tab.classList.add('active');

            galleryItems.forEach(item => {
                const category = item.getAttribute('data-category');

                if (filterValue === 'all' || category === filterValue) {
                    item.style.display = 'block';
                    setTimeout(() => {
                        item.style.opacity = '1';
                        item.style.transform = 'scale(1)';
                    }, 50);
                } else {
                    item.style.opacity = '0';
                    item.style.transform = 'scale(0.95)';
                    setTimeout(() => {
                        item.style.display = 'none';
                    }, 300);
                }
            });
        });
    });

    // 2. Lightbox Modal Controller
    const lightbox = document.getElementById('gallery-lightbox');
    const lightboxImg = document.getElementById('lightbox-img');
    const lightboxTitle = document.getElementById('lightbox-title');
    const lightboxCategory = document.getElementById('lightbox-category');
    const lightboxDesc = document.getElementById('lightbox-desc');
    const lightboxClose = document.getElementById('lightbox-close');

    if (!lightbox || !lightboxImg) return;

    galleryItems.forEach(item => {
        item.addEventListener('click', () => {
            const src = item.getAttribute('data-src');
            const title = item.getAttribute('data-title');
            const desc = item.getAttribute('data-desc');
            const cat = item.querySelector('.gallery-category-badge')?.innerText || 'PORTFOLIO';

            lightboxImg.src = src;
            lightboxTitle.innerText = title;
            lightboxCategory.innerText = cat;
            lightboxDesc.innerText = desc;

            lightbox.classList.add('active');
            document.body.style.overflow = 'hidden';
        });
    });

    function closeLightbox() {
        lightbox.classList.remove('active');
        document.body.style.overflow = '';
    }

    if (lightboxClose) lightboxClose.addEventListener('click', closeLightbox);
    lightbox.addEventListener('click', (e) => {
        if (e.target === lightbox) closeLightbox();
    });

    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && lightbox.classList.contains('active')) {
            closeLightbox();
        }
    });
});
