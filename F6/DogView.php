<?php
include('DogSQL.php');

$sql = "SELECT * FROM dogs";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
<title>Dog Records</title>
<link rel="stylesheet" href="style.css">
</head>
<body>

<h2>Dog Records</h2>

<table>
<tr>
  <th>ID</th>
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
    echo "<td>" . $row["id"] . "</td>";
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
  echo "<tr><td colspan='8'>No records found</td></tr>";
}

$conn->close();
?>

</table>

<a href="DogRegister.php" class="btn">Return</a>

</body>
</html>