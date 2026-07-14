<?php
session_start();
include "../config/db.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit();
}

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    $_SESSION['error'] = "Only admins can edit posts.";
    header("Location: dashboard.php");
    exit();
}

$id = isset($_GET['id']) ? (int)$_GET['id'] : (isset($_POST['id']) ? (int)$_POST['id'] : 0);

if ($id <= 0) {
    $_SESSION['error'] = "Invalid post.";
    header("Location: dashboard.php");
    exit();
}

$stmt = $conn->prepare("SELECT * FROM posts WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$post = $stmt->get_result()->fetch_assoc();

if (!$post) {
    $_SESSION['error'] = "Post not found.";
    header("Location: dashboard.php");
    exit();
}

$errors = array();
$title = $post['title'];
$content = $post['content'];

if (isset($_POST['update'])) {
    $title = htmlspecialchars(trim($_POST['title']));
    $content = trim($_POST['content']);

    if ($title == "" || strlen($title) > 150) {
        $errors[] = "Title is required and must be under 150 characters.";
    }
    if ($content == "") {
        $errors[] = "Content cannot be empty.";
    }

    if (count($errors) == 0) {
        $update = $conn->prepare("UPDATE posts SET title = ?, content = ? WHERE id = ?");
        $update->bind_param("ssi", $title, $content, $id);

        if ($update->execute()) {
            $_SESSION['success'] = "Post updated successfully.";
            header("Location: dashboard.php");
            exit();
        } else {
            $errors[] = "Something went wrong. Please try again.";
        }
    }
}

$pageTitle = "Edit Post";
$base = "../";
include "../includes/header.php";
?>

<div class="container py-5">
  <div class="row justify-content-center">
    <div class="col-lg-8">
      <div class="card fade-in">
        <div class="card-body p-4 p-md-5">
          <div class="d-flex align-items-center gap-2 mb-4">
            <a href="dashboard.php" class="btn btn-sm btn-outline-secondary"><i class="bi bi-arrow-left"></i></a>
            <h3 class="fw-semibold mb-0">Edit Post</h3>
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

          <form method="POST">
            <input type="hidden" name="id" value="<?php echo (int)$post['id']; ?>">

            <div class="mb-3">
              <label class="form-label">Title</label>
              <input type="text" name="title" class="form-control" value="<?php echo htmlspecialchars($title); ?>" maxlength="150" required>
            </div>

            <div class="mb-4">
              <label class="form-label">Content</label>
              <textarea name="content" class="form-control" rows="8" required><?php echo htmlspecialchars($content); ?></textarea>
            </div>

            <div class="d-flex gap-2">
              <button type="submit" name="update" class="btn btn-accent"><i class="bi bi-save me-1"></i> Save Changes</button>
              <a href="dashboard.php" class="btn btn-outline-secondary">Cancel</a>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<?php include "../includes/footer.php"; ?>
