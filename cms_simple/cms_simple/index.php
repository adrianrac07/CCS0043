<?php
session_start();
include "config/db.php";

$subjectsResult = $conn->query("SELECT * FROM subjects ORDER BY name ASC");
$pageTitle = "Home";
$base = "";
include "includes/header.php";
?>

<section class="hero text-center">
  <div class="container position-relative">
    <span class="badge bg-light text-primary-emphasis mb-3 px-3 py-2 rounded-pill">
      <i class="bi bi-stars me-1"></i> Simple. Fast. Useful.
    </span>
    <h1 class="display-5 mb-3">A beginner-friendly CMS for subjects and files</h1>
    <p class="lead mx-auto" style="max-width: 640px;">
      Browse learning topics, download files, and manage everything with a simple admin dashboard.
    </p>
    <div class="d-flex gap-3 justify-content-center mt-4">
      <?php if (isset($_SESSION['user_id'])): ?>
        <a href="admin/dashboard.php" class="btn btn-accent btn-lg"><i class="bi bi-speedometer2 me-1"></i> Go to Dashboard</a>
      <?php else: ?>
        <a href="auth/register.php" class="btn btn-accent btn-lg"><i class="bi bi-rocket-takeoff me-1"></i> Get Started</a>
        <a href="auth/login.php" class="btn btn-outline-light btn-lg">Log In</a>
      <?php endif; ?>
    </div>
  </div>
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
