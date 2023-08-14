<?php
session_start();

include 'db_connection.php';  // Assuming you've your connection details in this file

if(isset($_POST['display_name'], $_POST['postContent'])) {
    $title = $_POST['display_name'];
    $content = $_POST['postContent'];
    $graphSelection = intval($_POST['usersGraphsSelection']); // Convert to integer for safety
    $userId = $_SESSION['sessuserid']; // Assuming you've this session variable set when the user logs in

    // Basic validation (you can expand on this)
    if(empty($title) || empty($content)) {
        echo "Please fill in all the fields!";
        exit();
    }

    // Prepare your SQL statement to include the title and graph_id
    $stmt = $mysqli->prepare("INSERT INTO posts (user_id, title, content, graph_id, created_at) VALUES (?, ?, ?, ?, NOW())");
    $stmt->bind_param("issi", $userId, $title, $content, $graphSelection); // bind the parameters

    if($stmt->execute()) {
        echo "Post submitted successfully!";
    } else {
        echo "Error submitting post.";
    }

    $stmt->close();
}
?>