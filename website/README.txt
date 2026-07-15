GED0081 College Physics 1 Reviewer Website
===========================================

HOW TO RUN THIS ON XAMPP
-------------------------
1. Install XAMPP (https://www.apachefriends.org/) if you don't have it yet.
2. Copy this whole "website" folder into your XAMPP "htdocs" folder.
   Example (Windows):  C:\xampp\htdocs\physics-reviewer\
   Example (Mac):      /Applications/XAMPP/htdocs/physics-reviewer/
3. Start XAMPP and turn ON the "Apache" module (green light).
4. Open your browser and go to:
   http://localhost/physics-reviewer/
   (use whatever folder name you copied it as)
5. That's it! No database is needed -- everything is stored in plain PHP
   files and in the visitor's session while they take the quiz.

FILE STRUCTURE
--------------
index.php            -> Home page (lists topics, links to quiz)
reviewer.php          -> Full reviewer notes, organized by module
quiz.php              -> The interactive quiz (one question at a time)
result.php            -> Score + full answer review, shown after the quiz
data/modules.php      -> All reviewer text content (edit this to change notes)
data/questions.php    -> All quiz questions/answers/explanations (edit this to change the quiz)
includes/header.php   -> Shared top navigation bar
includes/footer.php   -> Shared footer
assets/style.css      -> All styling (colors, layout, fonts)

HOW THE QUIZ WORKS
------------------
- The quiz uses PHP $_SESSION to remember your current question, your
  score, and your answer history as you go -- no database required.
- Each question's answer choices are shuffled per attempt, so the
  correct answer isn't always in the same spot.
- After the last question, you're taken to result.php, which shows your
  score and a full review (your answer vs. the correct answer, plus a
  worked explanation for every question).
- Click "Restart Quiz" any time to clear your session and start over.

CUSTOMIZING
-----------
- To edit the reviewer notes: open data/modules.php and edit the "html"
  text for any module.
- To add/edit quiz questions: open data/questions.php and add a new
  array block following the same pattern (module, question, options,
  correct index, explanation).
