<?php
session_start();
if (!isset($_SESSION['alycar_usuario'])){
	?>
	<script>top.location.href='sg_index.php'</script>
	<?php
}


require_once 'includes/xajax/xajax.inc.php'; //archivo de configuracion de ajax
include "../includes/php/conf_smarty.php";//archivo de configuracion de smarty
include "../includes/php/conf_bd.php"; //archivo de coneccion al servidor y base de datos

$xajax = new xajax();

$xajax->setRequestURI("menu_lateral.php");
$xajax->setCharEncoding("ISO-8859-1");
$xajax->decodeUTF8InputOn();

function CargaInicial($data){
    global $conexion;
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	$objResponse->addScript("parent.frames['principal'].location='portada.php';");
	return $objResponse->getXML();
} 

function Carga($data, $link){
    global $conexion;
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	$objResponse->addScript("parent.frames['principal'].location='$link';");
	return $objResponse->getXML();
} 

//CARGA LOS MENUES
$arrRegistros = array();

//menues normales
if ($_GET['id_menu'] != 7){
	$sql = "select * from menues_hijos where menu_ncorr = '".$_GET['id_menu']."' and mhij_mostrar = 'SI' order by mhij_orden";
	$res = mysql_query($sql, $conexion);
	while ($line = mysql_fetch_assoc($res)) {
			array_push($arrRegistros, array("descripcion" => $line['mhij_desc'], "link" => $line['mhij_link']));
	}
}else{
	$sql = "select docu_ncorr, docu_desc from documentos order by docu_ncorr";
	$res = mysql_query($sql, $conexion);
	while ($line = mysql_fetch_assoc($res)) {
			$ncorr = $line['docu_ncorr'];
			$enlace = "sg_busca_siniestro_finiquito.php?t=$ncorr";
			array_push($arrRegistros, array("descripcion" => $line['docu_desc'], "link" => $enlace));
	}
}

$miSmarty->assign('arrRegistros', $arrRegistros);
$miSmarty->assign('TITULO_MENU', $_GET['titulo']);
	
//$xajax->registerFunction("Carga");
$xajax->registerFunction("Carga");
$xajax->registerFunction("CargaInicial");


$xajax->processRequests();
$miSmarty->assign('xajax_js', $xajax->getJavascript());


$miSmarty->display('menu_lateral.tpl');

?>

