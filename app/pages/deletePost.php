<?php 
session_start();
include __DIR__ . "/../core/functions.php";
require __DIR__ . "/./track.php";

$id = $_GET['id'];

?>

<?php 

    $query = "select * from posts where id = :id limit 1";
    $row = queryRow($query, ['id'=>$id]);

    if($_SERVER['REQUEST_METHOD'] == "POST"){
        if($row){
            $errors = [];

            if(empty($errors)){
                //delete from database
                $data = [];
                $data['id'] = $id;

                $query = "delete from posts where id = :id limit 1";
                query($query, $data);

                if(file_exists($row['image']))
                  unlink($row['image']);

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

    <div class="col-md-6 mx-auto">
  <form method="post">

    <h1 class="h3 mb-3 fw-normal">Delete post</h1>

    <?php if(!empty($row)):?>

        <?php if (!empty($errors)):?>
          <div class="alert alert-danger">Please fix the errors below</div>
        <?php endif;?>

        <div class="form-floating">
          <div class="form-control mb-2" ><?=oldValue('title', $row['title'])?></div>
        </div>
          <?php if(!empty($errors['title'])):?>
          <div class="text-danger"><?=$errors['title']?></div>
          <?php endif;?>

        <div class="form-floating">
          <div class="form-control mb-2" ><?=oldValue('slug', $row['slug'])?></div>
        </div>
          <?php if(!empty($errors['slug'])):?>
          <div class="text-danger"><?=$errors['slug']?></div>
          <?php endif;?>


        <a href="<?=ROOT?>/../pages/user.php">
            <button class="mt-4 btn btn-lg btn-primary" type="button">Back</button>
        </a>
        <button class="mt-4 btn btn-lg btn-danger  float-end" type="submit">Delete</button>
    <?php else:?>

        <div class="alert alert-danger text-center">Record not found!</div>
    <?php endif;?>

  </form>
</div>

</body>
</html>

