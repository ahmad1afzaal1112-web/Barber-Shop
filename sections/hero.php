<?php
/**
 * Hero Slider Section Component
 * Kre8 Luxury Barbershop
 * 
 * Matches reference layout:
 * - 3 Real photography slides with Ken Burns zoom & dark cinematic gradient overlay
 * - 10% Off pill discount badge
 * - "More Than a Haircut A / Signature Grooming / Experience" headline
 * - Dual CTAs: Book Appointment (Gold) + Watch Our Video (White)
 * - Ultra Prestigious Winner glassmorphic card with laurel wreath & avatar cluster
 * - Interactive 3-slide pagination dots
 * - Below-Hero 4-metric stats counter bar
 */
?>
<section class="hero-section" id="hero">
    <!-- Cinematic Photography Background Slider -->
    <div class="hero-slider" id="hero-slider" aria-roledescription="carousel" aria-label="Luxury Barbershop Gallery">
        <!-- Slide 1: Master Barber Precision Scissor Cut -->
        <div class="hero-slide active" data-slide="0" role="group" aria-roledescription="slide" aria-label="Slide 1 of 3">
            <div class="hero-slide-bg" style="background-image: url('assets/images/hero/hero-slide-1.jpg');"></div>
            <div class="hero-slide-overlay"></div>
        </div>
        <!-- Slide 2: Royal Hot Towel Straight Razor Shave -->
        <div class="hero-slide" data-slide="1" role="group" aria-roledescription="slide" aria-label="Slide 2 of 3">
            <div class="hero-slide-bg" style="background-image: url('assets/images/hero/hero-slide-2.jpg');"></div>
            <div class="hero-slide-overlay"></div>
        </div>
        <!-- Slide 3: Bespoke Hair Styling & Beard Artistry -->
        <div class="hero-slide" data-slide="2" role="group" aria-roledescription="slide" aria-label="Slide 3 of 3">
            <div class="hero-slide-bg" style="background-image: url('assets/images/hero/hero-slide-3.jpg');"></div>
            <div class="hero-slide-overlay"></div>
        </div>
    </div>

    <!-- Hero Content Container -->
    <div class="container hero-content-wrap">
        <div class="hero-grid">
            <!-- Left Text Column -->
            <div class="hero-text-col">
                <!-- 10% Off Badge Kicker -->
                <div class="hero-kicker-badge reveal reveal-down">
                    <span class="badge-pill">10% Off</span>
                    <span class="badge-kicker-text">Your First Barber Experience</span>
                </div>

                <!-- Main Hero Headline -->
                <h1 class="hero-title reveal reveal-up delay-1">
                    More Than a Haircut A<br>
                    Signature <span class="text-gold-accent">Grooming</span><br>
                    Experience
                </h1>

                <!-- Hero Supporting Paragraph -->
                <p class="hero-desc reveal reveal-up delay-2">
                    Step into an elite grooming sanctuary where century-old straight razor rituals merge seamlessly with master scissor craftsmanship and bespoke luxury pampering.
                </p>

                <!-- Dual Action CTAs -->
                <div class="hero-cta-group reveal reveal-up delay-3">
                    <a href="#appointment" class="btn btn-gold-hero">
                        <span>Book Appointment</span>
                        <?php echo render_svg_icon('arrow-right'); ?>
                    </a>
                    <a href="#video" class="btn btn-white-hero" id="hero-watch-video">
                        <span>Watch Our Video</span>
                        <?php echo render_svg_icon('arrow-right'); ?>
                    </a>
                </div>
            </div>

            <!-- Right Glassmorphic Award Card (Reference Exact Match) -->
            <div class="hero-award-col reveal reveal-zoom delay-3">
                <div class="hero-prestigious-card">
                    <!-- Laurel Wreath & Crest -->
                    <div class="prestigious-badge-wrap">
                        <svg class="prestigious-laurel-svg" viewBox="0 0 200 90" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                            <!-- Left Laurel Branch -->
                            <path d="M45 75C35 65 30 50 32 35C33 28 36 20 42 12" stroke="#C4A97A" stroke-width="2" stroke-linecap="round"/>
                            <path d="M38 68C30 64 26 55 26 48C31 51 36 58 38 68Z" fill="#C4A97A"/>
                            <path d="M34 54C26 50 22 41 23 34C28 37 32 44 34 54Z" fill="#C4A97A"/>
                            <path d="M33 39C26 34 23 25 25 18C29 22 32 29 33 39Z" fill="#C4A97A"/>
                            <path d="M36 24C30 19 28 10 32 4C35 9 37 16 36 24Z" fill="#C4A97A"/>
                            
                            <!-- Right Laurel Branch -->
                            <path d="M155 75C165 65 170 50 168 35C167 28 164 20 158 12" stroke="#C4A97A" stroke-width="2" stroke-linecap="round"/>
                            <path d="M162 68C170 64 174 55 174 48C169 51 164 58 162 68Z" fill="#C4A97A"/>
                            <path d="M166 54C174 50 178 41 177 34C172 37 168 44 166 54Z" fill="#C4A97A"/>
                            <path d="M167 39C174 34 177 25 175 18C171 22 168 29 167 39Z" fill="#C4A97A"/>
                            <path d="M164 24C170 19 172 10 168 4C165 9 163 16 164 24Z" fill="#C4A97A"/>
                        </svg>

                        <!-- Centered Badge Text -->
                        <div class="prestigious-badge-content">
                            <span class="badge-title-ultra">ULTRA</span>
                            <span class="badge-title-prestigious">PRESTIGIOUS</span>
                            <span class="badge-scope">BEST OF THE WORLD</span>
                            <div class="badge-five-stars">★★★★★</div>
                            <span class="badge-winner-tag">WINNER</span>
                        </div>
                    </div>

                    <!-- Client Avatar Cluster -->
                    <div class="award-avatar-cluster">
                        <img src="assets/images/testimonials/client-1.svg" alt="Gentleman Client" class="award-avatar-img">
                        <img src="assets/images/testimonials/client-2.svg" alt="Gentleman Client" class="award-avatar-img">
                        <img src="assets/images/testimonials/client-3.svg" alt="Gentleman Client" class="award-avatar-img">
                        <div class="award-avatar-count">+4</div>
                    </div>

                    <!-- Award Quote -->
                    <div class="award-card-divider"></div>
                    <p class="award-quote-text">“Award Winning Barber Shop Since 2024”</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Interactive Slider Pagination Dots -->
    <div class="container hero-pagination-wrap">
        <div class="slider-dots" id="hero-dots" role="tablist" aria-label="Hero Slide Switcher">
            <button class="slider-dot active" data-index="0" role="tab" aria-selected="true" aria-label="Slide 1"></button>
            <button class="slider-dot" data-index="1" role="tab" aria-selected="false" aria-label="Slide 2"></button>
            <button class="slider-dot" data-index="2" role="tab" aria-selected="false" aria-label="Slide 3"></button>
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
