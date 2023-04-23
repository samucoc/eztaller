<?php
session_start();

require_once 'includes/xajax/xajax.inc.php'; //archivo de configuracion de ajax
include "../includes/php/conf_smarty.php";//archivo de configuracion de smarty
include "../includes/php/conf_bd.php"; //archivo de coneccion al servidor y base de datos
//include "../includes/php/conf_bd_antigua.php"; //archivo de coneccion al servidor de yonley
//include "../includes/php/sgbodega.php"; 
include "../includes/php/validaciones.php"; 

$xajax = new xajax();

$xajax->setRequestURI("sg_correos_aviso_seguro.php");
$xajax->setCharEncoding("ISO-8859-1");
$xajax->decodeUTF8InputOn();

function Grabar($data){
	global $conexion;
	
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	$rut_trabajador_1	=	$data["rut_trabajador_1"];
	$rut_trabajador_2	=	$data["rut_trabajador_2"];
	$dias_anticipa		=	$data["dias_anticipa"];
	$repeticion			=	$data["repeticion"];
	
	//	inserto el registro
	$sql = "insert into envio_correos (correo,dias_anticipa,repeticion)
					values ('".$rut_trabajador_1."','".$dias_anticipa."','".$repeticion."')";
	$res = mysql_query($sql,$conexion);

	//	inserto el registro
	$sql = "insert into envio_correos (correo,dias_anticipa,repeticion)
					values ('".$rut_trabajador_2."','".$dias_anticipa."','".$repeticion."')";
	$res = mysql_query($sql,$conexion);

    $objResponse->addScript("alert('Registro Grabado Correctamente.')");
    $objResponse->addScript("document.location.href='sg_correos_aviso_seguro.php';");
    return $objResponse->getXML();
}


$xajax->registerFunction("Grabar");

$xajax->processRequests();
$miSmarty->assign('xajax_js', $xajax->getJavascript());


$miSmarty->display('sg_correos_aviso_seguro.tpl');

?>

