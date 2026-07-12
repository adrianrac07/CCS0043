<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "user_reg");
if($conn === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
if(!isset($_SESSION['username'])){
    header("Location: login.php");
    exit();
}
$message = '';
$messageType = 'success-message';
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $username = mysqli_real_escape_string($conn, $_SESSION['username']);
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_new_password'];
    $result = mysqli_query(
        $conn,
        "SELECT password FROM user_reg WHERE username='$username'"
    );

    if(mysqli_num_rows($result) > 0){
        $row = mysqli_fetch_assoc($result);
        if($current_password !== $row['password']){
            $message = "Current password is incorrect.";
            $messageType = 'error-message';
        }
        elseif($new_password !== $confirm_password){
            $message = "New password and confirm password do not match.";
            $messageType = 'error-message';
        }
        elseif($new_password === $row['password']){
            $message = "New password cannot be the same as the old password.";
            $messageType = 'error-message';
        }
        else{
            $update = mysqli_query($conn,"UPDATE user_reg SET password='$new_password' WHERE username='$username'");

            if($update){
                $message = "Password updated successfully.";
                $messageType = 'success-message';
            }
            else{
                $message = "Error updating password. " . mysqli_error($conn);
                $messageType = 'error-message';
            }
        }
    }
    else{
        $message = "User account not found.";
        $messageType = 'error-message';
    }
}
mysqli_close($conn);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Reset Password</title>
</head>
<body>
    

    <div class="login-card">
        <h1>User Profile</h1>
        <h3> <a href="logout.php" class="logout-button">Logout</a></h3>
        <h2><strong>Welcome, <?php echo htmlspecialchars($_SESSION['firstname']. " " . $_SESSION['middlename']. " " . $_SESSION['lastname']); ?>!</h2>
        <h2><strong>Birthday:</strong> <?php echo htmlspecialchars($_SESSION['birthday']); ?></p>
        <h2><strong> Contact Details:</strong> 
        <h2><strong>Email:</strong> <?php echo htmlspecialchars($_SESSION['email']); ?></p>
        <h2><strong>Contact :</strong> <?php echo htmlspecialchars($_SESSION['contactnumber']); ?></p>
        
        <h2>Reset Password</h2>
        <?php if(!empty($message)) { ?>
            <div class="message <?php echo htmlspecialchars($messageType); ?>">
                <?php echo htmlspecialchars($message); ?>
            </div>
        <?php } ?>
        <form method="post">
            <div class="form-row">
                <label for="current_password">Current Password</label>
                <input id="current_password" type="password" name="current_password" required>
            </div>
            <div class="form-row">
                <label for="new_password">New Password</label>
                <input id="new_password" type="password" name="new_password" required>
            </div>
            <div class="form-row">
                <label for="confirm_new_password">Confirm New Password</label>
                <input id="confirm_new_password" type="password" name="confirm_new_password" required>
            </div>
            <div class="form-actions">
                <button type="submit">Reset Password</button>
            </div>
        </form>
    </div>
    
</body>
</html>