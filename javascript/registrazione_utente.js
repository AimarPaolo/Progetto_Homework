/*utilizzo use strict per rendere più strutturato il linguaggio js, utilizzando questa funzione vengono segnalati degli errori 
che solitamente non verrebbero segnalati, come ad esempio problemi di segnalazione delle variabili (quando si utilizza let oppure 
var)*/
"use strict";
function validateForm(formId){
    /*come prima cosa mi prendo i valori dei form e controllo che questi valori siano corretti (a parte la password ripetuta 
    che utilizzerò solo per il controllo di ugualianza con l'altra password) */
    const form = document.getElementById(formId);
    console.log(form);
    let nome = form.name.value;
    let cognome = form.surname.value;
    console.log("il nome e il cognome inseriti sono: "+nome+" e "+cognome);
    /*controllando con il console log, quando un utente inserisce la data di nascita come dd/mm/yyyy viene restituito il valore
    yyyy/mm/dd, formato richiesto dalle specifiche, è quindi necessario controllare ancora che i dati siano inseriti 
    correttamente perchè potrebbero ancora esserci altri tipi di errori (es. data non inserita o inserita parzialmente) ma, una 
    parte dei controlli degli errori è già stata effettuata*/
    let data_nascita = form.birthdate.value;
    console.log("La data di nascita è: "+data_nascita);
    let indirizzo = form.adress.value;
    console.log("l'indirizzo inserito è: "+ indirizzo);
    let username = form.nick.value;
    console.log("l'username inserito è: "+username);
    let password = form.password.value;
    console.log("la password inserita è: "+password);
    let password_check = form.password_check.value; 
    console.log("la password per controllare che sia stata inserita correttamente è: "+password_check);
    /*utilizzando il console log controllo che tutti i dati inseriti siano nel formato voluto, in modo da trattare i valori in 
    maniera corretta*/
    /*controllo con le regexp i valori. Ad esempio nel primo caso controllo che il primo carattere sia maiuscolo con [A-Z] e 
    successivamente posso inserire tutti i valori che voglio sia maiuscoli che minuscoli che spazi*/
    let name_regexp= /^[A-Z][a-zA-Z ]{1,11}$/;
    let surname_regexp = /^[A-Z][a-zA-Z ]{1,15}$/;
    /*nel caso della data di nascita, con le regexp controllo solo il formato utilizzato, mentre sarà ancora necessario controllare
    che la data inserita non superi ad esempio la giornata odiera (se si volesse essere più precisi, che l'età dell'utente sia
    superiore a 12/13 anni circa)*/
    let birthdate_regexp = /^\d{4}-\d{1,2}-\d{1,2}$/;
    /*lo spazio può essere indicato sia con il carattere che con /s*/
    let indirizzo_regexp = /^(Via|Corso|Largo|Piazza|Vicolo) [a-zA-Zàèéìòù\s]+ \d{1,4}$/;
    let username_regexp = /^[a-zA-Z][a-zA-Z0-9_-]{3,9}$/;
    let password_regexp = /^(?=(.*[\d]){2})(?=.*[A-Z])(?=.*[a-z])(?=(.*[!?#@%^&*+=]){2})[A-Za-z\d!?#@%^&*+=]{8,16}$/;
    /*in questo sito utilizzo solo query che fanno riferimento alla tabella users per accedere alla parte privata, quindi per 
    evitare che un utente acceda o utilizzi l'account login posso aggiungere il controllo che non si registri con quel nome 
    (non essendo poi registrato non potrà di conseguenza accedere). */ 
    if(username == "admin"){
        window.alert("Non puoi utilizzare lo username admin per registrarti, selezionane un altro");
        return false;
    }
    /*in questo caso divido le condizioni perchè così si può segnalare in modo preciso l'errore commesso dall'utente
    e questo riesce a risolverlo più velocemente, senza dover provare a capire che cosa ha sbagliato facendo tentativi*/
    if(password != password_check){
        window.alert("Le due password inserite non corrispondono, controlla che siano uguali");
        return false;
    }
    if(!name_regexp.test(nome)){
        window.alert("Il nome inserito non rispetta le richieste");
        return false;
    }
    if(!surname_regexp.test(cognome)){
        window.alert("Il cognome inserito non rispetta le richieste");
        return false;
    }
    if(!indirizzo_regexp.test(indirizzo)){
        window.alert("L'indirizzo inserito non è corretto");
        return false;
    }
    if(!birthdate_regexp.test(data_nascita)){
        window.alert("La data di nascita inserita non corrisponde al formato corretto (aaaa-mm-gg)");
        return false;
    }
    if(!username_regexp.test(username)){
        window.alert("Lo username inserito non è corretto");
        return false;
    }
    console.log("la password inserita è"+password_regexp.test(password_check));
    if(!password_regexp.test(password_check)){
        window.alert("La password inserita non rispetta le condizioni");
        return false;
    }
    const data_odierna = new Date();
    console.log(data_odierna)
    let anno = data_odierna.getFullYear();
    /*mi creo un array che prende la stringa e la divide in anno, mese, giorno ---> 0, 1, 2 */
    let array = data_nascita.split("-")
    /*mi stampo un attimo il giorno per controllare che effettivamente i valori scelti siano quelli corretti */
    /*console.log(anno);
    console.log(giorno); 
    console.log(array[1]);*/
    /*Ora controllo che la data selezionata sia quella corretta e non sia già passata */
    console.log(array[0]);
    console.log(anno);
    if(parseInt(array[0]) >= parseInt(anno)-12){
        /*facendo questo controllo viene anche esclusa la possibilità che l'utente inserisca una data che è futura alla data odierna, non ho
        ritenuto necessario segnalare e distinguere queste due tipologie di errore, penso che sia sufficiente segnalare l'errore in questo
        modo*/
        /*inoltre ho deciso di non distinguere anche i mesi e i giorni, considero solamente l'anno generico*/
        window.alert("Hai meno di 12 anni, non è possibile iscriversi al sito");
        return false;
    }
    /*aggiungo anche un controllo che la persona inserisca un età sensata (ad esempio che non sia nata nel 1200)*/
    if(parseInt(array[0]) <= 1900){
        window.alert("La data inserita risulta troppo lontana dai giorni nostri.");
        return false;
    }
    /*Se tutti i controlli sono soddisfatti, allora posso convalidare il form e mandare i dati del form senza creare problemi
    (il controllo dovrà poi esser eseguito anche lato server con PHP in quando non si sa mai che pagina possa mandarci i dati)*/
    return true;
}