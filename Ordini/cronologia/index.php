<?php
    session_start();


    $a = $_COOKIE['PHPSESSID'];

    $dbconn = pg_connect("host=localhost dbname=ltw_db port=5432 user=postgres password=password");
    $queryRemember = "SELECT * FROM public.utente INNER JOIN public.identificativo ON public.utente.codice = public.identificativo.codcliente WHERE public.identificativo.codice = $1;";
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
        $_SESSION['codice'] = $tuple["codcliente"];

        $_SESSION['loggato'] = 1;
        $_SESSION['nome'] = $tuple["nome"];
    }
    #echo $_SESSION['codice'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="cronologia.css">
    <title>Cronologia Ordini</title>
</head>

<body style="background: rgba(0, 128, 0, 0.3)">

    <H1>CRONOLOGIA ORDINI</H1>

    <script>
        var dati =
            <?php

            if (!isset($_SESSION["loggato"]) && !isset($_COOKIE["nome"])) {
                header("location: ../../Home_Section/index.php");
                return;
            }

            if (isset($_SESSION["codice"])) {
                $codice = $_SESSION["codice"];
            }
            if (isset($_COOKIE["codice"])) {
                $codice = $_COOKIE["codice"];
            }

            $dbconn = pg_connect("host=localhost dbname=ltw_db port=5432 user=postgres password=password");
            $query = 
            "SELECT public.prodotto.nome, public.tipologia.*, public.transazione.scadenza, public.transazione.quantità, public.transazione.momento, public.transazione.via, public.transazione.ritiro FROM public.tipologia, public.transazione INNER JOIN public.prodotto ON public.transazione.codprodotto=public.prodotto.codice WHERE codcliente=$1 AND public.tipologia.categoria=public.prodotto.codtipologia ORDER BY public.transazione.momento DESC;";
            $result = pg_query_params($dbconn, $query, array($codice)); //Ci prendiamo la TABELLA risultante dalla query
            $array2 = array();
            while ($tuple = pg_fetch_array($result, null, PGSQL_ASSOC)) {
                $appoggio = array_values($tuple);
                $array2 = array_merge($array2, $appoggio);
            }
            echo '["' . implode('", "', $array2) . '"]';
            ?>;
        sessionStorage.setItem("jsArray", JSON.stringify(dati)); /*Salviamo mediante la sessionstorage in formato JSON, i dati prelevati dalla table e che saranno passati al JS 
        per l'elaborazione e la generazione di una tabella dinamica contenente i dati delle donazioni fatte dell'utente loggato.*/
    </script>
    <script src="./index.js"></script>

    <div class="container">
        <div class="row" id="riga">
            <div class="col-6" id="statistiche">
                <?php
                $dbconn = pg_connect("host=localhost dbname=ltw_db port=5432 user=postgres password=password");
                $query = "SELECT SUM(public.transazione.quantità), public.tipologia.categoria FROM public.tipologia, public.transazione INNER JOIN public.prodotto ON public.transazione.codprodotto=public.prodotto.codice WHERE codcliente=$1 AND public.tipologia.categoria=public.prodotto.codtipologia GROUP BY public.tipologia.categoria;";
                $result = pg_query_params($dbconn, $query, array($codice)); //Ci prendiamo la TABELLA risultante dalla query
                $array2 = array();
                while ($tuple = pg_fetch_array($result, null, PGSQL_ASSOC)) { //Scorriamo tutte le righe della tabella risultante della query prendendone i valori.
                    $appoggio = array_values($tuple);
                    if (($appoggio[0] != "") && ($appoggio[1] != "")) {
                        echo "<p>Quantità di $appoggio[1] donata ,complessivamente, pari a: $appoggio[0] KG</p>"; //Lo printiamo sulla Cronologia come resoconto.
                    }
                }


                ?>
            </div>

            <div class="col-sm"> </div>

            <div class="col-sm" id="bordo">
                <div id="spazio">
                    <div id="caption"> Legenda per le date di consegna: </div>

                    <div class="container" id="primo">
                        <div class="row">
                            <div class="col-1 ">
                                <div class="verde"></div>
                            </div>
                            <div class="col-sm">
                                Il tuo ordine sarà ritirato nei giorni successivi
                            </div>
                        </div>
                    </div>

                    <div class="container">
                        <div class="row">
                            <div class="col-1 ">
                                <div class="arancione"></div>
                            </div>
                            <div class="col-sm">
                                il tuo ordine sarà ritirato entro oggi</div>
                        </div>
                    </div>

                    <div class="container">
                        <div class="row">
                            <div class="col-1 ">
                                <div class="grigio"></div>
                            </div>
                            <div class="col-sm">
                                il tuo ordine è stato ritirato nei giorni precedenti</div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>


    </div>
    <a href="../../Home_Section/index.php" class="bottone1">HOME</a>


    </div>
</body>

</html>