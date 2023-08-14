<?php
session_start();
include 'db_connection.php';

$userId = $_SESSION['sessuserid'];

$query = "SELECT posts.*, users.username, users.avatar 
         FROM posts 
         JOIN users ON posts.user_id = users.userid 
         WHERE posts.user_id = ? 
         ORDER BY posts.created_at DESC";

$stmt = $mysqli->prepare($query);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();

$postCount = $result->num_rows;  // Get posts

if ($postCount > 0) {
    while ($post = $result->fetch_assoc()) {
        // Bootstrap styled HTML for post
        echo '<div class="row">';
        echo '<div class="col-lg-10 col-xlg-12">';
        echo '<div class="card">';
        echo '<div class="tab-content">';
        echo '<div class="card-body">';
        echo '<div class="profiletimeline border-start-0">';
        echo '<div class="sl-item">';
        
        // username and avatar
        echo '<div class="sl-left">';
        echo "<img src='images/users/" . htmlspecialchars($post['avatar'], ENT_QUOTES, 'UTF-8') . ".jpg' alt='user' class='img-circle'>"; 
        echo '</div>'; 
        
        echo '<div class="sl-right">';
        echo '<div>';
        echo "<a href='#'>" . htmlspecialchars($post['username'], ENT_QUOTES, 'UTF-8') . "</a> ";
        echo "<span class='sl-date'>" . date("F j, Y, g:i a", strtotime($post['created_at'])) . "</span>"; // Date posted
        
        // Display the post title and content
        echo "<h2 class='mt-2 mb-2'>" . htmlspecialchars($post['title'], ENT_QUOTES, 'UTF-8') . "</h2>";
        echo "<p class='mt-2'>" . htmlspecialchars($post['content'], ENT_QUOTES, 'UTF-8') . "</p>";
        
        echo "<button class='btn btn-danger text-white deletePostButton' data-postid='" . $post['post_id'] . "'>Delete Post</button>";

        echo '</div>'; // end of inner div
        echo '</div>'; // end of sl-right
        
        echo '</div>'; // end of sl-item
        echo '</div>'; // end of profiletimeline
        echo '</div>'; // end of card-body
        echo '</div>'; // end of tab-content
        echo '</div>'; // end of card
        echo '</div>'; // end of col
        echo '</div>'; // end of row
    }
} elseif ($postCount === 0) {
    // If no posts are available
    echo "<div class='alert alert-info'>You have not made any posts yet.</div>";
} else {
    echo "Error fetching your posts.";
}