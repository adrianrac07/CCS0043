<?php
session_start();
include "config/db.php";

// Must be logged in to view this page
if (!isset($_SESSION['user_id'])) {
    $_SESSION['error'] = "Please log in first.";
    header("Location: auth/login.php");
    exit();
}

$user_id = (int)$_SESSION['user_id'];
$errors = array();

// Get current user info
$stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();

// --- Update info (username + email) ---
if (isset($_POST['update_info'])) {
    $username = htmlspecialchars(trim($_POST['username']));
    $email = htmlspecialchars(trim($_POST['email']));

    if ($username == "" || strlen($username) < 3) {
        $errors[] = "Username must be at least 3 characters.";
    }

    if (count($errors) == 0) {
        // Make sure the username isn't taken by someone else
        $check = $conn->prepare("SELECT id FROM users WHERE username = ? AND id != ?");
        $check->bind_param("si", $username, $user_id);
        $check->execute();
        if ($check->get_result()->num_rows > 0) {
            $errors[] = "That username is already taken.";
        }
    }

    if (count($errors) == 0) {
        $update = $conn->prepare("UPDATE users SET username = ?, email = ? WHERE id = ?");
        $update->bind_param("ssi", $username, $email, $user_id);
        $update->execute();
        $_SESSION['username'] = $username; // keep navbar in sync
        $_SESSION['success'] = "Profile info updated.";
        header("Location: profile.php");
        exit();
    }
}

// --- Change password ---
if (isset($_POST['change_password'])) {
    $current = $_POST['current_password'];
    $new = $_POST['new_password'];
    $confirm = $_POST['confirm_password'];

    if (!password_verify($current, $user['password'])) {
        $errors[] = "Current password is incorrect.";
    }
    if (strlen($new) < 6) {
        $errors[] = "New password must be at least 6 characters.";
    }
    if ($new != $confirm) {
        $errors[] = "New passwords do not match.";
    }

    if (count($errors) == 0) {
        $hashed = password_hash($new, PASSWORD_DEFAULT);
        $update = $conn->prepare("UPDATE users SET password = ? WHERE id = ?");
        $update->bind_param("si", $hashed, $user_id);
        $update->execute();
        $_SESSION['success'] = "Password changed successfully.";
        header("Location: profile.php");
        exit();
    }
}

// --- Upload / change profile picture ---
if (isset($_POST['upload_picture']) && isset($_FILES['profile_image'])) {
    $allowed = ['jpg', 'jpeg', 'png', 'gif'];
    $ext = strtolower(pathinfo($_FILES['profile_image']['name'], PATHINFO_EXTENSION));

    if ($_FILES['profile_image']['error'] !== UPLOAD_ERR_OK) {
        $errors[] = "Upload failed. Please try again.";
    } elseif (!in_array($ext, $allowed)) {
        $errors[] = "Only jpg, jpeg, png, or gif images are allowed.";
    } else {
        // Delete the old picture file if one exists
        if (!empty($user['profile_image']) && file_exists(__DIR__ . "/" . $user['profile_image'])) {
            unlink(__DIR__ . "/" . $user['profile_image']);
        }

        $newName = "user_" . $user_id . "_" . time() . "." . $ext;
        $targetPath = "uploads/profiles/" . $newName;

        if (move_uploaded_file($_FILES['profile_image']['tmp_name'], __DIR__ . "/" . $targetPath)) {
            $update = $conn->prepare("UPDATE users SET profile_image = ? WHERE id = ?");
            $update->bind_param("si", $targetPath, $user_id);
            $update->execute();
            $_SESSION['success'] = "Profile picture updated.";
            header("Location: profile.php");
            exit();
        } else {
            $errors[] = "Could not save the uploaded file.";
        }
    }
}

// --- Remove profile picture ---
if (isset($_POST['remove_picture'])) {
    if (!empty($user['profile_image']) && file_exists(__DIR__ . "/" . $user['profile_image'])) {
        unlink(__DIR__ . "/" . $user['profile_image']);
    }
    $update = $conn->prepare("UPDATE users SET profile_image = NULL WHERE id = ?");
    $update->bind_param("i", $user_id);
    $update->execute();
    $_SESSION['success'] = "Profile picture removed.";
    header("Location: profile.php");
    exit();
}

// Refresh user data after any change
$stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();

$pageTitle = "My Profile";
$base = "";
include "includes/header.php";
?>

<div class="container py-5">
  <?php if (count($errors) > 0): ?>
    <div class="alert alert-danger">
      <ul class="mb-0 ps-3">
        <?php foreach ($errors as $error) { ?>
          <li><?php echo $error; ?></li>
        <?php } ?>
      </ul>
    </div>
  <?php endif; ?>

  <div class="row g-4">
    <!-- Profile picture -->
    <div class="col-lg-4">
      <div class="card fade-in">
        <div class="card-body text-center p-4">
          <img src="<?php echo $user['profile_image'] ? htmlspecialchars($user['profile_image']) : 'assets/logo1.png'; ?>"
               class="rounded-circle mb-3" style="width:130px; height:130px; object-fit:cover;">
          <h5 class="mb-1"><?php echo htmlspecialchars($user['username']); ?></h5>
          <p class="text-muted small mb-3"><?php echo htmlspecialchars($user['role']); ?></p>

          <form method="POST" enctype="multipart/form-data" class="mb-2">
            <input type="file" name="profile_image" class="form-control form-control-sm mb-2" required>
            <button type="submit" name="upload_picture" class="btn btn-accent btn-sm w-100">Upload / Change Picture</button>
          </form>

          <?php if ($user['profile_image']): ?>
            <form method="POST" onsubmit="return confirm('Remove your profile picture?');">
              <button type="submit" name="remove_picture" class="btn btn-outline-danger btn-sm w-100">Remove Picture</button>
            </form>
          <?php endif; ?>
        </div>
      </div>
    </div>

    <!-- Edit info + change password -->
    <div class="col-lg-8">
      <div class="card mb-4 fade-in">
        <div class="card-body p-4">
          <h5 class="mb-3">Edit Info</h5>
          <form method="POST">
            <div class="mb-3">
              <label class="form-label">Username</label>
              <input type="text" name="username" class="form-control" value="<?php echo htmlspecialchars($user['username']); ?>" required>
            </div>
            <div class="mb-3">
              <label class="form-label">Email</label>
              <input type="email" name="email" class="form-control" value="<?php echo htmlspecialchars($user['email'] ?? ''); ?>" placeholder="you@example.com">
            </div>
            <button type="submit" name="update_info" class="btn btn-accent">Save Changes</button>
          </form>
        </div>
      </div>

      <div class="card fade-in">
        <div class="card-body p-4">
          <h5 class="mb-3">Change Password</h5>
          <form method="POST">
            <div class="mb-3">
              <label class="form-label">Current Password</label>
              <input type="password" name="current_password" class="form-control" required>
            </div>
            <div class="mb-3">
              <label class="form-label">New Password</label>
              <input type="password" name="new_password" class="form-control" required>
            </div>
            <div class="mb-3">
              <label class="form-label">Confirm New Password</label>
              <input type="password" name="confirm_password" class="form-control" required>
            </div>
            <button type="submit" name="change_password" class="btn btn-accent">Change Password</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<?php include "includes/footer.php"; ?>
