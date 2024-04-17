<?php 
// Percorso al file di configurazione
$configFilePath = '../dir_queries/queries.ini';

// Caricamento delle configurazioni
$queryConfig = parse_ini_file($configFilePath, true);
session_start(); ?>
<!DOCTYPE html>
<html lang="it">

<head>
    <title>Modifica</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device.width,initial-scale=1">
    <link rel="stylesheet" href="../../bootstrap/css/bootstrap.css" />
    <link rel="stylesheet" href="modifica.css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css" />
    <link rel="icon" href="../../Home_Section\media\immagini\icon.png">

</head>

<body class="text-center" background="../media/sfondo.webp">
    <?php
    /*Se si entra in questa pagina senza passare dal LOGIN (quindi se il $_SESSION su loggatto non è settato), si viene ributtati sulla Home Page.
        -->La quale a sua volta gestirà gli utenti loggati e non (che vedranno in alto a destra il bottone d'accesso).*/
                   
        $a=$_COOKIE['PHPSESSID'];
               
        $db = getenv('PG_DATABASE');
$dbconn = pg_connect($db);
        $queryRemember = 'SELECT *
        from utente inner join identificativo on utente.codice = identificativo.codcliente
        where identificativo.codice = $1';
        $resultRemember = pg_query_params($dbconn, $queryRemember, array($a));
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
        $_SESSION['codice'] = $tuple["codice"];

        $_SESSION['loggato'] = 1;
        

/*
        $password = 'password';
        $metodo = 'aes';
        $formato = 'SQL_ASCII';
        


        $queryRemember = 'SELECT convert_from(decrypt($1,$2,$3),$4)';
        $resultRemember = pg_query_params($dbconn, $queryRemember, array($tuple["nome"],$password,$metodo,$formato));
        $tuples = pg_fetch_array($resultRemember, null, PGSQL_ASSOC);
        
        $_SESSION["nome"]=$tuples["convert_from"];
*/

   

        }    
    if (!isset($_SESSION["loggato"])  && !isset($_COOKIE["nome"]) ) {
        header("location: ../../Home_Section/index.php");
        return;
    }
    
    if (isset($_SESSION["nome"])){
        $nome=$_SESSION["nome"];

        $cognome=$_SESSION['cognome'];
        $email=$_SESSION['email'];
        $password=$_SESSION['password'];
        $cap=$_SESSION['cap'];
        $cellulare=$_SESSION['cellulare'];
        $cf=$_SESSION['cf'];
        $città=$_SESSION['città'];
        $via=$_SESSION['via'] ;
        $regione=$_SESSION['regione'];
        $codice=$_SESSION['codice'];

        
     
    }
    if (isset($_COOKIE["nome"])){

        $nome=$_COOKIE["nome"];
        $cognome=$_COOKIE['cognome'];
        $email=$_COOKIE['email'];
        $password=$_COOKIE['password'];
        $cap=$_COOKIE['cap'];
        $cellulare=$_COOKIE['cellulare'];
        $cf=$_COOKIE['cf'];
        $città=$_COOKIE['città'];
        $via=$_COOKIE['via'] ;
        $regione=$_COOKIE['regione'];
        $codice=$_COOKIE['codice'];

        
     
    }

    ?>
    <form action="modifica.php" method="POST" class="form-update" name="myForm">
        <img src="../media/finito.jpg" width="190px" />
        <h1 id="modifica" class="h1 mb-3 mt-5">Modifica</h1>

        <p class="Explain">Nome e Cognome:</p>
        <input type="text" name="nome" class="form-control" value="<?php 
// Percorso al file di configurazione
$configFilePath = '../dir_queries/queries.ini';

// Caricamento delle configurazioni
$queryConfig = parse_ini_file($configFilePath, true);
echo $nome; ?>" pattern="^[a-zA-Z]+$" required />
        <input type="text" name="cognome" class="form-control margine" value="<?php 
// Percorso al file di configurazione
$configFilePath = '../dir_queries/queries.ini';

// Caricamento delle configurazioni
$queryConfig = parse_ini_file($configFilePath, true);
echo $cognome; ?>" pattern="^[a-zA-Z]+$" required />

        <p class="Explain">Cellulare:</p>
        <input type="text" name="cell" class="form-control margine" value="<?php 
// Percorso al file di configurazione
$configFilePath = '../dir_queries/queries.ini';

// Caricamento delle configurazioni
$queryConfig = parse_ini_file($configFilePath, true);
echo $cellulare;  ?>" maxlength="10" pattern="[0-9]{10}$" required />
        
        <p class="Explain">Codice Fiscale:</p>
        <input type="text" name="cf" class="form-control margine" value="<?php 
// Percorso al file di configurazione
$configFilePath = '../dir_queries/queries.ini';

// Caricamento delle configurazioni
$queryConfig = parse_ini_file($configFilePath, true);
echo $cf;  ?>" pattern="^[a-zA-Z]{6}[0-9]{2}[a-zA-Z][0-9]{2}[a-zA-Z][0-9]{3}[a-zA-Z]$" required />

        <p class="Explain">Email e Password:</p>
        <input type="email" name="email" class="form-control margine" value="<?php 
// Percorso al file di configurazione
$configFilePath = '../dir_queries/queries.ini';

// Caricamento delle configurazioni
$queryConfig = parse_ini_file($configFilePath, true);
echo $email;  ?>" required />
        <div>
            <input type="password" class="form-control margine" name="pswd" id="pass" value="<?php 
// Percorso al file di configurazione
$configFilePath = '../dir_queries/queries.ini';

// Caricamento delle configurazioni
$queryConfig = parse_ini_file($configFilePath, true);
echo $password  ?>" pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#$%^&*_=+-.]).{8,16}$" required />
            <i class="bi bi-eye-slash" id="togglePassword"></i>
        </div>

        <p class="Explain">Regione:</p>
        <input class="box margine" id="boxRegione" list="Regione" name="regione" value="<?php 
// Percorso al file di configurazione
$configFilePath = '../dir_queries/queries.ini';

// Caricamento delle configurazioni
$queryConfig = parse_ini_file($configFilePath, true);
echo $regione; ?>">
        <datalist id="Regione">
            <option value="Abruzzo">
            <option value="Basilicata">
            <option value="Calabria">
            <option value="Emilia-Romagna">
            <option value="Friuli Venezia Giulia">
            <option value="Lazio">
            <option value="Liguria">
            <option value="Lombardia">
            <option value="Marche">
            <option value="Molise">
            <option value="Piemonte">
            <option value="Puglia">
            <option value="Sardegna">
            <option value="Sicilia">
            <option value="Toscana">
            <option value="Trentino-Alto Adige">
            <option value="Umbria">
            <option value="Valle d'Aosta">
            <option value="Veneto">
        </datalist>

        <script src="./index.js"></script>

        <p class="Explain">Indirizzo Domicilio:</p>
        <input type="text" class="form-control" name="città" value="<?php 
// Percorso al file di configurazione
$configFilePath = '../dir_queries/queries.ini';

// Caricamento delle configurazioni
$queryConfig = parse_ini_file($configFilePath, true);
echo $città;  ?>" pattern="^[a-zA-Z]+$" required>
        <input type="text" class="form-control margine" name="via" value="<?php 
// Percorso al file di configurazione
$configFilePath = '../dir_queries/queries.ini';

// Caricamento delle configurazioni
$queryConfig = parse_ini_file($configFilePath, true);
echo $via;  ?>" pattern="^[a-zA-Z\s]+[0-9]*" required>



        <div id="divCap" class="mb-3">
            <label for="cap" class="Explain">CAP (5 cifre):</label>
            <input type="text" name="cap" maxlength=5 size=5 value="<?php 
// Percorso al file di configurazione
$configFilePath = '../dir_queries/queries.ini';

// Caricamento delle configurazioni
$queryConfig = parse_ini_file($configFilePath, true);
echo $cap;  ?>" pattern="^[0-9]{5}" required />
        </div>


        <button type="submit" id="modify" name="registrationButton">Modifica</button>

    </form>

</body>

</html>