<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "db_user");
if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

if (!isset($_SESSION['accesslevel']) || $_SESSION['accesslevel'] != 'admin') {
    header("Location: login.php");
    exit();
}
$error = "";
if (isset($_POST['submit'])) {
    $firstname = mysqli_real_escape_string($conn, trim($_POST['firstname']));
    $middlename = mysqli_real_escape_string($conn, trim($_POST['middlename']));
    $lastname = mysqli_real_escape_string($conn, trim($_POST['lastname']));
    $username = mysqli_real_escape_string($conn, trim($_POST['username']));
    $password = $_POST['password'];
    $confirmpassword = $_POST['confirmpassword'];
    $birthday = mysqli_real_escape_string($conn, $_POST['birthday']);
    $email = mysqli_real_escape_string($conn, trim($_POST['email']));
    $contactno = mysqli_real_escape_string($conn, trim($_POST['contactno']));
    $id = (int)$_POST['id'];

    if ($firstname == "" || $lastname == "" || $username == "") {
        $error = "First name, last name, and username are required.";
    } elseif ($id == 0 && $password == "") {
        $error = "Password is required for a new user.";
    } elseif ($password != $confirmpassword) {
        $error = "Password and confirm password do not match.";
    } else {
        $password = mysqli_real_escape_string($conn, $password);

        if ($id == 0) {
            $check = mysqli_query($conn, "SELECT id FROM users WHERE username='$username'");
            if ($check && mysqli_num_rows($check) > 0) {
                $error = "Username already exists. Please choose another.";
            } else {
                mysqli_query($conn, "INSERT INTO users (firstname, middlename, lastname, username, password, birthday, email, contactno, accesslevel, status, image)
                    VALUES ('$firstname','$middlename','$lastname','$username','$password','$birthday','$email','$contactno','user','active','default.png')");
                header("Location: Admin_home.php");
                exit();
            }
        } else {
            if ($password != "") {
                mysqli_query($conn, "UPDATE users SET firstname='$firstname', middlename='$middlename', lastname='$lastname',
                    username='$username', password='$password', birthday='$birthday', email='$email', contactno='$contactno' WHERE id=$id");
            } else {
                mysqli_query($conn, "UPDATE users SET firstname='$firstname', middlename='$middlename', lastname='$lastname',
                    username='$username', birthday='$birthday', email='$email', contactno='$contactno' WHERE id=$id");
            }
            header("Location: Admin_home.php");
            exit();
        }
    }
}

$user = array('id'=>'','firstname'=>'','middlename'=>'','lastname'=>'','username'=>'','birthday'=>'','email'=>'','contactno'=>'');
if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    $result = mysqli_query($conn, "SELECT * FROM users WHERE id=$id");
    $row = $result ? mysqli_fetch_assoc($result) : null;
    if ($row) {
        $user = $row;
    }
}

if (isset($_POST['submit']) && $error != "") {
    $user['id'] = $_POST['id'];
    $user['firstname'] = $_POST['firstname'];
    $user['middlename'] = $_POST['middlename'];
    $user['lastname'] = $_POST['lastname'];
    $user['username'] = $_POST['username'];
    $user['birthday'] = $_POST['birthday'];
    $user['email'] = $_POST['email'];
    $user['contactno'] = $_POST['contactno'];
}

$editMode = ($user['id'] != "");
?>
<html>
<head>
    <title><?php echo $editMode ? "Edit User" : "Add User"; ?></title>
</head>
<body>
    <div style="width:400px;margin:30px auto;border:1px solid #333;padding:20px;">
        <p style="text-align:right;"><a href="Admin_home.php">Back</a></p>
        <h2><?php echo $editMode ? "Edit User" : "Add User"; ?></h2>
        <p>Fill Up Form</p>
        <?php if ($error != "") { echo "<p style='color:red;'>" . htmlspecialchars($error) . "</p>"; } ?>
        <form method="post" action="Admin_adduser.php">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($user['id']); ?>">

            First Name:<br>
            <input type="text" name="firstname" value="<?php echo htmlspecialchars($user['firstname']); ?>"><br><br>

            Middle Name:<br>
            <input type="text" name="middlename" value="<?php echo htmlspecialchars($user['middlename']); ?>"><br><br>

            Last Name:<br>
            <input type="text" name="lastname" value="<?php echo htmlspecialchars($user['lastname']); ?>"><br><br>

            Username:<br>
            <input type="text" name="username" value="<?php echo htmlspecialchars($user['username']); ?>"><br><br>

            Password:<?php echo $editMode ? " (leave blank to keep current password)" : ""; ?><br>
            <input type="password" name="password"><br><br>

            Confirm Password:<br>
            <input type="password" name="confirmpassword"><br><br>

            Birthday:<br>
            <input type="date" name="birthday" value="<?php echo htmlspecialchars($user['birthday']); ?>"><br><br>

            Email:<br>
            <input type="text" name="email" value="<?php echo htmlspecialchars($user['email']); ?>"><br><br>

            Contact Number:<br>
            <input type="text" name="contactno" value="<?php echo htmlspecialchars($user['contactno']); ?>"><br><br>

            <input type="submit" name="submit" value="Submit">
        </form>
    </div>
</body>
</html>
