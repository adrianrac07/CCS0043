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

$error = "";

if (isset($_POST['upload'])) {
    if (!isset($_FILES['image']) || $_FILES['image']['error'] !== UPLOAD_ERR_OK || $_FILES['image']['name'] == "") {
        $error = "Please choose a file to upload.";
    } else {
        $filename = $_FILES['image']['name'];
        $filetmp = $_FILES['image']['tmp_name'];
        $filesize = $_FILES['image']['size'];
        $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

        $allowed = array('jpg', 'jpeg', 'png', 'gif');

        if (!in_array($ext, $allowed)) {
            $error = "Only JPG, JPEG, PNG and GIF files are allowed.";
        } elseif ($filesize > 2000000) {
            $error = "File is too large. Max size is 2MB.";
        } else {
            $newname = "user_" . $id . "_" . time() . "." . $ext;
            if (move_uploaded_file($filetmp, "uploads/" . $newname)) {
                mysqli_query($conn, "UPDATE users SET image='$newname' WHERE id=$id");
                header("Location: user_image.php");
                exit();
            } else {
                $error = "Failed to upload file. Check that the uploads folder is writable.";
            }
        }
    }
}

$image = ($user && $user['image'] != "") ? $user['image'] : "default.png";
?>
<html>
<head>
    <title>Upload Image</title>
</head>
<body>
    <div style="width:400px;margin:30px auto;border:1px solid #333;padding:20px;">
        <p style="text-align:right;"><a href="User_home.php">Back</a></p>
        <h2>My Information</h2>
        Welcome <?php echo htmlspecialchars($user['firstname']); ?><br>
        Userlevel: <?php echo htmlspecialchars($user['accesslevel']); ?><br>
        Birthday: <?php echo htmlspecialchars($user['birthday']); ?><br>
        Contact Details:<br>
        Contact Number:<?php echo htmlspecialchars($user['contactno']); ?><br>
        Email: <?php echo htmlspecialchars($user['email']); ?><br>

        <img src="uploads/<?php echo htmlspecialchars($image); ?>" width="150"><br><br>

        <?php if ($error != "") { echo "<p style='color:red;'>" . htmlspecialchars($error) . "</p>"; } ?>

        <h2>-Upload Image-</h2>
        <form method="post" action="user_image.php" enctype="multipart/form-data">
            <input type="file" name="image"><br><br>
            <input type="submit" name="upload" value="Upload Image">
        </form>
    </div>
</body>
</html>
