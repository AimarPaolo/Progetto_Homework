<?php
    /*anche per la creazione dell'indicazione utilizzo una connessione normale in quanto non ho bisogno di modificare i dati*/
    $nome_server = $_SERVER["SERVER_ADDR"];
    $nome_utente = "normale";
    $password = "posso_leggere?";
    $nome_database = "social_network";
    $conn = mysqli_connect($nome_server, $nome_utente, $password, $nome_database); 
?>