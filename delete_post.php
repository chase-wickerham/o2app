<?php
session_start();
include 'db_connection.php';

if(isset($_POST['postId'])) {
    $postId = $_POST['postId'];
    $userId = $_SESSION['sessuserid'];

    $stmt = $mysqli->prepare("DELETE FROM posts WHERE post_id = ? AND user_id = ?");
    $stmt->bind_param("ii", $postId, $userId);

    if($stmt->execute()) {
        echo "Post deleted successfully!";
    } else {
        echo "Error deleting post.";
    }

    $stmt->close();
}
?>