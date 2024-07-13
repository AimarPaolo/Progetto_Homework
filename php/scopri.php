<?php
    include("../including/aperturaSessioni.php");
?>
<!DOCTYPE html>
<html lang="it">
    <head>
        <meta charset="UTF-8">
        <title>Scopri VortexNet</title>
        <meta name="author" content="Paolo Aimar">
        <meta name="keywords" lang="it" content="html">
        <meta name="description" content="pagina per guardare i tweet di altri utenti">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!--utilizzo ../ per prendere dalla cartella padre e poi specifico la cartella da cui voglio prendere il file da includere-->
        <link rel="stylesheet" href="../CSS/progetto.css">
        <!--icona presa dalla seguente -> https://icons8.it/icon/set/net/family-ios-->
        <link rel="icon" type="image/png" href="../Immagini/logo.png">
    </head>
    <body>
    <nav>
            <div class="navbar">
                <a href="home.php">Home</a>
                <a href="registrazione.php">Registra</a>
                <a class="<?php include('../including/nomeClasseLogout.php');?>" href="<?php include('../including/disabilitatoreScrivi.php');?>">Scrivi</a>
                <a class="<?php include('../including/nomeClasseLogout.php');?>" href="<?php include('../including/disabilitatoreBacheca.php');?>">Bacheca</a>
                <a class="<?php include('../including/nomeClasse.php');?>" href="<?php include('../including/disabilitatore.php');?>">Login</a>
                <a id="attiva" href="scopri.php">Scopri</a>
                <a class="<?php include('../including/nomeClasseLogout.php');?>" href="<?php include('../including/disabilitaLogout.php');?>">Logout</a>
            </div>
        </nav>
        <main>
            <div class="tweet_cornice">
                <h1>Scopri i tweets di tutti gli utenti</h1>
                <?php
                    $nome_server = $_SERVER["SERVER_ADDR"];
                    $nome_utente = "normale";
                    $password = "posso_leggere?";
                    $nome_database = "social_network";
                    $conn = mysqli_connect($nome_server, $nome_utente, $password, $nome_database); 
                    //controllo che non ci siano errori nella connessione
                    if(mysqli_connect_errno()){
                        echo "<p>Errore connessione al DBMS: ".mysqli_connect_error()."</p>\n";
                        //faccio in modo che stampi solo questo e segnali l'errore, non deve essere stampata la parte relativa alla registrazione
                    }else{
                            /*non impostando la codifica i caratteri accentati venivano visualizzati in maniera sbagliata. Aggiungendolo
                            viene impostata la codifica specificata (in questo caso utf8mb4). --> il valore della codifica lo prendo dallo
                            script presente sul sito, dove specifica anche il charset utilizzato per creare il database*/
                            mysqli_set_charset($conn, "utf8mb4");
                            $query = "SELECT * FROM tweets";
                            $stmt = mysqli_prepare($conn, $query);
                            if(!mysqli_stmt_execute($stmt)){
                                echo "<p>Errore query fallita, ricontrollare quale può essere il problema</p>";
                            }
                            mysqli_stmt_bind_result($stmt, $fetched_username, $fetched_data, $fetched_testo);
                            $_SESSION["errore"] = false;
                            while($row = mysqli_stmt_fetch($stmt)){
                                include("../including/tweetScopri.php");
                                }
                            }
                            mysqli_stmt_close($stmt);                    
                            if(!mysqli_close($conn)){
                                echo "<p>La connessione non si riesce a chiudere, errore.</p>";
                            }   
                ?>
             
            </div>
        </main>
        <footer>
            <!--inserisco il simbolo di copyright utilizzando la dicitura &copy; oppure &#169 per evitare succeffici errori di 
            interpretazione del sito web-->
            <div>Sito web realizzato da Aimar Paolo. Anno 2024 | Copyright | Tutti i diritti riservati &copy;</div>
            <div><a href="mailto:s297424@studenti.polito.it">Email: s297424@studenti.polito.it</a></div>
            <!--Dato che una delle richieste del sito è quello di calcolarsi il più possibile le informazioni autonomamente, 
            posso calcolare direttamente il nome della pagina sfruttando la variabile globale $_SERVER (il problema è che mi dava
            tutto il percorso. Cercando su internet ho trovato il comando basename che ti restituisce solamente il valore a noi
            interessato)-->
            <div>Pagina Corrente: <?php echo basename($_SERVER['PHP_SELF']);?></div>
    </footer>
    </body>
</html>