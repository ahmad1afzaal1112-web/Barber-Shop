/**
 * Kre8 Luxury Barbershop - Testimonials Carousel Support
 */

document.addEventListener('DOMContentLoaded', () => {
    const testimonialCards = document.querySelectorAll('.testimonial-card');
    if (!testimonialCards.length) return;

    // Hover effect highlights
    testimonialCards.forEach(card => {
        card.addEventListener('mouseenter', () => {
            card.style.transform = 'translateY(-6px)';
            card.style.borderColor = 'var(--color-border-accent)';
        });
        card.addEventListener('mouseleave', () => {
            card.style.transform = '';
            card.style.borderColor = '';
        });
    });
});
