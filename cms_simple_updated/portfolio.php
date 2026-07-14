<?php
session_start();
include "config/db.php";

$itemsResult = $conn->query("SELECT * FROM portfolio ORDER BY created_at DESC");

// Pull the admin-editable Portfolio page intro (CMS Content System feature)
$introRow = $conn->query("SELECT content FROM cms_pages WHERE page_name = 'portfolio'")->fetch_assoc();
$introText = $introRow['content'] ?? "A showcase of work and projects.";

$pageTitle = "Portfolio";
$base = "";
include "includes/header.php";
?>

<div class="container py-5">
  <div class="text-center mb-5">
    <h2 class="fw-semibold mb-2">Portfolio</h2>
    <p class="text-muted"><?php echo htmlspecialchars($introText); ?></p>
  </div>

  <?php if ($itemsResult->num_rows == 0): ?>
    <div class="text-center text-muted py-5">
      <i class="bi bi-briefcase fs-1 d-block mb-2"></i>
      No portfolio items yet.
    </div>
  <?php else: ?>
    <div class="row g-4">
      <?php while ($item = $itemsResult->fetch_assoc()): ?>
        <?php
          // Figure out preview type: image, other file, or neither
          $ext = !empty($item['image']) ? strtolower(pathinfo($item['image'], PATHINFO_EXTENSION)) : '';
          $isImage = in_array($ext, ['jpg', 'jpeg', 'png', 'gif']);
          $category = $item['category'] ?? 'Web App';
        ?>
        <div class="col-md-6 col-lg-4">
          <div class="card h-100 fade-in">
            <?php if ($isImage): ?>
              <img src="<?php echo htmlspecialchars($item['image']); ?>" class="card-img-top" style="height:200px; object-fit:cover; border-radius:16px 16px 0 0;">
            <?php elseif (!empty($item['image'])): ?>
              <div class="d-flex align-items-center justify-content-center" style="height:200px; background:#eef1ff; border-radius:16px 16px 0 0;">
                <i class="bi bi-file-earmark-text fs-1 text-primary"></i>
                <span class="ms-2 text-uppercase small fw-semibold text-primary"><?php echo htmlspecialchars($ext); ?></span>
              </div>
            <?php endif; ?>
            <div class="card-body d-flex flex-column">
              <span class="badge badge-soft mb-2 align-self-start"><?php echo htmlspecialchars($category); ?></span>
              <h5 class="card-title"><?php echo htmlspecialchars($item['title']); ?></h5>
              <p class="card-text text-muted"><?php echo nl2br(htmlspecialchars($item['description'] ?? '')); ?></p>

              <div class="mt-auto pt-2 d-flex gap-2 flex-wrap">
                <?php if (!empty($item['link'])): ?>
                  <a href="<?php echo htmlspecialchars($item['link']); ?>" target="_blank" rel="noopener" class="btn btn-sm btn-accent">
                    <i class="bi bi-box-arrow-up-right me-1"></i>Visit
                  </a>
                <?php endif; ?>
                <?php if (!empty($item['image'])): ?>
                  <a href="<?php echo htmlspecialchars($item['image']); ?>" target="_blank" class="btn btn-sm btn-outline-primary">
                    <?php echo $isImage ? 'View' : 'Download'; ?>
                  </a>
                <?php endif; ?>
              </div>
            </div>
          </div>
        </div>
      <?php endwhile; ?>
    </div>
  <?php endif; ?>
</div>

<?php include "includes/footer.php"; ?>
