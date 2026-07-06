<?php
session_start();

$storedUsername = 'admin';
$storedPassword = '12345';

if (isset($_SESSION['username'])) {
    header('Location: home.php');
    exit();
}

$errorMessage = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');
    $remember = isset($_POST['remember']);

    if ($username === $storedUsername && $password === $storedPassword) {
        $_SESSION['username'] = $username;

        if ($remember) {
            setcookie('login_username', $username, time() + 60 * 60 * 24 * 30, '/');
            setcookie('login_password', $password, time() + 60 * 60 * 24 * 30, '/');
        } else {
            setcookie('login_username', '', time() - 3600, '/');
            setcookie('login_password', '', time() - 3600, '/');
        }

        header('Location: home.php');
        exit();
    } else {
        $errorMessage = 'Invalid username or password.';
    }
}

$usernameValue = isset($_COOKIE['login_username']) ? $_COOKIE['login_username'] : '';
$passwordValue = isset($_COOKIE['login_password']) ? $_COOKIE['login_password'] : '';
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Login Module</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="login-card">
        <h2>Login</h2>
        <?php if ($errorMessage !== ''): ?>
            <p class="error-message"><?php echo htmlspecialchars($errorMessage); ?></p>
        <?php endif; ?>
        <form method="post" action="">
            <label for="username">Username</label>
            <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($usernameValue); ?>" required>

            <label for="password">Password</label>
            <input type="password" id="password" name="password" value="<?php echo htmlspecialchars($passwordValue); ?>" required>

            <label class="remember">
                <input type="checkbox" name="remember" <?php echo isset($_COOKIE['login_username']) && isset($_COOKIE['login_password']) ? 'checked' : ''; ?>>
                Remember Me
            </label>

            <button type="submit">Login</button>
        </form>
    </div>
</body>
</html>
