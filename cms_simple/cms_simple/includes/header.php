<?php
// $pageTitle and $base should be set by the page before including this file.
if (!isset($pageTitle)) $pageTitle = "Personal CMS";
if (!isset($base)) $base = "";
if (session_status() === PHP_SESSION_NONE) session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle; ?> - Personal CMS</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo $base; ?>assets/style.css">
</head>
<body>
<?php include __DIR__ . "/navbar.php"; ?>
<main>
<?php if (isset($_SESSION['success'])): ?>
  <div class="container mt-4">
    <div class="alert alert-success"><?php echo $_SESSION['success']; unset($_SESSION['success']); ?></div>
  </div>
<?php endif; ?>
<?php if (isset($_SESSION['error'])): ?>
  <div class="container mt-4">
    <div class="alert alert-danger"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></div>
  </div>
<?php endif; ?>
