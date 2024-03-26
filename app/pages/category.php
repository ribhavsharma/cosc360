<?php
include __DIR__ . "/../core/functions.php";

// Start the session
session_start();

// Get the category from the URL
$category = $_GET['category'];

// Fetch posts from the database
$query = "SELECT posts.*, categories.category FROM posts 
          JOIN categories ON posts.category_id = categories.id 
          WHERE categories.category = :category";
$rows = query($query, ['category' => $category]);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Posts in category: <?= htmlspecialchars($category) ?></title>
    <link rel="stylesheet" href="../public/assets/css/styles.css" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
</head>
<body>
    <header>
        <nav class="d-flex">
            <a class="logo" href="./home.php">Logo</a>
            <?php 
                if(isset($_SESSION['username'])){
                    $query = 'select role from users where username = :username limit 1';
                    $user = query_row($query, ['username' => $_SESSION['username']]);
                }
            ?>
            <ul class="nav-links">
                <li><a href="./home.php">Blogs</a></li>
                <li><a href="./write.php">Write Blog</a></li>
                <?php
                
                if (isset($_SESSION['username'])) {
                    echo '<a class="circle" href="./user.php"></a>';
                    echo '<li><a href="./user.php">' . $_SESSION['username'] .'</a></li>';
                    if($user['role'] == 'admin') {
                        echo '<li><a href="./admin.php">Admin</a></li>';
                    }
                    echo '<li><a href="./logout.php">Sign Out</a></li>';
                } else {
                    echo '<li><a href="./login.php">Log In</a></;li>';
                }
                ?>
            </ul>
        </nav>
    </header>
    <div class="container mt-4">
        <h1 class="mb-4">Posts in category: <?= htmlspecialchars($category) ?></h1>

        <?php
        if($rows){
            foreach($rows as $row){
                echo '<div class="card mb-4">';
                echo '<div class="card-body">';
                echo '<h5 class="card-title">' . htmlspecialchars($row['title']) . '</h5>';
                echo '<p class="card-text">' . htmlspecialchars($row['content']) . '</p>';
                echo '</div>';
                echo '</div>';
            }
        }else{
            echo '<p>No posts found in this category</p>';
        }
        ?>
    </div>
</body>
</html>