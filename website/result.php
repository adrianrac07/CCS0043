<?php
/**
 * result.php
 * Shows the final score and a full review of every question:
 * what the user picked, what the correct answer was, and the
 * worked-out explanation.
 */

session_start();

// If someone lands here without having taken the quiz, send them to start it.
if (!isset($_SESSION['quiz_answers']) || count($_SESSION['quiz_answers']) === 0) {
    header("Location: quiz.php");
    exit;
}

$answers = $_SESSION['quiz_answers'];
$score   = $_SESSION['quiz_score'];
$total   = count($answers);
$percent = round(($score / $total) * 100);

// A little encouragement message based on the score
if ($percent >= 90) {
    $message = "Outstanding! You really know your physics.";
} elseif ($percent >= 70) {
    $message = "Great job! Just a few concepts to review.";
} elseif ($percent >= 50) {
    $message = "Good effort — go over the missed topics in the Reviewer.";
} else {
    $message = "Keep practicing! Revisit the Reviewer page and try again.";
}

$active_page = "quiz";
require 'includes/header.php';
?>

    <h2 class="page-title">Your Results</h2>

    <div class="score-banner">
        <span class="score-number"><?php echo $score; ?> / <?php echo $total; ?></span>
        <span><?php echo $percent; ?>% &mdash; <?php echo $message; ?></span>
    </div>

    <h3>Answer Review</h3>

    <?php foreach ($answers as $i => $a): ?>
        <div class="review-item <?php echo $a['is_correct'] ? 'correct' : 'incorrect'; ?>">
            <span class="quiz-module-label"><?php echo htmlspecialchars($a['module']); ?></span>
            <p><strong>Q<?php echo $i + 1; ?>.</strong> <?php echo $a['question']; ?></p>

            <p>
                Your answer:
                <strong><?php echo $a['options'][$a['selected']]; ?></strong>
                &mdash;
                <?php if ($a['is_correct']): ?>
                    <span class="tag-correct">&#10003; Correct</span>
                <?php else: ?>
                    <span class="tag-incorrect">&#10007; Incorrect</span>
                <?php endif; ?>
            </p>

            <?php if (!$a['is_correct']): ?>
                <p>Correct answer: <strong><?php echo $a['options'][$a['correct']]; ?></strong></p>
            <?php endif; ?>

            <div class="explanation-box">
                <strong>Explanation:</strong> <?php echo $a['explanation']; ?>
            </div>
        </div>
    <?php endforeach; ?>

    <div class="cta-box">
        <p>Want to try again or review the notes?</p>
        <a href="quiz.php?restart=1" class="btn">Retake Quiz</a>
        &nbsp;
        <a href="reviewer.php" class="btn">Back to Reviewer</a>
    </div>

<?php require 'includes/footer.php'; ?>
