<?php
    /*Ho utilizzato un include in quanto le sessioni bisogna aprirle in ogni pagina per farle funzionare (sempre allo stesso modo)*/
    if( session_status() === PHP_SESSION_DISABLED){
        echo "<p>ERRORE SESSIONI DISABILITATE</p>";
        return;
    }
    elseif( session_status() !== PHP_SESSION_ACTIVE )
    {
        session_start();
    }
?>