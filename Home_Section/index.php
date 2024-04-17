


<?php 
  


        
#carichiamo nella session se id presente in identificativo 
        

session_start();
               
$a=$_COOKIE['PHPSESSID'];
               
$db = getenv('PG_DATABASE');

// Percorso al file di configurazione
$configFilePath = '../dir_queries\queries.ini';

// Caricamento delle configurazioni
$queryConfig = parse_ini_file($configFilePath, true);




$resultRemember = pg_query_params($dbconn, $queryConfig['database_queries']['fetch_user_data'], array($a));
$tuple = pg_fetch_array($resultRemember, null, PGSQL_ASSOC);




if ($tuple) {

  $_SESSION['nome'] = $tuple["nome"];
$_SESSION['cognome'] = $tuple["cognome"];
$_SESSION['email'] = $tuple["email"];
$_SESSION['password'] = $tuple["pswd"];
$_SESSION['cap'] = $tuple["cap"];
$_SESSION['cellulare'] = $tuple["cellulare"];
$_SESSION['cf'] = $tuple["cf"];
$_SESSION['città'] = $tuple["città"];
$_SESSION['via'] = $tuple["via"];
$_SESSION['regione'] = $tuple["regione"];
$_SESSION['codice'] = $tuple["codice"];

$_SESSION['loggato'] = 1;
/*
$password = 'password';
$metodo = 'aes';
$formato = 'SQL_ASCII';



$queryRemember = 'SELECT convert_from(decrypt($1,$2,$3),$4)';
$resultRemember = pg_query_params($dbconn, $queryRemember, array($tuple["nome"],$password,$metodo,$formato));
$tuple = pg_fetch_array($resultRemember, null, PGSQL_ASSOC);

$_SESSION["nome"]=$tuple["convert_from"];
*/
}
   


?>



<?php


//PHP relativo al caricamento dei dati dei Donat/Goal/Transazioni fatte ta tutti gli utenti.

if(isset($_COOKIE["nome"])){
  $nome=$_COOKIE["nome"];
}
if(isset($_SESSION["nome"])){
  $nome=$_SESSION["nome"];
}


$db = getenv('PG_DATABASE');
$result = pg_query_params($dbconn, $queryConfig['database_queries']['count_transactions'], array()); //Ci prendiamo la TABELLA risultante dalla query
$array2 = array();
while ($tuple = pg_fetch_array($result, null, PGSQL_ASSOC)) { //Scorriamo tutte le righe della tabella e le convertiamo in array singoli...
  $appoggio = array_values($tuple); //Mi prendo il valore della colonna "Email" e il suo corrispettivo counting...
  $array2 += array($appoggio[0] => $appoggio[1]); //Associo l'Email e il suo conteggio e la concateno all'array associativo "array2"
}
$dataPoints2 = array();
foreach ($array2 as $key => $value) {
  array_push($dataPoints2, array("label" => $key, "y" => $value)); //creo il mio dataPoints per il grafico il quale è un array indicizzato da sottoarray del tipo "label"->Email, y->Count"
}


?>




<!DOCTYPE html>
<html lang="it">

  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>


    <link rel="stylesheet" href="../bootstrap/css/bootstrap.css">
    <!-- link divisi per sezione-->
    <link rel="stylesheet" href="./css/header.css">
    <link rel="stylesheet" href="./css/style.css">
    <link rel="stylesheet" href="./css/footer.css">
    <!-- link alle icone dei social-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
    <!-- link icona della finestra-->
    <link rel="icon" href=".\media\immagini\icon.png">
    

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="../bootstrap/js/bootstrap.min.js"></script>



    
    <meta name="author" content="Alessio Civica">
    <meta name="keywords" content="Donazione, Alimenti, Cibo">
    <meta name="description" content="Sito per la donazione alimentare">


  </head> 

  <body>




  <header class="header">
    <div class="navbar-area">
      <div class="container">
        <div class="row align-items-center">
          <div class="col-lg-12">
            <nav class="navbar navbar-expand-lg">
              <a class="navbar-brand" href="#">
                <img src="./media/immagini/logo-home.png" alt="Logo" id="logo" />
              </a>
              <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
              <div class='main-btn'>Sezioni</div>
               </button>

              <div class="collapse navbar-collapse sub-menu-bar" id="navbarSupportedContent">
                <div class="ms-auto">
                  <ul id="nav" class="navbar-nav ms-auto">
                    <li class="nav-item">
                      <a class="page-scroll active" href="#" id="HomeButton">Home</a>
                    </li>
                    <li class="nav-item">
                      <a class="page-scroll" href="#normaleP" id="bottoneP">Programma</a>
                    </li>
                    <li class="nav-item">
                      <a class="page-scroll" href="#normaleN" id="bottoneN">News</a>
                    </li>
                    <li class="nav-item">
                      <a class="page-scroll" href="#normaleC" id="bottoneC">Collaborazioni</a>
                    </li>


                  </ul>
                </div>
              </div>

              <div id="utente">
                <?php
 

              
                if (!isset($_SESSION["loggato"]) && !isset($_COOKIE["email"])) {
               
                  
                  echo "<div class='header-btn'>
                <a href='..\Registrazione_Modifica_Login\login\index.php' class='main-btn btn-hover'>Accedi</a>
                </div>";
                } else {
                 
                  if (isset($_SESSION["loggato"]) || isset($_SESSION["nome"]) || isset($_COOKIE["nome"]) ) {
                   
                    echo "<div id='testo'>Ciao,";
                    print_r($nome);
                    echo "</div> ";
                    echo "<div id='Settings' class='nav-item dropdown'>
                      <a class='nav-link dropdown-toggle' data-bs-toggle='dropdown' href='#' role='a' aria-expanded='false'>Impostazioni</a>
                      <ul class='dropdown-menu'>
                      <li><a class='dropdown-item' href='../Ordini/cronologia/index.php'>Cronologia ordini</a></li>
                      <li><a class='dropdown-item' href='../Registrazione_Modifica_Login/modifica/index.php'>Modifica</a></li>
                      <li><hr class='dropdown-divider'></li>
                      <li><a id='esci' class='dropdown-item' href='../Registrazione_Modifica_Login/logout.php'>Disconnettiti</a></li>
                    </ul>
                  </div>";
                  }
                }

                ?>
              </div>
              <!-- navbar collapse -->
            </nav>
            <!-- navbar -->
          </div>
        </div>
        <!-- row -->
      </div>
      <!-- container -->
    </div>

    <!--navbar area -->
    

  </header>

  <div id="DiVideo">
    <video id="video" loop autoplay muted>
      <source src="./media/video/video.mp4" type="video/mp4" >
    </video>

    <div class="slogan">
      <p id="TestoSlogan">"Fare una cosa SEMPLICE, per un gesto SEMPLICE"</p>
      <input id="success" value="<?php   
        if (isset($_SESSION["success"])) {
          if ($_SESSION["success"] == 1) {
            echo 1; 
            $_SESSION["success"]=[];
          }
        }   ?>"
      />
    </div>

    <a href="../Ordini/Dona/index.php">
      <bottone type="button" onclick="/Ordini/Dona/index.php" class="dona"> DONA </bottone>
    </a>
  </div>

  <div class="citazione">"Quello che facciamo è soltanto una goccia nell'oceano. Ma se non ci fosse quella goccia all'oceano mancherebbe."</div>

  <div id="DivCarello">
    <!--DIV CARELLO -->
    <div class="container-lg">
      <div id="myCarousel" class="carousel slide" data-bs-ride="carousel">
        <!--INDICATORI ALLE SLIDE -->
        <ol class="carousel-indicators">
          <li data-bs-target="#myCarousel" data-bs-slide-to="0" class="active"></li>
          <li data-bs-target="#myCarousel" data-bs-slide-to="1"></li>
          <li data-bs-target="#myCarousel" data-bs-slide-to="2"></li>
        </ol>

        <!--ELEMENTI DELLA CAROUSEL-->
        <div class="carousel-inner">
          <div class="carousel-item active">
            <img src="./media/immagini/benvenuto.jpg" class="d-block w-100" alt="Slide 1">
            <div class="carousel-caption d-none d-md-block">
              <div class="mess" style="color:rgb(0, 255, 34);">Benvenuto!</div>
              <p name="testoCarousel">Questo è il nostro portale: "What they Need!"</p>
            </div>
            <div class="Titolo_Carousel" style="color:rgb(60, 179, 113)">Aiutaci anche tu!</div>
          </div>
          <div class="carousel-item">
            <img src="./media/immagini/chi_siamo.png" class="d-block w-100" alt="Slide 2">
            <div class="carousel-caption d-none d-md-block">
            <div class="mess" style="color:rgb(255, 0, 119);">Chi siamo?</div>
              <p name="testoCarousel">Siamo un'associazione dedita alla raccolta fondi per i più bisognosi, che specialmente durante i tempi odierni tra guerre e pandemie stanno patendo momenti duri e difficili!</p>
            </div>
            <div class="Titolo_Carousel" style="color:purple">Con un pasto...</div>
          </div>
          <div class="carousel-item">
            <img src="./media/immagini/donare.png" class="d-block w-100" alt="Slide 3">
            <div class="carousel-caption d-none d-md-block">
            <div class="mess" style="color: rgb(0, 238, 255);;">Come donare?</div>
              <p name="testoCarousel">E' molto facile!
                Ti basterà registrarti e scegliere la tipologia di prodotto da inserire e potrai successivamente scegliere se portare il tuo
                prodotto presso uno dei nostri Locker affilitati o se farti passare un corriere a casa per il ritiro che porterà a noi la tua donazione!
              </p>
            </div>
            <div class="Titolo_Carousel" style="color:blue">...fai la differenza!</div>
          </div>
        </div>

        <!--CONTROLLI-->
        <a class="carousel-control-prev" href="#myCarousel" data-bs-slide="prev">
          <span class="carousel-control-prev-icon"></span>
        </a>
        <a class="carousel-control-next" href="#myCarousel" data-bs-slide="next">
          <span class="carousel-control-next-icon"></span>
        </a>
      </div>
    </div>
  </div>



  



  <div id="stat">
    <div class="display-1 ">I nostri Donatori:</div>

    <div class="tabella">
      <div class="grid-container">

        <div class="grid-item">
          <p class="textStat">QUANTITA' DI DONAZIONI (Kg): </p>
          <p class="datoStat display-n">
            <?php 
            $db = getenv('PG_DATABASE');
            $result = pg_query_params($dbconn, $queryConfig['database_queries']['sum_quantities'], array()); //Ci prendiamo la TABELLA risultante dalla query
            while ($tuple = pg_fetch_array($result, null, PGSQL_ASSOC)) { //Scorriamo tutte le righe della tabella e le convertiamo in array singoli...
              print_r($tuple["sum"]);
            }
           
            ?>
          </p>

        </div>

        <div class="grid-item">
          <p class="textStat">NUMERO DI DONAZIONI EFFETTUATE: </p>
          <p class="datoStat display-n">
            <?php
            $db = getenv('PG_DATABASE');
            
            $result = pg_query_params($dbconn, $queryConfig['database_queries']['count_donations'], array()); //Ci prendiamo la TABELLA risultante dalla query
            while ($tuple = pg_fetch_array($result, null, PGSQL_ASSOC)) { //Scorriamo tutte le righe della tabella e le convertiamo in array singoli...
              print_r($tuple["count"]);
            }
            
            ?>
          </p>
        </div>
        <div class="grid-item">
          <p class="textStat">NUMERO DI UTENTI ATTIVI: </p>
          <div id='Numero' class="datoStat display-n"> </div>

        </div>

      </div>
    </div>
  </div>
  
  <!--Programma-News-Collaborazioni:-->
  <div id="carte">
    <!--Sezioni "disegnate su una griglia"-->
    <div class="Pparent">
      <div class="parent" id="normaleP">
        <div class="div1"> </div>
        <div class="div2"> <img src="./media/immagini/mensa-poveri.jpg" id="imgContorno"></div>
        <div class="div3"> </div>
        <div class="div4 tit" >IL NOSTRO PROGRAMMA:</div>
        <div class="div5">
          <p id="ProgNor" class="descrizione">
          </p>
        </div>
      </div>



      <div class="parent" id="normaleC">
        <div class="div1C"> </div>
        <div class="div2"> <img src="./media/immagini/partnership.png" id="imgContorno"></div>
        <div class="div3"> </div>
        <div class="div4 tit" >LE NOSTRE COLLABORAZIONI:</div>
        <div class="div5">
          <p id="colNor" class="descrizione">
          </p>
        </div>
      </div>


      <div class="parent" id="normaleN">
        <div class="div1N"> </div>
        <div class="div2"> <img src="https://www.pirazzi.it/wp-content/uploads/2020/05/news.jpg"  id="imgContorno"></div>
        <div class="div3"> </div>
        <div class="div4 tit" > NEWS:</div>
        <div class="div5" >
          <p id="NewsNor" class="descrizione">
          </p>
        </div>
      </div>
    </div>

    <!--Sezioni Carte di Bootstrap, "disegnate su una griglia"-->
    <div class="Pparent">
      <div class="Programma" id="Programma">
        <div class="div1P"> </div>
        <div class="div2P">
          <div class="card mb-3">
            <div class="row no-gutters">
              <div class="col-md-4">
                <img src="./media/immagini/mensa-poveri.jpg" class="card-img">
              </div>
              <div class="col-md-8">
                <div class="card-body">
                  <h5 class="card-title">IL NOSTRO PROGRAMMA</h5>
                  <p class="card-text" id="prog">
                  </p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="Contattaci" id="Contattaci">
        <div class="div1C"> </div>
        <div class="div2C">
          <div class="card mb-3">
            <div class="row no-gutters">
              <div class="col-md-4">
                <img src="./media/immagini/partnership.png" class="card-img">
              </div>
              <div class="col-md-8">
                <div class="card-body">
                  <h5 class="card-title">LE NOSTRE COLLABORAZIONI:</h5>
                  <p class="card-text" id="col">
                  </p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="News" id="News">
        <div class="div1N"> </div>
        <div class="div2N">
          <div class="card mb-3">
            <div class="row no-gutters">
              <div class="col-md-4">
                <img src="https://www.pirazzi.it/wp-content/uploads/2020/05/news.jpg" class="card-img">
              </div>
              <div class="col-md-8">
                <div class="card-body">
                  <h5 class="card-title">NEWS:</h5>
                  <p class="card-text" id="news">
                  </p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>



  <script src="./index.js"></script>
  <div style="position:relative" id="obbiettivi">
    <h1 class="display-1">I nostri obiettivi:</h1>

    <?php
  
    


  $db = getenv('PG_DATABASE');
   

    $result1 = pg_query_params($dbconn, $queryConfig['database_queries']['calculate_goals'], array()); //Ci prendiamo la TABELLA risultante dalla query

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



    <div id="seconda">
      <div class="grid-container">

        <div class="grid-item">
          <p class="textStat">PASTA:</p>
          <div id="anelloP" class="semi-donut margin" style="--percentage :<?php
            echo ($percpasta) ?>; --fill: #ebdc1c ;">
            <?php  echo (round($percpasta)) ?>%
          </div>
          <p id="paste" class="textStat" style="color: orange;"><?php  echo (round($percpasta)) ?>% </p>
          <p class="textStat">pasta donata: <?php  echo $pasta ?> su <?php echo $obpasta ?> kg</p>
        </div>
        <div class="grid-item">
          <p class="textStat">VERDURE:</p>
          <div id="anelloV" class="semi-donut margin" style="--percentage :<?php
            echo ($percverdura) ?>; --fill: #17dc49 ;">
            <?php  echo (round($percverdura)) ?>%
          </div>
          <p id="vegetable" class="textStat" style="color: green;"><?php  echo (round($percverdura)) ?>% </p>
          <p class="textStat">verdura donata: <?php echo $verdura ?> su <?php echo $obverdura ?> kg</p>
        </div>
        <div class="grid-item">
          <p class="textStat">FRUTTA:</p>
          <div id="anelloF" class="semi-donut margin" style="--percentage :<?php  echo ($percfrutta)  ?>; --fill: #fa0a07 ;">
            <?php  echo (round($percfrutta))  ?>%
          </div>
          <p id="fruit" class="textStat" style="color: red;"><?php echo (round($percfrutta)) ?>% </p>
          <p class="textStat">frutta donata: <?php  echo $frutta ?> su <?php echo $obfrutta ?> kg</p>
        </div>

      </div>


    </div>



    <div class="footer-basic">
        <footer>
            <div class="social">
              <a href="https://www.instagram.com/"><i class="icon ion-social-instagram"></i></a>
              <a href="https://accounts.snapchat.com/accounts/login?continue=%2Faccounts%2Fwelcome"><i class="icon ion-social-snapchat"></i></a>
              <a href="https://twitter.com/?lang=it"><i class="icon ion-social-twitter"></i></a>
              <a href="https://www.facebook.com/"><i class="icon ion-social-facebook"></i></a>
            </div>
            <ul class="list-inline">
                <li class="list-inline-item"><a href="#">Home</a></li>
                <li class="list-inline-item"><a href="#normaleP">Programma</a></li>
                <li class="list-inline-item"><a href="#normaleN">News</a></li>
                <li class="list-inline-item"><a href="#normaleC">Collaborazioni</a></li>
                <li class="list-inline-item"><a href="https://www.governo.it/it/privacy-policy">Privacy Policy</a></li>
            </ul>
            <p class="copyright">What They Need © 2022</p>
        </footer>
    </div>





  </body>

</html>