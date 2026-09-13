/**
 * Kre8 Luxury Barbershop - FAQ Accordion Controller
 */

document.addEventListener('DOMContentLoaded', () => {
    const faqItems = document.querySelectorAll('.faq-item');
    if (!faqItems.length) return;

    faqItems.forEach(item => {
        const question = item.querySelector('.faq-question');

        question.addEventListener('click', () => {
            const isActive = item.classList.contains('active');

            // Close all other items for clean single-accordion behavior
            faqItems.forEach(otherItem => {
                otherItem.classList.remove('active');
            });

            // Toggle clicked item
            if (!isActive) {
                item.classList.add('active');
            }
        });
    });
});
