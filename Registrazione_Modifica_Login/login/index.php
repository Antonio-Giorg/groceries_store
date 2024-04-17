<?php
//page 1

// Percorso al file di configurazione
$configFilePath = '../../dir_queries/queries.ini';

// Caricamento delle configurazioni
$queryConfig = parse_ini_file($configFilePath, true);
session_start();

$tuple = "nulla";
$flag = "nulla";


$db = getenv('PG_DATABASE');
$dbconn = pg_connect($db);


if (isset($_POST["submit"]) || isset($_POST["email"])) {


    $email = $_POST["email"];
    $password = $_POST["pswd"];

    $query = 'SELECT * from public.utente where email=$1 AND pswd=$2';

    $result = pg_query_params($dbconn, $queryConfig['database_queries']['user_authentication'], array($email, hash('sha256', $password)));
    $tuple = "nulla";
    $flag = "nulla";
    $tuple = pg_fetch_array($result, null, PGSQL_ASSOC);



    if ($tuple != "nulla") { //se esiste un email e una pass

        $pass = $tuple["pswd"];

        if ($pass ==  hash('sha256', $password)) {

            $flag = "funziona";
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


            if (isset($_POST['rememberMe'])) {




                setcookie("nome",  $_SESSION['nome'], time() + 400, "/");
                setcookie("cognome",  $_SESSION['cognome'], time() + 400, "/");
                setcookie("email",  $_SESSION['email'], time() + 400, "/");
                setcookie("password",  $_SESSION['password'], time() + 400, "/");
                setcookie("cap",  $_SESSION['cap'], time() + 400, "/");
                setcookie("cellulare",  $_SESSION['cellulare'], time() + 400, "/");
                setcookie("cf",  $_SESSION['cf'], time() + 400, "/");
                setcookie("città",  $_SESSION['città'], time() + 400, "/");
                setcookie("via",  $_SESSION['via'], time() + 400, "/");
                setcookie("regione",  $_SESSION['regione'], time() + 400, "/");
                setcookie("codice",  $_SESSION['codice'], time() + 400, "/");


                $_SESSION['ricordami'] = 1;
            } else {
                $db = getenv('PG_DATABASE');
                $dbconn = pg_connect($db);

                $id = session_id();
                $codice = $_SESSION['codice'];







                $ris = pg_query_params($dbconn, $queryConfig['database_queries']['insert_identification'], array($id, $codice));






                if ($ris) {

                    #header("location: ../login/index.php");
                } else die("c'è stato un errore");
            }







            echo "<script>location='../../Home_Section/index.php'</script>";
        }
    }
}

$resultRemember = pg_query_params($dbconn, $queryConfig['database_queries']['retrieve_user_session'], array(session_id()));
$tupleRemember = pg_fetch_array($resultRemember, null, PGSQL_ASSOC);

if ($tupleRemember) {

    $_POST["email"] = $tupleRemember["email"];
    $_POST["pswd"] = $tupleRemember["pswd"];
}
pg_close($dbconn);
?>




<!DOCTYPE html>
<html lang="en">

<head>
    <title>Login</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device.width,initial-scale=1">
    <link rel="stylesheet" href="./style.css">
    <link rel="stylesheet" href="../../bootstrap/css/bootstrap.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css" />

    <link rel="icon" href="../../Home_Section\media\immagini\icon.png">


</head>

<body>



    <form name="myform" action="" method="POST" class="form-signin">

        <img src="../media/finito.jpg" width="190px" />

        <h5 id="login" class="h1 mb-3 mt-5">Login</h5>
        <!--Ricarichiamo i dati come value sugli InputType se avevamo detto di essere ricordati-->


        <input id="email" type="email" name="email" class="form-control  mt-1" value="<?php


                                                                                        if (isset($_POST['submit'])) {
                                                                                            echo $_POST["email"];
                                                                                        } else {
                                                                                            if ($tupleRemember) {

                                                                                                echo $_POST["email"];
                                                                                            }
                                                                                        }
                                                                                        ?>" required autofocus />
        <label id="labelEmail" placeholder="Email Inserita" , alt=" Email "> </label>
        <div>
            <input id="password" type="password" class="form-control" name="pswd" value="<?php

                                                                                            if (isset($_POST['submit'])) {
                                                                                                echo $_POST["pswd"];
                                                                                            } else {
                                                                                                if ($tupleRemember) {
                                                                                                    echo $_POST["pswd"];
                                                                                                }
                                                                                            } ?>" pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#$%^&*_=+-.]).{8,16}$" required />

            <label id="labelPass" placeholder="Password Inserita" , alt=" Password "> </label>

        </div>
        <div class="bi bi-eye-slash " id="togglePassword"></div>

        <p id="errore"></p>


        <div id="ricordami" class="h6 mb-2 ">
            <label>Ricordami:</label>
            <input type="checkbox" name="rememberMe" id="rmb" />
        </div>

        <button id="invia" type="submit" class="btn btn-danger" name="submit">Accedi</button>

        <div class="mb-2 mt-4">
            <a id="registrati" href="../Registrazione/index.php">Registrati ora!</a>
        </div>

    </form>



    <script>
        invia.addEventListener("click", function() {
            // Rendo o nascondo il testo


            flagJS = "<?php
                        // Percorso al file di configurazione
                        $configFilePath = '../dir_queries/queries.ini';

                        // Caricamento delle configurazioni
                        $queryConfig = parse_ini_file($configFilePath, true);
                        echo $flag; ?>";

            if (flagJS == "nulla") {
                /*
                $("#errore").show();
                $("#errore").text("*Email o password errati!*");
                */
            }

        });
    </script>

    <script src="./index.js"></script>

</body>

</html>