<?php
    if(isset($_SESSION["entrato"]) && $_SESSION["entrato"]){
        echo "#";
    }else{
        //alcuni file potevano esser raggruppati utilizzando il comando basename($_SERVER['PHP_SELF']);
        echo "login.php";
    }
?>