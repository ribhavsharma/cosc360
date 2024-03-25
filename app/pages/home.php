<?php
 
// Starting the session, to use and
// store data in session variable
session_start();

include __DIR__ . "/../core/init.php";

$id = $_GET['id'] ?? 0;

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Home</title>
    <link rel="stylesheet" href="../public/assets/css/styles.css" />
    <link rel="stylesheet" href="../public/assets/css/my-slider.css"/>
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
</head>

<body>
    <header>
        <nav>
            <a class="logo" href="./">Logo</a>
            <?php 
                if(isset($_SESSION['username'])){
                    $query = 'select role from users where username = :username limit 1';
                    $user = query_row($query, ['username' => $_SESSION['username']]);
                }
            ?>
            <ul class="nav-links">
                <li><a href="./">Blogs</a></li>
                <?php
                
                if (isset($_SESSION['username'])) {     
                    echo '<a class="circle" href="../pages/user.php"></a>';
                    echo '<li><a href="../pages/user.php">' . $_SESSION['username'] .'</a></li>';
                    if($user['role'] == 'admin') {
                        echo '<li><a href="../pages/admin.php">Admin</a></li>';
                    }
                    echo '<li><a href="../pages/write.php">Write Blog</a></li>';
                    echo '<li><a href="../pages/logout.php">Sign Out</a></li>';
                } else {
                    echo '<li><a href="../pages/login.php">Log In</a></;li>';
                }
                ?>
            </ul>
        </nav>
    </header>
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
    </section>

    <section>
        <h3 class="pt-5 pl-5 pb-0 ">Trending</h3>
        <!-- <a class="text-show" href="#">Show all</a> -->

        <!-- <div class="blogs">
            <div class="card">
                <div class="circle-text">
                    <div class="circle-and-name">
                        <div class="circle-1"></div>
                        <p>John Doe</p>
                    </div>
                    <p class="card-content">Sed dictum, massa in pharetra pellentesque, libero leo venenatis tellus.</p>
                    <div class="card-footer ">
                        <p>Feb 4</p><p>8 min read</p>
                    </div>
                </div>
            </div>
            
            <div class="card">
                <div class="circle-text">
                    <div class="circle-and-name">
                        <div class="circle-1"></div>
                        <p>John Doe</p>
                    </div>
                    <p class="card-content">Sed dictum, massa in pharetra pellentesque, libero leo venenatis tellus.</p>
                    <div class="card-footer">
                        <p>Feb 4</p><p>8 min read</p>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="circle-text">
                    <div class="circle-and-name">
                        <div class="circle-1"></div>
                        <p>John Doe</p>
                    </div>
                    <p class="card-content">Sed dictum, massa in pharetra pellentesque, libero leo venenatis tellus.</p>
                    <div class="card-footer">
                        <p>Feb 4</p><p>8 min read</p>
                    </div>
                </div>
            </div>
        </div> -->

        <!-- <div class="line"></div> -->
        
        <div id="posts-section" class="row mb-2 p-5">
            <?php 
                
                $query = "select posts.*, categories.category from posts join categories on posts.category_id = categories.id order by id desc";
                $rows = query($query);
                if($rows){
                    foreach($rows as $row){
                        include __DIR__ . '/others/post-card.php';
                    }
                }else{
                    echo "No posts found";
                }
            ?>
        </div>
        
        
        <!-- <div class="blogs">
            <div class="card">
                <div class="circle-text">
                    <div class="circle-and-name">
                        <div class="circle-1"></div>
                        <p>John Doe</p>
                    </div>
                    <p class="card-content">Sed dictum, massa in pharetra pellentesque, libero leo venenatis tellus.</p>
                    <div class="card-footer">
                        <p>Feb 4</p><p>8 min read</p>
                    </div>
                </div>
            </div>
            
            <div class="card">
                <div class="circle-text">
                    <div class="circle-and-name">
                        <div class="circle-1"></div>
                        <p>John Doe</p>
                    </div>
                    <p class="card-content">Sed dictum, massa in pharetra pellentesque, libero leo venenatis tellus.</p>
                    <div class="card-footer">
                        <p>Feb 4</p><p>8 min read</p>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="circle-text">
                    <div class="circle-and-name">
                        <div class="circle-1"></div>
                        <p>John Doe</p>
                    </div>
                    <p class="card-content">Sed dictum, massa in pharetra pellentesque, libero leo venenatis tellus.</p>
                    <div class="card-footer">
                        <p>Feb 4</p><p>8 min read</p>
                    </div>
                </div>
            </div>
        </div> -->

        <div class="line"></div>

        <div class="box">
            <article class="info">
                <div class="article-card">
                    <a class="circle-1" href="#"></a>
                    <p>Shariar Shahrabi</p>
                </div>
                <p class="info-text">Designing for Apple Vision Pro: Lessons Learned from Puzzling Places</p>
                <p class="info-text-2">The Apple Vision Pro presents new design challenges to consider.
                    Here are some of the lessons learned from redesigning Puzzling…</p>
                <div class="info-footer">
                    <p>Feb 5</p><p>13 min read</p><p class="type">Category</p>
                </div>
            </article>
            <img src="../public/assets/images/placeholder2.jpg">
        </div>
        
        <div class="box">
            <article class="info">
                <div class="article-card">
                    <a class="circle-1" href="#"></a>
                    <p>Shariar Shahrabi</p>
                </div>
                <p class="info-text">Designing for Apple Vision Pro: Lessons Learned from Puzzling Places</p>
                <p class="info-text-2">The Apple Vision Pro presents new design challenges to consider.
                    Here are some of the lessons learned from redesigning Puzzling…</p>
                <div class="info-footer">
                    <p>Feb 5</p><p>13 min read</p><p class="type">Category</p>
                </div>
            </article>
            <img src="../public/assets/images/placeholder.jpg">
        </div>
        
        <div class="box">
            <article class="info">
                <div class="article-card">
                    <a class="circle-1" href="#"></a>
                    <p>Shariar Shahrabi</p>
                </div>
                <p class="info-text">Designing for Apple Vision Pro: Lessons Learned from Puzzling Places</p>
                <p class="info-text-2">The Apple Vision Pro presents new design challenges to consider.
                    Here are some of the lessons learned from redesigning Puzzling…</p>
                <div class="info-footer">
                    <p>Feb 5</p><p>13 min read</p><p class="type">Category</p>
                </div>
            </article>
            <img src="../public/assets/images/placeholder.jpg">
        </div>

        <div class="box">
            <article class="info">
                <div class="article-card">
                    <a class="circle-1" href="#"></a>
                    <p>Shariar Shahrabi</p>
                </div>
                <p class="info-text">Designing for Apple Vision Pro: Lessons Learned from Puzzling Places</p>
                <p class="info-text-2">The Apple Vision Pro presents new design challenges to consider.
                    Here are some of the lessons learned from redesigning Puzzling…</p>
                <div class="info-footer">
                    <p>Feb 5</p><p>13 min read</p><p class="type">Category</p>
                </div>
            </article>
            <img src="../public/assets/images/placeholder.jpg">
        </div>

        <div class="aside">
            <p>Categories</p>
            <div class="categories">
                <a href="#" class="category">Programming</a>
                <a href="#" class="category">Data Science</a>
                <a href="#" class="category">Technology</a>
                <a href="#" class="category">Self Improvement</a>
                <a href="#" class="category">Writing</a>
                <a href="#" class="category">Relationships</a>
                <a href="#" class="category">Machine Learning</a>
                <a href="#" class="category">Productivity</a>
                <a href="#" class="category">Politics</a>
            </div>
            <button class="see-more">See More Topics</button>
        </div>
          
    </section>

</body>

</html>