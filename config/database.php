<?php
/**
 * Database Connection Helper (PDO)
 * Graceful fallback to standalone mode if MySQL is not available.
 */

$db_host = getenv('DB_HOST') ?: '127.0.0.1';
$db_port = getenv('DB_PORT') ?: '3307';
$db_name = getenv('DB_NAME') ?: 'kre8_barbershop';
$db_user = getenv('DB_USER') ?: 'root';
$db_pass = getenv('DB_PASS') ?: '';

$pdo = null;
$db_connected = false;

try {
    $dsn = "mysql:host={$db_host};port={$db_port};dbname={$db_name};charset=utf8mb4";
    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
        PDO::ATTR_TIMEOUT            => 2, // Quick timeout to avoid blocking if MySQL is down
    ];
    $pdo = new PDO($dsn, $db_user, $db_pass, $options);
    $db_connected = true;
} catch (\Throwable $e) {
    // Database is optional; functions.php contains high-fidelity fallback data
    $pdo = null;
    $db_connected = false;
    error_log("Database connection note: " . $e->getMessage());
}

function get_db_connection() {
    global $pdo;
    return $pdo;
}

function is_db_connected() {
    global $db_connected;
    return $db_connected;
}
