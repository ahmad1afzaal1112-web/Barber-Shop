/**
 * Kre8 Luxury Barbershop - Booking Form & Service Pre-Selector
 */

document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('appointment-form');
    const serviceSelect = document.getElementById('service');
    const submitBtn = document.getElementById('submit-booking-btn');
    const submitBtnText = document.getElementById('booking-btn-text');

    // 1. Service Selection Pre-Fill from Services Cards
    document.querySelectorAll('.select-service-btn').forEach(btn => {
        btn.addEventListener('click', (e) => {
            const serviceName = btn.getAttribute('data-service');
            if (serviceSelect && serviceName) {
                for (let i = 0; i < serviceSelect.options.length; i++) {
                    if (serviceSelect.options[i].value.includes(serviceName) || serviceSelect.options[i].text.includes(serviceName)) {
                        serviceSelect.selectedIndex = i;
                        break;
                    }
                }
            }

            // Scroll to appointment form smoothly
            const apptSection = document.getElementById('appointment');
            if (apptSection) {
                const headerOffset = 90;
                const elementPosition = apptSection.getBoundingClientRect().top;
                const offsetPosition = elementPosition + window.pageYOffset - headerOffset;

                window.scrollTo({
                    top: offsetPosition,
                    behavior: 'smooth'
                });

                setTimeout(() => {
                    const firstNameInput = document.getElementById('first_name');
                    if (firstNameInput) firstNameInput.focus();
                }, 600);
            }
        });
    });

    // 2. AJAX Appointment Form Submission
    if (form) {
        form.addEventListener('submit', async (e) => {
            e.preventDefault();

            // Client-side validation check
            if (!form.checkValidity()) {
                form.reportValidity();
                return;
            }

            const formData = new FormData(form);
            const originalText = submitBtnText.innerText;

            // Loading state
            submitBtn.disabled = true;
            submitBtnText.innerText = 'Processing Reservation...';

            try {
                const response = await fetch(form.action, {
                    method: 'POST',
                    body: formData
                });

                const result = await response.json();

                if (result.success) {
                    if (window.showToast) {
                        window.showToast(result.message, 'success');
                    } else {
                        alert(result.message);
                    }
                    form.reset();
                } else {
                    if (window.showToast) {
                        window.showToast(result.message || 'Booking submission failed. Please try again.', 'error');
                    } else {
                        alert(result.message || 'Booking error');
                    }
                }
            } catch (err) {
                console.error('Booking submission error:', err);
                if (window.showToast) {
                    window.showToast('Unable to connect to booking server. Please call concierge directly.', 'error');
                }
            } finally {
                submitBtn.disabled = false;
                submitBtnText.innerText = originalText;
            }
        });
    }

    // 3. AJAX Newsletter Form Submission
    const newsletterForm = document.getElementById('newsletter-form');
    if (newsletterForm) {
        newsletterForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            const formData = new FormData(newsletterForm);

            try {
                const response = await fetch(newsletterForm.action, {
                    method: 'POST',
                    body: formData
                });
                const result = await response.json();

                if (result.success) {
                    if (window.showToast) {
                        window.showToast(result.message, 'success');
                    }
                    newsletterForm.reset();
                } else {
                    if (window.showToast) {
                        window.showToast(result.message || 'Newsletter subscription failed.', 'error');
                    }
                }
            } catch (err) {
                console.error('Newsletter error:', err);
            }
        });
    }
});
