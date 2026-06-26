<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
    session_start();    
    $_SESSION['num1'] = rand(1, 100);
    $_SESSION['num2'] = rand(1, 100);
    echo "Registration";
    ?>
    <form action="validation.php" method="post">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name"><br><br>
        <label for="username">Username:</label>
        <input type="text" id="username" name="username"><br><br>
        <label for="email">Email:</label>
        <input type="text" id="email" name="email"><br><br>
        <label for="captcha">Captcha: <?php echo $_SESSION['num1'] . " + " . $_SESSION['num2'] . " = ?"; ?></label>
        <input type="text" id="captcha" name="captcha"><br><br>
        <input type="submit" value="Submit">
    </form>
</body>
</html>