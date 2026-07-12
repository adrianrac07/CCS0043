<?php
session_start();
?>
<nav class="navbar navbar-expand-lg bg-dark px-3">
  <div class="container-fluid">
    <a class="navbar-brand text-white" href="home.php">Portfolio</a>

    <ul class="navbar-nav me-auto">
      <li class="nav-item"><a class="nav-link text-white" href="about-me.php">About Me</a></li>
      <li class="nav-item"><a class="nav-link text-white" href="projects.php">Projects</a></li>
    </ul>

    <ul class="navbar-nav">
      <?php if(isset($_SESSION['user'])): ?>
        <li class="nav-item text-white me-3">
          <?= $_SESSION['user']['username']; ?>
        </li>
        <li class="nav-item">
          <a href="logout.php" class="nav-link text-danger">Logout</a>
        </li>
      <?php else: ?>
        <li class="nav-item"><a class="nav-link text-white" href="index.php">Login</a></li>
      <?php endif; ?>
    </ul>
  </div>
</nav>