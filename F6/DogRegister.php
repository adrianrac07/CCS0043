<?php
include('DogSQL.php');
if (isset($_POST['save'])) {
  $name = $_POST['name'];
  $breed = $_POST['breed'];
  $age = $_POST['age'];
  $address = $_POST['address'];
  $color = $_POST['color'];
  $height = $_POST['height'];
  $weight = $_POST['weight'];

  $sql = "INSERT INTO dogs (name, breed, age, address, color, height, weight)
          VALUES ('$name','$breed','$age','$address','$color','$height','$weight')";

  if ($conn->query($sql) === TRUE) {
    header("Location: DogView.php"); 
  } else {
    echo "Error: " . $conn->error;
  }
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
<title>Dog Register</title>
<link rel="stylesheet" href="style.css">
</head>
<body>

<h2>Dog Registration</h2>

<form method="POST">
  <label>Name</label>
  <input type="text" name="name" required>

  <label>Breed</label>
  <input type="text" name="breed" required>

  <label>Age</label>
  <input type="number" name="age" required>

  <label>Address</label>
  <input type="text" name="address">

  <label>Color</label>
  <input type="text" name="color">

  <label>Height</label>
  <input type="text" name="height">

  <label>Weight</label>
  <input type="text" name="weight">

  <input type="submit" name="save" value="Save">
</form>

<a href="DogView.php" class="btn">View Dogs</a>

</body>
</html>
