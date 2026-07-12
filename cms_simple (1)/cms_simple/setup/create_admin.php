<?php
// ------------------------------------------------------
// Run this file ONCE in your browser to create your first admin
// account, e.g. http://localhost/cms_simple/setup/create_admin.php
// After that, DELETE this file - leaving it online is a security risk.
// ------------------------------------------------------
require_once __DIR__ . "/../config/db.php";

$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    if ($username === '' || $password === '') {
        $message = "Please fill in both fields.";
    } else {
        $hashed = password_hash($password, PASSWORD_DEFAULT);

        // Prepared statement, and role is always forced to 'admin' here
        $stmt = $conn->prepare("INSERT INTO users (username, password, role, status) VALUES (?, ?, 'admin', 'active')");
        $stmt->bind_param("ss", $username, $hashed);

        if ($stmt->execute()) {
            $message = "Admin account '$username' created! Go to auth/login.php to log in, then delete this file.";
        } else {
            $message = "Error: that username may already exist.";
        }
        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Create Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container my-5" style="max-width: 500px;">
    <h2>Create First Admin Account</h2>
    <p class="text-danger">Delete this file after you use it!</p>

    <?php if ($message): ?>
        <div class="alert alert-info"><?php echo htmlspecialchars($message); ?></div>
    <?php endif; ?>

    <form method="POST">
        <div class="mb-3">
            <label class="form-label">Admin Username</label>
            <input type="text" name="username" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Admin Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Create Admin</button>
    </form>
</body>
</html>
