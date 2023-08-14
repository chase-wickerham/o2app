<?php
session_start();  
require 'db_connection.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Prevent SQL injection
    $email = $mysqli->real_escape_string($email);
    $password = $mysqli->real_escape_string($password);

    // Get the user's IP address
    $ip = $_SERVER['REMOTE_ADDR'];

    // Validate (unique email etc)
    $result = $mysqli->query("SELECT * FROM users WHERE email = '$email'");

    if ($result && $result->num_rows > 0) {
        echo "This email address is already registered.";
        exit;
    }
    // password hashing
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    
    // Insert new user into the database
    if ($mysqli->query("INSERT INTO users (email, password, lastIP) VALUES ('$email', '$hashed_password', '$ip')")) {
        echo "success";
    } else {
        echo "An error occurred: " . $mysqli->error;
    }
}

$mysqli->close();
?>