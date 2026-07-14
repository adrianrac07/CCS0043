<?php
session_start();
include "../config/db.php";

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    $_SESSION['error'] = "Only admins can view messages.";
    header("Location: ../index.php");
    exit();
}

// Delete a message
if (isset($_POST['delete_message'])) {
    $id = (int)$_POST['id'];
    $stmt = $conn->prepare("DELETE FROM contact_messages WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $_SESSION['success'] = "Message deleted.";
    header("Location: messages.php");
    exit();
}

$messagesResult = $conn->query("SELECT * FROM contact_messages ORDER BY created_at DESC");

$pageTitle = "Contact Messages";
$base = "../";
include "../includes/header.php";
?>

<div class="container py-5">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-semibold mb-0">Contact Messages</h2>
    <a href="dashboard.php" class="btn btn-outline-secondary btn-sm">Back to Dashboard</a>
  </div>

  <div class="card">
    <div class="card-body">
      <?php if ($messagesResult->num_rows == 0): ?>
        <p class="text-muted mb-0">No messages yet.</p>
      <?php else: ?>
        <div class="table-responsive">
          <table class="table table-hover align-middle mb-0">
            <thead>
              <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Message</th>
                <th>Date</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              <?php while ($msg = $messagesResult->fetch_assoc()): ?>
                <tr>
                  <td><?php echo htmlspecialchars($msg['name']); ?></td>
                  <td><?php echo htmlspecialchars($msg['email']); ?></td>
                  <td><?php echo nl2br(htmlspecialchars($msg['message'])); ?></td>
                  <td class="text-nowrap"><?php echo date("M j, Y", strtotime($msg['created_at'])); ?></td>
                  <td>
                    <form method="POST" onsubmit="return confirm('Delete this message?');">
                      <input type="hidden" name="id" value="<?php echo (int)$msg['id']; ?>">
                      <button type="submit" name="delete_message" class="btn btn-sm btn-outline-danger">Delete</button>
                    </form>
                  </td>
                </tr>
              <?php endwhile; ?>
            </tbody>
          </table>
        </div>
      <?php endif; ?>
    </div>
  </div>
</div>

<?php include "../includes/footer.php"; ?>
