<?php
    include("../including/aperturaSessioni.php");
    if(isset($_SESSION["entrato"]))
        $entrato = $_SESSION["entrato"];
    else
        $entrato = false;

    if($entrato == true){
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
        <link rel="icon" type="image/png" href="../Immagini/logo.png">
    </head>
    <!--in questo caso ho appena controllato se l'utente aveva già fatto l'accesso. In caso affermativo blocco l'accesso al login e alla registrazione in quanto
    non avrebbe senso permettere all'utente di rifare il login una volta che l'ha già fatto-->
    <body class="bodyErrato">
        <p class="segnalaErrore">Identità già verificata, se vuoi iscriverti con un altro account o accedere di nuovo alla pagina di login, esegui prima il <a href="../including/logout.php">LOGOUT</a></p>
        <a href="bacheca.php">>>Torna alla pagina di Bacheca</a>
    </body>
</html>
<?php
    /*blocco il resto così mostra solo la pagina in cui viene segnalato l'errore*/
    return;
    }
?>
<?php
    unset($_SESSION["errore"]);
        /*in questo caso controllo che i valori mandati dal form siano settati, nel caso in cui sono settati controllo 
        se il nome utente e la password sono corretti e, in caso affermativo, mando la pagina alla home dopo aver settato
        i cookies e le sessioni necessarie ad accedere*/
        if(isset($_REQUEST["nick"]) && isset($_REQUEST["password"])){
            /*pulisco i valori utilizzando la funzione trim() per evitare che l'utente abbia inserito degli spazi ai lati inavvertitamente*/
            $username = trim($_REQUEST["nick"]);
            $password_utente = trim($_REQUEST["password"]);
            /*come prima cosa mi devo prendere l'indirizzo del server che utilizzerò poco dopo per aprire la connessione. Nel caso in cui
            siano presenti degli errori durante l'apertura è sufficiente segnalarlo utilizzando echo o printf per mostrare all'utente o
            al programmatore che potrebbe esserci stato un problema.*/
            //facendo riferimento al pacco di slide 25_phpmyadmin utilizzo la variabile globale per ottenere l'indirizzo di rete (slide 25)
            $nome_server = $_SERVER["SERVER_ADDR"];
            $nome_utente = "normale";
            /*la password viene presa dal file contentente lo script sql per creare il database, 
            si farà la stessa cosa anche per l'utente privilegiato*/ 
            $password = "posso_leggere?";
            $nome_database = "social_network";

            $conn = mysqli_connect($nome_server, $nome_utente, $password, $nome_database); 
            //controllo che non ci siano errori nella connessione
            if(mysqli_connect_errno()){
                echo "<p>Errore connessione al DBMS: ".mysqli_connect_error()."</p>\n";
                //faccio in modo che stampi solo questo e segnali l'errore, non deve essere stampata la parte relativa alla registrazione
            }else{
                    /*in questo caso utilizzo le query nella versione prepared statement per evitare possibili sql injections
                    Quindi, anche se non si dovrebbe correre questo rischio in questo caso, è sempre meglio utilizzare i prepared statement per
                    evitare che vengano inseriti valori non voluti (modificando così la funzione della query)*/
                    $query = "SELECT * FROM utenti WHERE username=?";
                    $stmt = mysqli_prepare($conn, $query);
                    mysqli_stmt_bind_param($stmt, "s", $username);
                    if(!mysqli_stmt_execute($stmt)){
                        echo "<p>Errore query fallita, ricontrollare quale può essere il problema</p>";
                    }
                    //qui associo ad ogni valore una variabile, poi controllo che corrisponda alla password che si vuole
                    mysqli_stmt_bind_result($stmt, $fetched_nome, $fetched_cognome, $fetched_data_nascita, $fetched_indirizzo, $fetched_username, $fetched_password);
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
                    
                    if(isset($_SESSION["no_errore"]) == false){
                        /*creo una variabile globale che è true, per indicare che è presente un errore generico sull'interimento*/
                        $_SESSION["errore"] = true;
                    }   
                    mysqli_stmt_close($stmt);                    
                    if(!mysqli_close($conn)){
                                echo "<p>La connessione non si riesce a chiudere, errore.</p>";
                    } 
            }      
        }   
                ?>
<!DOCTYPE html>
<html lang="it">
    <head>
        <meta charset="UTF-8">
        <title>Login VortexNet</title>
        <meta name="author" content="Paolo Aimar">
        <meta name="keywords" lang="it" content="html">
        <meta name="description" content="pagina di accesso al sito web">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script src="../javascript/login_utente.js"></script>
        <link rel="stylesheet" href="../CSS/progetto.css">
        <!--icona presa dalla seguente -> https://icons8.it/icon/set/net/family-ios-->
        <link rel="icon" type="image/png" href="../Immagini/logo.png">
    </head>
    <body>
        <nav>
            <div class="navbar">
                <a href="home.php">Home</a>
                <a class="<?php include('../including/nomeClasse.php');?>" href="<?php include('../including/disabilitatoreRegistrazione.php');?>">Registra</a>
                <a class="<?php include('../including/nomeClasseLogout.php');?>" href="<?php include('../including/disabilitatoreScrivi.php');?>">Scrivi</a>
                <a class="<?php include('../including/nomeClasseLogout.php');?>" href="<?php include('../including/disabilitatoreBacheca.php');?>">Bacheca</a>
                <a id="attiva" class="attiva" href="login.php">Login</a>
                <a href="scopri.php">Scopri</a>
                <a class="<?php include('../including/nomeClasseLogout.php');?>" href="<?php include('../including/disabilitaLogout.php');?>">Logout</a>
            </div>
        </nav>
        <main>
            <div class="content">
                <!--anche in questo caso, come con la registrazione, utilizzo il metodo POST in quanto ci possono essere dati sensibili che 
                non dovrebbero essere visibili nell'URL (sempre precisando che questo non rende automaticamente sicuro il metodo Post, ma riesce
                a risolvere alcune problematiche del get relative alla privacy)-->
                <h1>Pagina di accesso al sito</h1>
                <form id="login" action="<?php echo $_SERVER['PHP_SELF'];?>" method="POST">
                    <div class="campo">
                        <!--In questo caso ho scelto di utilizzare una segnalazione di errore inserendo il testo dentro dentro ad un output e colorandolo
                        di rosso per segnalare all'utente che il login non è andato a buon fine in quanto mi sembra migliore alla segnalazione
                        tramite alert che andrebbe a scomparire una volta premuto il pulsante. Volendo si può fare sfruttando in CSS lo stile
                        visibility, andando a cambiare il valore. In alternativa si può lasciare il campo output vuoto, inserendo successivamente
                        dentro al tag il testo che si vuole far comparire-->
                        <output class="segnalaErrore"><?php
                    if(isset($_SESSION["errore"])){
                        if($_SESSION["errore"] == true){
                            /*ho decido di non distinguere gli errori nell'inserimento della password con quelli dell'inserimento
                            del nome utente (username) in quanto mi sembrava sufficiente specificare un possibile errore
                            (magari l'utente aveva inserito un utente esistente nel database che però non era il suo, sarebbe stato 
                            sbagliato segnalarli che era sbagliata la password) */
                            ?>
                            Errore in fase di Login, controllare che utente e password siano stati inseriti correttamente!
                            <?php
                        }
                    }
                ?></output>
                        <label for="nick">Username: </label>
                        <input type="text" id="nick" name="nick" minlength="4" maxlength="10" placeholder="inserire lo username" value="<?php include("../including/controlloCookies.php");?>" required>
                    </div>
                    <div class="campo">
                        <label for="password">Password: </label>
                        <input type="password" id="password" name="password" minlength="8" maxlength="16" placeholder="inserire la password" required>
                        <!--in questo caso non inserisco nessuna linea guida sulla password perchè, se l'utente si è già registrato, ci si immagina
                        che lui sappia già come debba essere il formato della password-->
                        <p>Non hai ancora un account? <a href="registrazione.php">Registrati</a></p>
                        <div class="lastBtn">
                            <input class="bottoni" type="submit" id="accedi" name="accedi" value="Login">
                            <!--Per creare un pulsante che cancelli i valori del form potevo anche utilizzare un bottone che richiamasse
                            una funzione javascript per cancellare i valori dentro ai campi del form. Ho preferito utilizzare questo 
                            input reset in quanto ci viene già fornito direttamente eseguendo le stesse funzioni -->
                            <input class="bottoni" type="reset" id="cancella" name="cancella" value="Cancella">
                        </div>   
                    </div> 
                </form>
                <!--per evitare di creare un altro form che abbia come action la pagina scopri, posso utilizzare anche un bottone
                generico che, una volta che viene premuto, ti rimanda alla pagina SCOPRI per vedere i tweet degli altri utenti
                Per far questo posso utilizzare una redirection verso quel sito utilizzando javascript-->
                <button id="continua" class="bottoni" onclick="rimandaAScopri();">Continua senza autenticarti</button>
            </div>
        </main>
        <!--Inserisco all'interno del footer possibili contatti e informazioni utili all'utente, ad esempio l'autore, la sua mail
        e altre informazioni di questo genere (prendo anche spunto dai primi laboratori)-->
        <footer>
                <!--inserisco il simbolo di copyright utilizzando la dicitura &copy; oppure &#169 per evitare successivi errori di 
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