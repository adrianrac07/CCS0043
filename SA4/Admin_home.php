<?php
session_start();
if ($_SESSION['accesslevel'] != 'admin') {
    header("Location: login.php");
    exit();
}
echo "<h1>Welcome Admin</h1>";
?>
<a href="Admin_adduser.php">Add User</a> | 
<a href="Admin_image.php">Upload Image</a> | 
<a href="Admin_changepass.php">Reset Password</a> | 
<a href="logout.php">Logout</a>
