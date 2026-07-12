<?php
// ------------------------------------------------------
// Simple session helpers.
// Every page that needs to know "who is logged in" includes this file.
// ------------------------------------------------------

// Start the session only if one hasn't already been started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Returns true if someone is logged in
function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

// Returns true if the logged-in user is an admin
function isAdmin() {
    return isLoggedIn() && $_SESSION['role'] === 'admin';
}

// If not logged in, send the visitor to the login page
function requireLogin() {
    if (!isLoggedIn()) {
        header("Location: " . BASE_URL . "auth/login.php");
        exit;
    }
}

// If not an admin, block access to the page
function requireAdmin() {
    requireLogin();
    if (!isAdmin()) {
        header("Location: " . BASE_URL . "index.php");
        exit;
    }
}
