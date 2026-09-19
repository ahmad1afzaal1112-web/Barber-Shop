<?php
/**
 * Contact Form Submission API Handler
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

// Support both standard $_POST and JSON payload
$input_data = $_POST;
if (empty($input_data)) {
    $raw_input = file_get_contents('php://input');
    if (!empty($raw_input)) {
        $json_data = json_decode($raw_input, true);
        if (is_array($json_data)) {
            $input_data = $json_data;
        }
    }
}

// Honeypot spam check — hidden field must be empty
if (!empty($input_data['website'] ?? '')) {
    // Bot detected
    echo json_encode(['success' => true, 'message' => 'Thank you for your message.']);
    exit;
}

// Retrieve & sanitize
$name = sanitize_input($input_data['name'] ?? '');
$email = filter_var(trim($input_data['email'] ?? ''), FILTER_VALIDATE_EMAIL);
$phone = sanitize_input($input_data['phone'] ?? '');
$subject = sanitize_input($input_data['subject'] ?? 'General Inquiry');
$message = sanitize_input($input_data['message'] ?? '');

// Validation
if (empty($name)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Please provide your name.']);
    exit;
}

if (!$email) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Please provide a valid email address.']);
    exit;
}

if (empty($message) || strlen($message) < 10) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Please provide a detailed message (at least 10 characters).']);
    exit;
}

// Store in database
$saved = false;
$pdo = get_db_connection();

if ($pdo) {
    try {
        $stmt = $pdo->prepare("INSERT INTO contact_messages (name, email, phone, subject, message, ip_address) VALUES (?, ?, ?, ?, ?, ?)");
        $ip = $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1';
        $stmt->execute([$name, $email, $phone, $subject, $message, $ip]);
        $saved = true;
    } catch (\Throwable $e) {
        error_log("Contact DB error: " . $e->getMessage());
    }
}

// Fallback: store to JSON file
if (!$saved) {
    $data_dir = __DIR__ . '/../data';
    if (!is_dir($data_dir)) {
        mkdir($data_dir, 0777, true);
    }
    $file_path = $data_dir . '/contact_messages.json';
    $existing = file_exists($file_path) ? json_decode(file_get_contents($file_path), true) : [];
    if (!is_array($existing)) $existing = [];

    $existing[] = [
        'name' => $name,
        'email' => $email,
        'phone' => $phone,
        'subject' => $subject,
        'message' => $message,
        'created_at' => date('Y-m-d H:i:s')
    ];

    file_put_contents($file_path, json_encode($existing, JSON_PRETTY_PRINT));
}

echo json_encode([
    'success' => true,
    'message' => "Thank you, {$name}! Your message has been received. Our concierge team will respond within 24 hours."
]);
