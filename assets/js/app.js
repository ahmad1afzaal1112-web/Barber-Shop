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

    // 6. Polished Floating Scroll-To-Top Control
    const backToTopBtn = document.getElementById('back-to-top');
    if (backToTopBtn) {
        window.addEventListener('scroll', () => {
            if (window.scrollY > 400) {
                backToTopBtn.classList.add('is-visible');
            } else {
                backToTopBtn.classList.remove('is-visible');
            }
        }, { passive: true });

        backToTopBtn.addEventListener('click', (e) => {
            e.preventDefault();
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
    }

    // 7. Desktop Fine-Pointer Luxury Micro-Cursor
    const finePointer = window.matchMedia('(hover: hover) and (pointer: fine)').matches;
    const reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    if (finePointer && !reducedMotion) {
        const cursorDot = document.createElement('div');
        cursorDot.className = 'custom-cursor-dot';
        const cursorRing = document.createElement('div');
        cursorRing.className = 'custom-cursor-ring';
        document.body.appendChild(cursorDot);
        document.body.appendChild(cursorRing);

        let mouseX = -100, mouseY = -100;
        let ringX = -100, ringY = -100;
        let isCursorActive = false;

        document.addEventListener('mousemove', (e) => {
            mouseX = e.clientX;
            mouseY = e.clientY;
            if (!isCursorActive) {
                isCursorActive = true;
                cursorDot.classList.add('active');
                cursorRing.classList.add('active');
            }
            cursorDot.style.transform = `translate3d(${mouseX}px, ${mouseY}px, 0)`;
        }, { passive: true });

        function animateCursorRing() {
            ringX += (mouseX - ringX) * 0.18;
            ringY += (mouseY - ringY) * 0.18;
            cursorRing.style.transform = `translate3d(${ringX}px, ${ringY}px, 0)`;
            requestAnimationFrame(animateCursorRing);
        }
        requestAnimationFrame(animateCursorRing);

        document.addEventListener('mouseleave', () => {
            cursorDot.classList.remove('active');
            cursorRing.classList.remove('active');
            isCursorActive = false;
        });

        document.addEventListener('mouseenter', () => {
            if (isCursorActive) {
                cursorDot.classList.add('active');
                cursorRing.classList.add('active');
            }
        });

        // Interactive hover feedback on clickable elements
        const interactiveSelector = 'a, button, input, select, textarea, .service-card, .pricing-card, .team-card, .gallery-card-item, .filter-tab, .testimonial-card';
        document.addEventListener('mouseover', (e) => {
            if (e.target.closest(interactiveSelector)) {
                cursorRing.classList.add('hover');
            }
        });

        document.addEventListener('mouseout', (e) => {
            if (e.target.closest(interactiveSelector)) {
                cursorRing.classList.remove('hover');
            }
        });
    }
});
