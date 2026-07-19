<?php
session_start();
include "../config/db.php";
$base = "../";

if (!isset($_SESSION['user_id'])) {
    $_SESSION['error'] = "Please log in first.";
    header("Location: ../auth/login.php");
    exit();
}

if ($_SESSION['role'] !== 'admin') {
    echo "<script>alert('Access denied: only admins can view the dashboard.'); window.location.href = '../index.php';</script>";
    exit();
}

if (isset($_POST['change_role'])) {
    $user_id = (int)$_POST['user_id'];
    $role = $_POST['role'];
    $stmt = $conn->prepare("UPDATE users SET role = ? WHERE id = ?");
    $stmt->bind_param("si", $role, $user_id);
    $stmt->execute();
    $_SESSION['success'] = "User role updated.";
    header("Location: dashboard.php");
    exit();
}

if (isset($_POST['toggle_status'])) {
    $user_id = (int)$_POST['user_id'];
    $status = $_POST['status'];
    $stmt = $conn->prepare("UPDATE users SET status = ? WHERE id = ?");
    $stmt->bind_param("si", $status, $user_id);
    $stmt->execute();
    $_SESSION['success'] = "User status updated.";
    header("Location: dashboard.php");
    exit();
}

if (isset($_POST['delete_user'])) {
    $user_id = (int)$_POST['user_id'];
    if ($user_id !== (int)$_SESSION['user_id']) {
        $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $_SESSION['success'] = "User deleted.";
    } else {
        $_SESSION['error'] = "You cannot delete your own account while logged in.";
    }
    header("Location: dashboard.php");
    exit();
}

$usersResult = $conn->query("SELECT * FROM users ORDER BY id DESC");

$totalUsers = $conn->query("SELECT COUNT(*) AS total FROM users")->fetch_assoc()['total'];
$totalMessages = $conn->query("SELECT COUNT(*) AS total FROM contact_messages")->fetch_assoc()['total'];
$totalPortfolio = $conn->query("SELECT COUNT(*) AS total FROM portfolio")->fetch_assoc()['total'];

$pageTitle = "Dashboard";
$base = "../";
include "../includes/header.php";
?>

<div class="container py-5">
  <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
    <div>
      <h2 class="fw-semibold mb-1">Admin Dashboard</h2>
      <p class="text-muted mb-0">Manage users, portfolio, and site content.</p>
    </div>
    <div class="d-flex gap-2 flex-wrap">
      <a href="portfolio.php" class="btn btn-sm btn-outline-primary">Portfolio</a>
      <a href="messages.php" class="btn btn-sm btn-outline-primary">Messages</a>
      <a href="cms_pages.php" class="btn btn-sm btn-outline-primary">Page Content</a>
      <a href="documentation.php" class="btn btn-sm btn-outline-primary">Documentation</a>
    </div>
  </div>

  <div class="row g-4 mb-2">
    <div class="col-6 col-lg-4">
      <div class="card stat-card text-center">
        <div class="card-body">
          <i class="bi bi-people fs-3 text-primary"></i>
          <h3 class="fw-semibold mb-0 mt-2"><?php echo (int)$totalUsers; ?></h3>
          <p class="text-muted small mb-0">Total Users</p>
        </div>
      </div>
    </div>
    <div class="col-6 col-lg-4">
      <div class="card stat-card text-center">
        <div class="card-body">
          <i class="bi bi-briefcase fs-3 text-primary"></i>
          <h3 class="fw-semibold mb-0 mt-2"><?php echo (int)$totalPortfolio; ?></h3>
          <p class="text-muted small mb-0">Portfolio Items</p>
        </div>
      </div>
    </div>
    <div class="col-6 col-lg-4">
      <div class="card stat-card text-center">
        <div class="card-body">
          <i class="bi bi-envelope fs-3 text-primary"></i>
          <h3 class="fw-semibold mb-0 mt-2"><?php echo (int)$totalMessages; ?></h3>
          <p class="text-muted small mb-0">Contact Messages</p>
        </div>
      </div>
    </div>
  </div>

  <div class="card mt-2">
    <div class="card-body">
      <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="h5 mb-0">Users</h4>
        <a href="add_user.php" class="btn btn-sm btn-accent">Add User</a>
      </div>
      <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
          <thead>
            <tr>
              <th>Picture</th>
              <th>Username</th>
              <th>Email</th>
              <th>Role</th>
              <th>Status</th>
              <th>Created</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php while ($user = $usersResult->fetch_assoc()): ?>
              <tr>
                <td>
                  <img src="../<?php echo !empty($user['profile_image']) ? htmlspecialchars($user['profile_image']) : 'assets/default-avatar.svg'; ?>"
                       class="rounded-circle" style="width:36px; height:36px; object-fit:cover;">
                </td>
                <td><?php echo htmlspecialchars($user['username']); ?></td>
                <td><?php echo htmlspecialchars($user['email'] ?? '') !== '' ? htmlspecialchars($user['email']) : '—'; ?></td>
                <td>
                  <span class="badge <?php echo $user['role'] === 'admin' ? 'bg-primary' : 'bg-secondary'; ?>">
                    <?php echo htmlspecialchars($user['role']); ?>
                  </span>
                </td>
                <td>
                  <span class="badge <?php echo $user['status'] === 'active' ? 'bg-success' : 'bg-danger'; ?>">
                    <?php echo htmlspecialchars($user['status']); ?>
                  </span>
                </td>
                <td class="text-nowrap small text-muted"><?php echo date("M j, Y", strtotime($user['created_at'])); ?></td>
                <td class="text-nowrap">
                  <a href="edit_user.php?id=<?php echo (int)$user['id']; ?>" class="btn btn-sm btn-outline-secondary me-1">Edit</a>
                  <form method="POST" class="d-inline" onsubmit="return confirm('Delete this user?');">
                    <input type="hidden" name="user_id" value="<?php echo (int)$user['id']; ?>">
                    <button type="submit" name="delete_user" class="btn btn-sm btn-outline-danger">Delete</button>
                  </form>
                </td>
              </tr>
            <?php endwhile; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<?php include "../includes/footer.php"; ?>
