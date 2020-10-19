<?php
session_set_cookie_params('18000'); // 5 HORAS
session_start();
unset($_SESSION['alycar_sistemas']);

require_once 'includes/xajax/xajax.inc.php'; //archivo de configuracion de ajax
include "../includes/php/conf_smarty.php";//archivo de configuracion de smarty
include "../includes/php/conf_bd.php"; //archivo de coneccion al servidor y base de datos

$xajax = new xajax();

$xajax->setRequestURI("sg_login.php");
$xajax->setCharEncoding("ISO-8859-1");
$xajax->decodeUTF8InputOn();

function Acceso($data,$cadena){
    global $conexion;
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	$objResponse->addAssign("divacceso", "innerHTML", $cadena);
	
	return $objResponse->getXML();
}          
function Ingresa($data,$opt){
    global $conexion;
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	$_SESSION['alycar_sistemas']	= 	'SI';
	
	if ($opt == '1'){ // Sige
		$objResponse->addScript("top.location.href='../../sgbodega/sitio/sg_index.php';");
	}
	if ($opt == '2'){ // cobranza
		$objResponse->addScript("top.location.href='../../sgcobranza/sitio/sg_index.php';");
	}
	
	return $objResponse->getXML();
} 

$xajax->registerFunction("Acceso");
$xajax->registerFunction("Ingresa");

$xajax->processRequests();
$miSmarty->assign('xajax_js', $xajax->getJavascript());

$miSmarty->display('sg_login.tpl');

?>

