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
        <title>Home VortexNet</title>
        <meta name="author" content="Paolo Aimar">
        <meta name="keywords" lang="it" content="html">
        <meta name="description" content="homepage del sito NetConnect">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../CSS/progetto.css">
        <!--icona presa dalla seguente -> https://icons8.it/icon/set/net/family-ios-->
        <link rel="icon" type="image/png" href="../Immagini/logo.png">
    </head>
    <body id="body_home">
        <nav>
            <div class="navbar">
                <a id="attiva" href="home.php">Home</a>
                <a class="<?php include('../including/nomeClasse.php');?>" href="<?php include('../including/disabilitatoreRegistrazione.php');?>">Registra</a>
                <a class="<?php include('../including/nomeClasseLogout.php');?>" href="<?php include('../including/disabilitatoreScrivi.php');?>">Scrivi</a>
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
            <div class="pagina">
                <h1>Benvenuti su VortexNet: Il Futuro della Comunicazione Sociale.</h1>
                <div class="descrizione">
                    Siamo entusiasti di presentarvi VortexNet, il nuovo social network rivoluzionario che cambierà il modo in cui
                    connettiamo e condividiamo idee con il mondo. Su VortexNet, potete creare e leggere tweet di persone da ogni
                    angolo del pianeta, scoprendo così una vasta gamma di pensieri, opinioni ed esperienze.
                </div>
                <div>
                    VortexNet non è solo un social network, è una comunità vibrante e diversificata
                    che valorizza la comunicazione aperta e l'interconnessione globale. Che tu voglia rimanere aggiornato sulle 
                    ultime tendenze, esprimere le tue opinioni o semplicemente scoprire nuovi punti di vista, VortexNet è il posto 
                    giusto per te. Non perdere l'opportunità di essere parte di qualcosa di grande. Iscriviti a VortexNet 
                    oggi stesso e inizia a esplorare un mondo di tweet senza confini!
                </div>
                <div class="informazioni">
                    Dopo esserti iscritto al sito è possibile guardare i tweet postati da tutti gli altri utenti e, nel caso in cui tu voglia,
                    puoi anche vedere i tuoi personali!. Se non volessi effettuare il login, c'è la possibilità di guardare 
                    i tweet degli altri utenti premendo sul pulsante <a id="link_stampa" href="scopri.php">Scopri</a> ma non sarà possibile scrivere un nuovo tweet.
                </div>
                <h1>Sei stufo delle menzogne presenti sugli altri social?</h1>
                <!--inserisco un video preso da youtube (presente nell'iframe) prendendo spunto dai valori presenti nelle slide 78/79
                del pacco 02_html_p2. Ho deciso di inserire un video dove non fosse necessario l'audio, in modo da non distogliere completamente
                l'attenzione dell'utente dagli altri dettagli presenti nella pagina. Permetto inoltre il fulllscreen per accedere 
                al video ingrandito. Lascio i controlli settati a 0 per evitare che l'utente riesca a rimettere l'audio o il fullscreen facilemente (può sempre farlo ma solo se
                è particolarmente interessato al video). Utilizzo rel=0 per evitare che, alla fine del video, ne vengano suggeriti altri.
                -->
                <div class="centra_iframe">
                    <iframe src="https://www.youtube.com/embed/0EFHbruKEmw?autoplay=1&loop=1&controls=0&mute=1&rel=0" allowfullscreen></iframe>
                </div>  
                <div>
                    Noi di VortexNet vogliamo esaltare la spontaneità delle persone. In un mondo dove tutto sembra pianificato e 
                    curato, VortexNet vuole essere diverso. Il nostro obiettivo è creare uno spazio genuino dove
                    l'autenticità delle persone possa brillare. Crediamo che i momenti migliori e più memorabili nascano dalla 
                    spontaneità, e vogliamo che ogni nostro utente si senta libero di esprimersi in modo naturale e senza filtri. Inizia oggi
                    a scrivere tweet con tutti, iscrivendoti con pochi passaggi.
                </div>
                <h1>Perché unirti a noi?</h1>
                <ul>
                    <li>Connessioni Autentiche: Stringi legami sinceri con persone che condividono i tuoi interessi e le tue esperienze di vita.</li>
                    <li>Esplora e Ispira: Scopri contenuti unici e stimolanti ogni giorno. Dal lifestyle alla tecnologia, dalla cucina alla fotografia, troverai sempre qualcosa che ti affascina.</li>
                    <li>Condividi il Tuo Mondo: Mostra al mondo chi sei veramente. Pubblica foto, video e pensieri, e ricevi feedback immediati dalla nostra comunità positiva e coinvolgente.</li>
                    <li>Privacy e Sicurezza: La tua sicurezza è la nostra priorità. Le tue informazioni personali sono protette e il nostro team lavora costantemente per mantenere un ambiente sicuro e rispettoso.</li>
                </ul>
        <p>
            <span class="highlight">Non aspettare oltre!</span> Unisciti a noi oggi stesso e inizia a vivere un'esperienza di social networking come mai prima d'ora. Registrarsi è facile e veloce, e ti aprirà le porte a un mondo di possibilità senza limiti.
        </p>
            </div> 
        <div class="messaggio_no_stampa">
            <br>
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