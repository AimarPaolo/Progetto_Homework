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
                <form id="registrazione" action="<?php echo $_SERVER['PHP_SELF'];?>" method="POST" onsubmit="return validateForm('registrazione');">
                    <div class="campo">
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
                    <div class="campo">
                        <label for="adress">Indirizzo: </label>
                        <input type="text" name="adress" id="adress" placeholder="inserire l'indirizzo" required>
                        <span class="guida">*Inserire un indirizzo che sia nel formato "Via/Corso/Largo/Piazza/Vicolo" con l'aggiunta del nome e del numero civico, separati dallo spazio. Fare attenzione ad inserire la prima lettera maiuscola</span>
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