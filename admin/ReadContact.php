<?php include_once("../include/database.php"); ?>
<?php include_once("../include/functions.php"); ?>

<?php include_once( '../include/Sessions.php'); ?>
<?php confirm_login(); ?>

<?php 

    global $connection;
    $contact_id = $_GET["id"];
    $sql = "UPDATE contacts SET is_read=1 WHERE id=$contact_id";

    if($connection->query($sql)){
        redirect("contacts.php");
    } else {
        echo "Something Went Wrong";
    }


 ?>