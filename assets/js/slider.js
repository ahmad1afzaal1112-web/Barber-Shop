/**
 * Kre8 Luxury Barbershop — Hero Slider Controller
 * 
 * Features:
 * - 3 Photography Slides with Ken Burns zoom
 * - Smooth crossfade transitions without layout shifting
 * - Autoplay (6.5s interval) with pause on hover & focus
 * - Keyboard navigation (ArrowLeft, ArrowRight)
 * - Mobile Touch / Swipe gesture recognition
 * - Accessible pagination tabs with aria-selected sync
 */

document.addEventListener('DOMContentLoaded', () => {
    const heroSection = document.getElementById('hero');
    const slides = document.querySelectorAll('.hero-slide');
    const dots = document.querySelectorAll('.slider-dot');
    
    if (!slides.length) return;

    let currentIndex = 0;
    let slideInterval = null;
    const intervalDuration = 6500;
    let isPaused = false;

    /**
     * Switch to a specific slide index
     */
    function goToSlide(index) {
        if (index < 0) index = slides.length - 1;
        if (index >= slides.length) index = 0;

        slides.forEach((slide, i) => {
            const isActive = (i === index);
            if (isActive) {
                slide.classList.add('active');
                slide.setAttribute('aria-hidden', 'false');
            } else {
                slide.classList.remove('active');
                slide.setAttribute('aria-hidden', 'true');
            }
        });

        dots.forEach((dot, i) => {
            const isActive = (i === index);
            if (isActive) {
                dot.classList.add('active');
                dot.setAttribute('aria-selected', 'true');
                dot.setAttribute('tabindex', '0');
            } else {
                dot.classList.remove('active');
                dot.setAttribute('aria-selected', 'false');
                dot.setAttribute('tabindex', '-1');
            }
        });

        currentIndex = index;
    }

    /**
     * Advance to the next slide
     */
    function nextSlide() {
        goToSlide(currentIndex + 1);
    }

    /**
     * Return to the previous slide
     */
    function prevSlide() {
        goToSlide(currentIndex - 1);
    }

    /**
     * Start automatic cycling
     */
    function startAutoplay() {
        stopAutoplay();
        if (!isPaused) {
            slideInterval = setInterval(nextSlide, intervalDuration);
        }
    }

    /**
     * Stop automatic cycling
     */
    function stopAutoplay() {
        if (slideInterval) {
            clearInterval(slideInterval);
            slideInterval = null;
        }
    }

    // Dot Navigation Click & Key Listeners
    dots.forEach((dot) => {
        dot.addEventListener('click', () => {
            const index = parseInt(dot.getAttribute('data-index'), 10);
            if (!isNaN(index)) {
                goToSlide(index);
                startAutoplay();
            }
        });

        dot.addEventListener('keydown', (e) => {
            if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                dot.click();
            }
        });
    });

    // Pause on Hover
    if (heroSection) {
        heroSection.addEventListener('mouseenter', () => {
            isPaused = true;
            stopAutoplay();
        });

        heroSection.addEventListener('mouseleave', () => {
            isPaused = false;
            startAutoplay();
        });

        // Pause when focus enters hero
        heroSection.addEventListener('focusin', () => {
            isPaused = true;
            stopAutoplay();
        });

        heroSection.addEventListener('focusout', () => {
            isPaused = false;
            startAutoplay();
        });
    }

    // Keyboard Accessibility (ArrowLeft & ArrowRight)
    document.addEventListener('keydown', (e) => {
        // Only respond if active element is not an input or textarea
        const activeTag = document.activeElement ? document.activeElement.tagName.toLowerCase() : '';
        if (activeTag === 'input' || activeTag === 'textarea' || activeTag === 'select') return;

        if (e.key === 'ArrowRight') {
            nextSlide();
            startAutoplay();
        } else if (e.key === 'ArrowLeft') {
            prevSlide();
            startAutoplay();
        }
    });

    // Touch / Swipe Gesture Support for Mobile Devices
    let touchStartX = 0;
    let touchStartY = 0;
    let touchEndX = 0;
    let touchEndY = 0;

    if (heroSection) {
        heroSection.addEventListener('touchstart', (e) => {
            touchStartX = e.changedTouches[0].screenX;
            touchStartY = e.changedTouches[0].screenY;
        }, { passive: true });

        heroSection.addEventListener('touchend', (e) => {
            touchEndX = e.changedTouches[0].screenX;
            touchEndY = e.changedTouches[0].screenY;
            handleGesture();
        }, { passive: true });
    }

    function handleGesture() {
        const diffX = touchEndX - touchStartX;
        const diffY = touchEndY - touchStartY;
        const swipeThreshold = 45;

        // Ensure horizontal swipe is dominant over vertical scroll
        if (Math.abs(diffX) > Math.abs(diffY) && Math.abs(diffX) > swipeThreshold) {
            if (diffX < 0) {
                // Swiped Left -> Next Slide
                nextSlide();
                startAutoplay();
            } else {
                // Swiped Right -> Prev Slide
                prevSlide();
                startAutoplay();
            }
        }
    }

    // Initialize Autoplay
    startAutoplay();
});
