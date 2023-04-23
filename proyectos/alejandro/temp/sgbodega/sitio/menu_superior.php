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

$xajax->setRequestURI("menu_superior.php");
$xajax->setCharEncoding("ISO-8859-1");
$xajax->decodeUTF8InputOn();

function Carga($data, $id, $titulo){
    global $conexion;
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	$objResponse->addScript("parent.frames['lateral'].location='menu_lateral.php?id_menu=$id&titulo=$titulo';");
	return $objResponse->getXML();
} 
//CARGA LOS MENUES
$arrRegistros = array();
$perfil = $_SESSION["alycar_perfil"];
$sql = "select * 
        from menues 
        where menu_ncorr in (select menu
							  from 	bodega_tienen_menu
							  	where bodega = '".$_SESSION['alycar_sgyonley_bodega']."'
									and usuario = '".$_SESSION["alycar_usuario"]."')
        order by menu_orden asc";
$res = mysql_query($sql, $conexion);
while ($line = mysql_fetch_assoc($res)) {
		array_push($arrRegistros, array("id" => $line['menu_ncorr'], "descripcion" => $line['menu_desc']));
}

$miSmarty->assign('arrRegistros', $arrRegistros);
$xajax->registerFunction("Carga");

$xajax->processRequests();
$miSmarty->assign('xajax_js', $xajax->getJavascript());

$miSmarty->assign('NOMBREUSUARIO', $_SESSION["alycar_nombreusuario"]);
$miSmarty->assign('BODEGA', $_SESSION["alycar_sgyonley_bodega_nombre"]);


$miSmarty->display('menu_superior.tpl');

?>

