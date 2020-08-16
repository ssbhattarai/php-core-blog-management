<?php include_once("include/database.php"); ?>
<?php include_once("include/functions.php"); ?>
<?php
    $loginError = '';
    global $connection;
    if(isset($_POST["submit"])){
        $username = $_POST["username"];
        $password = $_POST["password"];
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);
        
        if(empty($username) || empty($password)){
            $loginError = "All fields must be filled.";

        }else{
            $result = mysqli_query($connection,"SELECT * FROM admins WHERE username='$username' and password = '$password' limit 1");
            print_r($result);
            $count  = mysqli_num_rows($result);
            echo $count;
            if($count==0) {
                $loginError = "Invalid Username or Password!";
                echo $loginError;
            } else {
                $message = "You are successfully authenticated!";
                echo $message;
            }
        }
    }


?>

<!DOCTYPE html>
<html lang="en">


<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <script src="js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" href="css/public.css">
    <title>Home </title>
</head>

<!-- background-image: linear-gradient(to bottom right, #981010, white) -->
<body style="background: linear-gradient(46deg,#981010 50%, #5f5f3c 15%); height:100%">
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
<div class="container">
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
    <div class="nav-header">
            <a href="index.php" style="argin: -6px;margin-right: 10px;">
                <img src="static/sundarBlog.png" alt="sundarblog" style="width:8em;">
            </a>
    </div>
  </div>
  </div>
</nav>
<div>
<div class="container col col-sm-4 card mt-5 p-5">
<h3>LOGIN</h3>
<form action="Login.php" method="post">
  <div class="form-group">
    <label for="username">Username</label>
    <input type="text" class="form-control" id="username" name="username">
  </div>
  <div class="form-group">
    <label for="password">Password</label>
    <input type="password" class="form-control" id="password" name="password">
  </div>
  <button type="submit" class="btn btn-primary" name="submit">LOGIN</button>
</form>
</div>
</div>

</body>
</html>