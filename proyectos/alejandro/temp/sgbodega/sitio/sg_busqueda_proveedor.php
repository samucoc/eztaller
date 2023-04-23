<?php
session_start();

require_once 'includes/xajax/xajax.inc.php'; //archivo de configuracion de ajax
include "../includes/php/conf_smarty.php";//archivo de configuracion de smarty
include "../includes/php/conf_bd.php"; //archivo de coneccion al servidor y base de datos

$xajax = new xajax();

$xajax->setRequestURI("sg_busqueda_proveedor.php");
$xajax->setCharEncoding("ISO-8859-1");
$xajax->decodeUTF8InputOn();

function Buscar($data, $tabla, $campo1, $campo2){
    global $conexion;
	global $miSmarty;
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	$v_buscar_por 	= 	$data["cboBuscarPor"];
	$v_texto 		= 	$data["txtTexto"];
	
	$objResponse->addAssign("divresultado", "innerHTML", "");
	
	if ($v_buscar_por == '01'){
		if (($v_entidad == 4) OR ($v_entidad == 7)){
			$sql = "select $campo1), $campo2 from $tabla where $campo2 like '%".$v_texto."%'";
		}else{
			$sql = "select $campo1, $campo2 from $tabla where $campo2 like '%".$v_texto."%'";
		}
	}
	if ($v_buscar_por == '02'){
		if (($v_entidad == 4) OR ($v_entidad == 7)){
			$sql = "select $campo1, $campo2 from $tabla where $campo1 like '%".$v_texto."%'";
		}else{
			$sql = "select $campo1, $campo2 from $tabla where $campo1 like '%".$v_texto."%'";
		}
	}
	
	$res = mysql_query($sql, $conexion);
	$arrRegistros = array();
	while ($line = mysql_fetch_array($res)) {
		array_push($arrRegistros, array("codigo" => $line[0], "descripcion" => $line[1]));
	}
	
	$miSmarty->assign('arrRegistros', $arrRegistros);
	$objResponse->addAssign("divresultado", "innerHTML", $miSmarty->fetch('sg_busqueda_proveedor_list.tpl'));
	
	return $objResponse->getXML();
}
function TraeValor($data, $campo1, $campo2) {
	$objResponse = new xajaxResponse('ISO-8859-1');
    
	$obj1 	= 	$data["txtObj1"];
	$obj2 	= 	$data["txtObj2"];
	
	$objResponse->addScript("window.parent.xajax_MuestraRegistro(xajax.getFormValues('Form1'), '$campo1', '$campo2', '$obj1', '$obj2')");
	$objResponse->addScript("window.parent.hidePopWin(true)");
	
	return $objResponse->getXML();
}
function Salir($data){
    global $conexion;
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	$obj1 	= 	$data["txtObj1"];
	$obj2 	= 	$data["txtObj2"];
	
	//$objResponse->addScript("alert('$obj1 $obj2')");
	
	$objResponse->addScript("window.parent.document.getElementById('$obj1').focus();");
	$objResponse->addScript("window.parent.hidePopWin(true)");	
	return $objResponse->getXML();
}  
function CargaPagina($data){
    global $conexion;
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	$objResponse->addScript("document.getElementById('txtTexto').focus();");
	
	return $objResponse->getXML();
}
      
$xajax->registerFunction("Buscar");
$xajax->registerFunction("TraeValor");
$xajax->registerFunction("Salir");
$xajax->registerFunction("CargaPagina");

$xajax->processRequests();
$miSmarty->assign('xajax_js', $xajax->getJavascript());

$miSmarty->assign('ENTIDAD', $_GET["entidad"]);
$miSmarty->assign('OBJ1', $_GET["obj1"]);
$miSmarty->assign('OBJ2', $_GET["obj2"]);

$miSmarty->display('sg_busqueda_proveedor.tpl');

?>

