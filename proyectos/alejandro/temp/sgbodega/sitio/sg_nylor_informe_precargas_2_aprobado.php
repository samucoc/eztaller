<?php
session_start();

require_once 'includes/xajax/xajax.inc.php'; //archivo de configuracion de ajax
include "../includes/php/conf_smarty.php";//archivo de configuracion de smarty
include "../includes/php/conf_bd.php"; //archivo de coneccion al servidor y base de datos
//include "../includes/php/conf_bd_antigua.php"; //archivo de coneccion al servidor de yonley
include "../includes/php/validaciones.php"; 

$xajax = new xajax();

$xajax->setRequestURI("sg_nylor_informe_precargas_2_aprobado.php");
$xajax->setCharEncoding("ISO-8859-1");
$xajax->decodeUTF8InputOn();

function Grabar($data){
    global $conexion;
    $objResponse = new xajaxResponse('ISO-8859-1');
    mysql_select_db('sgyonley', $conexion);
    
	$estado = $data['OBLIpedido'];
	$observacion = $data['observacion'];
	$fecha  = $data['OBLItxtFecha'];
	$folio  = $data['txtFolio'];
	$codigo  = $data['txtCodigo'];

	list($d,$m,$a) = explode('/',$fecha);
	$fecha = $a.'-'.$m.'-'.$d;
		$sql = "insert into sgyonley.cargas_aprobadas(`folio`, `codigo`, `estado`, `observacion`, `fecha_aprobacion`, `fecha_dig`, `usuario`) values ('".$folio."', '".$codigo."', '".$estado."', '".$observacion."', '".$fecha."', '".date("Y-m-d H:i:s")."', '".$_SESSION["alycar_sgyonley_usuario"]."')";
		$res = mysql_query($sql,$conexion) or die(mysql_error());
		$objResponse->addAlert("Registro guardado correctamente");
		$objResponse->addScript("window.parent.xajax_CargaListado(window.parent.xajax.getFormValues('Form1'))");
   	    	$objResponse->addScript("window.parent.hidePopWin(true)");	
	
    return $objResponse->getXML();
}

$xajax->registerFunction("Grabar");

$xajax->processRequests();
$miSmarty->assign('folio', $_GET['folio']);
$miSmarty->assign('codigo', $_GET['codigo']);
$miSmarty->assign('xajax_js', $xajax->getJavascript());

$miSmarty->display('sg_nylor_informe_precargas_2_aprobado.tpl');

?>

