<?php
/**
 * Appointment Booking Submission API Handler
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

// Retrieve & sanitize inputs
$first_name = sanitize_input($input_data['first_name'] ?? '');
$last_name  = sanitize_input($input_data['last_name'] ?? '');
$email      = filter_var(trim($input_data['email'] ?? ''), FILTER_VALIDATE_EMAIL);
$phone      = sanitize_input($input_data['phone'] ?? '');
$service_input = sanitize_input($input_data['service'] ?? 'Classic Haircut');
$barber_input  = sanitize_input($input_data['barber'] ?? 'Any Available Master');
$date       = sanitize_input($input_data['appointment_date'] ?? date('Y-m-d'));
$time_raw   = sanitize_input($input_data['appointment_time'] ?? '10:00 AM');
$message    = sanitize_input($input_data['message'] ?? '');

// Validation
if (empty($first_name) || empty($last_name)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Please provide your full first and last name.']);
    exit;
}

if (!$email) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Please provide a valid email address.']);
    exit;
}

if (empty($phone)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Please provide a contact phone number.']);
    exit;
}

// Convert time to standard 24h format (H:i:s) for DB consistency
$time_24h = date('H:i:s', strtotime($time_raw));

// Store Record in Database
$saved = false;
$pdo = get_db_connection();

if ($pdo) {
    try {
        // Resolve customer or create new
        $stmt = $pdo->prepare("SELECT id FROM customers WHERE email = ? LIMIT 1");
        $stmt->execute([$email]);
        $customer_id = $stmt->fetchColumn();

        if (!$customer_id) {
            $stmt = $pdo->prepare("INSERT INTO customers (first_name, last_name, email, phone) VALUES (?, ?, ?, ?)");
            $stmt->execute([$first_name, $last_name, $email, $phone]);
            $customer_id = $pdo->lastInsertId();
        }

        // Resolve service ID & duration
        $service_id = null;
        $service_duration = 45;
        $stmt = $pdo->prepare("SELECT id, title, duration_minutes FROM services WHERE title = ? OR title LIKE ? LIMIT 1");
        $stmt->execute([$service_input, "%{$service_input}%"]);
        $srv = $stmt->fetch();
        if ($srv) {
            $service_id = $srv['id'];
            $service_duration = (int) $srv['duration_minutes'];
        }

        // Resolve barber ID
        $barber_id = null;
        if (!empty($barber_input) && $barber_input !== 'Any Available Master') {
            $stmt = $pdo->prepare("SELECT id, name FROM barbers WHERE name = ? OR name LIKE ? LIMIT 1");
            $stmt->execute([$barber_input, "%{$barber_input}%"]);
            $brb = $stmt->fetch();
            if ($brb) {
                $barber_id = $brb['id'];
            }
        }

        $end_time = date('H:i:s', strtotime($time_24h) + ($service_duration * 60));

        $stmt = $pdo->prepare("INSERT INTO appointments (customer_id, service_id, barber_id, first_name, last_name, email, phone, service_name, barber_name, appointment_date, appointment_time, end_time, message, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'confirmed')");
        $stmt->execute([
            $customer_id,
            $service_id,
            $barber_id,
            $first_name,
            $last_name,
            $email,
            $phone,
            $service_input,
            $barber_input,
            $date,
            $time_24h,
            $end_time,
            $message
        ]);
        $saved = true;
    } catch (\Throwable $e) {
        error_log("DB insert failed: " . $e->getMessage());
    }
}

// Fallback JSON storage if DB unavailable
if (!$saved) {
    $data_dir = __DIR__ . '/../data';
    if (!is_dir($data_dir)) {
        mkdir($data_dir, 0777, true);
    }
    $file_path = $data_dir . '/appointments.json';
    $existing = file_exists($file_path) ? json_decode(file_get_contents($file_path), true) : [];
    if (!is_array($existing)) $existing = [];

    $existing[] = [
        'id' => count($existing) + 1,
        'first_name' => $first_name,
        'last_name' => $last_name,
        'email' => $email,
        'phone' => $phone,
        'service' => $service_input,
        'barber' => $barber_input,
        'appointment_date' => $date,
        'appointment_time' => $time_raw,
        'message' => $message,
        'created_at' => date('Y-m-d H:i:s')
    ];

    file_put_contents($file_path, json_encode($existing, JSON_PRETTY_PRINT));
}

echo json_encode([
    'success' => true,
    'message' => "Appointment Confirmed! Thank you, {$first_name}. We look forward to welcoming you for {$service_input} on {$date} at {$time_raw}."
]);
