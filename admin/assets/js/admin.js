/**
 * Kre8 Admin Dashboard — JavaScript
 */
document.addEventListener('DOMContentLoaded', () => {
    // Sidebar toggle
    const toggle = document.getElementById('sidebarToggle');
    const sidebar = document.getElementById('adminSidebar');
    if (toggle && sidebar) {
        toggle.addEventListener('click', () => sidebar.classList.toggle('open'));
        // Close sidebar on outside click (mobile)
        document.addEventListener('click', (e) => {
            if (window.innerWidth <= 1024 && sidebar.classList.contains('open') && !sidebar.contains(e.target) && e.target !== toggle) {
                sidebar.classList.remove('open');
            }
        });
    }

    // Auto-dismiss flash alerts
    const flash = document.getElementById('flashAlert');
    if (flash) {
        setTimeout(() => {
            flash.style.opacity = '0';
            flash.style.transform = 'translateY(-10px)';
            setTimeout(() => flash.remove(), 300);
        }, 5000);
    }

    // Modal handling
    window.openModal = function(id) {
        const modal = document.getElementById(id);
        if (modal) modal.classList.add('active');
    };

    window.closeModal = function(id) {
        const modal = document.getElementById(id);
        if (modal) modal.classList.remove('active');
    };

    // Close modal on overlay click
    document.querySelectorAll('.modal-overlay').forEach(overlay => {
        overlay.addEventListener('click', (e) => {
            if (e.target === overlay) overlay.classList.remove('active');
        });
    });

    // Confirm delete
    window.confirmDelete = function(form, itemName) {
        if (confirm(`Are you sure you want to delete "${itemName}"? This action cannot be undone.`)) {
            form.submit();
        }
        return false;
    };

    // Status update inline
    document.querySelectorAll('.status-select').forEach(select => {
        select.addEventListener('change', function() {
            this.closest('form').submit();
        });
    });
});
