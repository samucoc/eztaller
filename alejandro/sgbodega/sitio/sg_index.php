<?php
session_start();
/*
if (!isset($_SESSION['alycar_sistemas'])){
	?>
	<script>top.location.href='http://10.42.42.50/sgsistemas/sitio/sg_index.php'</script>
	<?php
}
*/

require_once 'includes/xajax/xajax.inc.php'; //archivo de configuracion de ajax
include "../includes/php/conf_smarty.php";//archivo de configuracion de smarty
include "../includes/php/conf_bd.php"; //archivo de coneccion al servidor y base de datos

$xajax = new xajax();

$xajax->setRequestURI("sg_index.php");
$xajax->setCharEncoding("UTF8");
$xajax->decodeUTF8InputOn();

function Grabar($data){
    global $conexion;
    $objResponse = new xajaxResponse('UTF8');
	
	//$v_ean = $data["OBLI-txtEan"];
	
	$objResponse->addScript("document.location.href='sg_seleccion_empresa.php'");
			
	return $objResponse->getXML();
}

$xajax->registerFunction("Grabar");

$xajax->processRequests();
$miSmarty->assign('xajax_js', $xajax->getJavascript());

$miSmarty->display('sg_index.tpl');

?>

