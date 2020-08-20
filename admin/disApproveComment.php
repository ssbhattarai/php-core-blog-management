<?php include_once("../include/database.php"); ?>
<?php include_once("../include/functions.php"); ?>
<?php include_once( '../include/Sessions.php'); ?>
<?php confirm_login(); ?>
<?php 

    global $connection;
    $comment_id = $_GET["id"];
    $sql = "UPDATE comments SET status='Pending' WHERE id=$comment_id";

    if($connection->query($sql)){
        redirect("Comments.php");
    } else {
        echo "Something Went Wrong";
    }



 ?>