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
	
	$empe_ncorr = $data["OBLI-cboEmpresa"];
	
	$_SESSION["alycar_sgyonley_empresa"] = $empe_ncorr; //empe_ncorr
	
	$sql = "select empe_rut, empe_desc from empresas where empe_ncorr = '".$empe_ncorr."'";
	$res = mysql_query($sql, $conexion);
	
	$_SESSION["alycar_sgyonley_empresa_rut"] 	= 	mysql_result($res,0,"empe_rut");
	$_SESSION["alycar_sgyonley_empresa_nombre"] = 	mysql_result($res,0,"empe_desc");
	
	
	$objResponse->addScript("top.location.href='principal.php'");
			
	return $objResponse->getXML();
}
function CargaPagina($data){
    global $conexion;
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	// carga tipos de vehiculos
	$ncorr=1;
	$objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'OBLI-cboEmpresa','empresas','','- - Seleccione - -','empe_ncorr', 'empe_desc', '')");
	
	$objResponse->addScript("document.getElementById('OBLI-cboEmpresa').focus();");
	
	return $objResponse->getXML();
}          

function CargaSelect($data, $select, $tabla, $codigo, $descripcion, $campo1, $campo2, $opt){
    global $conexion;
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	$objResponse->addAssign("$select","innerHTML",""); 		
	$sql = "select $campo1 as codigo, $campo2 as descripcion from $tabla";
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

$miSmarty->assign('NOMBREUSUARIO', $_SESSION["alycar_sgyonley_nombreusuario"]);

$miSmarty->display('sg_seleccion_empresa.tpl');

?>

