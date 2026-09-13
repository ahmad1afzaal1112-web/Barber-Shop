<?php
/**
 * Shop / Products Section Component
 * Kre8 Luxury Barbershop
 */

require_once __DIR__ . '/../includes/functions.php';
$products = get_products();
?>
<section class="section products-section" id="shop">
    <!-- Parallax Outlined Background Text -->
    <div class="section-parallax-bg">GROOMING</div>

    <div class="container">
        <!-- Section Header -->
        <div class="section-header text-center reveal reveal-up">
            <div class="section-tagline">
                <?php echo render_svg_icon('brush'); ?>
                <span>Apothecary &amp; Shop</span>
            </div>
            <h2 class="section-title">
                Curated Grooming <span class="text-gold-gradient">Essentials</span>
            </h2>
            <p class="section-desc">
                Bring the luxury salon experience home with our artisanal botanical formulas, clay pomades, and handcrafted grooming instruments.
            </p>
        </div>

        <!-- 4-Column Products Grid -->
        <div class="grid grid-4">
            <?php foreach ($products as $index => $prod): ?>
                <div class="product-card reveal reveal-up delay-<?php echo ($index % 4) + 1; ?>">
                    <!-- Thumbnail with Badge -->
                    <div class="product-thumb-wrap">
                        <?php if (!empty($prod['badge'])): ?>
                            <div class="product-badge-pos">
                                <span class="badge badge-gold"><?php echo htmlspecialchars($prod['badge']); ?></span>
                            </div>
                        <?php endif; ?>

                        <img src="<?php echo htmlspecialchars($prod['image_url']); ?>" alt="<?php echo htmlspecialchars($prod['name']); ?>" class="product-thumb" loading="lazy">
                    </div>

                    <!-- Product Content -->
                    <div class="product-content">
                        <div>
                            <div class="product-meta">
                                <span class="product-category"><?php echo htmlspecialchars($prod['category']); ?></span>
                                <div class="rating-stars">
                                    <?php echo render_svg_icon('star'); ?>
                                    <span style="font-size: 0.8rem; font-weight: 600; color: #fff;"><?php echo $prod['rating']; ?></span>
                                    <span style="font-size: 0.75rem; color: var(--color-text-dim);">(<?php echo $prod['reviews_count']; ?>)</span>
                                </div>
                            </div>

                            <h3 class="product-name"><?php echo htmlspecialchars($prod['name']); ?></h3>
                            
                            <div class="product-price-row">
                                <span class="product-price"><?php echo format_price($prod['price']); ?></span>
                                <?php if (!empty($prod['old_price'])): ?>
                                    <span class="product-old-price"><?php echo format_price($prod['old_price']); ?></span>
                                <?php endif; ?>
                            </div>
                        </div>

                        <button type="button" class="btn btn-outline btn-sm add-to-cart-btn" data-name="<?php echo htmlspecialchars($prod['name']); ?>" data-price="<?php echo format_price($prod['price']); ?>" style="width: 100%;">
                            <?php echo render_svg_icon('cart'); ?>
                            <span>Add to Bag</span>
                        </button>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.add-to-cart-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            const name = btn.getAttribute('data-name');
            const price = btn.getAttribute('data-price');
            if (window.showToast) {
                window.showToast(`Added <strong>${name}</strong> (${price}) to your grooming bag!`, 'success');
            }
        });
    });
});
</script>
