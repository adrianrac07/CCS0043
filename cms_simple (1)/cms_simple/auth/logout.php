<?php
require_once __DIR__ . "/../config/db.php";
require_once __DIR__ . "/../includes/auth.php";

// Clear all session data and destroy the session
$_SESSION = [];
session_destroy();

header("Location: " . BASE_URL . "auth/login.php");
exit;
