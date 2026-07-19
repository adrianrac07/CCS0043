<?php
session_start();
include "config/db.php";

// Pull the admin-editable Home content (CMS Content System feature)
$homeContentRow = $conn->query("SELECT content FROM cms_pages WHERE page_name = 'home'")->fetch_assoc();
$homeContent = $homeContentRow['content'] ?? "Welcome to my personal website.";

// Landing page now shows ONLY a preview of the portfolio (max 3 items)
$portfolioResult = $conn->query("SELECT * FROM portfolio ORDER BY created_at DESC LIMIT 3");

$pageTitle = "Home";
$base = "";
include "includes/header.php";
?>

<section class="hero text-center">
  <div class="container position-relative">
    <h1 class="display-5 mb-3">Welcome to My Personal Website</h1>
    <p class="lead mx-auto" style="max-width: 640px;">
      <?php echo nl2br(htmlspecialchars($homeContent)); ?>
    </p>
    <div class="d-flex gap-3 justify-content-center mt-4">
      <?php if (!isset($_SESSION['user_id'])): ?>
        <a href="auth/register.php" class="btn btn-accent btn-lg"><i class="bi bi-rocket-takeoff me-1"></i> Get Started</a>
        <a href="auth/login.php" class="btn btn-outline-light btn-lg">Log In</a>
      <?php endif; ?>
    </div>
  </div>
</section>

<section class="container py-5">
  <div class="d-flex justify-content-between align-items-end mb-4 flex-wrap gap-2">
    <h2 class="section-title h4 mb-0">Featured Portfolio</h2>
    <a href="portfolio.php" class="btn btn-sm btn-outline-primary">View All</a>
  </div>

  <?php if ($portfolioResult->num_rows == 0): ?>
    <div class="text-center text-muted py-5">
      <i class="bi bi-briefcase fs-1 d-block mb-2"></i>
      No portfolio items yet.
    </div>
  <?php else: ?>
    <div class="row g-4">
      <?php while ($item = $portfolioResult->fetch_assoc()): ?>
        <div class="col-md-6 col-lg-4">
          <div class="card h-100 fade-in">
            <?php
              $category = $item['category'] ?? 'Web App';
              $ext = !empty($item['image']) ? strtolower(pathinfo($item['image'], PATHINFO_EXTENSION)) : '';
              $isImage = in_array($ext, ['jpg', 'jpeg', 'png', 'gif']);
              $isPdf = ($ext === 'pdf');
            ?>
            <?php if ($category === 'Web App'): ?>
              <img src="<?php echo !empty($item['preview_image']) ? htmlspecialchars($item['preview_image']) : 'assets/webapp-placeholder.svg'; ?>"
                   class="card-img-top" style="height:180px; object-fit:cover; border-radius:16px 16px 0 0;">
            <?php endif; ?>
            <div class="card-body d-flex flex-column">
              <span class="badge badge-soft mb-2 align-self-start"><?php echo htmlspecialchars($category); ?></span>
              <h5 class="card-title"><?php echo htmlspecialchars($item['title']); ?></h5>
              <p class="card-text text-muted small">
                <?php echo htmlspecialchars(substr($item['description'] ?? '', 0, 100)); ?><?php echo strlen($item['description'] ?? '') > 100 ? '...' : ''; ?>
              </p>

              <?php if ($category === 'Study Material' && !empty($item['image'])): ?>
                <div class="mb-2">
                  <?php if ($isImage): ?>
                    <div class="d-flex align-items-center justify-content-center" style="height:100px; background:#eef1ff; border-radius:10px;">
                      <i class="bi bi-file-earmark-image fs-2 text-primary"></i>
                    </div>
                  <?php elseif ($isPdf): ?>
                    <div class="d-flex align-items-center justify-content-center" style="height:100px; background:#eef1ff; border-radius:10px;">
                      <i class="bi bi-file-earmark-pdf fs-2 text-danger"></i>
                    </div>
                  <?php else: ?>
                    <div class="d-flex align-items-center justify-content-center" style="height:100px; background:#eef1ff; border-radius:10px;">
                      <i class="bi bi-file-earmark-text fs-2 text-primary"></i>
                    </div>
                  <?php endif; ?>
                </div>
                <!-- Hidden embedded preview, toggled by the Preview button below -->
                <div id="sm-preview-<?php echo (int)$item['id']; ?>" style="display:none;" class="mb-2">
                  <?php if ($isImage): ?>
                    <img src="<?php echo htmlspecialchars($item['image']); ?>" class="img-fluid rounded">
                  <?php elseif ($isPdf): ?>
                    <iframe src="<?php echo htmlspecialchars($item['image']); ?>" style="width:100%; height:300px; border:0; border-radius:8px;"></iframe>
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
</section>

<?php include "includes/footer.php"; ?>
