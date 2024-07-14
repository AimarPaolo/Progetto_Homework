<!DOCTYPE html>
<html lang="it">
    <head>
        <meta charset="UTF-8">
        <title>Logout VortexNet</title>
        <meta name="author" content="Paolo Aimar">
        <meta name="keywords" lang="it" content="html">
        <meta name="description" content="pagina per uscire dal sito">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../CSS/progetto.css">
        <link rel="icon" type="image/png" href="../Immagini/logo.png">
    </head>
    <body>
        <div id="pagina_logout">
            <div id="richiesta">Sei sicuro di voler effettuare il logout?</div>
            <form id="form" name="form" action="logoutDefinitivo.php" method="POST">
                <input class="bottoni" id="si" name="si" type="submit" value="SI">
                <input class="bottoni" id="no" name="no" type="submit" value="NO">
            </form> 
        </div>
    </body>
</html>