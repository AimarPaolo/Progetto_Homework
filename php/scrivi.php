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
                <a href="registrazione.php">Registra</a>
                <a id="attiva" class="<?php include('../including/nomeClasseLogout.php');?>" href="<?php include('../including/disabilitatoreScrivi.php');?>">Scrivi</a>
                <a class="<?php include('../including/nomeClasseLogout.php');?>" href="<?php include('../including/disabilitatoreBacheca.php');?>">Bacheca</a>
                <a class="<?php include('../including/nomeClasse.php');?>" href="<?php include('../including/disabilitatore.php');?>">Login</a>
                <a href="scopri.php">Scopri</a>
                <a class="<?php include('../including/nomeClasseLogout.php');?>" href="<?php include('../including/disabilitaLogout.php');?>">Logout</a>
            </div>
        </nav>
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