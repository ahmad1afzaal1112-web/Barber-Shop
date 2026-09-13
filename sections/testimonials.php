<?php
/**
 * Testimonials Section Component
 * Kre8 Luxury Barbershop
 */

require_once __DIR__ . '/../includes/functions.php';
$testimonials = get_testimonials();
?>
<section class="section testimonials-section" id="testimonials">
    <!-- Parallax Outlined Background Text -->
    <div class="section-parallax-bg">REVIEWS</div>

    <div class="container">
        <!-- Section Header -->
        <div class="section-header text-center reveal reveal-up">
            <div class="section-tagline">
                <?php echo render_svg_icon('star'); ?>
                <span>Gentlemen Testimonials</span>
            </div>
            <h2 class="section-title">
                Words From Our <span class="text-gold-gradient">Distinguished Clients</span>
            </h2>
            <p class="section-desc">
                Discover why Hollywood executives, designers, and gentlemen of taste trust Kre8 for their signature grooming rituals.
            </p>
        </div>

        <!-- Testimonial Slider Grid / Cards -->
        <div class="grid grid-3" id="testimonials-grid">
            <?php foreach ($testimonials as $index => $review): ?>
                <div class="testimonial-card reveal reveal-up delay-<?php echo ($index % 3) + 1; ?>">
                    <div class="testimonial-quote-icon">
                        <?php echo render_svg_icon('quote'); ?>
                    </div>

                    <div class="rating-stars" style="margin-bottom: 20px;">
                        <?php for ($s = 0; $s < ($review['rating'] ?? 5); $s++): ?>
                            <?php echo render_svg_icon('star'); ?>
                        <?php endfor; ?>
                    </div>

                    <p class="testimonial-text">
                        “<?php echo htmlspecialchars($review['content']); ?>”
                    </p>

                    <div class="testimonial-author-row">
                        <img src="<?php echo htmlspecialchars($review['client_avatar'] ?? 'assets/images/testimonials/client-1.svg'); ?>" alt="<?php echo htmlspecialchars($review['client_name']); ?>" class="testimonial-avatar" width="54" height="54">
                        <div>
                            <div class="testimonial-name"><?php echo htmlspecialchars($review['client_name']); ?></div>
                            <div class="testimonial-role"><?php echo htmlspecialchars($review['client_role']); ?></div>
                            <div style="font-size: 0.75rem; color: var(--color-accent); margin-top: 2px;">
                                <?php echo htmlspecialchars($review['service_received']); ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
