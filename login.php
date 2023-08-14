<?php
session_start();
require 'db_connection.php';

$email = $_POST['email'];
$password = $_POST['password'];  

// Check if user exists and the password is correct
$query = "SELECT * FROM users WHERE email = ?";
$stmt = $mysqli->prepare($query);
$stmt->bind_param("s", $email);
$stmt->execute();

$result = $stmt->get_result();
$user = $result->fetch_assoc();

// Validate if user exists and password is correct
if($user && password_verify($password, $user['password'])) {
    // Get the user's IP address
    $ip = $_SERVER['REMOTE_ADDR'];

    // Update the lastIP field in the database
    $updateIPQuery = "UPDATE users SET lastIP = ? WHERE userid = ?";
    $ipStmt = $mysqli->prepare($updateIPQuery);
    $ipStmt->bind_param("si", $ip, $user['userid']);
    $ipStmt->execute();
    $ipStmt->close();

    $_SESSION['loggedin'] = true;
    $_SESSION['sessuserid'] = $user['userid'];
    $_SESSION['sessuseremail'] = $user['email'];
    $_SESSION['sessusername'] = $user['username'];  // Initialize session variables
    echo "success";
} else {
    echo "Invalid email or password.";
}

$stmt->close();
$mysqli->close();
?>