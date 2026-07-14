<?php
session_start();
include "config/db.php";

$errors = array();
$name = "";
$email = "";
$message = "";

if (isset($_POST['send'])) {
    $name = htmlspecialchars(trim($_POST['name']));
    $email = htmlspecialchars(trim($_POST['email']));
    $message = htmlspecialchars(trim($_POST['message']));

    if ($name == "") {
        $errors[] = "Please enter your name.";
    }
    if ($email == "" || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Please enter a valid email address.";
    }
    if ($message == "") {
        $errors[] = "Please enter a message.";
    }

    if (count($errors) == 0) {
        // Prepared statement keeps this safe from SQL injection
        $stmt = $conn->prepare("INSERT INTO contact_messages (name, email, message) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $name, $email, $message);

        if ($stmt->execute()) {
            $_SESSION['success'] = "Your message has been sent. Thank you!";
            header("Location: contact.php");
            exit();
        } else {
            $errors[] = "Something went wrong. Please try again.";
        }
    }
}

$pageTitle = "Contact";
$base = "";
include "includes/header.php";
?>

<div class="container py-5">
  <div class="row justify-content-center">
    <div class="col-lg-7">
      <div class="card fade-in">
        <div class="card-body p-4 p-md-5">
          <h3 class="fw-semibold mb-1">Get in Touch</h3>
          <p class="text-muted mb-4">Send a message and we will get back to you.</p>

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
              <label class="form-label">Name</label>
              <input type="text" name="name" class="form-control" value="<?php echo $name; ?>" required>
            </div>
            <div class="mb-3">
              <label class="form-label">Email</label>
              <input type="email" name="email" class="form-control" value="<?php echo $email; ?>" required>
            </div>
            <div class="mb-4">
              <label class="form-label">Message</label>
              <textarea name="message" class="form-control" rows="6" required><?php echo $message; ?></textarea>
            </div>
            <button type="submit" name="send" class="btn btn-accent w-100">Send Message</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<?php include "includes/footer.php"; ?>
