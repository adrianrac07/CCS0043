<?php
session_start();
include "config/db.php";

$itemsResult = $conn->query("SELECT * FROM portfolio ORDER BY created_at DESC");

$pageTitle = "Portfolio";
$base = "";
include "includes/header.php";
?>

<div class="container py-5">
  <div class="text-center mb-5">
    <h2 class="fw-semibold mb-2">Portfolio</h2>
    <p class="text-muted">A showcase of work and projects.</p>
  </div>

  <?php if ($itemsResult->num_rows == 0): ?>
    <div class="text-center text-muted py-5">
      <i class="bi bi-briefcase fs-1 d-block mb-2"></i>
      No portfolio items yet.
    </div>
  <?php else: ?>
    <div class="row g-4">
      <?php while ($item = $itemsResult->fetch_assoc()): ?>
        <div class="col-md-6 col-lg-4">
          <div class="card h-100 fade-in">
            <?php if ($item['image']): ?>
              <img src="<?php echo htmlspecialchars($item['image']); ?>" class="card-img-top" style="height:200px; object-fit:cover; border-radius:16px 16px 0 0;">
            <?php endif; ?>
            <div class="card-body">
              <h5 class="card-title"><?php echo htmlspecialchars($item['title']); ?></h5>
              <p class="card-text text-muted"><?php echo nl2br(htmlspecialchars($item['description'])); ?></p>
            </div>
          </div>
        </div>
      <?php endwhile; ?>
    </div>
  <?php endif; ?>
</div>

<?php include "includes/footer.php"; ?>
