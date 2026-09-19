<?php
/**
 * Gallery / Portfolio Section Component
 * Kre8 Luxury Barbershop
 * 
 * Asymmetric editorial masonry layout with category filtering and interactive lightbox.
 */

require_once __DIR__ . '/../includes/functions.php';
$gallery_items = get_gallery_items();
?>
<section class="section gallery-section" id="gallery">
    <!-- Parallax Outlined Background Text -->
    <div class="section-parallax-bg gold-stroke">PORTFOLIO</div>

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
        <div class="gallery-filter-tabs reveal reveal-up delay-1" id="gallery-filters" role="tablist" aria-label="Portfolio Filters">
            <button class="filter-tab active" data-filter="all" role="tab" aria-selected="true">All Styles</button>
            <button class="filter-tab" data-filter="haircut" role="tab" aria-selected="false">Haircuts</button>
            <button class="filter-tab" data-filter="beard" role="tab" aria-selected="false">Beard Sculpt</button>
            <button class="filter-tab" data-filter="shave" role="tab" aria-selected="false">Royal Shave</button>
            <button class="filter-tab" data-filter="styling" role="tab" aria-selected="false">Styling</button>
        </div>

        <!-- Asymmetric Editorial Gallery Grid -->
        <div class="gallery-asymmetric-grid" id="gallery-grid">
            <?php foreach ($gallery_items as $index => $item): ?>
                <div class="gallery-card-item gallery-item-<?php echo $index + 1; ?> reveal reveal-zoom delay-<?php echo ($index % 3) + 1; ?>" 
                     data-category="<?php echo htmlspecialchars($item['category_slug']); ?>" 
                     data-src="<?php echo htmlspecialchars($item['image_url']); ?>" 
                     data-title="<?php echo htmlspecialchars($item['title']); ?>" 
                     data-desc="<?php echo htmlspecialchars($item['desc']); ?>"
                     data-index="<?php echo $index; ?>"
                     tabindex="0"
                     role="button"
                     aria-label="View <?php echo htmlspecialchars($item['title']); ?>">
                    
                    <div class="gallery-card-inner reveal-image">
                        <img src="<?php echo htmlspecialchars($item['image_url']); ?>" alt="<?php echo htmlspecialchars($item['title']); ?>" class="gallery-card-img" loading="lazy">
                        
                        <div class="gallery-card-overlay">
                            <span class="gallery-category-pill"><?php echo htmlspecialchars($item['category']); ?></span>
                            <h3 class="gallery-card-title"><?php echo htmlspecialchars($item['title']); ?></h3>
                            <p class="gallery-card-desc"><?php echo htmlspecialchars($item['desc']); ?></p>
                            
                            <div class="gallery-expand-icon">
                                <?php echo render_svg_icon('search'); ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Lightbox Modal Container with Next, Prev, Close, and Counter -->
<div class="modal-overlay" id="gallery-lightbox" aria-modal="true" role="dialog" aria-hidden="true">
    <div class="modal-container lightbox-modal-container">
        <button class="modal-close" id="lightbox-close" aria-label="Close Lightbox">
            <?php echo render_svg_icon('close'); ?>
        </button>

        <!-- Navigation Arrows -->
        <button class="lightbox-nav-btn lightbox-prev-btn" id="lightbox-prev" aria-label="Previous Photo">
            <?php echo render_svg_icon('chevron-left'); ?>
        </button>
        <button class="lightbox-nav-btn lightbox-next-btn" id="lightbox-next" aria-label="Next Photo">
            <?php echo render_svg_icon('chevron-right'); ?>
        </button>

        <div class="modal-body lightbox-body-wrap">
            <div class="lightbox-media-box">
                <img src="" alt="Enlarged Barber Cut" id="lightbox-img">
            </div>
            <div class="lightbox-meta-box">
                <div class="lightbox-meta-top">
                    <span id="lightbox-category" class="lightbox-cat-badge">CATEGORY</span>
                    <span id="lightbox-counter" class="lightbox-counter">1 / 6</span>
                </div>
                <h3 id="lightbox-title" class="lightbox-title-text">Title</h3>
                <p id="lightbox-desc" class="lightbox-desc-text">Description</p>
            </div>
        </div>
    </div>
</div>
