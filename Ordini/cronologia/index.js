var body = document.getElementsByTagName('body')[0];

//Costruzione dello scheletro della mia table dinamica.
var tbl = document.createElement('table');
tbl.style.width = '90%';

var tbdy = document.createElement('tbody');
var today = new Date();
var dd = String(today.getDate()).padStart(2, '0');
var mm = String(today.getMonth() + 1).padStart(2, '0');
var yyyy = today.getFullYear();

var tr = document.createElement('tr');
var th = document.createElement('th');
th.appendChild(document.createTextNode("Nome Prodotto:"));
tr.appendChild(th);

var th = document.createElement('th');
th.appendChild(document.createTextNode("Tipologia Prodotto:"));
tr.appendChild(th);

var th = document.createElement('th');
th.appendChild(document.createTextNode("Scadenza:"));
tr.appendChild(th);

var th = document.createElement('th');
th.appendChild(document.createTextNode("Quantità Donata:"));
tr.appendChild(th);

var th = document.createElement('th');
th.appendChild(document.createTextNode("Data Donazione:"));
tr.appendChild(th);

var th = document.createElement('th');
th.appendChild(document.createTextNode("Indirizzo Scelto:"));
tr.appendChild(th);

var th = document.createElement('th');
th.appendChild(document.createTextNode("Data Scelta:"));
tr.appendChild(th);

tbdy.appendChild(tr);
tbl.appendChild(tbdy);

today = mm + '-' + dd + '-' + yyyy;

array = JSON.parse(sessionStorage.getItem("jsArray"));  //Mi prendo i dati passati dal PHP, facendo un JSON.parse per riconvertirlo in un formato "scorribile".

var dati = [];
var conta = 0;
var appoggio = [];

for (let i = 0; i < array.length; i++) { /*Scorro gli elementi dell'array (ogni 7 elementi finisce una riga)-->i 7 elementi sono i valori selezionati nella query, che il JSON tuttavia
    durante la riconversione ha riunito in un unico array contiguo i dati presi dalla query del PHP.*/
    const element = array[i];
    appoggio.push(element); //Mi ricostruisco gli elementi di una riga, mettendomeli in un array d'appoggio.
    if (conta < 6) {
        conta = conta + 1;
    } else { 
        //Arrivato alla settima iterazione di "conta" (partendo da conta=0), mi costruisco una riga della tabella dinamica con i dati di "appoggio"
        var tr = document.createElement('tr');
        for (let index = 0; index < appoggio.length; index++) {
            const dato = appoggio[index];
            var td = document.createElement('td');
            td.appendChild(document.createTextNode(dato));
            if (index == (appoggio.length) - 1) {
                const myArray = today.split("-");
                var stringaData = myArray[2] + "-" + myArray[0] + "-" + myArray[1];
                if (dato > stringaData) {
                    td.setAttribute("style", "background-color: green; border-top: 1px solid;border-bottom: 1px solid; font-weight: bold;");
                }
                if (dato < stringaData) {
                    td.setAttribute("style", "background-color: rgb(177, 183, 180); border-top: 1px solid;border-bottom: 1px solid; font-weight: bold;");
                }
                if (dato == stringaData) {
                    td.setAttribute("style", "background-color: orange; border-top: 1px solid;border-bottom: 1px solid; font-weight: bold;");
                }
            }
            tr.appendChild(td);
        }
        tbdy.appendChild(tr);
        
        //Risvuoto appoggio e risetto a 0 il conta per la prossima riga da costruire fin tanto che non ci sono più dati da organizzare dentro "array":
        appoggio = [];
        conta = 0;
    }
}
tbl.appendChild(tbdy);

//Ci siamo presi l'oggetto body della pagina per appenderci la table appena costruita.
body.appendChild(tbl);
