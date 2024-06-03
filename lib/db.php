<?php

$servername = "localhost"; 
$username = "root"; 
$password = ""; 
$dbname = "bookstore"; 

$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

function secure(){
    if (is_null($_SESSION['user_email']) || is_null($_SESSION['user_role'])) {
        header('location: ../index.php');
    }
}

function isAdmin(){
    if ($_SESSION['user_role'] == "admin") {
        return true;
    }
    return false;
}


?>