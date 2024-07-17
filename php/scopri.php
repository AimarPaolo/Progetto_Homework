<?php
    include("../including/aperturaSessioni.php");
    if(isset($_SESSION["entrato"]))
        $entrato = $_SESSION["entrato"];
    else
        $entrato = false;
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
    <body id="body_scopri">
    <nav>
            <div id="navbar_scopri" class="navbar">
                <a href="home.php">Home</a>
                <a class="<?php include('../including/nomeClasse.php');?>" href="<?php include('../including/disabilitatoreRegistrazione.php');?>">Registra</a>
                <a class="<?php include('../including/nomeClasseLogout.php');?>" href="<?php include('../including/disabilitatoreScrivi.php');?>">Scrivi</a>
                <a class="<?php include('../including/nomeClasseLogout.php');?>" href="<?php include('../including/disabilitatoreBacheca.php');?>">Bacheca</a>
                <a class="<?php include('../including/nomeClasse.php');?>" href="<?php include('../including/disabilitatore.php');?>">Login</a>
                <a id="attiva" href="scopri.php">Scopri</a>
                <a class="<?php include('../including/nomeClasseLogout.php');?>" href="<?php include('../including/disabilitaLogout.php');?>">Logout</a>
            </div>
        </nav>
        <main>
            <?php
            /*non lo vado ad inserire anche in login e registrazione perchè non si potrà mai entrare in quelle pagina quando
            il login è stato fatto*/
                if($entrato == true){
                    include("../including/indicazione.php");
                }
            ?>
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
                            /*Li ordino per data decrescente perchè è più sensato mostrare per primi i commenti più recenti*/
                            $query = "SELECT * FROM tweets ORDER BY data DESC";
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
            <!--aggiungo un collegamento ipertestuale per tornare a inizio pagina-->
            <!--purtroppo la grafica non è delle migliori, in quando quando si torna verso l'alto (sui dipositivi mobile) il bottone tende
            a spostarsi leggermente dalla sua dimensione e, inoltre, il bottone rischia di andare a sovrapporsi con il footer-->
            <!--le dimensioni ridotte del bottone non dovrebbero disturbare troppo la visibilità dei tweet in quanto, a meno che non tengano le dimensioni 
            massime consentite, non dovrebbero intersecarsi-->
            <a id="bottone_tornaSu"class="bottoni" href="#navbar_scopri">torna su</a>
            </div>
            <div class="messaggio_no_stampa">
            <!--aggiungo un messaggio di mancata stampa + diritti di copyright-->
            <div>&copy; 2024 Aimar Paolo. Tutti i diritti riservati.</div>
            <!--inserisco inoltre la url della pagina, in modo che la persona, nel caso in cui volesse, può ritornare a quella pagina seguendo il link-->
            <div>Pagina Corrente: <?php echo $_SERVER['PHP_SELF'];?></div>
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