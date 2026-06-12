<?php
if (isset($_GET['fname'])) {

    setcookie("firstname", $_GET['fname'], time() + 60);
    setcookie("middlename", $_GET['mname'], time() + 60);
    setcookie("lastname", $_GET['lname'], time() + 60);

    setcookie("start_time", time(), time() + 60);
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Cookie</title>
</head>
<body>

<form method="get">
    <table>
        <tr>
            <td>First Name:</td>
            <td><input type="text" name="fname"></td>
        </tr>
        <tr>
            <td>Middle Name:</td>
            <td><input type="text" name="mname"></td>
        </tr>
        <tr>
            <td>Last Name:</td>
            <td><input type="text" name="lname"></td>
        </tr>
        <tr>
            <td colspan="2">
                <input type="submit" value="Submit">
            </td>
        </tr>
    </table>
</form>

<br>

<?php
if (isset($_COOKIE['start_time'])) {

    $elapsed = time() - $_COOKIE['start_time'];

    if ($elapsed >= 10) {
        echo "First Name: " . $_COOKIE['firstname'] . "<br>";
    } else {
        echo "First Name: Waiting for 10 seconds...<br>";
    }

    if ($elapsed >= 20) {
        echo "Middle Name: " . $_COOKIE['middlename'] . "<br>";
    } else {
        echo "Middle Name: Waiting for 20 seconds...<br>";
    }

    if ($elapsed >= 30) {
        echo "Last Name: " . $_COOKIE['lastname'] . "<br>";
    } else {
        echo "Last Name: Waiting for 30 seconds...<br>";
    }
}
?>

</body>
</html>