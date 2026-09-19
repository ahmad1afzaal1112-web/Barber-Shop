<?php
/**
 * Admin Business Hours Management
 * Kre8 Luxury Barbershop
 */
require_once __DIR__ . '/includes/auth.php';
require_admin_auth();

$page_title = 'Business Hours';
$pdo = get_db_connection();

// Handle POST updates
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $csrf = $_POST['csrf_token'] ?? '';
    if (!verify_admin_csrf($csrf)) {
        set_flash('error', 'Invalid security token.');
        header('Location: business-hours.php');
        exit;
    }

    $hours_data = $_POST['hours'] ?? [];

    if (!empty($hours_data) && is_array($hours_data)) {
        $stmt = $pdo->prepare("UPDATE business_hours SET open_time = ?, close_time = ?, is_closed = ?, slot_interval_minutes = ? WHERE id = ?");
        
        foreach ($hours_data as $id => $data) {
            $id = (int) $id;
            $open_time = $data['open_time'] ?? '09:00:00';
            $close_time = $data['close_time'] ?? '20:00:00';
            $is_closed = isset($data['is_closed']) ? 1 : 0;
            $slot_interval = (int) ($data['slot_interval_minutes'] ?? 30);

            $stmt->execute([$open_time, $close_time, $is_closed, $slot_interval, $id]);
        }

        set_flash('success', 'Business hours updated successfully.');
    }

    header('Location: business-hours.php');
    exit;
}

// Fetch all 7 days
$hours = $pdo->query("SELECT * FROM business_hours ORDER BY FIELD(day_of_week, 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday')")->fetchAll();

require_once __DIR__ . '/includes/header.php';
?>

<div class="page-header">
    <div>
        <h1 class="page-title">Business & Operating Hours</h1>
        <p class="page-subtitle">Configure salon opening schedule, closed days, and booking slot duration</p>
    </div>
</div>

<div class="admin-card">
    <div class="card-header">
        <h3 class="card-title">Weekly Schedule & Slot Settings</h3>
    </div>

    <form method="POST" action="business-hours.php">
        <input type="hidden" name="csrf_token" value="<?= admin_csrf_token() ?>">

        <table class="admin-table">
            <thead>
                <tr>
                    <th>Day</th>
                    <th>Opening Time</th>
                    <th>Closing Time</th>
                    <th>Closed / Holiday</th>
                    <th>Slot Interval</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($hours as $h): ?>
                <tr>
                    <td>
                        <strong style="color:var(--admin-text); font-size:15px;"><?= htmlspecialchars($h['display_name']) ?></strong>
                        <div style="font-size:11px; color:var(--admin-text-muted); text-transform:capitalize;"><?= $h['day_of_week'] ?></div>
                    </td>
                    <td>
                        <input type="time" name="hours[<?= $h['id'] ?>][open_time]" value="<?= substr($h['open_time'], 0, 5) ?>" class="form-control" style="width:140px;" <?= $h['is_closed'] ? 'disabled' : '' ?>>
                    </td>
                    <td>
                        <input type="time" name="hours[<?= $h['id'] ?>][close_time]" value="<?= substr($h['close_time'], 0, 5) ?>" class="form-control" style="width:140px;" <?= $h['is_closed'] ? 'disabled' : '' ?>>
                    </td>
                    <td>
                        <label style="display:inline-flex; align-items:center; gap:8px; cursor:pointer;">
                            <input type="checkbox" name="hours[<?= $h['id'] ?>][is_closed]" value="1" <?= $h['is_closed'] ? 'checked' : '' ?> onchange="toggleDayInputs(this)">
                            <span style="font-size:13px; color:<?= $h['is_closed'] ? 'var(--admin-danger)' : 'var(--admin-text-muted)' ?>; font-weight:600;">
                                <?= $h['is_closed'] ? 'Closed All Day' : 'Open' ?>
                            </span>
                        </label>
                    </td>
                    <td>
                        <select name="hours[<?= $h['id'] ?>][slot_interval_minutes]" class="form-control" style="width:120px;" <?= $h['is_closed'] ? 'disabled' : '' ?>>
                            <option value="15" <?= $h['slot_interval_minutes'] == 15 ? 'selected' : '' ?>>15 Mins</option>
                            <option value="30" <?= $h['slot_interval_minutes'] == 30 ? 'selected' : '' ?>>30 Mins</option>
                            <option value="45" <?= $h['slot_interval_minutes'] == 45 ? 'selected' : '' ?>>45 Mins</option>
                            <option value="60" <?= $h['slot_interval_minutes'] == 60 ? 'selected' : '' ?>>60 Mins</option>
                        </select>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <div style="padding:24px; display:flex; justify-content:flex-end; border-top:1px solid var(--admin-border);">
            <button type="submit" class="btn btn-gold">
                <i class="fas fa-save"></i> Save Schedule Changes
            </button>
        </div>
    </form>
</div>

<script>
function toggleDayInputs(checkbox) {
    const row = checkbox.closest('tr');
    const inputs = row.querySelectorAll('input[type="time"], select');
    inputs.forEach(input => {
        input.disabled = checkbox.checked;
    });
    const label = checkbox.nextElementSibling;
    if (checkbox.checked) {
        label.innerText = 'Closed All Day';
        label.style.color = 'var(--admin-danger)';
    } else {
        label.innerText = 'Open';
        label.style.color = 'var(--admin-text-muted)';
    }
}
</script>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
