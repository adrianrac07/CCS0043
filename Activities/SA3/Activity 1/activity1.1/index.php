<!DOCTYPE html>
<html>
<head>
  <title>post_info</title>
  <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
  <form method="post" action="">
    <table>
      <tr>
        <td colspan ="2">My Personal Information</td>
      </tr>
      <tr>
        <td>First Name:</td>
        <td><input type="text" name="firstname"></td>
      </tr>
      <tr>
        <td>Middle Name:</td>
        <td><input type="text" name="middlename"></td>
      </tr>
      <tr>
        <td>Last Name:</td>
        <td><input type="text" name="lastname"></td>
      </tr>
      <tr>
        <td>Username:</td>
        <td><input type="text" name="username"></td>
      </tr>
      <tr>
        <td>Password:</td>
        <td><input type="text" name="password"></td>
      </tr>
      <tr>
        <td>Confirm Password:</td>
        <td><input type="text" name="confirmpassword"></td>
      </tr>
      <tr>
        <td>Birthday:</td>
        <td><input type="text" name="birthday"></td>
      </tr>
      <tr>
        <td>Email:</td>
        <td><input type="text" name="email"></td>
      </tr>
      <tr>
        <td>Contact Number:</td>
        <td><input type="text" name="contactnumber"></td>
      </tr>
      <tr>
        <td colspan="2"><input type="submit" value="Submit"></td>
      </tr>
    </table>
  </form>

  <?php
   if(isset($_POST['firstname'])) {
 $firstname = $_POST['firstname'];
 $middlename = $_POST['middlename'];
 $lastname = $_POST['lastname'];
 $username = $_POST['username'];
 $password = trim($_POST['password']);
 $confirmpassword = trim($_POST['confirmpassword']);
 $birthday = $_POST['birthday'];
 $email = $_POST['email'];
 $contactnumber = $_POST['contactnumber'];
 echo '<div class="output-card">';
 if($password != $confirmpassword) {
 echo '<p class="error-message">Password and Confirm Password does not match. Try again.</p>';
 } else {
 echo '<p><strong>Full Name:</strong> ' . $firstname . ' ' . $middlename . ' ' . $lastname . '</p>';
 echo '<p><strong>Username:</strong> ' . $username . '</p>';
 echo '<p><strong>Password:</strong> ' . $password . '</p>';
 echo '<p><strong>Date of Birth:</strong> ' . $birthday . '</p>';
 echo '<p><strong>Email Address:</strong> ' . $email . '</p>';
 echo '<p><strong>Contact Number:</strong> ' . $contactnumber . '</p>';
 }
 echo '</div>';
 }
  ?>
</body>
</html>
