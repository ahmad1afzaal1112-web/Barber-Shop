<?php
/**
 * Team / Master Barbers Section Component
 * Kre8 Luxury Barbershop
 */

require_once __DIR__ . '/../includes/functions.php';
$team = get_team_members();
?>
<section class="section team-section" id="team">
    <!-- Parallax Outlined Background Text -->
    <div class="section-parallax-bg">EXPERTS</div>

    <div class="container">
        <!-- Section Header -->
        <div class="section-header text-center reveal reveal-up">
            <div class="section-tagline">
                <?php echo render_svg_icon('crown'); ?>
                <span>Artisan Craftsmen</span>
            </div>
            <h2 class="section-title">
                Meet Our <span class="text-gold-gradient">Master Barbers</span>
            </h2>
            <p class="section-desc">
                Dedicated professionals with decades of combined European training, dedicated to precision scissor craft and authentic straight-razor mastery.
            </p>
        </div>

        <!-- 3-Column Team Grid -->
        <div class="grid grid-3">
            <?php foreach ($team as $index => $member): ?>
                <div class="team-card reveal reveal-up delay-<?php echo ($index % 3) + 1; ?>">
                    <div class="team-photo-wrap">
                        <img src="<?php echo htmlspecialchars($member['image_url']); ?>" alt="<?php echo htmlspecialchars($member['name']); ?>" class="team-photo" loading="lazy">
                    </div>

                    <div class="team-card-body">
                        <h3 class="team-name"><?php echo htmlspecialchars($member['name']); ?></h3>
                        <div class="team-role"><?php echo htmlspecialchars($member['role']); ?></div>
                        <p style="font-size: 0.875rem; color: var(--color-text-secondary); line-height: 1.6; margin-bottom: 20px;">
                            <?php echo htmlspecialchars($member['bio']); ?>
                        </p>

                        <div class="team-social-links">
                            <a href="<?php echo htmlspecialchars($member['social']['instagram'] ?? '#'); ?>" aria-label="<?php echo htmlspecialchars($member['name']); ?> Instagram">
                                <?php echo render_svg_icon('instagram'); ?>
                            </a>
                            <a href="<?php echo htmlspecialchars($member['social']['facebook'] ?? '#'); ?>" aria-label="<?php echo htmlspecialchars($member['name']); ?> Facebook">
                                <?php echo render_svg_icon('facebook'); ?>
                            </a>
                            <a href="<?php echo htmlspecialchars($member['social']['twitter'] ?? '#'); ?>" aria-label="<?php echo htmlspecialchars($member['name']); ?> Twitter">
                                <?php echo render_svg_icon('twitter'); ?>
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
