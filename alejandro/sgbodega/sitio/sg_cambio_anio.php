<?php
session_set_cookie_params('18000'); // 5 HORAS
session_start();

require_once 'includes/xajax/xajax.inc.php'; //archivo de configuracion de ajax
include "../includes/php/conf_smarty.php";//archivo de configuracion de smarty
include "../includes/php/conf_bd.php"; //archivo de coneccion al servidor y base de datos

$xajax = new xajax();

$xajax->setRequestURI("sg_cambio_anio.php");
$xajax->setCharEncoding("UTF8");
$xajax->decodeUTF8InputOn();

function Grabar($data){
    global $conexion;
    $objResponse = new xajaxResponse('UTF8');
	
	$_SESSION["sige_anio_escolar_vigente"] = $data["OBLIanio"];

	$objResponse->addScript("top.location.href='principal.php'");
		
	
	return $objResponse->getXML();
}

function CargaPagina($data){
    global $conexion;
    $objResponse = new xajaxResponse('UTF8');
	
	$objResponse->addScript("document.getElementById('OBLI-txtUsuario').focus();");
	
	$objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'OBLIanio','gescolcl_nmva_administracion.Periodos','','','distinct AnoAcademico','AnoAcademico', '')");
	       

	return $objResponse->getXML();
}          


function CargaSelect($data, $select, $tabla, $codigo, $descripcion, $campo1, $campo2, $opt){
    global $conexion;
    $objResponse = new xajaxResponse('UTF8');
	
	$objResponse->addAssign("$select","innerHTML",""); 		
	
    $sql = "select $campo1 as codigo, $campo2 as descripcion from $tabla $opt";
    $res = mysql_query($sql, $conexion) or die(mysql_error());
	
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

$miSmarty->display('sg_cambio_anio.tpl');

?>

