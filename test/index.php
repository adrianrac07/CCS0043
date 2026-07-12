<?php 
session_start();
include("config.php"); 
?>

<div class="container mt-5">

  <?php if(!isset($_SESSION['user'])): ?>
    
    <div class="row justify-content-center">
      <div class="col-md-5">
        <div class="card shadow-lg p-4">
          <h4 class="text-center mb-3">Login</h4>

          <?php if(isset($_GET['error'])): ?>
            <div class="alert alert-danger">
              Invalid username or password
            </div>
          <?php endif; ?>

          <form method="POST" action="login_process.php">
            <input type="text" name="username" class="form-control mb-2" placeholder="Username" required>
            <input type="password" name="password" class="form-control mb-3" placeholder="Password" required>
            <button class="btn btn-primary w-100">Login</button>
          </form>

          <div class="text-center mt-3">
            <a href="register.php">Create an account</a>
          </div>
        </div>
      </div>
    </div>

  <?php else: ?>

    <div class="text-center">
      <h2>Welcome, <?= htmlspecialchars($_SESSION['user']) ?> 👋</h2>
      <a href="admin/dashboard.php" class="btn btn-success mt-3">Go to Dashboard</a>
    </div>

  <?php endif; ?>

</div>

<?php include("includes/footer.php"); ?>