<?php
/**
 * Gallery / Portfolio Section Component
 * Kre8 Luxury Barbershop
 */

require_once __DIR__ . '/../includes/functions.php';
$gallery_items = get_gallery_items();
?>
<section class="section gallery-section" id="gallery">
    <!-- Parallax Outlined Background Text -->
    <div class="section-parallax-bg">PORTFOLIO</div>

    <div class="container">
        <!-- Section Header -->
        <div class="section-header text-center reveal reveal-up">
            <div class="section-tagline">
                <?php echo render_svg_icon('scissors'); ?>
                <span>Artisan Showcase</span>
            </div>
            <h2 class="section-title">
                Master Craftsmanship &amp; <span class="text-gold-gradient">Signature Cuts</span>
            </h2>
            <p class="section-desc">
                Explore our portfolio of bespoke fades, tailored beard profiles, and classic gentleman aesthetics crafted by our master stylists.
            </p>
        </div>

        <!-- Category Filter Tabs -->
        <div class="gallery-filter-tabs reveal reveal-up delay-1" id="gallery-filters">
            <button class="filter-tab active" data-filter="all">All Styles</button>
            <button class="filter-tab" data-filter="haircut">Haircuts</button>
            <button class="filter-tab" data-filter="beard">Beard Sculpt</button>
            <button class="filter-tab" data-filter="shave">Royal Shave</button>
            <button class="filter-tab" data-filter="styling">Styling</button>
        </div>

        <!-- 3-Column Masonry/Grid -->
        <div class="gallery-grid" id="gallery-grid">
            <?php foreach ($gallery_items as $index => $item): ?>
                <div class="gallery-item reveal reveal-zoom delay-<?php echo ($index % 3) + 1; ?>" data-category="<?php echo htmlspecialchars($item['category_slug']); ?>" data-src="<?php echo htmlspecialchars($item['image_url']); ?>" data-title="<?php echo htmlspecialchars($item['title']); ?>" data-desc="<?php echo htmlspecialchars($item['desc']); ?>">
                    <img src="<?php echo htmlspecialchars($item['image_url']); ?>" alt="<?php echo htmlspecialchars($item['title']); ?>" class="gallery-img" loading="lazy">
                    
                    <div class="gallery-overlay">
                        <div class="gallery-category-badge"><?php echo htmlspecialchars($item['category']); ?></div>
                        <h3 class="gallery-title"><?php echo htmlspecialchars($item['title']); ?></h3>
                        <p style="font-size: 0.8125rem; color: rgba(255,255,255,0.7); margin: 0;"><?php echo htmlspecialchars($item['desc']); ?></p>
                        
                        <div class="gallery-zoom-btn">
                            <?php echo render_svg_icon('search'); ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Lightbox Modal Container -->
<div class="modal-overlay" id="gallery-lightbox">
    <div class="modal-container" style="max-width: 750px; background: #111214;">
        <button class="modal-close" id="lightbox-close" aria-label="Close Lightbox">
            <?php echo render_svg_icon('close'); ?>
        </button>
        <div class="modal-body" style="flex-direction: column;">
            <div style="width: 100%; height: 460px; background: #0c0d0f; display: flex; align-items: center; justify-content: center; overflow: hidden;">
                <img src="" alt="Enlarged Portfolio Cut" id="lightbox-img" style="max-height: 100%; max-width: 100%; object-fit: contain;">
            </div>
            <div style="padding: 24px; width: 100%; border-top: 1px solid var(--color-border);">
                <div id="lightbox-category" style="font-size: 0.75rem; color: var(--color-accent); text-transform: uppercase; font-weight: 600; letter-spacing: 0.12em; margin-bottom: 4px;">CATEGORY</div>
                <h3 id="lightbox-title" style="font-size: 1.4rem; color: #fff; margin-bottom: 6px;">Title</h3>
                <p id="lightbox-desc" style="font-size: 0.9rem; color: var(--color-text-secondary); margin: 0;">Description</p>
            </div>
        </div>
    </div>
</div>
