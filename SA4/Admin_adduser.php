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
    echo "User added successfully!";
}
?>
<form method="POST">
    Firstname: <input type="text" name="firstname"><br>
    Lastname: <input type="text" name="lastname"><br>
    Username: <input type="text" name="username"><br>
    Password: <input type="password" name="password"><br>
    Access Level: 
    <select name="accesslevel">
        <option value="admin">Admin</option>
        <option value="user">User</option>
    </select><br>
    <button type="submit">Add User</button>
</form>
