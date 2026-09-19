<?php
try {
    $pdo = new PDO('mysql:host=127.0.0.1;port=3307;dbname=kre8_barbershop;charset=utf8mb4', 'root', '', [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    ]);
    $tables = $pdo->query('SHOW TABLES')->fetchAll(PDO::FETCH_COLUMN);
    echo "DB connected. Tables: " . implode(', ', $tables) . "\n";
    echo "Count: " . count($tables) . "\n";
} catch(Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
}
