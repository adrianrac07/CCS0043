<?php
$_HOST = "sql210.infinityfree.com";
$DB_NAME = "if0_42409048_p6";
$DB_USER = "if0_42409048";
$DB_PASS = "hm6P4l7VviuVwj4";

try {
   $conn = new mysqli($HOST, $DB_USER, $DB_PASS, $DB_NAME);

}

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$conn->set_charset("utf8mb4");

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

$conn->query("ALTER TABLE users ADD COLUMN IF NOT EXISTS email VARCHAR(100) NULL");
$conn->query("ALTER TABLE users ADD COLUMN IF NOT EXISTS profile_image VARCHAR(255) NULL");

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

$conn->query("ALTER TABLE portfolio ADD COLUMN IF NOT EXISTS category ENUM('Web App','Study Material') NOT NULL DEFAULT 'Web App'");
$conn->query("ALTER TABLE portfolio ADD COLUMN IF NOT EXISTS link VARCHAR(255) NULL");

$conn->query("ALTER TABLE portfolio ADD COLUMN IF NOT EXISTS preview_image VARCHAR(255) NULL");

$conn->query("CREATE TABLE IF NOT EXISTS cms_pages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    page_name VARCHAR(50) NOT NULL UNIQUE,
    content TEXT
) ENGINE=InnoDB");

$conn->query("INSERT IGNORE INTO cms_pages (page_name, content) VALUES
    ('home', 'Welcome to my personal portfolio website.'),
    ('about', 'I am Adrian Rovic A. Corrales, a 2nd Year Student from FEU Institute of Technology, pursuing a degree in BSITCST. I have a strong passion for web development and enjoy creating dynamic and user-friendly websites.'),
    ('portfolio', 'A showcase of work and projects.')");

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
    $conn->query("INSERT INTO users (username, password, role, status) VALUES ('admin', '$defaultPassword', 'admin', 'active')");
}
