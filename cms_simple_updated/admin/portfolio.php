<?php
session_start();
include "../config/db.php";

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    $_SESSION['error'] = "Only admins can manage the portfolio.";
    header("Location: ../index.php");
    exit();
}

$errors = array();

// Helper: handle an uploaded file for a portfolio item.
// $allowed is the list of extensions permitted for the chosen category.
// Returns the stored path, or "" if no file was uploaded / it was invalid.
function handlePortfolioFile($file, $allowed) {
    if (!isset($file) || $file['error'] !== UPLOAD_ERR_OK) {
        return "";
    }
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

// Which file extensions are allowed depends on the category
$allowedByCategory = [
    'Web App' => ['jpg', 'jpeg', 'png', 'gif'],
    'Study Material' => ['pdf', 'pptx', 'docx', 'jpg', 'jpeg', 'png', 'gif'],
];

// Add new portfolio item
if (isset($_POST['add_item'])) {
    $title = htmlspecialchars(trim($_POST['title']));
    $description = trim($_POST['description']);
    $category = in_array($_POST['category'] ?? '', ['Web App', 'Study Material']) ? $_POST['category'] : 'Web App';
    $link = htmlspecialchars(trim($_POST['link'] ?? ''));

    $allowedExt = $allowedByCategory[$category];
    $image = handlePortfolioFile($_FILES['file'] ?? null, $allowedExt);

    if ($title == "") {
        $errors[] = "Title is required.";
    }
    if ($category == 'Web App' && $link == '' && $image == '') {
        $errors[] = "For a Web App, please provide a file OR a link.";
    }
    if ($category == 'Study Material' && $image == '') {
        $errors[] = "Please upload a PDF, PPTX, DOCX, or image file for Study Material.";
    }

    if (count($errors) == 0) {
        $stmt = $conn->prepare("INSERT INTO portfolio (title, description, image, category, link) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $title, $description, $image, $category, $link);
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
    $category = in_array($_POST['category'] ?? '', ['Web App', 'Study Material']) ? $_POST['category'] : 'Web App';
    $link = htmlspecialchars(trim($_POST['link'] ?? ''));

    $allowedExt = $allowedByCategory[$category];
    $newImage = handlePortfolioFile($_FILES['file'] ?? null, $allowedExt);

    if ($newImage != "") {
        $stmt = $conn->prepare("UPDATE portfolio SET title = ?, description = ?, image = ?, category = ?, link = ? WHERE id = ?");
        $stmt->bind_param("sssssi", $title, $description, $newImage, $category, $link, $id);
    } else {
        $stmt = $conn->prepare("UPDATE portfolio SET title = ?, description = ?, category = ?, link = ? WHERE id = ?");
        $stmt->bind_param("ssssi", $title, $description, $category, $link, $id);
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
      <form method="POST" enctype="multipart/form-data" class="add-portfolio-form">
        <div class="row g-3">
          <div class="col-md-6">
            <input type="text" name="title" class="form-control" placeholder="Title" required>
          </div>
          <div class="col-md-6">
            <select name="category" class="form-select category-select" required>
              <option value="Web App">Web App</option>
              <option value="Study Material">Study Material</option>
            </select>
          </div>
          <div class="col-md-6 link-field">
            <input type="url" name="link" class="form-control" placeholder="Project link (e.g. https://...)">
          </div>
          <div class="col-md-6">
            <input type="file" name="file" class="form-control">
            <small class="text-muted file-hint">Image (jpg, png, gif)</small>
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
            <?php
              $ext = !empty($item['image']) ? strtolower(pathinfo($item['image'], PATHINFO_EXTENSION)) : '';
              $isImage = in_array($ext, ['jpg', 'jpeg', 'png', 'gif']);
            ?>
            <?php if ($isImage): ?>
              <img src="../<?php echo htmlspecialchars($item['image']); ?>" style="width:100%; height:160px; object-fit:cover; border-radius:10px;" class="mb-3">
            <?php elseif (!empty($item['image'])): ?>
              <div class="d-flex align-items-center justify-content-center mb-3" style="height:100px; background:#eef1ff; border-radius:10px;">
                <i class="bi bi-file-earmark-text fs-2 text-primary me-2"></i>
                <span class="text-uppercase small fw-semibold text-primary"><?php echo htmlspecialchars($ext); ?> file</span>
              </div>
            <?php endif; ?>
            <form method="POST" enctype="multipart/form-data" class="edit-portfolio-form">
              <input type="hidden" name="id" value="<?php echo (int)$item['id']; ?>">
              <div class="mb-2">
                <input type="text" name="title" class="form-control" value="<?php echo htmlspecialchars($item['title']); ?>" required>
              </div>
              <div class="mb-2">
                <select name="category" class="form-select category-select">
                  <option value="Web App" <?php echo ($item['category'] ?? 'Web App') == 'Web App' ? 'selected' : ''; ?>>Web App</option>
                  <option value="Study Material" <?php echo ($item['category'] ?? '') == 'Study Material' ? 'selected' : ''; ?>>Study Material</option>
                </select>
              </div>
              <div class="mb-2 link-field">
                <input type="url" name="link" class="form-control" placeholder="Project link" value="<?php echo htmlspecialchars($item['link'] ?? ''); ?>">
              </div>
              <div class="mb-2">
                <textarea name="description" class="form-control" rows="3"><?php echo htmlspecialchars($item['description']); ?></textarea>
              </div>
              <div class="mb-2">
                <input type="file" name="file" class="form-control form-control-sm">
                <small class="text-muted">Leave empty to keep current file.</small>
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

<script>
// Show/hide the link field based on chosen category (Web App can use a link, Study Material cannot)
document.querySelectorAll('.category-select').forEach(function (select) {
  function toggleLinkField() {
    var form = select.closest('form');
    var linkField = form.querySelector('.link-field');
    if (!linkField) return;
    linkField.style.display = (select.value === 'Web App') ? 'block' : 'none';
  }
  select.addEventListener('change', toggleLinkField);
  toggleLinkField();
});
</script>

<?php include "../includes/footer.php"; ?>
