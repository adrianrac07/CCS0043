<?php
session_start();
include "config/db.php";

$itemsResult = $conn->query("SELECT * FROM portfolio ORDER BY created_at DESC");

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
          $ext = !empty($item['image']) ? strtolower(pathinfo($item['image'], PATHINFO_EXTENSION)) : '';
          $isImage = in_array($ext, ['jpg', 'jpeg', 'png', 'gif']);
          $isPdf = ($ext === 'pdf');
          $category = $item['category'] ?? 'Web App';
        ?>
        <div class="col-md-6 col-lg-4">
          <div class="card h-100 fade-in">
            <?php if ($category === 'Web App'): ?>
              <img src="<?php echo !empty($item['preview_image']) ? htmlspecialchars($item['preview_image']) : 'assets/webapp-placeholder.svg'; ?>"
                   class="card-img-top" style="height:200px; object-fit:cover; border-radius:16px 16px 0 0;">
            <?php endif; ?>
            <div class="card-body d-flex flex-column">
              <span class="badge badge-soft mb-2 align-self-start"><?php echo htmlspecialchars($category); ?></span>
              <h5 class="card-title"><?php echo htmlspecialchars($item['title']); ?></h5>
              <p class="card-text text-muted"><?php echo nl2br(htmlspecialchars($item['description'] ?? '')); ?></p>

              <?php if ($category === 'Study Material' && !empty($item['image'])): ?>
                <div class="mb-2">
                  <?php if ($isImage): ?>
                    <div class="d-flex align-items-center justify-content-center" style="height:120px; background:#eef1ff; border-radius:10px;">
                      <i class="bi bi-file-earmark-image fs-1 text-primary"></i>
                    </div>
                  <?php elseif ($isPdf): ?>
                    <div class="d-flex align-items-center justify-content-center" style="height:120px; background:#eef1ff; border-radius:10px;">
                      <i class="bi bi-file-earmark-pdf fs-1 text-danger"></i>
                    </div>
                  <?php else: ?>
                    <div class="d-flex align-items-center justify-content-center" style="height:120px; background:#eef1ff; border-radius:10px;">
                      <i class="bi bi-file-earmark-text fs-1 text-primary"></i>
                      <span class="ms-2 text-uppercase small fw-semibold text-primary"><?php echo htmlspecialchars($ext); ?></span>
                    </div>
                  <?php endif; ?>
                </div>
                <div id="sm-preview-<?php echo (int)$item['id']; ?>" style="display:none;" class="mb-2">
                  <?php if ($isImage): ?>
                    <img src="<?php echo htmlspecialchars($item['image']); ?>" class="img-fluid rounded">
                  <?php elseif ($isPdf): ?>
                    <iframe src="<?php echo htmlspecialchars($item['image']); ?>" style="width:100%; height:400px; border:0; border-radius:8px;"></iframe>
                  <?php else: ?>
                    <p class="text-muted small mb-0">Preview isn't available for this file type. Use View to open it.</p>
                  <?php endif; ?>
                </div>
              <?php endif; ?>

              <div class="mt-auto pt-2 d-flex gap-2 flex-wrap">
                <?php if ($category === 'Web App'): ?>
                  <?php if (!empty($item['link'])): ?>
                    <a href="<?php echo htmlspecialchars($item['link']); ?>" target="_blank" rel="noopener" class="btn btn-sm btn-accent">
                      <i class="bi bi-box-arrow-up-right me-1"></i>Visit
                    </a>
                  <?php endif; ?>
                <?php else: ?>
                  <?php if (!empty($item['image'])): ?>
                    <button type="button" class="btn btn-sm btn-outline-primary" onclick="var el=document.getElementById('sm-preview-<?php echo (int)$item['id']; ?>'); el.style.display = (el.style.display==='none') ? 'block' : 'none';">
                      <i class="bi bi-eye me-1"></i>Preview
                    </button>
                    <?php if (!$isImage && !$isPdf): ?>
                      <a href="<?php echo htmlspecialchars($item['image']); ?>" target="_blank" class="btn btn-sm btn-outline-secondary">
                        <i class="bi bi-box-arrow-up-right me-1"></i>View
                      </a>
                    <?php endif; ?>
                  <?php endif; ?>
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
