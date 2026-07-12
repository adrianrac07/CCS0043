<?php
// ------------------------------------------------------
// Database connection using mysqli
// Edit these 4 values to match your own MySQL setup.
// ------------------------------------------------------
$db_host = "localhost";
$db_user = "root";
$db_pass = "";
$db_name = "cms_db";

// Create the connection
$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

// Stop the script if the connection fails
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$conn->set_charset("utf8mb4");

// ------------------------------------------------------
// BASE_URL: the folder this project lives in, relative to your web root.
// Example: if you access the site at http://localhost/cms_simple/,
// set this to "/cms_simple/". If it's the root site, use "/".
// We use this everywhere instead of typing out full paths, so links
// and redirects work no matter which page you're on.
// ------------------------------------------------------
define('BASE_URL', '/cms_simple/');
