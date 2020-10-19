<?php
session_start();

$NumeroRutAlumno 		= $_GET['NumeroRutAlumno'];
$anio					= $_GET["periodo"];

include "../../includes/php/conf_bd.php"; //archivo de coneccion al servidor y base de datos

$data 	= array();

$sql = "SELECT * 
        FROM AlumnosCondicional
        WHERE NumeroRutAlumno like '".$NumeroRutAlumno."' 
            and  periodo like '".$anio."'
			limit 0,20";
$res = mysql_query($sql, $conexion);
$i=0; 
if (mysql_num_rows($res)>0){
	echo "0";
	}	     
else{
	echo "1";
	}	  
?>