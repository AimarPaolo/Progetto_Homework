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
    /*in questo caso, a differenza del login, non utilizzo la connessione con un utente normale ma con un utente privilegiato,
    questo perchè l'utente deve poter aver la possibilità di inserire i dati delle iscrizioni dentro il database, aggiornandolo; 
    cosa che non era necessaria invece per il login*/
    if(isset($_REQUEST["name"]) && isset($_REQUEST["surname"]) && isset($_REQUEST["birthdate"]) && isset($_REQUEST["adress"]) && isset($_REQUEST["nick"]) && isset($_REQUEST["password"]) && $_REQUEST["name"] != "" && isset($_REQUEST["surname"]) && $_REQUEST["birthdate"]!="" && $_REQUEST["adress"]!="" && $_REQUEST["nick"] != "" && $_REQUEST["password"] != ""){
        /*non ho bisogno di prendere anche i dati della password ripetuta, quella mi serviva come controllo iniziale e per aiutare 
        l'utente ad inserire entrambe le password correttamente, non è utile per fare operazioni sul database in quanto è 
        sufficiente utilizzare quella non ancora ripetuta*/ 

        /*utilizzo il metodo request in quando non so che pagina arrivi, potrebbe essere quella presente nel sito come un'altra 
        che non possiamo prevedere, quindi non si può nemmeno prevedere se i dati verranno inviati tramite un metodo post o get*/
        $name = trim($_REQUEST['name']);
        $surname = trim($_REQUEST['surname']);
        $birthdate = trim($_REQUEST['birthdate']);
        $address = trim($_REQUEST['adress']);
        $nick = trim($_REQUEST['nick']);
        $password_utente = trim($_REQUEST['password']);
        /*A questo punto controllo nuovamente che i dati che sono stati inseriti non sia sbagliati, utilizzando le regexp che avevo
        utilizzato già prima con javascript*/
        $name_regexp= "/^[A-Z][a-zA-Z ]{1,11}$/";
        $surname_regexp = "/^[A-Z][a-zA-Z ]{1,15}$/";
        $birthdate_regexp = "/^\d{4}-\d{1,2}-\d{1,2}$/";
        /*permetto anche l'inserimento delle lettere accentate nella via*/
        $indirizzo_regexp = "/^(Via|Corso|Largo|Piazza|Vicolo) [a-zA-Zàèéìòù\s]+ \d{1,4}$/";
        $username_regexp = "/^[a-zA-Z][a-zA-Z0-9_-]{3,9}$/";
        $password_regexp = "/^(?=(.*[\d]){2})(?=.*[A-Z])(?=.*[a-z])(?=(.*[!?#@%^&*+=]){2})[A-Za-z\d!?#@%^&*+=]{8,16}$/";
        
        /*ho fatto prima i controlli dei dati mandati al server così evito di aprire inultimente la connessione, rallentando 
        così il sito*/
        if(!preg_match($name_regexp,$name)) {
            /*utilizzo la sessione per salvarmi il messaggio di errore e, una volta salvato, lo faccio poi inserire se settato dentro
            la parte di registrazione*/ 
            $_SESSION["messaggio_di_errore"] = "Errore nella lettura dei dati dal server, controlla che il nome inserito sia corretto";
            header('Location: registrazione.php');
            exit();
        }
        if(!preg_match($surname_regexp, $surname)) {
            $_SESSION["messaggio_di_errore"] = "Errore nella lettura dei dati dal server, controlla che il cognome inserito sia corretto";
            header('Location: registrazione.php');
            exit();
        }
        if(!preg_match($birthdate_regexp, $birthdate)) {
            $_SESSION["messaggio_di_errore"] = "Errore nella lettura dei dati dal server, controlla che la data di nascita inserita sia corretta";
            header('Location: registrazione.php');
            exit();
        }
        if(!preg_match($indirizzo_regexp, $address))  {
            $_SESSION["messaggio_di_errore"] = "Errore nella lettura dei dati dal server, controlla che l'indirizzo inserito sia corretto";
            header('Location: registrazione.php');
            exit();
        }
        if(!preg_match($username_regexp, $nick)) {
            $_SESSION["messaggio_di_errore"] = "Errore nella lettura dei dati dal server, controlla che l'username inserito sia corretto";
            header('Location: registrazione.php');
            exit();
        }
        if(!preg_match($password_regexp, $password_utente)) {
            $_SESSION["messaggio_di_errore"] = "Errore nella lettura dei dati dal server, controlla che la password inserita sia corretta";
            header('Location: registrazione.php');
            exit();
        }
        //controllo anche che l'anno inserito sia corretto, come veniva già fatto in javascript
        if(intval(explode("-", $birthdate)[0]) >= date("Y")){
            $_SESSION["messaggio_di_errore"] = "Errore nell'inserimento della data!";
            header('Location: registrazione.php');
            exit();
        }
        $nome_server = $_SERVER["SERVER_ADDR"];
        $nome_utente = "privilegiato";
        $password_accesso = "SuperPippo!!!";
        $nome_database = "social_network";

        $conn = mysqli_connect($nome_server, $nome_utente, $password_accesso, $nome_database); 
        mysqli_set_charset($conn, "utf8mb4");
        if(mysqli_connect_errno()){
            echo "<p>Errore connessione al DBMS: ".mysqli_connect_error()."</p>\n";
            exit();
        }
        /*applico anche in questo caso un prepared statement per evitare che un utente malevolo modifichi la query per farsi
        stampare o inserire contenuti. */
        $query_username = "SELECT utenti.username FROM utenti WHERE username = ?";
        /*utilizzo questa query per controllare che l'utente che si vuole registrare non voglia registrarsi con un username già utilizzato*/
        $stmt = mysqli_prepare($conn, $query_username);
        mysqli_stmt_bind_param($stmt, "s", $nick);
        if(!mysqli_stmt_execute($stmt)){
            echo "<p>Errore query fallita, ricontrollare quale può essere il problema</p>";
        }
        mysqli_stmt_bind_result($stmt, $fetched_username);
        while($row = mysqli_stmt_fetch($stmt)){
            /*Se entra nel ciclo vuol dire che il numero di righe è diverso da 0 (in questo caso può solo essere 1) e quindi mando
            il messaggio di errore dicendo che il nome utente inserito è già utilizzato*/
            /*volevo anche aggiungere un modo per salvare i dati e non dover reinserire tutti i campi ma solo lo username, quando viene ripetuto.*/
            $_SESSION["messaggio_di_errore"] = "Il nome utente da lei scelto è già utilizzato, selezionarne un altro.";
            header("Location: registrazione.php");
            exit();
        }
        /*si potrebbero aprire apposta due connessioni, una normale per fare la parte appena eseguita e una invece privilegiata che verrebbe utilizzata
        per inserire i dati dentro al database. In questo caso, per rendere il sito più fruibile e veloce nel caricare i dati, preferisco utilizzare un'unica 
        connessione privilegiata*/
        $query_inserimento = "INSERT INTO utenti (nome, cognome, data, indirizzo, username, pwd) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $query_inserimento);
        /*inserisco la data come stringa, "aaaa-mm-gg"*/
        mysqli_stmt_bind_param($stmt, "ssssss", $name, $surname, $birthdate, $address, $nick, $password_utente);
        $result = mysqli_stmt_execute($stmt);
        if(!$result){
                $_SESSION["messaggio_di_errore"] =  "<p>Errore query fallita: ".mysqli_error($conn)."</p>\n";
                header("Location: registrazione.php");
                mysqli_stmt_close($stmt);
                mysqli_close($conn);
                exit();
        }else{
            /*In questo caso, per migliorare l'esperienza dell'utente ho deciso che, dopo aver eseguito la registrazione, fino a quando si mantiene la sessione aperta
            o fino all'operazione di logout, non è necessario effettuare di nuovo il login. Questo potrebbe ridurre leggermente la si*/
            $_SESSION["no_errore"] = true;
            $_SESSION["entrato"] = true;
            $_SESSION["appena_entrato"] = true;
            $_SESSION["nome_utente"] = $nick;
            /*questo lo considero come un accesso, quindi anche in questo caso mi creo i cookies*/
            setcookie('ultimo_accesso', $username, time() + 57600, '/');
            mysqli_stmt_close($stmt);
            mysqli_close($conn);
            header("Location: bacheca.php");
            exit();
        }   
    }
?>
<!DOCTYPE html>
<html lang="it">
    <head>
        <!--nella prima parte dell'header identifico subito il tipo di codifica in modo tale che si sappia subito quale utilizzare-->
        <!--bisogna sempre dichiararlo entro i primi 1024 byte per sapere fin da subito la codifica che verrà utilizzata per il file
        (riferimento slide 01_HTML pagina 21 + appunti personali)-->
        <meta charset="UTF-8">
        <title>Registrazione VortexNet</title>
        <!--in questo caso inserisco diversi content per indicizzare la pagina web o per descrivere cosa farà principalmente
        questa pagina (ad esempio nella description)-->
        <meta name="author" content="Paolo Aimar">
        <meta name="keywords" lang="it" content="html">
        <meta name="description" content="pagina di registrazione al sito web">
        <!--utilizzo questo tag per ingrandire la visualizzazione nel caso in cui il dispositivo sia un mobile o sia un dispositivo
        diverso-->
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!--utilizzo il comando script per richiamare la pagina contente le funzioni utili per il corretto sviluppo della pagina
        es. validazione del form-->
        <script src="../javascript/registrazione_utente.js"></script>
        <!--per inserire un'icona (logo) del sito web utilizzo il tag link-->
        <link rel="stylesheet" href="../CSS/progetto.css">
        <link rel="icon" type="image/png" href="../Immagini/logo.png">
    </head>
    <body>
        <div class="messaggio_no_stampa">
            <div>
                La pagina che si vuole stampare non presenta sufficienti elementi per essere stampata in modo appropriato;
                provare con un altra pagina.
            </div>
            <!--aggiungo un messaggio di mancata stampa + diritti di copyright-->
            <div>&copy; 2024 Aimar Paolo. Tutti i diritti riservati.</div>
            <!--inserisco inoltre la url della pagina, in modo che la persona, nel caso in cui volesse, può ritornare a quella pagina seguendo il link-->
            <div>Pagina Corrente: <?php echo $_SERVER['PHP_SELF'];?></div>
        </div>
        <nav>
            <div class="navbar">
                <a href="home.php">Home</a>
                <a id="attiva" class="<?php include('../including/nomeClasse.php');?>" href="<?php include('../including/disabilitatoreRegistrazione.php');?>">Registra</a>
                <a class="<?php include('../including/nomeClasseLogout.php');?>" href="<?php include('../including/disabilitatoreScrivi.php');?>">Scrivi</a>
                <a class="<?php include('../including/nomeClasseLogout.php');?>" href="<?php include('../including/disabilitatoreBacheca.php');?>">Bacheca</a>
                <a class="<?php include('../including/nomeClasse.php');?>" href="<?php include('../including/disabilitatore.php');?>">Login</a>
                <a href="scopri.php">Scopri</a>
                <a class="<?php include('../including/nomeClasseLogout.php');?>" href="<?php include('../including/disabilitaLogout.php');?>">Logout</a>
            </div>
        </nav>
        <main>
            <!--utilizzo un contenitore per raggruppare tutti i campi del form dentro una box.-->
            <div class="content">
                <!--Nel caso in cui volessi aggiunger un ulteriore titolo dovrei utilizzare h2 oppure nuovamente h1 (non è possibile passare 
                da h1 ad h3 per cambiare la grandezza del font perchè sarebbe errato, è importante utilizzare il CSS per rimpicciolire il font)-->
                <h1>Pagina di registrazione a VortexNet</h1>
                <!--utilizzo il metodo post, in quanto non è molto sicuro utilizzare il metodo get quando vengono mandate delle informazioni
                private come in questo caso (è meglio non avere dei parametri che vengono passati nell'header, soprattutto se 
                si tratta di password o dati sensibili). utilizzo la variabile globale $_SERVER per prendere il valore del nome della pagina in cui sto scrivendo in questo 
                momento, è molto meglio utilizzare questo metodo piuttosto che scrivere il nome perchè, nel caso in cui venisse rinominata
                la pagina, questo contenuto cambia automaticamente-->
                <form id="registrazione" name="registrazione" action="<?php echo $_SERVER['PHP_SELF'];?>" method="POST" onsubmit="return validateForm('registrazione');">
                    <div class="campo">
                    <?php
                        if(isset($_SESSION["messaggio_di_errore"])){
                            //in questo caso utilizzo il comando echo perchè non avrebbe senso aprire e chiudere il codice PHP (creerebbe un codice più difficile da leggere)
                            echo "<output class=\"segnalaErrore\">";
                            $messaggio = $_SESSION["messaggio_di_errore"];
                            echo "$messaggio";
                            /*elimino il messaggio di errore per evitare che, tornando di nuovo sulla pagina, mi mostri l'errore precedente*/
                            unset($_SESSION["messaggio_di_errore"]);
                            echo "</output>";
                            }          
                    ?>
                        <label for="name">Nome: </label>
                        <!--In questo caso, utilizzando minlength e maxlenght e altri attributi, faccio un primo controllo riguardo ai dati che 
                        vengono inseriti in input, controllo che verrà ripetuto anche dopo aver premuto il tasto registrati attraverso la funzione
                        di javascript validateForm()-->
                        <input type="text" id="name" name="name" minlength="2" maxlength="12" placeholder="inserire il nome" required>
                        <!--inserisco solamente la linea guida riguardante la lettera maiuscola, in quanto può essere quella che crea più problemi-->
                        <span class="guida">*La prima lettera deve essere maiuscola</span>
                    </div>
                    <div class="campo">
                        <label for="surname">Cognome: </label>
                        <input type="text" id="surname" name="surname" minlength="2" maxlength="12" placeholder="inserire il cognome" required>
                        <span class="guida">*La prima lettera deve essere maiuscola</span>
                    </div>
                    <div class="campo">
                        <label for="birthdate">Data di nascita: </label>
                        <!--inserisco la data nel formato richiesto attraverso un calendario in quanto l'utente viene aiutato graficamente, rendendo
                        la fase di registrazione più intuitiva-->
                        <input type="date" id="birthdate" name="birthdate" required>
                        <span class="guida">*Selezionare la propria data di nascita, fare attenziona a non selezionarne una che non è ancora avvenuta</span>
                    </div>
                    <!--facendo provare la registrazione ai miei genitori ho notato che avevano difficoltà su questo punto, aggiungevano nell'indirizzo anche il nome della città.
                    Dato che nel database sono presenti solo certi campi, ho deciso di inserire questo form che non salva i dati, lascia solo inserire la città per rendere più
                    chiara la registrazione-->
                    <div class="campo">
                        <label for="adress">Città: </label>
                        <input type="text" name="city" id="city" placeholder="Inserire la città" required>
                        <span class="guida">*Inserire la città di residenza dell'utente</span>
                    </div>
                    <div class="campo">
                        <label for="adress">Indirizzo: </label>
                        <input type="text" name="adress" id="adress" placeholder="inserire l'indirizzo" required>
                        <span class="guida">*Inserire un indirizzo che sia nel formato "Via/Corso/Largo/Piazza/Vicolo" con l'aggiunta del nome e del numero civico (es. Via Saluzzo 11), separati dallo spazio. Fare attenzione ad inserire la prima lettera maiuscola</span>
                    </div>
                    <div class="campo">
                        <label for="nick">Username: </label>
                        <input type="text" id="nick" name="nick" minlength="4" maxlength="10" placeholder="inserire lo username" required>
                        <span class="guida">*Lo username può contenere lettere, numeri e '-' oppure '_', deve incominciare con un carattere alfabetico</span>
                    </div>
                    <div class="campo">
                        <label for="password">Password: </label>
                        <!--in questo caso si poteva anche utilizzare normalmente un input di type text in quanto anche il type password manda
                        i dati in chiaro. Va bene utilizzare il type password per far capire maggiormente all'utente che questa informazione 
                        deve essere riservata e rendere quindi più intuitiva la fase di registrazione-->
                        <input type="password" id="password" name="password" minlength="8" maxlength="16" placeholder="inserire la password" required>
                        <!--aggiungo un campo reinserire la password per esser sicuro che la password inserita dall'utente sia effettivamente quella
                        voluta, quando andrò a fare i controlli sull'inserimento della password utilizzerò le regexp solo sulla prima. Andando poi 
                        a confrontarle, se saranno uguali, vuol dire che anche la seconda rispetta i criteri richiesti-->
                        <span class="guida">*Inserire una password lunga almeno 8 caratteri e al massimo 16, che contenga almeno una lettera maiuscola, una lettera minuscola 2 numeri e 2 caratteri speciali [#!?@%^&*+=]</span>
                    </div> 
                    <div class="campo">
                        <label for="password_check">Ripeti la Password: </label>
                        <input type="password" id="password_check" name="password_check" minlength="8" maxlength="16" placeholder="inserire nuovamente la password" required>
                    </div>
                    <input class="bottoni" type="submit" id="registrati" value="Registrati">
                </form>
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