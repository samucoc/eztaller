<?php
session_set_cookie_params('18000'); // 5 HORAS
session_start();

require_once 'includes/xajax/xajax.inc.php'; //archivo de configuracion de ajax
include "../includes/php/conf_smarty.php";//archivo de configuracion de smarty
include "../includes/php/conf_bd.php"; //archivo de coneccion al servidor y base de datos

$xajax = new xajax();

$xajax->setRequestURI("sg_seleccion_empresa.php");
$xajax->setCharEncoding("ISO-8859-1");
$xajax->decodeUTF8InputOn();

function Grabar($data){
    global $conexion;
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	$empe_ncorr = $data["OBLIcboBodega"];
	
	$_SESSION["alycar_sgyonley_bodega"] = $empe_ncorr; //empe_ncorr
	
	$sql = "select bodega_ncorr, nombre from sgbodega.bodegas where bodega_ncorr = '".$empe_ncorr."'";
	$res = mysql_query($sql, $conexion);
	
	$_SESSION["alycar_sgyonley_bodega_nombre"] = 	mysql_result($res,0,"nombre");
	
	
	$objResponse->addScript("top.location.href='principal.php'");
			
	return $objResponse->getXML();
}
function CargaPagina($data){
    global $conexion;
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	// carga tipos de vehiculos
	$ncorr=1;
	$objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'OBLIcboBodega','sgbodega.bodegas','','- - Seleccione - -','bodega_ncorr', 'nombre', '')");
	
	$objResponse->addScript("document.getElementById('OBLIcboBodega').focus();");
	
	return $objResponse->getXML();
}          

function CargaSelect($data, $select, $tabla, $codigo, $descripcion, $campo1, $campo2, $opt){
    global $conexion;
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	$objResponse->addAssign("$select","innerHTML",""); 		
	$usuario = $_SESSION['alycar_usuario'];
	$opt = ' where bodega_ncorr in (select bodega_ncorr 
													  from sgbodega.bodega_tiene_usuarios
													  where usuario = "'.$usuario.'")';
	
	$sql = "select $campo1 as codigo, $campo2 as descripcion from $tabla $opt";
	$res = mysql_query($sql, $conexion);
	
	if (mysql_num_rows($res) > 0) {
		if ($opt == '1'){
			$j = 0;
		}else{
			$objResponse->addCreate("$select","option",""); 		
			$objResponse->addAssign("$select","options[0].value", $codigo);
			$objResponse->addAssign("$select","options[0].text", $descripcion); 	
			$j = 1;
		}
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

$miSmarty->assign('NOMBREUSUARIO', $_SESSION["alycar_nombreusuario"]);

$miSmarty->display('sg_seleccion_empresa.tpl');

?>

