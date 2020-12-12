<?php
include 'dbconnect.php';
session_start();
unset($_SESSION['muzik_admin']);
header('location: ./signin.php');
?>