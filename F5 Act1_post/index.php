<!DOCTYPE html>
<html>
<head>
  <title>POST_INFO</title>
</head>
<body>
  <form method="post" action="">
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
  if (isset($_POST['fname'])) {
      echo "<br>";
      echo "First Name: " . $_POST['fname'] . "<br>";
      echo "Middle Name: " . $_POST['mname'] . "<br>";
      echo "Last Name: " . $_POST['lname'] . "<br>";
      echo "Date of Birth: " . $_POST['dob'] . "<br>";
      echo "Address: " . $_POST['address'] . "<br>";
  }
  ?>
</body>
</html>
