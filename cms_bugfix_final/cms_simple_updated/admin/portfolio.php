<?php
session_start();
include "../config/db.php";

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    echo "<script>alert('Access denied: only admins can manage the portfolio.'); window.location.href = '../index.php';</script>";
    exit();
}

$errors = array();

// Helper: handle an uploaded file. $allowed is the list of extensions permitted.
// Returns the stored path, or "" if no file was uploaded.
// $errorMsg is set (by reference) whenever a file WAS selected but got rejected,
// so the caller can tell the admin why - instead of silently dropping it while
// still reporting "success" (this was the root cause of the Web App preview bug:
// a rejected/failed thumbnail upload was ignored silently, so the item saved fine
// but with no preview_image, and the admin never knew why).
function handlePortfolioFile($file, $allowed, &$errorMsg = null) {
    $errorMsg = null;

    // No file field submitted, or the user simply didn't choose a file - not an error
    if (!isset($file) || $file['error'] === UPLOAD_ERR_NO_FILE) {
        return "";
    }

    if ($file['error'] !== UPLOAD_ERR_OK) {
        $errorMsg = "The file upload failed (it may be too large). Please try a smaller file.";
        return "";
    }

    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    if (!in_array($ext, $allowed)) {
        $errorMsg = "That file type (." . htmlspecialchars($ext) . ") isn't supported. Allowed: " . implode(', ', $allowed) . ".";
        return "";
    }

    $newName = "portfolio_" . time() . "_" . rand(1000, 9999) . "." . $ext;
    $targetPath = "uploads/portfolio/" . $newName;
    if (move_uploaded_file($file['tmp_name'], __DIR__ . "/../" . $targetPath)) {
        return $targetPath;
    }

    $errorMsg = "Could not save the uploaded file to the server.";
    return "";
}

// Note: "webp" added - it's a very common export/screenshot format that was
// previously missing, causing valid thumbnail uploads to be silently rejected.
$imageOnly = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
$documentTypes = ['pdf', 'pptx', 'docx', 'jpg', 'jpeg', 'png', 'gif', 'webp'];

// Add new portfolio item
if (isset($_POST['add_item'])) {
    $title = htmlspecialchars(trim($_POST['title']));
    $description = trim($_POST['description']);
    $category = in_array($_POST['category'] ?? '', ['Web App', 'Study Material']) ? $_POST['category'] : 'Web App';
    $link = htmlspecialchars(trim($_POST['link'] ?? ''));

    // Web App gets an optional thumbnail (preview_image); Study Material gets its document (image)
    $previewImage = handlePortfolioFile($_FILES['preview_image'] ?? null, $imageOnly, $previewImageError);
    $docFile = handlePortfolioFile($_FILES['doc_file'] ?? null, $documentTypes, $docFileError);

    if ($title == "") {
        $errors[] = "Title is required.";
    }
    if ($category == 'Web App' && $link == '') {
        $errors[] = "Please provide a link for the Web App.";
    }
    if ($category == 'Study Material' && $docFile == '' && !$docFileError) {
        $errors[] = "Please upload a PDF, PPTX, DOCX, or image file for Study Material.";
    }
    // Surface any file-specific problems instead of silently dropping the file
    // (this is what previously caused the "upload succeeds but no preview" bug)
    if ($previewImageError) {
        $errors[] = $previewImageError;
    }
    if ($docFileError) {
        $errors[] = $docFileError;
    }

    if (count($errors) == 0) {
        $stmt = $conn->prepare("INSERT INTO portfolio (title, description, image, category, link, preview_image) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $title, $description, $docFile, $category, $link, $previewImage);
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

    $newPreviewImage = handlePortfolioFile($_FILES['preview_image'] ?? null, $imageOnly, $previewImageError);
    $newDocFile = handlePortfolioFile($_FILES['doc_file'] ?? null, $documentTypes, $docFileError);

    // Build the update dynamically so we only overwrite files that were actually replaced
    $fields = "title = ?, description = ?, category = ?, link = ?";
    $types = "ssss";
    $params = [$title, $description, $category, $link];

    if ($newDocFile != "") {
        $fields .= ", image = ?";
        $types .= "s";
        $params[] = $newDocFile;
    }
    if ($newPreviewImage != "") {
        $fields .= ", preview_image = ?";
        $types .= "s";
        $params[] = $newPreviewImage;
    }

    $types .= "i";
    $params[] = $id;

    $stmt = $conn->prepare("UPDATE portfolio SET $fields WHERE id = ?");
    $stmt->bind_param($types, ...$params);
    $stmt->execute();

    // Text fields (and any valid file) are saved either way; but if a file was
    // selected and rejected, tell the admin exactly why instead of staying quiet.
    if ($previewImageError || $docFileError) {
        $_SESSION['error'] = trim(($previewImageError ?? '') . ' ' . ($docFileError ?? ''));
    } else {
        $_SESSION['success'] = "Portfolio item updated.";
    }
    header("Location: portfolio.php");
    exit();
}

// Delete portfolio item
if (isset($_POST['delete_item'])) {
    $id = (int)$_POST['id'];

    $find = $conn->prepare("SELECT image, preview_image FROM portfolio WHERE id = ?");
    $find->bind_param("i", $id);
    $find->execute();
    $row = $find->get_result()->fetch_assoc();
    if ($row) {
        if (!empty($row['image']) && file_exists(__DIR__ . "/../" . $row['image'])) {
            unlink(__DIR__ . "/../" . $row['image']);
        }
        if (!empty($row['preview_image']) && file_exists(__DIR__ . "/../" . $row['preview_image'])) {
            unlink(__DIR__ . "/../" . $row['preview_image']);
        }
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

  <!-- Add Portfolio Item: organized into tabs so the form isn't one long list -->
  <div class="card mb-4">
    <div class="card-body">
      <h5 class="mb-3">Add Portfolio Item</h5>
      <form method="POST" enctype="multipart/form-data" class="portfolio-form">
        <ul class="nav nav-tabs mb-3">
          <li class="nav-item"><button type="button" class="nav-link active" data-bs-toggle="tab" data-bs-target="#add-basic">Basic Info</button></li>
          <li class="nav-item"><button type="button" class="nav-link" data-bs-toggle="tab" data-bs-target="#add-file">File / Link</button></li>
          <li class="nav-item"><button type="button" class="nav-link" data-bs-toggle="tab" data-bs-target="#add-category">Category</button></li>
        </ul>
        <div class="tab-content">
          <div class="tab-pane fade show active" id="add-basic">
            <div class="mb-3">
              <label class="form-label">Title</label>
              <input type="text" name="title" class="form-control" placeholder="Project title" required>
            </div>
            <div class="mb-3">
              <label class="form-label">Description</label>
              <textarea name="description" class="form-control" rows="4" placeholder="Short description"></textarea>
            </div>
          </div>
          <div class="tab-pane fade" id="add-file">
            <!-- Web App fields: link + thumbnail image -->
            <div class="webapp-fields">
              <div class="mb-3">
                <label class="form-label">Project Link</label>
                <input type="url" name="link" class="form-control" placeholder="https://...">
              </div>
              <div class="mb-3">
                <label class="form-label">Preview Thumbnail (optional)</label>
                <input type="file" name="preview_image" class="form-control" accept="image/*">
                <small class="text-muted">Image only (jpg, png, gif, webp). Shown as the card thumbnail.</small>
              </div>
            </div>
            <!-- Study Material field: the document itself -->
            <div class="studymat-fields" style="display:none;">
              <div class="mb-3">
                <label class="form-label">Upload Document</label>
                <input type="file" name="doc_file" class="form-control">
                <small class="text-muted">PDF, PPTX, DOCX, or image.</small>
              </div>
            </div>
          </div>
          <div class="tab-pane fade" id="add-category">
            <div class="mb-3">
              <label class="form-label">Category</label>
              <select name="category" class="form-select category-select" required>
                <option value="Web App">Web App</option>
                <option value="Study Material">Study Material</option>
              </select>
              <small class="text-muted d-block mt-2">Web App: add a link and an optional thumbnail image.<br>Study Material: upload a PDF, PPTX, DOCX, or image.</small>
            </div>
          </div>
        </div>
        <button type="submit" name="add_item" class="btn btn-accent mt-2">Add Item</button>
      </form>
    </div>
  </div>

  <div class="row g-4">
    <?php while ($item = $itemsResult->fetch_assoc()): ?>
      <?php
        $iid = (int)$item['id'];
        $ext = !empty($item['image']) ? strtolower(pathinfo($item['image'], PATHINFO_EXTENSION)) : '';
        $isImage = in_array($ext, ['jpg', 'jpeg', 'png', 'gif']);
      ?>
      <div class="col-md-6">
        <div class="card">
          <div class="card-body">
            <?php if (($item['category'] ?? 'Web App') === 'Web App'): ?>
              <img src="../<?php echo !empty($item['preview_image']) ? htmlspecialchars($item['preview_image']) : 'assets/webapp-placeholder.svg'; ?>"
                   style="width:100%; height:160px; object-fit:cover; border-radius:10px;" class="mb-3">
            <?php elseif ($isImage): ?>
              <img src="../<?php echo htmlspecialchars($item['image']); ?>" style="width:100%; height:160px; object-fit:cover; border-radius:10px;" class="mb-3">
            <?php elseif (!empty($item['image'])): ?>
              <div class="d-flex align-items-center justify-content-center mb-3" style="height:100px; background:#eef1ff; border-radius:10px;">
                <i class="bi bi-file-earmark-text fs-2 text-primary me-2"></i>
                <span class="text-uppercase small fw-semibold text-primary"><?php echo htmlspecialchars($ext); ?> file</span>
              </div>
            <?php endif; ?>

            <form method="POST" enctype="multipart/form-data" class="portfolio-form">
              <input type="hidden" name="id" value="<?php echo $iid; ?>">
              <ul class="nav nav-tabs mb-3">
                <li class="nav-item"><button type="button" class="nav-link active" data-bs-toggle="tab" data-bs-target="#edit-basic-<?php echo $iid; ?>">Basic Info</button></li>
                <li class="nav-item"><button type="button" class="nav-link" data-bs-toggle="tab" data-bs-target="#edit-file-<?php echo $iid; ?>">File / Link</button></li>
                <li class="nav-item"><button type="button" class="nav-link" data-bs-toggle="tab" data-bs-target="#edit-category-<?php echo $iid; ?>">Category</button></li>
              </ul>
              <div class="tab-content">
                <div class="tab-pane fade show active" id="edit-basic-<?php echo $iid; ?>">
                  <div class="mb-2">
                    <label class="form-label">Title</label>
                    <input type="text" name="title" class="form-control" value="<?php echo htmlspecialchars($item['title']); ?>" required>
                  </div>
                  <div class="mb-2">
                    <label class="form-label">Description</label>
                    <textarea name="description" class="form-control" rows="3"><?php echo htmlspecialchars($item['description'] ?? ''); ?></textarea>
                  </div>
                </div>
                <div class="tab-pane fade" id="edit-file-<?php echo $iid; ?>">
                  <div class="webapp-fields">
                    <div class="mb-2">
                      <label class="form-label">Project Link</label>
                      <input type="url" name="link" class="form-control" placeholder="https://..." value="<?php echo htmlspecialchars($item['link'] ?? ''); ?>">
                    </div>
                    <div class="mb-2">
                      <label class="form-label">Replace Thumbnail</label>
                      <input type="file" name="preview_image" class="form-control form-control-sm" accept="image/*">
                      <small class="text-muted">Leave empty to keep current thumbnail.</small>
                    </div>
                  </div>
                  <div class="studymat-fields" style="display:none;">
                    <div class="mb-2">
                      <label class="form-label">Replace Document</label>
                      <input type="file" name="doc_file" class="form-control form-control-sm">
                      <small class="text-muted">Leave empty to keep current document.</small>
                    </div>
                  </div>
                </div>
                <div class="tab-pane fade" id="edit-category-<?php echo $iid; ?>">
                  <div class="mb-2">
                    <label class="form-label">Category</label>
                    <select name="category" class="form-select category-select">
                      <option value="Web App" <?php echo ($item['category'] ?? 'Web App') == 'Web App' ? 'selected' : ''; ?>>Web App</option>
                      <option value="Study Material" <?php echo ($item['category'] ?? '') == 'Study Material' ? 'selected' : ''; ?>>Study Material</option>
                    </select>
                  </div>
                </div>
              </div>
              <div class="d-flex gap-2 mt-2">
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
// Show the correct upload fields based on the chosen category:
// Web App -> link + thumbnail image, Study Material -> document upload
document.querySelectorAll('.category-select').forEach(function (select) {
  function toggleFields() {
    var form = select.closest('form');
    var webappFields = form.querySelector('.webapp-fields');
    var studymatFields = form.querySelector('.studymat-fields');
    if (!webappFields || !studymatFields) return;
    var isWebApp = select.value === 'Web App';
    webappFields.style.display = isWebApp ? 'block' : 'none';
    studymatFields.style.display = isWebApp ? 'none' : 'block';
  }
  select.addEventListener('change', toggleFields);
  toggleFields();
});
</script>

<?php include "../includes/footer.php"; ?>
