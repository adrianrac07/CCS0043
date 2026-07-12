<?php
require_once __DIR__ . "/../config/db.php";
require_once __DIR__ . "/../includes/auth.php";

if (isLoggedIn()) {
    header("Location: " . BASE_URL . "index.php");
    exit;
}

$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    // Look up the user by username with a prepared statement
    $stmt = $conn->prepare("SELECT id, username, password, role, status FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    $stmt->close();

    if (!$user) {
        $error = "Invalid username or password.";
    } elseif ($user['status'] === 'blocked') {
        $error = "Your account has been blocked. Please contact the admin.";
    } elseif (!password_verify($password, $user['password'])) {
        // password_verify() checks the typed password against the stored hash
        $error = "Invalid username or password.";
    } else {
        // Login success - store the user's info in the session
        $_SESSION['user_id']  = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role']     = $user['role'];

        if ($user['role'] === 'admin') {
            header("Location: " . BASE_URL . "admin/dashboard.php");
        } else {
            header("Location: " . BASE_URL . "index.php");
        }
        exit;
    }
}

$pageTitle = "Login";
require_once __DIR__ . "/../includes/header.php";
?>

<div class="row justify-content-center">
  <div class="col-md-5">
    <h2 class="mb-4">Login</h2>

    <?php if ($error): ?>
      <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>

    <form method="POST" action="login.php">
      <div class="mb-3">
        <label class="form-label">Username</label>
        <input type="text" name="username" class="form-control" required>
      </div>
      <div class="mb-3">
        <label class="form-label">Password</label>
        <input type="password" name="password" class="form-control" required>
      </div>
      <button type="submit" class="btn btn-primary w-100">Login</button>
    </form>

    <p class="mt-3">Don't have an account? <a href="register.php">Register here</a></p>
  </div>
</div>

<?php require_once __DIR__ . "/../includes/footer.php"; ?>
