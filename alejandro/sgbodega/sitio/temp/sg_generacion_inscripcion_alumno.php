<?php
ob_start();
session_start();

require_once 'includes/xajax/xajax.inc.php'; //archivo de configuracion de ajax
include "../includes/php/conf_smarty.php";//archivo de configuracion de smarty
include "../includes/php/conf_bd.php"; //archivo de coneccion al servidor y base de datos
include "../includes/php/validaciones.php"; 

$xajax = new xajax();

$xajax->setRequestURI("sg_generacion_inscripcion_alumno.php");
$xajax->setCharEncoding("UTF8");
$xajax->decodeUTF8InputOn();

function Enviar($data,$arrRegistros){

}

function Grabar($data){

		}


$xajax->registerFunction("Enviar");
$xajax->registerFunction("Grabar");


$xajax->processRequests();
$miSmarty->assign('xajax_js', $xajax->getJavascript());


$miSmarty->display('sg_generacion_inscripcion_alumno.tpl');


ob_flush();
?>

