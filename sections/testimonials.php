<?php
/**
 * Testimonials Carousel Section Component
 * Kre8 Luxury Barbershop
 * 
 * Features:
 * - Autoplaying carousel with pause-on-hover
 * - Next / Prev arrow buttons
 * - Interactive pagination dots
 * - Mobile touch swipe support
 */

require_once __DIR__ . '/../includes/functions.php';
$testimonials = get_testimonials();
?>
<section class="section testimonials-section" id="testimonials">
    <!-- Parallax Outlined Background Text -->
    <div class="section-parallax-bg gold-stroke">REVIEWS</div>

    <div class="container">
        <!-- Section Header with Arrows -->
        <div class="testimonials-header-row reveal reveal-up">
            <div>
                <div class="section-tagline">
                    <?php echo render_svg_icon('star'); ?>
                    <span>Gentlemen Testimonials</span>
                </div>
                <h2 class="section-title" style="margin-bottom: 0;">
                    Words From Our <span class="text-gold-gradient">Distinguished Clients</span>
                </h2>
            </div>

            <!-- Carousel Controls -->
            <div class="testimonials-nav-controls">
                <button class="testi-nav-btn" id="testi-prev" aria-label="Previous Review">
                    <?php echo render_svg_icon('chevron-left'); ?>
                </button>
                <button class="testi-nav-btn" id="testi-next" aria-label="Next Review">
                    <?php echo render_svg_icon('chevron-right'); ?>
                </button>
            </div>
        </div>

        <!-- Carousel Viewport & Track -->
        <div class="testimonials-carousel-wrap reveal reveal-up delay-2" id="testimonials-carousel">
            <div class="testimonials-track" id="testimonials-track">
                <?php foreach ($testimonials as $index => $review): ?>
                    <div class="testimonial-slide" data-index="<?php echo $index; ?>">
                        <div class="testimonial-card">
                            <div class="testimonial-card-top">
                                <div class="rating-stars">
                                    <?php for ($s = 0; $s < ($review['rating'] ?? 5); $s++): ?>
                                        <?php echo render_svg_icon('star'); ?>
                                    <?php endfor; ?>
                                </div>
                                <div class="testimonial-quote-icon">
                                    <?php echo render_svg_icon('quote'); ?>
                                </div>
                            </div>

                            <p class="testimonial-text">
                                “<?php echo htmlspecialchars($review['content']); ?>”
                            </p>

                            <div class="testimonial-card-bottom">
                                <div class="testimonial-author-row">
                                    <img src="<?php echo htmlspecialchars($review['client_avatar'] ?? 'assets/images/testimonials/client-1.svg'); ?>" alt="<?php echo htmlspecialchars($review['client_name']); ?>" class="testimonial-avatar" width="52" height="52" loading="lazy">
                                    <div>
                                        <div class="testimonial-name"><?php echo htmlspecialchars($review['client_name']); ?></div>
                                        <div class="testimonial-role"><?php echo htmlspecialchars($review['client_role']); ?></div>
                                    </div>
                                </div>
                                <span class="testimonial-service-tag"><?php echo htmlspecialchars($review['service_received']); ?></span>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Carousel Pagination Dots -->
        <div class="testimonials-dots-wrap" id="testimonials-dots">
            <?php foreach ($testimonials as $index => $review): ?>
                <button class="testimonial-dot <?php echo $index === 0 ? 'active' : ''; ?>" data-index="<?php echo $index; ?>" aria-label="Review <?php echo $index + 1; ?>"></button>
            <?php endforeach; ?>
        </div>
    </div>
</section>
