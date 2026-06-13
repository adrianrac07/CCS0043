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
  if (isset($_POST['firstname'])) {
      echo "<br>";
      echo "First Name: " . $_POST['firstname'] . "<br>";
      echo "Middle Name: " . $_POST['middlename'] . "<br>";
      echo "Last Name: " . $_POST['lastname'] . "<br>";
      echo "Date of Birth: " . $_POST['dateofbirth'] . "<br>";
      echo "Address: " . $_POST['address'] . "<br>";
  }
  ?>
</body>
</html>
