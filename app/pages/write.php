<?php
require "../core/init.php";
require __DIR__ . "/./track.php";
// session_start();   
//fetching the user's id from the database
$query = "select id from users where username = :username limit 1";
$user = queryRow($query, ['username' => $_SESSION['username']]);

if(!empty($_POST)){
  $errors = [];

  if(empty($_POST['title'])){
      $errors['title'] = "A title is required";
  }

  if(empty($_POST['category_id'])){
      $errors['category_id'] = "A category is required";
  }

  //validate image
  $allowed = ['image/jpeg','image/png','image/webp'];
  if(!empty($_FILES['image']['name'])){
      $destination = "";
      if(!in_array($_FILES['image']['type'], $allowed)){
          $errors['image'] = "Image format not supported";
      }else{
          $folder = "uploads/";
          if(!file_exists($folder)){
              mkdir($folder, 0777, true);
          }

          $destination = $folder . time() . $_FILES['image']['name'];
          move_uploaded_file($_FILES['image']['tmp_name'], $destination);
          resizeImage($destination);
      }

  }else{
      $errors['image'] = "A featured image is required";
  }

  $slug = strToUrl($_POST['title']);

  $query = "select id from posts where slug = :slug limit 1";
  $slug_row = query($query, ['slug'=>$slug]); 

  if($slug_row){
      $slug .= rand(1000,9999);
  }


  if(empty($errors)){
      $new_content = removeImagesFromContent($_POST['content']);
      
      //save to database
      $data = [];
      $data['title']        = $_POST['title'];
      $data['content']      = $new_content;
      $data['category_id']  = $_POST['category_id'];
      $data['slug']         = $slug;
      $data['user_id']      = $user['id'];

      $query = "insert into posts (title,content,slug,category_id,user_id) values (:title,:content,:slug,:category_id,:user_id)";
      
      if(!empty($destination)){
        $data['image']     = $destination;
        $query = "insert into posts (title,content,slug,category_id,user_id,image) values (:title,:content,:slug,:category_id,:user_id,:image)";
      }

      query($query, $data);

      redirect('./home.php');

  }
}
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8" />
    <title>Home</title>
    <link rel="stylesheet" href="../public/assets/css/write.css" />
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
      integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"
      crossorigin="anonymous"
    />
    <link rel="stylesheet" href="../public/assets/css/modal.css" />

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
          <li><a href="./write.php">Write Blog</a></li>
          <?php
            if (isset($_SESSION['username'])) {
                echo '<a class="circle" href="./user.php"></a>';
                echo '<li><a href="./user.php">' . $_SESSION['username'] .'</a></li>';
                echo '<li><a id="sign-out-button" href="./logout.php">Sign Out</a></li>';
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
    <section class="content">
      <h1>Write</h1>
      <p>
        Start writing your own blog post and make it available to others easily !! 
      </p>
    </section>

    <section class="editor">
      <form id="post-blog-form" method="POST" enctype="multipart/form-data">
        <?php if (!empty($errors)):?>
        <div class="alert alert-danger">Please fix the errors below</div>
        <?php endif;?>  
        <div class="my-2">
          Featured Image:<br>
          <label class="d-block">
            <img class="mx-auto d-block image-preview-edit" src="<?=getImage('')?>" style="cursor: pointer;width: 150px;height: 150px;object-fit: cover;">
            <input onchange="displayImageEdit(this.files[0])" type="file" name="image" class="d-none">
          </label>
          <?php if(!empty($errors['image'])):?>
            <div class="text-danger"><?=$errors['image']?></div>
          <?php endif;?>

          <script>
              function displayImageEdit(file){
                  document.querySelector(".image-preview-edit").src = URL.createObjectURL(file);
              }
          </script>
        </div>
        <div class="form-floating">
          <input value="<?=oldValue('title')?>" name="title" type="text" class="form-control mb-2" id="floatingInput" placeholder="Title">
          <label for="floatingInput">Title</label>
        </div>
        <?php if(!empty($errors['title'])):?>
        <div class="text-danger"><?=$errors['title']?></div>
        <?php endif;?>
        <textarea id="summernote" rows="8" name="content" id="floatingInput" placeholder="Post content" type="content" class="form-control"><?=oldValue('content')?></textarea>
        <?php if(!empty($errors['content'])):?>
        <div class="text-danger"><?=$errors['content']?></div>
        <?php endif;?>
        <select name="category_id" class="form-select">

          <?php  
            $query = "select * from categories order by id desc";
            $categories = query($query);
          ?>
          <option value="">--Select--</option>
          <?php if(!empty($categories)):?>
              <?php foreach($categories as $cat):?>
                  <option value="<?=$cat['id']?>"><?=$cat['category']?></option>
              <?php endforeach;?>
          <?php endif;?>

        </select>
        <?php if(!empty($errors['category'])):?>
        <div class="text-danger"><?=$errors['category']?></div>
        <?php endif;?>

        <div class="actions">
          <button id="post-blog-button" type="submit">Post Blog</button>
          <a href="#">Preview</a>
        </div>
      </form>

       <!-- The Modal -->
       <div id="myModal" class="modal">
            <div class="modal-content">
                <span class="close">&times;</span>
                <p>Are you sure you want to sign out?</p>
                <button id="confirm-logout">Yes</button>
                <button id="cancel-logout">No</button>
            </div>
        </div>

        <div id="overlay" class="modal">
          <div class="modal-content">
            <span class="close close-post">&times;</span>
            <p>Are you sure you want to post this blog?</p>
            <button id="confirm-post">Yes</button>
            <button id="cancel-post">No</button>
          </div>
        </div>

    </section>
        
    <script>
        // Get the modal
        var modal = document.getElementById("myModal");
        
        // Get the elements that open, close, confirm and cancel the modal
        var btn = document.getElementById("sign-out-button");
        var span = document.getElementsByClassName("close")[0];
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

        // When the user clicks the "Post Blog" button, show the overlay
        var postBlogBtn = document.getElementById("post-blog-button");
        var postBlogForm = document.getElementById("post-blog-form");
        postBlogBtn.addEventListener("click", function(event) {
          event.preventDefault();
          document.getElementById("overlay").style.display = "block";
        });
        
        // When the user confirms the action in the overlay, submit the form
        var confirmPostBtn = document.getElementById("confirm-post");
        confirmPostBtn.addEventListener("click", function() {
          postBlogForm.submit();
        });

        // When the user clicks on cancel, close the overlay
        var cancelPostBtn = document.getElementById("cancel-post");
        cancelPostBtn.onclick = function() {
          document.getElementById("overlay").style.display = "none";
        };

        // When the user clicks on <span> (x), close the overlay
        var spanPost = document.getElementsByClassName("close-post")[0];
        spanPost.onclick = function() {
          document.getElementById("overlay").style.display = "none";
        };
    </script>
  </body>
</html>