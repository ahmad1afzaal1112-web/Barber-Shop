/**
 * Kre8 Luxury Barbershop - Animated Number Counters
 */

document.addEventListener('DOMContentLoaded', () => {
    const counters = document.querySelectorAll('.counter');
    if (!counters.length) return;

    const options = {
        threshold: 0.5
    };

    const counterObserver = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const el = entry.target;
                animateCounter(el);
                observer.unobserve(el);
            }
        });
    }, options);

    counters.forEach(counter => {
        counterObserver.observe(counter);
    });

    function animateCounter(el) {
        const target = parseFloat(el.getAttribute('data-target') || el.innerText);
        const suffix = el.getAttribute('data-suffix') || '';
        const prefix = el.getAttribute('data-prefix') || '';
        const decimals = parseInt(el.getAttribute('data-decimals') || '0', 10);
        const duration = 2000;
        const startTime = performance.now();

        function updateCount(currentTime) {
            const elapsedTime = currentTime - startTime;
            const progress = Math.min(elapsedTime / duration, 1);
            
            // Ease out cubic
            const easeProgress = 1 - Math.pow(1 - progress, 3);
            const currentVal = easeProgress * target;

            if (decimals > 0) {
                el.innerText = prefix + currentVal.toFixed(decimals) + suffix;
            } else {
                el.innerText = prefix + Math.floor(currentVal) + suffix;
            }

            if (progress < 1) {
                requestAnimationFrame(updateCount);
            } else {
                el.innerText = prefix + (decimals > 0 ? target.toFixed(decimals) : target) + suffix;
            }
        }

        requestAnimationFrame(updateCount);
    }
});
