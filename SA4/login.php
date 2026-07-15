<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "userdb");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE username='$username' AND password='$password'";
    $result = mysqli_query($conn, $sql);
    $user = mysqli_fetch_assoc($result);

    if ($user) {
        if ($user['status'] == 'disabled') {
            echo "This account is disabled. Please contact the administrator.";
        } else {
            $_SESSION['username'] = $user['username'];
            $_SESSION['accesslevel'] = $user['accesslevel'];

            if ($user['accesslevel'] == 'admin') {
                header("Location: Admin_home.php");
            } else {
                header("Location: User_home.php");
            }
        }
    } else {
        echo "Invalid login credentials.";
    }
}
?>
<form method="POST">
    <input type="text" name="username" placeholder="Username" required><br>
    <input type="password" name="password" placeholder="Password" required><br>
    <button type="submit">Login</button>
</form>
