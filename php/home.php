<?php
    include("../including/aperturaSessioni.php");
?>
<!DOCTYPE html>
<html lang="it">
    <head>
        <meta charset="UTF-8">
        <title>Home VortexNet</title>
        <meta name="author" content="Paolo Aimar">
        <meta name="keywords" lang="it" content="html">
        <meta name="description" content="homepage del sito NetConnect">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../CSS/progetto.css">
        <!--icona presa dalla seguente -> https://icons8.it/icon/set/net/family-ios-->
        <link rel="icon" type="image/png" href="../Immagini/logo.png">
    </head>
    <body>
        <nav>
            <div class="navbar">
                <a id="attiva" href="home.php">Home</a>
                <a href="registrazione.php">Registra</a>
                <a class="<?php include('../including/nomeClasseLogout.php');?>" href="<?php include('../including/disabilitatoreScrivi.php');?>">Scrivi</a>
                <a class="<?php include('../including/nomeClasseLogout.php');?>" href="<?php include('../including/disabilitatoreBacheca.php');?>">Bacheca</a>
                <a class="<?php include('../including/nomeClasse.php');?>" href="<?php include('../including/disabilitatore.php');?>">Login</a>
                <a href="scopri.php">Scopri</a>
                <a class="<?php include('../including/nomeClasseLogout.php');?>" href="<?php include('../including/disabilitaLogout.php');?>">Logout</a>
            </div>
        </nav>
        <main>
            <div class="pagina">
                <h1>Benvenuti su VortexNet: Il Futuro della Comunicazione Sociale.</h1>
                <div class="descrizione">
                    Siamo entusiasti di presentarvi VortexNet, il nuovo social network rivoluzionario che cambierà il modo in cui
                    connettiamo e condividiamo idee con il mondo. Su VortexNet, potete creare e leggere tweet di persone da ogni
                    angolo del pianeta, scoprendo così una vasta gamma di pensieri, opinioni ed esperienze.
                </div>
                <div class="informazioni">

                </div>
                <div>
                VortexNet non è solo un social network, è una comunità vibrante e diversificata
                che valorizza la comunicazione aperta e l'interconnessione globale. Che tu voglia rimanere aggiornato sulle 
                ultime tendenze, esprimere le tue opinioni o semplicemente scoprire nuovi punti di vista, VortexNet è il posto 
                giusto per te. Non perdere l'opportunità di essere parte di qualcosa di grande. <a href="registrazione.php">Iscriviti</a> a VortexNet 
                oggi stesso e inizia a esplorare un mondo di tweet senza confini!
                </div>
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