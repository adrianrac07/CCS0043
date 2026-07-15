<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "db_user");
if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

if (!isset($_SESSION['accesslevel']) || $_SESSION['accesslevel'] != 'admin') {
    header("Location: login.php");
    exit();
}

$id = (int)$_SESSION['id'];
$result = mysqli_query($conn, "SELECT * FROM users WHERE id=$id");
$user = mysqli_fetch_assoc($result);

$error = "";
$success = "";

if (isset($_POST['submit'])) {
    $oldpassword = $_POST['oldpassword'];
    $newpassword = $_POST['newpassword'];
    $confirmpassword = $_POST['confirmpassword'];

    if ($oldpassword != $user['password']) {
        $error = "Current password is incorrect.";
    } elseif ($newpassword == "") {
        $error = "New password cannot be blank.";
    } elseif ($newpassword != $confirmpassword) {
        $error = "New password and confirm password do not match.";
    } else {
        $newpassword = mysqli_real_escape_string($conn, $newpassword);
        mysqli_query($conn, "UPDATE users SET password='$newpassword' WHERE id=$id");
        $success = "Password updated successfully.";
        $user['password'] = $newpassword;
    }
}
?>
<html>
<head>
    <title>Reset Password</title>
</head>
<body>
    <div style="width:400px;margin:30px auto;border:1px solid #333;padding:20px;">
        <p style="text-align:right;"><a href="Admin_home.php">Back</a></p>
        <h2>My Information</h2>
         Welcome <?php echo htmlspecialchars($user['firstname']); ?><br>
        Userlevel: <?php echo htmlspecialchars($user['accesslevel']); ?><br>
        Birthday: <?php echo htmlspecialchars($user['birthday']); ?><br>
        Contact Details:<br>
        Contact Number:<?php echo htmlspecialchars($user['contactno']); ?><br>
        Email: <?php echo htmlspecialchars($user['email']); ?><br>

        <h2>-Password Reset-</h2>
        <?php if ($error != "") { echo "<p style='color:red;'>" . htmlspecialchars($error) . "</p>"; } ?>
        <?php if ($success != "") { echo "<p style='color:green;'>" . htmlspecialchars($success) . "</p>"; } ?>
        <form method="post" action="Admin_changepass.php">
            Enter Current Password:<br>
            <input type="password" name="oldpassword"><br><br>
            Enter New Password:<br>
            <input type="password" name="newpassword"><br><br>
            Re-Enter New Password:<br>
            <input type="password" name="confirmpassword"><br><br>
            <input type="submit" name="submit" value="Submit">
        </form>
    </div>
</body>
</html>
