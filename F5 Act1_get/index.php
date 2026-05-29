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
        <td><input type="text" name="fname"></td>
      </tr>
      <tr>
        <td>Middle Name:</td>
        <td><input type="text" name="mname"></td>
      </tr>
      <tr>
        <td>Last Name:</td>
        <td><input type="text" name="lname"></td>
      </tr>
      <tr>
        <td>Date of Birth:</td>
        <td><input type="text" name="dob"></td>
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
  if (isset($_GET['fname'])) {
      echo "<br>";
      echo "First Name: " . $_GET['fname'] . "<br>";
      echo "Middle Name: " . $_GET['mname'] . "<br>";
      echo "Last Name: " . $_GET['lname'] . "<br>";
      echo "Date of Birth: " . $_GET['dob'] . "<br>";
      echo "Address: " . $_GET['address'] . "<br>";
  }
  ?>
</body>
</html>
