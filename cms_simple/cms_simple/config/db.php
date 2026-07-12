<?php
// Simple MySQLi database connection
$conn = new mysqli("localhost", "root", "", "cms_db");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$conn->set_charset("utf8mb4");

// Create the tables we need if they do not exist yet.
$conn->query("CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin','user') NOT NULL DEFAULT 'user',
    status ENUM('active','blocked') NOT NULL DEFAULT 'active',
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB");

$conn->query("ALTER TABLE users ADD COLUMN IF NOT EXISTS role ENUM('admin','user') NOT NULL DEFAULT 'user'");
$conn->query("ALTER TABLE users ADD COLUMN IF NOT EXISTS status ENUM('active','blocked') NOT NULL DEFAULT 'active'");
$conn->query("ALTER TABLE users ADD COLUMN IF NOT EXISTS created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP");

$conn->query("CREATE TABLE IF NOT EXISTS subjects (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL UNIQUE
) ENGINE=InnoDB");

$conn->query("CREATE TABLE IF NOT EXISTS files (
    id INT AUTO_INCREMENT PRIMARY KEY,
    subject_id INT NOT NULL,
    filename VARCHAR(255) NOT NULL,
    uploaded_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (subject_id) REFERENCES subjects(id) ON DELETE CASCADE
) ENGINE=InnoDB");

if (!is_dir(__DIR__ . "/../uploads")) {
    mkdir(__DIR__ . "/../uploads", 0777, true);
}

$checkAdmin = $conn->query("SELECT id FROM users WHERE role = 'admin'");
if ($checkAdmin->num_rows == 0) {
    $defaultPassword = password_hash("Admin123!", PASSWORD_DEFAULT);
    $conn->query("INSERT INTO users (username, password, role, status) VALUES ('admin', '$defaultPassword', 'admin', 'active')");
}
