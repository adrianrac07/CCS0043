<?php
session_start();
include "../config/db.php";

// Admin-only: never let a normal user reach this page, even by typing the URL
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    echo "<script>alert('Access denied: only admins can manage documentation.'); window.location.href = '../index.php';</script>";
    exit();
}

$errors = array();

// Upload a new documentation PDF
if (isset($_POST['upload_doc']) && isset($_FILES['doc_file'])) {
    $file = $_FILES['doc_file'];
    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

    if ($file['error'] !== UPLOAD_ERR_OK) {
        $errors[] = "Upload failed. Please try again.";
    } elseif ($ext !== 'pdf') {
        // Security: only PDF files are allowed for documentation
        $errors[] = "Only PDF files are allowed.";
    } else {
        $originalName = basename($file['name']);
        $storedName = "doc_" . time() . "_" . rand(1000, 9999) . ".pdf";
        $targetPath = "uploads/documentation/" . $storedName;

        if (move_uploaded_file($file['tmp_name'], __DIR__ . "/../" . $targetPath)) {
            $stmt = $conn->prepare("INSERT INTO documentation (file_name, file_path) VALUES (?, ?)");
            $stmt->bind_param("ss", $originalName, $targetPath);
            $stmt->execute();
            $_SESSION['success'] = "Documentation uploaded.";
            header("Location: documentation.php");
            exit();
        } else {
            $errors[] = "Could not save the uploaded file.";
        }
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
          <li><?php echo $error; ?></li>
        <?php } ?>
      </ul>
    </div>
  <?php endif; ?>

  <div class="card mb-4">
    <div class="card-body">
      <h5 class="mb-3">Upload User Manual (PDF)</h5>
      <form method="POST" enctype="multipart/form-data" class="d-flex gap-2 flex-wrap">
        <input type="file" name="doc_file" accept="application/pdf" class="form-control" style="max-width:320px;" required>
        <button type="submit" name="upload_doc" class="btn btn-accent">Upload PDF</button>
      </form>
      <small class="text-muted d-block mt-2">Only PDF files are accepted. This section is visible to admins only.</small>
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
            <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap gap-2">
              <span><i class="bi bi-file-earmark-pdf text-danger me-2"></i><?php echo htmlspecialchars($doc['file_name']); ?>
                <small class="text-muted ms-2"><?php echo date("M j, Y", strtotime($doc['uploaded_at'])); ?></small>
              </span>
              <div>
                <a href="doc_file.php?id=<?php echo (int)$doc['id']; ?>&action=view" target="_blank" class="btn btn-sm btn-outline-primary me-1">View</a>
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
