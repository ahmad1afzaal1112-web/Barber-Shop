<?php
/**
 * Admin Testimonials Management
 * Kre8 Luxury Barbershop
 */
require_once __DIR__ . '/includes/auth.php';
require_admin_auth();

$page_title = 'Testimonials';
$pdo = get_db_connection();

// Handle POST actions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $csrf = $_POST['csrf_token'] ?? '';
    if (!verify_admin_csrf($csrf)) {
        set_flash('error', 'Invalid security token.');
        header('Location: testimonials.php');
        exit;
    }

    $action = $_POST['action'] ?? '';

    if ($action === 'create' || $action === 'update') {
        $client_name = trim($_POST['client_name'] ?? '');
        $client_role = trim($_POST['client_role'] ?? 'VIP Client');
        $content = trim($_POST['content'] ?? '');
        $rating = (int) ($_POST['rating'] ?? 5);
        $service_received = trim($_POST['service_received'] ?? 'Signature Haircut');
        $is_featured = isset($_POST['is_featured']) ? 1 : 0;
        $is_active = isset($_POST['is_active']) ? 1 : 0;

        if (empty($client_name) || empty($content)) {
            set_flash('error', 'Client name and testimonial content are required.');
            header('Location: testimonials.php');
            exit;
        }

        if ($action === 'create') {
            $stmt = $pdo->prepare("INSERT INTO testimonials (client_name, client_role, content, rating, service_received, is_featured, is_active) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([$client_name, $client_role, $content, $rating, $service_received, $is_featured, $is_active]);
            set_flash('success', "Testimonial by \"{$client_name}\" added successfully.");
        } else {
            $test_id = (int) ($_POST['testimonial_id'] ?? 0);
            $stmt = $pdo->prepare("UPDATE testimonials SET client_name = ?, client_role = ?, content = ?, rating = ?, service_received = ?, is_featured = ?, is_active = ? WHERE id = ?");
            $stmt->execute([$client_name, $client_role, $content, $rating, $service_received, $is_featured, $is_active, $test_id]);
            set_flash('success', "Testimonial updated.");
        }

        header('Location: testimonials.php');
        exit;
    }

    if ($action === 'toggle_active') {
        $test_id = (int) ($_POST['testimonial_id'] ?? 0);
        $stmt = $pdo->prepare("UPDATE testimonials SET is_active = NOT is_active WHERE id = ?");
        $stmt->execute([$test_id]);
        set_flash('success', "Testimonial visibility updated.");
        header('Location: testimonials.php');
        exit;
    }

    if ($action === 'delete') {
        $test_id = (int) ($_POST['testimonial_id'] ?? 0);
        if ($test_id > 0) {
            $stmt = $pdo->prepare("DELETE FROM testimonials WHERE id = ?");
            $stmt->execute([$test_id]);
            set_flash('success', "Testimonial removed.");
        }
        header('Location: testimonials.php');
        exit;
    }
}

// Fetch testimonials
$testimonials = $pdo->query("SELECT * FROM testimonials ORDER BY id DESC")->fetchAll();

require_once __DIR__ . '/includes/header.php';
?>

<div class="page-header">
    <div>
        <h1 class="page-title">Client Testimonials</h1>
        <p class="page-subtitle">Manage client praise, star ratings, and verified review showcases</p>
    </div>
    <button type="button" class="btn btn-gold" onclick="openCreateTestimonialModal()">
        <i class="fas fa-plus"></i> Add Testimonial
    </button>
</div>

<!-- Testimonials Grid -->
<div class="kpi-grid" style="grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));">
    <?php foreach ($testimonials as $t): ?>
    <div class="admin-card" style="margin-bottom:0; display:flex; flex-direction:column; justify-content:space-between;">
        <div class="card-body">
            <div style="display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:12px;">
                <div>
                    <h4 style="font-size:16px; font-weight:700; color:var(--admin-text);"><?= htmlspecialchars($t['client_name']) ?></h4>
                    <span style="font-size:12px; color:var(--admin-text-muted);"><?= htmlspecialchars($t['client_role']) ?></span>
                </div>
                <div class="stars">
                    <?php for ($i = 1; $i <= 5; $i++): ?>
                        <i class="fas fa-star <?= $i <= $t['rating'] ? '' : 'dim' ?>"></i>
                    <?php endfor; ?>
                </div>
            </div>

            <p style="font-size:13px; color:var(--admin-text); font-style:italic; line-height:1.6; margin-bottom:16px; background:var(--admin-surface-2); padding:14px; border-radius:8px; border-left:3px solid var(--admin-gold);">
                "<?= htmlspecialchars($t['content']) ?>"
            </p>

            <div style="font-size:12px; color:var(--admin-text-dim); margin-bottom:12px;">
                <strong style="color:var(--admin-text-muted);">Service:</strong> <?= htmlspecialchars($t['service_received']) ?>
            </div>

            <div style="display:flex; justify-content:space-between; align-items:center; border-top:1px solid var(--admin-border-light); padding-top:12px;">
                <form method="POST" action="testimonials.php" style="display:inline;">
                    <input type="hidden" name="action" value="toggle_active">
                    <input type="hidden" name="testimonial_id" value="<?= $t['id'] ?>">
                    <input type="hidden" name="csrf_token" value="<?= admin_csrf_token() ?>">
                    <button type="submit" class="badge badge-<?= $t['is_active'] ? 'active' : 'inactive' ?>" style="cursor:pointer; border:none;">
                        <?= $t['is_active'] ? 'Approved / Active' : 'Hidden' ?>
                    </button>
                </form>

                <div class="action-btns">
                    <button type="button" class="action-btn" title="Edit Testimonial" onclick="openEditTestimonialModal(<?= htmlspecialchars(json_encode($t)) ?>)">
                        <i class="fas fa-pencil-alt"></i>
                    </button>
                    <form method="POST" action="testimonials.php" onsubmit="return confirmDelete(this, '<?= htmlspecialchars($t['client_name']) ?> review')" style="display:inline;">
                        <input type="hidden" name="action" value="delete">
                        <input type="hidden" name="testimonial_id" value="<?= $t['id'] ?>">
                        <input type="hidden" name="csrf_token" value="<?= admin_csrf_token() ?>">
                        <button type="submit" class="action-btn delete" title="Delete"><i class="fas fa-trash-alt"></i></button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
</div>

<!-- Testimonial Modal (Create / Edit) -->
<div class="modal-overlay" id="testimonialModal">
    <div class="modal">
        <div class="modal-header">
            <h3 class="modal-title" id="testModalTitle">Add Client Testimonial</h3>
            <button class="modal-close" onclick="closeModal('testimonialModal')"><i class="fas fa-times"></i></button>
        </div>
        <form method="POST" action="testimonials.php" id="testForm">
            <input type="hidden" name="action" id="testFormAction" value="create">
            <input type="hidden" name="testimonial_id" id="testFormId" value="">
            <input type="hidden" name="csrf_token" value="<?= admin_csrf_token() ?>">

            <div class="modal-body">
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Client Name *</label>
                        <input type="text" name="client_name" id="testClientName" class="form-control" required placeholder="e.g. David Ross">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Role / Tag</label>
                        <input type="text" name="client_role" id="testClientRole" class="form-control" placeholder="e.g. Entrepreneur, VIP Member">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Rating (1 to 5 Stars)</label>
                        <select name="rating" id="testRating" class="form-control">
                            <option value="5">★★★★★ (5 Stars)</option>
                            <option value="4">★★★★☆ (4 Stars)</option>
                            <option value="3">★★★☆☆ (3 Stars)</option>
                            <option value="2">★★☆☆☆ (2 Stars)</option>
                            <option value="1">★☆☆☆☆ (1 Star)</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Service Received</label>
                        <input type="text" name="service_received" id="testService" class="form-control" placeholder="e.g. Signature Haircut & Beard Sculpt">
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Testimonial Quote *</label>
                    <textarea name="content" id="testContent" class="form-control" rows="4" required placeholder="What did the client say about their visit?"></textarea>
                </div>

                <div style="display:flex; gap:24px; margin-top:10px;">
                    <label style="display:flex; align-items:center; gap:8px; cursor:pointer;">
                        <input type="checkbox" name="is_featured" id="testFeatured" value="1" checked>
                        <span>Feature on Homepage</span>
                    </label>
                    <label style="display:flex; align-items:center; gap:8px; cursor:pointer;">
                        <input type="checkbox" name="is_active" id="testActive" value="1" checked>
                        <span>Active / Approved</span>
                    </label>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-outline" onclick="closeModal('testimonialModal')">Cancel</button>
                <button type="submit" class="btn btn-gold" id="testSubmitBtn">Save Testimonial</button>
            </div>
        </form>
    </div>
</div>

<script>
function openCreateTestimonialModal() {
    document.getElementById('testModalTitle').innerText = 'Add Client Testimonial';
    document.getElementById('testFormAction').value = 'create';
    document.getElementById('testFormId').value = '';
    document.getElementById('testForm').reset();
    document.getElementById('testRating').value = '5';
    document.getElementById('testActive').checked = true;
    document.getElementById('testFeatured').checked = true;
    document.getElementById('testSubmitBtn').innerText = 'Add Testimonial';
    openModal('testimonialModal');
}

function openEditTestimonialModal(t) {
    document.getElementById('testModalTitle').innerText = `Edit: ${t.client_name}`;
    document.getElementById('testFormAction').value = 'update';
    document.getElementById('testFormId').value = t.id;
    document.getElementById('testClientName').value = t.client_name || '';
    document.getElementById('testClientRole').value = t.client_role || '';
    document.getElementById('testRating').value = t.rating || 5;
    document.getElementById('testService').value = t.service_received || '';
    document.getElementById('testContent').value = t.content || '';
    document.getElementById('testFeatured').checked = t.is_featured == 1;
    document.getElementById('testActive').checked = t.is_active == 1;
    document.getElementById('testSubmitBtn').innerText = 'Save Changes';
    openModal('testimonialModal');
}
</script>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
