<?php

$host = "sql110.infinityfree.com";
$user = "if0_41303749";
$password = "y6E45be0s77foF";
$database = "if0_41303749_tree_plantation_system";

$conn = mysqli_connect($host,$user,$password,$database);

if(!$conn){
    die("Database connection failed: " . mysqli_connect_error());
}

?>