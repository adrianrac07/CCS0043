<?php
$conn = mysqli_connect("localhost", "root", "", "userdb");
session_start();
$username = $_SESSION['username'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $newpass = $_POST['newpass'];
    $sql = "UPDATE users SET password='$newpass' WHERE username='$username'";
    mysqli_query($conn, $sql);
    echo "Password changed successfully!";
}
?>
<form method="POST">
    New Password: <input type="password" name="newpass"><br>
    <button type="submit">Change Password</button>
</form>
