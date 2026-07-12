<?php
session_start();

if (!isset($_SESSION['username'])) {
    header('Location: index.php');
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Home</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="login-card">
        <h2>Welcome</h2>
        <p>You are logged in as <strong><?php echo htmlspecialchars($_SESSION['username']); ?></strong>.</p>
        <a href="logout.php">Logout</a>
    </div>
</body>
</html>
