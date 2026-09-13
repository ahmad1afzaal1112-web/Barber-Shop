/**
 * Kre8 Luxury Barbershop - Main Application Controller
 */

document.addEventListener('DOMContentLoaded', () => {
    // 1. Sticky Header on Scroll
    const header = document.getElementById('site-header');
    const topBar = document.querySelector('.top-bar');
    const topBarHeight = topBar ? topBar.offsetHeight : 42;

    window.addEventListener('scroll', () => {
        if (window.scrollY > topBarHeight + 20) {
            header.classList.add('is-sticky');
        } else {
            header.classList.remove('is-sticky');
        }
    }, { passive: true });

    // 2. Smooth Scroll for Anchor Links with Header Offset
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            const targetId = this.getAttribute('href');
            if (targetId === '#' || targetId === '') return;

            const targetElement = document.querySelector(targetId);
            if (targetElement) {
                e.preventDefault();
                const headerOffset = 90;
                const elementPosition = targetElement.getBoundingClientRect().top;
                const offsetPosition = elementPosition + window.pageYOffset - headerOffset;

                window.scrollTo({
                    top: offsetPosition,
                    behavior: 'smooth'
                });
            }
        });
    });

    // 3. Active Nav Menu Highlighting on Scroll
    const sections = document.querySelectorAll('section[id]');
    const navLinks = document.querySelectorAll('.nav-link');

    function highlightNav() {
        const scrollY = window.pageYOffset;

        sections.forEach(current => {
            const sectionHeight = current.offsetHeight;
            const sectionTop = current.offsetTop - 140;
            const sectionId = current.getAttribute('id');

            if (scrollY > sectionTop && scrollY <= sectionTop + sectionHeight) {
                navLinks.forEach(link => {
                    link.parentElement.classList.remove('active');
                    if (link.getAttribute('href') === `#${sectionId}`) {
                        link.parentElement.classList.add('active');
                    }
                });
            }
        });
    }

    window.addEventListener('scroll', highlightNav, { passive: true });

    // 4. Global Toast Notification Helper
    window.showToast = function(message, type = 'success') {
        let container = document.getElementById('toast-container');
        if (!container) {
            container = document.createElement('div');
            container.id = 'toast-container';
            container.className = 'toast-container';
            document.body.appendChild(container);
        }

        const toast = document.createElement('div');
        toast.className = `toast toast-${type}`;
        toast.innerHTML = `
            <div class="toast-icon">
                ${type === 'success' ? '✓' : 'ℹ'}
            </div>
            <div class="toast-message">${message}</div>
        `;

        container.appendChild(toast);

        // Trigger transition
        setTimeout(() => toast.classList.add('show'), 50);

        // Remove after 4.5 seconds
        setTimeout(() => {
            toast.classList.remove('show');
            setTimeout(() => toast.remove(), 400);
        }, 4500);
    };

    // 5. Video CTA Modal Popup Handler
    const videoBtn = document.getElementById('play-video-btn');
    const heroVideoBtn = document.getElementById('hero-watch-video');
    const videoModal = document.getElementById('video-modal');
    const videoClose = document.getElementById('video-modal-close');
    const videoFrame = document.getElementById('video-frame');

    function openVideoModal(e) {
        if (e) e.preventDefault();
        if (videoModal) {
            videoModal.classList.add('active');
            if (videoFrame) {
                videoFrame.src = 'https://www.youtube.com/embed/dQw4w9WgXcQ?autoplay=1';
            }
            document.body.style.overflow = 'hidden';
        }
    }

    function closeVideoModal() {
        if (videoModal) {
            videoModal.classList.remove('active');
            if (videoFrame) {
                videoFrame.src = '';
            }
            document.body.style.overflow = '';
        }
    }

    if (videoBtn) videoBtn.addEventListener('click', openVideoModal);
    if (heroVideoBtn) heroVideoBtn.addEventListener('click', openVideoModal);
    if (videoClose) videoClose.addEventListener('click', closeVideoModal);
    if (videoModal) {
        videoModal.addEventListener('click', (e) => {
            if (e.target === videoModal) closeVideoModal();
        });
    }
});
