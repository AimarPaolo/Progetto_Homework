<?php
    include("../including/aperturaSessioni.php");
    if(isset($_SESSION["entrato"]))
        $entrato = $_SESSION["entrato"];
    else
        $entrato = false;

    if($entrato == false){
        ?>
<!DOCTYPE html>
<html lang="it">
    <head>
        <meta charset="UTF-8">
        <title>Scrivi VortexNet</title>
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
    if(isset($_REQUEST["testo"]) && $_REQUEST["testo"] != ""){
        /*utilizzo l'utente privilegiato per poter inserire il tweet nel database e salvarlo*/
        $nome_server = $_SERVER["SERVER_ADDR"];
        $nome_utente = "privilegiato";
        $password_accesso = "SuperPippo!!!";
        $nome_database = "social_network";

        $conn = mysqli_connect($nome_server, $nome_utente, $password_accesso, $nome_database); 
        if(mysqli_connect_errno()){
            $_SESSION["messaggio_di_errore"] = "Errore connessione al DBMS: ".mysqli_connect_error();
        }
        mysqli_set_charset($conn, "utf8mb4");
        /*mi prendo l'ora in cui è stato creato il tweet attraverso uno dei comandi di php*/
        /*volendo si poteva anche utilizzare il comando NOW(). Dato che viene richiesto l'orario del server a cui è connesso il
        sito si utilizza il comando scritto qui sotto, NON conciderà con quello si vede sull'orologio in quando si riferisce
        all'orario del server che è presente in un altro fusorario*/
        $data = date("Y-m-d  H:i:s"); 
        $testo = trim($_REQUEST["testo"]);
        $query_username = "INSERT INTO tweets (username, data, testo) VALUES (?, ?, ?)";
        $stmt = mysqli_prepare($conn, $query_username);
        /*in questo caso posso controllare anche che l'username session sia settato, ma solitamente viene settato insieme al login
        o alla registrazione, quindi se entrato è true allora quasi sicuramente anche lo username sarà settato*/
        if(isset($_SESSION["nome_utente"])){
            //echo "sono entrato nell'if";
            mysqli_stmt_bind_param($stmt, "sss", $_SESSION["nome_utente"], $data, $testo);
            if (!mysqli_stmt_execute($stmt)) {
                $_SESSION["messaggio_di_errore"] = "Errore query fallita, ricontrollare quale può essere il problema";
            } else {
                $_SESSION["messaggio_di_successo"] = "Il tuo tweet è stato postato con successo!!";
                /*ho deciso di tenere i filtri validi fino alla chiusura del browser, eccetto quando viene scritto un nuovo tweet.
                In quel caso elimino le variabili di sessione così che quando vengo reindirizzato alla pagina di bacheca non 
                rimangono i filtri settati e posso vedere tutti i tweet scritti dall'utente*/
                unset($_SESSION["filtro1"]);
                unset($_SESSION["filtro2"]);
            }
            
        } else {
            $_SESSION["messaggio_di_errore"] = "Errore, lo username non è stato settato!";
        }
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
        header("Location: bacheca.php");
        exit();
    }
?>
<!DOCTYPE html>
<html lang="it">
    <head>
        <meta charset="UTF-8">
        <title>Scrivi VortexNe</title>
        <meta name="author" content="Paolo Aimar">
        <meta name="keywords" lang="it" content="html">
        <meta name="description" content="pagina per scrivere un nuovo tweet">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../CSS/progetto.css">
        <!--icona presa dalla seguente -> https://icons8.it/icon/set/net/family-ios-->
        <link rel="icon" type="image/png" href="../Immagini/logo.png">
    </head>
    <body>
        <nav>
            <div class="navbar">
                <a href="home.php">Home</a>
                <a class="<?php include('../including/nomeClasse.php');?>" href="<?php include('../including/disabilitatoreRegistrazione.php');?>">Registra</a>
                <a id="attiva" class="<?php include('../including/nomeClasseLogout.php');?>" href="<?php include('../including/disabilitatoreScrivi.php');?>">Scrivi</a>
                <a class="<?php include('../including/nomeClasseLogout.php');?>" href="<?php include('../including/disabilitatoreBacheca.php');?>">Bacheca</a>
                <a class="<?php include('../including/nomeClasse.php');?>" href="<?php include('../including/disabilitatore.php');?>">Login</a>
                <a href="scopri.php">Scopri</a>
                <a class="<?php include('../including/nomeClasseLogout.php');?>" href="<?php include('../including/disabilitaLogout.php');?>">Logout</a>
            </div>
        </nav>
        <main>
            <?php
                if($entrato == true){
                    include("../including/indicazione.php");
                }
            ?>
            <!--a questo punto creo un form che mandi direttamente i dati alla pagina PHP_SELF in modo da raccogliere i dati ed 
            inserirli nel database-->
                <div class="segnalaErrore"><?php
                    if(isset($_SESSION["messaggio_di_errore"])){
                        $mess = $_SESSION["messaggio_di_errore"];
                        echo $mess;
                        unset($_SESSION["messaggio_di_errore"]);
                    }
                    ?>
                    </div>
            <div class="new_tweet">
                <h1>Scrivi un tweet per condividerlo con tutti! Mostra alle persone quello che pensi</h1>
                <!--alt corrisponde all'alternativa nel caso in cui non si riesca a caricare l'immagine. Viene mostrato il testo
                per non presentare una parte completamente vuota-->
                <div><img src="../Immagini/condividi.jpg" alt="immagine condivisione tweet"></div>
                <form id="formScrivi" name="formScrivi" action="<?php echo $_SERVER['PHP_SELF'];?>" method="POST">
                    <label for="testo">Inserire il testo da pubblicare:</label>
                    <textarea name="testo" id="testo" minlength="3" maxlength="140"></textarea>
                    <span class="guida_scrivi">*Inserire un tweet lungo al massimo 140 caratteri!</span>
                    <!--in questo caso utilizzo una nuova classe, in quanto i bottoni del login stanno bene in posizioni diverse
                    rispetto a questo-->
                    <input id="pubblica" name="pubblica" class="bottoni_scrivi" type="submit" value="Pubblica">
                </form>
            </div>
            <div class="messaggio_no_stampa">
            <!--aggiungo un messaggio di mancata stampa + diritti di copyright-->
            <div>&copy; 2024 Aimar Paolo. Tutti i diritti riservati.</div>
            <!--inserisco inoltre la url della pagina, in modo che la persona, nel caso in cui volesse, può ritornare a quella pagina seguendo il link-->
            <div>Pagina Corrente: <?php echo $_SERVER['PHP_SELF'];?></div>
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