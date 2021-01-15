<?php  require_once("../include/database.php")?>
<?php  require_once("../include/functions.php")?>

<?php 
    global $connection;
    $postErr = "";
    $postSucc = "";
    $urlId = $_GET['Edit'];
    if (isset($_POST["update"])){

        // To get form data
        $titlepost = $_POST["title"]; 
        $categorypost = $_POST["category"]; 
        $post_bodypost = $_POST["post_body"]; 

        // for Created Date time
        date_default_timezone_get();
        $current_time = time();
        $datetime = strftime("%B-%d-%Y %H:%M:%S");
        $author = "Shyam";
        

        //Image Upload 
        $image_name = $_FILES['Image']['name'];
        $target_dir = "../images/";
        $target_file = $target_dir . basename($_FILES["Image"]["name"]);

        // Select file type
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

        // Valid file extensions
        $extensions_arr = array("jpg","jpeg","png","gif");
        
        if(empty($titlepost)) {
            $postErr = "All Field must be filled out";
        // }
        //  elseif(strlen($title) > 1000) {
        //     $postErr = "Category Name is Too long";
        }else {
            
        if( in_array($imageFileType,$extensions_arr) ){
            // Insert record
            $image_base64 = base64_encode(file_get_contents($_FILES['Image']['tmp_name']) );     // Convert to base64 
            $imageUpload = 'data:image/'.$imageFileType.';base64,'.$image_base64;
            
            if (move_uploaded_file($_FILES['Image']['tmp_name'], $target_file)) {

                $sql = "UPDATE blog SET 
                datetime='$datetime',title = '$titlepost', category='$categorypost',image='$imageUpload',post_body='$post_bodypost'
                WHERE id='$urlId'";
                
                if (mysqli_query($connection, $sql)) {
                    
                    $postSucc = "post Successfully!!";
                    redirect("dashboard.php");
                } else {
                    $postErr="something went worng";
                    echo "Error: " . $sql . "" . mysqli_error($connection);
                }
                //  $con->close();
                }
            } else {
                    $sql = "UPDATE blog SET 
                    datetime='$datetime',title = '$titlepost', category='$categorypost',post_body='$post_bodypost'
                    WHERE id='$urlId'";
                
                if (mysqli_query($connection, $sql)) {
                    
                    $postSucc = "post Successfully!!";
                    redirect("dashboard.php");
                } else {
                    $postErr="something went worng";
                    echo "Error: " . $sql . "" . mysqli_error($connection);
                }
                
            }
         }
    }

    $sql = "SELECT * FROM blog WHERE id='$urlId'";
    $result = $connection->query($sql);
    $data = $result->fetch_assoc();
    $title = $data["title"];
    $category = $data["category"];
    $image = $data["image"];
    $image = $data["image"];
    $post_body = $data["post_body"];
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
    <title>ADMIN-Edit Post</title>
    <style>
    </style>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-2">
            <h1 class="text-primary text-center">DASH</h1>
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
                        <a class="nav-link" href="admins.php">
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
                <h1>Add New Post </h1>
                <?php if($postErr){ ?>
                <div class="alert alert-danger" role="alert">
                    <?php echo $postErr; ?>
                </div>
                <?php  } ?>
                <?php if($postSucc){ ?>
                <div class="alert alert-success" role="alert">
                    <?php echo $postSucc; ?>
                </div>
                <?php  } ?>
                <form action="EditPost.php?Edit=<?php echo $urlId; ?>" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="title" class="form-name">Title</label>
                        <input type="text" class="form-control" id="title" aria-describedby="emailHelp" name="title" value="<?php echo $title ?>">
                    </div>
                    <div class="form-group">
                        <label for="category" class="form-name">Select Category</label>
                        <select class="form-control" id="category" name="category">
                            <option> Select a category for this post </option>
                            <?php 
                            $sql = "SELECT * FROM category ORDER BY datetime DESC";
                            $res_data = $connection->query($sql);
                                if($res_data->num_rows > 0) {
                                    while($row = $res_data->fetch_assoc()) {
                                        $categoryName = $row['category_name'];
                                        ?>
                                        <option <?php if($category==$categoryName) echo 'selected="selected"'; ?>> <?php echo "$categoryName"; ?>  </option>
                        <?php }}else {
                         echo "Please Create the Category to create a new Post";
                        } ?> 
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="image" class="form-name">Image</label>
                        <div style="margin:10px">
                            <img src="<?= $image ?>" alt="image" style="height:143px;width:270px;">
                        </div>
                        <input type="file" class="form-control-file" id="image" name="Image">
                    </div>
                    <div class="form-group">
                        <label for="post" class="form-name">Post</label>
                        <textarea class="form-control" id="post"  name="post_body" rows="15"><?php echo $post_body ?></textarea>
                    </div>
                    <button type="submit" class="btn btn-success btn-lg" name="update">Update</button>
                </form>
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