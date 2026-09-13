<?php
/**
 * Header & Navigation Component
 * Kre8 Luxury Barbershop
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

    <!-- Top Information Bar -->
    <div class="top-bar">
        <div class="container top-bar-inner">
            <div class="top-bar-left">
                <div class="top-bar-item">
                    <?php echo render_svg_icon('map-pin'); ?>
                    <span><?php echo htmlspecialchars($config['address']); ?></span>
                </div>
                <div class="top-bar-item">
                    <?php echo render_svg_icon('clock'); ?>
                    <span>Mon-Fri: 09:00 AM - 08:00 PM</span>
                </div>
            </div>
            <div class="top-bar-right">
                <div class="top-bar-item">
                    <?php echo render_svg_icon('mail'); ?>
                    <a href="mailto:<?php echo htmlspecialchars($config['email']); ?>"><?php echo htmlspecialchars($config['email']); ?></a>
                </div>
                <div class="top-bar-social">
                    <a href="<?php echo htmlspecialchars($config['social']['instagram']); ?>" target="_blank" rel="noopener" aria-label="Instagram"><?php echo render_svg_icon('instagram'); ?></a>
                    <a href="<?php echo htmlspecialchars($config['social']['facebook']); ?>" target="_blank" rel="noopener" aria-label="Facebook"><?php echo render_svg_icon('facebook'); ?></a>
                    <a href="<?php echo htmlspecialchars($config['social']['twitter']); ?>" target="_blank" rel="noopener" aria-label="Twitter"><?php echo render_svg_icon('twitter'); ?></a>
                    <a href="<?php echo htmlspecialchars($config['social']['youtube']); ?>" target="_blank" rel="noopener" aria-label="YouTube"><?php echo render_svg_icon('youtube'); ?></a>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Site Navigation Header -->
    <header class="site-header" id="site-header">
        <div class="header-container">
            <!-- Brand Logo -->
            <a href="#hero" class="header-logo" aria-label="Kre8 Barbershop Home">
                <img src="assets/images/logo.svg" alt="Kre8 Luxury Barbershop" width="180" height="45">
            </a>

            <!-- Desktop Nav Menu -->
            <nav class="desktop-nav" aria-label="Main Navigation">
                <ul class="nav-menu">
                    <?php foreach ($config['nav_menu'] as $item): ?>
                        <li class="nav-item <?php echo $item['active'] ? 'active' : ''; ?>">
                            <a href="<?php echo htmlspecialchars($item['url']); ?>" class="nav-link">
                                <?php echo htmlspecialchars($item['label']); ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </nav>

            <!-- Header Action CTAs -->
            <div class="header-actions">
                <a href="tel:<?php echo htmlspecialchars($config['phone_clean']); ?>" class="header-phone-btn" aria-label="Call Kre8 Barbershop">
                    <span class="header-phone-icon">
                        <?php echo render_svg_icon('phone'); ?>
                    </span>
                    <span class="header-phone-text d-none-mobile"><?php echo htmlspecialchars($config['phone']); ?></span>
                </a>

                <a href="#appointment" class="btn btn-primary btn-sm">
                    <span>Book Appointment</span>
                    <?php echo render_svg_icon('arrow-right'); ?>
                </a>

                <!-- Mobile Hamburger Toggle -->
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
    <div class="mobile-drawer" id="mobile-drawer">
        <div>
            <div class="mobile-drawer-header">
                <a href="#hero" class="header-logo">
                    <img src="assets/images/logo.svg" alt="Kre8 Luxury Barbershop" width="160" height="40">
                </a>
                <button class="btn-icon btn-glass" id="mobile-drawer-close" aria-label="Close Menu">
                    <?php echo render_svg_icon('close'); ?>
                </button>
            </div>

            <nav class="mobile-nav">
                <ul class="mobile-nav-list">
                    <?php foreach ($config['nav_menu'] as $item): ?>
                        <li>
                            <a href="<?php echo htmlspecialchars($item['url']); ?>" class="mobile-nav-link">
                                <?php echo htmlspecialchars($item['label']); ?>
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

            <a href="#appointment" class="btn btn-primary" style="width: 100%;">
                <span>Book Appointment</span>
                <?php echo render_svg_icon('arrow-right'); ?>
            </a>
        </div>
    </div>
