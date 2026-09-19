<?php
/**
 * Available Time Slots API
 * Returns available booking slots for a given date and barber.
 * Kre8 Luxury Barbershop
 */

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../includes/functions.php';

$date = $_GET['date'] ?? date('Y-m-d');
$barber_name = $_GET['barber'] ?? '';
$service_title = $_GET['service'] ?? '';

// Validate date format
if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $date)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Invalid date format. Use YYYY-MM-DD.']);
    exit;
}

// Check date is not in the past
if (strtotime($date) < strtotime(date('Y-m-d'))) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Cannot book appointments in the past.', 'slots' => []]);
    exit;
}

$pdo = get_db_connection();
$slots = [];

if ($pdo) {
    try {
        // Determine day of week
        $day_of_week = strtolower(date('l', strtotime($date)));

        // Check business hours for the requested day
        $stmt = $pdo->prepare("SELECT open_time, close_time, is_closed, slot_interval_minutes FROM business_hours WHERE day_of_week = ?");
        $stmt->execute([$day_of_week]);
        $hours = $stmt->fetch();

        if (!$hours || $hours['is_closed']) {
            echo json_encode([
                'success' => true,
                'slots' => [],
                'message' => 'The shop is closed on this day.'
            ]);
            exit;
        }

        // Get service duration (default 45 minutes)
        $service_duration = 45;
        if (!empty($service_title)) {
            $srvStmt = $pdo->prepare("SELECT duration_minutes FROM services WHERE title = ? AND is_active = 1 LIMIT 1");
            $srvStmt->execute([$service_title]);
            $srv = $srvStmt->fetch();
            if ($srv) {
                $service_duration = (int) $srv['duration_minutes'];
            }
        }

        $interval = (int) ($hours['slot_interval_minutes'] ?: 30);
        $open = strtotime($hours['open_time']);
        $close = strtotime($hours['close_time']);

        // Generate candidate time slots
        $candidate_slots = [];
        for ($t = $open; $t + ($service_duration * 60) <= $close; $t += $interval * 60) {
            $candidate_slots[] = date('H:i:s', $t);
        }

        // Fetch existing appointments for this date (and optionally this barber)
        $booked_slots = [];
        if (!empty($barber_name) && $barber_name !== 'Any Available Master') {
            $apptStmt = $pdo->prepare("SELECT appointment_time FROM appointments WHERE appointment_date = ? AND barber_name = ? AND status IN ('pending', 'confirmed')");
            $apptStmt->execute([$date, $barber_name]);
        } else {
            $apptStmt = $pdo->prepare("SELECT appointment_time FROM appointments WHERE appointment_date = ? AND status IN ('pending', 'confirmed')");
            $apptStmt->execute([$date]);
        }
        while ($row = $apptStmt->fetch()) {
            $booked_slots[] = $row['appointment_time'];
        }

        // Filter out booked slots
        foreach ($candidate_slots as $slot) {
            if (!in_array($slot, $booked_slots)) {
                $slots[] = [
                    'time_24h' => $slot,
                    'time_display' => date('g:i A', strtotime($slot))
                ];
            }
        }

    } catch (\Throwable $e) {
        error_log("Slots API error: " . $e->getMessage());
    }
}

// Fallback if DB is not available — generate default slots
if (empty($slots) && !$pdo) {
    $default_open = strtotime('09:00');
    $default_close = strtotime('20:00');
    for ($t = $default_open; $t + 2700 <= $default_close; $t += 1800) {
        $slots[] = [
            'time_24h' => date('H:i:s', $t),
            'time_display' => date('g:i A', $t)
        ];
    }
}

echo json_encode([
    'success' => true,
    'date' => $date,
    'barber' => $barber_name,
    'service' => $service_title,
    'slots' => $slots,
    'total' => count($slots)
]);
