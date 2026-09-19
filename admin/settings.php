<?php
/**
 * Admin Settings Management
 * Kre8 Luxury Barbershop
 */
require_once __DIR__ . '/includes/auth.php';
require_admin_auth();

$page_title = 'Settings';
$pdo = get_db_connection();

// Handle POST updates
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $csrf = $_POST['csrf_token'] ?? '';
    if (!verify_admin_csrf($csrf)) {
        set_flash('error', 'Invalid security token.');
        header('Location: settings.php');
        exit;
    }

    $settings_input = $_POST['settings'] ?? [];

    if (!empty($settings_input) && is_array($settings_input)) {
        $stmt = $pdo->prepare("UPDATE settings SET setting_value = ?, updated_at = NOW() WHERE setting_key = ?");
        
        foreach ($settings_input as $key => $value) {
            $stmt->execute([trim($value), $key]);
        }

        set_flash('success', 'Global configuration settings saved.');
    }

    header('Location: settings.php');
    exit;
}

// Fetch all settings grouped
$all_settings = $pdo->query("SELECT * FROM settings ORDER BY setting_group ASC, id ASC")->fetchAll();

$grouped = [];
foreach ($all_settings as $s) {
    $grp = $s['setting_group'] ?: 'general';
    $grouped[$grp][] = $s;
}

require_once __DIR__ . '/includes/header.php';
?>

<div class="page-header">
    <div>
        <h1 class="page-title">Website Settings</h1>
        <p class="page-subtitle">Configure business contact details, branding, booking rules, and social links</p>
    </div>
</div>

<form method="POST" action="settings.php">
    <input type="hidden" name="csrf_token" value="<?= admin_csrf_token() ?>">

    <?php foreach ($grouped as $group_name => $settings_list): ?>
    <div class="admin-card">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-sliders-h" style="color:var(--admin-gold); margin-right:8px;"></i>
                <?= ucfirst($group_name) ?> Configuration
            </h3>
        </div>
        <div class="card-body">
            <div class="form-row" style="grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));">
                <?php foreach ($settings_list as $s): ?>
                <div class="form-group">
                    <label class="form-label">
                        <?= ucwords(str_replace('_', ' ', $s['setting_key'])) ?>
                    </label>
                    <?php if (strlen($s['setting_value'] ?? '') > 100 || strpos($s['setting_key'], 'address') !== false || strpos($s['setting_key'], 'description') !== false): ?>
                        <textarea name="settings[<?= htmlspecialchars($s['setting_key']) ?>]" class="form-control" rows="3"><?= htmlspecialchars($s['setting_value'] ?? '') ?></textarea>
                    <?php else: ?>
                        <input type="text" name="settings[<?= htmlspecialchars($s['setting_key']) ?>]" value="<?= htmlspecialchars($s['setting_value'] ?? '') ?>" class="form-control">
                    <?php endif; ?>
                    <?php if (!empty($s['description'])): ?>
                        <div style="font-size:11px; color:var(--admin-text-dim); margin-top:4px;"><?= htmlspecialchars($s['description']) ?></div>
                    <?php endif; ?>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    <?php endforeach; ?>

    <div style="margin-bottom:40px; display:flex; justify-content:flex-end;">
        <button type="submit" class="btn btn-gold" style="padding:12px 28px; font-size:15px;">
            <i class="fas fa-save"></i> Save All Settings
        </button>
    </div>
</form>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
