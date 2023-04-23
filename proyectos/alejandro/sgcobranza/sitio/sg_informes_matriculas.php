<?php

session_start();



require_once 'includes/xajax/xajax.inc.php'; //archivo de configuracion de ajax

include "../includes/php/conf_smarty.php";//archivo de configuracion de smarty

include "../includes/php/conf_bd.php"; //archivo de coneccion al servidor y base de datos

include "../includes/php/validaciones.php"; 

$xajax = new xajax();



$xajax->setRequestURI("sg_informes_matriculas.php");

$xajax->setCharEncoding("UTF8");

$xajax->decodeUTF8InputOn();







$xajax->processRequests();

$miSmarty->assign('xajax_js', $xajax->getJavascript());





$miSmarty->display('sg_informes_matriculas.tpl');

?>

