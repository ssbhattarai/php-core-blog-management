<?php include_once("./database.php") ?>
<?php 

function redirect($location){
    header("Location: $location");
    exit;
}


function login_attempt($username, $password){
    global $connection;
    $query = "SELECT * FROM admins WHERE username='$username' and password = '$password'"
    // $execute = mysqli_query($connection, $query);

}