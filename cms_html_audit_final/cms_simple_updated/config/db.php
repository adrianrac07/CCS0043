<?php
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

$DB_HOST = "sql203.infinityfree.com";
$DB_NAME = "if0_42397363_1tech";
$DB_USER = "if0_42397363";
$DB_PASS = "Iw6urXQlLn";

try {
    $conn = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
    $conn->set_charset("utf8mb4");

    $conn->query("CREATE TABLE IF NOT EXISTS users (
        id INT AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(50) NOT NULL UNIQUE,
        password VARCHAR(255) NOT NULL,
        role ENUM('admin','user') NOT NULL DEFAULT 'user',
        status ENUM('active','blocked') NOT NULL DEFAULT 'active',
        created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB");

    $conn->query("CREATE TABLE IF NOT EXISTS contact_messages (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(100),
        email VARCHAR(100),
        message TEXT,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB");

    $conn->query("CREATE TABLE IF NOT EXISTS portfolio (
        id INT AUTO_INCREMENT PRIMARY KEY,
        title VARCHAR(150),
        description TEXT,
        image VARCHAR(255),
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB");

    $conn->query("CREATE TABLE IF NOT EXISTS cms_pages (
        id INT AUTO_INCREMENT PRIMARY KEY,
        page_name VARCHAR(50) NOT NULL UNIQUE,
        content TEXT
    ) ENGINE=InnoDB");

    $conn->query("CREATE TABLE IF NOT EXISTS documentation (
        id INT AUTO_INCREMENT PRIMARY KEY,
        file_name VARCHAR(255),
        file_path VARCHAR(255),
        uploaded_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB");

    if (!is_dir(__DIR__ . "/../uploads")) {
        mkdir(__DIR__ . "/../uploads", 0777, true);
    }
    if (!is_dir(__DIR__ . "/../uploads/profiles")) {
        mkdir(__DIR__ . "/../uploads/profiles", 0777, true);
    }
    if (!is_dir(__DIR__ . "/../uploads/portfolio")) {
        mkdir(__DIR__ . "/../uploads/portfolio", 0777, true);
    }
    if (!is_dir(__DIR__ . "/../uploads/documentation")) {
        mkdir(__DIR__ . "/../uploads/documentation", 0777, true);
    }

    $checkAdmin = $conn->query("SELECT id FROM users WHERE role = 'admin'");
    if ($checkAdmin->num_rows == 0) {
        $defaultPassword = password_hash("Admin123!", PASSWORD_DEFAULT);
        $stmt = $conn->prepare("INSERT INTO users (username, password, role, status) VALUES (?, ?, 'admin', 'active')");
        $username = "admin";
        $stmt->bind_param("ss", $username, $defaultPassword);
        $stmt->execute();
    }

} catch (mysqli_sql_exception $e) {
    die("Database error: " . $e->getMessage());
}