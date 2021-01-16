<?php include_once( '../include/database.php'); ?>
<?php include_once( '../include/Sessions.php'); ?>

<?php



$_SESSION["user_id"]==null;

session_destroy();

session_start();
$_SESSION["ErrorMessage"] = "You Logged out";
redirect('../Login.php');

?>