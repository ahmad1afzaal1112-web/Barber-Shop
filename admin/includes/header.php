<?php
/**
 * Admin Dashboard — Shared Header
 * Kre8 Luxury Barbershop
 */
$admin = get_current_admin();
$current_page = basename($_SERVER['PHP_SELF'], '.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $page_title ?? 'Dashboard' ?> — Kre8 Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:wght@600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="assets/css/admin.css">
</head>
<body class="admin-body">

<!-- Sidebar -->
<aside class="admin-sidebar" id="adminSidebar">
    <div class="sidebar-brand">
        <div class="brand-icon">
            <i class="fas fa-scissors"></i>
        </div>
        <div class="brand-text">
            <span class="brand-name">Kre8</span>
            <span class="brand-sub">Admin Panel</span>
        </div>
    </div>

    <nav class="sidebar-nav">
        <a href="index.php" class="nav-item <?= $current_page === 'index' ? 'active' : '' ?>">
            <i class="fas fa-chart-pie"></i>
            <span>Dashboard</span>
        </a>
        <a href="appointments.php" class="nav-item <?= $current_page === 'appointments' ? 'active' : '' ?>">
            <i class="fas fa-calendar-check"></i>
            <span>Appointments</span>
        </a>
        <a href="services.php" class="nav-item <?= $current_page === 'services' ? 'active' : '' ?>">
            <i class="fas fa-concierge-bell"></i>
            <span>Services</span>
        </a>
        <a href="barbers.php" class="nav-item <?= $current_page === 'barbers' ? 'active' : '' ?>">
            <i class="fas fa-user-tie"></i>
            <span>Barbers</span>
        </a>
        <a href="gallery.php" class="nav-item <?= $current_page === 'gallery' ? 'active' : '' ?>">
            <i class="fas fa-images"></i>
            <span>Gallery</span>
        </a>
        <a href="testimonials.php" class="nav-item <?= $current_page === 'testimonials' ? 'active' : '' ?>">
            <i class="fas fa-star"></i>
            <span>Testimonials</span>
        </a>
        <a href="messages.php" class="nav-item <?= $current_page === 'messages' ? 'active' : '' ?>">
            <i class="fas fa-envelope"></i>
            <span>Messages</span>
            <?php
            $pdo = get_db_connection();
            if ($pdo) {
                try {
                    $unread = $pdo->query("SELECT COUNT(*) FROM contact_messages WHERE is_read = 0")->fetchColumn();
                    if ($unread > 0) echo "<span class='nav-badge'>{$unread}</span>";
                } catch (\Throwable $e) {}
            }
            ?>
        </a>
        <a href="business-hours.php" class="nav-item <?= $current_page === 'business-hours' ? 'active' : '' ?>">
            <i class="fas fa-clock"></i>
            <span>Business Hours</span>
        </a>
        <a href="settings.php" class="nav-item <?= $current_page === 'settings' ? 'active' : '' ?>">
            <i class="fas fa-cog"></i>
            <span>Settings</span>
        </a>
    </nav>

    <div class="sidebar-footer">
        <a href="../index.php" class="nav-item" target="_blank">
            <i class="fas fa-external-link-alt"></i>
            <span>View Website</span>
        </a>
        <a href="logout.php" class="nav-item nav-logout">
            <i class="fas fa-sign-out-alt"></i>
            <span>Log Out</span>
        </a>
    </div>
</aside>

<!-- Main Content -->
<div class="admin-main">
    <!-- Top Bar -->
    <header class="admin-topbar">
        <button class="sidebar-toggle" id="sidebarToggle">
            <i class="fas fa-bars"></i>
        </button>
        <div class="topbar-right">
            <div class="admin-user">
                <div class="user-avatar">
                    <i class="fas fa-user-shield"></i>
                </div>
                <div class="user-info">
                    <span class="user-name"><?= htmlspecialchars($admin['full_name']) ?></span>
                    <span class="user-role"><?= ucfirst($admin['role']) ?></span>
                </div>
            </div>
        </div>
    </header>

    <!-- Flash Messages -->
    <?php $flash = get_flash(); if ($flash): ?>
    <div class="alert alert-<?= $flash['type'] ?>" id="flashAlert">
        <i class="fas fa-<?= $flash['type'] === 'success' ? 'check-circle' : ($flash['type'] === 'error' ? 'exclamation-circle' : 'info-circle') ?>"></i>
        <span><?= htmlspecialchars($flash['message']) ?></span>
        <button class="alert-close" onclick="this.parentElement.remove()"><i class="fas fa-times"></i></button>
    </div>
    <?php endif; ?>

    <!-- Page Content -->
    <div class="admin-content">
