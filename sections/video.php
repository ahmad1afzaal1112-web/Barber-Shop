<?php
/**
 * Video CTA Section Component
 * Kre8 Luxury Barbershop
 */
?>
<section class="video-section" id="video" style="background-image: url('assets/images/video/video-bg.jpg');">
    <div class="video-overlay"></div>

    <div class="container video-content reveal reveal-zoom">
        <!-- Pulsing Play Button -->
        <div class="video-play-wrap">
            <button class="play-btn-pulse" id="play-video-btn" aria-label="Play Salon Experience Video">
                <?php echo render_svg_icon('play'); ?>
            </button>
        </div>

        <div class="section-tagline" style="color: var(--color-accent); margin-bottom: 16px;">
            <?php echo render_svg_icon('sparkles'); ?>
            <span>Craftsmanship &amp; Heritage</span>
        </div>

        <h2 class="section-title" style="font-size: clamp(2.2rem, 4.2vw, 3.4rem); margin-bottom: 20px;">
            Immerse Yourself in the Ritual of <br>
            <span class="text-gold-gradient">Master Barbering</span>
        </h2>

        <p class="section-desc" style="max-width: 640px; margin-bottom: 32px;">
            Witness our master artisans in action as they sculpt timeless fades, razor-sharp beard contours, and restorative steaming towel rituals.
        </p>

        <a href="#appointment" class="btn btn-primary">
            <span>Book Your VIP Experience</span>
            <?php echo render_svg_icon('arrow-right'); ?>
        </a>
    </div>
</section>

<!-- Video Popup Modal -->
<div class="modal-overlay" id="video-modal">
    <div class="modal-container" style="max-width: 860px;">
        <button class="modal-close" id="video-modal-close" aria-label="Close Video">
            <?php echo render_svg_icon('close'); ?>
        </button>
        <div class="modal-body">
            <div class="modal-video-wrap">
                <iframe id="video-frame" src="" title="Barbershop Experience" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
            </div>
        </div>
    </div>
</div>
