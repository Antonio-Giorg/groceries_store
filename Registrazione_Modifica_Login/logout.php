<?php
$modifica=0;
    if($_GET){
        $modifica=1;
    }
session_start();


$_SESSION["loggato"]=0;
if($modifica==0){
    $dbconn = pg_connect("host=localhost dbname=LTW_DB port=5432 user=postgres password=password");
    $query='DELETE FROM identificativo WHERE $1=codice';
$a=pg_query_params($dbconn, $query, array(session_id())); //Ci prendiamo la TABELLA risultante dalla query
session_regenerate_id();
}


session_unset();
session_destroy();
// unset cookies
if (isset($_SERVER['HTTP_COOKIE'])) {
    $cookies = explode(';', $_SERVER['HTTP_COOKIE']);
    foreach($cookies as $cookie) {
        $parts = explode('=', $cookie);
        $name = trim($parts[0]);
        setcookie($name, '', time()-1000);
        setcookie($name, '', time()-1000, '/');
    }
}



 header("location: ./login/index.php ");



?>