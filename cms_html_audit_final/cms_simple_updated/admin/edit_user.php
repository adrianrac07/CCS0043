<?php
session_start();
include "../config/db.php";

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    echo "<script>alert('Access denied: only admins can edit users.'); window.location.href = '../index.php';</script>";
    exit();
}

$id = isset($_GET['id']) ? (int)$_GET['id'] : (isset($_POST['id']) ? (int)$_POST['id'] : 0);

if ($id <= 0) {
    $_SESSION['error'] = "Invalid user.";
    header("Location: dashboard.php");
    exit();
}

$stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();

if (!$user) {
    $_SESSION['error'] = "User not found.";
    header("Location: dashboard.php");
    exit();
}

$errors = array();

if (isset($_POST['update_user'])) {
    $username = htmlspecialchars(trim($_POST['username']));
    $email = htmlspecialchars(trim($_POST['email']));
    $role = in_array($_POST['role'] ?? '', ['admin', 'user']) ? $_POST['role'] : 'user';
    $status = in_array($_POST['status'] ?? '', ['active', 'blocked']) ? $_POST['status'] : 'active';

    if ($username == "" || strlen($username) < 3) {
        $errors[] = "Username must be at least 3 characters.";
    }

    if (count($errors) == 0) {
        $check = $conn->prepare("SELECT id FROM users WHERE username = ? AND id != ?");
        $check->bind_param("si", $username, $id);
        $check->execute();
        if ($check->get_result()->num_rows > 0) {
            $errors[] = "That username is already taken.";
        }
    }

    if (count($errors) == 0) {
        $update = $conn->prepare("UPDATE users SET username = ?, email = ?, role = ?, status = ? WHERE id = ?");
        $update->bind_param("ssssi", $username, $email, $role, $status, $id);
        $update->execute();
        $_SESSION['success'] = "User updated successfully.";
        header("Location: dashboard.php");
        exit();
    }
    $user['username'] = $username;
    $user['email'] = $email;
    $user['role'] = $role;
    $user['status'] = $status;
}

$pageTitle = "Edit User";
$base = "../";
include "../includes/header.php";
?>

<div class="container py-5">
  <div class="row justify-content-center">
    <div class="col-lg-6">
      <div class="card fade-in">
        <div class="card-body p-4 p-md-5">
          <div class="d-flex align-items-center gap-2 mb-4">
            <a href="dashboard.php" class="btn btn-sm btn-outline-secondary"><i class="bi bi-arrow-left"></i></a>
            <h3 class="fw-semibold mb-0">Edit User</h3>
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
            <input type="hidden" name="id" value="<?php echo (int)$user['id']; ?>">
            <div class="mb-3">
              <label class="form-label">Username</label>
              <input type="text" name="username" class="form-control" value="<?php echo htmlspecialchars($user['username']); ?>" required>
            </div>
            <div class="mb-3">
              <label class="form-label">Email</label>
              <input type="email" name="email" class="form-control" value="<?php echo htmlspecialchars($user['email'] ?? ''); ?>">
            </div>
            <div class="row g-3 mb-4">
              <div class="col-6">
                <label class="form-label">Role</label>
                <select name="role" class="form-select">
                  <option value="user" <?php echo $user['role'] === 'user' ? 'selected' : ''; ?>>user</option>
                  <option value="admin" <?php echo $user['role'] === 'admin' ? 'selected' : ''; ?>>admin</option>
                </select>
              </div>
              <div class="col-6">
                <label class="form-label">Status</label>
                <select name="status" class="form-select">
                  <option value="active" <?php echo $user['status'] === 'active' ? 'selected' : ''; ?>>active</option>
                  <option value="blocked" <?php echo $user['status'] === 'blocked' ? 'selected' : ''; ?>>blocked</option>
                </select>
              </div>
            </div>
            <button type="submit" name="update_user" class="btn btn-accent w-100">Save Changes</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<?php include "../includes/footer.php"; ?>
