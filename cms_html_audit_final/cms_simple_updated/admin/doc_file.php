<?php
session_start();
include "../config/db.php";

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    http_response_code(403);
    die("Access denied.");
}

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$action = $_GET['action'] ?? 'view';

if ($id <= 0) {
    http_response_code(400);
    die("Invalid request.");
}

$stmt = $conn->prepare("SELECT file_name, file_path FROM documentation WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$doc = $stmt->get_result()->fetch_assoc();

if (!$doc) {
    http_response_code(404);
    die("File not found.");
}

$safePath = str_replace(['..', '\\'], '', $doc['file_path']);
$fullPath = __DIR__ . "/../" . $safePath;

if (strpos(realpath($fullPath), realpath(__DIR__ . "/../uploads/documentation")) !== 0 || !file_exists($fullPath)) {
    http_response_code(404);
    die("File not found.");
}

$fileExt = strtolower(pathinfo($doc['file_path'], PATHINFO_EXTENSION));
$mimeTypes = [
    'pdf'  => 'application/pdf',
    'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
    'zip'  => 'application/zip',
];
$contentType = $mimeTypes[$fileExt] ?? 'application/octet-stream';

header("Content-Type: " . $contentType);
if ($action === 'download' || $fileExt !== 'pdf') {
    header("Content-Disposition: attachment; filename=\"" . basename($doc['file_name']) . "\"");
} else {
    header("Content-Disposition: inline; filename=\"" . basename($doc['file_name']) . "\"");
}
header("Content-Length: " . filesize($fullPath));
header("X-Content-Type-Options: nosniff");
readfile($fullPath);
exit();
