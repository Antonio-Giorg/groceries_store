<?php
$modifica=0;
    if($_GET){
        $modifica=1;
    }
session_start();


$_SESSION["loggato"]=0;
if($modifica==0){
<<<<<<< HEAD
    $db = getenv('PG_DATABASE');

$a=pg_query_params($db, $queryConfig['session_queries']['delete_session'], array(session_id())); //Ci prendiamo la TABELLA risultante dalla query
=======
    $dbconn = pg_connect("host=localhost dbname=ltw_db port=5432 user=postgres password=password");
    $query='DELETE FROM identificativo WHERE $1=codice';
$a=pg_query_params($dbconn, $query, array(session_id())); //Ci prendiamo la TABELLA risultante dalla query
>>>>>>> parent of 458389d (test alessio)
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