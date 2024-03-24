<?php

// Include your database connection
session_start();

$post_id = $_GET['id']; // Get the post ID from the URL

// Query the database to get the full post content using the post_id
$post = query_row("SELECT * FROM posts WHERE id = ?", [$post_id]);

if(!$post) {
    echo "Post not found!";
    die();
}

?>

<!DOCTYPE html>
<html>
<head>
        <link rel="stylesheet" href="../public/assets/css/styles.css" />
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
</head>
<body>
        <header>
                <nav class="d-flex">
                        <a class="logo" href="./">Logo</a>
                        <?php 
                                if(isset($_SESSION['username'])){
                                        $query = 'select role from users where username = :username limit 1';
                                        $user = query_row($query, ['username' => $_SESSION['username']]);
                                }
                        ?>
                        <ul class="nav-links">
                                <li><a href="./">Blogs</a></li>
                                <li><a href="./write">Write Blog</a></li>
                                <?php
                                
                                if (isset($_SESSION['username'])) {
                                        echo '<a class="circle" href="./user"></a>';
                                        echo '<li><a href="./user">' . $_SESSION['username'] .'</a></li>';
                                        if($user['role'] == 'admin') {
                                                echo '<li><a href="./admin">Admin</a></li>';
                                        }
                                        echo '<li><a href="./logout">Sign Out</a></li>';
                                } else {
                                        echo '<li><a href="./login">Log In</a></;li>';
                                }
                                ?>
                        </ul>
                </nav>
        </header>
        
        <div class="post mb-4 mt-4">
        
    <div class="container">
    <a href="./" style="color: blue;">Back</a>
        <div class="row mt-4 mb-4">
            <div class="col-md-8">
                <h1 class="display-4"><strong><?php echo esc($post['title']) ?></strong></h1>
            </div>
            <div class="col-md-4 text-muted">
                <p class="mb-0">Date: <?php echo esc($post['date']) ?></p>


                <?php
                $category_id = $post['category_id'];
                $category = query_row("SELECT category FROM categories WHERE id = ?", [$category_id]);
                if($category) {
                        echo "Category: " . esc($category['category']);
                }
                ?>
            </div>
        </div>

        <img src="<?php echo esc($post['image']) ?>" alt="Post Image" class="img-fluid rounded mb-4">

        <div class="content">
            <?php echo esc($post['content']) ?>
        </div>
    </div>
</div>


        
</body>
</html>
