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
          <li><a href="./write">Write Blog</a></li>
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
    <section class="content">
      <h1>Write</h1>
      <p>
        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce ut
        elementum lorem, eu euismod enim. Nulla sed vulputate sapien, quis
        sodales leo.
      </p>
    </section>

    <section class="editor">
      <form>
        <textarea placeholder="Enter your text here"></textarea>
        <select>
          <option value="category1">Category 1</option>
          <option value="category2">Category 2</option>
          <option value="category3">Category 3</option>
          <option value="category4">Category 4</option>
        </select>
        <div class="categories">
          <a href="#" class="category">Programming</a>
          <a href="#" class="category">Data Science</a>
          <a href="#" class="category">Technology</a>
        </div>

        <div class="actions">
          <button type="submit">Post Blog</button>
          <a href="#">Preview</a>
        </div>
      </form>
    </section>
  </body>
</html>
