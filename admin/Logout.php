<?php include_once( '../include/database.php'); ?>
<?php include_once( '../include/Sessions.php'); ?>

<?php



$_SESSION["user_id"]==null;

session_destroy();
redirect('../Login.php');

?>