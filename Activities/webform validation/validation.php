<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST["name"]);
    $username = trim($_POST["username"]);
    $email = trim($_POST["email"]);

    if (!preg_match("/^[a-zA-Z ]{2,50}$/", $name)) {
        echo "Invalid name format. Required format: 2-50 alphabetic characters.";
        exit;
    }
    elseif(!preg_match("/^[a-zA-Z0-9]{5,15}$/", $username)) {
        echo "Invalid username format. Required format: 5-15 alphanumeric characters.";
        exit;
    }
    elseif(!preg_match("/^[\w\.-]+@[\w\.-]+\.[a-zA-Z]{10,50}$/", $email)) {
        echo "Invalid email format.";
        exit;
    }
}
?>