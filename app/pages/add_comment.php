<?php

session_start();

if (!isset($_SESSION['username'])) {
  // Redirect to login if not logged in
  header('Location: ./login');
  die();
}

$post_id = $_POST['post_id'];
$content = htmlspecialchars($_POST['content']); // Escape user input

if (empty($content)) {
  // Handle empty comments
  echo "Please enter a comment.";
  die();
}

$query = "INSERT INTO comments (post_id, user_id, content) VALUES (?, ?, ?)";
$stmt = query($query, [$post_id, user('id'), $content]); // Assuming query() handles execution

// Redirect back to the post page after successful insertion
header('Location: ./post?id=' . $post_id);
die();


