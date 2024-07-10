<?php
    /*se l'utente ha deciso di fare il logout, cancello tutte le variabili di sessione e chiudo la sessione aperta. Rimando l'utente
    alla pagina di login in modo che lui possa accedere nuovamente, se lo desidera.*/ 
    include("aperturaSessioni.php");
    session_unset();

    session_destroy();
    
    header("Location: ../php/login.php");
    exit();
?>