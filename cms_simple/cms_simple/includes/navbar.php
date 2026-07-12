<?php if (session_status() === PHP_SESSION_NONE) session_start(); ?>
<nav class="navbar navbar-expand-lg navbar-dark app-navbar sticky-top shadow-sm">
  <div class="container">
    <a class="navbar-brand fw-semibold" href="<?php echo $base; ?>index.php">
      <i class="bi bi-stack"></i> Personal<span class="text-accent">CMS</span>
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="mainNav">
      <ul class="navbar-nav ms-auto align-items-lg-center gap-lg-2">
        <li class="nav-item"><a class="nav-link" href="<?php echo $base; ?>index.php"><i class="bi bi-house-door me-1"></i>Home</a></li>
        <li class="nav-item"><a class="nav-link" href="<?php echo $base; ?>about.php"><i class="bi bi-info-circle me-1"></i>About</a></li>
        <li class="nav-item"><a class="nav-link" href="<?php echo $base; ?>contact.php"><i class="bi bi-envelope me-1"></i>Contact</a></li>
        <?php if (isset($_SESSION['user_id']) && isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
          <li class="nav-item"><a class="nav-link" href="<?php echo $base; ?>admin/dashboard.php"><i class="bi bi-speedometer2 me-1"></i>Dashboard</a></li>
        <?php endif; ?>

        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
            <i class="bi bi-person-circle me-1"></i>
            <?php echo isset($_SESSION['username']) ? htmlspecialchars($_SESSION['username']) : 'Account'; ?>
          </a>
          <ul class="dropdown-menu dropdown-menu-end shadow">
            <li><a class="dropdown-item" href="<?php echo $base; ?>index.php"><i class="bi bi-house-door me-2"></i>Home</a></li>
            <?php if (isset($_SESSION['user_id']) && isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
              <li><a class="dropdown-item" href="<?php echo $base; ?>admin/dashboard.php"><i class="bi bi-speedometer2 me-2"></i>Dashboard</a></li>
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
