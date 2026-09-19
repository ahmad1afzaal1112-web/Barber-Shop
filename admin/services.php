<?php
/**
 * Admin Services Management
 * Kre8 Luxury Barbershop
 */
require_once __DIR__ . '/includes/auth.php';
require_admin_auth();

$page_title = 'Services';
$pdo = get_db_connection();

// Fetch categories for dropdowns
$categories = $pdo->query("SELECT * FROM service_categories ORDER BY sort_order ASC, name ASC")->fetchAll();

// Handle POST actions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $csrf = $_POST['csrf_token'] ?? '';
    if (!verify_admin_csrf($csrf)) {
        set_flash('error', 'Invalid security token.');
        header('Location: services.php');
        exit;
    }

    $action = $_POST['action'] ?? '';

    if ($action === 'create' || $action === 'update') {
        $title = trim($_POST['title'] ?? '');
        $category_id = !empty($_POST['category_id']) ? (int) $_POST['category_id'] : null;
        $price = (float) ($_POST['price'] ?? 0);
        $duration_minutes = (int) ($_POST['duration_minutes'] ?? 45);
        $duration = trim($_POST['duration'] ?? "{$duration_minutes} Mins");
        $description = trim($_POST['description'] ?? '');
        $badge = trim($_POST['badge'] ?? '');
        $icon_name = trim($_POST['icon_name'] ?? 'scissors');
        $is_featured = isset($_POST['is_featured']) ? 1 : 0;
        $is_active = isset($_POST['is_active']) ? 1 : 0;
        $sort_order = (int) ($_POST['sort_order'] ?? 0);

        // Features list
        $features_raw = trim($_POST['features'] ?? '');
        $features_array = array_filter(array_map('trim', explode("\n", str_replace("\r", "", $features_raw))));
        $features_json = !empty($features_array) ? json_encode(array_values($features_array)) : null;

        if (empty($title) || $price <= 0) {
            set_flash('error', 'Service title and a valid price are required.');
            header('Location: services.php');
            exit;
        }

        // Generate slug
        $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $title)));

        if ($action === 'create') {
            // Check unique slug
            $stmt = $pdo->prepare("SELECT COUNT(*) FROM services WHERE slug = ?");
            $stmt->execute([$slug]);
            if ($stmt->fetchColumn() > 0) {
                $slug .= '-' . time();
            }

            $stmt = $pdo->prepare("INSERT INTO services (category_id, title, slug, price, duration_minutes, duration, description, features_json, icon_name, badge, sort_order, is_featured, is_active) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([$category_id, $title, $slug, $price, $duration_minutes, $duration, $description, $features_json, $icon_name, $badge ?: null, $sort_order, $is_featured, $is_active]);
            set_flash('success', "Service \"{$title}\" created successfully.");
        } else {
            $service_id = (int) ($_POST['service_id'] ?? 0);
            $stmt = $pdo->prepare("UPDATE services SET category_id = ?, title = ?, price = ?, duration_minutes = ?, duration = ?, description = ?, features_json = ?, icon_name = ?, badge = ?, sort_order = ?, is_featured = ?, is_active = ?, updated_at = NOW() WHERE id = ?");
            $stmt->execute([$category_id, $title, $price, $duration_minutes, $duration, $description, $features_json, $icon_name, $badge ?: null, $sort_order, $is_featured, $is_active, $service_id]);
            set_flash('success', "Service \"{$title}\" updated successfully.");
        }

        header('Location: services.php');
        exit;
    }

    if ($action === 'toggle_active') {
        $service_id = (int) ($_POST['service_id'] ?? 0);
        $stmt = $pdo->prepare("UPDATE services SET is_active = NOT is_active WHERE id = ?");
        $stmt->execute([$service_id]);
        set_flash('success', "Service status updated.");
        header('Location: services.php');
        exit;
    }

    if ($action === 'delete') {
        $service_id = (int) ($_POST['service_id'] ?? 0);
        if ($service_id > 0) {
            $stmt = $pdo->prepare("DELETE FROM services WHERE id = ?");
            $stmt->execute([$service_id]);
            set_flash('success', "Service deleted successfully.");
        }
        header('Location: services.php');
        exit;
    }
}

// Fetch all services
$services = $pdo->query("SELECT s.*, c.name AS category_name FROM services s LEFT JOIN service_categories c ON s.category_id = c.id ORDER BY s.sort_order ASC, s.id ASC")->fetchAll();

require_once __DIR__ . '/includes/header.php';
?>

<div class="page-header">
    <div>
        <h1 class="page-title">Services & Pricing</h1>
        <p class="page-subtitle">Manage salon offerings, pricing, durations, features, and visibility</p>
    </div>
    <button type="button" class="btn btn-gold" onclick="openCreateServiceModal()">
        <i class="fas fa-plus"></i> Add New Service
    </button>
</div>

<!-- Services Table -->
<div class="admin-card">
    <div class="card-header">
        <h3 class="card-title">All Services (<?= count($services) ?>)</h3>
    </div>

    <?php if (empty($services)): ?>
        <div class="empty-state">
            <i class="fas fa-concierge-bell"></i>
            <h3>No services found</h3>
            <p>Click "Add New Service" to create your first grooming service.</p>
        </div>
    <?php else: ?>
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Sort</th>
                    <th>Service</th>
                    <th>Category</th>
                    <th>Price</th>
                    <th>Duration</th>
                    <th>Featured</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($services as $srv): ?>
                <tr>
                    <td style="color:var(--admin-text-dim);"><?= $srv['sort_order'] ?></td>
                    <td>
                        <div style="font-weight:600; color:var(--admin-text); display:flex; align-items:center; gap:8px;">
                            <i class="fas fa-<?= htmlspecialchars($srv['icon_name'] ?: 'scissors') ?>" style="color:var(--admin-gold);"></i>
                            <?= htmlspecialchars($srv['title']) ?>
                            <?php if (!empty($srv['badge'])): ?>
                                <span class="badge" style="background:var(--admin-gold-dim); color:var(--admin-gold); font-size:10px;"><?= htmlspecialchars($srv['badge']) ?></span>
                            <?php endif; ?>
                        </div>
                        <div style="font-size:12px; color:var(--admin-text-muted); margin-top:2px;">
                            <?= htmlspecialchars(substr($srv['description'], 0, 75)) . (strlen($srv['description']) > 75 ? '...' : '') ?>
                        </div>
                    </td>
                    <td><span class="badge" style="background:var(--admin-surface-2); color:var(--admin-text-muted);"><?= htmlspecialchars($srv['category_name'] ?: 'General') ?></span></td>
                    <td><strong style="color:var(--admin-gold); font-size:15px;">$<?= number_format($srv['price'], 2) ?></strong></td>
                    <td><?= htmlspecialchars($srv['duration'] ?: $srv['duration_minutes'] . ' Mins') ?></td>
                    <td>
                        <?= $srv['is_featured'] ? '<i class="fas fa-check-circle" style="color:var(--admin-success);" title="Featured"></i>' : '<i class="fas fa-minus-circle" style="color:var(--admin-text-dim);"></i>' ?>
                    </td>
                    <td>
                        <form method="POST" action="services.php" style="display:inline;">
                            <input type="hidden" name="action" value="toggle_active">
                            <input type="hidden" name="service_id" value="<?= $srv['id'] ?>">
                            <input type="hidden" name="csrf_token" value="<?= admin_csrf_token() ?>">
                            <button type="submit" class="badge badge-<?= $srv['is_active'] ? 'active' : 'inactive' ?>" style="cursor:pointer; border:none;">
                                <?= $srv['is_active'] ? 'Active' : 'Hidden' ?>
                            </button>
                        </form>
                    </td>
                    <td>
                        <div class="action-btns">
                            <button type="button" class="action-btn" title="Edit Service" onclick="openEditServiceModal(<?= htmlspecialchars(json_encode($srv)) ?>)">
                                <i class="fas fa-pencil-alt"></i>
                            </button>
                            <form method="POST" action="services.php" onsubmit="return confirmDelete(this, '<?= htmlspecialchars($srv['title']) ?>')" style="display:inline;">
                                <input type="hidden" name="action" value="delete">
                                <input type="hidden" name="service_id" value="<?= $srv['id'] ?>">
                                <input type="hidden" name="csrf_token" value="<?= admin_csrf_token() ?>">
                                <button type="submit" class="action-btn delete" title="Delete Service"><i class="fas fa-trash-alt"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>

<!-- Service Form Modal (Create / Edit) -->
<div class="modal-overlay" id="serviceModal">
    <div class="modal">
        <div class="modal-header">
            <h3 class="modal-title" id="serviceModalTitle">Add New Service</h3>
            <button class="modal-close" onclick="closeModal('serviceModal')"><i class="fas fa-times"></i></button>
        </div>
        <form method="POST" action="services.php" id="serviceForm">
            <input type="hidden" name="action" id="serviceFormAction" value="create">
            <input type="hidden" name="service_id" id="serviceFormId" value="">
            <input type="hidden" name="csrf_token" value="<?= admin_csrf_token() ?>">

            <div class="modal-body">
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Service Title *</label>
                        <input type="text" name="title" id="serviceTitle" class="form-control" required placeholder="e.g. Royal Executive Cut">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Category</label>
                        <select name="category_id" id="serviceCategory" class="form-control">
                            <option value="">-- No Category --</option>
                            <?php foreach ($categories as $cat): ?>
                                <option value="<?= $cat['id'] ?>"><?= htmlspecialchars($cat['name']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Price ($) *</label>
                        <input type="number" step="0.01" name="price" id="servicePrice" class="form-control" required placeholder="45.00">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Duration (Minutes)</label>
                        <input type="number" name="duration_minutes" id="serviceDurationMin" class="form-control" value="45">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Duration Display Text</label>
                        <input type="text" name="duration" id="serviceDurationText" class="form-control" placeholder="e.g. 45 Mins">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Badge (Optional)</label>
                        <input type="text" name="badge" id="serviceBadge" class="form-control" placeholder="e.g. Most Popular, Signature">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">FontAwesome Icon</label>
                        <input type="text" name="icon_name" id="serviceIcon" class="form-control" placeholder="scissors, crown, spa, eye...">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Sort Order</label>
                        <input type="number" name="sort_order" id="serviceSort" class="form-control" value="0">
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Description</label>
                    <textarea name="description" id="serviceDesc" class="form-control" rows="3" placeholder="Detailed service description..."></textarea>
                </div>

                <div class="form-group">
                    <label class="form-label">Bullet Features (One item per line)</label>
                    <textarea name="features" id="serviceFeatures" class="form-control" rows="4" placeholder="Precision Scissor & Razor Work&#10;Organic Essential Oil Hot Towel&#10;Scalp & Neck Massage"></textarea>
                </div>

                <div style="display:flex; gap:24px; margin-top:10px;">
                    <label style="display:flex; align-items:center; gap:8px; cursor:pointer;">
                        <input type="checkbox" name="is_featured" id="serviceFeatured" value="1" checked>
                        <span>Featured on Homepage</span>
                    </label>
                    <label style="display:flex; align-items:center; gap:8px; cursor:pointer;">
                        <input type="checkbox" name="is_active" id="serviceActive" value="1" checked>
                        <span>Active / Visible</span>
                    </label>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-outline" onclick="closeModal('serviceModal')">Cancel</button>
                <button type="submit" class="btn btn-gold" id="serviceSubmitBtn">Create Service</button>
            </div>
        </form>
    </div>
</div>

<script>
function openCreateServiceModal() {
    document.getElementById('serviceModalTitle').innerText = 'Add New Service';
    document.getElementById('serviceFormAction').value = 'create';
    document.getElementById('serviceFormId').value = '';
    document.getElementById('serviceForm').reset();
    document.getElementById('serviceSubmitBtn').innerText = 'Create Service';
    document.getElementById('serviceActive').checked = true;
    document.getElementById('serviceFeatured').checked = true;
    openModal('serviceModal');
}

function openEditServiceModal(srv) {
    document.getElementById('serviceModalTitle').innerText = `Edit: ${srv.title}`;
    document.getElementById('serviceFormAction').value = 'update';
    document.getElementById('serviceFormId').value = srv.id;
    document.getElementById('serviceTitle').value = srv.title || '';
    document.getElementById('serviceCategory').value = srv.category_id || '';
    document.getElementById('servicePrice').value = srv.price || '';
    document.getElementById('serviceDurationMin').value = srv.duration_minutes || 45;
    document.getElementById('serviceDurationText').value = srv.duration || '';
    document.getElementById('serviceBadge').value = srv.badge || '';
    document.getElementById('serviceIcon').value = srv.icon_name || 'scissors';
    document.getElementById('serviceSort').value = srv.sort_order || 0;
    document.getElementById('serviceDesc').value = srv.description || '';

    // Features
    let featuresStr = '';
    if (srv.features_json) {
        try {
            let parsed = JSON.parse(srv.features_json);
            if (Array.isArray(parsed)) {
                featuresStr = parsed.join('\n');
            }
        } catch(e) {}
    }
    document.getElementById('serviceFeatures').value = featuresStr;

    document.getElementById('serviceFeatured').checked = srv.is_featured == 1;
    document.getElementById('serviceActive').checked = srv.is_active == 1;
    document.getElementById('serviceSubmitBtn').innerText = 'Save Changes';
    openModal('serviceModal');
}
</script>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
