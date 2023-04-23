<?php

//coneccion local bd en mysql
$servidor= "186.67.71.229";
$usuario = "gescolcl";
//$pass = "admin.,240177";
//$pass 		= "";
$pass 		= "Q0.h=t61Zw&L538S";
$bd = "gescolcl_taller";

/*
$servidor = "localhost";
$usuario = "cyonley_vehusu";
$pass = "vehusu";
$bd = "cyonley_vehiculos";
*/


$conexion = mysql_connect($servidor, $usuario, $pass);
mysql_select_db($bd, $conexion);

ini_set("session.cookie_lifetime","7200");
ini_set("session.gc_maxlifetime","7200");
date_default_timezone_set("America/Santiago");


?>