<?php
require_once __DIR__ . "/config/db.php";
require_once __DIR__ . "/includes/auth.php";

$pageTitle = "About";
require_once __DIR__ . "/includes/header.php";
?>

<h1 class="mb-4">About This Site</h1>

<p>
    Simple CMS is a small content management system built with plain PHP,
    MySQL (using mysqli and prepared statements), and Bootstrap 5.
</p>

<p>
    Admins can organize files into subjects, and any logged-in user can
    browse those subjects and download the files inside them. It was built
    to be short and easy to read, so it's a good project for anyone
    learning how PHP and MySQL work together.
</p>

<?php require_once __DIR__ . "/includes/footer.php"; ?>
