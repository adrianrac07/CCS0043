<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "dog_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST['save'])) {
  $name = $_POST['name'];
  $breed = $_POST['breed'];
  $age = intval($_POST['age']);
  $address = $_POST['address'];
  $color = $_POST['color'];
  $height = floatval($_POST['height']);
  $weight = floatval($_POST['weight']);

  $sql = "INSERT INTO dogs (name, breed, age, address, color, height, weight)
  VALUES ('$name', '$breed', $age, '$address', '$color', $height, $weight)";

  if ($conn->query($sql) === TRUE) {
    echo "New record created successfully";
  } else {
    echo "Error: " . $sql . "<br>" . $conn->error;
  }
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
<title>Dog Register</title>
</head>
<body>

<h2>Dog Registration</h2>

<form method="POST">
  Name: <input type="text" name="name"><br><br>
  Breed: <input type="text" name="breed"><br><br>
  Age: <input type="number" name="age"><br><br>
  Address: <input type="text" name="address"><br><br>
  Color: <input type="text" name="color"><br><br>
  Height: <input type="text" name="height"><br><br>
  Weight: <input type="text" name="weight"><br><br>

  <input type="submit" name="save" value="Save" action="DogView.php">
</form>
<a href="DogView.php">View Dogs</a>
</body>
</html>