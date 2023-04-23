<?php
session_set_cookie_params('18000'); // 5 HORAS
session_start();

require_once 'includes/xajax/xajax.inc.php'; //archivo de configuracion de ajax
include "../includes/php/conf_smarty.php";//archivo de configuracion de smarty
include "../includes/php/conf_bd.php"; //archivo de coneccion al servidor y base de datos

$xajax = new xajax();

$xajax->setRequestURI("sg_login.php");
$xajax->setCharEncoding("ISO-8859-1");
$xajax->decodeUTF8InputOn();

function Grabar($data){
    global $conexion;
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	$usua_id 		= 	$data["OBLI-txtUsuario"];
	$usua_password 	= 	$data["OBLI-txtPassword"];
	
	if (($usua_id != '') && ($usua_password != '')){
		$sql = "select * from usuarios where US_USUARIO = '".$usua_id."' and US_PASSWORD = '".$usua_password."'";
		$res = mysql_query($sql, $conexion);
		if (mysql_num_rows($res) > 0){
			$_SESSION["alycar_nombreusuario"] = @mysql_result($res,0,"US_INGRESO");
			$_SESSION["alycar_usuario"] = @mysql_result($res,0,"US_USUARIO");
			$_SESSION["alycar_perfil"] = @mysql_result($res,0,"US_PERFIL");
			
			$objResponse->addScript("top.location.href='sg_seleccion_empresa.php'");
		
		}else{
			
			$objResponse->addScript("alert('Usuario Incorrecto');");
		}
	}
	
	return $objResponse->getXML();
}
function CargaPagina($data){
    global $conexion;
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	$objResponse->addScript("document.getElementById('OBLI-txtUsuario').focus();");
	
	return $objResponse->getXML();
}          

$xajax->registerFunction("Grabar");
$xajax->registerFunction("CargaPagina");

$xajax->processRequests();
$miSmarty->assign('xajax_js', $xajax->getJavascript());

$miSmarty->display('sg_login.tpl');

?>

