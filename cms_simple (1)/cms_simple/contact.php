<?php
require_once __DIR__ . "/config/db.php";
require_once __DIR__ . "/includes/auth.php";

// This form does not send an email or save to the database.
// It just shows a "thank you" message after submitting - you can
// extend this later (e.g. save messages to a table, or send an email).
$submitted = ($_SERVER['REQUEST_METHOD'] === 'POST');

$pageTitle = "Contact";
require_once __DIR__ . "/includes/header.php";
?>

<div class="row justify-content-center">
  <div class="col-md-6">
    <h1 class="mb-4">Contact Us</h1>

    <?php if ($submitted): ?>
        <div class="alert alert-success">Thanks for reaching out! We'll get back to you soon.</div>
    <?php endif; ?>

    <form method="POST" action="contact.php">
        <div class="mb-3">
            <label class="form-label">Name</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Message</label>
            <textarea name="message" class="form-control" rows="4" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Send Message</button>
    </form>
  </div>
</div>

<?php require_once __DIR__ . "/includes/footer.php"; ?>
