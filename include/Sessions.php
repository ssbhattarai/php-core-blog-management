<?php 
    session_start();

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

?>