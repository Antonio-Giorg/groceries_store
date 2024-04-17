<?php


$configFilePath = '../../dir_queries/queries.ini';  // Adjust the path as needed
    $queryConfig = parse_ini_file($configFilePath, true);


$modifica=0;
    if($_GET){
        $modifica=1;
    }
session_start();


$_SESSION["loggato"]=0;
if($modifica==0){
    $db = getenv('PG_DATABASE');

$a=pg_query_params($dbconn, $queryConfig['session_queries']['delete_session'], array(session_id())); //Ci prendiamo la TABELLA risultante dalla query
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