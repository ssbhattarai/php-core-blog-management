<?php  require_once("./include/database.php")?>
<?php  require_once("./include/functions.php")?>
<?php include_once( './include/Sessions.php'); ?>
<?php 
    global $connection;
    $aboutSuccess=  '';


?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
    integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
  </script>
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <script src="js/bootstrap.min.js"></script>
  <link rel="stylesheet" type="text/css" href="css/public.css">
  <title>About Us</title>
</head>

<body>
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo01"
        aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
        <div class="nav-header text-whilte">
          <a href="index.php" class="text-decoration-none text-white" style="argin: -6px;margin-right: 10px;">
            CMS
          </a>
        </div>
        <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
          <!-- <li class="nav-item">
            <a class="nav-link active" href="index.php">Home</a>
          </li> -->
          <li class="nav-item">
            <a class="nav-link" href="blog.php">Blog</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="contact.php">Contact</a>
          </li>
          <li class="nav-item active">
            <a class="nav-link" href="aboutus.php">About Us</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="Login.php" tabindex="-1" aria-disabled="true">Admin Site</a>
          </li>
        </ul>
        <form class="form-inline my-2 my-lg-0" action="blog.php" method="GET">
          <input class="form-control mr-sm-2" type="search" placeholder="Search Posts.." aria-label="Search" name="search">
          <button class="btn btn-outline-success my-2 my-sm-0" type="submit" name="postsearch">Search</button>
        </form>
      </div>
    </div>
  </nav>


  <div class="container">
    <div class="alert alert-dark mt-3 text-center" role="alert">
      <strong>Full PHP BLOG CMS </strong>
    </div>
    <div class="card m-5">
  
    <div class="card-header text-center">About us</div>
  <div class="card-body">
  <?php 
 $sql = "SELECT * FROM about_us ORDER BY id DESC limit 1";
 $res_data = $connection->query($sql);
         while($row = $res_data->fetch_assoc()) {
             $id = $row['id'];
             $title = $row['title'];
             $body = $row['body'];
              
  
?>
<h2><?php echo $title; ?></h2> <br>
          <?php echo $body; ?>

 <?php   }
   ?>
  </div>
</div>
  </div>


  <div id="footer">
    <!-- Footer div -->
    <hr>
    <p> | &copy; | 2020 <a href="https://sambhattarai.com.np" target="_blank">SAMBHATTARAI</a> All Right Reserved</p>
    <hr>
  </div>
</body>

</html>