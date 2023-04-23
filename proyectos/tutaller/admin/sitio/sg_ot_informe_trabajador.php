<?php
session_start();

require_once 'includes/xajax/xajax.inc.php'; //archivo de configuracion de ajax
include "../includes/php/conf_smarty.php";//archivo de configuracion de smarty
include "../includes/php/conf_bd.php"; //archivo de coneccion al servidor y base de datos
//include "../includes/php/conf_bd_antigua.php"; //archivo de coneccion al servidor de yonley
//include "../includes/php/sgbodega.php"; 
include "../includes/php/validaciones.php"; 

$xajax = new xajax();

$xajax->setRequestURI("sg_ot_informe_trabajador.php");
$xajax->setCharEncoding("ISO-8859-1");
$xajax->decodeUTF8InputOn();

function CargaPagina($data){
	global $conexion;
	
    $objResponse = new xajaxResponse('ISO-8859-1');
	


	return $objResponse->getXML();

	}

function VerDetalle($data,$ncorr){
	global $conexion;
	
    $objResponse = new xajaxResponse('ISO-8859-1');
	
    $objResponse->addScript("showPopWin('sg_ot_imprimir.php?ncorr=".$ncorr."', 'Ver Detalle', 800, 600, null);");

	return $objResponse->getXML();

	}
function Grabar($data){
	global $conexion;
	global $miSmarty;
	$arrRegistros = array();
	$arrRegistros_MO = array();
	$arrRegistros_REP = array();

    $objResponse = new xajaxResponse('ISO-8859-1');
	
   	$rut_trabajador = $data['rut_trabajador'];

    $sql_ot = "select ot_ncorr, folio, date_format(fecha,'%d/%m/%Y') as fecha, mecanico, patente, rut_trabajador
    				from gescolcl_taller.orden_trabajo 
    				where rut_trabajador = '".$rut_trabajador."' ";
    $res_ot = mysql_query($sql_ot,$conexion) or die(mysql_error());
    while ($row_ot = mysql_fetch_array($res_ot)){
    	$ot_ncorr 		= $row_ot['ot_ncorr'];
    	$folio 			= $row_ot['folio'];
    	$fecha 			= $row_ot['fecha'];
    	$patente 		= $row_ot['patente'];
    	$mecanico 		= $row_ot['mecanico'];
    	$rut_trabajador = $row_ot['rut_trabajador'];

    	$sql = "SELECT nombre
        		FROM `mecanicos` 
        		WHERE rut = '".$mecanico."' ";
		$res = mysql_query($sql, $conexion);
		$row = mysql_fetch_array($res);

		$nombre_mecanico = $row['nombre'];

		$sql = "SELECT * 
		        FROM `personas` 
		        WHERE (`pers_rut` like '".$rut_trabajador."'  )";
		$res = mysql_query($sql, $conexion);
		$row = mysql_fetch_assoc($res) ; 
		$id_proveedor = utf8_encode($row['pers_ape_pat']);
		$name_proveedor = utf8_encode($row['pers_ape_mat']);
		$nombre_proveedor = utf8_encode($row['pers_nombre']);

		$nombre_trabajador = $nombre_proveedor.' '.$id_proveedor.' '.$name_proveedor;
    
		$sql_genera_mo  = "select sum(total) as total_mo, sum(cantidad*iva) as iva, sum(precio_neto*cantidad) as precio_neto
						from gescolcl_taller.ot_detalle_mo
    					where ot_ncorr = '".$ot_ncorr."' ";
	    $res_genera_mo	= mysql_query($sql_genera_mo,$conexion) or die(mysql_error());
	    $row_genera_mo = mysql_fetch_array($res_genera_mo);
	    $total_mo = $row_genera_mo['total_mo'];

		
		$sql_genera_mo  = "select sum(total) as total_rep, sum(cantidad*iva) as iva, sum(precio_neto_unitario*cantidad) as precio_neto
							from gescolcl_taller.ot_detalle_repuestos
	    					where mod_ncorr = '".$ot_ncorr."'  ";
	    $res_genera_mo	= mysql_query($sql_genera_mo,$conexion) or die(mysql_error());
	    $row_genera_mo = mysql_fetch_array($res_genera_mo);
	    $total_rep = $row_genera_mo['total_rep'];

		array_push($arrRegistros, array("ot_ncorr" 			=> 	$ot_ncorr,
										"folio" 			=> 	$folio,
										"fecha" 			=> 	$fecha,
										"mecanico" 			=> 	$nombre_mecanico,
										"patente" 			=> 	$patente,
										"rut_trabajador" 	=> 	$nombre_trabajador,
										"total_mo" 			=> 	$total_mo,
										"total_rep" 		=> 	$total_rep));
		}
		
	 	$miSmarty->assign('arrRegistros', $arrRegistros);
		$_SESSION["alycar_matriz"] = $arrRegistros;
		$miSmarty->assign('arrRegistros_MO', $arrRegistros_MO);
		$miSmarty->assign('arrRegistros_REP', $arrRegistros_REP);
		$objResponse->addAssign("divabonos", "innerHTML", $miSmarty->fetch('sg_ot_informe_fecha_list.tpl'));


	return $objResponse->getXML();

	}	

function Ordenar($data, $campo){
	global $conexion;
	global $miSmarty;
	
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	$orden_asc 	= 'ASC';
	$orden_desc = 'DESC';
	if ($_SESSION["alycar_orden"] == $campo.$orden_asc){
		$campo_orden 		= 	$campo.$orden_desc;
		$direccion_orden	=	$orden_desc;
	}else{
		$campo_orden 		= 	$campo.$orden_asc;
		$direccion_orden	=	$orden_asc;
	}		
	
	$arrRegistros = array();
	$arrRegistros = ordenar_matriz_multidimensionada($_SESSION["alycar_matriz"],$campo,$direccion_orden);
	$_SESSION["alycar_orden"] = $campo_orden;
	
	$_SESSION["alycar_matriz"] = $arrRegistros;
	
	$miSmarty->assign('arrRegistros', $arrRegistros);
	$objResponse->addAssign("divabonos", "innerHTML", $miSmarty->fetch('sg_ot_informe_fecha_list.tpl'));
	
	return $objResponse->getXML();
}


$xajax->registerFunction("CargaPagina");
$xajax->registerFunction("Grabar");
$xajax->registerFunction("VerDetalle");
$xajax->registerFunction("Ordenar");

$xajax->processRequests();
$miSmarty->assign('xajax_js', $xajax->getJavascript());


$miSmarty->display('sg_ot_informe_trabajador.tpl');
?>

