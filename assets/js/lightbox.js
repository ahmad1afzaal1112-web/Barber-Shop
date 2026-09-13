/**
 * Kre8 Luxury Barbershop — Gallery Lightbox & Filter System
 * 
 * Features:
 * - Instant animated category filter tabs
 * - Next / Previous image navigation
 * - Keyboard shortcuts (ArrowLeft, ArrowRight, Escape)
 * - Mobile Touch Swipe support
 * - Dynamic photo counter
 */

document.addEventListener('DOMContentLoaded', () => {
    // 1. Category Filter Tabs
    const filterTabs = document.querySelectorAll('.filter-tab');
    const galleryItems = document.querySelectorAll('.gallery-card-item');

    filterTabs.forEach(tab => {
        tab.addEventListener('click', () => {
            const filterValue = tab.getAttribute('data-filter');

            filterTabs.forEach(t => {
                t.classList.remove('active');
                t.setAttribute('aria-selected', 'false');
            });
            tab.classList.add('active');
            tab.setAttribute('aria-selected', 'true');

            galleryItems.forEach(item => {
                const category = item.getAttribute('data-category');

                if (filterValue === 'all' || category === filterValue) {
                    item.style.display = '';
                    requestAnimationFrame(() => {
                        item.style.opacity = '1';
                        item.style.transform = 'scale(1)';
                    });
                } else {
                    item.style.opacity = '0';
                    item.style.transform = 'scale(0.95)';
                    setTimeout(() => {
                        item.style.display = 'none';
                    }, 250);
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
    const lightboxCounter = document.getElementById('lightbox-counter');
    const lightboxClose = document.getElementById('lightbox-close');
    const lightboxPrev = document.getElementById('lightbox-prev');
    const lightboxNext = document.getElementById('lightbox-next');

    if (!lightbox || !lightboxImg) return;

    let activeItems = [];
    let currentLightboxIndex = 0;

    function getVisibleItems() {
        return Array.from(galleryItems).filter(item => item.style.display !== 'none');
    }

    function showImageAtIndex(index) {
        activeItems = getVisibleItems();
        if (!activeItems.length) return;

        if (index < 0) index = activeItems.length - 1;
        if (index >= activeItems.length) index = 0;
        currentLightboxIndex = index;

        const currentItem = activeItems[currentLightboxIndex];
        const src = currentItem.getAttribute('data-src');
        const title = currentItem.getAttribute('data-title');
        const desc = currentItem.getAttribute('data-desc');
        const cat = currentItem.querySelector('.gallery-category-pill')?.innerText || 'PORTFOLIO';

        // Smooth image switch
        lightboxImg.style.opacity = '0';
        setTimeout(() => {
            lightboxImg.src = src;
            lightboxImg.alt = title;
            lightboxTitle.innerText = title;
            lightboxCategory.innerText = cat;
            lightboxDesc.innerText = desc;
            if (lightboxCounter) {
                lightboxCounter.innerText = `${currentLightboxIndex + 1} / ${activeItems.length}`;
            }
            lightboxImg.style.opacity = '1';
        }, 120);
    }

    // Item Click & Enter Key to Open Lightbox
    galleryItems.forEach(item => {
        item.addEventListener('click', () => {
            activeItems = getVisibleItems();
            const idx = activeItems.indexOf(item);
            showImageAtIndex(idx !== -1 ? idx : 0);
            openLightbox();
        });

        item.addEventListener('keydown', (e) => {
            if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                item.click();
            }
        });
    });

    function openLightbox() {
        lightbox.classList.add('active');
        lightbox.setAttribute('aria-hidden', 'false');
        document.body.style.overflow = 'hidden';
    }

    function closeLightbox() {
        lightbox.classList.remove('active');
        lightbox.setAttribute('aria-hidden', 'true');
        document.body.style.overflow = '';
    }

    if (lightboxClose) lightboxClose.addEventListener('click', closeLightbox);
    if (lightboxPrev) {
        lightboxPrev.addEventListener('click', (e) => {
            e.stopPropagation();
            showImageAtIndex(currentLightboxIndex - 1);
        });
    }
    if (lightboxNext) {
        lightboxNext.addEventListener('click', (e) => {
            e.stopPropagation();
            showImageAtIndex(currentLightboxIndex + 1);
        });
    }

    lightbox.addEventListener('click', (e) => {
        if (e.target === lightbox) closeLightbox();
    });

    // Keyboard Controls
    document.addEventListener('keydown', (e) => {
        if (!lightbox.classList.contains('active')) return;

        if (e.key === 'Escape') {
            closeLightbox();
        } else if (e.key === 'ArrowRight') {
            showImageAtIndex(currentLightboxIndex + 1);
        } else if (e.key === 'ArrowLeft') {
            showImageAtIndex(currentLightboxIndex - 1);
        }
    });

    // Touch Swipe Gesture for Lightbox on Mobile
    let touchStartX = 0;
    let touchEndX = 0;

    lightbox.addEventListener('touchstart', (e) => {
        touchStartX = e.changedTouches[0].screenX;
    }, { passive: true });

    lightbox.addEventListener('touchend', (e) => {
        touchEndX = e.changedTouches[0].screenX;
        const diff = touchEndX - touchStartX;
        if (Math.abs(diff) > 50) {
            if (diff < 0) {
                // Swiped Left -> Next
                showImageAtIndex(currentLightboxIndex + 1);
            } else {
                // Swiped Right -> Prev
                showImageAtIndex(currentLightboxIndex - 1);
            }
        }
    }, { passive: true });
});
