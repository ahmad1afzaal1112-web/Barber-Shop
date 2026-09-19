<?php
/**
 * Admin Barbers Management
 * Kre8 Luxury Barbershop
 */
require_once __DIR__ . '/includes/auth.php';
require_admin_auth();

$page_title = 'Barbers';
$pdo = get_db_connection();

// Handle POST actions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $csrf = $_POST['csrf_token'] ?? '';
    if (!verify_admin_csrf($csrf)) {
        set_flash('error', 'Invalid security token.');
        header('Location: barbers.php');
        exit;
    }

    $action = $_POST['action'] ?? '';

    if ($action === 'create' || $action === 'update') {
        $name = trim($_POST['name'] ?? '');
        $role = trim($_POST['role'] ?? 'Master Barber');
        $specialty = trim($_POST['specialty'] ?? 'Precision Scissor & Razor');
        $experience_years = (int) ($_POST['experience_years'] ?? 5);
        $bio = trim($_POST['bio'] ?? '');
        $image_url = trim($_POST['image_url'] ?? 'assets/images/barbers/barber1.jpg');
        $instagram_url = trim($_POST['instagram_url'] ?? '#');
        $facebook_url = trim($_POST['facebook_url'] ?? '#');
        $twitter_url = trim($_POST['twitter_url'] ?? '#');
        $sort_order = (int) ($_POST['sort_order'] ?? 0);
        $is_active = isset($_POST['is_active']) ? 1 : 0;

        if (empty($name)) {
            set_flash('error', 'Barber name is required.');
            header('Location: barbers.php');
            exit;
        }

        $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $name)));

        if ($action === 'create') {
            $stmt = $pdo->prepare("SELECT COUNT(*) FROM barbers WHERE slug = ?");
            $stmt->execute([$slug]);
            if ($stmt->fetchColumn() > 0) {
                $slug .= '-' . time();
            }

            $stmt = $pdo->prepare("INSERT INTO barbers (name, slug, role, specialty, experience_years, bio, image_url, instagram_url, facebook_url, twitter_url, sort_order, is_active) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([$name, $slug, $role, $specialty, $experience_years, $bio, $image_url, $instagram_url, $facebook_url, $twitter_url, $sort_order, $is_active]);
            set_flash('success', "Barber \"{$name}\" added successfully.");
        } else {
            $barber_id = (int) ($_POST['barber_id'] ?? 0);
            $stmt = $pdo->prepare("UPDATE barbers SET name = ?, role = ?, specialty = ?, experience_years = ?, bio = ?, image_url = ?, instagram_url = ?, facebook_url = ?, twitter_url = ?, sort_order = ?, is_active = ?, updated_at = NOW() WHERE id = ?");
            $stmt->execute([$name, $role, $specialty, $experience_years, $bio, $image_url, $instagram_url, $facebook_url, $twitter_url, $sort_order, $is_active, $barber_id]);
            set_flash('success', "Barber \"{$name}\" updated successfully.");
        }

        header('Location: barbers.php');
        exit;
    }

    if ($action === 'toggle_active') {
        $barber_id = (int) ($_POST['barber_id'] ?? 0);
        $stmt = $pdo->prepare("UPDATE barbers SET is_active = NOT is_active WHERE id = ?");
        $stmt->execute([$barber_id]);
        set_flash('success', "Barber active status toggled.");
        header('Location: barbers.php');
        exit;
    }

    if ($action === 'delete') {
        $barber_id = (int) ($_POST['barber_id'] ?? 0);
        if ($barber_id > 0) {
            $stmt = $pdo->prepare("DELETE FROM barbers WHERE id = ?");
            $stmt->execute([$barber_id]);
            set_flash('success', "Barber removed successfully.");
        }
        header('Location: barbers.php');
        exit;
    }
}

// Fetch all barbers
$barbers = $pdo->query("SELECT * FROM barbers ORDER BY sort_order ASC, id ASC")->fetchAll();

require_once __DIR__ . '/includes/header.php';
?>

<div class="page-header">
    <div>
        <h1 class="page-title">Master Barbers</h1>
        <p class="page-subtitle">Manage team profiles, bios, specialties, and active appointment availability</p>
    </div>
    <button type="button" class="btn btn-gold" onclick="openCreateBarberModal()">
        <i class="fas fa-plus"></i> Add Master Barber
    </button>
</div>

<!-- Barbers Grid -->
<div class="kpi-grid" style="grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));">
    <?php foreach ($barbers as $barber): ?>
    <div class="admin-card" style="margin-bottom:0; display:flex; flex-direction:column; justify-content:space-between;">
        <div class="card-body">
            <div style="display:flex; gap:16px; align-items:flex-start; margin-bottom:16px;">
                <img src="../<?= htmlspecialchars($barber['image_url']) ?>" alt="<?= htmlspecialchars($barber['name']) ?>" style="width:72px; height:72px; border-radius:50%; object-fit:cover; border:2px solid var(--admin-gold);" onerror="this.src='../assets/images/barbers/barber1.jpg'">
                <div style="flex:1;">
                    <h3 style="font-size:17px; font-weight:700; color:var(--admin-text); margin-bottom:2px;"><?= htmlspecialchars($barber['name']) ?></h3>
                    <div style="font-size:12px; color:var(--admin-gold); font-weight:600; text-transform:uppercase; letter-spacing:0.5px;"><?= htmlspecialchars($barber['role']) ?></div>
                    <div style="font-size:12px; color:var(--admin-text-muted); margin-top:4px;"><i class="fas fa-award" style="margin-right:4px;"></i><?= $barber['experience_years'] ?> Years Experience</div>
                </div>
            </div>

            <p style="font-size:13px; color:var(--admin-text-muted); line-height:1.5; margin-bottom:16px;">
                <?= htmlspecialchars(substr($barber['bio'] ?? '', 0, 110)) . (strlen($barber['bio'] ?? '') > 110 ? '...' : '') ?>
            </p>

            <div style="font-size:12px; color:var(--admin-text-dim); margin-bottom:12px;">
                <strong style="color:var(--admin-text-muted);">Specialty:</strong> <?= htmlspecialchars($barber['specialty']) ?>
            </div>

            <div style="display:flex; justify-content:space-between; align-items:center; border-top:1px solid var(--admin-border-light); padding-top:14px;">
                <form method="POST" action="barbers.php" style="display:inline;">
                    <input type="hidden" name="action" value="toggle_active">
                    <input type="hidden" name="barber_id" value="<?= $barber['id'] ?>">
                    <input type="hidden" name="csrf_token" value="<?= admin_csrf_token() ?>">
                    <button type="submit" class="badge badge-<?= $barber['is_active'] ? 'active' : 'inactive' ?>" style="cursor:pointer; border:none;">
                        <?= $barber['is_active'] ? 'Active' : 'Inactive' ?>
                    </button>
                </form>

                <div class="action-btns">
                    <button type="button" class="action-btn" title="Edit Barber" onclick="openEditBarberModal(<?= htmlspecialchars(json_encode($barber)) ?>)">
                        <i class="fas fa-pencil-alt"></i>
                    </button>
                    <form method="POST" action="barbers.php" onsubmit="return confirmDelete(this, '<?= htmlspecialchars($barber['name']) ?>')" style="display:inline;">
                        <input type="hidden" name="action" value="delete">
                        <input type="hidden" name="barber_id" value="<?= $barber['id'] ?>">
                        <input type="hidden" name="csrf_token" value="<?= admin_csrf_token() ?>">
                        <button type="submit" class="action-btn delete" title="Delete Barber"><i class="fas fa-trash-alt"></i></button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
</div>

<!-- Barber Modal (Create / Edit) -->
<div class="modal-overlay" id="barberModal">
    <div class="modal">
        <div class="modal-header">
            <h3 class="modal-title" id="barberModalTitle">Add Master Barber</h3>
            <button class="modal-close" onclick="closeModal('barberModal')"><i class="fas fa-times"></i></button>
        </div>
        <form method="POST" action="barbers.php" id="barberForm">
            <input type="hidden" name="action" id="barberFormAction" value="create">
            <input type="hidden" name="barber_id" id="barberFormId" value="">
            <input type="hidden" name="csrf_token" value="<?= admin_csrf_token() ?>">

            <div class="modal-body">
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Full Name *</label>
                        <input type="text" name="name" id="barberName" class="form-control" required placeholder="e.g. Marcus Vance">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Role Title *</label>
                        <input type="text" name="role" id="barberRole" class="form-control" required placeholder="e.g. Founder & Master Barber">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Specialty</label>
                        <input type="text" name="specialty" id="barberSpecialty" class="form-control" placeholder="e.g. Precision Scissor Work & Beard Shaping">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Experience (Years)</label>
                        <input type="number" name="experience_years" id="barberExp" class="form-control" value="8">
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Image Path / URL</label>
                    <input type="text" name="image_url" id="barberImage" class="form-control" placeholder="assets/images/barbers/barber1.jpg">
                </div>

                <div class="form-group">
                    <label class="form-label">Biography</label>
                    <textarea name="bio" id="barberBio" class="form-control" rows="3" placeholder="A short bio describing the barber's heritage, training and craft..."></textarea>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Instagram URL</label>
                        <input type="text" name="instagram_url" id="barberInsta" class="form-control" placeholder="https://instagram.com/...">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Sort Order</label>
                        <input type="number" name="sort_order" id="barberSort" class="form-control" value="0">
                    </div>
                </div>

                <div style="margin-top:10px;">
                    <label style="display:flex; align-items:center; gap:8px; cursor:pointer;">
                        <input type="checkbox" name="is_active" id="barberActive" value="1" checked>
                        <span>Active for Client Bookings</span>
                    </label>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-outline" onclick="closeModal('barberModal')">Cancel</button>
                <button type="submit" class="btn btn-gold" id="barberSubmitBtn">Save Barber</button>
            </div>
        </form>
    </div>
</div>

<script>
function openCreateBarberModal() {
    document.getElementById('barberModalTitle').innerText = 'Add Master Barber';
    document.getElementById('barberFormAction').value = 'create';
    document.getElementById('barberFormId').value = '';
    document.getElementById('barberForm').reset();
    document.getElementById('barberSubmitBtn').innerText = 'Add Barber';
    document.getElementById('barberActive').checked = true;
    openModal('barberModal');
}

function openEditBarberModal(barber) {
    document.getElementById('barberModalTitle').innerText = `Edit: ${barber.name}`;
    document.getElementById('barberFormAction').value = 'update';
    document.getElementById('barberFormId').value = barber.id;
    document.getElementById('barberName').value = barber.name || '';
    document.getElementById('barberRole').value = barber.role || '';
    document.getElementById('barberSpecialty').value = barber.specialty || '';
    document.getElementById('barberExp').value = barber.experience_years || 5;
    document.getElementById('barberImage').value = barber.image_url || '';
    document.getElementById('barberBio').value = barber.bio || '';
    document.getElementById('barberInsta').value = barber.instagram_url || '';
    document.getElementById('barberSort').value = barber.sort_order || 0;
    document.getElementById('barberActive').checked = barber.is_active == 1;
    document.getElementById('barberSubmitBtn').innerText = 'Save Changes';
    openModal('barberModal');
}
</script>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
