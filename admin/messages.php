<?php
/**
 * Admin Contact Messages Management
 * Kre8 Luxury Barbershop
 */
require_once __DIR__ . '/includes/auth.php';
require_admin_auth();

$page_title = 'Contact Inquiries';
$pdo = get_db_connection();

// Handle POST actions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $csrf = $_POST['csrf_token'] ?? '';
    if (!verify_admin_csrf($csrf)) {
        set_flash('error', 'Invalid security token.');
        header('Location: messages.php');
        exit;
    }

    $action = $_POST['action'] ?? '';

    if ($action === 'toggle_read') {
        $msg_id = (int) ($_POST['message_id'] ?? 0);
        $stmt = $pdo->prepare("UPDATE contact_messages SET is_read = NOT is_read WHERE id = ?");
        $stmt->execute([$msg_id]);
        set_flash('success', "Message status updated.");
        header('Location: messages.php');
        exit;
    }

    if ($action === 'mark_all_read') {
        $pdo->query("UPDATE contact_messages SET is_read = 1 WHERE is_read = 0");
        set_flash('success', "All messages marked as read.");
        header('Location: messages.php');
        exit;
    }

    if ($action === 'delete') {
        $msg_id = (int) ($_POST['message_id'] ?? 0);
        if ($msg_id > 0) {
            $stmt = $pdo->prepare("DELETE FROM contact_messages WHERE id = ?");
            $stmt->execute([$msg_id]);
            set_flash('success', "Message deleted.");
        }
        header('Location: messages.php');
        exit;
    }
}

// Filtering
$filter = $_GET['filter'] ?? 'all';
$where_sql = '';
if ($filter === 'unread') {
    $where_sql = 'WHERE is_read = 0';
} elseif ($filter === 'read') {
    $where_sql = 'WHERE is_read = 1';
}

$messages = $pdo->query("SELECT * FROM contact_messages {$where_sql} ORDER BY created_at DESC")->fetchAll();

$unread_count = (int) $pdo->query("SELECT COUNT(*) FROM contact_messages WHERE is_read = 0")->fetchColumn();
$total_count = (int) $pdo->query("SELECT COUNT(*) FROM contact_messages")->fetchColumn();

require_once __DIR__ . '/includes/header.php';
?>

<div class="page-header">
    <div>
        <h1 class="page-title">Client Inquiries</h1>
        <p class="page-subtitle">Incoming queries from the website contact form</p>
    </div>
    <?php if ($unread_count > 0): ?>
    <form method="POST" action="messages.php">
        <input type="hidden" name="action" value="mark_all_read">
        <input type="hidden" name="csrf_token" value="<?= admin_csrf_token() ?>">
        <button type="submit" class="btn btn-outline btn-sm">
            <i class="fas fa-check-double"></i> Mark All as Read
        </button>
    </form>
    <?php endif; ?>
</div>

<!-- Filters Bar -->
<div class="filters-bar">
    <a href="messages.php" class="btn <?= $filter === 'all' ? 'btn-gold' : 'btn-outline' ?> btn-sm">
        All Messages (<?= $total_count ?>)
    </a>
    <a href="messages.php?filter=unread" class="btn <?= $filter === 'unread' ? 'btn-gold' : 'btn-outline' ?> btn-sm">
        Unread (<?= $unread_count ?>)
    </a>
    <a href="messages.php?filter=read" class="btn <?= $filter === 'read' ? 'btn-gold' : 'btn-outline' ?> btn-sm">
        Read (<?= $total_count - $unread_count ?>)
    </a>
</div>

<!-- Messages Table -->
<div class="admin-card">
    <div class="card-header">
        <h3 class="card-title">Inquiries List (<?= count($messages) ?>)</h3>
    </div>

    <?php if (empty($messages)): ?>
        <div class="empty-state">
            <i class="fas fa-inbox"></i>
            <h3>No messages found</h3>
            <p>New inquiries submitted from the contact form will appear here.</p>
        </div>
    <?php else: ?>
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Status</th>
                    <th>Sender</th>
                    <th>Subject</th>
                    <th>Preview</th>
                    <th>Date Received</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($messages as $msg): ?>
                <tr style="<?= !$msg['is_read'] ? 'background:rgba(193, 163, 104, 0.04);' : '' ?>">
                    <td>
                        <form method="POST" action="messages.php" style="display:inline;">
                            <input type="hidden" name="action" value="toggle_read">
                            <input type="hidden" name="message_id" value="<?= $msg['id'] ?>">
                            <input type="hidden" name="csrf_token" value="<?= admin_csrf_token() ?>">
                            <button type="submit" class="badge badge-<?= $msg['is_read'] ? 'completed' : 'pending' ?>" style="cursor:pointer; border:none; font-size:11px;">
                                <?= $msg['is_read'] ? 'Read' : 'Unread' ?>
                            </button>
                        </form>
                    </td>
                    <td>
                        <div style="font-weight:600; color:var(--admin-text);"><?= htmlspecialchars($msg['name']) ?></div>
                        <div style="font-size:12px; color:var(--admin-text-muted);"><i class="fas fa-envelope" style="font-size:10px; margin-right:4px;"></i><?= htmlspecialchars($msg['email']) ?></div>
                        <?php if (!empty($msg['phone'])): ?>
                            <div style="font-size:12px; color:var(--admin-text-muted);"><i class="fas fa-phone" style="font-size:10px; margin-right:4px;"></i><?= htmlspecialchars($msg['phone']) ?></div>
                        <?php endif; ?>
                    </td>
                    <td><strong style="color:var(--admin-text); font-size:13px;"><?= htmlspecialchars($msg['subject'] ?: 'General Inquiry') ?></strong></td>
                    <td style="max-width:280px;">
                        <span style="font-size:13px; color:var(--admin-text-muted);">
                            <?= htmlspecialchars(substr($msg['message'], 0, 80)) . (strlen($msg['message']) > 80 ? '...' : '') ?>
                        </span>
                    </td>
                    <td>
                        <div style="font-size:13px; color:var(--admin-text);"><?= date('M d, Y', strtotime($msg['created_at'])) ?></div>
                        <div style="font-size:11px; color:var(--admin-text-muted);"><?= date('g:i A', strtotime($msg['created_at'])) ?></div>
                    </td>
                    <td>
                        <div class="action-btns">
                            <button type="button" class="action-btn" title="View Full Message" onclick="openMessageModal(<?= htmlspecialchars(json_encode($msg)) ?>)">
                                <i class="fas fa-envelope-open-text"></i>
                            </button>
                            <a href="mailto:<?= htmlspecialchars($msg['email']) ?>?subject=Re: <?= urlencode($msg['subject'] ?: 'Your Kre8 Barbershop Inquiry') ?>" class="action-btn" title="Reply via Email" target="_blank">
                                <i class="fas fa-reply"></i>
                            </a>
                            <form method="POST" action="messages.php" onsubmit="return confirmDelete(this, 'Message from <?= htmlspecialchars($msg['name']) ?>')" style="display:inline;">
                                <input type="hidden" name="action" value="delete">
                                <input type="hidden" name="message_id" value="<?= $msg['id'] ?>">
                                <input type="hidden" name="csrf_token" value="<?= admin_csrf_token() ?>">
                                <button type="submit" class="action-btn delete" title="Delete Inquiry"><i class="fas fa-trash-alt"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>

<!-- View Message Modal -->
<div class="modal-overlay" id="messageModal">
    <div class="modal">
        <div class="modal-header">
            <h3 class="modal-title" id="msgModalSubject">Message Details</h3>
            <button class="modal-close" onclick="closeModal('messageModal')"><i class="fas fa-times"></i></button>
        </div>
        <div class="modal-body">
            <div id="msgModalContent" style="font-size:14px; line-height:1.6;"></div>
        </div>
        <div class="modal-footer">
            <a href="#" id="msgReplyBtn" class="btn btn-gold" target="_blank"><i class="fas fa-reply"></i> Reply via Email</a>
            <button type="button" class="btn btn-outline" onclick="closeModal('messageModal')">Close</button>
        </div>
    </div>
</div>

<script>
function openMessageModal(msg) {
    document.getElementById('msgModalSubject').innerText = msg.subject ? msg.subject : `Inquiry from ${msg.name}`;
    document.getElementById('msgReplyBtn').href = `mailto:${encodeURIComponent(msg.email)}?subject=${encodeURIComponent('Re: ' + (msg.subject || 'Your Kre8 Barbershop Inquiry'))}`;

    let html = `
        <div style="background:var(--admin-surface-2); padding:16px; border-radius:8px; margin-bottom:16px;">
            <p><strong>From:</strong> ${msg.name}</p>
            <p><strong>Email:</strong> <a href="mailto:${msg.email}" style="color:var(--admin-gold); text-decoration:none;">${msg.email}</a></p>
            ${msg.phone ? `<p><strong>Phone:</strong> ${msg.phone}</p>` : ''}
            <p><strong>Received:</strong> ${msg.created_at}</p>
        </div>
        <div style="background:var(--admin-surface-3); padding:16px; border-radius:8px; border-left:3px solid var(--admin-gold); white-space:pre-wrap; color:var(--admin-text);">
            ${msg.message}
        </div>
    `;
    document.getElementById('msgModalContent').innerHTML = html;
    openModal('messageModal');
}
</script>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
