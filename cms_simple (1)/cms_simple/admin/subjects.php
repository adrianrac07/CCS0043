<?php
require_once __DIR__ . "/../config/db.php";
require_once __DIR__ . "/../includes/auth.php";

requireAdmin();

$message = "";

// ---- Add a new subject ----
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_subject'])) {
    $name = trim($_POST['name']);
    if ($name !== '') {
        $stmt = $conn->prepare("INSERT INTO subjects (name) VALUES (?)");
        $stmt->bind_param("s", $name);
        $stmt->execute();
        $stmt->close();
        $message = "Subject added.";
    }
}

// ---- Edit an existing subject's name ----
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_subject'])) {
    $id   = (int)$_POST['subject_id'];
    $name = trim($_POST['name']);
    if ($name !== '') {
        $stmt = $conn->prepare("UPDATE subjects SET name = ? WHERE id = ?");
        $stmt->bind_param("si", $name, $id);
        $stmt->execute();
        $stmt->close();
        $message = "Subject updated.";
    }
}

// ---- Delete a subject (its files are removed too, via ON DELETE CASCADE) ----
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_subject'])) {
    $id = (int)$_POST['subject_id'];
    $stmt = $conn->prepare("DELETE FROM subjects WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
    $message = "Subject deleted.";
}

$subjects = $conn->query("SELECT id, name FROM subjects ORDER BY name ASC");

$pageTitle = "Manage Subjects";
require_once __DIR__ . "/../includes/header.php";
?>

<h1 class="mb-4">Manage Subjects</h1>
<p><a href="dashboard.php">&larr; Back to dashboard</a></p>

<?php if ($message): ?>
    <div class="alert alert-info"><?php echo htmlspecialchars($message); ?></div>
<?php endif; ?>

<!-- Add new subject -->
<form method="POST" class="row g-2 mb-4">
    <div class="col-auto">
        <input type="text" name="name" class="form-control" placeholder="New subject name" required>
    </div>
    <div class="col-auto">
        <button type="submit" name="add_subject" class="btn btn-primary">Add Subject</button>
    </div>
</form>

<table class="table table-bordered bg-white align-middle">
    <thead class="table-light">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th style="width: 320px;">Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($subject = $subjects->fetch_assoc()): ?>
            <tr>
                <td><?php echo $subject['id']; ?></td>
                <td>
                    <!-- Editable name field, saved via its own small form -->
                    <form method="POST" class="d-flex gap-2">
                        <input type="hidden" name="subject_id" value="<?php echo $subject['id']; ?>">
                        <input type="text" name="name" class="form-control form-control-sm"
                               value="<?php echo htmlspecialchars($subject['name']); ?>">
                        <button type="submit" name="edit_subject" class="btn btn-sm btn-outline-primary">Save</button>
                    </form>
                </td>
                <td>
                    <form method="POST" onsubmit="return confirm('Delete this subject and all its files?');">
                        <input type="hidden" name="subject_id" value="<?php echo $subject['id']; ?>">
                        <button type="submit" name="delete_subject" class="btn btn-sm btn-outline-danger">Delete</button>
                    </form>
                </td>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>

<?php require_once __DIR__ . "/../includes/footer.php"; ?>
