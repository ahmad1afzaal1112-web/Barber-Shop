/**
 * Kre8 Luxury Barbershop - Scroll Reveal & Entrance Animations
 */

document.addEventListener('DOMContentLoaded', () => {
    // 1. Reduced Motion Check
    const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    const revealElements = document.querySelectorAll('.reveal, .reveal-image');

    if (!revealElements.length) return;

    if (prefersReducedMotion) {
        revealElements.forEach(el => el.classList.add('is-revealed'));
        return;
    }

    // 2. Auto-Stagger Grids if children don't have manual delay classes
    const staggeredContainers = document.querySelectorAll(
        '.services-grid, .pricing-tiers-grid, .team-grid, .gallery-asymmetric-grid, .footer-grid'
    );

    staggeredContainers.forEach(container => {
        const children = Array.from(container.children).filter(child => 
            child.classList.contains('reveal') || child.classList.contains('reveal-image')
        );

        children.forEach((child, index) => {
            const hasDelay = Array.from(child.classList).some(cls => cls.startsWith('delay-'));
            if (!hasDelay) {
                const staggerDelay = (index % 4) * 100;
                child.style.transitionDelay = `${staggerDelay}ms`;
            }
        });
    });

    // 3. Intersection Observer for Scroll Reveals
    const observerOptions = {
        root: null,
        rootMargin: '0px 0px -40px 0px',
        threshold: 0.12
    };

    const revealObserver = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('is-revealed');
                observer.unobserve(entry.target);
            }
        });
    }, observerOptions);

    revealElements.forEach(el => {
        revealObserver.observe(el);
    });

    // 4. Immediate viewport reveal trigger for above-the-fold hero elements
    requestAnimationFrame(() => {
        setTimeout(() => {
            revealElements.forEach(el => {
                const rect = el.getBoundingClientRect();
                if (rect.top < window.innerHeight && rect.bottom > 0) {
                    el.classList.add('is-revealed');
                    revealObserver.unobserve(el);
                }
            });
        }, 50);
    });
});

