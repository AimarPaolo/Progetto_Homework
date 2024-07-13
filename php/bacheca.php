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
            $query = "SELECT * FROM tweets WHERE username=?";
            $stmt = mysqli_prepare($conn, $query);
            $username = $_SESSION["nome_utente"];
            mysqli_stmt_bind_param($stmt, "s", $username);
            if(!mysqli_stmt_execute($stmt)){
                echo "<p>Errore query fallita, ricontrollare quale può essere il problema</p>";
            }
            //qui associo ad ogni valore una variabile, poi controllo che corrisponda alla password che si vuole
            mysqli_stmt_bind_result($stmt, $fetched_username, $fetched_data, $fetched_testo);
            $_SESSION["errore"] = false;
            while($row = mysqli_stmt_fetch($stmt)){
                //in questo caso non c'è il rischio che venga stampato più volte dato che il risultato sarà al massimo
                //una sola riga
                //echo $password_utente."<p>bravissimo</p>".$fetched_password; --> usato per controllare se erano uguali in quanto non entrava nell'if
                if($password_utente == $fetched_password){
                    $_SESSION["no_errore"] = true;
                    $_SESSION["entrato"] = true;
                    $_SESSION["appena_entrato"] = true;
                    /*mi salvo lo username che verrà poi utilizzato per assegnare il nome ai tweets*/
                    $_SESSION["nome_utente"] = $username;
                    //a questo punto, dato che l'utente è riuscito a fare l'accesso, setto i cookies per salvare quale è l'ultimo nome con cui ha fatto l'accesso
                    //utilizzo i cookie in quanto non mi interessa se questo dato viene modificato dal client (in quanto i cookies
                    //possono essere modificati in quanto salvati lato client)
                    setcookie('ultimo_accesso', $username, time() + 57600, '/');
                    //chiudo anche in questo caso la connessione
                    if(!mysqli_close($conn)){
                        echo "<p>La connessione non si riesce a chiudere, errore.</p>";
                        /*utilizzando il return ho visto che si bloccava il codice e mostrava una pagina bianca, ho sostituito con exit()*/ 
                        exit();
                    } 
                    header("Location: bacheca.php");
                    exit();
                }
            }
            mysqli_stmt_close($stmt);                    
            if(!mysqli_close($conn)){
                        echo "<p>La connessione non si riesce a chiudere, errore.</p>";
            } 
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
    </head>
    <body>
        <nav>
            <div class="navbar">
                <a href="home.php">Home</a>
                <a href="registrazione.php">Registra</a>
                <a class="<?php include('../including/nomeClasseLogout.php');?>" href="<?php include('../including/disabilitatoreScrivi.php');?>">Scrivi</a>
                <a id="attiva" class="<?php include('../including/nomeClasseLogout.php');?>" href="<?php include('../including/disabilitatoreBacheca.php');?>">Bacheca</a>
                <a class="<?php include('../including/nomeClasse.php');?>" href="<?php include('../including/disabilitatore.php');?>">Login</a>
                <a href="scopri.php">Scopri</a>
                <a class="<?php include('../including/nomeClasseLogout.php');?>" href="<?php include('../including/disabilitaLogout.php');?>">Logout</a>
            </div>
        </nav>
        <main>
            <?php
            /*ho voluto creare un messaggio che avvisa l'utente quando è riuscito ad accedere, SOLAMENTE la prima volta, quando inizia a navigare 
            non mi interessa più avvisarlo nuovamente e quindi il messaggio scompare (per questo non ho utilizzato la variabile entrato, quella rimane true quando 
            l'utente non ha cliccato su logout)*/
            if($appena_entrato == true)
                echo "<p class=\"successo\">Accesso effettuato con successo!</p>";
            ?>
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