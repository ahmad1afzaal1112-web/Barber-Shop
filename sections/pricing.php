<?php
/**
 * Premium Pricing Section Component
 * Kre8 Luxury Barbershop
 * 
 * Features:
 * - 3 Signature Grooming Packages with the recommended "Signature Grooming" tier highlighted
 * - Classic Barber Menu with elegant dotted line separators
 * - Pre-selector integration with the appointment booking form
 */

require_once __DIR__ . '/../includes/functions.php';
$pricing_data = get_pricing_packages();
$tiers = $pricing_data['tiers'];
$menu_items = $pricing_data['menu'];
?>
<section class="section pricing-section" id="pricing">
    <!-- Parallax Outlined Background Text -->
    <div class="section-parallax-bg gold-stroke">PRICING</div>

    <div class="container">
        <!-- Section Header -->
        <div class="section-header text-center reveal reveal-up">
            <div class="section-tagline">
                <?php echo render_svg_icon('crown'); ?>
                <span>Transparent Rates</span>
            </div>
            <h2 class="section-title">
                Artisanal Packages &amp; <span class="text-gold-gradient">Pricing</span>
            </h2>
            <p class="section-desc">
                Choose one of our signature curated grooming tiers or select individually from our traditional à la carte menu.
            </p>
        </div>

        <!-- 3-Tier Packages Grid -->
        <div class="pricing-tiers-grid">
            <?php foreach ($tiers as $index => $tier): ?>
                <div class="pricing-card <?php echo $tier['is_popular'] ? 'is-featured' : ''; ?> reveal reveal-up delay-<?php echo $index + 1; ?>">
                    <?php if ($tier['is_popular']): ?>
                        <div class="popular-ribbon">
                            <span>RECOMMENDED</span>
                        </div>
                    <?php endif; ?>

                    <div class="pricing-card-header">
                        <span class="pricing-tier-badge"><?php echo htmlspecialchars($tier['badge']); ?></span>
                        <h3 class="pricing-tier-name"><?php echo htmlspecialchars($tier['name']); ?></h3>
                        <p class="pricing-tier-desc"><?php echo htmlspecialchars($tier['description']); ?></p>
                        
                        <div class="pricing-rate-wrap">
                            <span class="pricing-currency">$</span>
                            <span class="pricing-amount"><?php echo number_format($tier['price'], 0); ?></span>
                            <span class="pricing-period">/ <?php echo htmlspecialchars($tier['period']); ?></span>
                        </div>
                    </div>

                    <div class="pricing-card-divider"></div>

                    <ul class="pricing-features">
                        <?php foreach ($tier['features'] as $feat): ?>
                            <li class="pricing-feature-item">
                                <span class="pricing-check-icon"><?php echo render_svg_icon('check'); ?></span>
                                <span><?php echo htmlspecialchars($feat); ?></span>
                            </li>
                        <?php endforeach; ?>
                    </ul>

                    <div class="pricing-card-footer">
                        <a href="#appointment" class="btn <?php echo $tier['is_popular'] ? 'btn-primary' : 'btn-outline'; ?> select-service-btn" data-service="<?php echo htmlspecialchars($tier['name']); ?>" style="width: 100%;">
                            <span><?php echo htmlspecialchars($tier['cta_text']); ?></span>
                            <?php echo render_svg_icon('arrow-right'); ?>
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Classic Barber Menu with Dotted Leaders -->
        <div class="pricing-menu-wrap reveal reveal-up delay-3">
            <div class="pricing-menu-header text-center">
                <span class="pricing-menu-kicker">A LA CARTE GROOMING</span>
                <h3 class="pricing-menu-title">Classic Barbershop Price List</h3>
            </div>

            <div class="pricing-menu-columns">
                <?php 
                $half = ceil(count($menu_items) / 2);
                $col1 = array_slice($menu_items, 0, $half);
                $col2 = array_slice($menu_items, $half);
                ?>
                <div class="pricing-menu-col">
                    <?php foreach ($col1 as $item): ?>
                        <div class="menu-list-item">
                            <div class="menu-item-head">
                                <span class="menu-item-name"><?php echo htmlspecialchars($item['title']); ?></span>
                                <span class="menu-item-dots"></span>
                                <span class="menu-item-price"><?php echo format_price($item['price']); ?></span>
                            </div>
                            <div class="menu-item-sub">
                                <span class="menu-item-desc"><?php echo htmlspecialchars($item['desc']); ?></span>
                                <a href="#appointment" class="menu-quick-book select-service-btn" data-service="<?php echo htmlspecialchars($item['title']); ?>">Book</a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <div class="pricing-menu-col">
                    <?php foreach ($col2 as $item): ?>
                        <div class="menu-list-item">
                            <div class="menu-item-head">
                                <span class="menu-item-name"><?php echo htmlspecialchars($item['title']); ?></span>
                                <span class="menu-item-dots"></span>
                                <span class="menu-item-price"><?php echo format_price($item['price']); ?></span>
                            </div>
                            <div class="menu-item-sub">
                                <span class="menu-item-desc"><?php echo htmlspecialchars($item['desc']); ?></span>
                                <a href="#appointment" class="menu-quick-book select-service-btn" data-service="<?php echo htmlspecialchars($item['title']); ?>">Book</a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Bottom Pricing Callout -->
            <div class="pricing-bottom-notice text-center">
                <p>
                    Planning a wedding party, executive retreat, or corporate grooming session? 
                    <a href="#appointment" class="text-gold underline">Inquire about our private salon buyouts.</a>
                </p>
            </div>
        </div>
    </div>
</section>
