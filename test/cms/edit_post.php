<?php
session_start();
include("../config.php");
if(!isset($_SESSION["user_id"])) { header("Location: ../login.php"); exit; }

$id = $_GET['id'];
$result = $conn->query("SELECT * FROM posts WHERE id=$id");
$post = $result->fetch_assoc();

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $title = htmlspecialchars(trim($_POST["title"]));
    $body = htmlspecialchars(trim($_POST["body"]));

    $stmt = $conn->prepare("UPDATE posts SET title=?, body=? WHERE id=?");
    $stmt->bind_param("ssi", $title, $body, $id);
    $stmt->execute();
    header("Location: ../index_admin.php");
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Post</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>    
<form method="POST">
  <input type="text" name="title" value="<?php echo $post['title']; ?>" required><br>
  <textarea name="body" required><?php echo $post['body']; ?></textarea><br>
  <button type="submit">Update Post</button>
</form>
</body>
</html>
