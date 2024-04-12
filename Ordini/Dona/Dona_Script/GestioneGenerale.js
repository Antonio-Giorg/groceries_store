//Responsiveness dei bottoni della modalità di consegna:
$(document).ready(function () {
    checkSize();
});
$(window).resize(function () {
    checkSize();
});
function checkSize() {
    if ($(this).width() <= 500) {
        $("#bottoni_indirizzo").show();
        $("#scelta1").hide();
        $("#scelta2").hide();
    } else {
        $("#bottoni_indirizzo").hide();
        $("#scelta1").show();
        $("#scelta2").show();
    }
}

//Gestione della schermata del form con la scelta tra Indirizzo di recapito e Locker di Consegna:
function showConsegna() {
    if (i == 0) {
        alert("Inserisci un prodotto almeno prima di scegliere la consegna!");
    }
    else {
        $("#sceltaSpedizione").show();

        $("#privato").hide();

        $("#bottoniInserimento").hide();

        $("#locker").hide();
        $("#contenutoInserimento").hide();
    }
}


//Gestione della schermata del form con i campi d'inserimento dei prodotti:
function showInserimento() {
    $("#bottoniInserimento").show();
    $("#sceltaSpedizione").hide();
    $("#privato").hide();
    $("#locker").hide();
    $("#contenutoInserimento").show();
}

//Mostriamo le componenti inerenti all'indirizzo privato:
function showPrivato() {
    $('#privato').show();
    $("#SendC").show();
    $("#sceltaSpedizione").hide();
}

//Mostriamo le componenti inerenti al Locker:
function showLocker() {
    $('#locker').show();
    $("#sceltaSpedizione").hide();
}

//Invio dati con Locker:
$("#SendL").click(function () {
    var data = $("#dataL").val();
    if (data == "") {
        alert("Inserisci una data di consegna al Locker!");
    } else {
        var oggi = new Date();
        var dd = String(oggi.getDate()).padStart(2, '0');
        var mm = String(oggi.getMonth() + 1).padStart(2, '0');
        var yyyy = oggi.getFullYear();
        oggi = mm + '-' + dd + '-' + yyyy;
        const myArray = oggi.split("-");
        var stringaData = myArray[2] + "-" + myArray[0] + "-" + myArray[1];
        if ((checkDate(data)) && (data >= stringaData)) { //Se la data è nel giusto formato e la consegna NON è da IERI in poi ok...
            invio[i] = 'Consenga presso Locker: ' + indirizzo;
            invio[i + 1] = data;
            var src = "Elaborazione.php?dati=" + invio;
            window.location.href = src;
        } else { //...altrimento ti fermo.
            alert("ATTENZIONE: la data scelta per la consegna va in conflitto con la scadenza di uno dei prodotti inseriti per la transazione! Scegliere una data di ritiro più vicina, o rivedi i tuoi prodotti ed elimina eventualmente quello in scadenza!")
        }
    }
});


//Invio dati con Domicilio:
$("#SendC").click(function () {
    const regex = new RegExp('^[a-zA-Z\s]+[0-9]*');
    var nome = $("#indirizzo").val();
    if (!(regex.test(nome)) || nome == "") {
        alert("Inserisci un indirizzo valido!");
    } else {
        const regex1 = new RegExp('^[a-zA-Z\s]*$');
        const regex2 = new RegExp('^[0-9]{5}');
        var città = $("#città").val();
        var cap = $("#cap").val();
        var data = $("#dataC").val();
        if ((!(regex1.test(città)) || città == "") || (!(regex2.test(cap)) || cap == "" || data == "")) {
            alert("Inserisci correttamente tutti i dati!");
        } else {
            var oggi = new Date();
            var dd = String(oggi.getDate()).padStart(2, '0');
            var mm = String(oggi.getMonth() + 1).padStart(2, '0');
            var yyyy = oggi.getFullYear();
            oggi = mm + '-' + dd + '-' + yyyy;
            const myArray = oggi.split("-");
            var stringaData = myArray[2] + "-" + myArray[0] + "-" + myArray[1];
            if ((checkDate(data)) && (data >= stringaData)) { //Se la data è nel giusto formato e la consegna NON è da IERI in poi ok...
                invio[i] = 'Ritiro Presso Domicilio: ' + $("#indirizzo").val();
                invio[i + 1] = data;
                var src = "Elaborazione.php?dati=" + invio;
                window.location.href = src;
            } else { //...altrimento ti fermo.
                if (data < stringaData) {
                    alert("Non puoi scegliere una data minore della CurrentDate!");
                } else {
                    alert("ATTENZIONE: la data scelta per il ritiro va in conflitto con la scadenza di uno dei prodotti inseriti per la transazione! Scegliere una data di ritiro più vicina, o rivedi i tuoi prodotti ed elimina eventualmente quello in scadenza!");
                }
            }
        }
    }
});


//Funzione di controllo di formato nelle date:
function checkDate(data) {
    var controllo = data;
    for (let x = 0; x < Arr.length; x++) { //Scorriamo le colonne (rappresentate da array della forma "nome,scadenza,quantità") della tabella contenute dentro "invio"
        app = Arr[x];
        dataScadenza = app[1];
        if (controllo >= dataScadenza) {

            return false; //Se la data di consegna supera quella di scadenza devo segnalarlo.
        }
    }

    return true; //Se arrivo fino alla fine del For vuol dire che non ho mai avuto violazioni e quindi ritorno true.
}


$("#Back2").click(function () {
    $("#Delete").show();
    $("#sinistra").show();
    $("#destra").show();
    $("#consegna").hide();
    $("#SendC").hide();
    $("#Back2").hide();
});


//Bottone di Back alla Home:
$("#Back").click(function () {
    var src = "../../Home_Section/index.php";
    window.location.href = src;
});


//Settings della tipologia di prodotto scelto e generazione random di una curiosità in merito:
function SettaTipologia(dato) {
    tipologia = dato;
    document.getElementById("output").innerHTML = tipologia;
    switch (tipologia) {
        case 'pasta':
            $("#cartaImm").attr("src", "https://www.ristorazioneitalianamagazine.it/CMS/wp-content/uploads/2021/10/pasta-day-.jpg");
            var chosenNumber = Math.floor(Math.random() * (3 - 1) + 1);
            var file = ("./testi/pasta/").concat("p").concat(chosenNumber).concat(".txt");
            $("#cartaTesto").load(file);
            $("#carta").fadeOut();
            $("#carta").fadeIn();
            break;
        case 'frutta':
            $("#cartaImm").attr("src", "https://www.basko.it/p/wp-content/uploads/2019/03/La-Frutta-Di-Stagione-03.jpg");
            var chosenNumber = Math.floor(Math.random() * (3 - 1) + 1);
            var file = ("./testi/frutta/").concat("f").concat(chosenNumber).concat(".txt");
            $("#cartaTesto").load(file);
            $("#carta").fadeOut();
            $("#carta").fadeIn();
            break;
        case 'verdura':
            $("#cartaImm").attr("src", "https://static.sky.it/images/skytg24/it/lifestyle/approfondimenti/frutta-verdura-stagione-marzo/frutta-verdura_freepik.jpg");
            var chosenNumber = Math.floor(Math.random() * (3 - 1) + 1);
            var file = ("./testi/verdura/").concat("v").concat(chosenNumber).concat(".txt");
            $("#cartaTesto").load(file);
            $("#carta").fadeOut();
            $("#carta").fadeIn();
            break;
        case 'altro':
            $("#cartaImm").attr("src", "https://www.starbene.it/content/uploads/2016/09/1_abitudini_alimentari_sbagliate.jpg");
            var chosenNumber = Math.floor(Math.random() * (3 - 1) + 1);
            var file = ("./testi/altro/").concat("a").concat(chosenNumber).concat(".txt");
            $("#cartaTesto").load(file);
            $("#carta").fadeOut();
            $("#carta").fadeIn();
            break;
    }
}