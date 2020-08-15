<?php  require_once("../include/database.php")?>
<?php  require_once("../include/functions.php")?>

<?php 
    global $connection;

    $urlId = $_GET['Delete']; // Get The ID from url
    $sql = "DELETE FROM admins WHERE id='$urlId'"; // DELETE QUERY
    if($connection->query($sql)){ // IF ITEM ID DELETED REDIRECT
        redirect("admins.php");
    }else {
        echo "can not delete the post"; // ELSE SHOE THIS ERRO
    }
?>