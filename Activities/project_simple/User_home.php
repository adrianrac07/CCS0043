<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "db_user");
if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

$id = (int)$_SESSION['id'];
$result = mysqli_query($conn, "SELECT * FROM users WHERE id=$id");
$user = mysqli_fetch_assoc($result);

if (!$user) {
    header("Location: logout.php");
    exit();
}

$image = ($user['image'] != "") ? $user['image'] : "default.png";




?>
<html>
<head>
    <title>User Home</title>
</head>
<body>
    <div style="text-align:right;">
        <a href="logout.php">Logout</a>
    </div>

    <h2>My Information</h2>
    <table>
        <column>
    <th>  
    Welcome <?php echo htmlspecialchars($user['firstname'] . " " . $user['lastname']); ?><br>
    <b>Userlevel:</b> <?php echo htmlspecialchars($user['accesslevel']); ?><br>
    <b>Birthday:</b> <?php echo htmlspecialchars($user['birthday']); ?><br>
    Contact Details<br>
    &nbsp;&nbsp;<b>Contact:</b> <?php echo htmlspecialchars($user['contactno']); ?><br>
    &nbsp;&nbsp;<b>Email:</b> <?php echo htmlspecialchars($user['email']); ?><br>
</th>
<th>
<img src="uploads/<?php echo htmlspecialchars($image); ?>" style="padding-left: 200px;" width="150"><br><br>
</th>

</table>
    <p>
        <a href="user_image.php">upload image</a> |
        <a href="user_changepass.php">Reset my password</a>
    </p>
</body>
</html>
