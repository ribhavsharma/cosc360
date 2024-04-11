<?php 
include __DIR__ . "/../core/functions.php";
require __DIR__ . "/./track.php";
// session_start();

$username = $_SESSION['username'];
$query = "select * from users where username = :username";
$user = queryRow($query, ['username' => $username]);

$query1 = "select * from posts WHERE user_id = :user_id ORDER BY date DESC"; 
$posts = query($query1, ['user_id' => $user['id']]);

$queryPostCountByDate = "SELECT posts.date, posts.title, COUNT(*) as post_count FROM posts WHERE user_id = :user_id GROUP BY date, title ORDER BY date DESC";
$postCountByDate = query($queryPostCountByDate, ['user_id' => $user['id']]);

$queryCommentCountByDate = "SELECT comments.date, posts.title, COUNT(*) as comment_count FROM comments JOIN posts ON comments.post_id = posts.id WHERE comments.user_id = :user_id GROUP BY date, title ORDER BY date DESC";
$commentCountByDate = query($queryCommentCountByDate, ['user_id' => $user['id']]);

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" 	content="width=device-width, initial-scale=1.0">
	<title>User page</title>
	<link rel="stylesheet" href="../public/assets/css/user.css">
	<link href="../public/assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="../public/assets/css/bootstrap-icons.css" rel="stylesheet">

	<style>
		.breadcrumb {
			background-color: #f8f9fa; 
			border-radius: .25rem; 
			border: 1px solid #ddd; 
			box-shadow: 0 0.25rem 0.75rem rgba(0, 0, 0, .05); 
			padding: 0.75rem 1rem; 
		}

		.breadcrumb a {
			color: #007bff; 
		}

		.breadcrumb .active {
			color: #6c757d; 
		}

		.user-links li {
			margin-bottom: 10px;
		}

		.user-stats h3 {
			margin-bottom: 20px;
		}

		.vertical-line {
			border-left: 1px solid #ccc;
			height: 100%;
		}

		.profile {
			display: flex;
			align-items: center;
			justify-content: center;
			flex-direction: column;
			padding: 20px;
			text-align: center;
		}

		.circle {
			width: 150px;
			height: 150px;
			background-color: #ccc;
			border-radius: 50%;
			margin-bottom: 20px;
		}

		.name-and-edit {
			margin-bottom: 20px;
		}
	</style>
</head>
<body>
<header>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container-fluid">
                <a class="navbar-brand" href="../pages/home.php">Grasp</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                    <a class="nav-link" href="../pages/home.php">Blogs</a>
                    </li>
                    <?php
                    if (isset($_SESSION['username'])) {
                    $query = 'select role from users where username = :username limit 1';
                    $user = queryRow($query, ['username' => $_SESSION['username']]);
                    ?>
                    <li class="nav-item">
                        <a class="nav-link" href="../pages/user.php"><?php echo $_SESSION['username']; ?></a>
                    </li>
                    <?php
                    if ($user['role'] == 'admin') {
                        echo '<li class="nav-item"><a class="nav-link" href="../pages/admin.php">Admin</a></li>';
                    }
                    echo '<li class="nav-item"><a class="nav-link" href="../pages/write.php">Write Blog</a></li>';
                    echo '<li class="nav-item"><a id="sign-out-button" class="nav-link" href="../pages/logout.php">Sign Out</a></li>';
                    } else {
                    echo '<li class="nav-item"><a class="nav-link" href="../pages/login.php">Log In</a></li>';
                    }
                    ?>
                </ul>
                </div>
            </div>
        </nav>
    </header>

	<div class="container my-5">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <?php echo create_breadcrumbs(); ?>
            </ol>
        </nav>
    </div>  

	<div class="user-page">
			<div class="user-and-articles">
				<div class="user">
					<?php echo '<h1>'.$_SESSION['username'].'\'s Blogs</h1>'?>
					<ul class="user-links">
						<li><a href="#">Home</a></li>
						<li><a href="#">About</a></li>
					</ul>
				</div>
				<hr>
				<div class="articles row">
					<?php foreach($posts as $post): ?>
						<div class="col-md-6 col-lg-4 mb-4">
							<div class="card">
								<img src="<?=ROOT?>/../pages/<?=$post['image']?>" class="card-img-top" alt="...">
								<div class="card-body">
									<h5 class="card-title"><?php echo $post['title']; ?></h5>
									<p class="card-text">
										<?php 
										$excerpt = substr($post['content'], 0, 100); 
										echo $excerpt . '...'; 
										?>
									</p>
									<p class="card-text"><small class="text-muted"><?php echo date("jS M, Y", strtotime($post['date'])); ?></small></p>
									<a href="./editPost.php?id=<?php echo $post['id']; ?>" class="btn btn-primary">Edit</a>
									<a href="./deletePost.php?id=<?php echo $post['id']; ?>" class="btn btn-danger">Delete</a>
								</div>
							</div>
						</div>
					<?php endforeach; ?>
				</div>
				<div class="user-stats pt-4">
					<?php echo '<h3 class="p-2">'.$_SESSION['username'].'\'s Post and Comment History</h3>'?>
					<table class="table table-striped table-hover table-bordered">
						<thead class="table-dark">
							<tr>
								<th scope="col">Date</th>
								<th scope="col">Post Title</th>
								<th scope="col">Posts</th>
								<th scope="col">Comments</th>
							</tr>
						</thead>
						<tbody>
							<?php
							$dates = array_merge(array_column($postCountByDate, 'date'), array_column($commentCountByDate, 'date'));
							$dates = array_unique($dates);

							foreach($dates as $date) {
								$postCount = 0;
								$postTitle = '';
								foreach($postCountByDate as $post) {
									if ($post['date'] == $date) {
										$postCount = $post['post_count'];
										$postTitle = $post['title'];
										break;
									}
								}
								$commentCount = 0;
								$commentPostTitle = '';
								foreach($commentCountByDate as $comment) {
									if ($comment['date'] == $date) {
										$commentCount = $comment['comment_count'];
										$commentPostTitle = $comment['title'];
										break;
									}
								}
								echo "<tr>";
								echo "<td>" . date("jS M, Y", strtotime($date)) . "</td>";
								echo "<td>$postTitle / $commentPostTitle</td>";
								echo "<td>$postCount</td>";
								echo "<td>$commentCount</td>";
								echo "</tr>";
							}
							?>
						</tbody>
					</table>
				</div>
			</div>
			<div class="vertical-line"></div>
			<div class="profile">
				<a class="circle" href="#"></a>
				<div class="name-and-edit">
					<?php echo '<h3>'.$_SESSION['username'].'</h3>'?>
					<a href="#">Edit profile</a>
				</div>
			</div>
	</div>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="../public/assets/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script>
        // Ensure Bootstrap JS and jQuery are included before this script
        $(document).ready(function () {
        // Initialize Bootstrap collapse plugin
        $('.navbar-nav .nav-link').on('click', function () {
            $('.navbar-collapse').collapse('hide');
        });
        });
    </script>

</body>
</html>