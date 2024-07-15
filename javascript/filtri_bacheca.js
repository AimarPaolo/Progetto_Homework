"use strict";
function validateForm(f1){
    const form = document.getElementById(f1);
    let data1 = form.filtro1.value;
    let data2 = form.filtro2.value;
    console.log("la data 1 è: "+data1);
    console.log("la data 2 è: "+data2);
    console.log("l'if inserito restituisce: "+(data1 > data2));
    if(data1=="" && data2==""){
        window.alert("inserire almeno uno dei due filtri per selezionare i tweet");
        return false;
    }
    if(data1 == "" || data2 == ""){
        //se una delle due date non è settata salto il filtro
        form.submit();
        return true;
    }
    if(data1 > data2){
        console.log("entrato");
        /*in questo caso vuol dire che non è stato inserito correttamente il filtro. Invio quindi un messaggio di errore sull'inserimento*/
        window.alert("Errore filtri settati in maniera non corretta, la data di inizio non può essere superiore a quella di fine");
        return false;
    }else{
        form.submit();
        return true;
    }
}

function submitCall(f1){
    const form = document.getElementById(f1);
    form.filtro1.value = null;
    form.filtro2.value = null;
    //annullo i valori delle date così che non ci siano filtri e poi mando al server
    form.submit()
}