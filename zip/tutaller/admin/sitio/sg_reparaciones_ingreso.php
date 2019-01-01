<?php
session_start();

require_once 'includes/xajax/xajax.inc.php'; //archivo de configuracion de ajax
include "../includes/php/conf_smarty.php";//archivo de configuracion de smarty
include "../includes/php/conf_bd.php"; //archivo de coneccion al servidor y base de datos
//include "../includes/php/conf_bd_antigua.php"; //archivo de coneccion al servidor de yonley
//include "../includes/php/sgbodega.php"; 
include "../includes/php/validaciones.php"; 

$xajax = new xajax();

$xajax->setRequestURI("sg_reparaciones_ingreso.php");
$xajax->setCharEncoding("ISO-8859-1");
$xajax->decodeUTF8InputOn();

function Grabar($data){
	global $conexion;
	
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	$trabajador = $data['OBLI-txtCodCobrador'];
	$patente = $data['cboPatente'];
	$mecanico = $data['rut_mecanico'];
	$fecha = $data['OBLI-txtFecha2'];
	$observa = $data['observa'];
	$documento = $data['OBLIdocumento'];
	$pago = $data['cboPago'];
	$cheque = $data['OBLInro_boleta'];
	$usuario = $_SESSION["alycar_usuario"];
	$fecha_dig = date("Y-m-d H:i:s");
	
	if ($pago==1){
		$pago="Efectivo";
		}
	elseif ($pago==2){
		$pago="Cheque";
		}

	list($dia1,$mes1,$anio1) = explode('/', $fecha_ingreso);	
	$fecha_ingreso	= $anio1."-".$mes1."-".$dia1;
	list($dia1,$mes1,$anio1) = explode('/', $fecha);	
	$fecha	= $anio1."-".$mes1."-".$dia1;
	    // bloqueo los ingresos posteriores a la fecha de cierre.
	$sql_cierre			= 	"select cier_fecha as ultimocierre 
								from cierres
								order by cier_fecha desc limit 1";
	$res_cierre			= 	mysql_query($sql_cierre, $conexion);
	$ult_cierre 			= 	@mysql_result($res_cierre,0,"ultimocierre");
	
	$sql_dif 			=	"SELECT DATEDIFF('".$fecha."','".$ult_cierre."') as dias_dif";
	$res_dif			=	mysql_query($sql_dif, $conexion);
	$dias_dif			=	@mysql_result($res_dif,0,"dias_dif");
	$ingresa 	= 	"SI";
	if ($dias_dif < 0){
			$ingresa 	= 	"NO";
			$objResponse->addScript("alert('Fecha antes del cierre.')");
			unset($_SESSION["alycar_sgyonley_aumento"]);
			$objResponse->addScript("window.document.Form1.submit();");
		}
		
	if ($ingresa == 'SI'){
	
	$sql_1 = "insert into reparaciones(trabajador,patente,mecanico,fecha,observaciones,documento,pago,cheque,usuario,fecha_dig)
				values('$trabajador','$patente','$mecanico','$fecha','$observa','$documento','$pago','$cheque','$usuario','$fecha_dig')";
	$res_1 = mysql_query($sql_1,$conexion) or die(mysql_error());
	$id = mysql_insert_id();
	$arr_repuesto 		= explode(',',$data['arr_repuesto']);
	$arr_pu 			= explode(',',$data['arr_pu']);
	$arr_cant 			= explode(',',$data['arr_cant']);
	$arr_vt 			= explode(',',$data['arr_vt']);
	$id = mysql_insert_id();
	for($i=0; $i< count($arr_repuesto); $i++){
		
		$sql_2 = "insert into detalle_reparacion(repuesto, precio_unitario, cantidad, repara_ncorr) 
					values ('".$arr_repuesto[$i]."','".str_replace(".", "", $arr_pu[$i])."','".$arr_cant[$i]."','".$id."')"	;
		$res_2 = mysql_query($sql_2,$conexion) or die(mysql_error());
		
		}
		
    $objResponse->addScript("alert('Registro Grabado Correctamente.Nro de Reparacion : $id')");
    $objResponse->addScript("document.location.href='sg_reparaciones_ingreso.php';");
	}
	return $objResponse->getXML();
}

function LlamaMantenedorVxC($data){
	global $conexion;
	
    $objResponse = new xajaxResponse('ISO-8859-1');
	
    $carga_veh		=	$data["cboPatente"];
	$carga_nom_pers		=	$data["cboPersona"];
	$carga_pers		=	$data["OBLI-txtCodCobrador"];
	$carga_fecha		=	$data["OBLI-txtFecha1"];
	
	$_SESSION["alycar_volver"]	=	'si';
	$_SESSION["alycar_pagina_volver"]	=	'sg_reparaciones_ingreso.php';
	
        $objResponse->addScript("document.location.href='sg_vehiculo_asociar_pv.php?carga_veh=".$carga_veh."&carga_nom_pers=".$carga_nom_pers."&carga_pers=".$carga_pers."&carga_fecha=".$carga_fecha."'");
	
	return $objResponse->getXML();
}


$xajax->registerFunction("Grabar");
$xajax->registerFunction("LlamaMantenedorVxC");

$xajax->processRequests();
$miSmarty->assign('xajax_js', $xajax->getJavascript());

//echo "aa";
$miSmarty->display('sg_reparaciones_ingreso.tpl');
?>

