<?php 
    $dbHost = "localhost";
    $dbUser = "root";
    $dbPass = "";
    $dbName = "bookdb";

    $conn = mysqli_connect(
        $dbHost, 
        $dbUser, 
        $dbPass, 
        $dbName
    );
    
    if (!$conn) {
        die("Something went Wrong");
    } 
?>