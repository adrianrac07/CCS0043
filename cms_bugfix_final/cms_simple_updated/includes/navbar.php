<?php
if (session_status() === PHP_SESSION_NONE) session_start();

// Look up the current user's profile picture for the navbar (if logged in and a DB connection exists)
$navProfileImage = "";
if (isset($_SESSION['user_id']) && isset($conn)) {
    $navStmt = $conn->prepare("SELECT profile_image FROM users WHERE id = ?");
    $navStmt->bind_param("i", $_SESSION['user_id']);
    $navStmt->execute();
    $navUser = $navStmt->get_result()->fetch_assoc();
    $navProfileImage = $navUser['profile_image'] ?? "";
}
?>
<nav class="navbar navbar-expand-lg navbar-dark app-navbar sticky-top shadow-sm">
  <div class="container">
    <a class="navbar-brand fw-semibold" href="<?php echo $base; ?>index.php">
<img src="<?php echo $base; ?>assets/logo1.png" style="width: 40px;">
  </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="mainNav">
      <ul class="navbar-nav ms-auto align-items-lg-center gap-lg-2">
        <li class="nav-item"><a class="nav-link" href="<?php echo $base; ?>index.php"><i class="bi bi-house-door me-1"></i>Home</a></li>
        <li class="nav-item"><a class="nav-link" href="<?php echo $base; ?>about.php"><i class="bi bi-info-circle me-1"></i>About</a></li>
        <li class="nav-item"><a class="nav-link" href="<?php echo $base; ?>portfolio.php"><i class="bi bi-briefcase me-1"></i>Portfolio</a></li>
        <li class="nav-item"><a class="nav-link" href="<?php echo $base; ?>contact.php"><i class="bi bi-envelope me-1"></i>Contact</a></li>
        <?php if (isset($_SESSION['user_id']) && isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
          <li class="nav-item"><a class="nav-link" href="<?php echo $base; ?>admin/dashboard.php"><i class="bi bi-speedometer2 me-1"></i>Dashboard</a></li>
        <?php endif; ?>

        <li class="nav-item">
          <button type="button" id="darkModeToggle" class="btn btn-sm btn-outline-light" title="Toggle dark mode">
            <i class="bi bi-moon-stars"></i>
          </button>
        </li>

        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" role="button" data-bs-toggle="dropdown">
            <?php if (!empty($navProfileImage)): ?>
              <img src="<?php echo $base . htmlspecialchars($navProfileImage); ?>" class="rounded-circle me-2" style="width:26px; height:26px; object-fit:cover;">
            <?php else: ?>
              <img src="<?php echo $base; ?>assets/default-avatar.svg" class="rounded-circle me-2" style="width:26px; height:26px; object-fit:cover;">
            <?php endif; ?>
            <?php echo isset($_SESSION['username']) ? htmlspecialchars($_SESSION['username']) : 'Account'; ?>
          </a>
          <ul class="dropdown-menu dropdown-menu-end shadow">
            <li><a class="dropdown-item" href="<?php echo $base; ?>index.php"><i class="bi bi-house-door me-2"></i>Home</a></li>
            <?php if (isset($_SESSION['user_id'])): ?>
              <li><a class="dropdown-item" href="<?php echo $base; ?>profile.php"><i class="bi bi-person me-2"></i>My Profile</a></li>
            <?php endif; ?>
            <?php if (isset($_SESSION['user_id']) && isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
              <li><a class="dropdown-item" href="<?php echo $base; ?>admin/dashboard.php"><i class="bi bi-speedometer2 me-2"></i>Dashboard</a></li>
              <li><a class="dropdown-item" href="<?php echo $base; ?>admin/documentation.php"><i class="bi bi-file-earmark-pdf me-2"></i>Documentation</a></li>
            <?php endif; ?>
            <li><hr class="dropdown-divider"></li>
            <?php if (isset($_SESSION['user_id'])): ?>
              <li><a class="dropdown-item text-danger" href="<?php echo $base; ?>auth/logout.php"><i class="bi bi-box-arrow-right me-2"></i>Logout</a></li>
            <?php else: ?>
              <li><a class="dropdown-item" href="<?php echo $base; ?>auth/login.php"><i class="bi bi-box-arrow-in-right me-2"></i>Login</a></li>
              <li><a class="dropdown-item" href="<?php echo $base; ?>auth/register.php"><i class="bi bi-person-plus me-2"></i>Register</a></li>
            <?php endif; ?>
          </ul>
        </li>
      </ul>
    </div>
  </div>
</nav>
