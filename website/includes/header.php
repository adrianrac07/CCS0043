<?php
/**
 * header.php
 * Shared top navigation bar, included on every page.
 * $active_page should be set BEFORE including this file
 * (e.g. "home", "reviewer", "quiz", "result") so we can
 * highlight the current nav link.
 */
if (!isset($active_page)) {
    $active_page = "";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>College Physics 1 Reviewer</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>

<header class="site-header">
    <h1>&#9878; GED0081 College Physics 1 Reviewer</h1>
    <nav>
        <a href="index.php" class="<?php echo $active_page === 'home' ? 'active' : ''; ?>">Home</a>
        <a href="reviewer.php" class="<?php echo $active_page === 'reviewer' ? 'active' : ''; ?>">Reviewer</a>
        <a href="quiz.php" class="<?php echo $active_page === 'quiz' ? 'active' : ''; ?>">Quiz</a>
    </nav>
</header>

<main class="container">
