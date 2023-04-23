<?php
session_start();
if (!isset($_SESSION['alycar_usuario'])){
	?>
	<script>top.location.href='index.php'</script>
	<?php
}
require_once 'includes/xajax/xajax.inc.php'; //archivo de configuracion de ajax
include "../includes/php/conf_smarty.php";//archivo de configuracion de smarty
include "../includes/php/conf_bd.php"; //archivo de coneccion al servidor y base de datos

$xajax = new xajax();

$xajax->setRequestURI("busqueda.php");
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
	$sucursal		=	$_SESSION['alycar_cod_sucursal'];
	
	$objResponse->addAssign("divresultado", "innerHTML", "");
	
	if (($v_entidad == 2) OR ($v_entidad == '2')){ // busqueda de vehiculo
		$v_and = " and teso_ncorr = 1 and tesc_ncorr = 1 and sucu_ncorr = '".$sucursal."'"; // estado operativo (2 = DISPONIBLE)
	}
	if (($v_entidad == 20) OR ($v_entidad == '20')){ // busqueda de vehiculo
		$v_and = " and teso_ncorr != '' and tesc_ncorr != ''"; // estado operativo cualquiera
	}
	if (($v_entidad == 21) OR ($v_entidad == '21')){ // busqueda de vehiculo
		$v_and = " and teso_ncorr = 3 OR teso_ncorr = 4 and tesc_ncorr = 1"; // estado operativo (3 = CONSUMO INTERNO, 4 = MANTENIMIENTO)
	}
	
	if ($v_buscar_por == '01'){
		$sql = "select distinct($campo1), $campo2 from $tabla where $campo2 like '%".$v_texto."%'$v_and";
	}
	if ($v_buscar_por == '02'){
		$sql = "select distinct($campo1), $campo2 from $tabla where $campo1 like '%".$v_texto."%'$v_and";
	}
	
	$res = mysql_query($sql, $conexion);
	$arrRegistros = array();
	while ($line = mysql_fetch_array($res)) {
		array_push($arrRegistros, array("codigo" => $line[0], "descripcion" => $line[1]));
	}
	
	$miSmarty->assign('arrRegistros', $arrRegistros);
	$objResponse->addAssign("divresultado", "innerHTML", $miSmarty->fetch('busqueda_list.tpl'));
	
	return $objResponse->getXML();
}
function TraeValor($data, $campo1, $campo2) {
	$objResponse = new xajaxResponse('ISO-8859-1');
    
	$obj1 	= 	$data["txtObj1"];
	$obj2 	= 	$data["txtObj2"];
	
	if (($obj1 != '') OR ($obj2 != '')){
		$objResponse->addScript("window.parent.xajax_MuestraRegistro(xajax.getFormValues('Form1'), '$campo1', '$campo2', '$obj1', '$obj2')");
	}else{
		$objResponse->addScript("window.parent.xajax_MuestraRegistro(xajax.getFormValues('Form1'), '$campo1', '$campo2')");
	}
	$objResponse->addScript("window.parent.hidePopWin(true)");
	
	return $objResponse->getXML();
}
function CargaPagina($data){
    global $conexion;
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	$objResponse->addScript("document.getElementById('cboBuscarPor').focus();");
	
	return $objResponse->getXML();
}     
    
$xajax->registerFunction("Buscar");
$xajax->registerFunction("TraeValor");
$xajax->registerFunction("CargaPagina");

$xajax->processRequests();
$miSmarty->assign('xajax_js', $xajax->getJavascript());

$miSmarty->assign('ENTIDAD', $_GET["entidad"]);
$miSmarty->assign('OBJ1', $_GET["obj1"]);
$miSmarty->assign('OBJ2', $_GET["obj2"]);

$miSmarty->display('busqueda.tpl');

?>

