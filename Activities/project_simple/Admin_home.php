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

if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    mysqli_query($conn, "DELETE FROM users WHERE id=$id");
    header("Location: Admin_home.php");
    exit();
}

if (isset($_GET['toggle'])) {
    $id = (int)$_GET['toggle'];
    $result = mysqli_query($conn, "SELECT status FROM users WHERE id=$id");
    $row = $result ? mysqli_fetch_assoc($result) : null;

    if ($row) {
        $newstatus = ($row['status'] == 'active') ? 'disable' : 'active';
        mysqli_query($conn, "UPDATE users SET status='$newstatus' WHERE id=$id");
    }

    header("Location: Admin_home.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Home</title>
</head>
<body>

<div style="text-align:right;">
    <a href="logout.php">Logout</a>
</div>

<h2>My Information</h2>

<div style="display:flex; justify-content:space-between; align-items:flex-start;">
    
    <div>
    <?php
    if (isset($_SESSION['id'])) {
        $id = (int)$_SESSION['id'];
        $result = mysqli_query($conn, "SELECT * FROM users WHERE id=$id");

        if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);

            $image = !empty($row['image']) ? $row['image'] : "default.png";
    ?>
        Welcome <?php echo htmlspecialchars($row['firstname']); ?><br>
        Userlevel: <?php echo htmlspecialchars($row['accesslevel']); ?><br>
        Birthday: <?php echo htmlspecialchars($row['birthday']); ?><br>
        Contact Details:<br>
        Contact Number: <?php echo htmlspecialchars($row['contactno']); ?><br>
        Email: <?php echo htmlspecialchars($row['email']); ?><br>
    </div>

    <div>
        <img src="uploads/<?php echo htmlspecialchars($image); ?>" width="150">
    </div>

    <?php
        }
    }
    ?>
</div>

<p>
    <a href="Admin_image.php">Upload Image</a> |
    <a href="Admin_changepass.php">Reset my password</a>
</p>

<h2>-Records-</h2>
<p><a href="Admin_adduser.php">Add New User</a></p>

<table border="1" cellpadding="5">
    <tr>
        <th>ID</th>
        <th>First Name</th>
        <th>Middle Name</th>
        <th>Last Name</th>
        <th>Contact No.</th>
        <th>Email</th>
        <th>Birthday</th>
        <th>Username</th>
        <th>Access Level</th>
        <th>Status</th>
    </tr>

<?php
$result = mysqli_query($conn, "SELECT * FROM users");

if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>" . (int)$row['id'] . "</td>";
        echo "<td>" . htmlspecialchars($row['firstname']) . "</td>";
        echo "<td>" . htmlspecialchars($row['middlename']) . "</td>";
        echo "<td>" . htmlspecialchars($row['lastname']) . "</td>";
        echo "<td>" . htmlspecialchars($row['contactno']) . "</td>";
        echo "<td>" . htmlspecialchars($row['email']) . "</td>";
        echo "<td>" . htmlspecialchars($row['birthday']) . "</td>";
        echo "<td>" . htmlspecialchars($row['username']) . "</td>";
        echo "<td>" . htmlspecialchars($row['accesslevel']) . "</td>";
        echo "<td><a href='Admin_home.php?toggle=" . (int)$row['id'] . "'>" . htmlspecialchars($row['status']) . "</a></td>";
       
        echo "</tr>";
    }
}
?>

</table>

</body>
</html>