<?php include_once('include/database.php');?>
<?php include_once('include/functions.php');?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <script src="js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" href="css/public.css">
    <title>Blog</title>
</head>
<body>
    <div style="height:10px;background: #227b5a;"></div>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
<div class="container">
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
    <div class="nav-header">
            <a href="index.php" style="argin: -6px;margin-right: 10px;">
                <img src="static/sundarBlog.png" alt="sundarblog" style="width:8em;">
            </a>
    </div>
    <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
      <li class="nav-item">
        <a class="nav-link" href="index.php">Home</a>
      </li>
      <li class="nav-item active">
        <a class="nav-link" href="blog.php">Blog</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">About</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">Contact</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#" tabindex="-1" aria-disabled="true">Disabled</a>
      </li>
    </ul>
    <form class="form-inline my-2 my-lg-0">
      <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
      <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
    </form>
  </div>
  </div>
</nav>
<div style="height:10px;background: #227b5a;"></div>
<div class="container">
    <h1>Full PHP BLOG CMS </h1>
    <p>Made by Sundar</p>
    <div class="row">
    <div class="col-sm-8">
    <?php 
            global $connection;
            $sql = "SELECT * FROM blog ORDER BY datetime DESC";
            $all_data = $connection->query($sql);
            if($all_data->num_rows > 0) {
                while($row = $all_data->fetch_assoc()) {
                    // echo print_r($row);
                    // $image = base64_decode($row['image']);
                    // echo $image;
                    $image = $row['image'];
            ?> 
    <div class="card shadow p-3 mb-5 bg-dark text-light rounded">
        <img src="<?= $image ?>" class="card-img-top img-thumbnail rounded float-left" alt="..." >
        <div class="card-body">
            <h5 class="card-title"><?php echo htmlentities($row['title']) ?></h5>
            <small class="float-sm-left">Category: <?php echo htmlentities($row["category"])?> </small>
            <small style="margin-left: 10px">Published on: <?php echo htmlentities($row["datetime"])?></small>
            <p class="card-text">
                <?php if(strlen($row['post_body']) > 150){
                    $post = substr($row["post_body"], 0, 150) . '...';
                }
                echo htmlentities($post); ?></p>
            <a href="#" class="btn btn-primary">View More</a>
        </div>
        </div>
        <?php
            }
            } else {
                echo  "No Post To display";
            }
            ?>
    </div>
    <div class="offset-sm-1 col-sm-3">
    <h2>THis is post Title</h2>
        <p>
        I inadvertently went to See's Candy last week (I was in the mall looking for phone repair), 
        and as it turns out, See's Candy now charges a dollar -- a full dollar -- for even the simplest 
        of their wee confection offerings. I bought two chocolate lollipops and two chocolate-caramel-almond things. 
        The total cost was four-something. I mean, the candies were tasty and all, but let's be real: A Snickers bar
         is fifty cents. After this dollar-per-candy revelation,
         I may not find myself wandering dreamily back into a See's Candy any time soon.
        </p>
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