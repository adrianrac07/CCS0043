<?php
    include("header.php"); 
?>

<h2>Enter Your Favorite Colors</h2>
<form method="get" action="ResultColor.php">
  <table>
    <tr><td>Favorite Color 1:</td><td><input type="text" name="color1"></td></tr>
    <tr><td>Favorite Color 2:</td><td><input type="text" name="color2"></td></tr>
    <tr><td>Favorite Color 3:</td><td><input type="text" name="color3"></td></tr>
    <tr><td>Favorite Color 4:</td><td><input type="text" name="color4"></td></tr>
    <tr><td>Favorite Color 5:</td><td><input type="text" name="color5"></td></tr>
    <tr><td colspan="2"><input type="submit" value="Send Colors"></td></tr>
  </table>
</form>

</body>
</html>
