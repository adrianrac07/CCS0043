<?php
$conn = mysqli_connect("localhost", "root", "", "userdb");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $newpass = $_POST['newpass'];

    $sql = "UPDATE users SET password='$newpass' WHERE username='$username'";
    mysqli_query($conn, $sql);
    echo "Password reset successfully!";
}
?>
<form method="POST">
    Username: <input type="text" name="username"><br>
    New Password: <input type="password" name="newpass"><br>
    <button type="submit">Reset Password</button>
</form>
