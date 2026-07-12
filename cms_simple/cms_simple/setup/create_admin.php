<?php
// Run this file ONCE in your browser to create a working admin login.
// DELETE THIS FILE after running it — anyone could use it to create admin accounts.

include "../config/db.php";

$username = "admin";
$email = "admin@gmail.com";
$password = "123123"; // change this if you like
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

$check = $conn->prepare("SELECT id FROM users WHERE email = ?");
$check->bind_param("s", $email);
$check->execute();
$existing = $check->get_result()->fetch_assoc();

if ($existing) {
    $update = $conn->prepare("UPDATE users SET password = ?, role = 'admin' WHERE email = ?");
    $update->bind_param("ss", $hashed_password, $email);
    $update->execute();
} else {
    $insert = $conn->prepare("INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, 'admin')");
    $insert->bind_param("sss", $username, $email, $hashed_password);
    $insert->execute();
}

echo "Admin user ready.<br>Email: $email<br>Password: $password<br><br>";
echo "<strong>Now delete setup/create_admin.php for security.</strong>";
