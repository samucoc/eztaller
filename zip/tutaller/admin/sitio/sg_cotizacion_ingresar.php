<?php
session_start();

require_once 'includes/xajax/xajax.inc.php'; //archivo de configuracion de ajax
include "../includes/php/conf_smarty.php";//archivo de configuracion de smarty
include "../includes/php/conf_bd.php"; //archivo de coneccion al servidor y base de datos
//include "../includes/php/conf_bd_antigua.php"; //archivo de coneccion al servidor de yonley
//include "../includes/php/sgbodega.php"; 
include "../includes/php/validaciones.php"; 

$xajax = new xajax();

$xajax->setRequestURI("sg_cotizacion_ingresar.php");
$xajax->setCharEncoding("ISO-8859-1");
$xajax->decodeUTF8InputOn();

function CargaPagina($data){
	global $conexion;
	
    $objResponse = new xajaxResponse('ISO-8859-1');
	
    $sql_busca = "select max(codigoCotizacion)+1 as grupo_mod
    				from gescolcl_taller.cotizacion";
    $res_busca = mysql_query($sql_busca,$conexion) or die(mysql_error());
    $row_busca = mysql_fetch_array($res_busca);
	
	$_SESSION['grupo_mod'] = $row_busca['grupo_mod'];

	$sql_busca = "delete from gescolcl_taller.cotizacion_detalle_repuestos_temp";
  	$res_busca = mysql_query($sql_busca,$conexion) or die(mysql_error());
    
    $sql_busca = "delete from gescolcl_taller.cotizacion_detalle_mo_temp";
    $res_busca = mysql_query($sql_busca,$conexion) or die(mysql_error());

	return $objResponse->getXML();

}

function Grabar($data){
	global $conexion;
	
    $objResponse = new xajaxResponse('ISO-8859-1');
	
    $folio 			= $data['folio'];
	
	$fechaCotizacion		= $data['fecha_ot'];
	list($dia,$mes,$anio) 	= explode('/',$fechaCotizacion);
	$fechaCotizacion 		= $anio.'-'.$mes.'-'.$dia;

	$codigoEmpresa 		= $_SESSION["alycar_empresa_rut"];
	$codigoComprador 	= $data['rut_trabajador'];
	$usuario 			= $_SESSION["alycar_usuario"];
	$fecha_dig 			= date("Y-m-d H:i:s");

	$sql_insert = "INSERT INTO gescolcl_taller.cotizacion(`codigoEmpresa`, `codigoComprador`, `fechaCotizacion`, `usuario`, `fecha_dig`) 
		VALUES ('".$codigoEmpresa."','".$codigoComprador."','".$fechaCotizacion ."','".$usuario ."','".$fecha_dig ."')";
    $res_insert = mysql_query($sql_insert,$conexion) or die(mysql_error());
    $id = mysql_insert_id();

	$sql_busca = "select grupo_mod
					FROM gescolcl_taller.cotizacion_detalle_mo_temp
					WHERE grupo_mod = '". $_SESSION['grupo_mod']."'";
    $res_busca = mysql_query($sql_busca,$conexion) or die(mysql_error());
    $row_busca = mysql_fetch_array($res_busca);
		$mod_ncorr = $row_busca['grupo_mod'];

		$sql_insert = "INSERT INTO gescolcl_taller.cotizacion_detalle_mo(`ot_ncorr`, `detalle`, `cantidad`, `precio_neto`, `iva`, `total_unitario`, `total`, `pagado`) 
						select '".$id."', `detalle`, `cantidad`, `precio_neto`, `iva`, `total_unitario`, `total`, `pagado` 
						FROM gescolcl_taller.cotizacion_detalle_mo_temp WHERE grupo_mod = '".$mod_ncorr."'";
	    $res_insert = mysql_query($sql_insert,$conexion) or die(mysql_error());

	    //$mod_ncorr_act = mysql_insert_id();


	$sql_busca = "select grupo_mod
					FROM gescolcl_taller.cotizacion_detalle_repuestos_temp	 
					WHERE grupo_mod = '". $_SESSION['grupo_mod']."'";
    $res_busca = mysql_query($sql_busca,$conexion) or die(mysql_error());
    $row_busca = mysql_fetch_array($res_busca);
		$mod_ncorr = $row_busca['grupo_mod'];

		$sql_insert = "INSERT INTO `cotizacion_detalle_repuestos`(`mod_ncorr`, `cod_repuesto`, `cantidad`, `precio_neto_unitario`, `iva`, `precio_unitario`, `total`) 
						select '".$id."', `cod_repuesto`, `cantidad`, `precio_neto_unitario`, `iva`, `precio_unitario`, `total`
						FROM `cotizacion_detalle_repuestos_temp` WHERE grupo_mod = '".$mod_ncorr."'";
	    $res_insert = mysql_query($sql_insert,$conexion) or die(mysql_error());

		

	$objResponse->addScript("alert('Cotizacion Guardada.Nro : ".$id."')");
	
	
	$sql_busca = "delete from gescolcl_taller.cotizacion_detalle_repuestos_temp";
  	$res_busca = mysql_query($sql_busca,$conexion) or die(mysql_error());
    
    $sql_busca = "delete from gescolcl_taller.cotizacion_detalle_mo_temp";
    $res_busca = mysql_query($sql_busca,$conexion) or die(mysql_error());
    
    $objResponse->addScript("document.Form1.submit();");

	return $objResponse->getXML();

}

function GrabarMO($data){
	global $conexion;
	global $miSmarty;
	
    $objResponse = new xajaxResponse('ISO-8859-1');
	
    $grupo_mod 		= $_SESSION['grupo_mod'];
	$ot_ncorr 		= $data['ot_ncorr'];
	$detalle		= $data['cod_detalle_mo_nuv'];
	$cantidad 		= $data['cantidad_mo'];
	$precio_neto 	= $data['precio_neto_mo'];
	$iva 			= $data['iva_mo'];
	$total_unitario = $data['total_unitario_mo'];
	$total 			= $data['total_mo'];
	$pagado 		= $data['pagado_mo'];
	
    $sql_insert = "INSERT INTO gescolcl_taller.cotizacion_detalle_mo_temp(`grupo_mod`, `ot_ncorr`, `detalle`, `cantidad`, 
    														`precio_neto`, `iva`, `total_unitario`, `total`, `pagado`) 
    				VALUES ('".$grupo_mod."','".$ot_ncorr."','".$detalle."','".$cantidad."','".$precio_neto ."',
    						'".$iva."','".$total_unitario."','".$total ."','".$pagado ."')";
    $res_insert = mysql_query($sql_insert,$conexion) or die(mysql_error());

    $arrRegistros = array();

    $sql_genera_mo  = "select * from gescolcl_taller.cotizacion_detalle_mo_temp
    					where grupo_mod = '".$grupo_mod."' ";
    $res_genera_mo	= mysql_query($sql_genera_mo,$conexion) or die(mysql_error());
    $i=0;
    while ($row_genera_mo = mysql_fetch_row($res_genera_mo)){
    	$i++;

    		$sql = "SELECT * 
			        FROM gescolcl_taller.tipo_mo
			        WHERE `tmo_ncorr` = '".$row_genera_mo[3]."' ";
			$res = mysql_query($sql, $conexion);
			$row = mysql_fetch_assoc($res);
			$nombre_mo = $row['nombre'];


    	array_push($arrRegistros, array("item"				=>	$i,
										"mod_ncorr" 		=> 	$row_genera_mo[0],
										"grupo_mod" 		=> 	$row_genera_mo[1],
										"ot_ncorr" 			=> 	$row_genera_mo[2],
										"detalle" 			=> 	strtoupper ($nombre_mo),
										"cantidad" 			=> 	$row_genera_mo[4],
										"precio_neto" 		=> 	number_format ( $row_genera_mo[5],0 , "." , "," ),
										"iva" 				=> 	number_format ( $row_genera_mo[6],0 , "." , "," ),
										"total_unitario" 	=> 	number_format ( $row_genera_mo[7],0 , "." , "," ),
										"total" 			=> 	number_format ( $row_genera_mo[8],0 , "." , "," ),
										"pagado" 			=> 	$row_genera_mo[9]));

    	}
	$miSmarty->assign('arrRegistros', $arrRegistros);
	$objResponse->addAssign("divmo", "innerHTML", $miSmarty->fetch('sg_cotizacion_ingresar_mo_list.tpl'));

	$objResponse->addAssign("detalle_mo_nuv", "value", '');
	$objResponse->addAssign("cod_detalle_mo_nuv", "value", '');
	$objResponse->addAssign("precio_neto_mo", "value", '');
	$objResponse->addAssign("iva_mo", "value", '');
	$objResponse->addAssign("total_unitario_mo", "value", '');
	$objResponse->addAssign("cantidad_mo", "value", '');
	$objResponse->addAssign("total_mo", "value", '');

	$sql_genera_mo  = "select sum(total) as total_mo, sum(cantidad*iva) as iva, sum(precio_neto*cantidad) as precio_neto
						from gescolcl_taller.cotizacion_detalle_mo_temp
    					where grupo_mod = '".$grupo_mod."' ";
    $res_genera_mo	= mysql_query($sql_genera_mo,$conexion) or die(mysql_error());
    $row_genera_mo = mysql_fetch_array($res_genera_mo);
    $total_mo = $row_genera_mo['total_mo'];
	$neto_mo = $row_genera_mo['precio_neto'];
	$iva_mo = $row_genera_mo['iva'];

    $objResponse->addScript("document.getElementById('total_mo_final').innerHTML='".number_format ( $row_genera_mo['total_mo'],0 , "." , "," )."'");
    $objResponse->addScript("document.getElementById('neto_mo_final').innerHTML='".number_format ( ($neto_mo),0 , "." , "," )."'");
    $objResponse->addScript("document.getElementById('iva_mo_final').innerHTML='".number_format ( ($iva_mo),0 , "." , "," )."'");
	
	$sql_genera_mo  = "select sum(total) as total_rep, sum(cantidad*iva) as iva, sum(precio_neto_unitario*cantidad) as precio_neto
						from gescolcl_taller.cotizacion_detalle_repuestos_temp
    					where grupo_mod = '".$grupo_mod."' ";
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
   

	$objResponse->addScript("alert('Mano de Obra ingresada.')");
	$objResponse->addScript("document.getElementById('detalle_mo_nuv').focus()");

	return $objResponse->getXML();

}


function EliminarMO($data,$ncorr,$grupo){
	global $conexion;
	global $miSmarty;
    
	
    $objResponse = new xajaxResponse('ISO-8859-1');
	
    $sql_busca = "delete from gescolcl_taller.cotizacion_detalle_mo_temp
    				where mod_ncorr = '".$ncorr."'";
    $res_busca = mysql_query($sql_busca,$conexion) or die(mysql_error());
    
	
	$arrRegistros = array();

    $sql_genera_mo  = "select * from gescolcl_taller.cotizacion_detalle_mo_temp
    					where grupo_mod = '".$grupo."' ";
    $res_genera_mo	= mysql_query($sql_genera_mo,$conexion) or die(mysql_error());
    $i=0;
    while ($row_genera_mo = mysql_fetch_row($res_genera_mo)){
    		$sql = "SELECT * 
			        FROM gescolcl_taller.tipo_mo
			        WHERE `tmo_ncorr` = '".$row_genera_mo[3]."' ";
			$res = mysql_query($sql, $conexion);
			$row = mysql_fetch_assoc($res);
			$nombre_mo = $row['nombre'];


    	array_push($arrRegistros, array("item"				=>	$i,
										"mod_ncorr" 		=> 	$row_genera_mo[0],
										"grupo_mod" 		=> 	$row_genera_mo[1],
										"ot_ncorr" 			=> 	$row_genera_mo[2],
										"detalle" 			=> 	strtoupper ($nombre_mo),
										"cantidad" 			=> 	$row_genera_mo[4],
										"precio_neto" 		=> 	number_format ( $row_genera_mo[5],0 , "." , "," ),
										"iva" 				=> 	number_format ( $row_genera_mo[6],0 , "." , "," ),
										"total_unitario" 	=> 	number_format ( $row_genera_mo[7],0 , "." , "," ),
										"total" 			=> 	number_format ( $row_genera_mo[8],0 , "." , "," ),
										"pagado" 			=> 	$row_genera_mo[9]));

    	}
	$miSmarty->assign('arrRegistros', $arrRegistros);
	$objResponse->addAssign("divmo", "innerHTML", $miSmarty->fetch('sg_cotizacion_ingresar_mo_list.tpl'));

	$sql_genera_mo  = "select sum(total) as total_mo, sum(cantidad*iva) as iva, sum(precio_neto*cantidad) as precio_neto
						from gescolcl_taller.cotizacion_detalle_mo_temp
    					where grupo_mod = '".$grupo."' ";
    $res_genera_mo	= mysql_query($sql_genera_mo,$conexion) or die(mysql_error());
    $row_genera_mo = mysql_fetch_array($res_genera_mo);
    $total_mo = $row_genera_mo['total_mo'];
	$neto_mo = $row_genera_mo['precio_neto'];
	$iva_mo = $row_genera_mo['iva'];


    $objResponse->addScript("document.getElementById('total_mo_final').innerHTML='".number_format ( $row_genera_mo['total_mo'],0 , "." , "," )."'");
    $objResponse->addScript("document.getElementById('neto_mo_final').innerHTML='".number_format ( ($neto_mo),0 , "." , "," )."'");
    $objResponse->addScript("document.getElementById('iva_mo_final').innerHTML='".number_format ( ($iva_mo),0 , "." , "," )."'");
	
	$sql_genera_mo  = "select sum(total) as total_rep, sum(cantidad*iva) as iva, sum(precio_neto_unitario*cantidad) as precio_neto
						from gescolcl_taller.cotizacion_detalle_repuestos_temp
    					where grupo_mod = '".$grupo."' ";
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
   



	$objResponse->addScript("alert('Mano de Obra Eliminada.')");


	return $objResponse->getXML();

}

function GrabarRepuesto($data){
	global $conexion;
	global $miSmarty;
    
	
    $objResponse = new xajaxResponse('ISO-8859-1');
	
    $grupo_mod 				= $_SESSION['grupo_mod'];
	$cod_repuesto 			= $data['cod_repuesto'];
	$cantidad 				= $data['cantidad'];
	$precio_neto_unitario 	= $data['precio_neto_unitario'];
	$iva 					= $data['iva'];
	$precio_unitario 		= $data['precio_unitario'];
	$total 					= $data['total'];
	
    $sql_insert = "INSERT INTO gescolcl_taller.cotizacion_detalle_repuestos_temp(`grupo_mod`, `cod_repuesto`, `cantidad`, 
    															`precio_neto_unitario`, `iva`, `precio_unitario`, `total`) 
    				VALUES ('".$grupo_mod."','".$cod_repuesto."','".$cantidad."','".$precio_neto_unitario ."',
    						'".$iva ."','".$precio_unitario."','".$total ."')";
    $res_insert = mysql_query($sql_insert,$conexion) or die(mysql_error());

	$arrRegistros = array();

    $sql_genera_mo  = "select * from gescolcl_taller.cotizacion_detalle_repuestos_temp
    					where grupo_mod = '".$_SESSION['grupo_mod']."' ";
    $res_genera_mo	= mysql_query($sql_genera_mo,$conexion) or die(mysql_error());
    $i=0;
    while ($row_genera_mo = mysql_fetch_row($res_genera_mo)){
    	$i++;
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

    	array_push($arrRegistros, array("item"		=>	$i,
										"otr_ncorr" 			=> 	$row_genera_mo[0],
										"grupo_mod" 			=> 	$row_genera_mo[1],
										"cod_repuesto" 			=>  strtoupper ($nombre_repuesto),
										"cantidad" 				=> 	$row_genera_mo[3],
										"precio_neto_unitario" 	=> 	number_format ( $row_genera_mo[4],0 , "." , "," ),
										"iva" 					=> 	number_format ( $row_genera_mo[5],0 , "." , "," ),
										"precio_unitario" 		=> 	number_format ( $row_genera_mo[6],0 , "." , "," ),
										"total" 				=>  number_format ( $row_genera_mo[7],0 , "." , "," )));

    	}
	$miSmarty->assign('arrRegistros', $arrRegistros);
	$objResponse->addAssign("divrepuestos", "innerHTML", $miSmarty->fetch('sg_cotizacion_ingresar_repuestos_list.tpl'));

	$objResponse->addAssign("repuesto", "value", '');
	$objResponse->addAssign("cod_repuesto", "value", '');
	$objResponse->addAssign("precio_neto_unitario", "value", '');
	$objResponse->addAssign("iva", "value", '');
	$objResponse->addAssign("precio_unitario", "value", '');
	$objResponse->addAssign("cantidad", "value", '');
	$objResponse->addAssign("total", "value", '');

	$objResponse->addScript("document.getElementById('repuesto').focus()");

	$objResponse->addScript("alert('Repuesto ingresado.')");


	$sql_genera_mo  = "select sum(total) as total_mo, sum(cantidad*iva) as iva, sum(precio_neto*cantidad) as precio_neto
						from gescolcl_taller.cotizacion_detalle_mo_temp
    					where grupo_mod = '".$grupo_mod."' ";
    $res_genera_mo	= mysql_query($sql_genera_mo,$conexion) or die(mysql_error());
    $row_genera_mo = mysql_fetch_array($res_genera_mo);
    $total_mo = $row_genera_mo['total_mo'];
	$neto_mo = $row_genera_mo['precio_neto'];
	$iva_mo = $row_genera_mo['iva'];

	
    $objResponse->addScript("document.getElementById('total_mo_final').innerHTML='".number_format ( $row_genera_mo['total_mo'],0 , "." , "," )."'");
    $objResponse->addScript("document.getElementById('neto_mo_final').innerHTML='".number_format ( ($neto_mo),0 , "." , "," )."'");
    $objResponse->addScript("document.getElementById('iva_mo_final').innerHTML='".number_format ( ($iva_mo),0 , "." , "," )."'");
	
	$sql_genera_mo  = "select sum(total) as total_rep, sum(cantidad*iva) as iva, sum(precio_neto_unitario*cantidad) as precio_neto
						from gescolcl_taller.cotizacion_detalle_repuestos_temp
    					where grupo_mod = '".$grupo_mod."' ";
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


	return $objResponse->getXML();

}

function EliminarRepuesto($data,$otr_ncorr,$mod_ncorr){
	global $conexion;
	global $miSmarty;
    
	
    $objResponse = new xajaxResponse('ISO-8859-1');
	
    $sql_busca = "delete from gescolcl_taller.cotizacion_detalle_repuestos_temp
    				where otr_ncorr = '".$otr_ncorr."'";
    $res_busca = mysql_query($sql_busca,$conexion) or die(mysql_error());
    $row_busca = mysql_fetch_array($res_busca);
	
	$arrRegistros = array();

    $sql_genera_mo  = "select * from gescolcl_taller.cotizacion_detalle_repuestos_temp
    					where grupo_mod = '".$mod_ncorr."' ";
    $res_genera_mo	= mysql_query($sql_genera_mo,$conexion) or die(mysql_error());
    $i=0;

    while ($row_genera_mo = mysql_fetch_row($res_genera_mo)){
    	$i++;
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

    	array_push($arrRegistros, array("item"		=>	$i,
										"otr_ncorr" 			=> 	$row_genera_mo[0],
										"grupo_mod" 			=> 	$row_genera_mo[1],
										"cod_repuesto" 			=>  strtoupper ($nombre_repuesto),
										"cantidad" 				=> 	$row_genera_mo[3],
										"precio_neto_unitario" 	=> 	number_format ($row_genera_mo[4],0 , "." , "," ),
										"iva" 					=> 	number_format ($row_genera_mo[5],0 , "." , "," ),
										"precio_unitario" 		=> 	number_format ($row_genera_mo[6],0 , "." , "," ),
										"total" 				=> 	number_format ($row_genera_mo[7],0 , "." , "," )));



    	}
	$miSmarty->assign('arrRegistros', $arrRegistros);
	$objResponse->addAssign("divrepuestos", "innerHTML", $miSmarty->fetch('sg_cotizacion_ingresar_repuestos_list.tpl'));

	$objResponse->addScript("alert('Repuesto Eliminada.')");
	

	$sql_genera_mo  = "select sum(total) as total_mo, sum(cantidad*iva) as iva, sum(precio_neto*cantidad) as precio_neto
						from gescolcl_taller.cotizacion_detalle_mo_temp
    					where grupo_mod = '".$mod_ncorr."' ";
    $res_genera_mo	= mysql_query($sql_genera_mo,$conexion) or die(mysql_error());
    $row_genera_mo = mysql_fetch_array($res_genera_mo);
    $total_mo = $row_genera_mo['total_mo'];
	$neto_mo = $row_genera_mo['precio_neto'];
	$iva_mo = $row_genera_mo['iva'];

    $objResponse->addScript("document.getElementById('total_mo_final').innerHTML='".number_format ( $row_genera_mo['total_mo'],0 , "." , "," )."'");
    $objResponse->addScript("document.getElementById('neto_mo_final').innerHTML='".number_format ( ($neto_mo),0 , "." , "," )."'");
    $objResponse->addScript("document.getElementById('iva_mo_final').innerHTML='".number_format ( ($iva_mo),0 , "." , "," )."'");
	
	$sql_genera_mo  = "select sum(total) as total_rep, sum(cantidad*iva) as iva, sum(precio_neto_unitario*cantidad) as precio_neto
						from gescolcl_taller.cotizacion_detalle_repuestos_temp
    					where grupo_mod = '".$mod_ncorr."' ";
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



	return $objResponse->getXML();

}


function AgregarMO($data){
	global $conexion;
	global $miSmarty;
    
	$objResponse = new xajaxResponse('ISO-8859-1');

	$objResponse->addScript("showPopWin('sg_mant_tablas.php?tbl=tipo_mo', 'Mantenedor Mano de Obra', 800, 600, null);");

	return $objResponse->getXML();

}

function AgregarRep($data){
	global $conexion;
	global $miSmarty;
    
	
    $objResponse = new xajaxResponse('ISO-8859-1');

	$objResponse->addScript("showPopWin('sg_mant_tablas.php?tbl=tipo_repuestos', 'Mantenedor Tipo Repuestos', 800, 600, null);");

	return $objResponse->getXML();

}


function AgregarPersona($data){
	global $conexion;
	global $miSmarty;
    
	
    $objResponse = new xajaxResponse('ISO-8859-1');

	$objResponse->addScript("showPopWin('sg_mant_tablas.php?tbl=personas', 'Mantenedor Clientes', 800, 600, null);");

	return $objResponse->getXML();

}



$xajax->registerFunction("CargaPagina");
$xajax->registerFunction("Grabar");
$xajax->registerFunction("GrabarMO");
$xajax->registerFunction("EliminarMO");
$xajax->registerFunction("GrabarRepuesto");
$xajax->registerFunction("EliminarRepuesto");
$xajax->registerFunction("AgregarMO");
$xajax->registerFunction("AgregarRep");
$xajax->registerFunction("AgregarPersona");


$xajax->processRequests();
$miSmarty->assign('xajax_js', $xajax->getJavascript());


$miSmarty->display('sg_cotizacion_ingresar.tpl');
?>

