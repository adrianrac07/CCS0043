<?php
session_start();
include "../config/db.php";

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    echo "<script>alert('Access denied: only admins can add users.'); window.location.href = '../index.php';</script>";
    exit();
}

$errors = array();
$username = "";
$email = "";

if (isset($_POST['add_user'])) {
    $username = htmlspecialchars(trim($_POST['username']));
    $email = htmlspecialchars(trim($_POST['email']));
    $password = $_POST['password'];
    $role = in_array($_POST['role'] ?? '', ['admin', 'user']) ? $_POST['role'] : 'user';
    $status = in_array($_POST['status'] ?? '', ['active', 'blocked']) ? $_POST['status'] : 'active';

    if ($username == "" || strlen($username) < 3) {
        $errors[] = "Username must be at least 3 characters.";
    }
    if (strlen($password) < 6) {
        $errors[] = "Password must be at least 6 characters.";
    }

    if (count($errors) == 0) {
        $check = $conn->prepare("SELECT id FROM users WHERE username = ?");
        $check->bind_param("s", $username);
        $check->execute();
        if ($check->get_result()->num_rows > 0) {
            $errors[] = "That username is already taken.";
        }
    }

    if (count($errors) == 0) {
        $hashed = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("INSERT INTO users (username, email, password, role, status) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $username, $email, $hashed, $role, $status);
        $stmt->execute();
        $_SESSION['success'] = "User added successfully.";
        header("Location: dashboard.php");
        exit();
    }
}

$pageTitle = "Add User";
$base = "../";
include "../includes/header.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo $pageTitle; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
  <link rel="stylesheet" href="../assets/styles.css">
</head>
<body>
<div class="container py-5">
  <div class="row justify-content-center">
    <div class="col-lg-6">
      <div class="card fade-in">
        <div class="card-body p-4 p-md-5">
          <div class="d-flex align-items-center gap-2 mb-4">
            <a href="dashboard.php" class="btn btn-sm btn-outline-secondary"><i class="bi bi-arrow-left"></i></a>
            <h3 class="fw-semibold mb-0">Add User</h3>
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
            <div class="mb-3">
              <label class="form-label">Username</label>
              <input type="text" name="username" class="form-control" value="<?php echo $username; ?>" required>
            </div>
            <div class="mb-3">
              <label class="form-label">Email</label>
              <input type="email" name="email" class="form-control" value="<?php echo $email; ?>">
            </div>
            <div class="mb-3">
              <label class="form-label">Password</label>
              <input type="password" name="password" class="form-control" required>
            </div>
            <div class="row g-3 mb-4">
              <div class="col-6">
                <label class="form-label">Role</label>
                <select name="role" class="form-select">
                  <option value="user">user</option>
                  <option value="admin">admin</option>
                </select>
              </div>
              <div class="col-6">
                <label class="form-label">Status</label>
                <select name="status" class="form-select">
                  <option value="active">active</option>
                  <option value="blocked">blocked</option>
                </select>
              </div>
            </div>
            <button type="submit" name="add_user" class="btn btn-accent w-100">Add User</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<?php include "../includes/footer.php"; ?>
          </body>
</html>