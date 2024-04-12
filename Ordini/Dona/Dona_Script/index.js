//SETTINGS INIZIALE:
var i = 0;
var Arr = [];
var orari = new Array();
var table = document.createElement('table');
var value = $("[name='premi']");
var invio = [];
var indirizzo;
var tipologia;
var flag = 0;
var flagTag = 0;
var tags = [];

//VARIABILI D'APPOGGIO PER GENERARE DEGLI ORARI PER LE MAPPE UNA SOLA VOLTA
var cr = 0;
var ct = 0;
var cm = 0;
var ct = 0;
var cn = 0;

//Nascondiamo Opportunatamente tutti gli elementi della pagina che ancora non dovranno essere visibili:
$("#SendC").hide();
$("#SendL").hide();
$("#Delete").hide();
$("#Back2").hide();
$("#DataL").hide();
$("#bottone").hide();
$("#consegna").hide();
$("#Orario").hide();
$("#DivMap").hide();
$("#DivScelteLocker").hide();
$("#output").hide();
$("#carta").hide();
$("#Tag").hide();
$("#bottoni2").hide();

//Richiamo gli altri Script:
$.post(
   './Dona_Script/LoaderScript/Loader.php', //Call AJAX al loader.
    function( data )
    {
        Dati_raccolti = JSON.parse(data); //Riconverto in Array la stringa passata in formato JSON.
        Dati_raccolti.forEach(element => {
            let result = element.includes(".js");
            if((result)&&(element!="index.js")){
                var path=("./Dona_Script/").concat(element);
                $.getScript(path, function(){});
            }  
        });  
});








