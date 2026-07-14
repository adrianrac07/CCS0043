</main>

<footer class="app-footer mt-5 py-4">
  <div class="container d-flex flex-column flex-md-row justify-content-between align-items-center gap-2 text-center text-md-start">
    <span class="text-muted small">&copy; <?php echo date("Y"); ?> Adrian Rovic. Corrales . All rights reserved.</span>
    <span class="text-muted small">Built with PHP, MySQL &amp; Bootstrap</span>  
  </div>

  <a href="https://www.facebook.com/Noobkiller10107" class="ms-2" style="padding-left: 65px;">
  <img src="<?php echo $base; ?>assets/facebook.png" style="width: 28px;">
</a>
<a href="https://www.instagram.com/reimonevaldes" class="ms-2">
  <img src="<?php echo $base; ?>assets/instagram.png" style="width: 35px;">
</a>
<a href="www.linkedin.com/in/adrian-rovic-corrales-aa9b7a380" class="ms-2">
  <img src="<?php echo $base; ?>assets/linked.png" style="width: 29px;">
</a>
<a href="https://github.com/adrianrac07" class="ms-2">
  <img src="<?php echo $base; ?>assets/github.png" style="width: 33px;">
</a>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
// Dark Mode toggle - remembers the choice in localStorage so it applies on every page
(function () {
  var toggleBtn = document.getElementById('darkModeToggle');
  if (!toggleBtn) return;

  function applyTheme(isDark) {
    document.documentElement.classList.toggle('dark-mode', isDark);
  }

  applyTheme(localStorage.getItem('theme') === 'dark');

  toggleBtn.addEventListener('click', function () {
    var isDark = !document.documentElement.classList.contains('dark-mode');
    applyTheme(isDark);
    localStorage.setItem('theme', isDark ? 'dark' : 'light');
  });
})();
</script>
</body>
</html>
