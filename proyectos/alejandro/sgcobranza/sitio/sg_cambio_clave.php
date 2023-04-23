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

$xajax->setRequestURI("sg_cambio_clave.php");
$xajax->setCharEncoding("UTF8");
$xajax->decodeUTF8InputOn();

function Grabar($data){
    global $conexion;
    $objResponse = new xajaxResponse('UTF8');
	
	$v_clave_actual		= 	$data["OBLI-txtClaveActual"];
	$v_clave_nueva1		= 	$data["OBLI-txtClaveNueva"];
	$v_clave_nueva2		= 	$data["OBLI-txtConfirmarClaveNueva"];
	$v_login			= 	$_SESSION["alycar_usuario"];
	
	$ingresa = 'SI';
	
	if ($ingresa == 'SI'){
		if ($v_clave_nueva1 != $v_clave_nueva2){
			$objResponse->addScript("alert('Confirmación de Clave Incorrecta')");
			$ingresa = 'NO';
		}
	}
	if ($ingresa == 'SI'){
		$sql = "select usu_pass from usuarios where usu_login = '".$v_login."' and usu_pass = '".$v_clave_actual."'";
		$res = mysql_query($sql, $conexion);
		if (mysql_num_rows($res) <= 0){
			$objResponse->addScript("alert('Clave Actual Incorrecta')");
			$ingresa = 'NO';
		}
	}
	
	if ($ingresa == 'SI'){
		$sql = "update usuarios set usu_pass = '".$v_clave_nueva1."' where usu_login = '".$v_login."'";
		$res = mysql_query($sql, $conexion);
		
		$objResponse->addScript("alert('Clave Cambiada Correctamente.')");
		
		//INICIALIZA EL FORMULARIO
		$objResponse->addScript("window.document.Form1.submit();");
	}
	
	
	return $objResponse->getXML();
}

function CargaPagina($data){
    global $conexion;
    $objResponse = new xajaxResponse('UTF8');
	
	$objResponse->addScript("document.getElementById('OBLI-txtClaveActual').focus();");
	
	return $objResponse->getXML();
} 
function Eliminar($data, $codigo){
    global $conexion;
    $objResponse = new xajaxResponse('UTF8');
	
	$v_tbl		= 	$data["txtTabla"];
	$v_campo1	= 	$data["txtCampo1"];
	$v_campo2	= 	$data["txtCampo2"];
	$v_desc		= 	$data["OBLI-txtDescripcion"];
	
	$sql = "delete from $v_tbl where $v_campo1 = '".$codigo."'";
	$res = mysql_query($sql, $conexion);
	
	$objResponse->addScript("xajax_CargaListado(xajax.getFormValues('Form1'))");
	
	$objResponse->addScript("window.parent.xajax_Refresca(xajax.getFormValues('Form1'))");

	return $objResponse->getXML();
}

$xajax->registerFunction("Grabar");
$xajax->registerFunction("CargaPagina");
$xajax->registerFunction("Eliminar");


$xajax->processRequests();
$miSmarty->assign('xajax_js', $xajax->getJavascript());

$miSmarty->assign('TIT', $_GET["tit"]);
$miSmarty->assign('TBL', $_GET["tbl"]);
$miSmarty->assign('CAMPO1', $_GET["campo1"]);
$miSmarty->assign('CAMPO2', $_GET["campo2"]);

$miSmarty->display('sg_cambio_clave.tpl');

?>

