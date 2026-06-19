<?php
session_start();
include("header.php");

if (isset($_GET['color1'])) {
    $color1 = $_GET['color1'];
    $color2 = $_GET['color2'];
    $color3 = $_GET['color3'];
    $color4 = $_GET['color4'];
    $color5 = $_GET['color5'];

    $_SESSION['color1'] = $color1;
    $_SESSION['color2'] = $color2;
    $_SESSION['color3'] = $color3;
    $_SESSION['color4'] = $color4;
    $_SESSION['color5'] = $color5;
}
?>

<div class="result">

 <table>
 <tr><th colspan="2" style="text-align: center;">Your Favorite Colors</th></tr>
<tr><td>Favorite Color 1:</td><td><?php echo ucfirst($_SESSION['color1']); ?></td></tr>
<tr><td>Favorite Color 2:</td><td><?php echo ucfirst($_SESSION['color2']); ?></td></tr>
<tr><td>Favorite Color 3:</td><td><?php echo ucfirst($_SESSION['color3']); ?></td></tr>
<tr><td>Favorite Color 4:</td><td><?php echo ucfirst($_SESSION['color4']); ?></td></tr>
<tr><td>Favorite Color 5:</td><td><?php echo ucfirst($_SESSION['color5']); ?></td></tr>
<tr><td colspan="2" style="text-align: center;">
        <form action="FavoriteColor.php" method="get">
        <input type="submit" value="Return">
        </form>
      </td></tr>
</table>

</div>
  

</body>
</html>
