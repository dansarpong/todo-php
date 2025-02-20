<?php
// config.php

// A simple function to load environment variables from a .env file.
function loadEnv($filePath) {
    if (!file_exists($filePath)) {
        return;
    }
    $lines = file($filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        // Skip comments
        if (strpos(trim($line), '#') === 0) {
            continue;
        }
        // Split into name and value
        list($name, $value) = explode("=", $line, 2);
        $name = trim($name);
        $value = trim($value);
        if (!array_key_exists($name, $_SERVER) && !array_key_exists($name, $_ENV)) {
            putenv(sprintf('%s=%s', $name, $value));
            $_ENV[$name] = $value;
            $_SERVER[$name] = $value;
        }
    }
}

// Load environment variables from the .env file
loadEnv(__DIR__ . '/.env');

// Retrieve database configuration from environment
$dbHost = getenv('DATABASE_HOST');
$dbPort = getenv('DATABASE_PORT');
$dbName = getenv('DATABASE_NAME');
$dbUser = getenv('DATABASE_USER');
$dbPass = getenv('DATABASE_PASSWORD');

// DSN for connecting without a database (to create it if needed)
$dsn = "mysql:host=$dbHost;port=$dbPort;charset=utf8";

// Connect to MySQL server
try {
    $pdo = new PDO($dsn, $dbUser, $dbPass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // Create the database if it doesn't exist
    $pdo->exec("CREATE DATABASE IF NOT EXISTS `$dbName` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// Now, connect to the specified database
$dsnDb = "mysql:host=$dbHost;port=$dbPort;dbname=$dbName;charset=utf8";
try {
    $db = new PDO($dsnDb, $dbUser, $dbPass);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // Create the todos table if it doesn't exist
    $db->exec("CREATE TABLE IF NOT EXISTS todos (
        id INT AUTO_INCREMENT PRIMARY KEY,
        task VARCHAR(255) NOT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>
