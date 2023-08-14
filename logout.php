<?php
session_start();

// Unset session variables
$_SESSION = array();

// destroy the session
session_destroy();

// Redirect to login page:
header("Location: index.php");
exit;
?>