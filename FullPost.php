<?php include_once('include/database.php');?>
<?php include_once('include/functions.php');?>
<?php 
    global $connection;
    $searchresult = "";
    
   
    if(isset($_GET['postsearch'])) {
        $search = mysqli_real_escape_string($connection, htmlspecialchars($_GET['search']));
        $sql = " SELECT * FROM blog WHERE
            title LIKE '%$search%' OR
            datetime LIKE '%$search%' OR
            post_body LIKE '%$search%' OR
            category LIKE '%$search%' 
        ";
        $result = array();
        $result = $connection->query($sql);
        if(mysqli_num_rows($result) <= 0){
            $searchresult = "NO Post To Show";
        }
    }else {
        $idOfURL = $_GET["id"];  //getid of url
        $sql = "SELECT * FROM blog WHERE id= $idOfURL";
    }
    $result = $connection->query($sql);

?>

<?php 


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <script src="js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" href="css/public.css">
    <title>Full Post</title>
</head>


<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
<div class="container">
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
    <div class="nav-header">
            <a href="index.php" class="text-white text-decoration-none" style="argin: -6px;margin-right: 10px;">
                CMS
            </a>
    </div>
    <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
      <li class="nav-item">
        <a class="nav-link" href="index.php">Home</a>
      </li>
      <li class="nav-item active">
        <a class="nav-link" href="blog.php">Blog</a>
      </li> <li class="nav-item">
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
      <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search" name="search">
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
            // if(mysqli_num_rows($result) <= 0){
            //     $searchresult = "NO Post To Show";
            // }
            $idOfURL = $_GET["id"];  //getid of url
            $view = "UPDATE blog SET views=views + '1' WHERE id='$idOfURL'";
            $connection->query($view);

           
            while($row = $result->fetch_assoc()){
                $image= $row["image"];
    
            ?> 
    <div class="card shadow p-3 mb-5 bg-dark text-light rounded">
        <img src="<?= $image ?>" class="card-img-top img-thumbnail rounded float-left" alt="Post Image" >
        <div class="card-body">
            <h5 class="card-title" style="font-weight: bold; color: #7bea42;"><?php echo htmlentities($row['title']) ?></h5>
            <div class="row row-cols-1 row-cols-sm-2">
                <div class="col small-color">Category: <span class="text-bold"><?php echo htmlentities($row["category"])?></span></div>
                <div class="col small-color">Published on: <?php echo htmlentities($row["datetime"])?></div>
                <div class=" col small-color">  Views: <?php echo htmlentities($row["views"])?></div>

            </div>
            <br>
            <p class="card-text">
                <?php 
                echo htmlentities($row["post_body"]); ?></p>
        </div>
        </div>
        <?php } ?>
        <?php 
              $postid = $_GET["id"];
              $commentErr  = '';
              $commentSuc = '';

              if(isset($_POST["submit"])){
                  $name = $_POST["name"];
                  $email = $_POST["email"];
                  $comment = $_POST["comment"];
                  
                  // for Created Date time
                  date_default_timezone_get();
                  $current_time = time();
                  $datetime = strftime("%B-%d-%Y %H:%M:%S");
                  
                  if(empty($name) || empty($email) || empty($comment)){
                    $commentErr = "All Field is Required";
                  } else {

                    $sql = "INSERT INTO comments(datetime,name,email,comment,blog_id)
                            VALUES('$datetime','$name','$email','$comment','$postid')";

                    if($connection->query($sql)){
                      $commentSuc = "Added Comment Wait for approve your comment by admin";
                      //  redirect("FullPost?id=</$postid");
                      
                    } elseif(strlen($comment) > 500){

                        $commentErr = "Only 500 Words are allowed !!";
                      } else {
                      $commentErr = "Something Went Wrong";
                    }
                  }
              }
              $comments = "SELECT * FROM comments WHERE blog_id=$postid and status= 'Approve'";
              
              $allComments = $connection->query($comments);
        ?>
        <h4>Comments: </h4>
        <?php while($commentFetch = $allComments->fetch_assoc()){ ?>
        <div class="card" style="background:aliceblue; margin:20px">
          <div class="card-body">
          <div class="row">
            <div class="col" style="display: block; color:#3eca6f;"><img src="https://cdn4.iconfinder.com/data/icons/small-n-flat/24/user-alt-512.png" alt="" style="height:48px;">
            <?php echo $commentFetch["name"];?><br> <p style="margin-left: 50px"><?php echo $commentFetch["datetime"];?></p><p style="margin-left: 50px"><?php echo $commentFetch["comment"];?></p></div>
          </div>
           
          </div>
        </div>
        <?php } ?>

            <h4 class="form-name">ADD thoughts about this post</h4>
            <?php if($commentErr) {  ?>
              <div class="alert alert-danger" role="alert">
                <?php echo $commentErr; ?>
              </div>
          <?php } ?>

          <?php if($commentSuc) {  ?>
              <div class="alert alert-success" role="alert">
                <?php echo $commentSuc; ?>
              </div>
          <?php } ?>
        <form action="FullPost.php?id=<?php echo $postid; ?>" method="post" enctype="multipart/form-data">
        <div class="form-group">
                        <label for="Name" class="form-name">Name</label>
                        <input type="text" class="form-control" id="Name"  name="name" required>
                    </div>
                    <div class="form-group">
                        <label for="email" class="form-name">Email</label>
                        <input type="email" class="form-control" id="email" placeholder="Email" name="email" required>
                        <small id="email" class="form-text text-muted">
                          Email Must be Valid
                        </small>
                    </div>
                    <div class="form-group">
                        <label for="comment" class="form-name">Comment</label>
                        <textarea class="form-control" id="comment"  name="comment" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-success btn-lg" name="submit">Comment</button>
                </form>
    </div>

    <!-- side of page -->
    <div class="offset-sm-1 col-sm-3">
    
    <div class="card border-primary text-white text-center" style="width: 15rem;">
    <div class="card-header bg-primary font-weight-bold">
            Categories
    </div>
  <ul class="list-group list-group-flush">
       <?php 

       $sql = "SELECT category_name FROM category ORDER BY datetime DESC";
       $res_data = $connection->query($sql);
           if($res_data->num_rows > 0) {
               while($row = $res_data->fetch_assoc()) {
                   $cateogyName = $row['category_name']; ?>
            
            <li class="list-group-item border-primary"><a href="blog.php?category=<?php echo $cateogyName; ?>"><?php echo $cateogyName; ?></a></li>
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


<div id="footer"> <!-- Footer div -->
        <hr>
            <p> | &copy; | 2020 <a href="https://sambhattarai.com.np" target="_blank">SAMBHATTARAI</a> All Right Reserved</p>
        <hr>
   </div>
   <div style="height:10px; background-color: #283b5f"></div>
</body>
</html>