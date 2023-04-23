<?php
session_start();

require_once 'includes/xajax/xajax.inc.php'; //archivo de configuracion de ajax
include "../includes/php/conf_smarty.php";//archivo de configuracion de smarty
include "../includes/php/conf_bd.php"; //archivo de coneccion al servidor y base de datos
//include "../includes/php/conf_bd_antigua.php"; //archivo de coneccion al servidor de yonley
include "../includes/php/validaciones.php"; 

$xajax = new xajax();

$xajax->setRequestURI("sg_nylor_informe_precargas_2_historial.php");
$xajax->setCharEncoding("ISO-8859-1");
$xajax->decodeUTF8InputOn();

function CargarPagina($data){
    global $conexion;
    global $miSmarty;
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	$folio  = $data['txtFolio'];
	$codigo  = $data['txtCodigo'];
	$arrRegistros = array();
	
	$sql_1 = "select *
		from sgyonley.ventas_antigua
		where vent_num_folio = '".$folio."' ";
	$res_1 = mysql_query($sql_1,$conexion) or die(mysql_error());
	while($row_1 = mysql_fetch_array($res_1)){
		$sql_prod = "select concat(TA_NCORR,' ',TA_BUSQUEDA,' ',TA_DESCRIPCION) as nombre
				from sgbodega.tallasnew
				where ta_ncorr = '". $codigo."'";
		$res_prod = mysql_query($sql_prod,$conexion) or die(mysql_error());
		$row_prod = mysql_fetch_array($res_prod);
		$nombre_prod = $row_prod['nombre'];

		array_push($arrRegistros, array(	"folio" => $row_1['vent_num_folio'],
						"codigo" => $nombre_prod ,
						"transaccion" => "Ingreso venta al sistema",
						"fecha_estado" => $row_1['vent_fecha'],
						"fecha_dig" => $row_1['vent_fecha_digitacion'],
						"usuario" => $row_1['usua_login']));
		}

	$sql_1 = "select *
		from sgyonley.cargas_autorizadas
		where caut_folio = '".$folio."' and
			vdet_ncorr  in ( select distinct vdet_ncorr 
							from sgyonley.ventas_detalle_antigua
								where vent_ncorr =  '".$folio."' and 
								arti_codigo = '".$codigo."')";
	$res_1 = mysql_query($sql_1,$conexion) or die(mysql_error());
	while($row_1 = mysql_fetch_array($res_1)){
		$sql_prod = "select concat(TA_NCORR,' ',TA_BUSQUEDA,' ',TA_DESCRIPCION) as nombre
				from sgbodega.tallasnew
				where ta_ncorr = '".$codigo."'";
		$res_prod = mysql_query($sql_prod,$conexion) or die(mysql_error());
		$row_prod = mysql_fetch_array($res_prod);
		$nombre_prod = $row_prod['nombre'];

		array_push($arrRegistros, array(	"folio" => $row_1['caut_folio'],
						"codigo" => $nombre_prod,
						"transaccion" => "Preaprobada autorizada",
						"fecha_estado" => $row_1['caut_fecha_dig'],
						"fecha_dig" => $row_1['caut_fecha_dig'],
						"usuario" => $row_1['caut_usuario']));
		}

	$sql_1 = "select *
		from sgyonley.cargas_pedidas
		where folio = '".$folio."' and
			codigo = '".$codigo."'";
	$res_1 = mysql_query($sql_1,$conexion) or die(mysql_error());
	while($row_1 = mysql_fetch_array($res_1)){
		$sql_prod = "select concat(TA_NCORR,' ',TA_BUSQUEDA,' ',TA_DESCRIPCION) as nombre
				from sgbodega.tallasnew
				where ta_ncorr = '".$row_1['codigo']."'";
		$res_prod = mysql_query($sql_prod,$conexion) or die(mysql_error());
		$row_prod = mysql_fetch_array($res_prod);
		$nombre_prod = $row_prod['nombre'];

		array_push($arrRegistros, array(	"folio" => $row_1['folio'],
						"codigo" => $nombre_prod,
						"transaccion" => "Pedido al Proveedor",
						"fecha_estado" => $row_1['fecha_pedida'],
						"fecha_dig" => $row_1['fecha_dig'],
						"usuario" => $row_1['usuario']));
		}

	$sql_2 = "select *
		from sgyonley.cargas_despachadas
		where folio = '".$folio."' and
			codigo = '".$codigo."'";
	$res_2 = mysql_query($sql_2,$conexion) or die(mysql_error());
	while($row_2 = mysql_fetch_array($res_2)){
		$sql_prod = "select concat(TA_NCORR,' ',TA_BUSQUEDA,' ',TA_DESCRIPCION) as nombre
				from sgbodega.tallasnew
				where ta_ncorr = '".$row_2['codigo']."'";
		$res_prod = mysql_query($sql_prod,$conexion) or die(mysql_error());
		$row_prod = mysql_fetch_array($res_prod);
		$nombre_prod = $row_prod['nombre'];

		array_push($arrRegistros, array(	"folio" => $row_2['folio'],
						"codigo" => $nombre_prod,
						"transaccion" => "Despachado al vendedor | Guia Interna ".$row_2['guia_interna'],
						"fecha_estado" => $row_2['fecha_despacho'],
						"fecha_dig" => $row_2['fecha_dig'],
						"usuario" => $row_2['usuario']));
		}

	$sql_3 = "select *
		from sgyonley.cargas_aprobadas
		where folio = '".$folio."' and
			codigo = '".$codigo."'";
	$res_3 = mysql_query($sql_3,$conexion) or die(mysql_error());
	while($row_3 = mysql_fetch_array($res_3)){
		$sql_prod = "select concat(TA_NCORR,' ',TA_BUSQUEDA,' ',TA_DESCRIPCION) as nombre
				from sgbodega.tallasnew
				where ta_ncorr = '".$row_3['codigo']."'";
		$res_prod = mysql_query($sql_prod,$conexion) or die(mysql_error());
		$row_prod = mysql_fetch_array($res_prod);
		$nombre_prod = $row_prod['nombre'];

		array_push($arrRegistros, array(	"folio" => $row_3['folio'],
						"codigo" => $nombre_prod,
						"transaccion" => "Operacion : ".$row_3['estado']." | Observacion : ".$row_3['observacion'],
						"fecha_estado" => $row_3['fecha_aprobacion'],
						"fecha_dig" => $row_3['fecha_dig'],
						"usuario" => $row_3['usuario']));
		}
	$arrRegistros = ordenar_matriz_multidimensionada($arrRegistros,'fecha_dig','ASC');
	$miSmarty->assign('arrRegistros', $arrRegistros);
	$objResponse->addAssign("divabonos", "innerHTML", $miSmarty->fetch('sg_nylor_informe_precargas_2_historial_list.tpl'));
    return $objResponse->getXML();
}

$xajax->registerFunction("CargarPagina");
$xajax->processRequests();
$miSmarty->assign('folio', $_GET['folio']);
$miSmarty->assign('codigo', $_GET['codigo']);
$miSmarty->assign('xajax_js', $xajax->getJavascript());

$miSmarty->display('sg_nylor_informe_precargas_2_historial.tpl');

?>

