<?php
    // Include necessary files
    include __DIR__ . '/../core/functions.php';
    require __DIR__ . '/./track.php';

    // Check if post_id is provided
    if(isset($_GET['post_id'])) {
        $post_id = $_GET['post_id'];

        // Query to fetch comments for the given post_id
        $query = "SELECT comments.*, users.username 
                  FROM comments 
                  JOIN users ON comments.user_id = users.id 
                  WHERE comments.post_id = ? 
                  ORDER BY comments.id DESC";

        // Execute the query
        $comments = query($query, [$post_id]);

        // Check if there are comments
        if($comments) {
            // Loop through each comment and output HTML
            foreach($comments as $comment) {
                echo '<div class="card mb-3 w-100">';
                echo '<div class="card-body">';
                echo '<h5 class="card-title">' . esc($comment['username']) . '</h5>';
                echo '<p class="card-text">' . esc($comment['content']) . '</p>';
                echo '<p class="card-text"><small class="text-muted">' . date("F j, Y, g:i a", strtotime($comment['date'])) . '</small></p>';
                echo '</div>';
                echo '</div>';
            }
        } else {
            // If no comments found
            echo '<p>No comments yet.</p>';
        }
    } else {
        // If post_id is not provided
        echo "Post ID not provided.";
    }
