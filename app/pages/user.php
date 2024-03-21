<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" 	content="width=device-width, initial-scale=1.0">
	<title>User page</title>
	<link rel="stylesheet" href="./assets/css/user.css">
</head>
<body>
	<header>
			<nav>
				<a class="logo" href="./">Logo</a>
				<ul class="nav-links">
					<li><a href="./">Read</a></li>
					<li><a href="./write">Write</a></li>
					<?php
					session_start();
					if (isset($_SESSION['username'])) {
						echo '<a class="circle" href="./user"></a>';
						echo '<li><a href="./user">' . $_SESSION['username'] .'</a></li>';
						echo '<li><a href="./logout">Sign Out</a></li>';
					} else {
						echo '<li><a href="./login">Log In</a></;li>';
					}
					?>
				</ul>
			</nav>
	</header>

	<div class="user-page">
			<div class="user-and-articles">
				<div class="user">
					<?php echo '<h1>'.$_SESSION['username'].'</h1>'?>
					<ul class="user-links">
						<li><a href="#">Home</a></li>
						<li><a href="#">About</a></li>
					</ul>
				</div>
				<hr>
				<div class="articles">
					<section class="article">
						<div class="text">
							<div class="name">
								<a href="#"></a>
								<?php echo '<h5>'.$_SESSION['username'].'</h5>'?>
							</div>
							<article>
								<h4>Designing for Apple Vision Pro: Lessons Learned from Puzzling Places</h4 >
								<p>
									The Apple Vision Pro presents new desing challenges to consider. Here are some of the lessons learned from redesigning Puzzling...
								</p>
							</article>
							<div class="info">
								<ul>
									<li>Date</li>
									<li>Read time</li>
									<li>Category</li>	
								</ul>
							</div>
						</div>
						<div class="pic">
							<img src="./assets/images/placeholder2.jpg"/>
						</div>
					</section>

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