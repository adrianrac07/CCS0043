<?php
session_start();
include "../config/db.php";

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    $_SESSION['error'] = "Only Admins Can manage Files. Please Contact Admin For Access";
    header("Location: dashboard.php");
    exit();
}

$subject_id = (int)($_GET['subject_id'] ?? 0);
if ($subject_id <= 0) {
    header("Location: dashboard.php");
    exit();
}

if (isset($_POST['upload'])) {
    $targetDir = "cms_simple/uploads/";
    $fileName = basename($_FILES['file']['name']);
    $targetFile = $targetDir . $fileName;

    if (move_uploaded_file($_FILES['file']['tmp_name'], $targetFile)) {
        $stmt = $conn->prepare("INSERT INTO files (subject_id, filename) VALUES (?, ?)");
        $path = "uploads/" . $fileName;
        $stmt->bind_param("is", $subject_id, $path);
        $stmt->execute();
        $_SESSION['success'] = "File uploaded.";
    } else {
        $_SESSION['error'] = "Upload failed.";
    }
    header("Location: files.php?subject_id=" . $subject_id);
    exit();
}

if (isset($_POST['delete_file'])) {
    $file_id = (int)$_POST['file_id'];
    $fileStmt = $conn->prepare("SELECT filename FROM files WHERE id = ?");
    $fileStmt->bind_param("i", $file_id);
    $fileStmt->execute();
    $fileRow = $fileStmt->get_result()->fetch_assoc();

    if ($fileRow) {
        $fullPath = __DIR__ . "/../" . $fileRow['filename'];
        if (file_exists($fullPath)) {
            unlink($fullPath);
        }
        $deleteStmt = $conn->prepare("DELETE FROM files WHERE id = ?");
        $deleteStmt->bind_param("i", $file_id);
        $deleteStmt->execute();
        $_SESSION['success'] = "File deleted.";
    }
    header("Location: files.php?subject_id=" . $subject_id);
    exit();
}

$subjectStmt = $conn->prepare("SELECT * FROM subjects WHERE id = ?");
$subjectStmt->bind_param("i", $subject_id);
$subjectStmt->execute();
$subject = $subjectStmt->get_result()->fetch_assoc();

$filesStmt = $conn->prepare("SELECT * FROM files WHERE subject_id = ? ORDER BY uploaded_at DESC");
$filesStmt->bind_param("i", $subject_id);
$filesStmt->execute();
$filesResult = $filesStmt->get_result();

$pageTitle = "Files";
$base = "../";
include "../includes/header.php";
?>

<div class="container py-5">
  <div class="card mb-4">
    <div class="card-body">
      <h3 class="fw-semibold mb-3">Manage Files for <?php echo htmlspecialchars($subject['name']); ?></h3>
      <form method="POST" enctype="multipart/form-data">
        <div class="mb-3">
          <input type="file" name="file" class="form-control" required>
        </div>
        <button type="submit" name="upload" class="btn btn-accent">Upload File</button>
        <a href="dashboard.php" class="btn btn-outline-secondary ms-2">Back</a>
      </form>
    </div>
  </div>

  <div class="card">
    <div class="card-body">
      <h4 class="h5 mb-3">Uploaded Files</h4>
      <?php if ($filesResult->num_rows == 0): ?>
        <p class="text-muted mb-0">No files uploaded for this subject yet.</p>
      <?php else: ?>
        <ul class="list-group list-group-flush">
          <?php while ($file = $filesResult->fetch_assoc()): ?>
            <li class="list-group-item d-flex justify-content-between align-items-center">
              <span><?php echo htmlspecialchars(basename($file['filename'])); ?></span>
              <form method="POST" class="d-inline">
                <input type="hidden" name="file_id" value="<?php echo (int)$file['id']; ?>">
                <button type="submit" name="delete_file" class="btn btn-sm btn-outline-danger">Delete</button>
              </form>
            </li>
          <?php endwhile; ?>
        </ul>
      <?php endif; ?>
    </div>
  </div>
</div>

<?php include "../includes/footer.php"; ?>