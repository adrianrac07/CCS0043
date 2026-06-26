<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "dog_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM dogs";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
<title>Dog Records</title>
</head>
<body>

<h2>Dog Records</h2>

<table border="1">
<tr>
  <th>Name</th>
  <th>Breed</th>
  <th>Age</th>
  <th>Address</th>
  <th>Color</th>
  <th>Height</th>
  <th>Weight</th>
</tr>

<?php
if ($result->num_rows > 0) {
  while($row = $result->fetch_assoc()) {
    echo "<tr>";
    echo "<td>" . $row["name"] . "</td>";
    echo "<td>" . $row["breed"] . "</td>";
    echo "<td>" . $row["age"] . "</td>";
    echo "<td>" . $row["address"] . "</td>";
    echo "<td>" . $row["color"] . "</td>";
    echo "<td>" . $row["height"] . " ft</td>";
    echo "<td>" . $row["weight"] . " kg</td>";
    echo "</tr>";
  }
} else {
  echo "0 results";
}

$conn->close();
?>

</table>

<br>
<a href="DogRegister.php">Back</a>

</body>
</html>