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

// Posts table (referenced by admin/create.php, edit.php, delete.php but was never
// actually created anywhere before - adding it now so those existing features work
// and so it can be displayed on the Home page).
$conn->query("CREATE TABLE IF NOT EXISTS posts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NULL,
    title VARCHAR(150) NOT NULL,
    content TEXT NOT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL
) ENGINE=InnoDB");

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

// CMS pages table (CMS Content System feature) - lets admin edit Home / About content
$conn->query("CREATE TABLE IF NOT EXISTS cms_pages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    page_name VARCHAR(50) NOT NULL UNIQUE,
    content TEXT
) ENGINE=InnoDB");

// Seed default rows for the two editable CMS pages, only if they don't exist yet
$conn->query("INSERT IGNORE INTO cms_pages (page_name, content) VALUES
    ('home', 'Browse learning topics, download files, and manage everything with a simple admin dashboard.'),
    ('about', 'I am Adrian Rovic A. Corrales, a 2nd Year Student from FEU Institute of Technology, pursuing a degree in BSITCST. I have a strong passion for web development and enjoy creating dynamic and user-friendly websites.')");

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

$checkAdmin = $conn->query("SELECT id FROM users WHERE role = 'admin'");
if ($checkAdmin->num_rows == 0) {
    $defaultPassword = password_hash("Admin123!", PASSWORD_DEFAULT);
    $conn->query("INSERT INTO users (username, password, role, status) VALUES ('admin', '$defaultPassword', 'admin', 'active')");
}
