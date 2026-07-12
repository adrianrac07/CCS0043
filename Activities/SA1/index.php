<<<<<<< HEAD
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Document</title>
</head>
<body>
    <table>
    <tr>
        <th colspan = "2">For School Use - 5 <div class="mb-3"> <label for="exampleFormControlInput1" class="form-label">Email address</label>
  <input type="email" class="form-control" id="exampleFormControlInput1" placeholder="name@example.com">
</div></th>
    </tr>
    <tr>
        <td>Addition</td>
        <td> </td>
    </tr>
    <tr>
        <td>Subtraction</td>
        <td> </td>
    </tr>
    <tr>
        <td>Multiplication</td>
        <td></td>
    </tr>
    <tr>
        <td>Division</td>
        <td></td>
    </tr>
</table> 
</body>
</html>
=======
<!DOCTYPE html> 
<html> 
<head> 
<style> 
table { 
    border-collapse: collapse; 
} 
td,{ 
    width: 40px; 
    height: 40px; 
    text-align: center; 
} 
</style> 
</head> 
<body> 
 
<h2>Multiplication Table</h2> 
 
<table border="2"> 
<?php 
for ($row = 0; $row <= 10; $row++) { 
 
    for ($col = 0; $col <= 10; $col++) { 
 
        if (($row + $col) % 2 == 0) { 
            $color = "#ebb70eff"; 
        } else { 
            $color = "#095dccff"; 
        } 
 
        echo "<td bgcolor='$color'>" . ($row * $col) . "</td>"; 
    } 
 
    echo "</tr>"; 
} 
?> 
</table> 
 
</body> 
</html> 
>>>>>>> 7778316bc1f185c8bf4ee5854e72ea6c1468e936
