<?php
session_start();

if (!isset($_SESSION['fname'])) {
    header("Location: ../../Frontend/HTML/home_page.html");
    exit();
}

$name = $_SESSION['fname'];  
?>

