<?php
// Reset admin password and role in POS database
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'POS';

$newHash = '$2y$10$nmzEKbG/tMmHCX9dyHAu6.1XfsykLi4NZwBXH1JYpgOc5PN8T0O42'; // admin123

try {
    $pdo = new PDO("mysql:host=$host;dbname=$database", $username, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);

    // Check existence
    $exists = (int) $pdo->query("SELECT COUNT(*) FROM users WHERE username='admin'")->fetchColumn();
    if ($exists > 0) {
        $stmt = $pdo->prepare("UPDATE users SET password = :hash, role = 0 WHERE username = 'admin'");
        $stmt->execute([':hash' => $newHash]);
        $action = 'updated';
    } else {
        $stmt = $pdo->prepare("INSERT INTO users (username, password, role) VALUES ('admin', :hash, 0)");
        $stmt->execute([':hash' => $newHash]);
        $action = 'inserted';
    }

    $check = $pdo->query("SELECT id, username, role, LEFT(password, 20) AS pass_prefix FROM users WHERE username='admin' LIMIT 1")
        ->fetch();

    // Normalize role 'kasir' -> 'user' if any leftovers
    $pdo->exec("UPDATE users SET role='user' WHERE role='kasir'");

    echo "Admin $action.\n";
    echo "admin => id={$check['id']}, role={$check['role']}, pass_prefix={$check['pass_prefix']}...\n";
    echo "Done. Use username 'admin' and password 'admin123'.\n";
} catch (Throwable $e) {
    echo 'Error: ' . $e->getMessage() . "\n";
    exit(1);
}
?>