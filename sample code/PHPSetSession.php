
<?php
session_start();
$_SESSION['logged'] = true;
$_SESSION['name' ] = 'Juan Dela Cruz';
$_SESSION['email'] = 'jdelacruz@yahoo.com';
header ('location: PHPDisplaySession.php') ;
?>