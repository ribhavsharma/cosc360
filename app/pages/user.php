<?php 
include __DIR__ . "/../core/functions.php";
require __DIR__ . "/./track.php";
// session_start();

$username = $_SESSION['username'];
$query = "select * from users where username = :username";
$user = queryRow($query, ['username' => $username]);

$query1 = "select * from posts WHERE user_id = :user_id ORDER BY date DESC"; 
$posts = query($query1, ['user_id' => $user['id']]);

// $query2 = "select category from categories where id = :id";
// $categories = query($query2, ['id' => $posts['category_id']]);

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" 	content="width=device-width, initial-scale=1.0">
	<title>User page</title>
	<link rel="stylesheet" href="../public/assets/css/user.css">
	<!-- <link href="../public/assets/bootstrap/css/bootstrap.min.css" rel="stylesheet"> -->
    <!-- <link href="../public/assets/css/bootstrap-icons.css" rel="stylesheet"> -->

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
			<nav>
				<a class="logo" href="./home.php">Logo</a>
				<ul class="nav-links">
					<li><a href="./home.php">Blogs</a></li>
					<li><a href="../pages/write.php">Write Blog</a></li>
					<?php
					if (isset($_SESSION['username'])) {
						echo '<a class="circle" href="../pages/user.php"></a>';
						echo '<li><a href="../pages/user.php">' . $_SESSION['username'] .'</a></li>';
						echo '<li><a href="../pages/logout.php">Sign Out</a></li>';
					} else {
						echo '<li><a href="../pages/login.php">Log In</a></;li>';
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
				<div class="articles">
					<?php foreach($posts as $post): ?>
						<section class="article">
							<div class="text">
								<div class="name">
									<a href="#"></a>
									<?php echo '<h5>'.$_SESSION['username'].'</h5>'?>
								</div>
								<article>
									<h2><?php echo $post['title']; ?></h2>
									<p>
										<?php echo $post['content']; ?>
									</p>
								</article>
								<div class="info">
									<ul>
										<li><?php echo date("jS M, Y", strtotime($post['date'])); ?></li>
										<!-- <?php foreach($categories as $category): ?>
											<li><?php echo $category['category']; ?></li>	
										<?php endforeach; ?> -->
									</ul>
								</div>
								<div class="post-actions">
									<a href="./editPost.php?id=<?php echo $post['id']; ?>" class="btn btn-primary">Edit</a>
									<a href="./deletePost.php?id=<?php echo $post['id']; ?>" class="btn btn-danger">Delete</a>
								</div>
							</div>
							<div class="pic">
								<img src="<?=ROOT?>/../pages/<?=$post['image']?>"/>
							</div>
						</section>
					<?php endforeach; ?>
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

</body>
</html>