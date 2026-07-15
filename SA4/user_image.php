<?php
$conn = mysqli_connect("localhost", "root", "", "userdb");
session_start();
$username = $_SESSION['username'];

if (isset($_POST['upload'])) {
    $file = $_FILES['image']['name'];
    $target = "uploads/" . basename($file);

    if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
        $sql = "UPDATE users SET image='$file' WHERE username='$username'";
        mysqli_query($conn, $sql);
        echo "Image uploaded successfully!";
    } else {
        echo "Failed to upload image.";
    }
}
?>
<form method="POST" enctype="multipart/form-data">
    Select Image: <input type="file" name="image"><br>
    <button type="submit" name="upload">Upload</button>
</form>
