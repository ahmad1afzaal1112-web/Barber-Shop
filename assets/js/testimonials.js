/**
 * Kre8 Luxury Barbershop — Testimonials Carousel Controller
 * 
 * Features:
 * - Autoplay (5.5s) with pause on hover
 * - Responsive items per view (2 on desktop, 1 on tablet/mobile)
 * - Next & Prev navigation arrows
 * - Interactive pagination dots
 * - Mobile Touch / Swipe gesture handling
 */

document.addEventListener('DOMContentLoaded', () => {
    const carousel = document.getElementById('testimonials-carousel');
    const track = document.getElementById('testimonials-track');
    const slides = document.querySelectorAll('.testimonial-slide');
    const prevBtn = document.getElementById('testi-prev');
    const nextBtn = document.getElementById('testi-next');
    const dotsWrap = document.getElementById('testimonials-dots');
    const dots = dotsWrap ? dotsWrap.querySelectorAll('.testimonial-dot') : [];

    if (!carousel || !track || !slides.length) return;

    let currentIndex = 0;
    let autoplayTimer = null;
    const autoplayDuration = 5500;
    let isPaused = false;

    function getItemsPerView() {
        if (window.innerWidth <= 860) return 1;
        return 2;
    }

    function getMaxIndex() {
        const perView = getItemsPerView();
        return Math.max(0, slides.length - perView);
    }

    function updateCarousel() {
        const maxIndex = getMaxIndex();
        if (currentIndex > maxIndex) currentIndex = maxIndex;
        if (currentIndex < 0) currentIndex = 0;

        const perView = getItemsPerView();
        const slideWidthPercent = 100 / perView;
        const translatePercent = currentIndex * slideWidthPercent;

        track.style.transform = `translateX(-${translatePercent}%)`;

        // Update Dots
        dots.forEach((dot, i) => {
            if (i === currentIndex) {
                dot.classList.add('active');
            } else {
                dot.classList.remove('active');
            }
        });
    }

    function nextReview() {
        const maxIndex = getMaxIndex();
        if (currentIndex >= maxIndex) {
            currentIndex = 0;
        } else {
            currentIndex++;
        }
        updateCarousel();
    }

    function prevReview() {
        const maxIndex = getMaxIndex();
        if (currentIndex <= 0) {
            currentIndex = maxIndex;
        } else {
            currentIndex--;
        }
        updateCarousel();
    }

    function startAutoplay() {
        stopAutoplay();
        if (!isPaused) {
            autoplayTimer = setInterval(nextReview, autoplayDuration);
        }
    }

    function stopAutoplay() {
        if (autoplayTimer) {
            clearInterval(autoplayTimer);
            autoplayTimer = null;
        }
    }

    if (nextBtn) {
        nextBtn.addEventListener('click', () => {
            nextReview();
            startAutoplay();
        });
    }

    if (prevBtn) {
        prevBtn.addEventListener('click', () => {
            prevReview();
            startAutoplay();
        });
    }

    dots.forEach((dot, index) => {
        dot.addEventListener('click', () => {
            currentIndex = Math.min(index, getMaxIndex());
            updateCarousel();
            startAutoplay();
        });
    });

    // Pause on Hover
    carousel.addEventListener('mouseenter', () => {
        isPaused = true;
        stopAutoplay();
    });

    carousel.addEventListener('mouseleave', () => {
        isPaused = false;
        startAutoplay();
    });

    // Mobile Swipe
    let touchStartX = 0;
    let touchEndX = 0;

    carousel.addEventListener('touchstart', (e) => {
        touchStartX = e.changedTouches[0].screenX;
    }, { passive: true });

    carousel.addEventListener('touchend', (e) => {
        touchEndX = e.changedTouches[0].screenX;
        const diff = touchEndX - touchStartX;
        if (Math.abs(diff) > 40) {
            if (diff < 0) {
                nextReview();
            } else {
                prevReview();
            }
            startAutoplay();
        }
    }, { passive: true });

    window.addEventListener('resize', () => {
        updateCarousel();
    });

    // Initialize
    updateCarousel();
    startAutoplay();
});
