<?php include_once('include/database.php');?>
<?php include_once('include/functions.php');?>
<?php 
    global $connection;
    $searchresult = "";
    
    if(isset($_GET['postsearch'])) {
        $search = mysqli_real_escape_string($connection, htmlspecialchars($_GET['search']));
        $sql = " SELECT * FROM blog WHERE
            title LIKE '%$search%' OR
            post_body LIKE '%$search%' OR
            category LIKE '%$search%' 
            AND Status=1;
        ";
        $result = array();
        $result = $connection->query($sql);
        if(mysqli_num_rows($result) <= 0){
            $searchresult = "NO Post To Show";
        }
    }elseif(isset($_GET["category"])){
      // $search = mysqli_real_escape_string($connection, htmlspecialchars($_GET['search']));
         $category = $_GET["category"];
        $sql = " SELECT * FROM blog WHERE
            category = '$category' and status=1;
        ";
        $result = array();
        $result = $connection->query($sql);
        if(mysqli_num_rows($result) <= 0){
            $searchresult = "NO Post To Show";
        }
    }else {
      $sql = "SELECT * FROM blog Where status=1 ORDER BY datetime DESC";
    }
    $result = $connection->query($sql);

    
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
  <title>Blog</title>
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
          <li class="nav-item active">
            <a class="nav-link" href="blog.php">Blog</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="contact.php">Contact</a>
          </li>
          <li class="nav-item">
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
    

    <div class="row">
      <div class="col-sm-8">
        <?php if($searchresult) { ?>
        <div class="alert alert-primary" role="alert">
          <?php  echo $searchresult; ?>
        </div>
        <?php   } ?>
        <?php   
            if(mysqli_num_rows($result) <= 0){
                $searchresult = "NO Post To Show";
            }
            while($row = $result->fetch_assoc()){
                $image= $row["image"];
  
            ?>
        <div class="card shadow p-3 mb-5 bg-dark text-light rounded">
          <img src="<?= $image ?>" class="card-img-top img-thumbnail rounded float-left" alt="...">
          <div class="card-body">
            <h5 class="card-title" style="font-weight: bold; color: #7bea42;"><?php echo htmlentities($row['title']) ?>
            </h5>
            <div class="row row-cols-1 row-cols-sm-2">
              <div class="col small-color">Category: <?php echo htmlentities($row["category"])?></div>
              <div class="col small-color">Published on: <?php echo htmlentities($row["datetime"])?></div>
            </div>
            <p class="card-text">
              <?php if(strlen($row['post_body']) > 150){
                    $post = substr($row["post_body"], 0, 150) . '...';

                    echo htmlentities($post); 
                }
                    ?>
            </p>
            <a href="FullPost.php?id=<?php echo $row["id"] ?>" class="btn btn-success">View More &rsaquo;&rsaquo;</a>
          </div>
        </div>
        <?php
            // }
            // } else {
            //     echo  "No Post To display";
            // }
            }
            ?>
      </div>


      <div class="offset-sm-1 col-sm-3">
        <div class="card border-primary text-white text-center" style="width: 15rem;">
          <div class="card-header bg-primary font-weight-bold">
            Categories
          </div>
          <?php ?>
          <ul class="list-group list-group-flush ">

            <?php 
       $sql = "SELECT category_name FROM category ORDER BY datetime DESC";
       $res_data = $connection->query($sql);
           if($res_data->num_rows > 0) {
               while($row = $res_data->fetch_assoc()) {
                   $cateogyName = $row['category_name']; ?>

            <li class="list-group-item border-primary "><a class="text-decoration-none"
                href="blog.php?category=<?php echo $cateogyName; ?>"><?php echo $cateogyName; ?></a></li>
            <?php 
                }} else {
                echo "no Category to show";
            }
                   ?>
          </ul>
          </ul>
        </div>


       <div class="card border-primary  mt-5 mb-5" style="width: 20rem;">
        <div class="card-header bg-primary font-weight-bold text-white text-center">
            Most Viwed Posts
          </div>
          <ul class="list-group list-group-flush">
            <?php 
       $sql = "SELECT * FROM blog Where status = 1 ORDER BY views DESC limit 4";
       $res_data = $connection->query($sql);
           if($res_data->num_rows > 0) {
               while($row = $res_data->fetch_assoc()) {
                   $id = $row['id'];
                   $title = $row['title'];
                   $post_body = $row['post_body'];
                   $category = $row['category'];
                   $author = $row['author'];
                   $image = $row['image'];
                   $status = $row['status'];
                    ?>
  <?php if($row['status']){ ?>
            <li class="list-group-item">
              <div class="card" style="width: 18rem;">
                <img src="<?= $image ?>" class="card-img-top" alt="post-image">
                <div class="card-body">
                  <h5 class="card-title font-weight-bold"><?php echo $title; ?></h5>
                  <p class="card-text">
                    <?php if(strlen($post_body) > 65){
                  $post_body = substr($post_body,0,65). "...";
                }
                echo $post_body;?>
                  </p>
                  <a href="FullPost.php?id=<?php echo $id; ?>" class="btn btn-primary">view More</a>
                </div>
              </div>
            </li>
            <?php 
                }}} else {
               
            
                   ?>
            <span class="text-center p-2 font-weight-bold">
              No post to show
            </span>
            <?php } ?>
          </ul>
          </ul>
        </div>


        <div class="card border-primary  mt-5 mb-5" style="width: 20rem;">
        <div class="card-header bg-primary font-weight-bold text-white text-center">
            Latest Posts
          </div>
          <ul class="list-group list-group-flush">
            <?php 
       $sql = "SELECT * FROM blog Where status = 1 ORDER BY datetime DESC limit 4";
       $res_data = $connection->query($sql);
           if($res_data->num_rows > 0) {
               while($row = $res_data->fetch_assoc()) {
                   $id = $row['id'];
                   $title = $row['title'];
                   $post_body = $row['post_body'];
                   $category = $row['category'];
                   $author = $row['author'];
                   $image = $row['image'];
                   $status = $row['status'];
                    ?>
  <?php if($row['status']){ ?>
            <li class="list-group-item">
              <div class="card" style="width: 18rem;">
                <img src="<?= $image ?>" class="card-img-top" alt="post-image">
                <div class="card-body">
                  <h5 class="card-title font-weight-bold"><?php echo $title; ?></h5>
                  <p class="card-text">
                    <?php if(strlen($post_body) > 65){
                  $post_body = substr($post_body,0,65). "...";
                }
                echo $post_body;?>
                  </p>
                  <a href="FullPost.php?id=<?php echo $id; ?>" class="btn btn-primary">view More</a>
                </div>
              </div>
            </li>
            <?php 
                }}} else {
               
            
                   ?>
            <span class="text-center p-2 font-weight-bold">
              No post to show
            </span>
            <?php } ?>
          </ul>
          </ul>
        </div>

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