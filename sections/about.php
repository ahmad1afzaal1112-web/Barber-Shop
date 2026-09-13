<?php
/**
 * About Section Component
 * Kre8 Luxury Barbershop
 */
?>
<section class="section about-section" id="about">
    <!-- Parallax Outlined Background Text -->
    <div class="section-parallax-bg">ABOUT US</div>

    <div class="container">
        <div class="about-grid">
            <!-- Left Column: Composite Image Cluster & Rotating Badge -->
            <div class="about-images-col reveal reveal-left">
                <div class="about-images-wrapper">
                    <!-- Main Master Stylist Image -->
                    <img src="assets/images/about/about-1.svg" alt="Master Barber Craftsmanship" class="about-img-main" width="440" height="520">
                    
                    <!-- Secondary Razor Artwork -->
                    <img src="assets/images/about/about-2.svg" alt="Royal Shaving Ritual" class="about-img-sub float-anim" width="260" height="320">
                    
                    <!-- Tertiary Ambiance Artwork -->
                    <img src="assets/images/about/about-3.svg" alt="Barbershop Ambiance" class="about-img-sub2" width="220" height="260">

                    <!-- Continuous Rotating Circular Badge -->
                    <div class="about-badge-pos">
                        <div class="rotating-badge-wrap">
                            <svg class="rotating-badge-svg" viewBox="0 0 160 160">
                                <path id="circlePath" d="M 80, 80 m -60, 0 a 60,60 0 1,1 120,0 a 60,60 0 1,1 -120,0" fill="none" />
                                <text fill="#C9B182" font-size="10" font-family="'Inter Tight', sans-serif" font-weight="600" letter-spacing="3.5">
                                    <textPath href="#circlePath" startOffset="0%">
                                        ★ KRE8 BARBERSHOP ★ MASTER CRAFTSMEN ★
                                    </textPath>
                                </text>
                            </svg>
                            <div class="rotating-badge-center">
                                <?php echo render_svg_icon('scissors'); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column: Story & Features -->
            <div class="about-content-col reveal reveal-right delay-1">
                <div class="section-header" style="margin-bottom: 24px;">
                    <div class="section-tagline no-after">
                        <?php echo render_svg_icon('sparkles'); ?>
                        <span>About Our Sanctuary</span>
                    </div>
                    <h2 class="section-title">
                        Crafting Confidence Through <br>
                        <span class="text-gold-gradient">Master Barbering</span>
                    </h2>
                    <p class="section-desc" style="margin: 0; max-width: 100%;">
                        Founded on the tenets of old-world European barbershop excellence and modern masculine refinement, Kre8 is more than a salon—it is a bespoke haven where gentlemen decompress and emerge elevated.
                    </p>
                </div>

                <!-- Two Key Feature Cards -->
                <div class="about-features-grid">
                    <div class="about-feature-card">
                        <div class="about-feature-icon">
                            <?php echo render_svg_icon('crown'); ?>
                        </div>
                        <div class="about-feature-title">Master Craftsmen</div>
                        <p class="about-feature-desc">Every barber on our team possesses at least 8 years of rigorous training in scissor precision and straight-razor artistry.</p>
                    </div>

                    <div class="about-feature-card">
                        <div class="about-feature-icon">
                            <?php echo render_svg_icon('award'); ?>
                        </div>
                        <div class="about-feature-title">VIP Hospitality</div>
                        <p class="about-feature-desc">Enjoy complimentary single-malt scotch, artisan espresso, and heated herbal towels throughout your grooming session.</p>
                    </div>
                </div>

                <!-- Author & Signature Block -->
                <div class="about-author-row">
                    <a href="#appointment" class="btn btn-primary">
                        <span>Book an Experience</span>
                        <?php echo render_svg_icon('arrow-right'); ?>
                    </a>
                    <div>
                        <div style="font-family: var(--font-heading); font-size: 1.25rem; font-weight: 700; color: #fff;">Alexander Pierce</div>
                        <div style="font-size: 0.8rem; color: var(--color-accent); text-transform: uppercase; letter-spacing: 0.1em;">Founder &amp; Master Barber</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
