<?php
session_start();
$pageTitle = "About";
$base = "";
include "includes/header.php";
?>

<div class="container py-5">
  <div class="card mx-auto" style="max-width: 760px;">
    <div class="card-body p-4 p-md-5">
      <h2 class="fw-semibold mb-3">About This CMS</h2>
      <p class="text-muted">
        This is a simple PHP and MySQL content management system made for beginners.
        It uses Bootstrap 5 for a clean layout and mysqli prepared statements for safe database access.
      </p>
      <p class="text-muted mb-0">
        Admin users can manage users, subjects, and files, while regular users can browse subjects and download files.
      </p>
    </div>
  </div>
</div>

<?php include "includes/footer.php"; ?>