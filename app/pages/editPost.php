<?php 
session_start();
include __DIR__ . "/../core/functions.php";

$id = $_GET['id'];

?>

<?php 



$query = "select * from posts where id = :id limit 1";
$row = query_row($query, ['id'=>$id]);

if(!empty($_POST)){

  if($row){
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

    }

    if(empty($errors)){
        $new_content = removeImagesFromContent($_POST['content']);
        $new_content = removeRootFromImage($new_content);

        //save to database
        $data = [];
        $data['title']    = $_POST['title'];
        $data['content']  = $new_content;
        $data['category_id']   = $_POST['category_id'];
        $data['id']       = $id;

        $image_str = "";

        if(!empty($destination)){
          $image_str = "image = :image, ";
          $data['image'] = $destination;
        }
      
        $query = "update posts set title = :title, content = :content, $image_str category_id = :category_id where id = :id limit 1";

        query($query, $data);
        redirect('./user.php');

    }
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

  <body?>
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
                echo '<li><a href="./logout.php">Sign Out</a></li>';
            } else {
                echo '<li><a href="./login.php">Log In</a></;li>';
            }
          ?>
        </ul>
      </nav>
    </header>

    <div class="col-md-12 mx-auto">
    <form method="post" enctype="multipart/form-data">

        <h1 class="h3 mb-3 fw-normal">Edit post</h1>

        <?php if(!empty($row)):?>

            <?php if (!empty($errors)):?>
            <div class="alert alert-danger">Please fix the errors below</div>
            <?php endif;?>

            <div class="my-2">
                <label class="d-block">
                    <img class="mx-auto d-block image-preview-edit" src="<?=ROOT?>/../pages/<?=$row['image']?>" style="cursor: pointer;width: 150px;height: 150px;object-fit: cover;">
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
            <input value="<?=old_value('title', $row['title'])?>" name="title" type="text" class="form-control mb-2" id="floatingInput" placeholder="Username">
            <label for="floatingInput">Title</label>
            </div>
            <?php if(!empty($errors['title'])):?>
            <div class="text-danger"><?=$errors['title']?></div>
            <?php endif;?>

            <div class="">
        <textarea id="summernote" rows="8" name="content" id="floatingInput" placeholder="Post content" type="content" class="form-control"><?=old_value('content',addRootToImage($row['content']))?></textarea>
        </div>
        <?php if(!empty($errors['content'])):?>
        <div class="text-danger"><?=$errors['content']?></div>
        <?php endif;?>

        <div class="form-floating my-3">
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
        <label for="floatingInput">Category</label>
        </div>
        <?php if(!empty($errors['category'])):?>
        <div class="text-danger"><?=$errors['category']?></div>
        <?php endif;?>

            <a href="<?=ROOT?>/../pages/user.php">
                <button class="mt-4 btn btn-lg btn-primary" type="button">Back</button>
            </a>
            <button class="mt-4 btn btn-lg btn-primary  float-end" type="submit">Save</button>
        <?php else:?>

            <div class="alert alert-danger text-center">Record not found!</div>
        <?php endif;?>

    </form>
    </div>

</body>
</html>

