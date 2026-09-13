/**
 * Kre8 Luxury Barbershop - Hero Slider Controller
 */

document.addEventListener('DOMContentLoaded', () => {
    const slides = document.querySelectorAll('.hero-slide');
    const dots = document.querySelectorAll('.slider-dot');
    if (!slides.length) return;

    let currentIndex = 0;
    let slideInterval = null;
    const intervalDuration = 6000;

    function goToSlide(index) {
        slides.forEach((slide, i) => {
            if (i === index) {
                slide.classList.add('active');
            } else {
                slide.classList.remove('active');
            }
        });

        dots.forEach((dot, i) => {
            if (i === index) {
                dot.classList.add('active');
            } else {
                dot.classList.remove('active');
            }
        });

        currentIndex = index;
    }

    function nextSlide() {
        const nextIndex = (currentIndex + 1) % slides.length;
        goToSlide(nextIndex);
    }

    function startAutoplay() {
        stopAutoplay();
        slideInterval = setInterval(nextSlide, intervalDuration);
    }

    function stopAutoplay() {
        if (slideInterval) {
            clearInterval(slideInterval);
            slideInterval = null;
        }
    }

    // Dot Navigation Click Listeners
    dots.forEach((dot) => {
        dot.addEventListener('click', () => {
            const index = parseInt(dot.getAttribute('data-index'), 10);
            goToSlide(index);
            startAutoplay();
        });
    });

    // Pause on Hover
    const heroSection = document.getElementById('hero');
    if (heroSection) {
        heroSection.addEventListener('mouseenter', stopAutoplay);
        heroSection.addEventListener('mouseleave', startAutoplay);
    }

    // Touch Swipe Support
    let touchStartX = 0;
    let touchEndX = 0;

    if (heroSection) {
        heroSection.addEventListener('touchstart', (e) => {
            touchStartX = e.changedTouches[0].screenX;
        }, { passive: true });

        heroSection.addEventListener('touchend', (e) => {
            touchEndX = e.changedTouches[0].screenX;
            handleSwipe();
        }, { passive: true });
    }

    function handleSwipe() {
        const swipeThreshold = 50;
        if (touchEndX < touchStartX - swipeThreshold) {
            // Swiped left
            nextSlide();
            startAutoplay();
        } else if (touchEndX > touchStartX + swipeThreshold) {
            // Swiped right
            const prevIndex = (currentIndex - 1 + slides.length) % slides.length;
            goToSlide(prevIndex);
            startAutoplay();
        }
    }

    // Initialize Autoplay
    startAutoplay();
});
