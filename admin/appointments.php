<?php
/**
 * Admin Appointments Management
 * Kre8 Luxury Barbershop
 */
require_once __DIR__ . '/includes/auth.php';
require_admin_auth();

$page_title = 'Appointments';
$pdo = get_db_connection();

// Handle POST actions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $csrf = $_POST['csrf_token'] ?? '';
    if (!verify_admin_csrf($csrf)) {
        set_flash('error', 'Invalid security token. Please try again.');
        header('Location: appointments.php');
        exit;
    }

    $action = $_POST['action'] ?? '';

    if ($action === 'update_status') {
        $appt_id = (int) ($_POST['appt_id'] ?? 0);
        $new_status = $_POST['new_status'] ?? '';
        $valid_statuses = ['pending', 'confirmed', 'completed', 'cancelled'];

        if ($appt_id > 0 && in_array($new_status, $valid_statuses, true)) {
            $stmt = $pdo->prepare("UPDATE appointments SET status = ?, updated_at = NOW() WHERE id = ?");
            $stmt->execute([$new_status, $appt_id]);
            set_flash('success', "Appointment #{$appt_id} status updated to " . ucfirst($new_status) . ".");
        } else {
            set_flash('error', 'Invalid appointment or status value.');
        }
        header('Location: appointments.php');
        exit;
    }

    if ($action === 'update_notes') {
        $appt_id = (int) ($_POST['appt_id'] ?? 0);
        $notes = trim($_POST['admin_notes'] ?? '');
        if ($appt_id > 0) {
            $stmt = $pdo->prepare("UPDATE appointments SET admin_notes = ? WHERE id = ?");
            $stmt->execute([$notes, $appt_id]);
            set_flash('success', "Notes updated for appointment #{$appt_id}.");
        }
        header('Location: appointments.php');
        exit;
    }

    if ($action === 'delete') {
        $appt_id = (int) ($_POST['appt_id'] ?? 0);
        if ($appt_id > 0) {
            $stmt = $pdo->prepare("DELETE FROM appointments WHERE id = ?");
            $stmt->execute([$appt_id]);
            set_flash('success', "Appointment #{$appt_id} deleted successfully.");
        }
        header('Location: appointments.php');
        exit;
    }
}

// Filtering & Search
$status_filter = $_GET['status'] ?? 'all';
$date_filter = $_GET['date'] ?? '';
$search_query = trim($_GET['q'] ?? '');

$where_clauses = [];
$params = [];

if ($status_filter !== 'all' && in_array($status_filter, ['pending', 'confirmed', 'completed', 'cancelled'], true)) {
    $where_clauses[] = "status = ?";
    $params[] = $status_filter;
}

if (!empty($date_filter)) {
    $where_clauses[] = "appointment_date = ?";
    $params[] = $date_filter;
}

if (!empty($search_query)) {
    $where_clauses[] = "(first_name LIKE ? OR last_name LIKE ? OR email LIKE ? OR phone LIKE ? OR service_name LIKE ?)";
    $like_term = "%{$search_query}%";
    $params = array_merge($params, [$like_term, $like_term, $like_term, $like_term, $like_term]);
}

$where_sql = !empty($where_clauses) ? 'WHERE ' . implode(' AND ', $where_clauses) : '';

$sql = "SELECT * FROM appointments {$where_sql} ORDER BY appointment_date DESC, appointment_time DESC LIMIT 200";
$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$appointments = $stmt->fetchAll();

// Get counts for quick filters
$counts = [
    'all' => (int) $pdo->query("SELECT COUNT(*) FROM appointments")->fetchColumn(),
    'pending' => (int) $pdo->query("SELECT COUNT(*) FROM appointments WHERE status = 'pending'")->fetchColumn(),
    'confirmed' => (int) $pdo->query("SELECT COUNT(*) FROM appointments WHERE status = 'confirmed'")->fetchColumn(),
    'completed' => (int) $pdo->query("SELECT COUNT(*) FROM appointments WHERE status = 'completed'")->fetchColumn(),
    'cancelled' => (int) $pdo->query("SELECT COUNT(*) FROM appointments WHERE status = 'cancelled'")->fetchColumn(),
];

require_once __DIR__ . '/includes/header.php';
?>

<div class="page-header">
    <div>
        <h1 class="page-title">Appointments</h1>
        <p class="page-subtitle">Manage customer bookings, schedule updates, and service confirmations</p>
    </div>
</div>

<!-- Filters Bar -->
<div class="filters-bar" style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:16px;">
    <div style="display:flex; gap:10px; flex-wrap:wrap; align-items:center;">
        <a href="appointments.php" class="btn <?= $status_filter === 'all' && empty($date_filter) && empty($search_query) ? 'btn-gold' : 'btn-outline' ?> btn-sm">
            All (<?= $counts['all'] ?>)
        </a>
        <a href="appointments.php?status=pending" class="btn <?= $status_filter === 'pending' ? 'btn-gold' : 'btn-outline' ?> btn-sm">
            Pending (<?= $counts['pending'] ?>)
        </a>
        <a href="appointments.php?status=confirmed" class="btn <?= $status_filter === 'confirmed' ? 'btn-gold' : 'btn-outline' ?> btn-sm">
            Confirmed (<?= $counts['confirmed'] ?>)
        </a>
        <a href="appointments.php?status=completed" class="btn <?= $status_filter === 'completed' ? 'btn-gold' : 'btn-outline' ?> btn-sm">
            Completed (<?= $counts['completed'] ?>)
        </a>
        <a href="appointments.php?status=cancelled" class="btn <?= $status_filter === 'cancelled' ? 'btn-gold' : 'btn-outline' ?> btn-sm">
            Cancelled (<?= $counts['cancelled'] ?>)
        </a>
    </div>

    <form method="GET" action="appointments.php" style="display:flex; gap:10px; align-items:center;">
        <?php if ($status_filter !== 'all'): ?>
            <input type="hidden" name="status" value="<?= htmlspecialchars($status_filter) ?>">
        <?php endif; ?>
        <input type="date" name="date" value="<?= htmlspecialchars($date_filter) ?>" class="form-control" style="width:160px; padding:6px 12px; font-size:13px;">
        <input type="text" name="q" value="<?= htmlspecialchars($search_query) ?>" placeholder="Search client or service..." class="form-control" style="width:200px; padding:6px 12px; font-size:13px;">
        <button type="submit" class="btn btn-outline btn-sm"><i class="fas fa-search"></i></button>
        <?php if (!empty($date_filter) || !empty($search_query)): ?>
            <a href="appointments.php<?= $status_filter !== 'all' ? '?status=' . urlencode($status_filter) : '' ?>" class="btn btn-outline btn-sm" title="Clear search"><i class="fas fa-times"></i></a>
        <?php endif; ?>
    </form>
</div>

<!-- Appointments Table Card -->
<div class="admin-card">
    <div class="card-header">
        <h3 class="card-title">Bookings (<?= count($appointments) ?>)</h3>
    </div>

    <?php if (empty($appointments)): ?>
        <div class="empty-state">
            <i class="fas fa-calendar-check"></i>
            <h3>No appointments found</h3>
            <p>Try adjusting your search criteria or filters.</p>
        </div>
    <?php else: ?>
        <table class="admin-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Date & Time</th>
                    <th>Client Details</th>
                    <th>Service</th>
                    <th>Master Barber</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($appointments as $appt): ?>
                <tr>
                    <td><strong style="color:var(--admin-gold);">#<?= $appt['id'] ?></strong></td>
                    <td>
                        <div style="font-weight:600; color:var(--admin-text);"><?= date('M d, Y', strtotime($appt['appointment_date'])) ?></div>
                        <div style="font-size:12px; color:var(--admin-text-muted);"><?= date('g:i A', strtotime($appt['appointment_time'])) ?></div>
                    </td>
                    <td>
                        <div style="font-weight:600;"><?= htmlspecialchars($appt['first_name'] . ' ' . $appt['last_name']) ?></div>
                        <div style="font-size:12px; color:var(--admin-text-muted);"><i class="fas fa-envelope" style="font-size:10px; margin-right:4px;"></i><?= htmlspecialchars($appt['email']) ?></div>
                        <div style="font-size:12px; color:var(--admin-text-muted);"><i class="fas fa-phone" style="font-size:10px; margin-right:4px;"></i><?= htmlspecialchars($appt['phone']) ?></div>
                    </td>
                    <td>
                        <div style="font-weight:500;"><?= htmlspecialchars($appt['service_name']) ?></div>
                    </td>
                    <td>
                        <span style="font-size:13px; color:var(--admin-text);"><i class="fas fa-user-tie" style="color:var(--admin-gold); margin-right:6px;"></i><?= htmlspecialchars($appt['barber_name'] ?: 'Any Master') ?></span>
                    </td>
                    <td>
                        <form method="POST" action="appointments.php" style="display:inline;">
                            <input type="hidden" name="action" value="update_status">
                            <input type="hidden" name="appt_id" value="<?= $appt['id'] ?>">
                            <input type="hidden" name="csrf_token" value="<?= admin_csrf_token() ?>">
                            <select name="new_status" class="filter-select status-select" style="min-width:125px; padding:6px 10px; font-size:12px;">
                                <?php foreach (['pending', 'confirmed', 'completed', 'cancelled'] as $st): ?>
                                    <option value="<?= $st ?>" <?= $appt['status'] === $st ? 'selected' : '' ?>><?= ucfirst($st) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </form>
                    </td>
                    <td>
                        <div class="action-btns">
                            <button type="button" class="action-btn" title="View Details / Notes" onclick="openNotesModal(<?= htmlspecialchars(json_encode($appt)) ?>)">
                                <i class="fas fa-eye"></i>
                            </button>
                            <form method="POST" action="appointments.php" onsubmit="return confirmDelete(this, 'Appointment #<?= $appt['id'] ?> (<?= htmlspecialchars($appt['first_name']) ?>)')" style="display:inline;">
                                <input type="hidden" name="action" value="delete">
                                <input type="hidden" name="appt_id" value="<?= $appt['id'] ?>">
                                <input type="hidden" name="csrf_token" value="<?= admin_csrf_token() ?>">
                                <button type="submit" class="action-btn delete" title="Delete Booking"><i class="fas fa-trash-alt"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>

<!-- Details & Notes Modal -->
<div class="modal-overlay" id="apptModal">
    <div class="modal">
        <div class="modal-header">
            <h3 class="modal-title" id="modalApptTitle">Appointment Details</h3>
            <button class="modal-close" onclick="closeModal('apptModal')"><i class="fas fa-times"></i></button>
        </div>
        <div class="modal-body">
            <div id="modalApptDetails" style="margin-bottom:20px; font-size:14px; line-height:1.6;"></div>
            
            <form method="POST" action="appointments.php" id="modalNotesForm">
                <input type="hidden" name="action" value="update_notes">
                <input type="hidden" name="appt_id" id="modalApptId" value="">
                <input type="hidden" name="csrf_token" value="<?= admin_csrf_token() ?>">
                <div class="form-group">
                    <label class="form-label">Internal Admin Notes</label>
                    <textarea name="admin_notes" id="modalAdminNotes" class="form-control" rows="4" placeholder="Add private notes for staff..."></textarea>
                </div>
                <div class="modal-footer" style="padding:0; margin-top:20px; border-top:none;">
                    <button type="button" class="btn btn-outline" onclick="closeModal('apptModal')">Close</button>
                    <button type="submit" class="btn btn-gold">Save Notes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function openNotesModal(appt) {
    document.getElementById('modalApptTitle').innerText = `Booking #${appt.id} — ${appt.first_name} ${appt.last_name}`;
    document.getElementById('modalApptId').value = appt.id;
    document.getElementById('modalAdminNotes').value = appt.admin_notes || '';
    
    let html = `
        <div style="background:var(--admin-surface-2); padding:16px; border-radius:8px; margin-bottom:16px;">
            <p><strong>Client:</strong> ${appt.first_name} ${appt.last_name}</p>
            <p><strong>Email:</strong> ${appt.email} | <strong>Phone:</strong> ${appt.phone}</p>
            <p><strong>Service:</strong> ${appt.service_name}</p>
            <p><strong>Barber:</strong> ${appt.barber_name || 'Any Available Master'}</p>
            <p><strong>Date & Time:</strong> ${appt.appointment_date} at ${appt.appointment_time}</p>
            <p><strong>Status:</strong> <span class="badge badge-${appt.status}">${appt.status}</span></p>
            ${appt.message ? `<p style="margin-top:8px; border-top:1px solid var(--admin-border-light); padding-top:8px;"><strong>Client Note:</strong> <em>"${appt.message}"</em></p>` : ''}
        </div>
    `;
    document.getElementById('modalApptDetails').innerHTML = html;
    openModal('apptModal');
}
</script>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
