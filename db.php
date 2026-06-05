<?php
$host = 'localhost';
$db   = 'fitness_tracker';
$user = 'fitness_user';
$pass = 'secure_password'; // Replace with the password set during installation
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    // In a production environment, errors should be logged rather than displayed
    exit("Database connection failed: " . $e->getMessage());
}
?>