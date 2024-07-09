<!DOCTYPE html>
<html lang="it">
    <head>
        <meta charset="UTF-8">
        <title>Login</title>
        <meta name="author" content="Paolo Aimar">
        <meta name="keywords" lang="it" content="html">
        <meta name="description" content="pagina di accesso al sito web">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script src="javascript/login_utente.js"></script>
        <link rel="stylesheet" href="CSS/progetto.css">
        <!--icona presa dalla seguente -> https://icons8.it/icon/set/net/family-ios-->
        <link rel="icon" type="image/png" href="Immagini/logo.png">
    </head>
    <body>
        <nav>
            <div class="navbar">
                <a href="home.php">Home</a>
                <a href="registrazione.php">Registra</a>
                <a href="scrivi.php">Scrivi</a>
                <a href="bacheca.php">Bacheca</a>
                <a href="login.php">Login</a>
                <a href="scopri.php">Scopri</a>
            </div>
        </nav>
        <main>
            <div class="content">
                <!--anche in questo caso, come con la registrazione, utilizzo il metodo POST in quanto ci possono essere dati sensibili che 
                non dovrebbero essere visibili nell'URL (sempre precisando che questo non rende automaticamente sicuro il metodo Post, ma riesce
                a risolvere alcune problematiche del get relative alla privacy)-->
                <h1>Pagina di accesso al sito</h1>
                <form id="login" action="<?php echo $_SERVER['PHP_SELF'];?>" method="POST" onsubmit="return validateForm('login');">
                    <div class="campo">
                        <!--In questo caso ho scelto di utilizzare una segnalazione di errore inserendo il testo dentro dentro ad un output e colorandolo
                        di rosso per segnalare all'utente che il login non è andato a buon fine in quanto mi sembra migliore alla segnalazione
                        tramite alert che andrebbe a scomparire una volta premuto il pulsante. Volendo si può fare sfruttando in CSS lo stile
                        visibility, andando a cambiare il valore. In alternativa si può lasciare il campo output vuoto, inserendo successivamente
                        dentro al tag il testo che si vuole far comparire-->
                        <output id="segnalaErrore"></output>
                        <label for="nick">Username: </label>
                        <input type="text" id="nick" name="nick" minlength="4" maxlength="10" placeholder="inserire lo username" required>
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
    </body>
    <!--Inserisco all'interno del footer possibili contatti e informazioni utili all'utente, ad esempio l'autore, la sua mail
    e altre informazioni di questo genere (prendo anche spunto dai primi laboratori)-->
    <footer>
            <!--inserisco il simbolo di copyright utilizzando la dicitura &copy; oppure &#169 per evitare succeffici errori di 
            interpretazione del sito web-->
            <div>Sito web realizzato da Aimar Paolo. Anno 2024 | Copyright | Tutti i diritti riservati &copy;</div>
            <div><a href="mailto:s297424@studenti.polito.it">Email: s297424@studenti.polito.it</a></div>
            <!--Dato che una delle richieste del sito è quello di calcolarsi il più possibile le informazioni autonomamente, 
            posso calcolare direttamente il nome della pagina sfruttando la variabile globale $_SERVER (il problema è che mi dava
            tutto il percorso. Cercando su internet ho trovato il comando basename che ti restituisce solamente il valore a noi
            interessato)-->
            <div>Pagina: la pagina in cui si trova in questo momento &eacute; <?php echo basename($_SERVER['PHP_SELF']);?></div>
    </footer>
</html>