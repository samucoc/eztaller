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

$xajax->setRequestURI("sg_movimientos_detalle.php");
$xajax->setCharEncoding("UTF8");
$xajax->decodeUTF8InputOn();


function CargaPagina($data){
    global $conexion;
    global $miSmarty;
	$objResponse = new xajaxResponse('UTF8');
	
	$nro_boleta = $data['nro_boleta'];

	$tbl="";
	$sql_boletas = "select DATE_FORMAT(FechaBoleta,'%d/%m/%Y') as FechaBoleta, `DescripcionBoleta`, ValorBoleta
					from gescolcl_arcoiris_administracion.Movimientos 
					where NumeroBoleta in (select NumeroBoleta 
											from  gescolcl_arcoiris_administracion.Movimientos 
											where mov_ncorr = '".$nro_boleta."')";
	$res_boletas = mysql_query($sql_boletas,$conexion) or die(mysql_error());
	$tbl .= '<table class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">';
	while($row_boletas = mysql_fetch_array($res_boletas)){
		$tbl .= '<tr>';
		$tbl .= '<td class="grilla-tab-fila-campo" >'.$row_boletas['FechaBoleta'].'</td>';
		$tbl .= '<td class="grilla-tab-fila-campo" >'.$row_boletas['DescripcionBoleta'].'</td>';
		$tbl .= '<td class="grilla-tab-fila-campo" >'.$row_boletas['ValorBoleta'].'</td>';
		$tbl .= '</tr>';
		}
	$tbl .= '</table>';
	$objResponse->addAssign("divabonos", "innerHTML", $tbl);
	
	return $objResponse->getXML();
}          

function Imprime(){
    global $conexion;
    $objResponse = new xajaxResponse('UTF8');
	
	$objResponse->addScript("ImprimeDiv('divabonos');");
	
	return $objResponse->getXML();
}

$xajax->registerFunction("CargaPagina");
$xajax->registerFunction("Imprime");

$xajax->processRequests();
$miSmarty->assign('xajax_js', $xajax->getJavascript());

$miSmarty->assign('nro_boleta', $_GET["nro_boleta"]);

$miSmarty->display('sg_movimientos_detalle.tpl');


ob_flush();
?>

