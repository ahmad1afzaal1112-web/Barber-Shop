<?php
/**
 * Newsletter Subscription API Handler
 * Kre8 Luxury Barbershop
 */

header('Content-Type: application/json');

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../includes/functions.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
    exit;
}

$email = filter_var(trim($_POST['email'] ?? ''), FILTER_VALIDATE_EMAIL);

if (!$email) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Please enter a valid email address.']);
    exit;
}

$pdo = get_db_connection();
if ($pdo) {
    try {
        $stmt = $pdo->prepare("INSERT IGNORE INTO newsletter_subscribers (email) VALUES (?)");
        $stmt->execute([$email]);
    } catch (\Throwable $e) {
        error_log("Newsletter DB error: " . $e->getMessage());
    }
}

echo json_encode([
    'success' => true,
    'message' => 'Thank you for subscribing to Kre8 Exclusive Grooming Gazette!'
]);
