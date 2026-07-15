<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "db_user");
if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

$error = "";

if (isset($_POST['login'])) {
    $username = mysqli_real_escape_string($conn, trim($_POST['username']));
    $password = mysqli_real_escape_string($conn, trim($_POST['password']));

    if ($username == "" || $password == "") {
        $error = "Please enter username and password.";
    } else {
        $query = mysqli_query($conn, "SELECT * FROM users WHERE username='$username' AND password='$password'");

        if ($query && mysqli_num_rows($query) > 0) {
            $row = mysqli_fetch_assoc($query);

            if ($row['status'] == 'disable') {
                $error = "This account is disabled please contact the administrator";
            } else {
                $_SESSION['id'] = $row['id'];
                $_SESSION['firstname']  = $row['firstname'];
                $_SESSION['accesslevel']= $row['accesslevel'];
                $_SESSION['lastname']   = $row['lastname']   ?? '';
                $_SESSION['contactno']  = $row['contactno']  ?? '';
                $_SESSION['email']      = $row['email']      ?? '';

                if ($row['accesslevel'] == 'admin') {
                    header("Location: Admin_home.php");
                } else {
                    header("Location: User_home.php");
                }
                exit();
            }
        } else {
            $error = "Invalid username or password";
        }
    }
}
?>
<html>
<head>
    <title>Login</title>
</head>
<body>
    <div style="width:300px;margin:100px auto;border:1px solid #333;padding:20px;">
        <h2>Log-In Form</h2>
        <?php if ($error != "") { echo "<p style='color:red;'>" . htmlspecialchars($error) . "</p>"; } ?>
        <form method="post" action="login.php">
            Username<br>
            <input type="text" name="username"><br><br>
            Password<br>
            <input type="password" name="password"><br><br>
            <input type="submit" name="login" value="Login">
        </form>
    </div>
</body>
</html>
