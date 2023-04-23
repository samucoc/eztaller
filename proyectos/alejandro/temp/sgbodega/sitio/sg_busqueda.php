<?php
session_set_cookie_params('18000'); // 5 HORAS
session_start();

require_once 'includes/xajax/xajax.inc.php'; //archivo de configuracion de ajax
include "../includes/php/conf_smarty.php";//archivo de configuracion de smarty
include "../includes/php/conf_bd.php"; //archivo de coneccion al servidor y base de datos

$xajax = new xajax();

$xajax->setRequestURI("sg_busqueda.php");
$xajax->setCharEncoding("ISO-8859-1");
$xajax->decodeUTF8InputOn();

function Buscar($data, $tabla, $campo1, $campo2){
    global $conexion;
	global $miSmarty;
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	$v_buscar_por 	= 	$data["cboBuscarPor"];
	$v_texto 		= 	$data["txtTexto"];
	$v_entidad 		= 	$data["txtEntidad"];
	$v_and 			= 	'';
	$sect_ncorr		=	$_SESSION["alycar_sgyonley_sector"];
	$empresa 		= 	$_SESSION["alycar_sgyonley_empresa"];
	$ta_empresa 	= 	$_SESSION["alycar_sgyonley_empresa_rut"];
	
	$objResponse->addAssign("divresultado", "innerHTML", "");
	
	// busqueda en la bodega central
	
	if ($v_entidad == 1){
		$v_and 		= 	" and empe_ncorr = '".$empresa."'";
	}
	if ($v_entidad == 4){
		$v_and 		= 	" and ta_empresa = '".$ta_empresa."'";
	}
	if ($v_entidad == 22){
		$v_and 		= 	" and ve_empresa = '".$ta_empresa."'";
	}
	if ($v_entidad == 'articulo'){
		$v_and 		= 	" and ta_empresa = '".$ta_empresa."'";
	}
	if ($v_entidad == 5){
		$v_and 		= 	" and sp_empresa = '".$ta_empresa."'";
	}
	if (($tabla == 'cobrador') OR ($tabla == 'sgyonley.cobrador')){
		$v_and 		= 	" and co_empresa = '".$ta_empresa."'";
	}
	if (($tabla == 'supervisor') OR ($tabla == 'sgyonley.supervisor')){
		$v_and 		= 	" and sp_empresa = '".$ta_empresa."'";
	}
	
	if ($v_buscar_por == '01'){
		$sql = "select $campo1, $campo2 from $tabla where $campo2 like '%".$v_texto."%'$v_and";
		if (($v_entidad == 4) OR ($v_entidad == 7) OR ($v_entidad == 'articulo')){
			$sql = "select ta_ncorr, concat(ta_busqueda, ' ', ta_descripcion) as descripcion from sgbodega.tallasnew where concat(ta_busqueda, '', ta_descripcion) like '%".$v_texto."%'";
		}
		
		/*
		if ($v_entidad == 8){
			$sql = "select b.ta_ncorr, a.bv_glosa, bv_valornuevo from 
					sgbodega.bodvendedor a,  sgbodega.tallasnew b where 
					a.bv_glosa like '%".$v_texto."%' and 
					a.bv_codbus = b.ta_codigo group by b.ta_ncorr";
		}
		*/
		
	}
	if ($v_buscar_por == '02'){
		$sql = "select $campo1, $campo2 from $tabla where $campo1 like '%".$v_texto."%'$v_and";
		
		if (($v_entidad == 4) OR ($v_entidad == 7) OR ($v_entidad == 'articulo')){
			$sql = "select ta_ncorr, concat(ta_busqueda, ' ', ta_descripcion) as descripcion from sgbodega.tallasnew where ta_ncorr like '%".$v_texto."%'";
		}
		
		/*
		if ($v_entidad == 8){
			$sql = "select b.ta_ncorr, a.bv_glosa, bv_valornuevo from 
					sgbodega.bodvendedor a,  sgbodega.tallasnew b where 
					b.ta_ncorr like '%".$v_texto."%' and 
					b.ta_codigo = a.bv_codbus group by b.ta_ncorr";
		}
		*/
		
	}
	
	//$objResponse->addAssign("divresultado", "innerHTML", $sql);
	
	$res = mysql_query($sql, $conexion);
	$arrRegistros = array();
	while ($line = mysql_fetch_array($res)) {
		$desc = str_replace('"', '', $line[1]);

		//$desc = utf8_decode($line[1]);
		
		array_push($arrRegistros, array("codigo" => $line[0], "descripcion" => $desc));
	}
	
	/*
	// busqueda para vendedores que nunca se han asignado
	if ($v_entidad == 8){
		if ($v_buscar_por == '01'){
			$sql_b = "select ta_ncorr, ta_busqueda,  ta_descripcion from sgbodega.tallasnew
					where ta_busqueda like '%".$v_texto."%'";
		}
		if ($v_buscar_por == '02'){
			$sql_b = "select ta_ncorr, ta_busqueda,  ta_descripcion from sgbodega.tallasnew
					where ta_ncorr like '%".$v_texto."%'";
		}
		$res_b = mysql_query($sql_b, $conexion);
		while ($line_b = mysql_fetch_array($res_b)) {
			array_push($arrRegistros, array("codigo" => $line_b[0], "descripcion" => $line_b[1]));
		}
	}		
	*/
	
	$miSmarty->assign('arrRegistros', $arrRegistros);
	$objResponse->addAssign("divresultado", "innerHTML", $miSmarty->fetch('sg_busqueda_list.tpl'));
	
	
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

$miSmarty->display('sg_busqueda.tpl');

?>

