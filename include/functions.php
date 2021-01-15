<?php include_once("database.php") ?>
<?php 

// Reusable function for the project

function redirect($location){
    header("Location: $location");
    exit;
}


function login_attempt($username, $password){
    global $connection;
    $query = "SELECT * FROM admins WHERE username='$username' and password = '$password'";
    $execute = mysqli_query($connection, $query);

    if($admin = mysqli_fetch_assoc($execute)){
        return $admin;
    }else {
        return null;
    }
}

// function logedin() {
//     if(isset($_SESSION["user_id"])) {
//         return true;
//     }
// }

// function isLoggedin() {
//     if(!logedin()) {
//         redirect("Login.php");
//     }
// }