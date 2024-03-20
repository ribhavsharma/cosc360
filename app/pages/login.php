<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="../public/assets/css/login.css" />
</head>

<body>   
    <header>
        <nav>
            <a class="logo" href="./">Logo</a>
            <ul class="nav-links">
                <li><a href="./">Read</a></li>
                <li><a href="./write">Write</a></li>
                <a class="circle" href="./user"></a>
                <li><a href="./user">Om Mistry</a></li>
            </ul>
        </nav>
    </header>    

    <div class="wrapper">
        <div class="card-switch">
            <label class="switch">
               <input type="checkbox" class="toggle">
               <span class="slider"></span>
               <span class="card-side"></span>
               <div class="flip-card__inner">
                  <div class="flip-card__front">
                     <div class="title">Log in</div>
                     <form class="flip-card__form" action="">
                        <input class="flip-card__input" name="email" placeholder="Email" type="email">
                        <input class="flip-card__input" name="password" placeholder="Password" type="password">
                        <button class="flip-card__btn">Let`s go!</button>
                     </form>
                  </div>
                  <div class="flip-card__back">
                     <div class="title">Sign up</div>
                     <form class="flip-card__form" action="signup.php"  method="POST">
                        <input class="flip-card__input" name="username" placeholder="Username" type="text">
                        <input class="flip-card__input" name="email" placeholder="Email" type="email">
                        <input class="flip-card__input" name="password" placeholder="Password" type="password">
                        <button class="flip-card__btn">Sign up</button>
                     </form>
                  </div>
               </div>
            </label>
        </div>   
   </div>
</body>
</html>