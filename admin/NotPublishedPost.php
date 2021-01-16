<?php include_once("../include/database.php"); ?>
<?php include_once("../include/functions.php"); ?>

<?php include_once( '../include/Sessions.php'); ?>
<?php confirm_login(); ?>

<?php 

    global $connection;
    $blog_id = $_GET["id"];
    $sql = "UPDATE blog SET status='0' WHERE id=$blog_id";

    if($connection->query($sql)){
        redirect("dashboard.php");
    } else {
        echo "Something Went Wrong";
    }



 ?>