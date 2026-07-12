<?php
session_start();
include("config.php");
if(!isset($_SESSION["user_id"])) { header("Location: login.php"); exit; }
?>
<!DOCTYPE html>
<html>
<head>
  <title>Admin Dashboard</title>
  <link rel="stylesheet" href="bootstrap.min.css">
  <link rel="stylesheet" href="style.css">
</head>
<body>
<nav class="navbar navbar-dark bg-dark">
  <a class="navbar-brand" href="#">Admin Panel</a>
</nav>

<div class="container mt-4">
  <h2>Manage Posts</h2>
  <a href="cms/add_post.php" class="btn btn-success">Add Post</a>
  <table class="table table-bordered mt-3">
    <tr><th>ID</th><th>Title</th><th>Actions</th></tr>
    <?php
    $result = $conn->query("SELECT * FROM posts");
    while($row = $result->fetch_assoc()){
        echo "<tr>
                <td>{$row['id']}</td>
                <td>{$row['title']}</td>
                <td>
                  <a href='cms/edit_post.php?id={$row['id']}' class='btn btn-warning btn-sm'>Edit</a>
                  <a href='cms/delete_post.php?id={$row['id']}' class='btn btn-danger btn-sm'>Delete</a>
                </td>
              </tr>";
    }
    ?>
  </table>
</div>
</body>
</html>
