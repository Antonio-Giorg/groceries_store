$(document).ready(function () {
    //Nascondiamo le div che contengono le carte in Bootstrap per il momento.
    $("#success").hide();
    $("#Programma").hide();
    $("#News").hide();
    $("#Contattaci").hide();
    document.getElementById("Numero").innerHTML = Math.floor(Math.random() * 10000) + 1;

    //Funzione richiamata per settare ogni 4 sec. (4000/1000=4 sec.) un random per il numero di utenti.
    setInterval(function () {
        var el = document.getElementById('Numero');
        incount = Math.floor(Math.random() * 10000) + 1;;
        el.innerText = incount;
    }, 4000);

    //Carichiamo le Descrizioni del nostro sito negli appositi Container...
    $("#ProgNor").load("./descrizioni_card/programma.txt");
    $("#colNor").load("./descrizioni_card/collaborazioni.txt");
    $("#NewsNor").load("./descrizioni_card/news.txt");

    //...e nelle carte che compariranno quando il viewport verrà ridotto.
    $("#prog").load("./descrizioni_card/programma.txt");
    $("#col").load("./descrizioni_card/collaborazioni.txt");
    $("#news").load("./descrizioni_card/news.txt");

    //Le div contenenti le percentuali dei grafici a semianello.
    $("#paste").hide();
    $("#fruit").hide();
    $("#vegetable").hide();

    //Facciamo un Check del viewport e riadattiamo le componentistiche della Home a seconda della dimensione della finestra.
    checkSize();
    
    //Funzione che aziona un evento sulla Home per segnalare la transazione avvenuta con successo.
    if (($("#success").val()) == 1) {
        $("#TestoSlogan").text('Your donation made a difference');
        $("#TestoSlogan").css('color', 'rgb(153, 255, 102)');
        setTimeout(function () {
            $("#TestoSlogan").fadeOut();
        }, 3000);

        setTimeout(function () {
            $("#TestoSlogan").text('Thanks a lot for your support!');
            $("#TestoSlogan").fadeIn();
        }, 4000);

        setTimeout(function () {
            $("#TestoSlogan").fadeOut();
        }, 6000);

        setTimeout(function () {
            $("#TestoSlogan").css('color', 'rgba(255, 255, 255, 0.822)');
            $("#TestoSlogan").text('"Your donation is all They Need"');
            $("#TestoSlogan").fadeIn();
        }, 8000);
    }
});


$(window).resize(function () {
    //Facciamo un Check del viewport e riadattiamo le componentistiche della Home a seconda della dimensione della finestra.
    checkSize();
});

//Funzione per gestire l'effetto di transazione sulle voci dell'Header (di Default solo la voce Home è inizialmente active).
$(".page-scroll").click(function () {
    $('#navbarSupportedContent').find('.active').removeClass("active");
    $(this).addClass("active");
});

function checkSize() {
    if ($(this).width() < 1700) {
        //Facciamo comparire le carte in Bootstrap nella sezione centrale del sito...
        $("#Programma").show();
        $("#News").show();
        $("#Contattaci").show();
        //nascondendo i container classici di default (con solo immagine e a destra una descrizione).
        $("#normaleP").hide();
        $("#normaleC").hide();
        $("#normaleN").hide();
        //Cambiamo gli HREF delle voci dell'header che ora punteranno alle carte.
        document.getElementById("bottoneP").href = "#Programma";
        document.getElementById("bottoneC").href = "#Contattaci";
        document.getElementById("bottoneN").href = "#News";

    } else {
        //In caso contrario...si fa il viceversa di quanto descritto nell'IF.
        $("#Programma").hide();
        $("#News").hide();
        $("#Contattaci").hide();
        $("#normaleP").show();
        $("#normaleC").show();
        $("#normaleN").show();
        document.getElementById("bottoneP").href = "#normaleP";
        document.getElementById("bottoneC").href = "#normaleC";
        document.getElementById("bottoneN").href = "#normaleN";
    }
    if ($(this).width() < 1110) {
        //Facciamo sparire i semi-anelli di statistiche...
        $("#anelloP").hide();
        $("#anelloF").hide();
        $("#anelloV").hide();

        //...e facciamo comparire delle div contenenti delle percentuali più visibili di ogni tipologia di prodotto.
        $("#paste").show();
        $("#fruit").show();
        $("#vegetable").show();
    } else {
        //In caso contrario...si fa il viceversa di quanto descritto nell'IF.
        $("#paste").hide();
        $("#fruit").hide();
        $("#vegetable").hide();

        $("#anelloP").show();
        $("#anelloF").show();
        $("#anelloV").show();
    }
    if ($(this).width() <= 767) {
        //Facciamo comparire dei "titoletti" su ogni page del Carosello dato che le descrizioni non sono più visibili dopo i 767px.
        $(".Titolo_Carousel").show();

    } else {
        //In caso contrario...si fa il viceversa di quanto descritto nell'IF.
        $(".Titolo_Carousel").hide();
    }
}