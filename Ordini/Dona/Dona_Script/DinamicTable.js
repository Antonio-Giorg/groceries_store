//GESTIONE INSERIMENTO PRODOTTO (Al click di "inserimento"):
$(value).click(function () { 
    var nome = $("#nomeP").val();
    const regex = new RegExp('^[a-zA-Z\s]');
    if (!(regex.test(nome)) || nome == "") {
        alert("Inserisci un nome nel giusto formato!");
        return;
    }
    else {
        var today = new Date();
        var date1 = new Date(($("#scadP").val()));

        if (($("#scadP").val() == "" || today >= date1) || $("#quantP").val() == "" || tipologia == undefined || tipologia == "") {
            alert("Inserisci correttamente tutti i dati!");
            if (today >= date1) {
                alert("In particolare non puoi mettermi un prodotto già scaduto!");
            }
            return;
        }
        //Se i dati sono stati inseriti tutti e nel giusto formato, me li salvo in variabili dai corrispettivi textbox...
        var nome = $("#nomeP").val();
        var scadenza = $("#scadP").val();
        var quantita = $("#quantP").val();

        //...e poi li svuoto.
        $("#nomeP").val("");
        $("#scadP").val("");
        $("#quantP").val("");
    }

    $("#placeholder").hide(); //L'immagine placeholder ora non serve più.

    if (flag == 0) {
        SettaTh(table);
        flag++;
    }
    //Generiamo il nostro carrello con i prodotti che l'utente di volta in volta inserisce:
    var tr = document.createElement('tr');
    var td1 = document.createElement('td');
    var td2 = document.createElement('td');
    var td3 = document.createElement('td');
    var td4 = document.createElement('td');

    var text1 = document.createTextNode(nome);
    var text2 = document.createTextNode(scadenza);
    var text3 = document.createTextNode(quantita);
    var text4 = document.createTextNode(tipologia);

    td1.appendChild(text1);
    td2.appendChild(text2);
    td3.appendChild(text3);
    td4.appendChild(text4);

    tr.appendChild(td1);
    tr.appendChild(td2);
    tr.appendChild(td3);
    tr.appendChild(td4);

    table.appendChild(tr);

    var tagList = "";
    //Converto i miei tag (eventualmente inseriti), in una stringa di elementi separati da virgole.
    tags.forEach(element => {
        tagList = tagList.concat("-").concat(element);
    });

    tagList = tagList.replace("-", ""); //Leva la prima virgola di troppo

    Arr[i] = [nome, scadenza, quantita, tipologia]; //L'array che tiene conto del contenuto alla riga "i" della table.
    invio[i] = nome + '|' + tipologia + '|' + scadenza + '|' + quantita + '|' + tagList; //Salvo i dati da inviare ad Elaborazione.PHP per l'inserimento e la gestione nel DB con il formato scritto.
    i = i + 1;
    $("#destra").html(table); //Rendiamo visibile la table di riepilogo.

    $("#DatiSpedizione").css("background-color", "rgb(153, 255, 51)");

    $("#Delete").show(); //Ora che è presente ALMENO un prodotto potenzialmente cancellabile rendiamo questo bottone (in una div) visibile.

    $("#carta").hide();

    $("#bottoni2").hide();
    $("#Tag").hide();

    flagTag = 0; //Ora che il prodotto è inserito...risblocco il flag per i prossimi Tag.

    tags = []; //E riazzero il suo Array per il prossimo prodotto.

    renderTags(); //Renderizzo di nuovo il TagArea con i Tags presenti nell'array (ovvero nessuno, quindi l'area viene ripulita)
});


//Eliminazione Ultima entry della table:
$("#Delete").click(function () {
    var tab = document.createElement('table');
    i = i - 1;
    Arr.splice(-1);
    invio.splice(-1);
    if (i == 0) { //Se sto eliminando l'ultima entry della table faccio ritornare il placeholder e gestisco componenti che ora non hanno senso di essere visibili.
        $("#placeholder").show();
        $("#SendC").hide();
        $("#SendL").hide();
        $("#Delete").hide();
        flag = 0;
        $("#DatiSpedizione").css("background-color", "rgb(194, 194, 214)");
    }
    else {
        SettaTh(tab);

        for (let x = 0; x < Arr.length; x++) {
            var tr = document.createElement('tr');
            var app = Arr[x];
            for (let y = 0; y < app.length; y++) {
                var td = document.createElement('td');
                var text = document.createTextNode(app[y]);
                td.appendChild(text);
                tr.appendChild(td);
            }
            tab.appendChild(tr);
        }
    }

    $("#destra").html(tab);
    table = tab;
    //Sostanzialmente rigeneriamo la stessa table di prima e la carichiamo nella sua div, meno l'ultima entry (e aggiorno table con la tab creata)...i TH devono essere però risettati.
});


//Funzione di generazione di Th per la nostra Table di riepilogo:
function SettaTh(tabella) {
    var th1 = document.createElement('th');
    var th2 = document.createElement('th');
    var th3 = document.createElement('th');
    var th4 = document.createElement('th');

    var text1 = document.createTextNode("Nome prodotto");
    var text2 = document.createTextNode("Scadenza");
    var text3 = document.createTextNode("Quantita");
    var text4 = document.createTextNode("Tipologia");

    th1.appendChild(text1);
    th2.appendChild(text2);
    th3.appendChild(text3);
    th4.appendChild(text4);

    tabella.appendChild(th1);
    tabella.appendChild(th2);
    tabella.appendChild(th3);
    tabella.appendChild(th4);
}