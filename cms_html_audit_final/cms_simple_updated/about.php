<?php
session_start();
include "config/db.php";

$aboutRow = $conn->query("SELECT content FROM cms_pages WHERE page_name = 'about'")->fetch_assoc();
$aboutContent = $aboutRow['content'] ?? "I am Adrian Rovic A. Corrales a 2nd Year Student from FEU Institute of Technology, pursuing a degree in BSITCST. I have a strong passion for web development and enjoy creating dynamic and user-friendly websites.";

$pageTitle = "About";
$base = "";
include "includes/header.php";
?>

<div class="container py-5">
  <div class="card mx-auto" style="max-width: 760px;">
    <div class="card-body p-4 p-md-5">
      <h2 class="fw-semibold mb-3">About Me</h2>
      <p class="text-muted"><?php echo nl2br(htmlspecialchars($aboutContent)); ?></p>
    </div>
  </div>
</div>

<?php include "includes/footer.php"; ?>