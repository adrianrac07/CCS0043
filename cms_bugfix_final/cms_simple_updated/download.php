<?php
// Secure download handler for portfolio files.
// Instead of linking directly to the uploads folder, we look up the file
// path in the database by ID. This avoids exposing/trusting raw file paths.
include "config/db.php";

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id <= 0) {
    http_response_code(400);
    die("Invalid file request.");
}

$stmt = $conn->prepare("SELECT title, image FROM portfolio WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$item = $stmt->get_result()->fetch_assoc();

if (!$item || empty($item['image'])) {
    http_response_code(404);
    die("File not found.");
}

// Only allow files inside the portfolio uploads folder (prevents path traversal)
$safePath = str_replace(['..', '\\'], '', $item['image']);
$fullPath = __DIR__ . "/" . $safePath;

if (strpos(realpath($fullPath), realpath(__DIR__ . "/uploads/portfolio")) !== 0 || !file_exists($fullPath)) {
    http_response_code(404);
    die("File not found.");
}

$ext = strtolower(pathinfo($fullPath, PATHINFO_EXTENSION));
$downloadName = preg_replace('/[^A-Za-z0-9_\-]/', '_', $item['title']) . "." . $ext;

header("Content-Description: File Transfer");
header("Content-Type: application/octet-stream");
header("Content-Disposition: attachment; filename=\"" . $downloadName . "\"");
header("Content-Length: " . filesize($fullPath));
header("X-Content-Type-Options: nosniff");
readfile($fullPath);
exit();
