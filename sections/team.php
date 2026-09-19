<?php
/**
 * Team / Master Barbers Section Component
 * Kre8 Luxury Barbershop
 * 
 * Features:
 * - High-resolution photography portraits
 * - Name, position/role, specialty pill badge, and bio
 * - Hover state: subtle image zoom, luxury dark gradient overlay, and smooth social icon reveal
 */

require_once __DIR__ . '/../includes/functions.php';
$team = get_team_members();
?>
<section class="section team-section" id="team">
    <!-- Parallax Outlined Background Text -->
    <div class="section-parallax-bg gold-stroke">EXPERTS</div>

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
                Decades of combined master training dedicated to precision scissor craft, bespoke fades, and authentic straight-razor shaving rituals.
            </p>
        </div>

        <!-- 3-Column Team Grid -->
        <div class="team-grid">
            <?php foreach ($team as $index => $member): ?>
                <div class="team-card reveal reveal-up delay-<?php echo ($index % 3) + 1; ?>">
                    <div class="team-photo-wrap reveal-image">
                        <img src="<?php echo htmlspecialchars($member['image_url']); ?>" alt="<?php echo htmlspecialchars($member['name']); ?>" class="team-photo" loading="lazy">
                        
                        <!-- Hover Overlay with Smooth Social Links Reveal -->
                        <div class="team-photo-overlay">
                            <div class="team-social-floating">
                                <a href="<?php echo htmlspecialchars($member['social']['instagram'] ?? '#'); ?>" target="_blank" rel="noopener" aria-label="<?php echo htmlspecialchars($member['name']); ?> Instagram">
                                    <?php echo render_svg_icon('instagram'); ?>
                                </a>
                                <a href="<?php echo htmlspecialchars($member['social']['facebook'] ?? '#'); ?>" target="_blank" rel="noopener" aria-label="<?php echo htmlspecialchars($member['name']); ?> Facebook">
                                    <?php echo render_svg_icon('facebook'); ?>
                                </a>
                                <a href="<?php echo htmlspecialchars($member['social']['twitter'] ?? '#'); ?>" target="_blank" rel="noopener" aria-label="<?php echo htmlspecialchars($member['name']); ?> Twitter">
                                    <?php echo render_svg_icon('twitter'); ?>
                                </a>
                            </div>
                        </div>

                        <!-- Specialty Pill Tag -->
                        <span class="team-specialty-tag"><?php echo htmlspecialchars($member['specialty']); ?></span>
                    </div>

                    <div class="team-card-body">
                        <h3 class="team-name"><?php echo htmlspecialchars($member['name']); ?></h3>
                        <div class="team-role"><?php echo htmlspecialchars($member['role']); ?></div>
                        <p class="team-bio"><?php echo htmlspecialchars($member['bio']); ?></p>

                        <div class="team-card-footer">
                            <a href="#appointment" class="team-book-btn select-barber-btn" data-barber="<?php echo htmlspecialchars($member['name']); ?>">
                                <span>Book With <?php echo explode(' ', $member['name'])[0]; ?></span>
                                <?php echo render_svg_icon('arrow-right'); ?>
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
