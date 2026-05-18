<?php

function preventDuplicate($conn, $table, $conditions, $redirect, $message){

    $query = "SELECT * FROM $table WHERE $conditions";

    $result = mysqli_query($conn, $query);

    if(mysqli_num_rows($result) > 0){

        echo "<script>alert('$message'); window.location='$redirect';</script>";

        exit();

    }

}

?>