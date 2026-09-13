<?php
/**
 * Header & Navigation Component
 * Kre8 Luxury Barbershop
 * 
 * Exact Reference Layout:
 * - Full-width Gold Top Bar
 * - Left: Navigation Links with dropdown indicators
 * - Center: Hanging Gold Pennant Ribbon Logo with Barber Crest
 * - Right: Search, Wishlist, Cart (with badge), User profile, and Gold CTA Button
 */

require_once __DIR__ . '/functions.php';
$config = get_app_config();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo htmlspecialchars($config['app_name']); ?> — <?php echo htmlspecialchars($config['app_tagline']); ?></title>
    <meta name="description" content="Experience master craftsmanship and timeless luxury grooming at Kre8 Barbershop. Precision haircuts, artisanal beard sculpting, and traditional royal straight razor shaves.">
    
    <!-- Favicon -->
    <link rel="icon" type="image/svg+xml" href="assets/images/logo.svg">

    <!-- CSS Architecture -->
    <link rel="stylesheet" href="assets/css/variables.css">
    <link rel="stylesheet" href="assets/css/base.css">
    <link rel="stylesheet" href="assets/css/layout.css">
    <link rel="stylesheet" href="assets/css/components.css">
    <link rel="stylesheet" href="assets/css/animations.css">
    <link rel="stylesheet" href="assets/css/header.css">
    <link rel="stylesheet" href="assets/css/hero.css">
    <link rel="stylesheet" href="assets/css/sections.css">
    <link rel="stylesheet" href="assets/css/footer.css">
    <link rel="stylesheet" href="assets/css/responsive.css">
</head>
<body>

    <!-- Top Information Bar (Warm Gold Banner) -->
    <div class="top-bar">
        <div class="container top-bar-inner">
            <div class="top-bar-left">
                <span class="top-bar-tagline">Premium Grooming for the Modern Gentleman</span>
            </div>
            <div class="top-bar-right">
                <div class="top-bar-item">
                    <?php echo render_svg_icon('mail'); ?>
                    <span>Email Us:</span>
                    <a href="mailto:<?php echo htmlspecialchars($config['email']); ?>"><?php echo htmlspecialchars($config['email']); ?></a>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Site Navigation Header -->
    <header class="site-header" id="site-header">
        <div class="header-container">
            <!-- Left: Navigation Links -->
            <nav class="desktop-nav" aria-label="Main Navigation">
                <ul class="nav-menu">
                    <?php foreach ($config['nav_menu'] as $item): ?>
                        <li class="nav-item <?php echo $item['active'] ? 'active' : ''; ?>">
                            <a href="<?php echo htmlspecialchars($item['url']); ?>" class="nav-link">
                                <span><?php echo htmlspecialchars($item['label']); ?></span>
                                <?php if (!empty($item['has_dropdown'])): ?>
                                    <?php echo render_svg_icon('chevron-down', 'nav-chevron'); ?>
                                <?php endif; ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </nav>

            <!-- Center: Hanging Gold Pennant Brand Logo -->
            <a href="#hero" class="header-logo-pennant" aria-label="Kre8 Barbershop Home">
                <div class="pennant-badge">
                    <svg class="pennant-crest" viewBox="0 0 70 80" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                        <!-- Barber Head Silhouette with Beard and Scissor Accent -->
                        <path d="M35 10C24 10 16 18 16 29C16 35 19 40 23 44L23 54C23 60 28 66 35 68C42 66 47 60 47 54L47 44C51 40 54 35 54 29C54 18 46 10 35 10Z" fill="#111214"/>
                        <!-- Hair Texture / Swoop -->
                        <path d="M22 26C22 18 28 12 35 12C41 12 47 16 48 22C44 20 39 19 33 21C27 23 23 25 22 26Z" fill="#C4A97A"/>
                        <path d="M20 31C24 28 29 27 34 27C41 27 46 30 48 33C45 32 40 31 36 32C30 33 24 35 20 31Z" fill="#C4A97A"/>
                        <!-- Beard Detail Lines -->
                        <path d="M27 46C30 52 35 56 35 62C35 56 40 52 43 46C40 47 38 48 35 48C32 48 30 47 27 46Z" fill="#C4A97A"/>
                        <!-- Crossed Scissors Accent below Head -->
                        <circle cx="28" cy="65" r="3" stroke="#111214" stroke-width="1.5"/>
                        <circle cx="42" cy="65" r="3" stroke="#111214" stroke-width="1.5"/>
                        <line x1="30" y1="63" x2="40" y2="55" stroke="#111214" stroke-width="1.5" stroke-linecap="round"/>
                        <line x1="40" y1="63" x2="30" y2="55" stroke="#111214" stroke-width="1.5" stroke-linecap="round"/>
                    </svg>
                    <span class="pennant-brand-text">KRE8</span>
                </div>
            </a>

            <!-- Right: Action Icons & CTA Button -->
            <div class="header-actions">
                <!-- Search Button -->
                <button class="header-icon-btn" aria-label="Search Catalog" id="search-toggle">
                    <?php echo render_svg_icon('search'); ?>
                </button>

                <!-- Wishlist (Heart) Button -->
                <a href="#shop" class="header-icon-btn" aria-label="View Wishlist">
                    <?php echo render_svg_icon('heart'); ?>
                </a>

                <!-- Cart Button with Count Badge -->
                <a href="#shop" class="header-icon-btn header-cart-btn" aria-label="Shopping Cart">
                    <?php echo render_svg_icon('cart'); ?>
                    <span class="cart-badge">0</span>
                </a>

                <!-- User Profile Button -->
                <a href="#appointment" class="header-icon-btn" aria-label="User Account">
                    <?php echo render_svg_icon('user'); ?>
                </a>

                <!-- Book Appointment Primary CTA -->
                <a href="#appointment" class="btn btn-primary btn-sm header-cta">
                    <span>Book Appointment</span>
                    <?php echo render_svg_icon('arrow-right'); ?>
                </a>

                <!-- Mobile Menu Hamburger Button -->
                <button class="mobile-toggle" id="mobile-toggle" aria-label="Toggle Mobile Menu" aria-expanded="false">
                    <span></span>
                    <span></span>
                    <span></span>
                </button>
            </div>
        </div>
    </header>

    <!-- Off-Canvas Mobile Drawer -->
    <div class="mobile-drawer-overlay" id="mobile-drawer-overlay"></div>
    <div class="mobile-drawer" id="mobile-drawer" aria-hidden="true">
        <div>
            <div class="mobile-drawer-header">
                <a href="#hero" class="mobile-drawer-logo">
                    <span class="text-gold" style="font-family: var(--font-heading); font-size: 1.8rem; font-weight: 700; letter-spacing: 2px;">KRE8</span>
                    <span style="font-size: 0.75rem; letter-spacing: 3px; color: var(--color-text-muted); text-transform: uppercase;">Barbershop</span>
                </a>
                <button class="btn-icon btn-glass" id="mobile-drawer-close" aria-label="Close Menu">
                    <?php echo render_svg_icon('close'); ?>
                </button>
            </div>

            <nav class="mobile-nav" aria-label="Mobile Navigation">
                <ul class="mobile-nav-list">
                    <?php foreach ($config['nav_menu'] as $index => $item): ?>
                        <li style="--nav-index: <?php echo $index; ?>">
                            <a href="<?php echo htmlspecialchars($item['url']); ?>" class="mobile-nav-link">
                                <span><?php echo htmlspecialchars($item['label']); ?></span>
                                <?php if (!empty($item['has_dropdown'])): ?>
                                    <?php echo render_svg_icon('chevron-down', 'mobile-chevron'); ?>
                                <?php endif; ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </nav>
        </div>

        <div class="mobile-drawer-footer">
            <div class="mobile-drawer-contact">
                <a href="tel:<?php echo htmlspecialchars($config['phone_clean']); ?>">
                    <?php echo render_svg_icon('phone'); ?>
                    <span><?php echo htmlspecialchars($config['phone']); ?></span>
                </a>
                <a href="mailto:<?php echo htmlspecialchars($config['email']); ?>">
                    <?php echo render_svg_icon('mail'); ?>
                    <span><?php echo htmlspecialchars($config['email']); ?></span>
                </a>
                <div class="top-bar-item">
                    <?php echo render_svg_icon('clock'); ?>
                    <span>Mon - Sun: Open Daily</span>
                </div>
            </div>

            <div class="mobile-drawer-social">
                <a href="<?php echo htmlspecialchars($config['social']['instagram']); ?>" target="_blank" rel="noopener" aria-label="Instagram"><?php echo render_svg_icon('instagram'); ?></a>
                <a href="<?php echo htmlspecialchars($config['social']['facebook']); ?>" target="_blank" rel="noopener" aria-label="Facebook"><?php echo render_svg_icon('facebook'); ?></a>
                <a href="<?php echo htmlspecialchars($config['social']['twitter']); ?>" target="_blank" rel="noopener" aria-label="Twitter"><?php echo render_svg_icon('twitter'); ?></a>
                <a href="<?php echo htmlspecialchars($config['social']['youtube']); ?>" target="_blank" rel="noopener" aria-label="YouTube"><?php echo render_svg_icon('youtube'); ?></a>
            </div>

            <a href="#appointment" class="btn btn-primary" style="width: 100%; margin-top: 20px;">
                <span>Book Appointment</span>
                <?php echo render_svg_icon('arrow-right'); ?>
            </a>
        </div>
    </div>
