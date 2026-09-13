<?php
/**
 * Footer Component
 * Kre8 Luxury Barbershop
 */

require_once __DIR__ . '/functions.php';
$config = get_app_config();
$services = get_services();
?>
    <!-- Site Footer -->
    <footer class="site-footer">
        <div class="container">
            <div class="footer-grid">
                <!-- Col 1: Brand & Bio -->
                <div>
                    <a href="#hero" class="footer-logo" aria-label="Kre8 Home">
                        <img src="assets/images/logo.svg" alt="Kre8 Barbershop" width="170" height="42">
                    </a>
                    <p class="footer-about-text">
                        The ultimate grooming destination for gentlemen of distinction. Dedicated to precision scissor mastery, royal straight razor shaves, and luxury lounge hospitality.
                    </p>
                    <div class="footer-social-row">
                        <a href="<?php echo htmlspecialchars($config['social']['instagram']); ?>" class="footer-social-btn" target="_blank" rel="noopener" aria-label="Instagram">
                            <?php echo render_svg_icon('instagram'); ?>
                        </a>
                        <a href="<?php echo htmlspecialchars($config['social']['facebook']); ?>" class="footer-social-btn" target="_blank" rel="noopener" aria-label="Facebook">
                            <?php echo render_svg_icon('facebook'); ?>
                        </a>
                        <a href="<?php echo htmlspecialchars($config['social']['twitter']); ?>" class="footer-social-btn" target="_blank" rel="noopener" aria-label="Twitter">
                            <?php echo render_svg_icon('twitter'); ?>
                        </a>
                        <a href="<?php echo htmlspecialchars($config['social']['youtube']); ?>" class="footer-social-btn" target="_blank" rel="noopener" aria-label="YouTube">
                            <?php echo render_svg_icon('youtube'); ?>
                        </a>
                    </div>
                </div>

                <!-- Col 2: Quick Links -->
                <div>
                    <h3 class="footer-title">Quick Links</h3>
                    <ul class="footer-links-list">
                        <li><a href="#hero">Home</a></li>
                        <li><a href="#services">Barber Services</a></li>
                        <li><a href="#pricing">Pricing Packages</a></li>
                        <li><a href="#video">Craftsmanship Reel</a></li>
                        <li><a href="#appointment">VIP Reservation</a></li>
                        <li><a href="#gallery">Artisan Portfolio</a></li>
                        <li><a href="#team">Master Barbers</a></li>
                        <li><a href="#testimonials">Client Endorsements</a></li>
                    </ul>
                </div>

                <!-- Col 3: Signature Services -->
                <div>
                    <h3 class="footer-title">Signature Services</h3>
                    <ul class="footer-links-list">
                        <?php foreach (array_slice($services, 0, 5) as $srv): ?>
                            <li>
                                <a href="#services" class="select-service-btn" data-service="<?php echo htmlspecialchars($srv['title']); ?>">
                                    <?php echo htmlspecialchars($srv['title']); ?>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>

                <!-- Col 4: Newsletter & Opening Hours -->
                <div>
                    <h3 class="footer-title">Exclusive Gazette</h3>
                    <p style="font-size: 0.85rem; color: var(--color-text-secondary); margin-bottom: 16px;">
                        Subscribe for seasonal styling guides, VIP event invitations, and new product releases.
                    </p>

                    <form id="newsletter-form" action="api/newsletter.php" method="POST" class="footer-newsletter-form">
                        <input type="email" name="email" class="form-control" placeholder="Enter your email" required>
                        <button type="submit" class="btn btn-primary btn-sm" aria-label="Subscribe to Gazette">
                            <?php echo render_svg_icon('arrow-right'); ?>
                        </button>
                    </form>

                    <div class="footer-hours-box">
                        <div style="font-weight: 600; color: var(--color-accent); margin-bottom: 6px;">Lounge Hours:</div>
                        <div>Mon - Fri: 09:00 AM - 08:00 PM</div>
                        <div>Sat - Sun: 09:00 AM - 06:00 PM</div>
                    </div>
                </div>
            </div>

            <!-- Bottom Copyright Bar -->
            <div class="footer-bottom">
                <div class="footer-bottom-inner">
                    <div>
                        &copy; <?php echo date('Y'); ?> <?php echo htmlspecialchars($config['app_name']); ?>. All Rights Reserved. Masterfully Crafted.
                    </div>

                    <div class="footer-bottom-links">
                        <a href="#hero">Privacy Policy</a>
                        <a href="#hero">Terms of Service</a>
                        <a href="#hero">Cookie Settings</a>
                    </div>

                    <button class="back-to-top-btn" id="back-to-top" aria-label="Back to Top">
                        <?php echo render_svg_icon('arrow-right'); ?>
                    </button>
                </div>
            </div>
        </div>
    </footer>

    <!-- Toast Notifications Container -->
    <div id="toast-container" class="toast-container"></div>

    <!-- Scripts -->
    <script src="assets/js/slider.js"></script>
    <script src="assets/js/animations.js"></script>
    <script src="assets/js/counter.js"></script>
    <script src="assets/js/accordion.js"></script>
    <script src="assets/js/lightbox.js"></script>
    <script src="assets/js/testimonials.js"></script>
    <script src="assets/js/mobile-nav.js"></script>
    <script src="assets/js/booking.js"></script>
    <script src="assets/js/app.js"></script>
</body>
</html>
