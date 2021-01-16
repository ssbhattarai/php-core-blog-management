<?php  require_once("../include/database.php")?>
<?php  require_once("../include/functions.php")?>
<?php include_once( '../include/Sessions.php'); ?>
<?php confirm_login(); ?>

<?php 
    $adminErr = "";
    $adminSucc = "";


    $unapproveCommentCount = "SELECT count(*) as upapproveComment from comments where status='Pending'";
    $count = $connection->query($unapproveCommentCount);
    

    if (isset($_POST["submit"])){

        $username = $_POST["username"]; 
        $password = $_POST["password"]; 
        $confirm_password = $_POST["confirm_password"]; 


        // $passwordHash = password_hash($password, PASSWORD_DEFAULT);  

        // DateTimeZone('Asia/Katmandu');
        date_default_timezone_get();
        $current_time = time();
        $datetime = strftime("%B-%d-%Y %H:%M:%S");
        $admin = "SHyam";

        
        if(empty($username) || empty($password) || empty($confirm_password)) {
            $adminErr = "All Field must be filled out";
        } elseif(strlen($password) < 6) {
            $adminErr = "Password must contains at least 6 character";
        }elseif($password != $confirm_password){
            $adminErr = "Password must be same";
        }else {
            
        global $connection;
         $sql = "INSERT INTO admins(datetime,username,password,addedby)
                    VALUES('$datetime','$username','$password','$admin')";
                    
        if (mysqli_query($connection, $sql)) {
            $categorySucc = "New user Added Successfully!!";
            redirect("admins.php");
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
    <title>Manage Admins</title>
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
                        <a class="nav-link active" href="admins.php">
                            <i class="fa fa-users" aria-hidden="true"></i>
                            &nbsp;Manage Admins
                        </a>
                    </li>
                    <li class="nav-item">
						<a class="nav-link" href="aboutus.php"> <i class="fa fa-info" aria-hidden="true"></i>
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
                <h1 class="text-center m-5">Manage Category </h1>
                <?php if($adminErr){ ?>
                <div class="alert alert-danger" role="alert">
                    <?php echo $adminErr; ?>
                </div>
                <?php  } ?>
                <?php if($adminSucc){ ?>
                <div class="alert alert-success" role="alert">
                    <?php echo $adminSucc; ?>
                </div>
                <?php  } ?>
                <form action="admins.php" method="post">
                    <div class="form-group">
                        <label for="usename" class="form-name">Username</label>
                        <input type="text" class="form-control" id="username" name="username">
                    </div>
                    <div class="form-group">
                        <label for="password" class="form-name">Password</label>
                        <input type="password" class="form-control" id="password" name="password">
                    </div>
                    <div class="form-group">
                        <label for="confirmPassword" class="form-name">Confirm Password</label>
                        <input type="password" class="form-control" id="confirmPassword" name="confirm_password">
                    </div>
                    <button type="submit" class="btn btn-success btn-lg" name="submit">Add Admin</button>
                </form>


                <!-- Category Table -->
                <h4 style="margin-top: 50px;text-align:center; font-weight:bold;" > Admins Table </h4>
                <div style="margin-top: 26px;" class="table-responsive">
                    
                    <?php 
                        $adminData = '';
                        global $connection;
                        $admin = mysqli_query($connection, "SELECT * FROM admins order by datetime desc");
                        // while($allData  = mysqli_fetch_assoc($admin)){

                        // }
                       
                    ?> 
                    <table class="table table-striped">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col">Id</th>
                                <th scope="col">Datetime </th>
                                <th scope="col">Username</th>
                                <th scope="col">Added by</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php 
                        if($admin->num_rows > 0) {
                            while($row = mysqli_fetch_assoc($admin)) {
                                echo "<tr>
                                <td>{$row['id']}</td>
                                <td>{$row['datetime']}</td>
                                <td>{$row['username']}</td>
                                <td>{$row['addedby']}</td>
                                <td><a href='DeleteAdmin.php?Delete={$row['id']}'><button class='btn btn-danger'>Delete</button></a></td></tr>\n";
                            }
                        } else {
                            $dataErr = "No data To display";
                        }
                        ?>
                    </table>
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