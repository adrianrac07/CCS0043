<?php
session_start();
include("config/db.php");

if(isset($_POST['login'])){
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE email=?");
    $stmt->bind_param("s",$email);
    $stmt->execute();
    $result = $stmt->get_result();

    if($user = $result->fetch_assoc()){
        if(password_verify($password, $user['password'])){
            $_SESSION['user'] = $user;
            header("Location: home.php");
            exit();
        } else {
            $error = "Wrong password";
        }
    } else {
        $error = "User not found";
    }
}

if(isset($_POST['signup'])){
    $name = $_POST['name'];
    $email = $_POST['email'];
    $pass = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO users(username,email,password) VALUES (?,?,?)");
    $stmt->bind_param("sss",$name,$email,$pass);
    $stmt->execute();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0
    <title>Login</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <form method="POST">
            <h3>Login</h3>
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <a href="home.php"><button name="login">Login</button></a>
</form>

<hr>

<form method="POST">
<h3>Sign Up</h3>
<input type="text" name="name" placeholder="Name" required>
<input type="email" name="email" placeholder="Email" required>
<input type="password" name="password" placeholder="Password" required>
<input type="password" name="confirm_password" placeholder="Confirm Password" required>
<?php 
if(isset($_POST['signup']) && $_POST['password'] != $_POST['confirm_password']) { 
echo "<p style='color:red;'>Passwords do not match</p>"; } 
 
if(isset($_POST['signup']) && $_POST['password'] == $_POST['confirm_password']) {
    echo "<p style='color:green;'>Account created successfully</p>";
}
    ?>
    
<button name="signup">Sign Up</button>
</form>