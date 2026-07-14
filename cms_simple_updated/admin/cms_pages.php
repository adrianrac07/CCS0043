<?php
session_start();
include "../config/db.php";

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    $_SESSION['error'] = "Only admins can edit page content.";
    header("Location: ../index.php");
    exit();
}

// Save updated content for a page (home or about)
if (isset($_POST['save_page'])) {
    $page_name = $_POST['page_name'];
    $content = trim($_POST['content']);

    // Only allow known page names, keeps this simple and safe
    if (in_array($page_name, ['home', 'about'])) {
        $stmt = $conn->prepare("UPDATE cms_pages SET content = ? WHERE page_name = ?");
        $stmt->bind_param("ss", $content, $page_name);
        $stmt->execute();
        $_SESSION['success'] = ucfirst($page_name) . " content updated.";
    }
    header("Location: cms_pages.php");
    exit();
}

$homePage = $conn->query("SELECT * FROM cms_pages WHERE page_name = 'home'")->fetch_assoc();
$aboutPage = $conn->query("SELECT * FROM cms_pages WHERE page_name = 'about'")->fetch_assoc();

$pageTitle = "Edit Page Content";
$base = "../";
include "../includes/header.php";
?>

<div class="container py-5">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-semibold mb-0">Edit Page Content</h2>
    <a href="dashboard.php" class="btn btn-outline-secondary btn-sm">Back to Dashboard</a>
  </div>

  <div class="row g-4">
    <div class="col-lg-6">
      <div class="card">
        <div class="card-body">
          <h5 class="mb-3">Home Page Content</h5>
          <form method="POST">
            <input type="hidden" name="page_name" value="home">
            <textarea name="content" class="form-control" rows="6"><?php echo htmlspecialchars($homePage['content'] ?? ''); ?></textarea>
            <button type="submit" name="save_page" class="btn btn-accent mt-3">Save Home Content</button>
          </form>
        </div>
      </div>
    </div>

    <div class="col-lg-6">
      <div class="card">
        <div class="card-body">
          <h5 class="mb-3">About Page Content</h5>
          <form method="POST">
            <input type="hidden" name="page_name" value="about">
            <textarea name="content" class="form-control" rows="6"><?php echo htmlspecialchars($aboutPage['content'] ?? ''); ?></textarea>
            <button type="submit" name="save_page" class="btn btn-accent mt-3">Save About Content</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<?php include "../includes/footer.php"; ?>
