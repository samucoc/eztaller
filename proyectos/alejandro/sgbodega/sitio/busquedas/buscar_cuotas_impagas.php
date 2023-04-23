<?php
session_start();

$NumeroRutAlumno 		= 	$_GET['NumeroRutAlumno'];
$anio					= 	$_GET["periodo"];
$anio_ant				=	$anio-1;

include "../../includes/php/conf_bd.php"; //archivo de coneccion al servidor y base de datos

$data 	= array();

$sql = "SELECT sum(ValorPactado)-sum(ValorPagado) as saldo
        FROM 	CuentaCorriente".$anio_ant."
        WHERE NumeroRutAlumno like '".$NumeroRutAlumno."' and 
        		FechaVencimiento <= '".date('Y-m-d',mktime(0,0,0,date("m"),date("d"),$anio_ant))."'

            limit 0,20";
$res = mysql_query($sql, $conexion);
$i=0; 
$row = mysql_fetch_array($res);
if ($row['saldo']>0){
	echo "0";
	}
else{
	echo "1";
	}

?>