<!-- carciamento dati per il riempimento dei grafici -->
<?php
   $dbconn = pg_connect("host=localhost dbname=ltw_db port=5432 user=postgres password=password");
   $query5 = 'select tipologia.categoria, sum(transazione.quantità)
    from ((
    transazione inner join prodotto on transazione.codprodotto=prodotto.codice
    ) inner join tipologia on prodotto.codtipologia = tipologia.categoria)
    group by tipologia.categoria';
    $array2 = array();
    $result1 = pg_query_params($db, $query5, array()); //Ci prendiamo la TABELLA risultante dalla query

    while ($tuple = pg_fetch_array($result1, null, PGSQL_ASSOC)) { //Scorriamo tutte le righe della tabella e le convertiamo in array singoli...

      $appoggio = array_values($tuple); //Mi prendo il valore della colonna "Email" e il suo corrispettivo counting...

      $nuovo = array($appoggio[0] => $appoggio[1]);
      $array2 = array_merge($array2, $nuovo); //Associo l'Email e il suo conteggio e la concateno all'array associativo "array2"
    }


    if (!isset($array2["pasta"])) {
      $array2["pasta"] = 0;
    }
    if (!isset($array2["frutta"])) {
      $array2["frutta"] = 0;
    }

    if (!isset($array2["verdura"])) {
      $array2["verdura"] = 0;
    }



    $pasta = $array2["pasta"];
    $obpasta = 45;

    $verdura = $array2["verdura"];
    $obverdura = 45;

    $frutta = $array2["frutta"];
    $obfrutta = 45;

    $percpasta = ($pasta * 100) / $obpasta;
    if ($percpasta > 100) {
      $percpasta = 100;
    }
    $percverdura = ($verdura * 100) / $obverdura;
    if ($percverdura > 100) {
      $percverdura = 100;
    }
    $percfrutta = ($frutta * 100) / $obfrutta;
    if ($percfrutta > 100) {
      $percfrutta = 100;
    }
?>


<!DOCTYPE html>
<html lang="it">

<head>

  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  
  <title>Ordina</title>


  <link rel="stylesheet" href="../../bootstrap/css/bootstrap.css">
  <link rel="stylesheet" href="style.css">
  <link rel="icon" href="..\..\Home_section\media\immagini\icon.png">

  <script src="//code.jquery.com/jquery-3.6.0.js"></script>

  <meta name="author" content="Alessio Civica">
  <meta name="keywords" content="Donazione, Alimenti, Cibo">
  <meta name="description" content="Sito per la donazione alimentare">
</head>



<body background="..\..\Registrazione_Modifica_Login\media\sfondo.webp">

  <?php
  session_start();
                 
  $a=$_COOKIE['PHPSESSID'];
               
  $dbconn = pg_connect("host=localhost dbname=ltw_db port=5432 user=postgres password=password");
 $queryRemember = 'SELECT *
  from utente inner join identificativo on utente.codice = identificativo.codcliente
  where identificativo.codice = $1';
  $resultRemember = pg_query_params($db, $queryRemember, array($a));
  $tuple = pg_fetch_array($resultRemember, null, PGSQL_ASSOC);
  
  if ($tuple) {
  
  
  $_SESSION['cognome'] = $tuple["cognome"];
  $_SESSION['email'] = $tuple["email"];
  $_SESSION['password'] = $tuple["pswd"];
  $_SESSION['cap'] = $tuple["cap"];
  $_SESSION['cellulare'] = $tuple["cellulare"];
  $_SESSION['cf'] = $tuple["cf"];
  $_SESSION['città'] = $tuple["città"];
  $_SESSION['via'] = $tuple["via"];
  $_SESSION['regione'] = $tuple["regione"];
  $_SESSION['codice'] = $tuple["codcliente"];

  $_SESSION['loggato'] = 1;
  $_SESSION['nome'] = $tuple["nome"];
  }
  if (!isset($_SESSION["loggato"]) && (!isset($_COOKIE["nome"]))) {
    header("location: ../../Home_Section/index.php");
  }
  if (isset($_SESSION["codice"])){
    $loggato = $_SESSION["codice"];
}

if (isset($_COOKIE["codice"])){
    $loggato = $_COOKIE["codice"];
}
  ?>
  <script src="//code.jquery.com/jquery-3.6.0.js"></script>


  <div id="titolo" class="spazio">Effettua una Donazione!</div>

  <div class="container ">
    <div class="row">

      <div class="col-sm  ">

        <div class="input-group-prepend">
          <button id="inserimentoProdotti" class="btn btn-outline-secondary" type="button" onclick="showInserimento()">1.Inserimento prodotti</button>
          <button id="DatiSpedizione" class="btn btn-outline-secondary" type="button" onclick="showConsegna()">2.Inserimento recapito</button>
        </div>
       
        <div id="form">
          
          <div id="contenutoInserimento" >


            <div id=ombra>
                <h1 id=testo>Inserisci il Prodotto:</h1>

                <div>
                <input type="text" placeholder="nome prodotto" id="nomeP" pattern="^[a-zA-Z\s]*$"></input>
                </div>

                <div>
                <input type="date" placeholder="scadenza del prodotto" id="scadP"  ></input>
                </div>
                <div>
                <input type="number" placeholder="quantità donata (Kg)" id="quantP" min="0.1"></input>
                </div>
           </div>


            <div id="bottoni">
              <button onclick="SettaTipologia('pasta')" class="raise" style=" --color: yellow;">Pasta</button>
              <button onclick="SettaTipologia('verdura')" class="raise" style=" --color: rgb(23, 196, 23);">Verdura</button>
              <button onclick="SettaTipologia('frutta')" class="raise" style="--color: rgb(255, 166, 0);">Frutta</button>
              <button onclick="SettaTipologia('altro')" class="raise" style=" --color: rgb(65, 156, 225);">Altro</button>
            </div>

            <div id="bottoni2">
              <p>Vuoi delle informazioni aggiuntive per il prodotto?</p>
              <button onclick="setTag(1)" class="raise" style=" --color: rgb(198, 255, 26)">✓</button>
              <button onclick="setTag(0)" class="raise" style=" --color: rgb(255, 204, 102);">✕</button>
            </div>

            <div id="Tag">
              <h4>Tag Prodotto:</h4>
                <div class="tag-area">
                    <ul>
                        <input type="text" class="tag-input" id="tag-input" />
                    </ul>
                </div>
            </div>

            <div id="spazio">
              <button id="premiP" name="premi" value="insP">inserisci</button>
            </div>

            <!--Container delle curiosità:-->
            <div class="grid-container">
              <div class="grid-item">
                <div id="output"></div>
                <div class="card" id="carta">
                  <img class="card-img-top" id="cartaImm">
                  <div class="card-body">
                    <h5 class="card-title">Lo sapevi che...</h5>
                    <p class="card-text" id="cartaTesto"></p>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div id="sceltaSpedizione">
            <div class="container" id="sceltaBottoni">
              <div class="row">
                <div id="testo">Scegli il tipo di consegna:</div>
              </div>

               <div class="priv" id="scelta1" type="button" onclick="showPrivato()"> Indirizzo privato</div>
               <div class="lock" id="scelta2" type="button" onclick="showLocker()">Locker</div>

              <div id="bottoni_indirizzo">
                <button id="ButtPrivato" onclick="showPrivato()" class="raise" style=" --color: rgb(255, 112, 77);">Ritiro presso Domicilio</button>
                <button id="ButtLocker" onclick="showLocker()" class="raise" style=" --color: rgb(102, 153, 255);">Consegna presso Locker</button>
              </div>

            </div>
          </div>
          <div id="privato">

            <div class="form">
              <div id="ombra">
                      <div id="testo">Inserire Indirizzo</div>

                      <div>
                      <input type="text" placeholder="Indirizzo" id="indirizzo" pattern="^[a-zA-Z\s]+[0-9]*"></input>
                      </div>

                      <div>
                      <input type="text" placeholder="Città" id="città" pattern="^[a-zA-Z\s]*$"></input>
                      </div>

                      <div>
                      <input type="text" placeholder="CAP" id="cap"></input>
                      </div>
                      
                      <div>
                      <input type="date" id="dataC" palceholder="Seleziona una data per il ritiro" name="Domicilio"> </input>
                      </div>
                    </div>
            </div>
            <button id="SendC" value="Ind" class="bottone1">CONFERMA LA DONAZIONE!</button>
          </div>

          <div id="locker">
            <div id="testo">Locker di Consegna:</div>
            <label for="scelta">Scegli la Città di Riferimento:</label>
            <select name="scelta" id="selectBox" onchange="Setting(value);">
              <option></option>
              <option value="roma">Roma</option>
              <option value="milano">Milano</option>
              <option value="bologna">Bologna</option>
              <option value="napoli">Napoli</option>
            </select>


             <!--Container delle mappe dei Locker:-->
            <div id="DivScelteLocker">
              <div id="Numeri">
                Scegli un Locker:
                <input type="submit" name="changesrc" class="changesrc" value="1" />
                <input type="submit" name="changesrc" class="changesrc" value="2" />
                <input type="submit" name="changesrc" class="changesrc" value="3" />
                <p id="Orario" style="margin: 0; padding: 0;"></button>
              </div>
                  <div>
                       Seleziona una data di consegna: <input type="date" id="dataL" name="Consegna"></input>
                  </div>
              <div id="DivMap">
                <div id=Mappa1 class="mapcontainer"><iframe id="map1" width="95%" height="500px" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="#" value="#"></iframe></div>
                <div id=Mappa2 class="mapcontainer"><iframe id="map2" width="95%" height="500px" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="#" value="#"></iframe></div>
                <div id=Mappa3 class="mapcontainer"><iframe id="map3" width="95%" height="500px" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="#" value="#"></iframe></div>
              </div>
              <!--La stessa struttura/DIV viene richiamata da ogni città, aggiornando opportunatamente i campi "src" e "value" a seconda della città scelta e al JS implementato-->
            </div>

            <button id="SendL" value="Dom" class="bottone1">CONFERMA LA DONAZIONE!</button>
          </div>

        </div>

      </div>

      <div class="col-sm ">

        <div id="testoCarrello">Carrello Prodotti:</div>

        <div id="placeholder">
          <img  id="imma" src="http://www.terafox.it/new/image/carrello-vuoto.png" >
        </div>
        <div id="destra"></div>
        <button id="Delete" class="bottone1">CANCELLA L'ULTIMO INSERIMENTO!</button>

        <button id="Back" class="bottone1">TORNA ALLA HOME!</button>
      </div>



    </div>
  </div>
  <script src="./Dona_Script/index.js"></script>
</body>

</html>