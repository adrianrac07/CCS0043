<html>
<style>
table {
    border-collapse: collapse;
    width: 30%;
    margin: 0 auto;
}

td, th {
    border: 1px solid black;
    padding: 10px;
    text-align: center;
}

h2 {
    text-align: center;
}
</style>
<body>
<h2>List of Names</h2>
<table>
<tr>
    <th>Name</th>
    <th>Number of characters</th>
    <th>Uppercase first character</th>
    <th>Replace vowels with @</th>
    <th>Check position of character "a"</th>
    <th>Reverse name</th>
</tr>
<?php
$names = array(
    "chrisa", "maria", "juan", "pedro", "ana",
    "mark", "john", "jane", "paul", "lisa",
    "kim", "jungkook", "yoongi", "jimin", "jin",
    "namjoon", "rose", "eunwoo", "minho", "hye kyo"
);
foreach ($names as $name) {
    echo "<tr>";
    echo "<td>$name</td>";
    echo "<td>" . strlen($name) . "</td>";
    echo "<td>" . ucfirst($name) . "</td>";
    $replace = str_replace(
        array('a','e','i','o','u'),
        '@',
        strtolower($name)
    );
    echo "<td>$replace</td>";
    $pos = strpos($name, 'a');
    if ($pos !== false) {
        echo "<td>$pos</td>";
    } else {
        echo "<td>None</td>";
    }
    echo "<td>" . strrev($name) . "</td>";
    echo "</tr>";
}
?>
</table>
</body>
</html>