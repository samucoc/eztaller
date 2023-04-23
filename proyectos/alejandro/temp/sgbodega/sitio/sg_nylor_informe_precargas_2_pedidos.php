<?php
session_start();

require_once 'includes/xajax/xajax.inc.php'; //archivo de configuracion de ajax
include "../includes/php/conf_smarty.php";//archivo de configuracion de smarty
include "../includes/php/conf_bd.php"; //archivo de coneccion al servidor y base de datos
//include "../includes/php/conf_bd_antigua.php"; //archivo de coneccion al servidor de yonley
include "../includes/php/validaciones.php"; 

$xajax = new xajax();

$xajax->setRequestURI("sg_nylor_informe_precargas_2_pedidos.php");
$xajax->setCharEncoding("ISO-8859-1");
$xajax->decodeUTF8InputOn();

function Grabar($data){
    global $conexion;
    $objResponse = new xajaxResponse('ISO-8859-1');
    mysql_select_db('sgyonley', $conexion);
    
	$estado = $data['OBLIpedido'];
	$fecha  = $data['OBLItxtFecha'];
	$folio  = $data['txtFolio'];
	$codigo  = $data['txtCodigo'];

	list($d,$m,$a) = explode('/',$fecha);
	$fecha = $a.'-'.$m.'-'.$d;
		$sql_cp = "select fecha_aprobacion
					from cargas_aprobadas
					where folio = '".$folio."' and
						codigo = '".$codigo."' and
						estado = 'rechazado'
						order by fecha_aprobacion desc
							";
		$res_cp = mysql_query($sql_cp,$conexion) or die(mysql_error());
		$row_cp = mysql_fetch_array($res_cp);
		$fecha_pedido = $row_cp['fecha_aprobacion'];
		
		$sql_dif =	"SELECT DATEDIFF('".$fecha_pedido."','".$fecha."') as dias_dif";
		$res_dif = mysql_query($sql_dif,$conexion);
		$dias_dif = @mysql_result($res_dif,0,"dias_dif");
		
		if ($dias_diff >= 0 ){
			$sql = "insert into sgyonley.cargas_pedidas(`folio`, `codigo`, `estado`, `fecha_pedida`, `fecha_dig`, usuario) values ('".$folio."', '".$codigo."', '".$estado."', '".$fecha."', '".date("Y-m-d H:i:s")."', '".$_SESSION["alycar_sgyonley_usuario"]."')";
			$res = mysql_query($sql,$conexion) or die(mysql_error());
			$objResponse->addAlert("Registro guardado correctamente");
			$objResponse->addScript("window.parent.xajax_CargaListado(window.parent.xajax.getFormValues('Form1'))");
			$objResponse->addScript("window.parent.hidePopWin(true)");	
			}
		else{
			$objResponse->addAlert("Fecha de pedido anterior a fecha de rechazo");
			}
    return $objResponse->getXML();
}

$xajax->registerFunction("Grabar");

$xajax->processRequests();
$miSmarty->assign('folio', $_GET['folio']);
$miSmarty->assign('codigo', $_GET['codigo']);
$miSmarty->assign('xajax_js', $xajax->getJavascript());

$miSmarty->display('sg_nylor_informe_precargas_2_pedidos.tpl');

?>

