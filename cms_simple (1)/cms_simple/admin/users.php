<?php
require_once __DIR__ . "/../config/db.php";
require_once __DIR__ . "/../includes/auth.php";

requireAdmin();

$message = "";

// ---- Handle actions submitted from this page (role change, block, delete) ----
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    $userId = (int)($_POST['user_id'] ?? 0);

    // Prevent an admin from accidentally locking themselves out
    if ($userId === (int)$_SESSION['user_id']) {
        $message = "You can't change your own account here.";
    } elseif ($action === 'change_role') {
        $newRole = $_POST['role'] === 'admin' ? 'admin' : 'user';
        $stmt = $conn->prepare("UPDATE users SET role = ? WHERE id = ?");
        $stmt->bind_param("si", $newRole, $userId);
        $stmt->execute();
        $stmt->close();
        $message = "User role updated.";

    } elseif ($action === 'toggle_status') {
        $newStatus = $_POST['status'] === 'active' ? 'blocked' : 'active';
        $stmt = $conn->prepare("UPDATE users SET status = ? WHERE id = ?");
        $stmt->bind_param("si", $newStatus, $userId);
        $stmt->execute();
        $stmt->close();
        $message = "User status updated.";

    } elseif ($action === 'delete') {
        $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $stmt->close();
        $message = "User deleted.";
    }
}

$users = $conn->query("SELECT id, username, role, status FROM users ORDER BY id ASC");

$pageTitle = "Manage Users";
require_once __DIR__ . "/../includes/header.php";
?>

<h1 class="mb-4">Manage Users</h1>
<p><a href="dashboard.php">&larr; Back to dashboard</a></p>

<?php if ($message): ?>
    <div class="alert alert-info"><?php echo htmlspecialchars($message); ?></div>
<?php endif; ?>

<table class="table table-bordered bg-white align-middle">
    <thead class="table-light">
        <tr>
            <th>ID</th>
            <th>Username</th>
            <th>Role</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($user = $users->fetch_assoc()): ?>
            <tr>
                <td><?php echo $user['id']; ?></td>
                <td><?php echo htmlspecialchars($user['username']); ?></td>
                <td>
                    <span class="badge bg-<?php echo $user['role'] === 'admin' ? 'primary' : 'secondary'; ?>">
                        <?php echo htmlspecialchars($user['role']); ?>
                    </span>
                </td>
                <td>
                    <span class="badge bg-<?php echo $user['status'] === 'active' ? 'success' : 'danger'; ?>">
                        <?php echo htmlspecialchars($user['status']); ?>
                    </span>
                </td>
                <td>
                    <?php if ($user['id'] === (int)$_SESSION['user_id']): ?>
                        <span class="text-muted small">This is you</span>
                    <?php else: ?>
                        <!-- Change role -->
                        <form method="POST" class="d-inline">
                            <input type="hidden" name="action" value="change_role">
                            <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">
                            <input type="hidden" name="role" value="<?php echo $user['role'] === 'admin' ? 'user' : 'admin'; ?>">
                            <button type="submit" class="btn btn-sm btn-outline-primary">
                                Make <?php echo $user['role'] === 'admin' ? 'User' : 'Admin'; ?>
                            </button>
                        </form>

                        <!-- Block / Unblock -->
                        <form method="POST" class="d-inline">
                            <input type="hidden" name="action" value="toggle_status">
                            <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">
                            <input type="hidden" name="status" value="<?php echo $user['status']; ?>">
                            <button type="submit" class="btn btn-sm btn-outline-warning">
                                <?php echo $user['status'] === 'active' ? 'Block' : 'Unblock'; ?>
                            </button>
                        </form>

                        <!-- Delete -->
                        <form method="POST" class="d-inline" onsubmit="return confirm('Delete this user?');">
                            <input type="hidden" name="action" value="delete">
                            <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">
                            <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                        </form>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>

<?php require_once __DIR__ . "/../includes/footer.php"; ?>
