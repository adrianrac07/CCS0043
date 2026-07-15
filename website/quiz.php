<?php
/**
 * quiz.php
 * ------------------------------------------------------------
 * A simple one-question-at-a-time quiz.
 * - Uses PHP $_SESSION to remember: current question number,
 *   running score, and the list of answers given so far.
 * - Uses the "Post/Redirect/Get" pattern: after the user submits
 *   an answer, we redirect back to this same page with a GET
 *   request. This stops the browser from re-submitting the same
 *   answer twice if the user hits refresh.
 * ------------------------------------------------------------
 */

session_start();
require 'data/questions.php'; // gives us $questions array
$total_questions = count($questions);

// ---- Handle "Restart Quiz" ----
if (isset($_GET['restart'])) {
    unset($_SESSION['quiz_index']);
    unset($_SESSION['quiz_score']);
    unset($_SESSION['quiz_answers']);
    header("Location: quiz.php");
    exit;
}

// ---- Start a fresh quiz session if one doesn't exist yet ----
if (!isset($_SESSION['quiz_index'])) {
    $_SESSION['quiz_index']   = 0;   // which question we're on (0-based)
    $_SESSION['quiz_score']   = 0;   // how many correct so far
    $_SESSION['quiz_answers'] = [];  // history of answers, used on the Result page

    // Shuffle the on-screen ORDER of each question's options, so the
    // correct answer isn't always sitting in the same spot (e.g. always "A").
    // We only shuffle the display order -- the underlying option text/index
    // used for grading never changes.
    $_SESSION['quiz_option_order'] = [];
    foreach ($questions as $q_index => $q) {
        $order = range(0, count($q['options']) - 1); // e.g. [0,1,2,3]
        shuffle($order);
        $_SESSION['quiz_option_order'][$q_index] = $order;
    }
}

$error_message = "";

// ---- Handle a submitted answer (POST request) ----
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Make sure the user actually picked an option
    if (!isset($_POST['selected_option'])) {

        $error_message = "Please select an answer before continuing.";

    } else {

        $current_index   = $_SESSION['quiz_index'];
        $selected_option = (int) $_POST['selected_option'];
        $current_q       = $questions[$current_index];
        $is_correct      = ($selected_option === $current_q['correct']);

        if ($is_correct) {
            $_SESSION['quiz_score']++;
        }

        // Save this answer so result.php can show a full review
        $_SESSION['quiz_answers'][] = [
            'module'      => $current_q['module'],
            'question'    => $current_q['question'],
            'options'     => $current_q['options'],
            'selected'    => $selected_option,
            'correct'     => $current_q['correct'],
            'is_correct'  => $is_correct,
            'explanation' => $current_q['explanation'],
        ];

        // Move to the next question
        $_SESSION['quiz_index']++;

        // If that was the last question, go to the results page
        if ($_SESSION['quiz_index'] >= $total_questions) {
            header("Location: result.php");
            exit;
        }

        // Otherwise, redirect back here (Post/Redirect/Get) for the next question
        header("Location: quiz.php");
        exit;
    }
}

$active_page = "quiz";
require 'includes/header.php';

$current_index = $_SESSION['quiz_index'];
$current_q     = $questions[$current_index];
$q_number      = $current_index + 1; // human-friendly, 1-based
$progress_pct  = round(($current_index / $total_questions) * 100);
?>

    <h2 class="page-title">Quiz</h2>

    <div class="quiz-progress">Question <?php echo $q_number; ?> of <?php echo $total_questions; ?></div>
    <div class="progress-bar">
        <div class="progress-bar-fill" style="width: <?php echo $progress_pct; ?>%;"></div>
    </div>

    <?php if ($error_message): ?>
        <p class="error-msg"><?php echo htmlspecialchars($error_message); ?></p>
    <?php endif; ?>

    <span class="quiz-module-label"><?php echo htmlspecialchars($current_q['module']); ?></span>

    <p class="quiz-question"><?php echo $q_number; ?>. <?php echo $current_q['question']; ?></p>

    <form method="POST" action="quiz.php">
        <?php
            // Show the options in this question's shuffled order, but keep
            // using the ORIGINAL index as the submitted value for grading.
            $display_order = $_SESSION['quiz_option_order'][$current_index];
        ?>
        <?php foreach ($display_order as $original_index): ?>
            <label class="option-label">
                <input type="radio" name="selected_option" value="<?php echo $original_index; ?>">
                <?php echo $current_q['options'][$original_index]; ?>
            </label>
        <?php endforeach; ?>

        <button type="submit">
            <?php echo ($q_number === $total_questions) ? "Submit & See Results" : "Next Question &rarr;"; ?>
        </button>
    </form>

    <p style="margin-top:20px;"><a href="quiz.php?restart=1">&#8635; Restart Quiz</a></p>

<?php require 'includes/footer.php'; ?>
