<?php
error_reporting(E_ALL);
ini_set('display_errors', 'on');
// Initialize the session
session_start(); 
header("location: welcome.php");
exit;
?>