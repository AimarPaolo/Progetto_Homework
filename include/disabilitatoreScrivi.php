<?php
    if(!isset($_SESSION["entrato"]) || !$_SESSION["entrato"]){
        echo "#";
    }else{
        echo "scrivi.php";
    }
?>