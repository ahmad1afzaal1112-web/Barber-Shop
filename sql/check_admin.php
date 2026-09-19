<?php
require_once __DIR__ . '/../config/database.php';
$pdo = get_db_connection();
if ($pdo) {
    $hash = password_hash('Admin@12345', PASSWORD_DEFAULT);
    $pdo->prepare("UPDATE admins SET password_hash = ? WHERE username = 'admin'")->execute([$hash]);
    echo "Updated admin password to Admin@12345 (Hash: $hash)\n";
    
    $admin = $pdo->query("SELECT * FROM admins WHERE username = 'admin'")->fetch(PDO::FETCH_ASSOC);
    echo "Verify test: " . (password_verify('Admin@12345', $admin['password_hash']) ? 'SUCCESS' : 'FAILED') . "\n";
}
