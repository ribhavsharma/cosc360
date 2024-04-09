<?php
include __DIR__ . "/../core/functions.php";
require __DIR__ . "/./track.php";

// Start the session
// session_start();

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

    <style>
        .breadcrumb {
            background-color: #f8f9fa; /* Change the background color */
            border-radius: .25rem; /* Add rounded corners */
            border: 1px solid #ddd; 
            box-shadow: 0 0.25rem 0.75rem rgba(0, 0, 0, .05); /* Add a subtle shadow */
            padding: 0.75rem 1rem; /* Add some padding */
        }

        .breadcrumb a {
            color: #007bff; /* Change the color of the links */
        }

        .breadcrumb .active {
            color: #6c757d; /* Change the color of the active page */
        }
    </style>
</head>
<body>
    <header>
        <nav class="d-flex">
            <a class="logo" href="./home.php">Logo</a>
            <?php 
                if(isset($_SESSION['username'])){
                    $query = 'select role from users where username = :username limit 1';
                    $user = queryRow($query, ['username' => $_SESSION['username']]);
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

    <div class="container my-5">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <?php echo create_breadcrumbs(); ?>
            </ol>
        </nav>
    </div> 

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