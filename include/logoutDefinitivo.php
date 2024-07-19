<?php
    include("aperturaSessioni.php");
    if(isset($_REQUEST["si"])){
        /*se l'utente ha deciso di fare il logout, cancello tutte le variabili di sessione e chiudo la sessione aperta. Rimando l'utente
        alla pagina di login in modo che lui possa accedere nuovamente, se lo desidera.*/ 
        session_unset();
        session_destroy();
        header("Location: ../php/login.php");
        exit();
    }elseif(isset($_REQUEST["no"])){
        header("Location: ../php/bacheca.php");
        exit();
    }  
?>