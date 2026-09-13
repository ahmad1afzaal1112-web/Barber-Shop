<?php
/**
 * Blog / Latest Articles Section Component
 * Kre8 Luxury Barbershop
 */

require_once __DIR__ . '/../includes/functions.php';
$posts = get_blog_posts();
?>
<section class="section blog-section" id="blog">
    <!-- Parallax Outlined Background Text -->
    <div class="section-parallax-bg">ARTICLES</div>

    <div class="container">
        <!-- Section Header -->
        <div class="section-header text-center reveal reveal-up">
            <div class="section-tagline">
                <?php echo render_svg_icon('comb'); ?>
                <span>Grooming Gazette</span>
            </div>
            <h2 class="section-title">
                Latest Insights &amp; <span class="text-gold-gradient">Master Tips</span>
            </h2>
            <p class="section-desc">
                Expert advice from our master barbers on maintaining razor sharpness, hair texture styling, and executive grooming rituals.
            </p>
        </div>

        <!-- 3-Column Blog Grid -->
        <div class="grid grid-3">
            <?php foreach ($posts as $index => $post): ?>
                <article class="blog-card reveal reveal-up delay-<?php echo ($index % 3) + 1; ?>">
                    <div class="blog-thumb-wrap">
                        <img src="<?php echo htmlspecialchars($post['image_url']); ?>" alt="<?php echo htmlspecialchars($post['title']); ?>" class="blog-thumb" loading="lazy">
                    </div>

                    <div class="blog-content">
                        <div class="blog-meta-row">
                            <span class="badge badge-gold-outline"><?php echo htmlspecialchars($post['category']); ?></span>
                            <div class="blog-meta-item">
                                <?php echo render_svg_icon('calendar'); ?>
                                <span><?php echo date('M d, Y', strtotime($post['published_date'])); ?></span>
                            </div>
                            <div class="blog-meta-item">
                                <?php echo render_svg_icon('clock'); ?>
                                <span><?php echo htmlspecialchars($post['read_time']); ?></span>
                            </div>
                        </div>

                        <h3 class="blog-title">
                            <a href="#blog"><?php echo htmlspecialchars($post['title']); ?></a>
                        </h3>

                        <p class="blog-excerpt"><?php echo htmlspecialchars($post['excerpt']); ?></p>

                        <a href="#blog" class="btn-link">
                            <span>Read Full Article</span>
                            <?php echo render_svg_icon('arrow-right'); ?>
                        </a>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>
