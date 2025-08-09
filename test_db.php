<?php
// Simple database test
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'POS';

echo "Testing database connection...\n";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$database", $username, $password);
    echo "✅ Database connected successfully!\n";
    
    // Test query
    $stmt = $pdo->query("SELECT COUNT(*) as count FROM users");
    $result = $stmt->fetch();
    echo "Users count: " . $result['count'] . "\n";
    
    if ($result['count'] > 0) {
        $stmt = $pdo->query("SELECT username, role FROM users");
        $users = $stmt->fetchAll();
        echo "Users in database:\n";
        foreach ($users as $user) {
            echo "- " . $user['username'] . " (role: " . $user['role'] . ")\n";
        }
    } else {
        echo "❌ No users found! Please import create_default_users.sql\n";
    }
    
} catch(PDOException $e) {
    echo "❌ Connection failed: " . $e->getMessage() . "\n";
}
?>
