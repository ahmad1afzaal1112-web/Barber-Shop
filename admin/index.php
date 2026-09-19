<?php
/**
 * Admin Dashboard — KPI Overview
 * Kre8 Luxury Barbershop
 */
require_once __DIR__ . '/includes/auth.php';
require_admin_auth();

$page_title = 'Dashboard';
$pdo = get_db_connection();

// Fetch KPIs
$total_appointments = 0;
$pending_count = 0;
$revenue_estimate = 0;
$unread_messages = 0;
$today_appointments = [];
$recent_messages = [];

if ($pdo) {
    try {
        $total_appointments = (int) $pdo->query("SELECT COUNT(*) FROM appointments")->fetchColumn();
        $pending_count = (int) $pdo->query("SELECT COUNT(*) FROM appointments WHERE status = 'pending'")->fetchColumn();

        $rev = $pdo->query("SELECT COALESCE(SUM(s.price), 0) AS revenue FROM appointments a LEFT JOIN services s ON a.service_id = s.id WHERE a.status IN ('confirmed', 'completed')")->fetch();
        $revenue_estimate = (float) ($rev['revenue'] ?? 0);
        // Fallback: estimate from count
        if ($revenue_estimate == 0 && $total_appointments > 0) {
            $confirmed = (int) $pdo->query("SELECT COUNT(*) FROM appointments WHERE status IN ('confirmed', 'completed')")->fetchColumn();
            $revenue_estimate = $confirmed * 45;
        }

        $unread_messages = (int) $pdo->query("SELECT COUNT(*) FROM contact_messages WHERE is_read = 0")->fetchColumn();

        // Today's appointments
        $today = date('Y-m-d');
        $stmt = $pdo->prepare("SELECT * FROM appointments WHERE appointment_date = ? ORDER BY appointment_time ASC");
        $stmt->execute([$today]);
        $today_appointments = $stmt->fetchAll();

        // Recent messages
        $recent_messages = $pdo->query("SELECT * FROM contact_messages ORDER BY created_at DESC LIMIT 5")->fetchAll();
    } catch (\Throwable $e) {
        error_log("Dashboard KPI error: " . $e->getMessage());
    }
}

require_once __DIR__ . '/includes/header.php';
?>

<div class="page-header">
    <div>
        <h1 class="page-title">Dashboard</h1>
        <p class="page-subtitle">Welcome back, <?= htmlspecialchars(get_current_admin()['full_name']) ?></p>
    </div>
</div>

<!-- KPI Cards -->
<div class="kpi-grid">
    <div class="kpi-card">
        <div class="kpi-header">
            <div class="kpi-icon gold"><i class="fas fa-calendar-check"></i></div>
        </div>
        <div class="kpi-value"><?= $total_appointments ?></div>
        <div class="kpi-label">Total Bookings</div>
    </div>
    <div class="kpi-card">
        <div class="kpi-header">
            <div class="kpi-icon blue"><i class="fas fa-clock"></i></div>
        </div>
        <div class="kpi-value"><?= $pending_count ?></div>
        <div class="kpi-label">Pending Appointments</div>
    </div>
    <div class="kpi-card">
        <div class="kpi-header">
            <div class="kpi-icon green"><i class="fas fa-dollar-sign"></i></div>
        </div>
        <div class="kpi-value">$<?= number_format($revenue_estimate, 0) ?></div>
        <div class="kpi-label">Revenue Estimate</div>
    </div>
    <div class="kpi-card">
        <div class="kpi-header">
            <div class="kpi-icon red"><i class="fas fa-envelope"></i></div>
        </div>
        <div class="kpi-value"><?= $unread_messages ?></div>
        <div class="kpi-label">Unread Messages</div>
    </div>
</div>

<!-- Today's Schedule -->
<div class="admin-card">
    <div class="card-header">
        <h3 class="card-title"><i class="fas fa-calendar-day" style="color: var(--admin-gold); margin-right: 8px;"></i>Today's Schedule</h3>
        <a href="appointments.php" class="btn btn-outline btn-sm">View All</a>
    </div>
    <?php if (empty($today_appointments)): ?>
        <div class="empty-state">
            <i class="fas fa-calendar-times"></i>
            <h3>No appointments today</h3>
            <p>Enjoy the quiet or check upcoming bookings.</p>
        </div>
    <?php else: ?>
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Time</th>
                    <th>Client</th>
                    <th>Service</th>
                    <th>Barber</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($today_appointments as $appt): ?>
                <tr>
                    <td><strong><?= date('g:i A', strtotime($appt['appointment_time'])) ?></strong></td>
                    <td><?= htmlspecialchars($appt['first_name'] . ' ' . $appt['last_name']) ?></td>
                    <td><?= htmlspecialchars($appt['service_name'] ?? $appt['service'] ?? 'N/A') ?></td>
                    <td><?= htmlspecialchars($appt['barber_name'] ?? $appt['barber'] ?? 'Any') ?></td>
                    <td><span class="badge badge-<?= $appt['status'] ?>"><?= ucfirst($appt['status']) ?></span></td>
                    <td>
                        <form method="POST" action="appointments.php" style="display:inline">
                            <input type="hidden" name="action" value="update_status">
                            <input type="hidden" name="appt_id" value="<?= $appt['id'] ?>">
                            <input type="hidden" name="csrf_token" value="<?= admin_csrf_token() ?>">
                            <select name="new_status" class="filter-select status-select" style="min-width:120px">
                                <?php foreach (['pending','confirmed','completed','cancelled'] as $s): ?>
                                    <option value="<?= $s ?>" <?= $appt['status'] === $s ? 'selected' : '' ?>><?= ucfirst($s) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>

<!-- Recent Messages -->
<div class="admin-card">
    <div class="card-header">
        <h3 class="card-title"><i class="fas fa-inbox" style="color: var(--admin-gold); margin-right: 8px;"></i>Recent Inquiries</h3>
        <a href="messages.php" class="btn btn-outline btn-sm">View All</a>
    </div>
    <?php if (empty($recent_messages)): ?>
        <div class="empty-state">
            <i class="fas fa-inbox"></i>
            <h3>No messages yet</h3>
            <p>Contact form submissions will appear here.</p>
        </div>
    <?php else: ?>
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Subject</th>
                    <th>Date</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($recent_messages as $msg): ?>
                <tr>
                    <td>
                        <strong><?= htmlspecialchars($msg['name']) ?></strong>
                        <div style="font-size:12px;color:var(--admin-text-muted)"><?= htmlspecialchars($msg['email']) ?></div>
                    </td>
                    <td><?= htmlspecialchars($msg['subject'] ?: 'General Inquiry') ?></td>
                    <td><?= date('M j, g:i A', strtotime($msg['created_at'])) ?></td>
                    <td>
                        <?php if ($msg['is_read']): ?>
                            <span class="badge badge-completed">Read</span>
                        <?php else: ?>
                            <span class="badge badge-pending">New</span>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
