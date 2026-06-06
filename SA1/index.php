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