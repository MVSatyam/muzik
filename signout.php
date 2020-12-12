<?php
include 'dbconnect.php';
session_start();
unset($_SESSION['muzik_user']);
header('location: ./signin.php');
?>