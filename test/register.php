<?php 
session_start();
require_once("config.php");

// Check connection
if (!$conn) {
    die("Database connection failed.");
}

// Helper function
function clean($data) {
    return htmlspecialchars(trim($data), ENT_QUOTES, 'UTF-8');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = clean($_POST['username'] ?? '');
    $email = clean($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';

    // Validation
    if (empty($username) || empty($email) || empty($password) || empty($confirm_password)) {
        header("Location: auth.php?error=empty_fields");
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header("Location: auth.php?error=invalid_email");
        exit;
    }

    if ($password !== $confirm_password) {
        header("Location: auth.php?error=passwords_dont_match");
        exit;
    }

    if (strlen($password) < 6) {
        header("Location: auth.php?error=password_short");
        exit;
    }

    // Check duplicate username/email
    $check = $conn->prepare("SELECT id FROM users WHERE username=? OR email=?");
    $check->bind_param("ss", $username, $email);
    $check->execute();
    $check->store_result();

    if ($check->num_rows > 0) {
        header("Location: auth.php?error=user_exists");
        exit;
    }

    // Hash password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    $role = "user";

    // Insert user
    $stmt = $conn->prepare("INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $username, $email, $hashedPassword, $role);

    if ($stmt->execute()) {
        // ✅ Redirect to login tab with success message
        header("Location: auth.php?success=registered");
        exit;
    } else {
        header("Location: auth.php?error=registration_failed");
        exit;
    }
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Register</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="style.css">
</head>

<body>

<div class="container d-flex justify-content-center align-items-center vh-100">
  <div class="card shadow" style="width: 28rem;">
    <div class="card-body">

      <h4 class="text-center mb-3">Register</h4>

      <!-- ERROR DISPLAY -->
      <?php if (isset($_GET['error'])): ?>
        <div class="alert alert-danger">
          <?php
            switch($_GET['error']) {
                case 'empty_fields': echo "All fields are required."; break;
                case 'invalid_email': echo "Invalid email format."; break;
                case 'passwords_dont_match': echo "Passwords do not match."; break;
                case 'password_short': echo "Password must be at least 6 characters."; break;
                case 'user_exists': echo "Username or email already exists."; break;
                default: echo "Registration failed.";
            }
          ?>
        </div>
      <?php endif; ?>

      <form method="POST" action="">
        <div class="mb-3">
          <input type="text" name="username" class="form-control" placeholder="Username" required>
        </div>

        <div class="mb-3">
          <input type="email" name="email" class="form-control" placeholder="Email" required>
        </div>

        <div class="mb-3">
          <input type="password" name="password" class="form-control" placeholder="Password" required>
        </div>

        <div class="mb-3">
          <input type="password" name="confirm_password" class="form-control" placeholder="Confirm Password" required>
        </div>

        <button type="submit" class="btn btn-primary w-100">Register</button>

        <div class="mt-3 text-center">
          <a href="login.php">Already have an account? Login</a>
        </div>
      </form>

    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>