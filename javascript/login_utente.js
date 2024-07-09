"use strict";

function rimandaAScopri(f1){
    window.location.href = 'scopri.php';
}

function errorAlert(fl){
    const formLog = document.getElementById(fl);
    let errore = "Errore in fase di Login, controllare che utente e password siano stati inseriti correttamente!";
    formLog.segnalaErrore.innerText = errore;
}