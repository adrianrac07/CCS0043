<?php
session_start();
include "../config/db.php";

if (isset($_SESSION['user_id'])) {
    header("Location: ../index.php");
    exit();
}

$errors = array();
$username = "";

if (isset($_POST['login'])) {
    $username = htmlspecialchars(trim($_POST['username']));
    $password = $_POST['password'];

    if ($username == "") {
        $errors[] = "Please enter your username.";
    }
    if ($password == "") {
        $errors[] = "Please enter your password.";
    }

    if (count($errors) == 0) {
        $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        if ($user && password_verify($password, $user['password'])) {
            if ($user['status'] === 'blocked') {
                $errors[] = "This account has been blocked.";
            } else {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['role'] = $user['role'];
                $_SESSION['success'] = "Welcome back, " . $user['username'] . "!";

                if ($user['role'] === 'admin') {
                    header("Location: ../admin/dashboard.php");
                } else {
                    header("Location: ../index.php");
                }
                exit();
            }
        } else {
            $errors[] = "Incorrect username or password.";
        }
    }
}

$pageTitle = "Login";
$base = "../";
include "../includes/header.php";
?>
<!DOCTYPE html>
<head>
<link rel="stylesheet" href="assets/style.css">
</head>
<body>
<div class="auth-wrapper">
  <div class="card auth-card fade-in">
    <div class="card-body p-4 p-md-5">
      <div class="text-center mb-4">
        <i class="bi bi-box-arrow-in-right fs-1 text-primary"></i>
        <h3 class="fw-semibold mt-2">Welcome Back</h3>
        <p class="text-muted small mb-0">Log in to browse subjects and files.</p>
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

        <div class="mb-4">
          <label class="form-label">Password</label>
          <input type="password" name="password" class="form-control" required>
        </div>

        <button type="submit" name="login" class="btn btn-accent w-100">Log In</button>
      </form>

      <p class="text-center text-muted small mt-4 mb-0">
        Don't have an account? <a href="register.php">Register</a>
      </p>
    </div>
  </div>
</div>

<?php include "../includes/footer.php"; ?>
      </body>
      </html>