<?php
session_start();
include('../config/db_connect.php');
require_once('../includes/validation.php');
if($_SERVER["REQUEST_METHOD"] == "POST"){

$event_name = mysqli_real_escape_string($conn, $_POST['event_name']);
$event_date = $_POST['event_date'];
$location_id = $_POST['location_id'];
$organized_by = $_SESSION['user_id'];
preventDuplicate(
    $conn,
    "plantation_events",
    "event_name='$event_name' AND event_date='$event_date' AND location_id='$location_id'",
    "add_event.php",
    "Event already exists!"
);
$sql = "INSERT INTO plantation_events(event_name,event_date,location_id,organized_by)
VALUES('$event_name','$event_date','$location_id','$organized_by')";

if(mysqli_query($conn,$sql)){

echo "<script>
alert('Event created successfully');
window.location.href='manage_events.php';
</script>";

}
else{

echo "Error: " . mysqli_error($conn);

}

}
