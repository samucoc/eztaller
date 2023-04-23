<?php
session_start();

require_once 'includes/xajax/xajax.inc.php'; //archivo de configuracion de ajax
include "../includes/php/conf_smarty.php";//archivo de configuracion de smarty
include "../includes/php/conf_bd.php"; //archivo de coneccion al servidor y base de datos
//include "../includes/php/conf_bd_antigua.php"; //archivo de coneccion al servidor de yonley
include "../includes/php/validaciones.php"; 

$xajax = new xajax();

$xajax->setRequestURI("sg_seguros_siniestros.php");
$xajax->setCharEncoding("ISO-8859-1");
$xajax->decodeUTF8InputOn();

function Grabar($data){
	global $conexion;
	global $miSmarty;
	
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	$fecha = $data['fecha'];
	$patente = $data['cboPatente'];
	$trabajador = $data['rut_trab'];
	$obs = $data['obs'];
	
	list($dia1,$mes1,$anio1)	= explode('/', $fecha);
	$nro_mes_anterior       	= mktime(0, 0, 0, $mes1, $dia1,   $anio1);
	$fecha             			= date("Y-m-d",$nro_mes_anterior);
	
	$sql = "insert into siniestros(fecha,patente, trabajador,observacion)
				values('$fecha','$patente','$trabajador','$obs')";
	$res = mysql_query($sql,$conexion);
	
	$objResponse->addScript("alert('Registro Grabado Correctamente.')");
    $objResponse->addScript("document.location.href='sg_seguros_siniestros.php';");
	
	return $objResponse->getXML();
}

function Imprime(){
    global $conexion;
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	$objResponse->addScript("ImprimeDiv('divabonos');");
	
	return $objResponse->getXML();
}

function CargaPagina($data){
    global $conexion;
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	return $objResponse->getXML();
}  


$xajax->registerFunction("CargaPagina");
$xajax->registerFunction("Grabar");
$xajax->registerFunction("Imprime");

$xajax->processRequests();
$miSmarty->assign('xajax_js', $xajax->getJavascript());

$miSmarty->display('sg_seguros_siniestros.tpl');

?>

