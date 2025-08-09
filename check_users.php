<?php
// Script untuk mengecek data user di database
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'POS';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$database", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "=== Database Connection Test ===\n";
    echo "Connected to database successfully!\n\n";
    
    // Cek tabel users
    $stmt = $pdo->query("SELECT * FROM users");
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo "=== Users Data ===\n";
    if (empty($users)) {
        echo "No users found in database!\n";
        echo "Please import create_default_users.sql\n";
    } else {
        foreach ($users as $user) {
            echo "ID: " . $user['id'] . "\n";
            echo "Username: " . $user['username'] . "\n";
            echo "Role: " . $user['role'] . "\n";
            echo "Password Hash: " . substr($user['password'], 0, 20) . "...\n";
            echo "---\n";
        }
    }
    
    // Cek struktur tabel
    echo "\n=== Table Structure ===\n";
    $stmt = $pdo->query("DESCRIBE users");
    $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    foreach ($columns as $column) {
        echo $column['Field'] . " - " . $column['Type'] . "\n";
    }
    
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage() . "\n";
}
?>
