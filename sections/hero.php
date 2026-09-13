<?php
/**
 * Hero Slider Section Component
 * Kre8 Luxury Barbershop
 */
?>
<section class="hero-section" id="hero">
    <!-- Background Slider Elements -->
    <div class="hero-slider" id="hero-slider">
        <!-- Slide 1 -->
        <div class="hero-slide active" data-slide="0">
            <div class="hero-slide-bg" style="background-image: url('assets/images/hero/hero-slide-1.svg');"></div>
            <div class="hero-slide-overlay"></div>
        </div>
        <!-- Slide 2 -->
        <div class="hero-slide" data-slide="1">
            <div class="hero-slide-bg" style="background-image: url('assets/images/hero/hero-slide-2.svg');"></div>
            <div class="hero-slide-overlay"></div>
        </div>
    </div>

    <!-- Hero Content Container -->
    <div class="container hero-content-wrap">
        <div class="hero-grid">
            <!-- Left Text Column -->
            <div class="hero-text-col">
                <div class="hero-badge reveal reveal-down">
                    <?php echo render_svg_icon('sparkles'); ?>
                    <span>The Gold Standard of Barbering</span>
                </div>

                <h1 class="hero-title reveal reveal-up delay-1">
                    Where Precision Meets <br>
                    <span class="text-gold-gradient">Timeless Luxury</span>
                </h1>

                <p class="hero-desc reveal reveal-up delay-2">
                    Step into an elevated grooming sanctuary where century-old razor shaving rituals merge with precision scissor mastery and bespoke masculine pampering.
                </p>

                <div class="hero-cta-group reveal reveal-up delay-3">
                    <a href="#services" class="btn btn-primary btn-lg">
                        <span>Explore Services</span>
                        <?php echo render_svg_icon('arrow-right'); ?>
                    </a>
                    <a href="#about" class="btn btn-outline btn-lg">
                        <span>Our Heritage</span>
                    </a>
                </div>
            </div>

            <!-- Right Glassmorphic Award Card -->
            <div class="hero-award-col reveal reveal-zoom delay-3">
                <div class="hero-award-card">
                    <div class="hero-award-header">
                        <div class="hero-award-icon">
                            <?php echo render_svg_icon('award'); ?>
                        </div>
                        <div>
                            <div class="hero-award-subtitle">Award Winning</div>
                            <div class="hero-award-title">Top Luxury Salon 2026</div>
                        </div>
                    </div>

                    <div class="hero-award-divider"></div>

                    <div class="hero-award-reviews">
                        <div class="avatar-cluster">
                            <div class="avatar-item"><img src="assets/images/testimonials/client-1.svg" alt="VIP Client"></div>
                            <div class="avatar-item"><img src="assets/images/testimonials/client-2.svg" alt="VIP Client"></div>
                            <div class="avatar-item"><img src="assets/images/testimonials/client-3.svg" alt="VIP Client"></div>
                            <div class="avatar-count">+2.5k</div>
                        </div>

                        <div class="hero-award-info">
                            <div class="hero-award-rating-num text-gold">4.9 ★</div>
                            <div class="hero-award-rating-text">Verified Reviews</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Slider Pagination Dots -->
    <div class="container">
        <div class="hero-controls">
            <div class="slider-dots" id="hero-dots">
                <button class="slider-dot active" data-index="0" aria-label="Slide 1"></button>
                <button class="slider-dot" data-index="1" aria-label="Slide 2"></button>
            </div>
        </div>
    </div>

    <!-- Below-Hero Stats Counter Bar -->
    <div class="container hero-stats-bar">
        <div class="stats-card reveal reveal-up delay-4">
            <div class="stat-item">
                <div class="stat-icon-wrap">
                    <?php echo render_svg_icon('star'); ?>
                </div>
                <div>
                    <div class="stat-number text-gold counter" data-target="4.9" data-decimals="1">4.9</div>
                    <div class="stat-label">Client Rating</div>
                </div>
            </div>

            <div class="stat-item">
                <div class="stat-icon-wrap">
                    <?php echo render_svg_icon('crown'); ?>
                </div>
                <div>
                    <div class="stat-number counter" data-target="15" data-suffix="+">15+</div>
                    <div class="stat-label">Years Experience</div>
                </div>
            </div>

            <div class="stat-item">
                <div class="stat-icon-wrap">
                    <?php echo render_svg_icon('scissors'); ?>
                </div>
                <div>
                    <div class="stat-number text-gold counter" data-target="25" data-suffix="k+">25k+</div>
                    <div class="stat-label">Gentlemen Groomed</div>
                </div>
            </div>

            <div class="stat-item">
                <div class="stat-icon-wrap">
                    <?php echo render_svg_icon('award'); ?>
                </div>
                <div>
                    <div class="stat-number counter" data-target="12" data-suffix="+">12+</div>
                    <div class="stat-label">Master Stylists</div>
                </div>
            </div>
        </div>
    </div>
</section>
