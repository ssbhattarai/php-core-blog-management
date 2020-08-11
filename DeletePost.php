<?php  require_once("include/database.php")?>
<?php  require_once("include/functions.php")?>

<?php 
    global $connection;
    $postErr = "";
    $postSucc = "";
    $urlId = $_GET['Delete'];
    $sql = "DELETE FROM blog WHERE id='$urlId'";
    if($connection->query($sql)){
        redirect("dashboard.php");
    }else {
        echo "can not delete the post";
    }

    


?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <script src="js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="css/adminstyles.css">
    <link href="https://fonts.googleapis.com/css2?family=B612&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>ADMIN-Delete Post</title>
    <style>
    </style>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-2">
                <ul id="side_menu" class="nav flex-column nav-pills">
                <br><br><br>
                    <li class="nav-item">
                        <a class="nav-link" href="dashboard.php">
                            <i class="fa fa-tachometer" aria-hidden="true"></i>
                            
                            &nbsp;Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="AddNewPost.php">
                            <i class="fa fa-list" aria-hidden="true"></i>
                            &nbsp;Add New post
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="categories.php">
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
                    </li>
                    <li class="nav-item">
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
            </div> <!-- ending of side area-->
        </div> <!-- ending  of row-->
    </div> <!-- ennd containger-->
    <div id="footer">
        <!-- Footer div -->
        <hr>
        <p> | &copy; | 2020 <a href="https://sambhattarai.com.np" target="_blank">SAMBHATTARAI</a> All Right Reserved</p>
        <hr>
    </div>
    <div style="height:10px; background-color: #283b5f"></div>

</body>

</html>