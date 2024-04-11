<?php
    include __DIR__ . '/../core/functions.php';
    session_start();

    $newestPostId = $_GET['newestPostId'] ?? 0;

    $query = "SELECT posts.*, categories.category FROM posts JOIN categories ON posts.category_id = categories.id WHERE posts.id > :newestPostId ORDER BY id DESC";
    $rows = query($query, ['newestPostId' => $newestPostId]);
    if($rows){
        foreach($rows as $row){
            include '../pages/others/post-card.php';
        }
    }
?>