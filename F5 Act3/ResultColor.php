<?php
include("header.php");

if (isset($_GET['color1'])) {
    $color1 = $_GET['color1'];
    $color2 = $_GET['color2'];
    $color3 = $_GET['color3'];
    $color4 = $_GET['color4'];
    $color5 = $_GET['color5'];
}
?>

<h2>My Favorite Colors</h2>
<div class="result">
  <table>
    <tr><td><?php if(isset($color1)) echo "My Favorite Color 1: " . $color1; ?></td></tr>
    <tr><td><?php if(isset($color2)) echo "My Favorite Color 2: " . $color2; ?></td></tr>
    <tr><td><?php if(isset($color3)) echo "My Favorite Color 3: " . $color3; ?></td></tr>
    <tr><td><?php if(isset($color4)) echo "My Favorite Color 4: " . $color4; ?></td></tr>
    <tr><td><?php if(isset($color5)) echo "My Favorite Color 5: " . $color5; ?></td></tr>
  </table>
</div>

<div style="margin-top:20px;">
  <form action="FavoriteColor.php" method="get">
    <input type="submit" value="Try Again">
  </form>
</div>

</body>
</html>
