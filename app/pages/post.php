<?php

include __DIR__ . "/../core/functions.php";
require __DIR__ . "/./track.php";

// Include your database connection
session_start();

$post_id = $_GET['id']; // Get the post ID from the URL

// Query the database to get the full post content using the post_id
$post = queryRow("SELECT * FROM posts WHERE id = ?", [$post_id]);

if (!$post) {
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
                        <a class="logo" href="./home.php">Logo</a>
                        <?php
                        if (isset ($_SESSION['username'])) {
                                $query = 'select role from users where username = :username limit 1';
                                $user = queryRow($query, ['username' => $_SESSION['username']]);
                        }
                        ?>
                        <ul class="nav-links">
                                <li><a href="./home.php">Blogs</a></li>
                                <li><a href="../pages/write.php">Write Blog</a></li>
                                <?php

                                if (isset ($_SESSION['username'])) {
                                        echo '<a class="circle" href="../pages/user.php"></a>';
                                        echo '<li><a href="../pages/user.php">' . $_SESSION['username'] . '</a></li>';
                                        if ($user['role'] == 'admin') {
                                                echo '<li><a href="../pages/admin.php">Admin</a></li>';
                                        }
                                        echo '<li><a href="../pages/logout.php">Sign Out</a></li>';
                                } else {
                                        echo '<li><a href="../pages/login.php">Log In</a></;li>';
                                }
                                ?>
                        </ul>
                </nav>
        </header>

        <div class="post mb-4 mt-4">

                <div class="container">
                        <a href="./home.php" style="color: blue;">Back</a>
                        <div class="row mt-4 mb-4">
                                <div class="col-md-8">
                                        <h1 class="display-4"><strong>
                                                        <?php echo esc($post['title']) ?>
                                                </strong></h1>
                                </div>
                                <div class="col-md-4 text-muted">
                                        <p class="mb-0">Date:
                                                <?php echo esc($post['date']) ?>
                                        </p>


                                        <?php
                                        $category_id = $post['category_id'];
                                        $category = queryRow("SELECT category FROM categories WHERE id = ?", [$category_id]);
                                        if ($category) {
                                                echo '<p class="badge badge-dark p-2">' . esc($category['category']) . '</h1>';
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



        <div class="comments mt-4 container">
                <h3>Comments</h3>
                <form id="commentForm" action="add_comment.php" method="POST" class="mb-4">
    <input type="hidden" name="post_id" value="<?php echo $post_id ?>">
    <div class="form-group">
        <label for="content" class="invisible">Comment</label>
        <textarea name="content" id="content" class="form-control" required></textarea>
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
</form>

<div id="commentsContainer" class="comments mt-4 container">
        <!-- Comments will be loaded here dynamically -->
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            // Function to fetch comments and update comments container
            function fetchComments() {
                $.ajax({
                    type: 'GET',
                    url: 'fetchComments.php',
                    data: { post_id: <?php echo $post_id; ?> },
                    success: function(response) {
                        $('#commentsContainer').html(response);
                    }
                });
            }

            // Fetch comments when the page loads
            fetchComments();

            // Handler for submitting new comment (if you want to handle it asynchronously)
            $('#commentForm').submit(function(event) {
                event.preventDefault(); // Prevent default form submission

                var formData = $(this).serialize(); // Serialize form data

                $.ajax({
                    type: 'POST',
                    url: $(this).attr('action'),
                    data: formData,
                    success: function(response) {
                        // After successfully adding a new comment, fetch comments again to update the comments container
                        console.log("added comment");
                        fetchComments();
                    }
                });
            });
        });
    </script>
</body>

</html>