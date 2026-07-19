<?php
session_start();
include "../config/db.php";

// Admin-only: never let a normal user reach this page, even by typing the URL
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    echo "<script>alert('Access denied: only admins can manage documentation.'); window.location.href = '../index.php';</script>";
    exit();
}

$errors = array();
$uploadedCount = 0;

// Allowed types: PDF/DOCX/PPTX for manuals, plus ZIP for bundles of multiple files
$allowedExtensions = ['pdf', 'docx', 'pptx', 'zip'];

// Upload documentation: accepts ONE zip file, or MULTIPLE individual files at once
if (isset($_POST['upload_doc']) && isset($_FILES['doc_files'])) {
    $files = $_FILES['doc_files'];
    $fileCount = count($files['name']);

    if ($fileCount == 0 || $files['name'][0] == '') {
        $errors[] = "Please choose at least one file to upload.";
    }

    // Loop through every selected file (this also correctly handles just a single file)
    for ($i = 0; $i < $fileCount; $i++) {
        if ($files['error'][$i] === UPLOAD_ERR_NO_FILE) {
            continue; // empty slot, skip quietly
        }

        $originalName = basename($files['name'][$i]);
        $ext = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));

        if ($files['error'][$i] !== UPLOAD_ERR_OK) {
            $errors[] = "$originalName failed to upload (it may be too large).";
            continue;
        }

        // Security: only allow the specific extensions we support - anything else is rejected
        if (!in_array($ext, $allowedExtensions)) {
            $errors[] = "$originalName was skipped - only PDF, DOCX, PPTX, or ZIP files are allowed.";
            continue;
        }

        $storedName = "doc_" . time() . "_" . rand(1000, 9999) . "." . $ext;
        $targetPath = "uploads/documentation/" . $storedName;

        if (move_uploaded_file($files['tmp_name'][$i], __DIR__ . "/../" . $targetPath)) {
            $stmt = $conn->prepare("INSERT INTO documentation (file_name, file_path) VALUES (?, ?)");
            $stmt->bind_param("ss", $originalName, $targetPath);
            $stmt->execute();
            $uploadedCount++;
        } else {
            $errors[] = "Could not save $originalName to the server.";
        }
    }

    if ($uploadedCount > 0 && count($errors) == 0) {
        $_SESSION['success'] = $uploadedCount == 1 ? "Documentation uploaded." : "$uploadedCount files uploaded.";
        header("Location: documentation.php");
        exit();
    } elseif ($uploadedCount > 0) {
        // Some files worked and some didn't - let the admin know both things
        $_SESSION['success'] = "$uploadedCount file(s) uploaded successfully.";
    }
}

// Delete a documentation entry
if (isset($_POST['delete_doc'])) {
    $id = (int)$_POST['id'];
    $find = $conn->prepare("SELECT file_path FROM documentation WHERE id = ?");
    $find->bind_param("i", $id);
    $find->execute();
    $row = $find->get_result()->fetch_assoc();
    if ($row && file_exists(__DIR__ . "/../" . $row['file_path'])) {
        unlink(__DIR__ . "/../" . $row['file_path']);
    }
    $stmt = $conn->prepare("DELETE FROM documentation WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $_SESSION['success'] = "Documentation file removed.";
    header("Location: documentation.php");
    exit();
}

$docsResult = $conn->query("SELECT * FROM documentation ORDER BY uploaded_at DESC");

$pageTitle = "Documentation";
$base = "../";
include "../includes/header.php";
?>

<div class="container py-5">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-semibold mb-0">Documentation</h2>
    <a href="dashboard.php" class="btn btn-outline-secondary btn-sm">Back to Dashboard</a>
  </div>

  <?php if (count($errors) > 0): ?>
    <div class="alert alert-danger">
      <ul class="mb-0 ps-3">
        <?php foreach ($errors as $error) { ?>
          <li><?php echo htmlspecialchars($error); ?></li>
        <?php } ?>
      </ul>
    </div>
  <?php endif; ?>

  <div class="card mb-4">
    <div class="card-body">
      <h5 class="mb-3">Upload Documentation</h5>
      <form method="POST" enctype="multipart/form-data" class="d-flex gap-2 flex-wrap">
        <input type="file" name="doc_files[]" accept=".pdf,.docx,.pptx,.zip" multiple class="form-control" style="max-width:360px;" required>
        <button type="submit" name="upload_doc" class="btn btn-accent">Upload</button>
      </form>
      <small class="text-muted d-block mt-2">
        Accepts PDF, DOCX, or PPTX files - select multiple at once, or upload a single ZIP bundle. This section is visible to admins only.
      </small>
    </div>
  </div>

  <div class="card">
    <div class="card-body">
      <h5 class="mb-3">Uploaded Files</h5>
      <?php if ($docsResult->num_rows == 0): ?>
        <p class="text-muted mb-0">No documentation uploaded yet.</p>
      <?php else: ?>
        <ul class="list-group list-group-flush">
          <?php while ($doc = $docsResult->fetch_assoc()): ?>
            <?php
              $docExt = strtolower(pathinfo($doc['file_name'], PATHINFO_EXTENSION));
              $iconClass = 'bi-file-earmark-text text-primary';
              if ($docExt === 'pdf') $iconClass = 'bi-file-earmark-pdf text-danger';
              elseif ($docExt === 'zip') $iconClass = 'bi-file-earmark-zip text-warning';
              elseif ($docExt === 'docx') $iconClass = 'bi-file-earmark-word text-primary';
              elseif ($docExt === 'pptx') $iconClass = 'bi-file-earmark-ppt text-danger';
            ?>
            <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap gap-2">
              <span><i class="bi <?php echo $iconClass; ?> me-2"></i><?php echo htmlspecialchars($doc['file_name']); ?>
                <small class="text-muted ms-2"><?php echo date("M j, Y", strtotime($doc['uploaded_at'])); ?></small>
              </span>
              <div>
                <?php if ($docExt !== 'zip'): ?>
                  <a href="doc_file.php?id=<?php echo (int)$doc['id']; ?>&action=view" target="_blank" class="btn btn-sm btn-outline-primary me-1">View</a>
                <?php endif; ?>
                <a href="doc_file.php?id=<?php echo (int)$doc['id']; ?>&action=download" class="btn btn-sm btn-outline-primary me-1">Download</a>
                <form method="POST" class="d-inline" onsubmit="return confirm('Delete this file?');">
                  <input type="hidden" name="id" value="<?php echo (int)$doc['id']; ?>">
                  <button type="submit" name="delete_doc" class="btn btn-sm btn-outline-danger">Delete</button>
                </form>
              </div>
            </li>
          <?php endwhile; ?>
        </ul>
      <?php endif; ?>
    </div>
  </div>
</div>

<?php include "../includes/footer.php"; ?>
