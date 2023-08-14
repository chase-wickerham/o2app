<?php
session_start();

if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION['sessuserid'])) {
    $userid = $_SESSION['sessuserid'];

    // Gathering form data
    $displayName = $_POST['display_name'] ?? null;
    $userEmail = $_POST['user_email'] ?? null;
    $tagline = $_POST['tagline'] ?? null;
    $avatar = $_POST['avatar'];

    $updates = [];
    $types = '';
    $values = [];

    if ($displayName) {
        $updates[] = "username = ?";
        $types .= "s";
        $values[] = $displayName;
    }

    if ($userEmail) {
        $updates[] = "email = ?";
        $types .= "s";
        $values[] = $userEmail;
    }

    if ($tagline) {
        $updates[] = "tagline = ?";
        $types .= "s";
        $values[] = $tagline;
    }

    if ($avatar) {
        $updates[] = "avatar = ?";
        $types .= "i";
        $values[] = $avatar;
    }



    // Abort if no fields are updated
    if (empty($updates)) {
        echo "No data provided for update!";
        exit;
    }

    require 'db_connection.php'; 

    $types .= "i";
    $values[] = $userid;

    $stmt = $mysqli->prepare("UPDATE users SET " . implode(", ", $updates) . " WHERE userid = ?");
    $stmt->bind_param($types, ...$values);  // Using the spread operator to unpack array values
    
    if ($stmt->execute()) {
        echo "Profile updated successfully!";
    // Fetching updated user details
    $stmt = $mysqli->prepare("SELECT * FROM users WHERE userid = ?");
    $stmt->bind_param("i", $userid);
    $stmt->execute();

    $result = $stmt->get_result();
    $updatedUser = $result->fetch_assoc();

    // Update session variables
    $_SESSION['sessusername'] = $updatedUser['username'];
    $_SESSION['sessuseremail'] = $updatedUser['email'];
    $tagline = $updatedUser['tagline'];
    } else {
        echo "Error updating profile.";
    }

    $stmt->close();
    $mysqli->close();
}
?>