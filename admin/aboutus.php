<?php  require_once("../include/database.php")?>
<?php  require_once("../include/functions.php")?>
<?php include_once( '../include/Sessions.php'); ?>
<?php confirm_login(); ?>

<?php 
    $aboutError = "";
    $aboutSucc = "";


    $unapproveCommentCount = "SELECT count(*) as upapproveComment from comments where status='Pending'";
    $count = $connection->query($unapproveCommentCount);
    

    if (isset($_POST["submit"])){

        $title = $_POST["title"]; 
        $body = $_POST["body"]; 

        // DateTimeZone('Asia/Katmandu');
        date_default_timezone_get();
        $current_time = time();
        $datetime = strftime("%B-%d-%Y %H:%M:%S");

        
        if(empty($title) || empty($body)) {
            $aboutError = "All Field must be filled out";
        } elseif(strlen($title) > 1000) {
            $aboutError = "Title Name is Too long";
        }else {
            
        global $connection;
         $sql = "INSERT INTO about_us(title,body,datetime)
                    VALUES('$title','$body','$datetime')";
                    
        if (mysqli_query($connection, $sql)) {
            $aboutSucc = "New About Us Added Successfully!!";
            redirect("aboutus.php");
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
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <script src="../js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="../css/adminstyles.css">
    <link href="https://fonts.googleapis.com/css2?family=B612&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>About Us</title>
    <style>
    </style>
</head>

<body>
    <div class="container-fluid">
        <div class="row">

            <div class="col-sm-2">
            <h1 class="text-primary text-center">DASH</h1>
                <ul id="side_menu" class="nav flex-column nav-pills">
                    <li class="nav-item">
                        <a class="nav-link" href="dashboard.php">
                            <i class="fa fa-tachometer" aria-hidden="true"></i>
                            &nbsp;Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="AddNewPost.php">
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
                        <a class="nav-link" href="admins.php">
                            <i class="fa fa-users" aria-hidden="true"></i>
                            &nbsp;Manage Admins
                        </a>
                    </li>
                    <li class="nav-item">
						<a class="nav-link active" href="aboutus.php"> <i class="fa fa-info" aria-hidden="true"></i>
							&nbsp;About Us</a>
					</li>
                    <li class="nav-item">
						<a class="nav-link" href="Comments.php"> <i class="fa fa-comments" aria-hidden="true"></i>
							&nbsp;Comments <?php while($countcom = $count->fetch_assoc()){
								$unapprove = $countcom["upapproveComment"];
							} ?>
							<?php if($unapprove > 0){ ?><span class="badge badge-danger" style="float:right;"><?php echo $unapprove ?></span> <?php } ?></a>
					</li>
                    <li class="nav-item">
                        <a class="nav-link" href="contacts.php">
                            <i class="fa fa-phone" aria-hidden="true"></i>
                            &nbsp;Contacts
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="Logout.php">
                            <i class="fa fa-sign-out" aria-hidden="true"></i>
                            &nbsp;Logout
                        </a>
                    </li>
                </ul>
            </div> <!-- ending of side area-->


            <div class="col-sm-10">
                <h1 class="text-center m-5">Manage About Us </h1>
                <?php if($aboutError){ ?>
                <div class="alert alert-danger" role="alert">
                    <?php echo $aboutError; ?>
                </div>
                <?php  } ?>
                <?php if($aboutSucc){ ?>
                <div class="alert alert-success" role="alert">
                    <?php echo $aboutSucc; ?>
                </div>
                <?php  } ?>
                <form action="aboutus.php" method="post">
                    <div class="form-group">
                        <label for="title" class="form-name">Title </label>
                        <input type="text" class="form-control" id="title" name="title">
                    </div>
                    <div class="form-group">
                        <label for="body" class="form-name">Body </label>
                        <textarea rows="3" class="form-control" id="body" name="body"></textarea>
                    </div>
                    <button type="submit" class="btn btn-success btn-lg" name="submit">Add About</button>
                </form>


                <!-- Category Table -->
                <h4 style="margin-top: 50px;text-align:center; font-weight:bold;" > About Us Table </h4>
                <div style="margin-top: 26px;" class="table-responsive">
                    
                    <?php 
                        // Pagination
                     
                  

                        $dataErr = "";
                        $sql = "SELECT * FROM about_us order by id desc";
                        // $sql = "SELECT * FROM category";
                        $res_data = $connection->query($sql);
                        // echo $result;

                       
                    ?>
             <?php if(!$dataErr) { ?>
             <div class="table-responsive m-5">
                    <table class="table table-striped">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col">Id</th>
                                <th scope="col">title </th>
                                <th scope="col">body</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php 
                        if($res_data->num_rows > 0) {
                            while($row = $res_data->fetch_assoc()) {
                                echo "<tr><td>{$row['id']}</td><td>{$row['title']}</td><td>{$row['body']}</td>
                               </tr>\n";
                            }
                        } else {
                            $dataErr = "No data To display";
                        }
                        ?>
                    <?php if($dataErr) {?>
                    <div class="alert alert-info" role="alert">
                         <?php echo $dataErr; ?>
                    </div>
                    <?php } ?>
                    </table>
             </div>
        <?php } ?>
                </div>
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