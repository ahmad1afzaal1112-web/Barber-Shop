<?php
/**
 * FAQ Section Component
 * Kre8 Luxury Barbershop
 */

require_once __DIR__ . '/../includes/functions.php';
$faqs = get_faqs();
$config = get_app_config();
?>
<section class="section faq-section" id="faq">
    <!-- Parallax Outlined Background Text -->
    <div class="section-parallax-bg">QUESTIONS</div>

    <div class="container">
        <!-- Section Header -->
        <div class="section-header text-center reveal reveal-up">
            <div class="section-tagline">
                <?php echo render_svg_icon('sparkles'); ?>
                <span>Common Questions</span>
            </div>
            <h2 class="section-title">
                Frequently Asked <span class="text-gold-gradient">Inquiries</span>
            </h2>
            <p class="section-desc">
                Everything you need to know about our reservation process, organic products, arrival etiquette, and salon amenities.
            </p>
        </div>

        <div class="faq-grid">
            <!-- Left FAQ Accordion List -->
            <div class="faq-list reveal reveal-left">
                <?php foreach ($faqs as $index => $faq): ?>
                    <div class="faq-item <?php echo $index === 0 ? 'active' : ''; ?>">
                        <div class="faq-question">
                            <span class="faq-question-text"><?php echo htmlspecialchars($faq['question']); ?></span>
                            <div class="faq-toggle-icon">
                                <?php echo render_svg_icon('chevron-down'); ?>
                            </div>
                        </div>
                        <div class="faq-answer">
                            <p style="margin: 0;"><?php echo htmlspecialchars($faq['answer']); ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- Right FAQ Visual & Direct Help Card -->
            <div class="faq-promo-col reveal reveal-right delay-1">
                <div class="card-luxury" style="padding: 0; overflow: hidden; text-align: center;">
                    <img src="assets/images/faq/faq-banner.svg" alt="Got Questions" style="width: 100%; height: auto;">
                    <div style="padding: 30px;">
                        <h3 style="font-size: 1.4rem; color: #fff; margin-bottom: 8px;">Still Have Questions?</h3>
                        <p style="font-size: 0.875rem; color: var(--color-text-secondary); margin-bottom: 20px;">
                            Our dedicated front desk concierge is ready to assist with custom event bookings, group grooming, or styling consultations.
                        </p>
                        <a href="tel:<?php echo htmlspecialchars($config['phone_clean']); ?>" class="btn btn-primary" style="width: 100%;">
                            <?php echo render_svg_icon('phone'); ?>
                            <span>Call <?php echo htmlspecialchars($config['phone']); ?></span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
