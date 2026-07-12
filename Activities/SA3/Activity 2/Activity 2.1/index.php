<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Registration Module</title>
  <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
 
 <div class="form-container">
  <div class="login-card">
 <h2>My Personal Information</h2>
    <form method="post" action="">
      <div class="form-row">
        <label>First Name:</label>
        <input type="text" name="firstname" value="<?php echo isset($_POST['firstname']) ? htmlspecialchars($_POST['firstname']) : ''; ?>" required>
      </div>
      <div class="form-row">
        <label>Middle Name:</label>
        <input type="text" name="middlename" value="<?php echo isset($_POST['middlename']) ? htmlspecialchars($_POST['middlename']) : ''; ?>">
      </div>
      <div class="form-row">
        <label>Last Name:</label>
        <input type="text" name="lastname" value="<?php echo isset($_POST['lastname']) ? htmlspecialchars($_POST['lastname']) : ''; ?>" required>
      </div>
      <div class="form-row">
        <label>Username:</label>
        <input type="text" name="username" value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username']) : ''; ?>" required>
      </div>
      <div class="form-row">
        <label>Password:</label>
        <input type="password" name="password" required>
      </div>
      <div class="form-row">
        <label>Confirm Password:</label>
        <input type="password" name="confirmpassword" required>
      </div>
      <div class="form-row">
        <label>Birthday:</label>
        <input type="text" name="birthday" value="<?php echo isset($_POST['birthday']) ? htmlspecialchars($_POST['birthday']) : ''; ?>" required>
      </div>
      <div class="form-row">
        <label>Email:</label>
        <input type="email" name="email" value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>" required>
      </div>
      <div class="form-row">
        <label>Contact Number:</label>
        <input type="text" name="contactnumber" value="<?php echo isset($_POST['contactnumber']) ? htmlspecialchars($_POST['contactnumber']) : ''; ?>" required>
      </div>
      <div class="form-actions">
        <input type="submit" value="Register">
      </div>
      <div class="form-actions">
        <a href="login.php">Already have an account? Login here</a>
      </div>
    </form>
</div>

    <?php
    session_start();
    $host = 'localhost';
    $user = 'root';
    $pass = '';
    $dbname = "user_reg";

    $conn = new mysqli($host, $user, $pass, $dbname);

    if ($conn->connect_error) {
        echo '<div class="message error-message">Database connection failed: ' . htmlspecialchars($conn->connect_error) . '</div>';
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $errors = [];
        $firstname = ($_POST['firstname'] ?? '');
        $middlename = ($_POST['middlename'] ?? '');
        $lastname = ($_POST['lastname'] ?? '');
        $username = ($_POST['username'] ?? '');
        $password = (trim($_POST['password'] ?? ''));
        $confirmpassword = (trim($_POST['confirmpassword'] ?? ''));
        $birthday = ($_POST['birthday'] ?? '');
        $email = ($_POST['email'] ?? '');
        $contactnumber = ($_POST['contactnumber'] ?? '');

       
        if ($password !== $confirmpassword) {
            $errors[] = 'Password and confirm password do not match.';
        }
       
        if (!empty($errors)) {
            echo '<div class="message error-message">';
            foreach ($errors as $error) {
                echo '<p>' . htmlspecialchars($error) . '</p>';
            }
            echo '</div>';
        } elseif (isset($conn) && !$conn->connect_error) {
            $insertQuery = "INSERT INTO user_reg (firstname, middlename, lastname, username, password, birthday, email, contactnumber) VALUES ('$firstname', '$middlename', '$lastname', '$username', '$password', '$birthday', '$email', '$contactnumber')";

            if ($conn->query($insertQuery) === TRUE) {
                echo '<div class="message success-message"><p>Registration successful! Your account has been created.</p></div>';
            } else {
                echo '<div class="message error-message"><p>Registration failed. Please check your database table and try again.</p></div>';
            }
        }
    }
    ?>
  </div>
</body>
</html>
