/**
 * Kre8 Luxury Barbershop - Mobile Navigation & Off-Canvas Drawer
 */

document.addEventListener('DOMContentLoaded', () => {
    const mobileToggle = document.getElementById('mobile-toggle');
    const mobileDrawer = document.getElementById('mobile-drawer');
    const mobileOverlay = document.getElementById('mobile-drawer-overlay');
    const mobileCloseBtn = document.getElementById('mobile-drawer-close');
    const mobileLinks = document.querySelectorAll('.mobile-nav-link');

    if (!mobileToggle || !mobileDrawer) return;

    function openDrawer() {
        mobileToggle.classList.add('active');
        mobileToggle.setAttribute('aria-expanded', 'true');
        mobileDrawer.classList.add('active');
        if (mobileOverlay) mobileOverlay.classList.add('active');
        document.body.style.overflow = 'hidden';
    }

    function closeDrawer() {
        mobileToggle.classList.remove('active');
        mobileToggle.setAttribute('aria-expanded', 'false');
        mobileDrawer.classList.remove('active');
        if (mobileOverlay) mobileOverlay.classList.remove('active');
        document.body.style.overflow = '';
    }

    mobileToggle.addEventListener('click', () => {
        if (mobileDrawer.classList.contains('active')) {
            closeDrawer();
        } else {
            openDrawer();
        }
    });

    if (mobileCloseBtn) {
        mobileCloseBtn.addEventListener('click', closeDrawer);
    }

    if (mobileOverlay) {
        mobileOverlay.addEventListener('click', closeDrawer);
    }

    // Close on link click
    mobileLinks.forEach(link => {
        link.addEventListener('click', closeDrawer);
    });

    // Close on Escape key
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && mobileDrawer.classList.contains('active')) {
            closeDrawer();
        }
    });
});
