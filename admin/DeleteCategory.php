<?php  require_once("../include/database.php")?>
<?php  require_once("../include/functions.php")?>
<?php include_once( '../include/Sessions.php'); ?>
<?php confirm_login(); ?>

<?php 
    global $connection;

    $urlId = $_GET['Delete']; // Get The ID from url
    $sql = "DELETE FROM category WHERE id='$urlId'"; // DELETE QUERY
    if($connection->query($sql)){ // IF ITEM ID DELETED REDIRECT
        redirect("categories.php");
    }else {
        echo "can not delete the post"; // ELSE SHOE THIS ERRO
    }
?>