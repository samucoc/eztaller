<?php
ob_start();
session_start();

require_once 'includes/xajax/xajax.inc.php'; //archivo de configuracion de ajax
include "../includes/php/conf_smarty.php";//archivo de configuracion de smarty
include "../includes/php/conf_bd.php"; //archivo de coneccion al servidor y base de datos
//include "../includes/php/conf_bd_antigua.php"; //archivo de coneccion al servidor de yonley
include "../includes/php/validaciones.php"; 
/*
include "../includes/php/class.phpmailer.php";
include "../includes/php/class.pop3.php";
include "../includes/php/class.smtp.php";
include "../includes/php/PHPExcel.php";
include "../includes/php/PHPExcel/Reader/Excel2007.php";
*/
$xajax = new xajax();

$xajax->setRequestURI("sg_cobranza_grafico_pagos_anual.php");
$xajax->setCharEncoding("ISO-8859-1");
$xajax->decodeUTF8InputOn();


function Grabar($data){
    global $conexion;
    global $miSmarty;
	$objResponse = new xajaxResponse('ISO-8859-1');
	
	$anio = $data['anio'];
	$mes = $data['mes'];
	
	$arrRegistros = array();
	$arrRegistrosDetale = array();
	
	// $sql_boletas = "select distinct nombre
	// 				from gescolcl_test.Movimientos
	// 					inner join gescolcl_test.TipoPagoBoleta
	// 						on Movimientos.TipoPagoBoleta = TipoPagoBoleta.tpb_ncorr
	// 				where year(FechaBoleta) = '".$anio."' and month(FechaBoleta) = '".$mes."' 
	// 				group by FechaBoleta";
	// $res_boletas = mysql_query($sql_boletas,$conexion) or die(mysql_error());
	// while($row_boletas = mysql_fetch_array($res_boletas)){
	// 	array_push($arrRegistros,array(	'nombre'		=>	$row_boletas['nombre']
	// 									));
	// 	}
	

	// $sql_boletas = "select nombre, sum(ValorBoleta) as ValorBoleta, FechaBoleta
	// 				from gescolcl_test.Movimientos
	// 					inner join gescolcl_test.TipoPagoBoleta
	// 						on Movimientos.TipoPagoBoleta = TipoPagoBoleta.tpb_ncorr
	// 				where year(FechaBoleta) = '".$anio."' and month(FechaBoleta) = '".$mes."' 
	// 				group by FechaBoleta";
	// $res_boletas = mysql_query($sql_boletas,$conexion) or die(mysql_error());
	// while($row_boletas = mysql_fetch_array($res_boletas)){
	// 	array_push($arrRegistrosDetale,array(	'nombre'		=>	$row_boletas['nombre'],
	// 									'FechaBoleta'	=>	$row_boletas['FechaBoleta'],
	// 									'ValorBoleta'	=>	$row_boletas['ValorBoleta']
	// 									));
	// 	}

	// 	$miSmarty->assign('arrRegistrosDetale', $arrRegistrosDetale);
	// 	$miSmarty->assign('arrRegistros', $arrRegistros);
		
	$objResponse->addScript("showPopWin('sg_cobranza_visualizador_grafico_pagos_anual.php?anio=".$anio."', 'Estad&iacute;stica de Recaudaci&oacute;n Anual', 800, 600, null);");
	
	return $objResponse->getXML();
}          

function Imprime(){
    global $conexion;
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	$objResponse->addScript("ImprimeDiv('divabonos');");
	
	return $objResponse->getXML();
}

$xajax->registerFunction("Grabar");
$xajax->registerFunction("Imprime");

$xajax->processRequests();
$miSmarty->assign('xajax_js', $xajax->getJavascript());

$miSmarty->assign('nro_boleta', $_GET["nro_boleta"]);

$miSmarty->display('sg_cobranza_grafico_pagos_anual.tpl');

?>

