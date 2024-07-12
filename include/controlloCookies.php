<?php
    if(isset($_COOKIE['ultimo_accesso'])){
        $username = $_COOKIE["ultimo_accesso"];
        echo "$username";
    }
    else
        echo "";
?>