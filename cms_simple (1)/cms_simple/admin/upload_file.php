<?php
require_once __DIR__ . "/../config/db.php";
require_once __DIR__ . "/../includes/auth.php";

requireAdmin();

$message = "";
$uploadDir = __DIR__ . "/../uploads/";

// Make sure the uploads folder exists
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0755, true);
}

// ---- Handle file upload ----
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['upload_file'])) {
    $subjectId = (int)$_POST['subject_id'];

    if (!$subjectId) {
        $message = "Please choose a subject.";
    } elseif (!isset($_FILES['file']) || $_FILES['file']['error'] !== UPLOAD_ERR_OK) {
        $message = "Please choose a valid file to upload.";
    } else {
        // Add a timestamp to the filename so two uploads with the same
        // name don't overwrite each other on disk.
        $originalName = basename($_FILES['file']['name']);
        $safeName = time() . "_" . preg_replace("/[^A-Za-z0-9._-]/", "_", $originalName);
        $destination = $uploadDir . $safeName;

        if (move_uploaded_file($_FILES['file']['tmp_name'], $destination)) {
            $stmt = $conn->prepare("INSERT INTO files (subject_id, filename) VALUES (?, ?)");
            $stmt->bind_param("is", $subjectId, $safeName);
            $stmt->execute();
            $stmt->close();
            $message = "File uploaded successfully.";
        } else {
            $message = "Failed to upload the file.";
        }
    }
}

// ---- Handle file delete ----
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_file'])) {
    $fileId = (int)$_POST['file_id'];

    $stmt = $conn->prepare("SELECT filename FROM files WHERE id = ?");
    $stmt->bind_param("i", $fileId);
    $stmt->execute();
    $file = $stmt->get_result()->fetch_assoc();
    $stmt->close();

    if ($file) {
        $path = $uploadDir . $file['filename'];
        if (file_exists($path)) {
            unlink($path); // remove the actual file from disk
        }
        $del = $conn->prepare("DELETE FROM files WHERE id = ?");
        $del->bind_param("i", $fileId);
        $del->execute();
        $del->close();
        $message = "File deleted.";
    }
}

$subjects = $conn->query("SELECT id, name FROM subjects ORDER BY name ASC");

$files = $conn->query("
    SELECT files.id, files.filename, subjects.name AS subject_name
    FROM files
    JOIN subjects ON files.subject_id = subjects.id
    ORDER BY files.id DESC
");

$pageTitle = "Manage Files";
require_once __DIR__ . "/../includes/header.php";
?>

<h1 class="mb-4">Manage Files</h1>
<p><a href="dashboard.php">&larr; Back to dashboard</a></p>

<?php if ($message): ?>
    <div class="alert alert-info"><?php echo htmlspecialchars($message); ?></div>
<?php endif; ?>

<?php if ($subjects->num_rows === 0): ?>
    <div class="alert alert-warning">You need to add a subject before you can upload files. <a href="subjects.php">Add one here</a>.</div>
<?php else: ?>
    <!-- Upload form -->
    <form method="POST" enctype="multipart/form-data" class="row g-2 mb-4 align-items-end">
        <div class="col-auto">
            <label class="form-label">Subject</label>
            <select name="subject_id" class="form-select" required>
                <?php $subjects->data_seek(0); ?>
                <?php while ($s = $subjects->fetch_assoc()): ?>
                    <option value="<?php echo $s['id']; ?>"><?php echo htmlspecialchars($s['name']); ?></option>
                <?php endwhile; ?>
            </select>
        </div>
        <div class="col-auto">
            <label class="form-label">File</label>
            <input type="file" name="file" class="form-control" required>
        </div>
        <div class="col-auto">
            <button type="submit" name="upload_file" class="btn btn-primary">Upload</button>
        </div>
    </form>
<?php endif; ?>

<table class="table table-bordered bg-white align-middle">
    <thead class="table-light">
        <tr>
            <th>ID</th>
            <th>File</th>
            <th>Subject</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($file = $files->fetch_assoc()): ?>
            <tr>
                <td><?php echo $file['id']; ?></td>
                <td><?php echo htmlspecialchars($file['filename']); ?></td>
                <td><?php echo htmlspecialchars($file['subject_name']); ?></td>
                <td>
                    <a href="../download.php?id=<?php echo $file['id']; ?>" class="btn btn-sm btn-outline-primary">Download</a>
                    <form method="POST" class="d-inline" onsubmit="return confirm('Delete this file?');">
                        <input type="hidden" name="file_id" value="<?php echo $file['id']; ?>">
                        <button type="submit" name="delete_file" class="btn btn-sm btn-outline-danger">Delete</button>
                    </form>
                </td>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>

<?php require_once __DIR__ . "/../includes/footer.php"; ?>
