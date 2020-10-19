<?php
session_start();

require_once 'includes/xajax/xajax.inc.php'; //archivo de configuracion de ajax
include "../includes/php/conf_smarty.php";//archivo de configuracion de smarty
include "../includes/php/conf_bd.php"; //archivo de coneccion al servidor y base de datos
//include "../includes/php/conf_bd_antigua.php"; //archivo de coneccion al servidor de yonley
include "../includes/php/validaciones.php"; 

$xajax = new xajax();

$xajax->setRequestURI("sg_existencia_movimientos_vendedor_detalle.2.php");
$xajax->setCharEncoding("ISO-8859-1");
$xajax->decodeUTF8InputOn();

function Grabar($data){
	global $conexion;
	global $miSmarty;
	
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	$objResponse->addScript("document.getElementById('divabonos').style.display='none';");
	
	$codigo			= 	$data["txtCodigo"];
	$descripcion	= 	$data["txtDescripcion"];
	$fecha1			= 	$data["txtFecha1"];
	$fecha2			= 	$data["txtFecha2"];
	$cobrador		= 	$data["txtCobrador"];
	$empresa		= 	$data["txtEmpresa"];
	$mes			=	$data['txtMes'];
	$anio			=	$data['txtAnio'];
	
	//busca el codigo antiguo
	$sql_ncorr 	= 	"select ta_codigo from sgbodega.tallasnew where ta_ncorr = '".$codigo."'";
	$res_ncorr 	= 	mysql_query($sql_ncorr, $conexion);
	$codigo_antiguo		=	@mysql_result($res_ncorr,0,"ta_codigo");

	$arrRegistros = array();
	$total_n = 0;
	$total_u = 0;
	
	// busca el stock inicial de la ultima guia y el codigo
						// busca el stock inicial de la ultima guia y el codigo
						$sql_sguia = "select SG_FECHA, sg_stocknuevo as inicial_n, sg_stockusado as inicial_u from sgbodega.subgdcontrol 
										where sg_codbus = '".$codigo."' and SG_VENDEDOR = '".$cobrador."'
										order by sg_numero desc ";
						$res_sguia = mysql_query($sql_sguia, $conexion) or die(mysql_error());
						$row_sguia = mysql_fetch_array($res_sguia);
						$inicial_n = $row_sguia["inicial_n"];
						$inicial_u = $row_sguia["inicial_u"];
						$ult_fecha = $row_sguia["SG_FECHA"];
					
					$sql_cierre			= 	"select fecha as ultimocierre 
													from sgyonley.cierres_ventas 
													where vend_rut = '".$cobrador."' 
														order by cv_ncorr desc ";
					$res_cierre			= 	mysql_query($sql_cierre, $conexion);
					$row_cierre			=	mysql_fetch_array($res_cierre)	;
					$fecha_hasta		= 	$row_cierre["ultimocierre"];
					$row_cierre			=	mysql_fetch_array($res_cierre)	;
					$fecha_desde		= 	$row_cierre["ultimocierre"];
					
					$sql_cierre			= 	"select fecha as ultimocierre 
									from sgyonley.cierres_ventas 
									where vend_rut = '".$cobrador."' and mes='".$mes."' and anio='".$anio."' 
										order by fecha desc limit 1
							";
					$res_cierre			= 	mysql_query($sql_cierre, $conexion);
					$row_cierre			=	mysql_fetch_array($res_cierre)	;
					$fecha_hasta		= 	$row_cierre["ultimocierre"];
				
					$sql_cierre			= 	"select fecha as ultimocierre 
													from sgyonley.cierres_ventas 
													where vend_rut = '".$cobrador."' and mes='".$mes."' and anio='".$anio."' 
														order by fecha asc limit 1 
										";
					$res_cierre			= 	mysql_query($sql_cierre, $conexion);
					$row_cierre			=	mysql_fetch_array($res_cierre)	;
					$fecha_desde		= 	$row_cierre["ultimocierre"];
					
	
					$fecha1 	= $fecha_desde;
					$fecha2 	= $fecha_hasta;

					$actual_n = $inicial_n ;
					$actual_u = $inicial_u ;
					
			array_push($arrRegistros, array("fecha"			=>	$fecha_guia,
											"codigo"		=>	$codigo,
											"descripcion"	=>	$descripcion,
											"nu"			=>	'N',
											"guia" 			=> 	'----',
											"tarjeta" 		=> 	'',
											"movim"	 		=> 	'INICIO',
											"cantidad" 		=> 	$actual_n,
											"usuario"		=> 	'----'));
			$total_n = $total_n + $actual_n ;
			array_push($arrRegistros, array("fecha"			=>	$fecha_guia,
											"codigo"		=>	$codigo,
											"descripcion"	=>	$descripcion,
											"nu"			=>	'U',
											"guia" 			=> 	'----',
											"tarjeta" 		=> 	'',
											"movim"	 		=> 	'INICIO',
											"cantidad" 		=> 	$actual_u,
											"usuario"		=> 	'----'));
			$total_u = $total_u + $actual_u ;
		
	//busca los aumentos en el periodo (movim 2)
	//NUEVO
	
	$and="";
	$and_1="";
	$fecha1_1 = $ult_fecha;
	$and = " b.movim_fecha <= '".$fecha2."' and ";
	$and_1 = " b.vent_fecha <= '".$fecha2."' and ";
	
	$sql_saumentos 	= "select 
						DATE_FORMAT(b.movim_fecha,'%d/%m/%Y') as fecha,
						a.mdet_codigo as codigo,
						a.mdet_desc as descripcion,
						a.mdet_nu as nu,
						a.movim_ncorr as guia,
						a.mdet_cantidad as cantidad,
						b.usu_id as usuario
						
						from 
						sgcompras.movim_detalle a, sgcompras.movim b
						
						where
						a.mdet_codigo = '".$codigo."' and
						a.mdet_nu = 'N' and
						a.movim_ncorr = b.movim_ncorr and
						b.movim_tipo = '2' and
						b.empe_rut = '".$empresa."' and
						b.vend_ncorr = '".$cobrador."' and
						b.movim_fecha >= '".$fecha1_1."' and $and
						b.movim_estado = 'FINALIZADO' and
						b.movim_ncorr in (select guia from control_guia)";
	
	//$objResponse->addAssign("divabonos", "innerHTML", $sql_saumentos);
	
	$res_saumentos 	= 	mysql_query($sql_saumentos, $conexion);
	while ($line_saumentos = mysql_fetch_row($res_saumentos)) {
		
		array_push($arrRegistros, array("fecha"			=>	$line_saumentos[0],
										"codigo"		=>	$line_saumentos[1],
										"descripcion"	=>	$line_saumentos[2],
										"nu"			=>	$line_saumentos[3],
										"guia" 			=> 	$line_saumentos[4],
										"tarjeta" 		=> 	'',
										"movim"	 		=> 	'AUMENTO',
										"cantidad" 		=> 	$line_saumentos[5],
										"usuario"		=> 	$line_saumentos[6]));
		$i++;
		$total_n = $total_n + $line_saumentos[5];
	}
	//USADO
	$sql_saumentos 	= "select 
						DATE_FORMAT(b.movim_fecha,'%d/%m/%Y') as fecha,
						a.mdet_codigo as codigo,
						a.mdet_desc as descripcion,
						a.mdet_nu as nu,
						a.movim_ncorr as guia,
						a.mdet_cantidad as cantidad,
						b.usu_id as usuario
						
						from 
						sgcompras.movim_detalle a, sgcompras.movim b
						
						where
						a.mdet_codigo = '".$codigo."' and
						a.mdet_nu = 'U' and
						a.movim_ncorr = b.movim_ncorr and
						b.movim_tipo = '2' and
						b.empe_rut = '".$empresa."' and
						b.vend_ncorr = '".$cobrador."' and
						b.movim_fecha >= '".$fecha1_1."' and $and
						b.movim_estado = 'FINALIZADO' and
						b.movim_ncorr in (select guia from control_guia)";
	
	//$objResponse->addAssign("divabonos", "innerHTML", $sql_saumentos);
	
	$res_saumentos 	= 	mysql_query($sql_saumentos, $conexion);
	while ($line_saumentos = mysql_fetch_row($res_saumentos)) {
		
		array_push($arrRegistros, array("fecha"			=>	$line_saumentos[0],
										"codigo"		=>	$line_saumentos[1],
										"descripcion"	=>	$line_saumentos[2],
										"nu"			=>	$line_saumentos[3],
										"guia" 			=> 	$line_saumentos[4],
										"tarjeta" 		=> 	'',
										"movim"	 		=> 	'AUMENTO',
										"cantidad" 		=> 	$line_saumentos[5],
										"usuario"		=> 	$line_saumentos[6]));
		$i++;
		$total_u = $total_u + $line_saumentos[5];
	}
	
	//busca los aumentos en el periodo que no afectan a bodega (movim 6)
	//NUEVO
	$sql_saumentos_nb 	= "select 
						DATE_FORMAT(b.movim_fecha,'%d/%m/%Y') as fecha,
						a.mdet_codigo as codigo,
						a.mdet_desc as descripcion,
						a.mdet_nu as nu,
						a.movim_ncorr as guia,
						a.mdet_cantidad as cantidad,
						b.usu_id as usuario
						
						from 
						sgcompras.movim_detalle a, sgcompras.movim b
						
						where
						a.mdet_codigo = '".$codigo."' and
						a.mdet_nu = 'N' and
						a.movim_ncorr = b.movim_ncorr and
						b.movim_tipo = '6' and
						b.empe_rut = '".$empresa."' and
						b.vend_ncorr = '".$cobrador."' and
						b.movim_fecha >= '".$fecha1_1."' and $and
						b.movim_estado = 'FINALIZADO'";
	
	//$objResponse->addAssign("divabonos", "innerHTML", $sql_saumentos);
	
	$res_saumentos_nb 	= 	mysql_query($sql_saumentos_nb, $conexion);
	while ($line_saumentos_nb = mysql_fetch_row($res_saumentos_nb)) {
		
		array_push($arrRegistros, array("fecha"			=>	$line_saumentos_nb[0],
										"codigo"		=>	$line_saumentos_nb[1],
										"descripcion"	=>	$line_saumentos_nb[2],
										"nu"			=>	$line_saumentos_nb[3],
										"guia" 			=> 	$line_saumentos_nb[4],
										"tarjeta" 		=> 	'',
										"movim"	 		=> 	'AUMENTO NO AFECTA BODEGA',
										"cantidad" 		=> 	$line_saumentos_nb[5],
										"usuario"		=> 	$line_saumentos_nb[6]));
		$i++;
		$total_n = $total_n + $line_saumentos_nb[5];
	}
	//USADO
	$sql_saumentos_ub 	= "select 
						DATE_FORMAT(b.movim_fecha,'%d/%m/%Y') as fecha,
						a.mdet_codigo as codigo,
						a.mdet_desc as descripcion,
						a.mdet_nu as nu,
						a.movim_ncorr as guia,
						a.mdet_cantidad as cantidad,
						b.usu_id as usuario
						
						from 
						sgcompras.movim_detalle a, sgcompras.movim b
						
						where
						a.mdet_codigo = '".$codigo."' and
						a.mdet_nu = 'U' and
						a.movim_ncorr = b.movim_ncorr and
						b.movim_tipo = '6' and
						b.empe_rut = '".$empresa."' and
						b.vend_ncorr = '".$cobrador."' and
						b.movim_fecha >= '".$fecha1_1."' and $and
						b.movim_estado = 'FINALIZADO'";
	
	//$objResponse->addAssign("divabonos", "innerHTML", $sql_saumentos_ub);
	
	$res_saumentos_ub 	= 	mysql_query($sql_saumentos_ub, $conexion);
	while ($line_saumentos_ub = mysql_fetch_row($res_saumentos_ub)) {
		
		array_push($arrRegistros, array("fecha"			=>	$line_saumentos_ub[0],
										"codigo"		=>	$line_saumentos_ub[1],
										"descripcion"	=>	$line_saumentos_ub[2],
										"nu"			=>	$line_saumentos_ub[3],
										"guia" 			=> 	$line_saumentos_ub[4],
										"tarjeta" 		=> 	'',
										"movim"	 		=> 	'AUMENTO NO AFECTA BODEGA',
										"cantidad" 		=> 	$line_saumentos_ub[5],
										"usuario"		=> 	$line_saumentos_ub[6]));
		$i++;
		$total_u = $total_u + $line_saumentos_ub[5];
	}
	
	
	//busca las rebajas por ventas 
	//NUEVO (ventas antiguas)
	$sql_rebajas 	= "select 
						DATE_FORMAT(b.vent_fecha,'%d/%m/%Y') as fecha,
						a.arti_codigo_largo as codigo,
						a.arti_desc as descripcion,
						a.arti_nu as nu,
						b.vent_num_folio as tarjeta,
						a.vent_cant as cantidad,
						b.usua_login as usuario
	
						from 
						sgyonley.ventas_detalle_antigua a, sgyonley.ventas_antigua b
						
						where
						a.arti_codigo_largo = '".$codigo_antiguo."' and
						a.vent_migrado = 'SI' and
						a.arti_nu = 'N' and
						a.vent_ncorr = b.vent_num_folio and
						b.empe_rut = '".$empresa."' and
						b.vend_ncorr = '".$cobrador."' and
						b.vent_fecha >= '".$fecha1_1."' and $and_1
						b.vent_estado = 'FINALIZADA' and
						b.vent_estado_ingreso != 'A' AND
						b.vent_estado_ingreso != 'N' AND
						b.vent_estado_ingreso != 'PV'";
	
	
	$res_rebajas 	= 	mysql_query($sql_rebajas, $conexion);
	while ($line_rebajas = mysql_fetch_row($res_rebajas)) {
		array_push($arrRegistros, array("fecha"			=>	$line_rebajas[0],
										"codigo"		=>	$line_rebajas[1],
										"descripcion"	=>	$line_rebajas[2],
										"nu"			=>	$line_rebajas[3],
										"guia" 			=> 	'',
										"tarjeta" 		=> 	$line_rebajas[4],
										"movim"	 		=> 	'VENTA SIST. ANTIGUO',
										"cantidad" 		=> 	$line_rebajas[5],
										"usuario"		=> 	$line_rebajas[6]));
		$i++;
		$total_n = $total_n - $line_rebajas[5];
	
	}
	//USADO
	$sql_rebajas 	= "select 
						DATE_FORMAT(b.vent_fecha,'%d/%m/%Y') as fecha,
						a.arti_codigo_largo as codigo,
						a.arti_desc as descripcion,
						a.arti_nu as nu,
						b.vent_num_folio as tarjeta,
						a.vent_cant as cantidad,
						b.usua_login as usuario
	
						from 
						sgyonley.ventas_detalle_antigua a, sgyonley.ventas_antigua b
						
						where
						a.arti_codigo_largo = '".$codigo_antiguo."' and
						a.vent_migrado = 'SI' and
						a.arti_nu = 'U' and
						a.vent_ncorr = b.vent_num_folio and
						b.empe_rut = '".$empresa."' and
						b.vend_ncorr = '".$cobrador."' and
						b.vent_fecha >= '".$fecha1_1."' and $and_1
						b.vent_estado = 'FINALIZADA' and
						b.vent_estado_ingreso != 'A' AND
						b.vent_estado_ingreso != 'N' AND
						b.vent_estado_ingreso != 'PV'";
	
	
	$res_rebajas 	= 	mysql_query($sql_rebajas, $conexion);
	while ($line_rebajas = mysql_fetch_row($res_rebajas)) {
		array_push($arrRegistros, array("fecha"			=>	$line_rebajas[0],
										"codigo"		=>	$line_rebajas[1],
										"descripcion"	=>	$line_rebajas[2],
										"nu"			=>	$line_rebajas[3],
										"guia" 			=> 	'',
										"tarjeta" 		=> 	$line_rebajas[4],
										"movim"	 		=> 	'VENTA SIST. ANTIGUO',
										"cantidad" 		=> 	$line_rebajas[5],
										"usuario"		=> 	$line_rebajas[6]));
		$i++;
		$total_u = $total_u - $line_rebajas[5];
	
	}
	
	
	//NUEVO (ventas nuevas)
	$sql_rebajasnew 	= "select 
						DATE_FORMAT(b.vent_fecha,'%d/%m/%Y') as fecha,
						a.arti_codigo_largo as codigo,
						a.arti_desc as descripcion,
						a.arti_nu as nu,
						b.vent_num_folio as tarjeta,
						a.vent_cant as cantidad,
						b.usua_login as usuario
	
						from 
						sgyonley.ventas_detalle_antigua a, sgyonley.ventas_antigua b
						
						where
						a.arti_codigo_largo = '".$codigo."' and
						a.arti_nu = 'N' and
						a.vent_ncorr = b.vent_num_folio and
						b.empe_rut = '".$empresa."' and
						b.vend_ncorr = '".$cobrador."' and
						b.vent_fecha >= '".$fecha1_1."' and $and_1
						b.vent_estado = 'FINALIZADA' and
						b.vent_estado_ingreso != 'A' AND
						b.vent_estado_ingreso != 'N' AND
						b.vent_estado_ingreso != 'PV'";
	
	
	$res_rebajasnew 	= 	mysql_query($sql_rebajasnew, $conexion);
	while ($line_rebajasnew = mysql_fetch_row($res_rebajasnew)) {
		array_push($arrRegistros, array("fecha"			=>	$line_rebajasnew[0],
										"codigo"		=>	$line_rebajasnew[1],
										"descripcion"	=>	$line_rebajasnew[2],
										"nu"			=>	$line_rebajasnew[3],
										"guia" 			=> 	'',
										"tarjeta" 		=> 	$line_rebajasnew[4],
										"movim"	 		=> 	'VENTA',
										"cantidad" 		=> 	$line_rebajasnew[5],
										"usuario"		=> 	$line_rebajasnew[6]));
		$i++;
		$total_n = $total_n - $line_rebajasnew[5];
	
	}
	
	//USADO
	$sql_rebajasnew 	= "select 
						DATE_FORMAT(b.vent_fecha,'%d/%m/%Y') as fecha,
						a.arti_codigo_largo as codigo,
						a.arti_desc as descripcion,
						a.arti_nu as nu,
						b.vent_num_folio as tarjeta,
						a.vent_cant as cantidad,
						b.usua_login as usuario
	
						from 
						sgyonley.ventas_detalle_antigua a, sgyonley.ventas_antigua b
						
						where
						a.arti_codigo_largo = '".$codigo."' and
						a.arti_nu = 'U' and
						a.vent_ncorr = b.vent_num_folio and
						b.empe_rut = '".$empresa."' and
						b.vend_ncorr = '".$cobrador."' and
						b.vent_fecha >= '".$fecha1_1."' and $and_1
						b.vent_estado = 'FINALIZADA' and
						b.vent_estado_ingreso != 'A' AND
						b.vent_estado_ingreso != 'N' AND
						b.vent_estado_ingreso != 'PV'";
	
	
	$res_rebajasnew 	= 	mysql_query($sql_rebajasnew, $conexion);
	while ($line_rebajasnew = mysql_fetch_row($res_rebajasnew)) {
		array_push($arrRegistros, array("fecha"			=>	$line_rebajasnew[0],
										"codigo"		=>	$line_rebajasnew[1],
										"descripcion"	=>	$line_rebajasnew[2],
										"nu"			=>	$line_rebajasnew[3],
										"guia" 			=> 	'',
										"tarjeta" 		=> 	$line_rebajasnew[4],
										"movim"	 		=> 	'VENTA',
										"cantidad" 		=> 	$line_rebajasnew[5],
										"usuario"		=> 	$line_rebajasnew[6]));
		$i++;
		$total_u = $total_u - $line_rebajasnew[5];
	
	}
	
	//busca las devoluciones de vendedor en el periodo (movim 4) rebajas por devoluciones de vendedor
	//NUEVO
	$sql_dev 	= "select 
						DATE_FORMAT(b.movim_fecha,'%d/%m/%Y') as fecha,
						a.mdet_codigo as codigo,
						a.mdet_desc as descripcion,
						a.mdet_nu as nu,
						b.movim_ncorr as guia,
						a.mdet_cantidad as cantidad,
						b.usu_id as usuario
						
						from 
						sgcompras.movim_detalle a, sgcompras.movim b
						
						where
						a.mdet_codigo = '".$codigo."' and
						a.mdet_nu = 'N' and
						a.movim_ncorr = b.movim_ncorr and
						b.movim_tipo = '4' and
						b.empe_rut = '".$empresa."' and
						b.vend_ncorr = '".$cobrador."' and
						b.movim_fecha >= '".$fecha1_1."' and $and
						b.movim_estado = 'FINALIZADO'";
	$res_dev 	= 	mysql_query($sql_dev, $conexion);
	while ($line_dev = mysql_fetch_row($res_dev)) {
		array_push($arrRegistros, array("fecha"			=>	$line_dev[0],
										"codigo"		=>	$line_dev[1],
										"descripcion"	=>	$line_dev[2],
										"nu"			=>	$line_dev[3],
										"guia" 			=> 	$line_dev[4],
										"tarjeta" 		=> 	'',
										"movim"	 		=> 	'DEVOLUCION DE VENDEDOR',
										"cantidad" 		=> 	$line_dev[5],
										"usuario"		=> 	$line_dev[6]));
		
		$total_n = $total_n - $line_dev[5];
	}
	//USADO
	$sql_dev 	= "select 
						DATE_FORMAT(b.movim_fecha,'%d/%m/%Y') as fecha,
						a.mdet_codigo as codigo,
						a.mdet_desc as descripcion,
						a.mdet_nu as nu,
						b.movim_ncorr as guia,
						a.mdet_cantidad as cantidad,
						b.usu_id as usuario
						
						from 
						sgcompras.movim_detalle a, sgcompras.movim b
						
						where
						a.mdet_codigo = '".$codigo."' and
						a.mdet_nu = 'U' and
						a.movim_ncorr = b.movim_ncorr and
						b.movim_tipo = '4' and
						b.empe_rut = '".$empresa."' and
						b.vend_ncorr = '".$cobrador."' and
						b.movim_fecha >= '".$fecha1_1."' and $and
						b.movim_estado = 'FINALIZADO'";
	$res_dev 	= 	mysql_query($sql_dev, $conexion);
	while ($line_dev = mysql_fetch_row($res_dev)) {
		array_push($arrRegistros, array("fecha"			=>	$line_dev[0],
										"codigo"		=>	$line_dev[1],
										"descripcion"	=>	$line_dev[2],
										"nu"			=>	$line_dev[3],
										"guia" 			=> 	$line_dev[4],
										"tarjeta" 		=> 	'',
										"movim"	 		=> 	'DEVOLUCION DE VENDEDOR',
										"cantidad" 		=> 	$line_dev[5],
										"usuario"		=> 	$line_dev[6]));
	
		$total_u = $total_u - $line_dev[5];
	}
	//fin
	
	
	//busca las rebajas de vendedor en el periodo (movim 10) rebajas por devoluciones de vendedor
	//NUEVO
	$sql_dev 	= "select 
						DATE_FORMAT(b.movim_fecha,'%d/%m/%Y') as fecha,
						a.mdet_codigo as codigo,
						a.mdet_desc as descripcion,
						a.mdet_nu as nu,
						b.movim_ncorr as guia,
						a.mdet_cantidad as cantidad,
						b.usu_id as usuario
						
						from 
						sgcompras.movim_detalle a, sgcompras.movim b
						
						where
						a.mdet_codigo = '".$codigo."' and
						a.mdet_nu = 'N' and
						a.movim_ncorr = b.movim_ncorr and
						b.movim_tipo = '10' and
						b.empe_rut = '".$empresa."' and
						b.vend_ncorr = '".$cobrador."' and
						b.movim_fecha >= '".$fecha1_1."' and $and
						b.movim_estado = 'FINALIZADO'";
	$res_dev 	= 	mysql_query($sql_dev, $conexion);
	while ($line_dev = mysql_fetch_row($res_dev)) {
		array_push($arrRegistros, array("fecha"			=>	$line_dev[0],
										"codigo"		=>	$line_dev[1],
										"descripcion"	=>	$line_dev[2],
										"nu"			=>	$line_dev[3],
										"guia" 			=> 	$line_dev[4],
										"tarjeta" 		=> 	'',
										"movim"	 		=> 	'REBAJA DE VENDEDOR (NO AFECTA A BODEGA)',
										"cantidad" 		=> 	$line_dev[5],
										"usuario"		=> 	$line_dev[6]));
		
		$total_n = $total_n - $line_dev[5];
	}
	//USADO
	$sql_dev 	= "select 
						DATE_FORMAT(b.movim_fecha,'%d/%m/%Y') as fecha,
						a.mdet_codigo as codigo,
						a.mdet_desc as descripcion,
						a.mdet_nu as nu,
						b.movim_ncorr as guia,
						a.mdet_cantidad as cantidad,
						b.usu_id as usuario
						
						from 
						sgcompras.movim_detalle a, sgcompras.movim b
						
						where
						a.mdet_codigo = '".$codigo."' and
						a.mdet_nu = 'U' and
						a.movim_ncorr = b.movim_ncorr and
						b.movim_tipo = '10' and
						b.empe_rut = '".$empresa."' and
						b.vend_ncorr = '".$cobrador."' and
						b.movim_fecha >= '".$fecha1_1."' and $and
						b.movim_estado = 'FINALIZADO'";
	$res_dev 	= 	mysql_query($sql_dev, $conexion);
	while ($line_dev = mysql_fetch_row($res_dev)) {
		array_push($arrRegistros, array("fecha"			=>	$line_dev[0],
										"codigo"		=>	$line_dev[1],
										"descripcion"	=>	$line_dev[2],
										"nu"			=>	$line_dev[3],
										"guia" 			=> 	$line_dev[4],
										"tarjeta" 		=> 	'',
										"movim"	 		=> 	'REBAJA DE VENDEDOR (NO AFECTA A BODEGA)',
										"cantidad" 		=> 	$line_dev[5],
										"usuario"		=> 	$line_dev[6]));
	
		$total_u = $total_u - $line_dev[5];
	}
	//fin
	
	//busca las rebajas por ventas nulas
	//NUEVO
	$sql_rebajas 	= "select 
						DATE_FORMAT(b.vent_fecha,'%d/%m/%Y') as fecha,
						a.arti_codigo_largo as codigo,
						a.arti_desc as descripcion,
						a.arti_nu as nu,
						b.vent_num_folio as tarjeta,
						a.vent_cant as cantidad,
						b.usua_login as usuario
	
						from 
						sgyonley.ventas_detalle_antigua a, sgyonley.ventas_antigua b
						
						where
						a.arti_codigo_largo = '".$codigo."' and
						a.arti_nu = 'N' and
						a.vent_ncorr = b.vent_num_folio and
						b.empe_rut = '".$empresa."' and
						b.vend_ncorr = '".$cobrador."' and
						b.vent_fecha >= '".$fecha1_1."' and $and_1
						b.vent_estado = 'FINALIZADA' and
						b.vent_estado_ingreso = 'N'";
	
	
	$res_rebajas 	= 	mysql_query($sql_rebajas, $conexion);
	while ($line_rebajas = mysql_fetch_row($res_rebajas)) {
		array_push($arrRegistros, array("fecha"			=>	$line_rebajas[0],
										"codigo"		=>	$line_rebajas[1],
										"descripcion"	=>	$line_rebajas[2],
										"nu"			=>	$line_rebajas[3],
										"guia" 			=> 	'',
										"tarjeta" 		=> 	$line_rebajas[4],
										"movim"	 		=> 	'VENTA NULA',
										"cantidad" 		=> 	$line_rebajas[5],
										"usuario"		=> 	$line_rebajas[6]));
		$i++;
		//$total_n = $total_n + $line_rebajas[5];
	
	}
	//USADO
	$sql_rebajas 	= "select 
						DATE_FORMAT(b.vent_fecha,'%d/%m/%Y') as fecha,
						a.arti_codigo_largo as codigo,
						a.arti_desc as descripcion,
						a.arti_nu as nu,
						b.vent_num_folio as tarjeta,
						a.vent_cant as cantidad,
						b.usua_login as usuario
	
						from 
						sgyonley.ventas_detalle_antigua a, sgyonley.ventas_antigua b
						
						where
						a.arti_codigo_largo = '".$codigo."' and
						a.arti_nu = 'U' and
						a.vent_ncorr = b.vent_num_folio and
						b.empe_rut = '".$empresa."' and
						b.vend_ncorr = '".$cobrador."' and
						b.vent_fecha >= '".$fecha1_1."' and $and_1
						b.vent_estado = 'FINALIZADA' and
						b.vent_estado_ingreso = 'N'";
	
	
	$res_rebajas 	= 	mysql_query($sql_rebajas, $conexion);
	while ($line_rebajas = mysql_fetch_row($res_rebajas)) {
		array_push($arrRegistros, array("fecha"			=>	$line_rebajas[0],
										"codigo"		=>	$line_rebajas[1],
										"descripcion"	=>	$line_rebajas[2],
										"nu"			=>	$line_rebajas[3],
										"guia" 			=> 	'',
										"tarjeta" 		=> 	$line_rebajas[4],
										"movim"	 		=> 	'VENTA NULA',
										"cantidad" 		=> 	$line_rebajas[5],
										"usuario"		=> 	$line_rebajas[6]));
		$i++;
		//$total_u = $total_u + $line_rebajas[5];
	
	}
	
	$miSmarty->assign('arrRegistros', $arrRegistros);
	$miSmarty->assign('TOTAL_N', $total_n);
	$miSmarty->assign('TOTAL_U', $total_u);
	$miSmarty->assign('TOTAL', $total_n + $total_u);
	
	$objResponse->addAssign("divabonos", "innerHTML", $miSmarty->fetch('sg_existencia_movimientos_vendedor_detalle.2_list.tpl'));
	
	$objResponse->addScript("document.getElementById('divabonos').style.display='block';");
	
	return $objResponse->getXML();
}

$xajax->registerFunction("Grabar");

$xajax->processRequests();
$miSmarty->assign('xajax_js', $xajax->getJavascript());

$miSmarty->assign('CODIGO', $_GET["codigo"]);
$miSmarty->assign('DESCRIPCION', $_GET["descripcion"]);
$miSmarty->assign('FECHA1', $_GET["fecha1"]);
$miSmarty->assign('FECHA2', $_GET["fecha2"]);
$miSmarty->assign('COBRADOR', $_GET["cobrador"]);
$miSmarty->assign('EMPRESA', $_GET["empresa"]);
$miSmarty->assign('MES', $_GET["mes"]);
$miSmarty->assign('ANIO', $_GET["anio"]);

$miSmarty->display('sg_existencia_movimientos_vendedor_detalle.2.tpl');

?>

