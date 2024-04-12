<?php
//page 2

setcookie("b", "fiasdasnale", time()+400);
session_start();





#print_r($_SERVER);
print_r($_COOKIE);
if(isset($_COOKIE["no"])){
    echo ("ciao");
}else{
    echo ("non c'è");
}




if(isset($_SESSION['var1'])){
echo $_SESSION['var1']; 
}
#print_r($_SESSION);
//OUTPUT: My Portuguese text: SOU Gaucho!
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">


    <title>primoo</title>
    
</head>
<style>
html, body {
    height: 100%;
}

html {
    display: table;
    margin: auto;
}

body {
    display: table-cell;
    vertical-align: middle;
}
</style>
<body>



<button> <a href="./index.php">entra nel portale!!</a> </button>




</body>
</html>