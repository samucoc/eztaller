<?php
session_start();

require_once 'includes/xajax/xajax.inc.php'; //archivo de configuracion de ajax
include "../includes/php/conf_smarty.php";//archivo de configuracion de smarty
include "../includes/php/conf_bd.php"; //archivo de coneccion al servidor y base de datos
//include "../includes/php/conf_bd_antigua.php"; //archivo de coneccion al servidor de yonley
include "../includes/php/validaciones.php"; 

$xajax = new xajax();

$xajax->setRequestURI("sg_bodega_toma_inventario_cierre.php");
$xajax->setCharEncoding("ISO-8859-1");
$xajax->decodeUTF8InputOn();

function Grabar($data){
	global $conexion;
	
	$cinv_fecha			= 	$data["OBLItxtCierre"];
	$cinv_usuario		= 	$_SESSION["alycar_sgyonley_usuario"];
	$cinv_fechadig		= 	date("Y-m-d H:i:s");
	
	$fecha1 		= 	explode("/", $cinv_fecha); $dia1 = $fecha1[0]; $mes1 = $fecha1[1]; $anio1 = $fecha1[2];
	$cinv_fecha 	= 	$anio1."-".$mes1."-".$dia1;
	
	$sql = "insert into cierres_inventarios (cinv_fecha,cinv_usuario,cinv_fechadig)
			values ('".$cinv_fecha."','".$cinv_usuario."','".$cinv_fechadig."')";
	$res = mysql_query($sql,$conexion);
	
	$objResponse = new xajaxResponse('ISO-8859-1');
	
	$objResponse->addScript("window.parent.hidePopWin(true)");	

	return $objResponse->getXML();
}
function CargaPagina($data){
	global $conexion;
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	// busca el ultimo cierre
	$sql = "select DATE_FORMAT(cinv_fecha,'%d/%m/%Y') as ultcierre from cierres_inventarios order by cinv_fecha desc limit 1";
	$res = mysql_query($sql,$conexion);
	
	$objResponse->addAssign("txtUltCierre", "value", @mysql_result($res,0,"ultcierre"));

	$objResponse->addScript("document.getElementById('OBLItxtCierre').focus();");

	return $objResponse->getXML();
}          

function Imprime(){
    global $conexion;
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	$objResponse->addScript("showPopWin('sg_bodega_toma_inventario_cierre.php', 'Cierre para Inventario', 700, 280, null);");
	
	$objResponse->addScript("ImprimeDiv('divabonos');");
	
	return $objResponse->getXML();
}

$xajax->registerFunction("CargaPagina");
$xajax->registerFunction("Grabar");
$xajax->registerFunction("Imprime");

$xajax->processRequests();
$miSmarty->assign('xajax_js', $xajax->getJavascript());

$miSmarty->display('sg_bodega_toma_inventario_cierre.tpl');

?>

