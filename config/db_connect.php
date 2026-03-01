<?php
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "tree_plantation_system";

$conn = mysqli_connect($host, $user, $pass, $dbname);

// Check if the connection failed
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>