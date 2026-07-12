<?php
session_start();
include("../config.php");
if(!isset($_SESSION["user_id"])) { header("Location: ../login.php"); exit; }

$id = $_GET['id'];
$stmt = $conn->prepare("DELETE FROM posts WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();
header("Location: ../index_admin.php");
?>
