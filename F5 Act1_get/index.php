<!DOCTYPE html>
<html>
<head>
  <title>GET_INFO</title>
</head>
<body>
  <form method="get" action="">
    <table>
      <tr>
        <td>First Name:</td>
        <td><input type="text" name="firstname"></td>
      </tr>
      <tr>
        <td>Middle Name:</td>
        <td><input type="text" name="middlename"></td>
      </tr>
      <tr>
        <td>Last Name:</td>
        <td><input type="text" name="lastname"></td>
      </tr>
      <tr>
        <td>Date of Birth:</td>
        <td><input type="text" name="dateofbirth"></td>
      </tr>
      <tr>
        <td>Address:</td>
        <td><input type="text" name="address"></td>
      </tr>
      <tr>
        <td colspan="2"><input type="submit" value="Submit"></td>
      </tr>
    </table>
  </form>

  <?php
  if (isset($_GET['firstname'])) {
      echo "<br>";
      echo "First Name: " . $_GET['firstname'] . "<br>";
      echo "Middle Name: " . $_GET['middlename'] . "<br>";
      echo "Last Name: " . $_GET['lastname'] . "<br>";
      echo "Date of Birth: " . $_GET['dateofbirth'] . "<br>";
      echo "Address: " . $_GET['address'] . "<br>";
  }
  ?>
</body>
</html>
