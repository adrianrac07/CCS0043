<?php
// Simple MySQLi database connection
$host = 'localhost';
$user = 'root';
$pass ='';
$name = 'cms_db';

$conn = new mysqli($host, $user, $pass, $name);


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

// New optional columns for the Profile feature (nullable so existing users/rows are not affected)
$conn->query("ALTER TABLE users ADD COLUMN IF NOT EXISTS email VARCHAR(100) NULL");
$conn->query("ALTER TABLE users ADD COLUMN IF NOT EXISTS profile_image VARCHAR(255) NULL");

// Contact messages table (Contact Module feature)
$conn->query("CREATE TABLE IF NOT EXISTS contact_messages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100),
    email VARCHAR(100),
    message TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB");

// Portfolio table (Portfolio System feature)
$conn->query("CREATE TABLE IF NOT EXISTS portfolio (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(150),
    description TEXT,
    image VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB");

// Minimal extra columns for the Portfolio Category feature (Web App / Study Material)
$conn->query("ALTER TABLE portfolio ADD COLUMN IF NOT EXISTS category ENUM('Web App','Study Material') NOT NULL DEFAULT 'Web App'");
$conn->query("ALTER TABLE portfolio ADD COLUMN IF NOT EXISTS link VARCHAR(255) NULL");

// Web App thumbnail image (separate from "image", which is used for the Study Material document)
$conn->query("ALTER TABLE portfolio ADD COLUMN IF NOT EXISTS preview_image VARCHAR(255) NULL");

// CMS pages table (CMS Content System feature) - lets admin edit Home / About / Portfolio content
$conn->query("CREATE TABLE IF NOT EXISTS cms_pages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    page_name VARCHAR(50) NOT NULL UNIQUE,
    content TEXT
) ENGINE=InnoDB");

// Seed default rows for the three editable CMS pages, only if they don't exist yet
$conn->query("INSERT IGNORE INTO cms_pages (page_name, content) VALUES
    ('home', 'Welcome to my personal portfolio website.'),
    ('about', 'I am Adrian Rovic A. Corrales, a 2nd Year Student from FEU Institute of Technology, pursuing a degree in BSITCST. I have a strong passion for web development and enjoy creating dynamic and user-friendly websites.'),
    ('portfolio', 'A showcase of work and projects.')");

// Documentation table (admin-only User Manual PDF upload)
$conn->query("CREATE TABLE IF NOT EXISTS documentation (
    id INT AUTO_INCREMENT PRIMARY KEY,
    file_name VARCHAR(255),
    file_path VARCHAR(255),
    uploaded_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB");

if (!is_dir(__DIR__ . "/../uploads")) {
    mkdir(__DIR__ . "/../uploads", 0777, true);
}

// Folder for profile pictures (Profile feature)
if (!is_dir(__DIR__ . "/../uploads/profiles")) {
    mkdir(__DIR__ . "/../uploads/profiles", 0777, true);
}

// Folder for portfolio images (Portfolio feature)
if (!is_dir(__DIR__ . "/../uploads/portfolio")) {
    mkdir(__DIR__ . "/../uploads/portfolio", 0777, true);
}

// Folder for the documentation PDF (Documentation feature)
if (!is_dir(__DIR__ . "/../uploads/documentation")) {
    mkdir(__DIR__ . "/../uploads/documentation", 0777, true);
}

$checkAdmin = $conn->query("SELECT id FROM users WHERE role = 'admin'");
if ($checkAdmin->num_rows == 0) {
    $defaultPassword = password_hash("Admin123!", PASSWORD_DEFAULT);
    $conn->query("INSERT INTO users (username, password, role, status) VALUES ('admin', '$defaultPassword', 'admin', 'active')");
}
