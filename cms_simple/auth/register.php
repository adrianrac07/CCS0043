<?php
session_start();
include "../config/db.php";

if (isset($_SESSION['user_id'])) {
    header("Location: ../index.php");
    exit();
}

$errors = array();
$username = "";

if (isset($_POST['register'])) {
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    $username = htmlspecialchars($username);

    if ($username == "" || strlen($username) < 3) {
        $errors[] = "Username must be at least 3 characters.";
    }
    if (strlen($password) < 6) {
        $errors[] = "Password must be at least 6 characters.";
    }
    if ($password != $confirm_password) {
        $errors[] = "Passwords do not match.";
    }

    if (count($errors) == 0) {
        $check = $conn->prepare("SELECT id FROM users WHERE username = ?");
        $check->bind_param("s", $username);
        $check->execute();
        $result = $check->get_result();

        if ($result->num_rows > 0) {
            $errors[] = "Username is already taken.";
        }
    }

    if (count($errors) == 0) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $conn->prepare("INSERT INTO users (username, password, role, status) VALUES (?, ?, 'user', 'active')");
        $stmt->bind_param("ss", $username, $hashed_password);

        if ($stmt->execute()) {
            $_SESSION['success'] = "Account created successfully. Please log in.";
            header("Location: login.php");
            exit();
        } else {
            $errors[] = "Something went wrong. Please try again.";
        }
    }
}

$pageTitle = "Register";
$base = "../";
include "../includes/header.php";
?>

<div class="auth-wrapper">
  <div class="card auth-card fade-in">
    <div class="card-body p-4 p-md-5">
      <div class="text-center mb-4">
        <i class="bi bi-person-plus-fill fs-1 text-primary"></i>
        <h3 class="fw-semibold mt-2">Create an Account</h3>
        <p class="text-muted small mb-0">Join to browse subjects and download files.</p>
      </div>

      <?php if (count($errors) > 0): ?>
        <div class="alert alert-danger">
          <ul class="mb-0 ps-3">
            <?php foreach ($errors as $error) { ?>
              <li><?php echo $error; ?></li>
            <?php } ?>
          </ul>
        </div>
      <?php endif; ?>

      <form method="POST">
        <div class="mb-3">
          <label class="form-label">Username</label>
          <input type="text" name="username" class="form-control" value="<?php echo $username; ?>" required>
        </div>

        <div class="mb-3">
          <label class="form-label">Password</label>
          <input type="password" name="password" class="form-control" required>
        </div>

        <div class="mb-4">
          <label class="form-label">Confirm Password</label>
          <input type="password" name="confirm_password" class="form-control" required>
        </div>

        <button type="submit" name="register" class="btn btn-accent w-100">Create Account</button>
      </form>

      <p class="text-center text-muted small mt-4 mb-0">
        Already have an account? <a href="login.php">Log in</a>
      </p>
    </div>
  </div>
</div>

<?php include "../includes/footer.php"; ?>
