<?php
$conn = mysqli_connect("localhost", "root", "", "userdb");

if (isset($_POST['upload'])) {
    $username = $_POST['username'];
    $file = $_FILES['image']['name'];
    $target = "uploads/" . basename($file);

    if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
        $sql = "UPDATE users SET image='$file' WHERE username='$username'";
        mysqli_query($conn, $sql);
        $msg = "Image uploaded successfully!";
    } else {
        $msg = "Failed to upload image.";
    }
}
?>
<link rel="stylesheet" href="style.css">
<div class="container">
  <h2>Upload Image</h2>
  <form method="POST" enctype="multipart/form-data">
    <input type="text" name="username" placeholder="Username"><br>
    <input type="file" name="image"><br>
    <button type="submit" name="upload">Upload</button>
  </form>
  <p style="color:green;"><?php if(isset($msg)) echo $msg; ?></p>
  <a href="Admin_home.php">Back</a>
</div>
