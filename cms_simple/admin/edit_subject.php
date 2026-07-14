<?php
session_start();
include "../config/db.php";

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    $_SESSION['error'] = "Only admins can edit subjects.";
    header("Location: dashboard.php");
    exit();
}

$id = (int)($_GET['id'] ?? 0);
if ($id <= 0) {
    header("Location: dashboard.php");
    exit();
}

if (isset($_POST['update'])) {
    $name = trim($_POST['name']);
    $stmt = $conn->prepare("UPDATE subjects SET name = ? WHERE id = ?");
    $stmt->bind_param("si", $name, $id);
    $stmt->execute();
    $_SESSION['success'] = "Subject updated.";
    header("Location: dashboard.php");
    exit();
}

$subjectStmt = $conn->prepare("SELECT * FROM subjects WHERE id = ?");
$subjectStmt->bind_param("i", $id);
$subjectStmt->execute();
$subject = $subjectStmt->get_result()->fetch_assoc();

$pageTitle = "Edit Subject";
$base = "../";
include "../includes/header.php";
?>

<div class="container py-5">
  <div class="card mx-auto" style="max-width: 560px;">
    <div class="card-body p-4">
      <h3 class="fw-semibold mb-3">Edit Subject</h3>
      <form method="POST">
        <div class="mb-3">
          <label class="form-label">Subject Name</label>
          <input type="text" name="name" class="form-control" value="<?php echo htmlspecialchars($subject['name']); ?>" required>
        </div>
        <button type="submit" name="update" class="btn btn-accent">Save Changes</button>
        <a href="dashboard.php" class="btn btn-outline-secondary ms-2">Cancel</a>
      </form>
    </div>
  </div>
</div>

<?php include "../includes/footer.php"; ?>