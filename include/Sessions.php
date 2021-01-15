<?php include_once("functions.php"); ?>
<?php 
    session_start();
    // To display the session message
    function Message(){
        if(isset($_SESSION["ErrorMessage"])){
            $output = htmlentities($_SESSION["ErrorMessage"]);
            $_SESSION["ErrorMessage"] = null;
            return $output;
        }
    }

    function successMessage(){
        if(isset($_SESSION["succMessage"])){
            $output = htmlentities($_SESSION["succMessage"]);
            $_SESSION["succMessage"] = null;
            return $output;
        }
    }

    function login(){
        if(isset($_SESSION["user_id"])){
            return true;

        }
    }

    function confirm_login(){
        if(!login()){
            $_SESSION["ErrorMessage"] = "Login Required";
            redirect("../Login.php");
        }else{
            // redirect("admin/dashboard.php");
        }
    }

?>