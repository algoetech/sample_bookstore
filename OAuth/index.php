<?php

session_start();

if (is_null($_SESSION['user_email']) || is_null($_SESSION['user_role'])) {
    header('location: ../index.php');
}
?>