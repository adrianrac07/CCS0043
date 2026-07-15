<?php
/**
 * reviewer.php
 * Displays the full reviewer notes, one section per module.
 * All the actual text content lives in data/modules.php --
 * this page just loops through it and prints it out.
 */

$active_page = "reviewer";
require 'data/modules.php';      // gives us $modules array
require 'includes/header.php';   // top nav bar
?>

    <h2 class="page-title">Reviewer</h2>

    <!-- Table of contents: quick jump links -->
    <div class="reviewer-toc">
        <strong>Jump to a module:</strong><br>
        <?php
            $links = [];
            foreach ($modules as $id => $mod) {
                $links[] = '<a href="#module-' . $id . '">' . htmlspecialchars($mod['title']) . '</a>';
            }
            echo implode(' &nbsp;|&nbsp; ', $links);
        ?>
    </div>

    <?php foreach ($modules as $id => $mod): ?>
        <section class="module-section" id="module-<?php echo $id; ?>">
            <h2><?php echo htmlspecialchars($mod['title']); ?></h2>
            <?php echo $mod['html']; // pre-built HTML notes for this module ?>
        </section>
    <?php endforeach; ?>

<?php require 'includes/footer.php'; ?>
