<?php
/**
 * Admin Gallery Management
 * Kre8 Luxury Barbershop
 */
require_once __DIR__ . '/includes/auth.php';
require_admin_auth();

$page_title = 'Gallery';
$pdo = get_db_connection();

// Handle POST actions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $csrf = $_POST['csrf_token'] ?? '';
    if (!verify_admin_csrf($csrf)) {
        set_flash('error', 'Invalid security token.');
        header('Location: gallery.php');
        exit;
    }

    $action = $_POST['action'] ?? '';

    if ($action === 'create' || $action === 'update') {
        $title = trim($_POST['title'] ?? '');
        $category = trim($_POST['category'] ?? 'Haircuts');
        $desc_text = trim($_POST['desc_text'] ?? '');
        $image_url = trim($_POST['image_url'] ?? '');
        $thumbnail_url = trim($_POST['thumbnail_url'] ?? $image_url);
        $sort_order = (int) ($_POST['sort_order'] ?? 0);
        $is_active = isset($_POST['is_active']) ? 1 : 0;

        if (empty($title) || empty($image_url)) {
            set_flash('error', 'Title and image path are required.');
            header('Location: gallery.php');
            exit;
        }

        $category_slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $category)));

        if ($action === 'create') {
            $stmt = $pdo->prepare("INSERT INTO gallery (title, category, category_slug, desc_text, image_url, thumbnail_url, sort_order, is_active) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([$title, $category, $category_slug, $desc_text, $image_url, $thumbnail_url, $sort_order, $is_active]);
            set_flash('success', "Gallery item \"{$title}\" added successfully.");
        } else {
            $gallery_id = (int) ($_POST['gallery_id'] ?? 0);
            $stmt = $pdo->prepare("UPDATE gallery SET title = ?, category = ?, category_slug = ?, desc_text = ?, image_url = ?, thumbnail_url = ?, sort_order = ?, is_active = ? WHERE id = ?");
            $stmt->execute([$title, $category, $category_slug, $desc_text, $image_url, $thumbnail_url, $sort_order, $is_active, $gallery_id]);
            set_flash('success', "Gallery item \"{$title}\" updated.");
        }

        header('Location: gallery.php');
        exit;
    }

    if ($action === 'toggle_active') {
        $gallery_id = (int) ($_POST['gallery_id'] ?? 0);
        $stmt = $pdo->prepare("UPDATE gallery SET is_active = NOT is_active WHERE id = ?");
        $stmt->execute([$gallery_id]);
        set_flash('success', "Gallery item visibility updated.");
        header('Location: gallery.php');
        exit;
    }

    if ($action === 'delete') {
        $gallery_id = (int) ($_POST['gallery_id'] ?? 0);
        if ($gallery_id > 0) {
            $stmt = $pdo->prepare("DELETE FROM gallery WHERE id = ?");
            $stmt->execute([$gallery_id]);
            set_flash('success', "Gallery item removed successfully.");
        }
        header('Location: gallery.php');
        exit;
    }
}

// Filter
$cat_filter = $_GET['cat'] ?? 'all';
$where_sql = $cat_filter !== 'all' ? "WHERE category_slug = ?" : "";
$params = $cat_filter !== 'all' ? [$cat_filter] : [];

$stmt = $pdo->prepare("SELECT * FROM gallery {$where_sql} ORDER BY sort_order ASC, id DESC");
$stmt->execute($params);
$gallery_items = $stmt->fetchAll();

// Distinct categories for filter
$cats = $pdo->query("SELECT DISTINCT category, category_slug FROM gallery ORDER BY category ASC")->fetchAll();

require_once __DIR__ . '/includes/header.php';
?>

<div class="page-header">
    <div>
        <h1 class="page-title">Gallery Portfolio</h1>
        <p class="page-subtitle">Manage high-resolution lookbook images and client showcase cuts</p>
    </div>
    <button type="button" class="btn btn-gold" onclick="openCreateGalleryModal()">
        <i class="fas fa-plus"></i> Add Gallery Item
    </button>
</div>

<!-- Filter Bar -->
<div class="filters-bar">
    <a href="gallery.php" class="btn <?= $cat_filter === 'all' ? 'btn-gold' : 'btn-outline' ?> btn-sm">All (<?= $pdo->query("SELECT COUNT(*) FROM gallery")->fetchColumn() ?>)</a>
    <?php foreach ($cats as $c): ?>
        <a href="gallery.php?cat=<?= urlencode($c['category_slug']) ?>" class="btn <?= $cat_filter === $c['category_slug'] ? 'btn-gold' : 'btn-outline' ?> btn-sm">
            <?= htmlspecialchars($c['category']) ?>
        </a>
    <?php endforeach; ?>
</div>

<!-- Gallery Grid -->
<div class="kpi-grid" style="grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));">
    <?php foreach ($gallery_items as $item): ?>
    <div class="admin-card" style="margin-bottom:0; overflow:hidden;">
        <div style="position:relative; height:180px; overflow:hidden; background:var(--admin-surface-2);">
            <img src="../<?= htmlspecialchars($item['image_url']) ?>" alt="<?= htmlspecialchars($item['title']) ?>" style="width:100%; height:100%; object-fit:cover;" onerror="this.src='../assets/images/gallery/cut1.jpg'">
            <span class="badge" style="position:absolute; top:10px; left:10px; background:rgba(0,0,0,0.7); backdrop-filter:blur(4px); color:var(--admin-gold);">
                <?= htmlspecialchars($item['category']) ?>
            </span>
        </div>
        <div class="card-body" style="padding:16px;">
            <h4 style="font-size:15px; font-weight:600; color:var(--admin-text); margin-bottom:4px;"><?= htmlspecialchars($item['title']) ?></h4>
            <p style="font-size:12px; color:var(--admin-text-muted); margin-bottom:12px;">
                <?= htmlspecialchars($item['desc_text'] ?: 'No caption provided') ?>
            </p>

            <div style="display:flex; justify-content:space-between; align-items:center; border-top:1px solid var(--admin-border-light); padding-top:10px;">
                <form method="POST" action="gallery.php" style="display:inline;">
                    <input type="hidden" name="action" value="toggle_active">
                    <input type="hidden" name="gallery_id" value="<?= $item['id'] ?>">
                    <input type="hidden" name="csrf_token" value="<?= admin_csrf_token() ?>">
                    <button type="submit" class="badge badge-<?= $item['is_active'] ? 'active' : 'inactive' ?>" style="cursor:pointer; border:none; font-size:11px;">
                        <?= $item['is_active'] ? 'Published' : 'Hidden' ?>
                    </button>
                </form>

                <div class="action-btns">
                    <button type="button" class="action-btn" title="Edit Item" onclick="openEditGalleryModal(<?= htmlspecialchars(json_encode($item)) ?>)">
                        <i class="fas fa-pencil-alt"></i>
                    </button>
                    <form method="POST" action="gallery.php" onsubmit="return confirmDelete(this, '<?= htmlspecialchars($item['title']) ?>')" style="display:inline;">
                        <input type="hidden" name="action" value="delete">
                        <input type="hidden" name="gallery_id" value="<?= $item['id'] ?>">
                        <input type="hidden" name="csrf_token" value="<?= admin_csrf_token() ?>">
                        <button type="submit" class="action-btn delete" title="Delete Item"><i class="fas fa-trash-alt"></i></button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
</div>

<!-- Gallery Modal (Create / Edit) -->
<div class="modal-overlay" id="galleryModal">
    <div class="modal">
        <div class="modal-header">
            <h3 class="modal-title" id="galleryModalTitle">Add Gallery Showcase Item</h3>
            <button class="modal-close" onclick="closeModal('galleryModal')"><i class="fas fa-times"></i></button>
        </div>
        <form method="POST" action="gallery.php" id="galleryForm">
            <input type="hidden" name="action" id="galleryFormAction" value="create">
            <input type="hidden" name="gallery_id" id="galleryFormId" value="">
            <input type="hidden" name="csrf_token" value="<?= admin_csrf_token() ?>">

            <div class="modal-body">
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Title / Style Name *</label>
                        <input type="text" name="title" id="galleryTitle" class="form-control" required placeholder="e.g. Skin Fade Pompadour">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Category *</label>
                        <input type="text" name="category" id="galleryCategory" class="form-control" required placeholder="Haircuts, Beards, Shaves...">
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Image Path / URL *</label>
                    <input type="text" name="image_url" id="galleryImage" class="form-control" required placeholder="assets/images/gallery/cut1.jpg">
                </div>

                <div class="form-group">
                    <label class="form-label">Caption / Description</label>
                    <input type="text" name="desc_text" id="galleryDesc" class="form-control" placeholder="e.g. Seamless skin fade with textured crop styling">
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Sort Order</label>
                        <input type="number" name="sort_order" id="gallerySort" class="form-control" value="0">
                    </div>
                    <div class="form-group" style="display:flex; align-items:flex-end; padding-bottom:10px;">
                        <label style="display:flex; align-items:center; gap:8px; cursor:pointer;">
                            <input type="checkbox" name="is_active" id="galleryActive" value="1" checked>
                            <span>Published on Website</span>
                        </label>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-outline" onclick="closeModal('galleryModal')">Cancel</button>
                <button type="submit" class="btn btn-gold" id="gallerySubmitBtn">Save Item</button>
            </div>
        </form>
    </div>
</div>

<script>
function openCreateGalleryModal() {
    document.getElementById('galleryModalTitle').innerText = 'Add Gallery Showcase Item';
    document.getElementById('galleryFormAction').value = 'create';
    document.getElementById('galleryFormId').value = '';
    document.getElementById('galleryForm').reset();
    document.getElementById('gallerySubmitBtn').innerText = 'Add Image';
    document.getElementById('galleryActive').checked = true;
    openModal('galleryModal');
}

function openEditGalleryModal(item) {
    document.getElementById('galleryModalTitle').innerText = `Edit: ${item.title}`;
    document.getElementById('galleryFormAction').value = 'update';
    document.getElementById('galleryFormId').value = item.id;
    document.getElementById('galleryTitle').value = item.title || '';
    document.getElementById('galleryCategory').value = item.category || '';
    document.getElementById('galleryImage').value = item.image_url || '';
    document.getElementById('galleryDesc').value = item.desc_text || '';
    document.getElementById('gallerySort').value = item.sort_order || 0;
    document.getElementById('galleryActive').checked = item.is_active == 1;
    document.getElementById('gallerySubmitBtn').innerText = 'Save Changes';
    openModal('galleryModal');
}
</script>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
