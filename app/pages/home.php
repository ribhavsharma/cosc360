<?php
 
// Starting the session, to use and
// store data in session variable
session_start();
  
// If the session variable is empty, this 
// means the user is yet to login
// User will be sent to 'login.php' page
// to allow the user to login
if (!isset($_SESSION['username'])) {
    echo '<p>You have to log in first</p>';
    redirect('./login');
}
  
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Home</title>
    <link rel="stylesheet" href="../public/assets/css/styles.css" />
    <link rel="stylesheet" href="../public/assets/css/my-slider.css"/>
    <script src="../public/assets/slider/ism/js/ism-2.2.min.js"></script>

</head>

<body>
    <header>
        <nav>
            <a class="logo" href="./">Logo</a>
            <ul class="nav-links">
                <li><a href="#">Read</a></li>
                <li><a href="./write">Write</a></li>
                <?php
                
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
    <div class="ism-slider" data-image_fx="zoompan" id="my-slider">
        <ol>
            <li>
                <img src="../public/assets/slider/ism/image/slides/background-2276_1280.jpg">
                <div class="ism-caption ism-caption-0">Nature</div>
            </li>
            <li>
                <img src="../public/assets/slider/ism/image/slides/beautiful-701678_1280.jpg">
                <div class="ism-caption ism-caption-0">Science</div>
            </li>
            <li>
                <img src="../public/assets/slider/ism/image/slides/summer-192179_1280.jpg">
                <div class="ism-caption ism-caption-0">Travel</div>
            </li>
            <li>
                <img src="../public/assets/slider/ism/image/slides/city-690332_1280.jpg">
                <div class="ism-caption ism-caption-0">Daily Life</div>
            </li>
            <li>
                <img src="../public/assets/slider/ism/image/slides/bora-bora-685303_1280.jpg">
                <div class="ism-caption ism-caption-0">Adventures</div>
            </li>
        </ol>
    </div>
    <section class="content">
        <h1>Keep Learning</h1>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce ut elementum lorem, eu euismod enim. Nulla sed
            vulputate sapien, quis sodales leo. Aliquam vel est massa. Etiam sodales ornare massa non ullamcorper. Morbi
            venenatis imperdiet rhoncus. Cras vulputate ligula eu leo tincidunt, quis sodales lectus scelerisque. In
            laoreet, arcu et varius blandit, sem ex hendrerit libero, vel hendrerit tellus quam id quam.</p>
        <button class="CTA" onclick="window.location.href='./login'">Get Started</button>
    </section>

    <section>
        <h3>Trending</h3>
        <a class="text-show" href="#">Show all</a>

        <div class="blogs">
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
        </div>

        <div class="line"></div>    
        
        <div class="blogs">
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
        </div>

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