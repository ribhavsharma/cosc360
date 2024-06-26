<?php
   // session_start();
   include __DIR__ . "/../core/functions.php";
   include __DIR__ . "/./track.php";

   if(!empty($_POST)){
      //Signup form validation 
      $errors = [];

      if(empty($_POST['username'])){
         $errors['username'] = "A username must be provided";
      }else if(!preg_match("/^[a-zA-Z]+$/", $_POST['username'])){
         $errors['username'] = "A username can only have letters and no spaces";
      }

      $query = "select id from users where email = :email limit 1";
      $email = query($query, ['email' => $_POST['email']]);
      if(empty($_POST['email'])){
         $errors['email'] = "An email is required";
      }else if(!filter_var($_POST['email'],FILTER_VALIDATE_EMAIL)){
         $errors['email'] = "Email provided is not valid";
      }else if($email){
         $errors['email'] = "Email already in use";
      }

      if(empty($_POST['password'])){
         $errors['password'] = "A password is required";
      }else if(strlen($_POST['password']) < 8){
         $errors['password'] = "A password must be at least 8 characters or more";
      }

      if(empty($errors)){
         //save to database
         $data = [];
         $data['username'] = $_POST['username'];
         $data['email'] = $_POST['email'];
         $data['role'] = "user";
         $data['password'] = password_hash($_POST['password'], PASSWORD_DEFAULT);
         $query = "insert into users (username,email,password,role) values (:username,:email,:password,:role)";
         query($query, $data);
         $_SESSION['username'] = $data['username'];
         redirect('../pages/home.php');
      }
   }

   // Login form validation 
   if(!empty($_POST)){
      $errorsLogin = [];

      $query = "select * from users where email = :email limit 1";
      $result = query($query, ['email'=>$_POST['email']]);

      if($result){
         $data = [];
         if(password_verify($_POST['password'], $result[0]['password'])){
            //grant access
            authenticate($result[0]);
            $_SESSION['username'] = $result[0]['username'];
            // Check if the user is an admin
            if ($result[0]['role'] === 'admin') {
               // If the user is an admin, redirect to the admin page
               redirect('../pages/admin.php');
            } else {
                  // If the user is not an admin, redirect to the home page
                  redirect('../pages/home.php');
            }
         }else{
            $errorsLogin['email'] = "wrong email or password";
         }
      }else{
         $errorsLogin['email'] = "wrong email or password";
      }
   }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="../public/assets/css/login.css" />
    <link rel="stylesheet" href="../public/assets/bootstrap/css/bootstrap.min.css" />

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
            <a class="logo" href="./home.php">Grasp</a>
            <ul class="nav-links">  
                <li><a href="./home.php">Blogs</a></li>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <li><a href="./write.php">Write Blog</a></li>
                <?php endif; ?>
                <!-- <a class="circle" href="./user"></a>
                <li><a href="./user">Om Mistry</a></li> -->
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

    <div class="wrapper">
        <div class="card-switch">
            <label class="switch">
               <input type="checkbox" class="toggle">
               <span class="slider"></span>
               <span class="card-side"></span>
               <div class="flip-card__inner">
                  <div class="flip-card__front">
                     <div class="title">Log in</div>
                     <form class="flip-card__form" method="POST">

                        <?php if (!empty($errorsLogin['email'])):?>
                           <div class="alert alert-danger"><?=$errorsLogin['email']?></div>
                        <?php endif;?>

                        <input value="<?=oldValue('email')?>" class="flip-card__input" name="email" placeholder="Email" type="email">
                        <input value="<?=oldValue('password')?>" class="flip-card__input" name="password" placeholder="Password" type="password">
                        <button class="flip-card__btn" type="submit">Let`s go!</button>
                     </form>
                  </div>
                  <div class="flip-card__back">
                     <div class="title">Sign up</div>
                     <form class="flip-card__form"  method="POST">
                        <?php if(!empty($errors)):?>
                           <div class="alert alert-danger">Please fix the errors below</div>
                        <?php endif;?>
                        <input value="<?=oldValue('username')?>" class="flip-card__input" name="username" placeholder="Username" type="text">
                        <?php if(!empty($errors['username'])):?>
                           <div class="text-danger"><?=$errors['username']?></div>
                        <?php endif;?>
                        
                        <input value="<?=oldValue('email')?>" class="flip-card__input" name="email" placeholder="Email" type="email">
                        <?php if(!empty($errors['email'])):?>
                           <div class="text-danger"><?=$errors['email']?></div>
                        <?php endif;?>

                        <input value="<?=oldValue('password')?>" class="flip-card__input" name="password" placeholder="Password" type="password">
                        <?php if(!empty($errors['password'])):?>
                           <div class="text-danger"><?=$errors['password']?></div>
                        <?php endif;?>

                        <button class="flip-card__btn" type="submit">Sign up</button>
                     </form>
                  </div>
               </div>
            </label>
        </div>   
   </div>
</body>
</html>