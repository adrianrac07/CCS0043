<?php
session_start();
include("config.php");
if(!isset($_SESSION["user_id"])) { header("Location: login.php"); exit; }
?>
<!DOCTYPE html>
<html>
<head>
  <title>User Homepage</title>
  <link rel="stylesheet" href="bootstrap.min.css">
  <link rel="stylesheet" href="style.css">
</head>
<body>
<nav class="navbar navbar-dark bg-dark">
  <a class="navbar-brand" href="#">User Portal</a>
</nav>

<div class="container mt-4">
  <h2>Posts</h2>
  <?php
  $result = $conn->query("SELECT * FROM posts ORDER BY created_at DESC");
  while($row = $result->fetch_assoc()){
      echo "<div class='card mb-3'>
              <div class='card-body'>
                <h5 class='card-title'>{$row['title']}</h5>
                <p class='card-text'>{$row['body']}</p>
              </div>
            </div>";
  }
  ?>
</div>
</body>
</html>
