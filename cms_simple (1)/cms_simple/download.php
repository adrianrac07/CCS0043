<?php
require_once __DIR__ . "/config/db.php";
require_once __DIR__ . "/includes/auth.php";

// Only logged-in users can download files
requireLogin();

$fileId = isset($_GET['id']) ? (int)$_GET['id'] : 0;

$stmt = $conn->prepare("SELECT filename FROM files WHERE id = ?");
$stmt->bind_param("i", $fileId);
$stmt->execute();
$result = $stmt->get_result();
$file = $result->fetch_assoc();
$stmt->close();

if (!$file) {
    die("File not found.");
}

$filePath = __DIR__ . "/uploads/" . $file['filename'];

if (!file_exists($filePath)) {
    die("File is missing from the server.");
}

// Force the browser to download the file instead of displaying it
header("Content-Description: File Transfer");
header("Content-Type: application/octet-stream");
header("Content-Disposition: attachment; filename=\"" . basename($file['filename']) . "\"");
header("Content-Length: " . filesize($filePath));
readfile($filePath);
exit;
