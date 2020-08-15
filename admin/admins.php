<?php  require_once("../include/database.php")?>
<?php  require_once("../include/functions.php")?>

<?php 
    $adminErr = "";
    $adminSucc = "";


    $unapproveCommentCount = "SELECT count(*) as upapproveComment from comments where status='Pending'";
    $count = $connection->query($unapproveCommentCount);
    

    if (isset($_POST["submit"])){

        $username = $_POST["username"]; 
        $password = $_POST["password"]; 
        $confirm_password = $_POST["confirm_password"]; 


        $passwordHash = password_hash($password, PASSWORD_DEFAULT);  

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
                    VALUES('$datetime','$username','$passwordHash','$admin')";
                    
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
                <h1>shyam</h1>
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
						<a class="nav-link" href="Comments.php"> <i class="fa fa-comments" aria-hidden="true"></i>
							&nbsp;Comments <?php while($countcom = $count->fetch_assoc()){
								$unapprove = $countcom["upapproveComment"];
							} ?>
							<?php if($unapprove > 0){ ?><span class="badge badge-danger" style="float:right;"><?php echo $unapprove ?></span> <?php } ?></a>
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
                <h1>Manage Category </h1>
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
                    <button type="submit" class="btn btn-success btn-lg" name="submit">Add User</button>
                </form>


                <!-- Category Table -->
                <h4 style="margin-top: 20px;text-align:center; font-weight:bold;" > Category Table </h4>
                <div style="margin-top: 26px;" class="table-responsive">
                    
                    <?php 
                        // Pagination
                        if (isset($_GET['page_no']) && $_GET['page_no']!="") {
                            $page_no = $_GET['page_no'];
                        } else {
                                $page_no = 1;
                        }
                        $total_records_per_page = 3;
                        
                        $offset = ($page_no-1) * $total_records_per_page;
                        $previous_page = $page_no - 1;
                        $next_page = $page_no + 1;
                        $adjacents = "2";

                        $result_count = mysqli_query(
                            $connection,
                            "SELECT COUNT(*) AS total_categories FROM `category`"
                        );
                        $total_records = mysqli_fetch_array($result_count);
                        $total_records = $total_records['total_categories'];
                        $total_number_of_pages = ceil($total_records / $total_records_per_page);
                        $second_last = $total_number_of_pages - 1;


                        $dataErr = "";
                        $sql = "SELECT * FROM category LIMIT $offset, $total_records_per_page";
                        // $sql = "SELECT * FROM category";
                        $res_data = $connection->query($sql);
                        // echo $result;

                       
                    ?>
             <?php if(!$dataErr) { ?>
                    <table class="table table-striped">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col">Id</th>
                                <th scope="col">Category </th>
                                <th scope="col">Created Date</th>
                                <th scope="col">Creator Name</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php 
                        if($res_data->num_rows > 0) {
                            while($row = $res_data->fetch_assoc()) {
                                echo "<tr><td>{$row['id']}</td><td>{$row['category_name']}</td><td>{$row['datetime']}</td><td>{$row['creatorname']}</td></tr>\n";
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
                    <div style='padding: 10px 20px 0px; border-top: dotted 1px #CCC;'>
                        <strong>Page <?php echo $page_no." of ".$total_number_of_pages; ?></strong>
                    </div>
                    <nav aria-label="Page navigation example">
                    <ul class="pagination justify-content-end">
                        <?php if($page_no > 1){
                        echo "<li><a class='page-link' href='?page_no=1'>First Page</a></li>";
                        } ?>
                            
                        <li class="page-item" <?php if($page_no <= 1){ echo "class='disabled'"; } ?>>
                        <a class='page-link' <?php if($page_no > 1){
                        echo "href='?page_no=$previous_page'";
                        } ?>>Previous</a>
                        </li>
                        <?php     
                        if ($total_number_of_pages <= 10){  	 
                            for ($counter = 1; $counter <= $total_number_of_pages; $counter++){
                            if ($counter == $page_no) {
                            echo "<li class='active'><a class='page-link' >$counter</a></li>";	
                                    }else{
                                echo "<li><a class='page-link' href='?page_no=$counter'>$counter</a></li>";
                                        }
                                }
                        }elseif ($total_number_of_pages > 10){
                            if($page_no <= 4) { 
                                for ($counter = 1; $counter < 8; $counter++){ 
                                if ($counter == $page_no) {
                                   echo "<li class='active'><a class='page-link'>$counter</a></li>"; 
                                }else{
                                          echo "<li class=\"page-item\"><a class='page-link' href='?page_no=$counter'>$counter</a></li>";
                                               }
                               }
                               echo "<li class=\"page-item\"><a class='page-link'>...</a></li>";
                               echo "<li class=\"page-item\"><a class='page-link' href='?page_no=$second_last'>$second_last</a></li>";
                               echo "<li class=\"page-item\"><a class='page-link' href='?page_no=$total_number_of_pages'>$total_number_of_pages</a></li>";
                               }
                            }
                            // elseif($page_no > 4 && $page_no < $total_number_of_pages - 4) { 
                            //     echo "<li class='page-item'><a class='page-link' href='?page_no=1'>1</a></li>";
                            //     echo "<li class='page-item'><a class='page-link' href='?page_no=2'>2</a></li>";
                            //     echo "<li class='page-item'><a class='page-link'>...</a></li>";
                            //     for (
                            //          $counter = $page_no - $adjacents;
                            //          $counter <= $page_no + $adjacents;
                            //          $counter++
                            //          ) { 
                            //          if ($counter == $page_no) {
                            //      echo "<li class='page-item' class='active'><a class='page-link'>$counter</a></li>"; 
                            //      }else{
                            //             echo "<li class='page-item'><a class='page-link' href='?page_no=$counter'>$counter</a></li>";
                            //               }                  
                            //            }
                            //     echo "<li class='page-item'><a class='page-link'>...</a></li>";
                            //     echo "<li class='page-item'><a class='page-link' href='?page_no=$second_last'>$second_last</a></li>";
                            //     echo "<li class='page-item'><a class='page-link' href='?page_no=$total_number_of_pages'>$total_number_of_pages</a></li>";
                        //  } else {
                        //     echo "<li><a href='?page_no=1'>1</a></li>";
                        //     echo "<li><a href='?page_no=2'>2</a></li>";
                        //     echo "<li><a>...</a></li>";
                        //     for (
                        //          $counter = $total_no_of_pages - 1;
                        //          $counter <= $total_no_of_pages;
                        //          $counter++
                        //          ) {
                        //          if ($counter == $page_no) {
                        //      echo "<li class='active'><a>$counter</a></li>"; 
                        //      }else{
                        //             echo "<li><a href='?page_no=$counter'>$counter</a></li>";
                        //      }                   
                        //          }
                        //     }
                                
                        ?>
                        <?php if($page_no < $total_number_of_pages){
                        echo "<li class='page-item'><a class='page-link' href='?page_no=$total_number_of_pages'>Last &rsaquo;&rsaquo;</a></li>";
                        } ?>
                        </ul>
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