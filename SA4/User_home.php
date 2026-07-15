<?php
session_start();
if ($_SESSION['accesslevel'] != 'user') {
    header("Location: login.php");
    exit();
}
echo "<h1>Welcome User</h1>";
?>
<a href="user_changepass.php">Change Password</a> | 
<a href="user_image.php">Upload Picture</a> | 
<a href="logout.php">Logout</a>
