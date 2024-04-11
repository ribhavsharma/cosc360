<?php
    include __DIR__ . '/../core/functions.php';
    session_start();

    $query = "select posts.*, categories.category from posts join categories on posts.category_id = categories.id order by id desc";
    $rows = query($query);
    if($rows){
        foreach($rows as $row){
            include '../pages/others/post-card.php';
        }
    }else{
        echo "No posts found";
    }
?>