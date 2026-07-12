<?php
// The navbar needs the subjects list for its dropdown, so we fetch it here.
$navSubjects = $conn->query("SELECT id, name FROM subjects ORDER BY name ASC");
?>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container">
    <a class="navbar-brand" href="<?php echo BASE_URL; ?>index.php">Simple CMS</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navMenu">
      <ul class="navbar-nav me-auto">
        <li class="nav-item">
          <a class="nav-link" href="<?php echo BASE_URL; ?>index.php">Home</a>
        </li>

        <!-- Dropdown listing all subjects -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">Subjects</a>
          <ul class="dropdown-menu">
            <?php if ($navSubjects && $navSubjects->num_rows > 0): ?>
              <?php while ($s = $navSubjects->fetch_assoc()): ?>
                <li>
                  <a class="dropdown-item" href="<?php echo BASE_URL; ?>index.php?subject=<?php echo $s['id']; ?>">
                    <?php echo htmlspecialchars($s['name']); ?>
                  </a>
                </li>
              <?php endwhile; ?>
            <?php else: ?>
              <li><span class="dropdown-item-text text-muted">No subjects yet</span></li>
            <?php endif; ?>
          </ul>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="<?php echo BASE_URL; ?>about.php">About</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?php echo BASE_URL; ?>contact.php">Contact</a>
        </li>
      </ul>

      <ul class="navbar-nav">
        <?php if (isLoggedIn()): ?>
          <?php if (isAdmin()): ?>
            <li class="nav-item">
              <a class="nav-link" href="<?php echo BASE_URL; ?>admin/dashboard.php">Admin Dashboard</a>
            </li>
          <?php endif; ?>
          <li class="nav-item">
            <span class="nav-link text-light">Hi, <?php echo htmlspecialchars($_SESSION['username']); ?></span>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="<?php echo BASE_URL; ?>auth/logout.php">Logout</a>
          </li>
        <?php else: ?>
          <li class="nav-item">
            <a class="nav-link" href="<?php echo BASE_URL; ?>auth/login.php">Login</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="<?php echo BASE_URL; ?>auth/register.php">Register</a>
          </li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</nav>
