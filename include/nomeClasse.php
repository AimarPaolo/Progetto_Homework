<?php
    if(isset($_SESSION["entrato"]) && $_SESSION["entrato"]){
        echo "disabilitata";
    }else{
        echo "abilitata";
    }
?>