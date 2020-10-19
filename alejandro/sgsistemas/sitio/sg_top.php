<?php
session_set_cookie_params('18000'); // 5 HORAS
session_start();
date_default_timezone_set("America/Santiago");
setlocale(LC_TIME, 'spanish');

require_once 'includes/xajax/xajax.inc.php'; //archivo de configuracion de ajax
include "../includes/php/conf_smarty.php";//archivo de configuracion de smarty
include "../includes/php/conf_bd.php"; //archivo de coneccion al servidor y base de datos

$xajax = new xajax();

$xajax->setRequestURI("sg_top.php");
$xajax->setCharEncoding("ISO-8859-1");
$xajax->decodeUTF8InputOn();

function Grabar($data){
    global $conexion;
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	$usua_id 		= 	$data["OBLI-txtUsuario"];
	$usua_password 	= 	$data["OBLI-txtPassword"];
	
	if (($usua_id != '') && ($usua_password != '')){
		$sql = "select * from usuarios where usu_login = '".$usua_id."' and usu_pass = '".$usua_password."'";
		$res = mysql_query($sql, $conexion);
		if (mysql_num_rows($res) > 0){
			$_SESSION["alycar_nombreusuario"] = @mysql_result($res,0,"usu_nombre");
			$_SESSION["alycar_usuario"] = @mysql_result($res,0,"usu_login");
			
			$objResponse->addScript("top.location.href='principal.php'");
		
		}else{
			
			$objResponse->addScript("alert('Usuario Incorrecto');");
		}
	}
	
	return $objResponse->getXML();
}
function CargaPagina($data){
    global $conexion;
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	$objResponse->addAssign("divfecha", "innerHTML", strftime("Hoy es %A %d de %B del %Y")." ".date(" H:i:s",time()));
	
	return $objResponse->getXML();
}          

$xajax->registerFunction("Grabar");
$xajax->registerFunction("CargaPagina");

$xajax->processRequests();
$miSmarty->assign('xajax_js', $xajax->getJavascript());

$miSmarty->display('sg_top.tpl');

?>

