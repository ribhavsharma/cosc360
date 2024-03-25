<?php
require "../core/init.php";
session_start();   
//fetching the user's id from the database
$query = "select id from users where username = :username limit 1";
$user = query_row($query, ['username' => $_SESSION['username']]);

if(!empty($_POST)){
  //validate
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
          resize_image($destination);
      }

  }else{
      $errors['image'] = "A featured image is required";
  }

  $slug = str_to_url($_POST['title']);

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
  </head>

  <body>
    <header>
      <nav>
        <a class="logo" href="./">Logo</a>
        <ul class="nav-links">
          <li><a href="./">Blogs</a></li>
          <li><a href="./write.php">Write Blog</a></li>
          <?php
            if (isset($_SESSION['username'])) {
                echo '<a class="circle" href="./user.php"></a>';
                echo '<li><a href="./user.php">' . $_SESSION['username'] .'</a></li>';
                echo '<li><a href="./logout.php">Sign Out</a></li>';
            } else {
                echo '<li><a href="./login.php">Log In</a></;li>';
            }
          ?>
        </ul>
      </nav>
    </header>
    <section class="content">
      <h1>Write</h1>
      <p>
        Start writing your own blog post and make it available to others easily !! 
      </p>
    </section>

    <section class="editor">
      <form method="POST" enctype="multipart/form-data">
        <?php if (!empty($errors)):?>
        <div class="alert alert-danger">Please fix the errors below</div>
        <?php endif;?>  
        <div class="my-2">
          Featured Image:<br>
          <label class="d-block">
            <img class="mx-auto d-block image-preview-edit" src="<?=get_image('')?>" style="cursor: pointer;width: 150px;height: 150px;object-fit: cover;">
            <input onchange="display_image_edit(this.files[0])" type="file" name="image" class="d-none">
          </label>
          <?php if(!empty($errors['image'])):?>
            <div class="text-danger"><?=$errors['image']?></div>
          <?php endif;?>

          <script>
              function display_image_edit(file){
                  document.querySelector(".image-preview-edit").src = URL.createObjectURL(file);
              }
          </script>
        </div>
        <div class="form-floating">
          <input value="<?=old_value('title')?>" name="title" type="text" class="form-control mb-2" id="floatingInput" placeholder="Title">
          <label for="floatingInput">Title</label>
        </div>
        <?php if(!empty($errors['title'])):?>
        <div class="text-danger"><?=$errors['title']?></div>
        <?php endif;?>
        <textarea id="summernote" rows="8" name="content" id="floatingInput" placeholder="Post content" type="content" class="form-control"><?=old_value('content')?></textarea>
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
          <button type="submit">Post Blog</button>
          <a href="#">Preview</a>
        </div>
      </form>
    </section>
  </body>
</html>
