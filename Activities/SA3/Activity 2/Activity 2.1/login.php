<?php
session_start();

if(isset($_SESSION['username'])) {
header("Location: reset_password.php");
exit();
}

$conn = mysqli_connect("localhost", "root", "", "user_reg");
if($conn === false){
die("ERROR: Could not connect. " . mysqli_connect_error());
}

$error = "";

if($_SERVER["REQUEST_METHOD"] == "POST") {
$username = (trim($_POST['username']));
$password = (trim($_POST['password']));

$sql = "SELECT * FROM user_reg WHERE username = '$username' AND password = '$password'";
$result = mysqli_query($conn, $sql);

if(mysqli_num_rows($result) == 1){
$row = mysqli_fetch_assoc($result);
$_SESSION['username'] = $row['username'];
$_SESSION['firstname'] = $row['firstname'];
$_SESSION['middlename'] = $row['middlename'];
$_SESSION['lastname'] = $row['lastname'];
$_SESSION['birthday'] = $row['birthday'];
$_SESSION['email'] = $row['email'];
$_SESSION['contactnumber'] = $row['contactnumber'];
header("Location:reset_password.php");
exit();
} else{
$error = "username or password is incorrect.";
}
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Login</title>
<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<div class="login-page">
  <div class="login-card">
    <h3>Login</h3>
    <form method="post">
      <div class="form-row">
        <label for="username">Username</label>
        <input id="username" type="text" name="username" required>
      </div>
      <div class="form-row">
        <label for="password">Password</label>
        <input id="password" type="password" name="password" required>
      </div>
      <?php if($error != "") { ?>
      <div class="error-message">
        <?php echo htmlspecialchars($error); ?>
      </div>
    <?php } ?>
      <div class="form-actions">
        <button type="submit">Login</button>
        <a class="link-button" href="index.php">Register</a>
        
      </div>
    </form>
  </div>
</div>
</body>
</html>