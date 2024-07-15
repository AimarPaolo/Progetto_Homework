"use strict";

function rimandaAScopri(f1){
    window.location.href = 'scopri.php';
}

function pulisciForm(f1){
    const form = document.getElementById(f1);
    //pulisco i campi
    form.nick.value = "";
    form.password.value = ""; 
}

function errorAlert(fl){
    //non utilizzato perchè diventava troppo complicato da gestire, vengono invece utilizzate  le variabili di sessione
    const formLog = document.getElementById(fl);
    let errore = "Errore in fase di Login, controllare che utente e password siano stati inseriti correttamente!";
    formLog.segnalaErrore.innerText = errore;
}
