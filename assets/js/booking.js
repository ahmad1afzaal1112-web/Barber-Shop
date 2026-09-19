/**
 * Kre8 Luxury Barbershop - Booking Form & Dynamic Slot Selector
 */

document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('appointment-form');
    const serviceSelect = document.getElementById('service');
    const barberSelect = document.getElementById('barber');
    const dateInput = document.getElementById('appointment_date');
    const timeSelect = document.getElementById('appointment_time');
    const submitBtn = document.getElementById('submit-booking-btn');
    const submitBtnText = document.getElementById('booking-btn-text');

    // 1. Fetch available slots from backend API
    async function fetchAvailableSlots() {
        if (!dateInput || !timeSelect) return;

        const dateVal = dateInput.value;
        if (!dateVal) return;

        const barberVal = barberSelect ? barberSelect.value : '';
        const serviceVal = serviceSelect ? serviceSelect.value : '';

        // Store currently selected time
        const currentTime = timeSelect.value;
        timeSelect.disabled = true;

        try {
            const params = new URLSearchParams({
                date: dateVal,
                barber: barberVal,
                service: serviceVal
            });

            const res = await fetch(`api/get-available-slots.php?${params.toString()}`);
            const data = await res.json();

            timeSelect.innerHTML = '';

            if (data.success && data.slots && data.slots.length > 0) {
                data.slots.forEach(slot => {
                    const opt = document.createElement('option');
                    opt.value = slot.time_display;
                    opt.textContent = slot.time_display;
                    if (slot.time_display === currentTime) {
                        opt.selected = true;
                    }
                    timeSelect.appendChild(opt);
                });
                timeSelect.disabled = false;
            } else {
                const opt = document.createElement('option');
                opt.value = '';
                opt.textContent = data.message || 'No slots available for this date';
                timeSelect.appendChild(opt);
                timeSelect.disabled = true;
            }
        } catch (err) {
            console.error('Error fetching time slots:', err);
            timeSelect.disabled = false;
        }
    }

    // Bind listeners for dynamic slot refresh
    if (dateInput) {
        dateInput.addEventListener('change', fetchAvailableSlots);
    }
    if (barberSelect) {
        barberSelect.addEventListener('change', fetchAvailableSlots);
    }
    if (serviceSelect) {
        serviceSelect.addEventListener('change', fetchAvailableSlots);
    }

    // Initial fetch on page load
    if (dateInput && dateInput.value) {
        fetchAvailableSlots();
    }

    // 2. Service Selection Pre-Fill from Services Cards
    document.querySelectorAll('.select-service-btn').forEach(btn => {
        btn.addEventListener('click', (e) => {
            const serviceName = btn.getAttribute('data-service');
            if (serviceSelect && serviceName) {
                for (let i = 0; i < serviceSelect.options.length; i++) {
                    if (serviceSelect.options[i].value.includes(serviceName) || serviceSelect.options[i].text.includes(serviceName)) {
                        serviceSelect.selectedIndex = i;
                        fetchAvailableSlots();
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

    // 3. Barber Selection Pre-Fill from Team Cards
    document.querySelectorAll('.select-barber-btn').forEach(btn => {
        btn.addEventListener('click', (e) => {
            const barberName = btn.getAttribute('data-barber');
            if (barberSelect && barberName) {
                for (let i = 0; i < barberSelect.options.length; i++) {
                    if (barberSelect.options[i].value.includes(barberName) || barberSelect.options[i].text.includes(barberName)) {
                        barberSelect.selectedIndex = i;
                        fetchAvailableSlots();
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

    // 4. AJAX Appointment Form Submission
    if (form) {
        form.addEventListener('submit', async (e) => {
            e.preventDefault();

            // Client-side validation check
            if (!form.checkValidity()) {
                form.reportValidity();
                return;
            }

            const formData = new FormData(form);
            const originalText = submitBtnText ? submitBtnText.innerText : 'Confirm VIP Appointment';

            // Loading state
            if (submitBtn) submitBtn.disabled = true;
            if (submitBtnText) submitBtnText.innerText = 'Processing Reservation...';

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
                    fetchAvailableSlots();
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
                if (submitBtn) submitBtn.disabled = false;
                if (submitBtnText) submitBtnText.innerText = originalText;
            }
        });
    }

    // 5. AJAX Newsletter Form Submission
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

    // 6. Contact Form Submission (if present)
    const contactForm = document.getElementById('contact-form');
    if (contactForm) {
        contactForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            const formData = new FormData(contactForm);

            try {
                const response = await fetch(contactForm.action || 'api/contact.php', {
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
                    contactForm.reset();
                } else {
                    if (window.showToast) {
                        window.showToast(result.message || 'Message submission failed.', 'error');
                    }
                }
            } catch (err) {
                console.error('Contact form error:', err);
            }
        });
    }
});
