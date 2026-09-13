<?php
/**
 * Services & Pricing Section Component
 * Kre8 Luxury Barbershop
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
                Artisanal Services &amp; <span class="text-gold-gradient">Fair Pricing</span>
            </h2>
            <p class="section-desc">
                From precision scissor sculpting to revitalizing straight-razor hot shaves, every service is executed with unparalleled mastery and top-tier organic botanical formulations.
            </p>
        </div>

        <!-- 3-Column Services Grid -->
        <div class="grid grid-3">
            <?php foreach ($services as $index => $service): ?>
                <div class="service-card reveal reveal-up delay-<?php echo ($index % 3) + 1; ?>">
                    <div>
                        <div class="service-card-header">
                            <div class="service-icon-box">
                                <?php echo render_svg_icon($service['icon_name'] ?? 'scissors'); ?>
                            </div>
                            <div class="service-price-wrap">
                                <div class="service-price"><?php echo format_price($service['price']); ?></div>
                                <div class="service-duration"><?php echo htmlspecialchars($service['duration']); ?></div>
                            </div>
                        </div>

                        <h3 class="service-title"><?php echo htmlspecialchars($service['title']); ?></h3>
                        <p class="service-desc"><?php echo htmlspecialchars($service['description']); ?></p>

                        <?php if (!empty($service['features'])): ?>
                            <div class="service-features-list">
                                <?php foreach ($service['features'] as $feat): ?>
                                    <div class="service-feature-item">
                                        <?php echo render_svg_icon('check'); ?>
                                        <span><?php echo htmlspecialchars($feat); ?></span>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                    </div>

                    <a href="#appointment" class="btn btn-outline btn-sm select-service-btn" data-service="<?php echo htmlspecialchars($service['title']); ?>" style="width: 100%;">
                        <span>Book This Service</span>
                        <?php echo render_svg_icon('arrow-right'); ?>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
