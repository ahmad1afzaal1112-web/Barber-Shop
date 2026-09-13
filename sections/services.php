<?php
/**
 * Signature Barber Services Section Component
 * Kre8 Luxury Barbershop
 * 
 * 8 Signature Services:
 * 1. Classic Haircut
 * 2. Skin Fade
 * 3. Beard Styling
 * 4. Hair & Beard Combo
 * 5. Royal Shave
 * 6. Kids Haircut
 * 7. Hair Styling
 * 8. Premium Grooming
 */

require_once __DIR__ . '/../includes/functions.php';
$services = get_services();
?>
<section class="section services-section" id="services">
    <!-- Parallax Outlined Background Text -->
    <div class="section-parallax-bg gold-stroke">SERVICES</div>

    <div class="container">
        <!-- Section Header -->
        <div class="section-header text-center reveal reveal-up">
            <div class="section-tagline">
                <?php echo render_svg_icon('scissors'); ?>
                <span>Tailored Grooming Menu</span>
            </div>
            <h2 class="section-title">
                Signature Barber <span class="text-gold-gradient">Services</span>
            </h2>
            <p class="section-desc">
                From precision scissor sculpting to revitalizing straight-razor hot shaves, every ritual is executed with master craftsmanship and organic botanical formulations.
            </p>
        </div>

        <!-- 4-Column Responsive Services Grid (8 Services) -->
        <div class="services-grid">
            <?php foreach ($services as $index => $service): ?>
                <div class="service-card reveal reveal-up delay-<?php echo ($index % 4) + 1; ?>">
                    <?php if (!empty($service['badge'])): ?>
                        <span class="service-card-badge"><?php echo htmlspecialchars($service['badge']); ?></span>
                    <?php endif; ?>

                    <div class="service-card-top">
                        <div class="service-icon-box">
                            <?php echo render_svg_icon($service['icon_name'] ?? 'scissors'); ?>
                        </div>
                        <div class="service-price-wrap">
                            <div class="service-price"><?php echo format_price($service['price']); ?></div>
                            <div class="service-duration"><?php echo htmlspecialchars($service['duration']); ?></div>
                        </div>
                    </div>

                    <div class="service-card-body">
                        <h3 class="service-title"><?php echo htmlspecialchars($service['title']); ?></h3>
                        <p class="service-desc"><?php echo htmlspecialchars($service['description']); ?></p>

                        <?php if (!empty($service['features'])): ?>
                            <ul class="service-features-list">
                                <?php foreach ($service['features'] as $feat): ?>
                                    <li class="service-feature-item">
                                        <?php echo render_svg_icon('check'); ?>
                                        <span><?php echo htmlspecialchars($feat); ?></span>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        <?php endif; ?>
                    </div>

                    <div class="service-card-footer">
                        <a href="#appointment" class="btn btn-outline btn-sm select-service-btn" data-service="<?php echo htmlspecialchars($service['title']); ?>">
                            <span>Book This Service</span>
                            <?php echo render_svg_icon('arrow-right'); ?>
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
