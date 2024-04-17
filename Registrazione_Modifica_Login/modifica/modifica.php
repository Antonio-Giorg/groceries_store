<?php


session_start();

        
if (!isset($_SESSION["loggato"]) || !isset($_COOKIE["nome"])){
        header("location: ../../Home_Section/index.php");
        return;
}
     

$nome=$_POST["nome"];
$cognome=$_POST["cognome"];
$email=$_POST["email"];
$password=$_POST["pswd"];
$cap=$_POST["cap"];
$cellulare=$_POST["cell"];
$cf=$_POST["cf"];
$città=$_POST["città"];
$via=$_POST["via"];
$regione=$_POST["regione"];

if (isset($_SESSION["codice"])){
        $codice=$_SESSION["codice"];
}
if (isset($_COOKIE["codice"])){
        $codice=$_COOKIE["codice"];
}

$dbconn = pg_connect("host=localhost dbname=ltw_db port=5432 user=postgres password=password");   


$query2= 'UPDATE utente SET nome=$1,cognome=$2,email=$3,pswd=$4,cap=$5,cellulare=$6,cf=$7,città=$8,via=$9,regione=$10  WHERE codice=$11';

$result = pg_query_params($db, $query2, array($nome,$cognome,$email,$password,$cap,$cellulare,$cf,$città,$via,$regione,$codice));
     
if ($result){
        $modifica = 1;
        session_unset();
        header("location: ../logout.php?user=".$modifica);
}else die(
               
        print_r($_POST)
          
);
        


?>

