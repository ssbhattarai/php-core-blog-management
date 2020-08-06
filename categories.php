<?php  require_once("include/database.php")?>
<?php  require_once("include/functions.php")?>

<?php 
    $categoryErr = "";
    $categorySucc = "";
    if (isset($_POST["submit"])){

        $category = $_POST["category"]; 

        // DateTimeZone('Asia/Katmandu');
        date_default_timezone_get();
        $current_time = time();
        $datetime = strftime("%B-%d-%Y %H:%M:%S");
        $admin = "SHyam";

        
        if(empty($category)) {
            $categoryErr = "All Field must be filled out";
        } elseif(strlen($category) > 1000) {
            $categoryErr = "Category Name is Too long";
        }else {
            
        global $connection;
         $sql = "INSERT INTO category(category_name,datetime,creatername)
                    VALUES('$category','$datetime','$admin')";
                    
        if (mysqli_query($connection, $sql)) {
            $categorySucc = "New Category Added Successfully!!";
         } else {
            echo "Error: " . $sql . "" . mysqli_error($connection);
         }
        //  $con->close();
        }
    }


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="css/adminstyles.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>ADMIN</title>
    <style>
    </style>
</head>
<body>
   <div class="container-fluid">
        <div class="row">
            <div class="col-sm-2">
                <h1>shyam</h1>
                <ul id="side_menu" class="nav flex-column nav-pills">
                    <li class="nav-item">
                        <a class="nav-link" href="dashboard.php">
                        <i class="fa fa-tachometer" aria-hidden="true"></i>
                        &nbsp;Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                        <i class="fa fa-list" aria-hidden="true"></i>
                        &nbsp;Add New post
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="categories.php">
                        <i class="fa fa-tags" aria-hidden="true"></i>
                        &nbsp;Categories
                    </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                        <i class="fa fa-users" aria-hidden="true"></i>
                        &nbsp;Manage Admins
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                        <i class="fa fa-comments" aria-hidden="true"></i>
                        &nbsp;Comments
                        </a>
                    </li><li class="nav-item">
                        <a class="nav-link" href="#">
                        <i class="fa fa-rss" aria-hidden="true"></i>
                        &nbsp;Live Blog
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                        <i class="fa fa-sign-out" aria-hidden="true"></i>
                        &nbsp;Logout
                        </a>
                    </li>
                    </ul>
            </div> <!-- ending of side area-->
                <div class="col-sm-10">
                    <h1>Manage Category </h1>
                   <?php if($categoryErr){ ?>
                       <div class="alert alert-danger" role="alert">
                          <?php echo $categoryErr; ?>
                         </div>
                   <?php  } ?> 
                   <?php if($categorySucc){ ?>
                       <div class="alert alert-success" role="alert">
                          <?php echo $categorySucc; ?>
                         </div>
                   <?php  } ?> 
                    <form action="categories.php" method="post">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Category Name</label>
                            <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="category" autofocus>
                        </div>
                        <!-- <div class="form-group">
                            <label for="exampleInputPassword1">Created Date</label>
                            <input type="text" class="form-control" id="exampleInputPassword1" name="datetime">
                        </div> -->
                        <!-- <div class="form-group form-check">
                            <input type="checkbox" class="form-check-input" id="exampleCheck1">
                            <label class="form-check-label" for="exampleCheck1">Check me out</label>
                        </div> -->
                        <button type="submit" class="btn btn-success btn-lg" name="submit">Submit</button>
                        </form>
            </div> <!-- ending of side area-->
        </div> <!-- ending  of row-->
   </div> <!-- ennd containger-->
   <div id="footer"> <!-- Footer div -->
        <hr>
            <p> | &copy; | 2020 <a href="https://sambhattarai.com.np" target="_blank">SAMBHATTARAI</a> All Right Reserved</p>
        <hr>
   </div>
   <div style="height:10px; background-color: #283b5f"></div>
</body>
</html>