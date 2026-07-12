<?php
session_start();
include("../config.php");
if(!isset($_SESSION["user_id"])) { header("Location: ../login.php"); exit; }

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $title = htmlspecialchars(trim($_POST["title"]));
    $body = htmlspecialchars(trim($_POST["body"]));

    $stmt = $conn->prepare("INSERT INTO posts (title, body) VALUES (?, ?)");
    $stmt->bind_param("ss", $title, $body);
    $stmt->execute();
    header("Location: ../index_admin.php");
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Add Post</title>
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
<form method="POST">
  <input type="text" name="title" placeholder="Title" required><br>
  <textarea name="body" placeholder="Content" required></textarea><br>
  <button type="submit">Add Post</button>
</form>
</body>
</html>
