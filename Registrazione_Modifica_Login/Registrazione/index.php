<?php
// Percorso al file di configurazione
$configFilePath = '../../dir_queries\queries.ini';

// Caricamento delle configurazioni
$queryConfig = parse_ini_file($configFilePath, true);
session_start();
if(isset($_POST['submit'])){      
    $dbconn = pg_connect("host=127.0.0.1 port=5432 dbname=ltw_db user=postgres password=password");

    $email = $_POST["email"];
    $query = 'SELECT * from utente where email=$1';
    $result = pg_query_params($dbconn,$queryConfig['database_queries']['check_user_email'], array($email));



    if ($tuple=pg_fetch_array($result,null,PGSQL_ASSOC)){

        //non usare
        //echo "<script>if(confirm('e-mail già usata!')){document.location.href='index.php'};</script>";


        echo '<script type="text/javascript">';
        echo ' alert("e-mail già usata")';  //not showing an alert box.
        
        echo '</script>';
        
    }else{
        $CodFisc = $_POST["cf"];
        
        $query2 = 'SELECT * from utente where cf=$1';
        $result2 = pg_query_params($dbconn,$queryConfig['database_queries']['check_user_cf'], array($CodFisc));

        if ($tuple2=pg_fetch_array($result2,null,PGSQL_ASSOC)){

        // echo "<script>if(confirm('Codice fiscale già usato!')){document.location.href='index.php'};</script>";
        echo '<script type="text/javascript">';
        echo ' alert("Codice fiscale già usato")';  //not showing an alert box.
        echo '</script>';
        
        }else{

        $nome = $_POST["nome"];
        $cognome = $_POST["cognome"];
        $email = $_POST["email"];
        $pswd = $_POST["pswd"];
        $cap = $_POST["cap"];
        $cell = $_POST["cell"];
        $cf = $_POST["cf"];
        $citta = $_POST["citta"];
        $via = $_POST["via"];
        $regione = $_POST["regione"];


       

        $enc_pwd = hash('sha256',$pswd);
        $metodo = 'aes';

        $query2 = 'INSERT INTO public.utente(nome,cognome,email,pswd,cap,cellulare,cf,città,via,regione) values ($1,$2,$3,$4,$5,$6,$7,$8,$9,$10)';
        $result = pg_query_params($dbconn, $queryConfig['database_queries']['insert_new_user'], array($nome,$cognome,$email,$enc_pwd,$cap,$cell,$cf,$città,$via,$regione));
        if ($result){
        
            header("location: ../login/index.php");
        }else {
            var_dump($result);
            die("c'è stato un errore");
        }
        
        }
    }
}

?>


<!DOCTYPE html>
<html lang="it">

    <head>
        <title>Registrazione</title>       
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device.width,initial-scale=1">
        <link rel="stylesheet" href="./style.css">
        <link rel="stylesheet" href="../../bootstrap/css/bootstrap.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css" />
        <link rel="icon" href="../../Home_Section\media\immagini\icon.png">

    </head>

    <body background="../media/sfondo.webp" >

    <form id="Form" action="" method="POST" name="myForm" class="form-signin text-center"  >  

            <img src="../media/finito.jpg" width="190px" />

            <h1 id="registrati" class="h1 mb-3 ">Registrati</h1>

                <input type="email" name="email" class="form-control" value="<?php 

 if(isset($_POST['submit'])){ echo $_POST["email"];}?>" required autofocus></input>

                <label placeholder="E-mail inserita", alt=" E-mail" > </label>
                 
          
       
                <input type="password" class="form-control" name="pswd" id="pass" value="<?php 

 if(isset($_POST['submit'])){ echo $_POST["pswd"];}?>" pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#$%^&*_=+-.]).{8,16}$" required/>

                <label placeholder="Password inserita", alt=" Password" > </label>
                <div class="bi bi-eye-slash" id="togglePassword"></div>
                
     


            <input type="text" name="nome" class="form-control"  value="<?php 

 if(isset($_POST['submit'])){ echo $_POST["nome"];}?>" pattern="^[A-Za-z]+$" required autofocus/>       
            <label placeholder="Nome Inserito", alt=" nome" > </label>



            <input type="text" name="cognome" class="form-control" value="<?php 

 if(isset($_POST['submit'])){ echo $_POST["cognome"];}?>"
                pattern="^[A-Za-z]+$" required/>
                <label  placeholder="cognome inserito", alt=" cognome" > </label>
            
            <input type="tel" name="cell" class="form-control"  value="<?php 

 if(isset($_POST['submit'])){ echo $_POST["cell"];}?>" pattern="[0-9]{10}" required/>
            <label placeholder="numero di cell inserito", alt=" numero di cellulare" > </label>


            <input type="text" name="cf" class="form-control"    value="<?php 

 if(isset($_POST['submit'])){ echo $_POST["cf"];}?>" pattern="^[a-zA-Z]{6}[0-9]{2}[a-zA-Z][0-9]{2}[a-zA-Z][0-9]{3}[a-zA-Z]$" required/>
            <label placeholder="Codice Fiscale inserito", alt=" Codice Fiscale" > </label>



            <input type="text"  class="box form-control" list="Regione" name="regione"   value="<?php 

 if(isset($_POST['submit'])){ echo $_POST["regione"];}?>" required />
            <label placeholder="Regione Inserita", alt=" Regione" > </label>

            <datalist  id="Regione">
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



            <input type="text" name="citta" class="form-control"  value="<?php 

 if(isset($_POST['submit'])){ echo $_POST["citta"];}?>"
           pattern="^[A-Za-z]+$" required autofocus/>       
            <label placeholder="città Inserito", alt=" citta" > </label>



            <input type="text" class="form-control" name="via" value="<?php 

 if(isset($_POST['submit'])){ echo $_POST["via"];}?>"
                pattern="^[a-zA-Z\s]+[0-9]*" required>
                <label  placeholder="via inserita", alt=" la via e numero" > </label>


            <div id="divCap" class="mb-3">
        
            <input type="text" class="cap form-control" name="cap" id="CAP" maxlength=5 size=8 value="<?php 

 if(isset($_POST['submit'])){ echo $_POST["cap"];}?>"
                pattern="^[0-9]{5}" required/>
                <label  placeholder="CAP inserito", alt="inserire il CAP" > </label>
            </div>

            <!--<img id="interrogativo" class="position-relative"  src="../media/interrogativo.png"  /> -->
            
            <div class="requisiti" id="req">
             <div id="testo"> Requisiti password: </div> 
             <ul>
              <li> 1 lettera minuscola  </li>
              <li> 1 lettere maiuscola </li>
              <li> 1 numero </li>
              <li> 1 carattere speciale  </li>
              <li> Deve essere compresa da 8 a 16 caratteri  </li>
            </ul>
            </div>

    
           <p> 
            <button type="submit" class="invia" name="submit">Registrati</button>
           </p>
        </form>
        
        <script src="./index.js"></script>

    </body>

</html>

