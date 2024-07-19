<?php
    include("../including/aperturaSessioni.php");
    if(isset($_SESSION["entrato"]))
        $entrato = $_SESSION["entrato"];
    else
        $entrato = false;
    if(isset($_SESSION["appena_entrato"])){
        $appena_entrato = true;
        unset($_SESSION["appena_entrato"]);
    }
    //in questo caso voglio che i filtri rimangano fino a quando non viene scritto un altro tweet o fino a quando non chiudo il web, quindi me li salvo in variabili di sessione
    if(isset($_REQUEST["filtro1"]))
        $_SESSION["filtro1"] = $_REQUEST["filtro1"];
    if(isset($_REQUEST["filtro2"]))
    $_SESSION["filtro2"] = $_REQUEST["filtro2"];
    if($entrato == false){
?>
<!DOCTYPE html>
<html lang="it">
    <head>
        <meta charset="UTF-8">
        <title>Bacheca VortexNet</title>
        <meta name="author" content="Paolo Aimar">
        <meta name="keywords" lang="it" content="html">
        <meta name="description" content="pagina per guardare i tweet che l'utente ha fatto">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../CSS/progetto.css">
        <!--icona presa dalla seguente -> https://icons8.it/icon/set/net/family-ios-->
        <link rel="icon" type="image/png" href="../Immagini/logo.png">
    </head>
    <body class="bodyErrato">
        <p class="segnalaErrore">Identità non verificata, l'utente non ha ancora eseguito l'accesso. Verifica l'identità per poter accedere a questa parte!</p>
        <a href="login.php">Torna alla pagina di Login</a>
    </body>
</html>
<?php
    /*blocco il resto così mostra solo la pagina in cui viene segnalato l'errore*/
    return;
    }
    ?>
<!DOCTYPE html>
<html lang="it">
    <head>
        <meta charset="UTF-8">
        <title>Bacheca VortexNet</title>
        <meta name="author" content="Paolo Aimar">
        <meta name="keywords" lang="it" content="html">
        <meta name="description" content="pagina per guardare i tweet che l'utente ha fatto">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../CSS/progetto.css">
        <!--icona presa dalla seguente -> https://icons8.it/icon/set/net/family-ios-->
        <link rel="icon" type="image/png" href="../Immagini/logo.png">
        <script src="../javascript/filtri_bacheca.js"></script>
    </head>
    <body>
        <nav>
            <div class="navbar">
                <a href="home.php">Home</a>
                <a class="<?php include('../including/nomeClasse.php');?>" href="<?php include('../including/disabilitatoreRegistrazione.php');?>">Registra</a>
                <a class="<?php include('../including/nomeClasseLogout.php');?>" href="<?php include('../including/disabilitatoreScrivi.php');?>">Scrivi</a>
                <a id="attiva" class="<?php include('../including/nomeClasseLogout.php');?>" href="<?php include('../including/disabilitatoreBacheca.php');?>">Bacheca</a>
                <a class="<?php include('../including/nomeClasse.php');?>" href="<?php include('../including/disabilitatore.php');?>">Login</a>
                <a href="scopri.php">Scopri</a>
                <a class="<?php include('../including/nomeClasseLogout.php');?>" href="<?php include('../including/disabilitaLogout.php');?>">Logout</a>
            </div>
        </nav>
        <main>
            <!--inserisco un'immagine non troppo grande per evitare di ridimensionarla troppo, in quanto voglio creare un mini
            pattern a forma di tornado (inserita come sfondo del body)-->
            <?php
                /*ho voluto creare un messaggio che avvisa l'utente quando è riuscito ad accedere, SOLAMENTE la prima volta, quando inizia a navigare 
                non mi interessa più avvisarlo nuovamente e quindi il messaggio scompare (per questo non ho utilizzato la variabile entrato, quella rimane true quando 
                l'utente non ha cliccato su logout)*/
                if($appena_entrato == true){
                    echo "<p class=\"successo\">Accesso effettuato con successo!</p>";
                    unset($_SESSION["appena_entrato"]);
                }
                if(isset($_SESSION["messaggio_di_successo"])){
                    $mess = $_SESSION["messaggio_di_successo"];
                    echo "<div class=\"successo\">".$mess."</div>";
                    unset($_SESSION["messaggio_di_successo"]); 
                }
                if($entrato == true){
                    include("../including/indicazione.php");
                }
                /*ho decido di utilizzare gli echo piuttosto che chiuedere e riaprire il codice PHP in quanto, per pezzi di codice
                molto piccoli, potrebbe risultare confusionario chiudere e riaprire (codice molto più pulito)*/
                echo "<h1>Divertiti a guardare i tweet scritti da te!!</h1>";
                $nome_server = $_SERVER["SERVER_ADDR"];
                $nome_utente = "normale";
                $password = "posso_leggere?";
                $nome_database = "social_network";
                $conn = mysqli_connect($nome_server, $nome_utente, $password, $nome_database); 
                mysqli_set_charset($conn, "utf8mb4");
                //controllo che non ci siano errori nella connessione
                if(mysqli_connect_errno()){
                    echo "<p>Errore connessione al DBMS: ".mysqli_connect_error()."</p>\n";
                    //faccio in modo che stampi solo questo e segnali l'errore, non deve essere stampata la parte relativa alla registrazione
                }else{
                    if(isset($_SESSION["filtro1"]) && isset($_SESSION["filtro2"]) && $_SESSION["filtro1"]!="" && $_SESSION["filtro2"]){
                        //se entrambi i filtri sono settati controllo che la data sia compresa tra quei due valori
                        $query = "SELECT * FROM tweets WHERE username=? AND data>=? AND data<=? ORDER BY data DESC";
                        $stmt = mysqli_prepare($conn, $query);
                        $username = $_SESSION["nome_utente"];
                        $data1 = $_REQUEST["filtro1"];
                        $data2 = $_REQUEST["filtro2"];
                        mysqli_stmt_bind_param($stmt, "sss", $username, $data1, $data2);
                    }elseif(isset($_SESSION["filtro1"]) && $_SESSION["filtro1"] != ""){
                        //in questo caso ho solo il primo filtro settato, quindi mi prenderò tutti i tweet successivi a quella data
                        $query = "SELECT * FROM tweets WHERE username=? AND data>=? ORDER BY data DESC";
                        $stmt = mysqli_prepare($conn, $query);
                        $username = $_SESSION["nome_utente"];
                        $data1 = $_SESSION["filtro1"];
                        mysqli_stmt_bind_param($stmt, "ss", $username, $data1);
                    }elseif(isset($_SESSION["filtro2"]) && $_SESSION["filtro2"] != ""){
                        $query = "SELECT * FROM tweets WHERE username=? AND data<=? ORDER BY data DESC";
                        $stmt = mysqli_prepare($conn, $query);
                        $username = $_SESSION["nome_utente"];
                        $data2 = $_SESSION["filtro2"];
                        mysqli_stmt_bind_param($stmt, "ss", $username, $data2);
                    }elseif((!isset( $_SESSION["filtro2"]) && !isset($_SESSION["filtro1"])) || ($_SESSION["filtro1"] == "" && $_SESSION["filtro1"]=="")){
                        //se non è settato nessun filtro, la pagina viene visualizzata normalmente senza filtri sulle data
                        $query = "SELECT * FROM tweets WHERE username=? ORDER BY data DESC";
                        $stmt = mysqli_prepare($conn, $query);
                        $username = $_SESSION["nome_utente"];
                        mysqli_stmt_bind_param($stmt, "s", $username);
                    }
                    if (!mysqli_stmt_execute($stmt)) {
                        $_SESSION["messaggio_di_errore"] = "Errore query fallita, ricontrollare quale può essere il problema";
                    }
                    //qui associo ad ogni valore una variabile, poi controllo che corrisponda alla password che si vuole
                    mysqli_stmt_bind_result($stmt, $fetched_username, $fetched_data, $fetched_testo);
                        $has_results = false;
                        while (mysqli_stmt_fetch($stmt)) {
                            $risultato = true;
                            /*implemento una struttura simile a quella di scopri per mantenere un format coerente in tutte le pagine*/
                            include("../including/tweetBacheca.php");
                        }
                        if (!$risultato && (!isset($_SESSION["filtro1"]) && !isset($_SESSION["filtro2"]))) {
                    ?>
                    <?php
                        /*in questo caso ho controllato se esisteva un risultato. In caso affermativo stampo i tweet che sono 
                        stati scritto dall'utente, in caso negativo si stampa il messaggio per invogliare l'utente a scrivere un messaggio
                        */
                        echo " 
                        <p class=\"aggiungi_tweet\">Non hai ancora scritto nessun tweet... Aggiungine uno per condividere subito quello che pensi con tutti!</p>
                        <p class=\"aggiungi_tweet\">Per aggiungere un tweet passa alla pagina <a href=\"scrivi.php\">SCRIVI</a></p>
                        ";
                    }elseif(!$risultato){
                        echo"<p class=\"aggiungi_tweet\">Non sono presenti tweet nel periodo che hai selezionato. Prova a selezionarne un altro oppure scrivine uno ora!</p>
                        <p class=\"aggiungi_tweet\">Per aggiungere un tweet passa alla pagina <a href=\"scrivi.php\">SCRIVI</a></p>";
                    }
                }
            ?>
            <!--In questo caso non metto nessun controllo degli input perchè non mi interessa controllare che siano settati (sicuro sono
            corretti in quanto utilizzo un input date). Cercherò solo di escludere attraverso PHP -->
            <!--metto inoltre un metodo get per il form, in quanto non sto inviando dati sensibili o file per i quali è strettamente
            richiesto e consigliato il metodo POST-->
            <!--non utilizzo in questo caso echo o printf perchè il codice HTML risultante è parecchio lungo (non c'è il rischio di 
            di rendere difficoltosa la lettura del codice) inoltre, è possibile visualizzare meglio i commenti inseriti all'interno del codice-->
            <form id="form_bacheca" name="form_bacheca" action="bacheca.php" method="GET">
                <output id="segnalaErrore" name="segnalaErrore">
                    <?php
                        if(isset($_SESSION["messaggio_di_errore"])){
                            $mess = $_SESSION["messaggio_di_errore"];
                            echo $mess;
                            unset($_SESSION["messaggio_di_errore"]);
                        }
                    ?>
                </output>
                <label for="filtro1">Inserire la data di inzio per cui si vuole filtrare: </label>
                <input type="datetime-local" id="filtro1" name="filtro1">
                <label for="filtro1">Inserire la data di fine per cui si vuole filtrare: </label>
                <input type="datetime-local" id="filtro2" name="filtro2">
                <input class="bottoni" type="button" id="filtra" name="filtra" value="filtra" onclick="validateForm('form_bacheca');">
                <!--in questo caso devo fare in modo che accetti anche il fatto che non siano settati i due filtri, quindi richiamo una funzione
                che poi farà un submit diretto del form (senza eseguire controlli)-->
                <input class="bottoni" type="button" id="salta_filtri" name="salta_filtri" value="Mostra tutti i tweet personali" onclick="submitCall('form_bacheca');">
            </form>
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