<?php
/**
 * Master Homepage
 * Kre8 Luxury Barbershop
 * 
 * Phase 2 Homepage Sections:
 * 1. Header & Navigation (Phase 1)
 * 2. Hero Slider & Stats Bar (Phase 1)
 * 3. Infinite Gold Marquee Craftsmanship Ticker
 * 4. Signature Barber Services (8 Categories)
 * 5. Artisanal Packages & Pricing Menu (3 Tiers + A La Carte)
 * 6. Master Barbering Craftsmanship Video CTA Banner
 * 7. VIP Appointment Reservation System
 * 8. Artisan Craftsmanship Gallery / Portfolio (with Lightbox)
 * 9. Master Barbers / Team Showcase
 * 10. Distinguished Client Testimonials Carousel
 * 11. Luxury Barbershop Footer
 * 
 * Exclusions: About Us, Why Choose Us, Our Unique Experience, and Latest Blogs
 * are strictly omitted from the homepage per project guidelines.
 */

// Include Header & Navigation
require_once __DIR__ . '/includes/header.php';

// 1. Hero Slider & Stats Bar Section
require_once __DIR__ . '/sections/hero.php';

// 2. Infinite Gold Marquee Ticker Bar
require_once __DIR__ . '/sections/marquee.php';

// 3. Signature Barber Services Section (8 Categories)
require_once __DIR__ . '/sections/services.php';

// 4. Artisanal Packages & Pricing Menu Section
require_once __DIR__ . '/sections/pricing.php';

// 5. Craftsmanship Video CTA Section
require_once __DIR__ . '/sections/video.php';

// 6. VIP Appointment Booking Section
require_once __DIR__ . '/sections/appointment.php';

// 7. Gallery / Portfolio Showcase Section (Asymmetric & Lightbox)
require_once __DIR__ . '/sections/gallery.php';

// 8. Team / Master Barbers Section
require_once __DIR__ . '/sections/team.php';

// 9. Client Testimonials Carousel Section
require_once __DIR__ . '/sections/testimonials.php';

// Include Footer & Global Scripts
require_once __DIR__ . '/includes/footer.php';
