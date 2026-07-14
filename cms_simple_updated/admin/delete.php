<?php
session_start();
include "../config/db.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit();
}

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    $_SESSION['error'] = "Only admins can delete posts.";
    header("Location: dashboard.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['id'])) {
    $id = (int)$_POST['id'];

    $stmt = $conn->prepare("DELETE FROM posts WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();

    $_SESSION['success'] = "Post deleted successfully.";
} else {
    $_SESSION['error'] = "Invalid request.";
}

header("Location: dashboard.php");
exit();
