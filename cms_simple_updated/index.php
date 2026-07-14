<?php
session_start();
include "config/db.php";

$subjectsResult = $conn->query("SELECT * FROM subjects ORDER BY name ASC");

// Pull the admin-editable Home content (CMS Content System feature)
$homeContentRow = $conn->query("SELECT content FROM cms_pages WHERE page_name = 'home'")->fetch_assoc();
$homeContent = $homeContentRow['content'] ?? "Browse learning topics, download files, and manage everything with a simple admin dashboard.";

// Latest posts for the Home page (Public Pages feature)
$postsResult = $conn->query("SELECT posts.*, users.username FROM posts LEFT JOIN users ON posts.user_id = users.id ORDER BY posts.created_at DESC LIMIT 5");

$pageTitle = "Home";
$base = "";
include "includes/header.php";
?>

<section class="hero text-center">
  <div class="container position-relative">
    <h1 class="display-5 mb-3">Study Material Manager</h1>
    <p class="lead mx-auto" style="max-width: 640px;">
      <?php echo htmlspecialchars($homeContent); ?>
    </p>
  </div>
</section>

<section class="container py-5">
  <div class="d-flex justify-content-between align-items-end mb-4 flex-wrap gap-2">
    <h2 class="section-title h4 mb-0">Latest Posts</h2>
  </div>

  <?php if ($postsResult->num_rows == 0): ?>
    <div class="text-center text-muted py-4">
      <i class="bi bi-journal-text fs-1 d-block mb-2"></i>
      No posts yet.
    </div>
  <?php else: ?>
    <div class="row g-4 mb-2">
      <?php while ($post = $postsResult->fetch_assoc()): ?>
        <div class="col-lg-6">
          <div class="card h-100 post-card">
            <div class="card-body">
              <h4 class="h5 mb-2"><?php echo htmlspecialchars($post['title']); ?></h4>
              <p class="text-muted small mb-2">
                By <?php echo htmlspecialchars($post['username'] ?? 'Unknown'); ?> &middot;
                <?php echo date("M j, Y", strtotime($post['created_at'])); ?>
              </p>
              <p class="mb-0"><?php echo nl2br(htmlspecialchars(substr($post['content'], 0, 220))); ?><?php echo strlen($post['content']) > 220 ? '...' : ''; ?></p>
            </div>
          </div>
        </div>
      <?php endwhile; ?>
    </div>
  <?php endif; ?>
</section>

<section class="container py-5">
  <div class="d-flex justify-content-between align-items-end mb-4 flex-wrap gap-2">
    <h2 class="section-title h4 mb-0">Subjects & Files</h2>
    <span class="text-muted small"><?php echo $subjectsResult->num_rows; ?> subjects</span>
  </div>

  <?php if ($subjectsResult->num_rows == 0): ?>
    <div class="text-center text-muted py-5">
      <i class="bi bi-journal-x fs-1 d-block mb-2"></i>
      No subjects yet. Please check back soon.
    </div>
  <?php else: ?>
    <div class="row g-4">
      <?php while ($subject = $subjectsResult->fetch_assoc()): ?>
        <?php $filesStmt = $conn->prepare("SELECT * FROM files WHERE subject_id = ? ORDER BY uploaded_at DESC");
              $filesStmt->bind_param("i", $subject['id']);
              $filesStmt->execute();
              $files = $filesStmt->get_result(); ?>
        <div class="col-lg-6">
          <div class="card h-100">
            <div class="card-body">
              <h4 class="h5 mb-3"><?php echo htmlspecialchars($subject['name']); ?></h4>
              <?php if ($files->num_rows == 0): ?>
                <p class="text-muted mb-0">No files uploaded yet.</p>
              <?php else: ?>
                <ul class="list-group list-group-flush">
                  <?php while ($file = $files->fetch_assoc()): ?>
                    <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                      <span><?php echo htmlspecialchars(basename($file['filename'])); ?></span>
                      <a href="<?php echo htmlspecialchars($file['filename']); ?>" class="btn btn-sm btn-outline-primary" download>Download</a>
                    </li>
                  <?php endwhile; ?>
                </ul>
              <?php endif; ?>
            </div>
          </div>
        </div>
      <?php endwhile; ?>
    </div>
  <?php endif; ?>
</section>

<?php include "includes/footer.php"; ?>
