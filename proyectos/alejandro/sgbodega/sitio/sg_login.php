<?php
session_start();

require_once 'includes/xajax/xajax.inc.php'; //archivo de configuracion de ajax
include "../includes/php/conf_smarty.php";//archivo de configuracion de smarty
include "../includes/php/conf_bd.php"; //archivo de coneccion al servidor y base de datos

$xajax = new xajax();

$xajax->setRequestURI("sg_login.php");
$xajax->setCharEncoding("UTF8");
$xajax->decodeUTF8InputOn();

function Grabar($data){
    global $conexion;
    $objResponse = new xajaxResponse('UTF8');
	
	$usua_id 		= 	$data["OBLI-txtUsuario"];
	$usua_password 	= 	$data["OBLI-txtPassword"];
	
	if (($usua_id != '') && ($usua_password != '')){
		$sql = "select * from usuarios where usu_login = '".$usua_id."' and usu_pass = '".$usua_password."'";
		$res = mysql_query($sql, $conexion) or die(mysql_error($conexion));
		if (mysql_num_rows($res) > 0){
			$_SESSION["alycar_nombreusuario"] = @mysql_result($res,0,"usu_nombre");
			$_SESSION["alycar_usuario"] = @mysql_result($res,0,"usu_login");
			$_SESSION["alycar_perfil"] = @mysql_result($res,0,"perf_ncorr");
			$_SESSION["sige_email_usuario"] = @mysql_result($res,0,"email");
	
			$objResponse->addScript("top.location.href='principal.php'");
		
		}else{
			
			$objResponse->addScript("alert('Usuario Incorrecto');");
		}
	}
	
	return $objResponse->getXML();
}
function CargaPagina($data){
    global $conexion;
    $objResponse = new xajaxResponse('UTF8');
	
	$objResponse->addScript("document.getElementById('OBLI-txtUsuario').focus();");
		
	return $objResponse->getXML();
}          


function CargaSelect($data, $select, $tabla, $codigo, $descripcion, $campo1, $campo2, $opt){
    global $conexion;
    $objResponse = new xajaxResponse('UTF8');
	
	$objResponse->addAssign("$select","innerHTML",""); 		
	
    $sql = "select $campo1 as codigo, $campo2 as descripcion from $tabla $opt";
    $res = mysql_query($sql, $conexion) or die(mysql_error($conexion));
	
	if (@mysql_num_rows($res) > 0) {
        $j=0;
		while ($line = mysql_fetch_array($res)) {
			$objResponse->addCreate("$select","option",""); 		
			$objResponse->addAssign("$select","options[".$j."].value", $line[0]);
			$objResponse->addAssign("$select","options[".$j."].text", $line[1]); 	
			$j++;
		}
	}
	
	return $objResponse->getXML();
}

$xajax->registerFunction("Grabar");
$xajax->registerFunction("CargaPagina");
$xajax->registerFunction("CargaSelect");

$xajax->processRequests(); 
$miSmarty->assign('xajax_js', $xajax->getJavascript());


$miSmarty->display('sg_login.tpl');

?>