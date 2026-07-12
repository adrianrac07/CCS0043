<?php
require_once __DIR__ . "/../config/db.php";
require_once __DIR__ . "/../includes/auth.php";

// If already logged in, no need to register again
if (isLoggedIn()) {
    header("Location: " . BASE_URL . "index.php");
    exit;
}

$error = "";
$success = "";

// This block only runs when the form is submitted (POST request)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $confirm  = $_POST['confirm_password'];

    if ($username === '' || $password === '') {
        $error = "Please fill in all fields.";
    } elseif ($password !== $confirm) {
        $error = "Passwords do not match.";
    } elseif (strlen($password) < 6) {
        $error = "Password must be at least 6 characters.";
    } else {
        // Check if the username is already taken (prepared statement = safe from SQL injection)
        $stmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $error = "That username is already taken.";
        } else {
            // Hash the password before saving it - NEVER store plain text passwords
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            $insert = $conn->prepare("INSERT INTO users (username, password, role, status) VALUES (?, ?, 'user', 'active')");
            $insert->bind_param("ss", $username, $hashedPassword);

            if ($insert->execute()) {
                $success = "Account created! You can now log in.";
            } else {
                $error = "Something went wrong. Please try again.";
            }
            $insert->close();
        }
        $stmt->close();
    }
}

$pageTitle = "Register";
require_once __DIR__ . "/../includes/header.php";
?>

<div class="row justify-content-center">
  <div class="col-md-5">
    <h2 class="mb-4">Create an Account</h2>

    <?php if ($error): ?>
      <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>

    <?php if ($success): ?>
      <div class="alert alert-success">
        <?php echo htmlspecialchars($success); ?>
        <a href="login.php">Go to login</a>
      </div>
    <?php endif; ?>

    <form method="POST" action="register.php">
      <div class="mb-3">
        <label class="form-label">Username</label>
        <input type="text" name="username" class="form-control" required>
      </div>
      <div class="mb-3">
        <label class="form-label">Password</label>
        <input type="password" name="password" class="form-control" required>
      </div>
      <div class="mb-3">
        <label class="form-label">Confirm Password</label>
        <input type="password" name="confirm_password" class="form-control" required>
      </div>
      <button type="submit" class="btn btn-primary w-100">Register</button>
    </form>

    <p class="mt-3">Already have an account? <a href="login.php">Login here</a></p>
  </div>
</div>

<?php require_once __DIR__ . "/../includes/footer.php"; ?>
