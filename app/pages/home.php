<?php
 
// Starting the session, to use and store data in session variable
session_start();

include __DIR__ . "/../core/init.php";
require __DIR__ . "/./track.php";

$id = $_GET['id'] ?? 0;

// Fetch the top 2 posts with the most views
$query = "SELECT posts.*, COUNT(tracking.page) as views FROM posts LEFT JOIN tracking ON CONCAT('/cosc360%20-%20Copy/app/pages/post.php?id=', posts.id) = tracking.page GROUP BY posts.id ORDER BY views DESC LIMIT 2";
$trending_posts = query($query);

// Fetch all the posts excluding the top 2
$query = "SELECT posts.*, COUNT(tracking.page) as views FROM posts LEFT JOIN tracking ON CONCAT('/cosc360%20-%20Copy/app/pages/post.php?id=', posts.id) = tracking.page LEFT JOIN (SELECT posts.id FROM posts LEFT JOIN tracking ON CONCAT('/cosc360%20-%20Copy/app/pages/post.php?id=', posts.id) = tracking.page GROUP BY posts.id ORDER BY COUNT(tracking.page) DESC LIMIT 2) as top_posts ON posts.id = top_posts.id WHERE top_posts.id IS NULL GROUP BY posts.id ORDER BY views DESC";
$other_posts = query($query);

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Home</title>
    <link rel="stylesheet" href="../public/assets/css/styles.css" />
    <link rel="stylesheet" href="../public/assets/css/my-slider.css"/>
    <link rel="stylesheet" href="../public/assets/css/modal.css"/>
    <link rel="stylesheet" href="../public/assets/css/modal.css"/>
    <script src="../public/assets/slider/ism/js/ism-2.2.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@docsearch/css@3">

    <link href="../public/assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    
    <style>
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }

      .b-example-divider {
        width: 100%;
        height: 3rem;
        background-color: rgba(0, 0, 0, .1);
        border: solid rgba(0, 0, 0, .15);
        border-width: 1px 0;
        box-shadow: inset 0 .5em 1.5em rgba(0, 0, 0, .1), inset 0 .125em .5em rgba(0, 0, 0, .15);
      }

      .b-example-vr {
        flex-shrink: 0;
        width: 1.5rem;
        height: 100vh;
      }

      .bi {
        vertical-align: -.125em;
        fill: currentColor;
      }

      .nav-scroller {
        position: relative;
        z-index: 2;
        height: 2.75rem;
        overflow-y: hidden;
      }

      .nav-scroller .nav {
        display: flex;
        flex-wrap: nowrap;
        padding-bottom: 1rem;
        margin-top: -1px;
        overflow-x: auto;
        text-align: center;
        white-space: nowrap;
        -webkit-overflow-scrolling: touch;
      }

      .btn-bd-primary {
        --bd-violet-bg: #712cf9;
        --bd-violet-rgb: 112.520718, 44.062154, 249.437846;

        --bs-btn-font-weight: 600;
        --bs-btn-color: var(--bs-white);
        --bs-btn-bg: var(--bd-violet-bg);
        --bs-btn-border-color: var(--bd-violet-bg);
        --bs-btn-hover-color: var(--bs-white);
        --bs-btn-hover-bg: #6528e0;
        --bs-btn-hover-border-color: #6528e0;
        --bs-btn-focus-shadow-rgb: var(--bd-violet-rgb);
        --bs-btn-active-color: var(--bs-btn-hover-color);
        --bs-btn-active-bg: #5a23c8;
        --bs-btn-active-border-color: #5a23c8;
      }

      .bd-mode-toggle {
        z-index: 1500;
      }

      .bd-mode-toggle .dropdown-menu .active .bi {
        display: block !important;
      }
      
    </style>

    <!-- Custom styles for this template -->
    <link href="https://fonts.googleapis.com/css?family=Playfair&#43;Display:700,900&amp;display=swap" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="../public/assets/bootstrap-5.3.3-examples/bootstrap-5.3.3-examples/blog/blog.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="../pages/updatePosts.js"></script>


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
    <div class="container mx-5">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <?php echo create_breadcrumbs(); ?>
            </ol>
        </nav>
    </div>  
    <div class="ism-slider" data-image_fx="zoompan" id="my-slider">
        <ol>
            <li>
                <a href="./category.php?category=Nature">
                    <img src="../public/assets/slider/ism/image/slides/background-2276_1280.jpg">
                    <div class="ism-caption ism-caption-0">Nature</div>
                </a>
            </li>
            <li>
                <a href="./category.php?category=Science">
                    <img src="../public/assets/slider/ism/image/slides/beautiful-701678_1280.jpg">
                    <div class="ism-caption ism-caption-0">Science</div>
                </a>
            </li>
            <li>
                <a href="./category.php?category=Travel">
                    <img src="../public/assets/slider/ism/image/slides/summer-192179_1280.jpg">
                    <div class="ism-caption ism-caption-0">Travel</div>
                </a>
            </li>
            <li>
                <a href="./category.php?category=Lifestyle">
                    <img src="../public/assets/slider/ism/image/slides/city-690332_1280.jpg">
                    <div class="ism-caption ism-caption-0">Daily Life</div>
                </a>
            </li>
            <li>
                <a href="./category.php?category=Adventures">
                    <img src="../public/assets/slider/ism/image/slides/bora-bora-685303_1280.jpg">
                    <div class="ism-caption ism-caption-0">Adventures</div>
                </a>
            </li>
        </ol>
    </div>
    <section class="content">
        <h1>Keep Learning</h1>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce ut elementum lorem, eu euismod enim. Nulla sed
            vulputate sapien, quis sodales leo. Aliquam vel est massa. Etiam sodales ornare massa non ullamcorper. Morbi
            venenatis imperdiet rhoncus. Cras vulputate ligula eu leo tincidunt, quis sodales lectus scelerisque. In
            laoreet, arcu et varius blandit, sem ex hendrerit libero, vel hendrerit tellus quam id quam.</p>
            <?php
            // Check if the user is not logged in
            if (!isset($_SESSION['username'])) {
                echo '<a href="../pages/login.php"><button class="CTA">Get Started</button></a>';
            }
            ?>    
        <?php
            // Fetch categories from the database
            $query = "SELECT category FROM categories";
            $categories = query($query);
        ?>
        
        <form action="" method="GET" class="form-inline my-2 my-lg-0">
            <input class="form-control mr-sm-2" type="text" name="search" placeholder="Search posts..." aria-label="Search">
            <select class=" form-control-sm  mt-2" name="category">
                <option value="" selected>All Categories</option>
                <?php
                    foreach ($categories as $category) {
                        echo '<option value="' . $category['category'] . '">' . $category['category'] . '</option>';
                    }
                ?>
            </select>
            <button class="btn btn-outline-primary mt-3 my-2 my-sm-0" type="submit">Search</button>
        </form>
    </section>

    <section>
        <h3 class="pt-5 pl-5 pb-0 ">Trending</h3>

        <div id="posts-section" class="d-flex flex-wrap justify-content-between p-5">
            <?php
            if ($trending_posts) {
                foreach ($trending_posts as $row) {
                    include __DIR__ . '/others/post-card.php';
                }
            } else {
                echo "No posts found";
            }
            ?>
        </div>
        
        <h3 class="pt-5 pl-5 pb-0 ">Blogs</h3>
        
        <div id="all-posts-section" class="d-flex flex-wrap justify-content-between p-5">
            <?php 
                $searchTerm = $_GET['search'] ?? '';
                $category = $_GET['category'] ?? '';

                $query = "SELECT posts.*, categories.category FROM posts JOIN categories ON posts.category_id = categories.id";

                $params = [];
                if ($searchTerm !== '' && $category !== '') {
                    $query .= " WHERE posts.title LIKE :searchTerm AND categories.category = :category";
                    $params['searchTerm'] = '%' . $searchTerm . '%';
                    $params['category'] = $category;
                } elseif ($searchTerm !== '') {
                    $query .= " WHERE posts.title LIKE :searchTerm";
                    $params['searchTerm'] = '%' . $searchTerm . '%';
                } elseif ($category !== '') {
                    $query .= " WHERE categories.category = :category";
                    $params['category'] = $category;
                }

                $query .= " ORDER BY id DESC";

                $rows = query($query, $params);
                if ($rows) {
                    foreach ($rows as $row) {
                        include __DIR__ . '/others/post-card.php';
                    }
                } else {
                    echo "No posts found";
                }
            ?>
        </div>
        

        <div class="line"></div>

        <!-- The Modal -->
        <div id="myModal" class="modal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Confirmation</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure you want to sign out?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="cancel-logout" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                        <a href="../pages/logout.php" id="confirm-logout" class="btn btn-primary">Yes</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
        
    <script>
    // Get the modal
    var modal = document.getElementById("myModal");
    
    // Get the button that opens the modal
    var btn = document.getElementById("sign-out-button");
    
    // Get the <span> element that closes the modal
    var span = document.getElementsByClassName("btn-close")[0];
    
    // Get the confirm and cancel buttons
    var confirmBtn = document.getElementById("confirm-logout");
    var cancelBtn = document.getElementById("cancel-logout");
    
    // When the user clicks the button, open the modal 
    btn.onclick = function(event) {
        event.preventDefault();
        modal.style.display = "block";
    }
    
    // When the user clicks on <span> (x), close the modal
    span.onclick = function() {
        modal.style.display = "none";
    }
    
    // When the user clicks on confirm, redirect to logout page
    confirmBtn.onclick = function() {
        window.location.href = "../pages/logout.php";
    }
    
    // When the user clicks on cancel, close the modal
    cancelBtn.onclick = function() {
        modal.style.display = "none";
    }
    
    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
    </script>

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

    <script>
    document.querySelectorAll('.read-more').forEach(function(button) {
        button.addEventListener('click', function() {
            var content = document.querySelector(button.getAttribute('data-target'));
            if(content.classList.contains('show')) {
                content.classList.remove('show');
                content.classList.add('collapse');
            } else {
                content.classList.remove('collapse');
                content.classList.add('show');
            }
        });
    });
    </script>

</body>

</html>