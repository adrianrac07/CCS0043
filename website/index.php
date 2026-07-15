<?php
/**
 * index.php  (HOME PAGE)
 * Lists all the topics/modules covered in the reviewer,
 * with quick links to jump straight to that module, plus
 * a call-to-action button to start the quiz.
 */

$active_page = "home";
require 'data/modules.php';      // gives us $modules array
require 'includes/header.php';   // top nav bar
?>

    <h2 class="page-title">Welcome!</h2>
    <p>
        This site organizes your <strong>GED0081 College Physics 1</strong> lecture materials
        (Vectors, Motion, Newton's Laws, Work-Energy-Power, Impulse &amp; Momentum, and
        Equilibrium &amp; Torque) into an easy-to-read reviewer, plus a short interactive quiz
        so you can test yourself.
    </p>

    <h3>Topics covered</h3>
    <div class="topic-grid">
        <?php foreach ($modules as $id => $mod): ?>
            <a class="topic-card" href="reviewer.php#module-<?php echo $id; ?>">
                <?php echo htmlspecialchars($mod['title']); ?>
            </a>
        <?php endforeach; ?>
    </div>

    <div class="cta-box">
        <p>Think you know your physics?</p>
        <a href="quiz.php" class="btn">Start the Quiz &rarr;</a>
    </div>

<?php require 'includes/footer.php'; ?>
