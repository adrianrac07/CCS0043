<?php
require_once __DIR__ . "/../config/db.php";
require_once __DIR__ . "/../includes/auth.php";

// Only admins may see this page
requireAdmin();

// A few quick stats for the dashboard
$userCount    = $conn->query("SELECT COUNT(*) AS c FROM users")->fetch_assoc()['c'];
$subjectCount = $conn->query("SELECT COUNT(*) AS c FROM subjects")->fetch_assoc()['c'];
$fileCount    = $conn->query("SELECT COUNT(*) AS c FROM files")->fetch_assoc()['c'];

$pageTitle = "Admin Dashboard";
require_once __DIR__ . "/../includes/header.php";
?>

<h1 class="mb-4">Admin Dashboard</h1>

<div class="row g-4 mb-4">
    <div class="col-md-4">
        <div class="card text-center shadow-sm">
            <div class="card-body">
                <h2><?php echo $userCount; ?></h2>
                <p class="text-muted mb-0">Users</p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card text-center shadow-sm">
            <div class="card-body">
                <h2><?php echo $subjectCount; ?></h2>
                <p class="text-muted mb-0">Subjects</p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card text-center shadow-sm">
            <div class="card-body">
                <h2><?php echo $fileCount; ?></h2>
                <p class="text-muted mb-0">Files</p>
            </div>
        </div>
    </div>
</div>

<div class="list-group">
    <a href="users.php" class="list-group-item list-group-item-action">
        Manage Users &rarr; view all users, change roles, block or delete accounts
    </a>
    <a href="subjects.php" class="list-group-item list-group-item-action">
        Manage Subjects &rarr; add, edit, or delete subjects
    </a>
    <a href="upload_file.php" class="list-group-item list-group-item-action">
        Manage Files &rarr; upload files under a subject, or delete existing files
    </a>
</div>

<?php require_once __DIR__ . "/../includes/footer.php"; ?>
