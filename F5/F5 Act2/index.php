<?php
if (isset($_GET['firstname'])) {

    setcookie("firstname", $_GET['firstname'], time() + 60);
    setcookie("middlename", $_GET['middlename'], time() + 60);
    setcookie("lastname", $_GET['lastname'], time() + 60);

    setcookie("start_time", time(), time() + 60);

    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Personal Information Webpage</title>

    <?php
    if (isset($_COOKIE['start_time'])) {
        echo '<meta http-equiv="refresh" content="1">';
    }
    ?>
</head>

<body>

<div class="container">

    <h2>Personal Information</h2>

    <form method="get">
        <table>
            <tr>
                <td>First Name:</td>
                <td><input type="text" name="firstname" required></td>
            </tr>

            <tr>
                <td>Middle Name:</td>
                <td><input type="text" name="middlename" required></td>
            </tr>

            <tr>
                <td>Last Name:</td>
                <td><input type="text" name="lastname" required></td>
            </tr>

            <tr>
                <td colspan="2">
                    <input type="submit" value="Submit">
                </td>
            </tr>
        </table>
    </form>

    <div class="result">
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
    </div>

</div>

</body>
</html>