<?php
    /*anche per la creazione dell'indicazione utilizzo una connessione normale in quanto non ho bisogno di modificare i dati*/
    $nome_server = $_SERVER["SERVER_ADDR"];
    $nome_utente = "normale";
    $password = "posso_leggere?";
    $nome_database = "social_network";
    $conn = mysqli_connect($nome_server, $nome_utente, $password, $nome_database); 
    /*limit indica il numero di rows che si va a salezionare. Inserendo limit 1 prenderò solamente l'ultimo tweet inserito (ordino
    anche per data altrimenti prenderei solamente il primo)*/
    $query = "SELECT * FROM tweets WHERE username=? ORDER BY data DESC LIMIT 1";
    $stmt = mysqli_prepare($conn, $query);
    if(!isset($_SESSION["nome_utente"])){
        echo "<p>Username non settato</p>";
        exit();
    }
    mysqli_stmt_bind_param($stmt, "s", $_SESSION["nome_utente"]);
    if(!mysqli_stmt_execute($stmt)){
        echo "<p>Errore query fallita, ricontrollare quale può essere il problema</p>";
        exit();
    }else{
    mysqli_stmt_bind_result($stmt, $fetched_username, $fetched_data, $fetched_testo);
    $_SESSION["errore"] = false;
    $risultato = mysqli_stmt_fetch($stmt);
    if($risultato) {
        ?>
        <div class="indicazione">
            <div class="bordo">
                <div class="titolo_grassetto">Username:</div><?php echo $fetched_username; ?>
                <div class="titolo_grassetto">Data:</div><?php echo $fetched_data; ?>
                <div class="titolo_grassetto">Testo:</div><?php echo $fetched_testo; ?>
            </div>
        </div>
        <?php
    }else{
        ?>
        <div class="indicazione">
                <div class="bordo">
                    <!--nel caso in cui non ci siano ancora dei tweet non viene mostrato niente nel valore della data e del testo-->
                    <div class="titolo_grassetto">Username:</div><?php echo $_SESSION["nome_utente"] ?>
                    <div class="titolo_grassetto">Data:</div>
                    <div class="titolo_grassetto">Testo:</div>
                </div>
            </div>
            <?php
    }
    mysqli_stmt_close($stmt);                    
    if(!mysqli_close($conn)){
        echo "<p>La connessione non si riesce a chiudere, errore.</p>";
        exit();
    }   
}

    ?>