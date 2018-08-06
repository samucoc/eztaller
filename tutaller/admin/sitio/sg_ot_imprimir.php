<?php
session_start();

require_once 'includes/xajax/xajax.inc.php'; //archivo de configuracion de ajax
include "../includes/php/conf_smarty.php";//archivo de configuracion de smarty
include "../includes/php/conf_bd.php"; //archivo de coneccion al servidor y base de datos
//include "../includes/php/conf_bd_antigua.php"; //archivo de coneccion al servidor de yonley
//include "../includes/php/sgbodega.php"; 
include "../includes/php/validaciones.php"; 

$xajax = new xajax();

$xajax->setRequestURI("sg_ot_imprimir.php");
$xajax->setCharEncoding("ISO-8859-1");
$xajax->decodeUTF8InputOn();

function CargaPagina($data){
	global $conexion;
	
    $objResponse = new xajaxResponse('ISO-8859-1');
	
    $objResponse->addScript("xajax_Grabar(xajax.getFormValues('Form1'));");

	return $objResponse->getXML();

	}

function Grabar($data){
	global $conexion;
	global $miSmarty;
	$arrRegistros_MO = array();
	$arrRegistros_REP = array();

    $objResponse = new xajaxResponse('ISO-8859-1');
	
   	$ot_ncorr = $data['ot_ncorr'];
	$folio = $data['folio'];

	$sql_ot = "";
	if ($folio!=''){
		$sql_ot = "select ot_ncorr, folio, date_format(fecha,'%d/%m/%Y') as fecha, mecanico, patente, rut_trabajador
    				from gescolcl_taller.orden_trabajo 
    				where folio = '".$folio."'";
   		}
	else{ 
    	$sql_ot = "select ot_ncorr, folio, date_format(fecha,'%d/%m/%Y') as fecha, mecanico, patente, rut_trabajador
    				from gescolcl_taller.orden_trabajo 
    				where ot_ncorr = '".$ot_ncorr."'";
   		}
   	$res_ot = mysql_query($sql_ot,$conexion) or die(mysql_error());
    while ($row_ot = mysql_fetch_array($res_ot)){

    	$objResponse->addScript("document.getElementById('volver').style.display='block'");

    	$ot_ncorr 			= $row_ot['ot_ncorr'];
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
    
    	$miSmarty->assign('ot_ncorr',$ot_ncorr);
    	$miSmarty->assign('folio',$folio);
    	$miSmarty->assign('fecha',$fecha);
    	$miSmarty->assign('patente',$patente);
    	$miSmarty->assign('nombre_mecanico',$nombre_mecanico);
    	$miSmarty->assign('nombre_trabajador',$nombre_trabajador);


		$sql_mo ="select mod_ncorr, ot_ncorr, `detalle`, `cantidad`, `precio_neto`, `iva`, `total_unitario`, `total`, `pagado` 
					FROM `ot_detalle_mo` 
					WHERE ot_ncorr = '".$ot_ncorr."'";
		$res_mo = mysql_query($sql_mo,$conexion) or die(mysql_error());
		while($row_mo = mysql_fetch_row($res_mo)){
			$sql = "SELECT * 
			        FROM gescolcl_taller.tipo_mo
			        WHERE `tmo_ncorr` = '".$row_mo[2]."' ";
			$res = mysql_query($sql, $conexion);
			$row = mysql_fetch_assoc($res);
			$nombre_mo = $row['nombre'];

			array_push($arrRegistros_MO, array("mod_ncorr" 		=> 	$row_mo[0],
										"ot_ncorr" 			=> 	$row_mo[1],
										"detalle" 			=> 	$nombre_mo,
										"cantidad" 			=> 	$row_mo[3],
										"precio_neto" 		=> 	$row_mo[4],
										"iva" 				=> 	$row_mo[5],
										"total_unitario" 	=> 	$row_mo[6],
										"total" 			=> 	$row_mo[7],
										"pagado" 			=> 	$row_mo[8]));
			}
		
		$sql_genera_mo  = "select * from gescolcl_taller.ot_detalle_repuestos
    					where mod_ncorr = '".$ot_ncorr."' ";
		$res_genera_mo	= mysql_query($sql_genera_mo,$conexion) or die(mysql_error());
		    while ($row_genera_mo = mysql_fetch_row($res_genera_mo)){

				$sql = "SELECT * 
				        FROM `repuestos` 
				        	inner join tipo_repuestos
				        		on tipo_repuestos.tipo_repuesto = repuestos.repu_ncorr
				        WHERE trep_ncorr = '".$row_genera_mo[2]."' 
						limit 0,10";
				$res = mysql_query($sql, $conexion);
				$i=0;        
				$row = mysql_fetch_assoc($res);
				$nombre_repuesto = utf8_encode($row['nombre'].' - '.$row['especificaciones']);


		    	array_push($arrRegistros_REP, array("otr_ncorr" 			=> 	$row_genera_mo[0],
												"mod_ncorr" 			=> 	$row_genera_mo[1],
												"cod_repuesto" 			=> 	$nombre_repuesto,
												"cantidad" 				=> 	$row_genera_mo[3],
												"precio_neto_unitario" 	=> 	$row_genera_mo[4],
												"iva" 					=> 	$row_genera_mo[5],
												"precio_unitario" 		=> 	$row_genera_mo[6],
												"total" 				=> 	$row_genera_mo[7]));

			}
		$miSmarty->assign('arrRegistros_MO', $arrRegistros_MO);
		$miSmarty->assign('arrRegistros_REP', $arrRegistros_REP);
		$objResponse->addAssign("divabonos", "innerHTML", $miSmarty->fetch('sg_ot_imprimir_list.tpl'));


	$sql_genera_mo  = "select sum(total) as total_mo, sum(cantidad*iva) as iva, sum(precio_neto*cantidad) as precio_neto
						from gescolcl_taller.ot_detalle_mo
    					where ot_ncorr = '".$ot_ncorr."' ";
    $res_genera_mo	= mysql_query($sql_genera_mo,$conexion) or die(mysql_error());
    $row_genera_mo = mysql_fetch_array($res_genera_mo);
    $total_mo = $row_genera_mo['total_mo'];
	$neto_mo = $row_genera_mo['precio_neto'];
	$iva_mo = $row_genera_mo['iva'];

    $objResponse->addScript("document.getElementById('total_mo_final').innerHTML='".number_format ( $row_genera_mo['total_mo'],0 , "." , "," )."'");
    $objResponse->addScript("document.getElementById('neto_mo_final').innerHTML='".number_format ( ($neto_mo),0 , "." , "," )."'");
    $objResponse->addScript("document.getElementById('iva_mo_final').innerHTML='".number_format ( ($iva_mo),0 , "." , "," )."'");
	
	$sql_genera_mo  = "select sum(total) as total_rep, sum(cantidad*iva) as iva, sum(precio_neto_unitario*cantidad) as precio_neto
						from gescolcl_taller.ot_detalle_repuestos
    					where mod_ncorr = '".$ot_ncorr."'  ";
    $res_genera_mo	= mysql_query($sql_genera_mo,$conexion) or die(mysql_error());
    $row_genera_mo = mysql_fetch_array($res_genera_mo);
    $total_rep = $row_genera_mo['total_rep'];
	$neto_rep = $row_genera_mo['precio_neto'];
	$iva_rep = $row_genera_mo['iva'];

    $objResponse->addScript("document.getElementById('total_rep_final').innerHTML='".number_format ( ($total_rep),0 , "." , "," )."'");
    $objResponse->addScript("document.getElementById('neto_rep_final').innerHTML='".number_format ( ($neto_rep),0 , "." , "," )."'");
    $objResponse->addScript("document.getElementById('iva_rep_final').innerHTML='".number_format ( ($iva_rep),0 , "." , "," )."'");
	
    $total = $total_mo + $total_rep;
    $neto = $neto_rep + $neto_mo;
	$iva = $iva_mo + $iva_rep;
    $objResponse->addScript("document.getElementById('total_final').innerHTML='".number_format ( ($total),0 , "." , "," )."'");
    $objResponse->addScript("document.getElementById('neto_final').innerHTML='".number_format ( ($neto),0 , "." , "," )."'");
    $objResponse->addScript("document.getElementById('iva_final').innerHTML='".number_format ( ($iva),0 , "." , "," )."'");
   

	   	}

	return $objResponse->getXML();

}


$xajax->registerFunction("CargaPagina");
$xajax->registerFunction("Grabar");

$xajax->processRequests();
$miSmarty->assign('xajax_js', $xajax->getJavascript());
$miSmarty->assign('ot_ncorr', $_GET['ncorr']);


$miSmarty->display('sg_ot_imprimir.tpl');
?>

