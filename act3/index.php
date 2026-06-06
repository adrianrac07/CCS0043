<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Array Operations</title>
    <style>
        table {
            border-collapse: collapse;
            width: 400px;
        }
        td, th {
            border: 1px solid black;
            padding: 8px;
        }
        th {
            text-align: left;
        }
    </style>
</head>
<body>

<?php
$numbers = array(1, 2, 3, 4, 5, 6, 7, 8, 10);

$sum = array_sum($numbers);

$subtraction = $numbers[0];
for ($i = 1; $i < count($numbers); $i++) {
    $subtraction -= $numbers[$i];
}

$product = 1;
foreach ($numbers as $num) {
    $product *= $num;
}

$division = $numbers[0];
for ($i = 1; $i < count($numbers); $i++) {
    $division /= $numbers[$i];
}
?>

<table>
    <tr>
        <th colspan="2">Array list: <?= implode(", ", $numbers); ?></th>
    </tr>
    <tr>
        <td>Addition</td>
        <td><?= $sum; ?></td>
    </tr>
    <tr>
        <td>Subtraction</td>
        <td><?= $subtraction; ?></td>
    </tr>
    <tr>
        <td>Multiplication</td>
        <td><?= $product; ?></td>
    </tr>
    <tr>
        <td>Division</td>
        <td><?= $division; ?></td>
    </tr>
</table>

</body>
</html>