<?php
session_start();
$pageTitle = "About";
$base = "";
include "includes/header.php";
?>

<div class="container py-5">
  <div class="card mx-auto" style="max-width: 760px;">
    <div class="card-body p-4 p-md-5">
      <h2 class="fw-semibold mb-3">About Me</h2>
      <p class="text-muted">
        I am <strong>Adrian Rovic A. Corrales</strong> a 2nd Year Student from FEU Institute of Technology, pursuing a degree in BSITCST. 
        I have a strong passion for web development and enjoy creating dynamic and user-friendly websites. 
      </p>
    </div>
  </div>
</div>

<?php include "includes/footer.php"; ?>