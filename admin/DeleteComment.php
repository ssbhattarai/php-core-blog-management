<?php include_once("../include/database.php"); ?>
<?php include_once("../include/functions.php"); ?>
<?php 

    global $connection;
    $comment_id = $_GET["id"];
    $sql = "DELETE FROM comments WHERE id=$comment_id";

    if($connection->query($sql)){
        redirect("Comments.php");
    } else {
        echo "Something Went Wrong";
    }



 ?>