<?php
//PHP che mi scansiona il contenuto della Dir specificata e lo passa all'index.js tramite una codifica JSON come stringa

$dir = "../";

$a = scandir($dir);

$Stringa_dati_raccolti = json_encode($a);
  
  echo $Stringa_dati_raccolti;

?>