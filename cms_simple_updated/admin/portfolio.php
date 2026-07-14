<?php
session_start();
include "../config/db.php";

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    $_SESSION['error'] = "Only admins can manage the portfolio.";
    header("Location: ../index.php");
    exit();
}

$errors = array();

// Helper: handle an uploaded image, returns the stored path or "" if none/invalid
function handlePortfolioImage($file) {
    if (!isset($file) || $file['error'] !== UPLOAD_ERR_OK) {
        return "";
    }
    $allowed = ['jpg', 'jpeg', 'png', 'gif'];
    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    if (!in_array($ext, $allowed)) {
        return "";
    }
    $newName = "portfolio_" . time() . "_" . rand(1000, 9999) . "." . $ext;
    $targetPath = "uploads/portfolio/" . $newName;
    if (move_uploaded_file($file['tmp_name'], __DIR__ . "/../" . $targetPath)) {
        return $targetPath;
    }
    return "";
}

// Add new portfolio item
if (isset($_POST['add_item'])) {
    $title = htmlspecialchars(trim($_POST['title']));
    $description = trim($_POST['description']);
    $image = handlePortfolioImage($_FILES['image'] ?? null);

    if ($title == "") {
        $errors[] = "Title is required.";
    }

    if (count($errors) == 0) {
        $stmt = $conn->prepare("INSERT INTO portfolio (title, description, image) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $title, $description, $image);
        $stmt->execute();
        $_SESSION['success'] = "Portfolio item added.";
        header("Location: portfolio.php");
        exit();
    }
}

// Update existing portfolio item
if (isset($_POST['update_item'])) {
    $id = (int)$_POST['id'];
    $title = htmlspecialchars(trim($_POST['title']));
    $description = trim($_POST['description']);

    $newImage = handlePortfolioImage($_FILES['image'] ?? null);

    if ($newImage != "") {
        $stmt = $conn->prepare("UPDATE portfolio SET title = ?, description = ?, image = ? WHERE id = ?");
        $stmt->bind_param("sssi", $title, $description, $newImage, $id);
    } else {
        $stmt = $conn->prepare("UPDATE portfolio SET title = ?, description = ? WHERE id = ?");
        $stmt->bind_param("ssi", $title, $description, $id);
    }
    $stmt->execute();
    $_SESSION['success'] = "Portfolio item updated.";
    header("Location: portfolio.php");
    exit();
}

// Delete portfolio item
if (isset($_POST['delete_item'])) {
    $id = (int)$_POST['id'];

    $find = $conn->prepare("SELECT image FROM portfolio WHERE id = ?");
    $find->bind_param("i", $id);
    $find->execute();
    $row = $find->get_result()->fetch_assoc();
    if ($row && $row['image'] && file_exists(__DIR__ . "/../" . $row['image'])) {
        unlink(__DIR__ . "/../" . $row['image']);
    }

    $stmt = $conn->prepare("DELETE FROM portfolio WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $_SESSION['success'] = "Portfolio item deleted.";
    header("Location: portfolio.php");
    exit();
}

$itemsResult = $conn->query("SELECT * FROM portfolio ORDER BY created_at DESC");

$pageTitle = "Manage Portfolio";
$base = "../";
include "../includes/header.php";
?>

<div class="container py-5">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-semibold mb-0">Manage Portfolio</h2>
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
      <h5 class="mb-3">Add Portfolio Item</h5>
      <form method="POST" enctype="multipart/form-data">
        <div class="row g-3">
          <div class="col-md-6">
            <input type="text" name="title" class="form-control" placeholder="Title" required>
          </div>
          <div class="col-md-6">
            <input type="file" name="image" class="form-control">
          </div>
          <div class="col-12">
            <textarea name="description" class="form-control" rows="3" placeholder="Description"></textarea>
          </div>
        </div>
        <button type="submit" name="add_item" class="btn btn-accent mt-3">Add Item</button>
      </form>
    </div>
  </div>

  <div class="row g-4">
    <?php while ($item = $itemsResult->fetch_assoc()): ?>
      <div class="col-md-6">
        <div class="card">
          <div class="card-body">
            <?php if ($item['image']): ?>
              <img src="../<?php echo htmlspecialchars($item['image']); ?>" style="width:100%; height:160px; object-fit:cover; border-radius:10px;" class="mb-3">
            <?php endif; ?>
            <form method="POST" enctype="multipart/form-data">
              <input type="hidden" name="id" value="<?php echo (int)$item['id']; ?>">
              <div class="mb-2">
                <input type="text" name="title" class="form-control" value="<?php echo htmlspecialchars($item['title']); ?>" required>
              </div>
              <div class="mb-2">
                <textarea name="description" class="form-control" rows="3"><?php echo htmlspecialchars($item['description']); ?></textarea>
              </div>
              <div class="mb-2">
                <input type="file" name="image" class="form-control form-control-sm">
                <small class="text-muted">Leave empty to keep current image.</small>
              </div>
              <div class="d-flex gap-2">
                <button type="submit" name="update_item" class="btn btn-sm btn-accent">Save</button>
                <button type="submit" name="delete_item" class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete this item?');">Delete</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    <?php endwhile; ?>
  </div>
</div>

<?php include "../includes/footer.php"; ?>
