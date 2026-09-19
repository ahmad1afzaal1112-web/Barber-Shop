<?php
$passwords = ['', 'root', 'admin', 'password', '123456', 'mysql', 'root123', 'toor', '1234'];
$hosts = ['127.0.0.1', 'localhost'];

foreach ($hosts as $h) {
    foreach ($passwords as $p) {
        try {
            $pdo = new PDO("mysql:host={$h};port=3306", 'root', $p, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
            echo "SUCCESS: Host={$h}, User=root, Password='{$p}'\n";
            exit(0);
        } catch (Exception $e) {
            // continue
        }
    }
}

echo "Could not find root password among common defaults.\n";
