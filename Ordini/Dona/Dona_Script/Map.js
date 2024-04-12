//Gestione delle Mappe dei Locker:
function Setting(valore) {
    //In base al valore del menu a tendina cliccato:
    switch (valore) {
        case "":
            //Nascondiamo tutto
            $("#DivMap").hide();
            $("#SendL").hide();
            $("#DivScelteLocker").hide();
            $("#Orario").hide();
            $("#SendL").hide();
            break;
        case "roma":
            //Per far sì che generiamo solo PER LA PRIMA VOLTA gli orari di una città, e non ogni volta che riclicco sulla stessa.
            if (cr == 0) {
                cr = 1;
                Rom1 = generaOrario();
                Rom2 = generaOrario();
                Rom3 = generaOrario();
                //Setto alle corrispettive mappe l'orario di apertura generato in Rom1-2-3:
                $('#map1').attr('value', Rom1);
                $('#map2').attr('value', Rom2);
                $('#map3').attr('value', Rom3);
            }
            else {
                //Setto alle corrispettive mappe l'orario di apertura generato in Rom1-2-3:
                $('#map1').attr('value', Rom1);
                $('#map2').attr('value', Rom2);
                $('#map3').attr('value', Rom3);
            }
            //Genero 3 link SPECIFICI e statici scelti dall'admin (nel formato di Google) e l'associo alle mappe.
            link1 = ("https://maps.google.com/maps?q=").concat("CONAD,Piazza dei Redi Roma,15").concat("&t=&z=13&ie=UTF8&iwloc=&output=embed");
            link2 = ("https://maps.google.com/maps?q=").concat("Eurospin,Via Tiburtina,655").concat("&t=&z=13&ie=UTF8&iwloc=&output=embed");
            link3 = ("https://maps.google.com/maps?q=").concat("SPAZIO CONAD,Viale Giovanni Battista Valente, 190").concat("&t=&z=13&ie=UTF8&iwloc=&output=embed");
            $('#map1').attr('src', link1);
            $('#map2').attr('src', link2);
            $('#map3').attr('src', link3);
            $("#DivMap").hide();
            $("#Orario").hide();
            $("#recapLavora").hide();
            $("#DivScelteLocker").show();
            $("#SendL").hide();
            break;
        //Per le altre città vi è il medesimo ragionamento...
        case "milano":
            if (cm == 0) {
                cm = 1;
                Mil1 = generaOrario();
                Mil2 = generaOrario();
                Mil3 = generaOrario();
                $('#map1').attr('value', Mil1);
                $('#map2').attr('value', Mil2);
                $('#map3').attr('value', Mil3);
            }
            else {
                $('#map1').attr('value', Mil1);
                $('#map2').attr('value', Mil2);
                $('#map3').attr('value', Mil3);
            }
            link1 = ("https://maps.google.com/maps?q=").concat("CONAD, Via Bernardo Quaranta, 42").concat("&t=&z=13&ie=UTF8&iwloc=&output=embed");
            link2 = ("https://maps.google.com/maps?q=").concat("Eurospin, Via Maffeo Bagarotti, 5").concat("&t=&z=13&ie=UTF8&iwloc=&output=embed");
            link3 = ("https://maps.google.com/maps?q=").concat("CONAD, Via della Pecetta, 33").concat("&t=&z=13&ie=UTF8&iwloc=&output=embed");
            $('#map1').attr('src', link1);
            $('#map2').attr('src', link2);
            $('#map3').attr('src', link3);
            $("#DivMap").hide();
            $("#DivScelteLocker").show();
            $("#SendL").hide();
            $("#Orario").hide();
            break;
        case "bologna":
            if (ct == 0) {
                ct = 1;
                Bol1 = generaOrario();
                Bol2 = generaOrario();
                Bol3 = generaOrario();
                $('#map1').attr('value', Bol1);
                $('#map2').attr('value', Bol2);
                $('#map3').attr('value', Bol3);
            }
            else {
                $('#map1').attr('value', Bol1);
                $('#map2').attr('value', Bol2);
                $('#map3').attr('value', Bol3);
            }
            link1 = ("https://maps.google.com/maps?q=").concat("CONAD, Viale Antonio Silvani").concat("&t=&z=13&ie=UTF8&iwloc=&output=embed");
            link2 = ("https://maps.google.com/maps?q=").concat("CONAD SUPERSTORE, Via Emilia Levante, 6").concat("&t=&z=13&ie=UTF8&iwloc=&output=embed");
            link3 = ("https://maps.google.com/maps?q=").concat("Eurospin, Via Giovanni Segantini, 23").concat("&t=&z=13&ie=UTF8&iwloc=&output=embed");
            $('#map1').attr('src', link1);
            $('#map2').attr('src', link2);
            $('#map3').attr('src', link3);
            $("#DivMap").hide();
            $("#Orario").hide();
            $("#SendL").hide();
            $("#DivScelteLocker").show();
            break;
        case "napoli":
            if (cn == 0) {
                cn = 1;
                Nap1 = generaOrario();
                Nap2 = generaOrario();
                Nap3 = generaOrario();
                $('#map1').attr('value', Nap1);
                $('#map2').attr('value', Nap2);
                $('#map3').attr('value', Nap3);
            }
            else {
                $('#map1').attr('value', Nap1);
                $('#map2').attr('value', Nap2);
                $('#map3').attr('value', Nap3);
            }
            link1 = ("https://maps.google.com/maps?q=").concat("CONAD, Via Bruno Falcomata, 3").concat("&t=&z=13&ie=UTF8&iwloc=&output=embed");
            link2 = ("https://maps.google.com/maps?q=").concat("CONAD, Via Roberto Bracco, 4").concat("&t=&z=13&ie=UTF8&iwloc=&output=embed");
            link3 = ("https://maps.google.com/maps?q=").concat("Eurospin, Via Filippo Turati, 72").concat("&t=&z=13&ie=UTF8&iwloc=&output=embed");
            $('#map1').attr('src', link1);
            $('#map2').attr('src', link2);
            $('#map3').attr('src', link3);
            $("#DivMap").hide();
            $("#Orario").hide();
            $("#SendL").hide();
            $("#DivScelteLocker").show();
            break;
    }
}

//Funzione di generazione orari per le mappe:
function generaOrario() {
    return "Aperto tutti i giorni dalle ore: " + Math.floor(Math.random() * (11 - 8) + 8) + " alle ore: " + Math.floor(Math.random() * (21 - 19) + 19);
}


$(function () {
    $('.changesrc').click(function () { //Funzione richiamata al click su un bottone numerato dei locker
        $('.mapcontainer').hide();
        var number = $(this).attr('value'); //Mi prendo il numero della mappa al quale devo cambiare sorgente MAPS.
        $("#DivMap").show();
        $("#SendL").show();
        $('#Mappa' + number).show();
        indirizzo = (document.getElementById("map".concat(number)).src); //Mi prendo l'indirizzo della mappa settato come attribute "src". 
        indirizzo = indirizzo.replaceAll("%20", " ");
        indirizzo = indirizzo.replaceAll("https://maps.google.com/maps?q=", "");
        indirizzo = indirizzo.replaceAll("&t=&z=13&ie=UTF8&iwloc=&output=embed", "");
        indirizzo = indirizzo.replaceAll(",", " ");
        $("#Orario").html($('#map' + number).attr('value'));
        $("#Orario").show();
        $("#DataL").hide();
    });
});

var output = document.getElementById('output');


document.getElementById("output").innerHTML = tipologia;


//Gestione del Locker e dei suoi indirizzi:
$("#cercaL").click(function () {
    var contenuto = $("#cercaLocker").val();
    contenuto = contenuto.replaceAll(" ", "%20");
    var indirizzo = ("https://maps.google.com/maps?q=").concat(contenuto).concat("&t=&z=13&ie=UTF8&iwloc=&output=embed");
    $('#ifrm').attr('src', indirizzo);
    $("#DivL").hide();
    $("#DivMap").show();
    $("#SendL").show();
});

$("#cambiaL").click(function () {
    $("#DivL").show();
    $("#DivMap").hide();
});