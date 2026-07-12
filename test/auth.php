<?php 
include("config.php"); 
session_start(); 
?>

      if (isset($_GET["error"])) {
          $error_msg = "";
          if ($_GET["error"] === "empty_fields") $error_msg = "Please fill in all fields.";
          if ($_GET["error"] === "invalid_password") $error_msg = "Invalid password.";
          if ($_GET["error"] === "user_not_found") $error_msg = "User not found.";
          if ($_GET["error"] === "passwords_dont_match") $error_msg = "Passwords do not match.";
          if ($_GET["error"] === "password_short") $error_msg = "Password must be at least 6 characters.";
          if ($_GET["error"] === "username_exists") $error_msg = "Username already exists.";
          if ($_GET["error"] === "email_exists") $error_msg = "Email already registered.";
          if ($_GET["error"] === "registration_failed") $error_msg = "Registration failed. Please try again.";
          if ($_GET["error"] === "not_authorized") $error_msg = "You are not authorized to access this page.";
          if (!empty($error_msg)) {
              echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                      $error_msg
                      <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
                    </div>";
          }
      }
      
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Authentication</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
  <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container d-flex justify-content-center align-items-center vh-100">
  <div class="card shadow" style="width: 28rem;">
    <div class="card-body">
      <!-- Nav Tabs -->
      <ul class="nav nav-tabs" id="authTabs" role="tablist">
        <li class="nav-item" role="presentation">
          <button class="nav-link active" id="login-tab" data-bs-toggle="tab" data-bs-target="#login" type="button" role="tab">Login</button>
        </li>
        <li class="nav-item" role="presentation">
          <button class="nav-link" id="register-tab" data-bs-toggle="tab" data-bs-target="#register" type="button" role="tab">Register</button>
        </li>
      </ul>

      

      <div class="tab-content mt-3" id="authTabsContent">
        <div class="tab-pane fade show active" id="login" role="tabpanel">
          <form method="POST" action="login.php">
            <div class="mb-3">
              <input type="text" name="username" class="form-control" placeholder="Username" required>
            </div>
            <div class="mb-3">
              <input type="password" name="password" class="form-control" placeholder="Password" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Login</button>
          </form>
        </div>

        <div class="tab-pane fade" id="register" role="tabpanel">
          <form method="POST" action="register.php">
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
            <button type="submit" class="btn btn-success w-100">Register</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>
</html>
