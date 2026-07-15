<?php
$conn = mysqli_connect("localhost", "root", "", "userdb");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $accesslevel = $_POST['accesslevel'];

    $sql = "INSERT INTO users (firstname, lastname, username, password, accesslevel, status) 
            VALUES ('$firstname','$lastname','$username','$password','$accesslevel','active')";
    mysqli_query($conn, $sql);
    $msg = "User added successfully!";
}
?>
<link rel="stylesheet" href="style.css">
<div class="container">
  <h2>Add User</h2>
  <form method="POST">
    <input type="text" name="firstname" placeholder="Firstname"><br>
    <input type="text" name="lastname" placeholder="Lastname"><br>
    <input type="text" name="username" placeholder="Username"><br>
    <input type="password" name="password" placeholder="Password"><br>
    <select name="accesslevel">
      <option value="admin">Admin</option>
      <option value="user">User</option>
    </select><br>
    <button type="submit">Add User</button>
  </form>
  <p style="color:green;"><?php if(isset($msg)) echo $msg; ?></p>
  <a href="Admin_home.php">Back</a>
</div>
