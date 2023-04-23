<?php
session_start();

$fecha 		= $_GET['fecha'];
list($d,$m,$a) = explode('/',$fecha);
$fecha = $a.'-'.$m.'-'.$d;
$hora					= $_GET["hora"];

include "../../includes/php/conf_bd.php"; //archivo de coneccion al servidor y base de datos

$data 	= array();

$sql = "SELECT * 
        FROM AgendaMatricula
        WHERE fechaAgenda like '".$fecha."' 
            and  horaAgenda like '".$hora.":00'
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