<?php
session_start();
include('db_connection.php'); // Make sure you include your database connection details here

$userid = $_SESSION['sessuserid'];
$currentPassword = $_POST['currentPassword'];
$newPassword = $_POST['newPassword'];

// Fetch the current hashed password from the database
$stmt = $mysqli->prepare("SELECT password FROM users WHERE userid = ?");
$stmt->bind_param("i", $userid);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$hashedPassword = $row['password'];

if (password_verify($currentPassword, $hashedPassword)) {
    // If the current password is correct, hash the new password and update it
    $newHashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

    $stmt = $mysqli->prepare("UPDATE users SET password = ? WHERE userid = ?");
    $stmt->bind_param("si", $newHashedPassword, $userid);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo "Password updated successfully!";
    } else {
        echo "Error updating password!";
    }

} else {
    echo "Current password is incorrect!";
}

$stmt->close();
?>