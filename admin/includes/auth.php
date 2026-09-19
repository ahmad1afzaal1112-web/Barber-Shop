<?php
/**
 * Admin Authentication & Session Management
 * Kre8 Luxury Barbershop
 */

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../includes/functions.php';

// Security headers
header('X-Content-Type-Options: nosniff');
header('X-Frame-Options: DENY');
header('X-XSS-Protection: 1; mode=block');

/**
 * Check if user is logged in. Redirect to login if not.
 */
function require_admin_auth() {
    if (!isset($_SESSION['admin_id']) || !isset($_SESSION['admin_logged_in'])) {
        header('Location: login.php');
        exit;
    }
    // Session timeout: 2 hours
    if (isset($_SESSION['admin_last_activity']) && (time() - $_SESSION['admin_last_activity']) > 7200) {
        session_unset();
        session_destroy();
        header('Location: login.php?expired=1');
        exit;
    }
    $_SESSION['admin_last_activity'] = time();
}

/**
 * Generate a CSRF token
 */
function admin_csrf_token() {
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

/**
 * Verify CSRF token from POST
 */
function verify_admin_csrf($token) {
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}

/**
 * Get current admin info
 */
function get_current_admin() {
    return [
        'id' => $_SESSION['admin_id'] ?? 0,
        'username' => $_SESSION['admin_username'] ?? 'Admin',
        'full_name' => $_SESSION['admin_full_name'] ?? 'Administrator',
        'role' => $_SESSION['admin_role'] ?? 'superadmin'
    ];
}

/**
 * Set a flash message
 */
function set_flash($type, $message) {
    $_SESSION['flash'] = ['type' => $type, 'message' => $message];
}

/**
 * Get and clear flash message
 */
function get_flash() {
    if (isset($_SESSION['flash'])) {
        $flash = $_SESSION['flash'];
        unset($_SESSION['flash']);
        return $flash;
    }
    return null;
}
