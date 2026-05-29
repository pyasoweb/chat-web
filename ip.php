<?php
echo "<h1>Estaditicas del sitio:</h1>";
echo $_SERVER['SERVER_NAME'];
 
//Recuperar informacion del visitante de la variabler globa $_SERVER
echo "<h4>nombre de la pagina web actual</h4>";
echo $_SERVER['PHP_SELF'];
 
echo "<h4>Pagina web de donde viene el visitante</h4>";
echo $_SERVER['HTTP_REFERER'];
 
echo "<h4> Nombre del navegador</h4>";
echo $_SERVER['HTTP_USER_AGENT'];
 
echo "<h4>Direccion Ip del visitante</h4>";
echo $_SERVER['REMOTE_ADDR'];
?>
