<?php  require_once("../include/database.php")?>
<?php  require_once("../include/functions.php")?>
<?php include_once( '../include/Sessions.php'); ?>
<?php confirm_login(); ?>

<?php 
    $categoryErr = "";
    $categorySucc = "";


    $unapproveCommentCount = "SELECT count(*) as upapproveComment from comments where status='Pending'";
    $count = $connection->query($unapproveCommentCount);
    

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
         $sql = "INSERT INTO category(category_name,datetime,creatorname)
                    VALUES('$category','$datetime','$admin')";
                    
        if (mysqli_query($connection, $sql)) {
            $categorySucc = "New Category Added Successfully!!";
            redirect("categories.php");
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
    <title>ADMIN</title>
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
                        <a class="nav-link active" href="categories.php">
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
                        <label for="category" class="form-name">Category Name</label>
                        <input type="text" class="form-control" id="category" name="category">
                    </div>
                    <button type="submit" class="btn btn-success btn-lg" name="submit">Add Category</button>
                </form>


                <!-- Category Table -->
                <h4 style="margin-top: 50px;text-align:center; font-weight:bold;" > Category Table </h4>
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
             <div class="table-responsive m-5">
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
                                echo "<tr><td>{$row['id']}</td><td>{$row['category_name']}</td><td>{$row['creatorname']}</td>
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