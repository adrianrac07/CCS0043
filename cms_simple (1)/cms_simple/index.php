<?php
require_once __DIR__ . "/config/db.php";
require_once __DIR__ . "/includes/auth.php";

// If a subject was clicked in the navbar dropdown, only show that one.
// Otherwise show all subjects.
$filterSubjectId = isset($_GET['subject']) ? (int)$_GET['subject'] : 0;

if ($filterSubjectId > 0) {
    $stmt = $conn->prepare("SELECT id, name FROM subjects WHERE id = ?");
    $stmt->bind_param("i", $filterSubjectId);
    $stmt->execute();
    $subjects = $stmt->get_result();
} else {
    $subjects = $conn->query("SELECT id, name FROM subjects ORDER BY name ASC");
}

$pageTitle = "Home";
require_once __DIR__ . "/includes/header.php";
?>

<h1 class="mb-4">Subjects</h1>

<?php if ($subjects->num_rows === 0): ?>
    <p class="text-muted">No subjects have been added yet.</p>
<?php else: ?>
    <div class="row g-4">
        <?php while ($subject = $subjects->fetch_assoc()): ?>
            <div class="col-md-6 col-lg-4">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo htmlspecialchars($subject['name']); ?></h5>

                        <?php
                        // Get all files that belong to this subject
                        $fileStmt = $conn->prepare("SELECT id, filename FROM files WHERE subject_id = ? ORDER BY id DESC");
                        $fileStmt->bind_param("i", $subject['id']);
                        $fileStmt->execute();
                        $files = $fileStmt->get_result();
                        ?>

                        <?php if ($files->num_rows === 0): ?>
                            <p class="text-muted small mb-0">No files yet.</p>
                        <?php else: ?>
                            <ul class="list-group list-group-flush">
                                <?php while ($file = $files->fetch_assoc()): ?>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <span class="text-truncate me-2"><?php echo htmlspecialchars($file['filename']); ?></span>
                                        <a href="download.php?id=<?php echo $file['id']; ?>" class="btn btn-sm btn-outline-primary">Download</a>
                                    </li>
                                <?php endwhile; ?>
                            </ul>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
<?php endif; ?>

<?php require_once __DIR__ . "/includes/footer.php"; ?>
