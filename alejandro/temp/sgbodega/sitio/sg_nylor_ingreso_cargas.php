<?php
session_start();

require_once 'includes/xajax/xajax.inc.php'; //archivo de configuracion de ajax
include "../includes/php/conf_smarty.php";//archivo de configuracion de smarty
include "../includes/php/conf_bd.php"; //archivo de coneccion al servidor y base de datos
//include "../includes/php/conf_bd_antigua.php"; //archivo de coneccion al servidor de yonley
include "../includes/php/validaciones.php"; 

$xajax = new xajax();

$xajax->setRequestURI("sg_nylor_ingreso_cargas.php");
$xajax->setCharEncoding("ISO-8859-1");
$xajax->decodeUTF8InputOn();

function CargaListado($data){
    global $conexion;
	global $miSmarty;
    $objResponse = new xajaxResponse('ISO-8859-1');
    mysql_select_db('sgyonley', $conexion);
    
	$objResponse->addAssign("divresultado", "innerHTML", "");
	
	$cod_vendedor 	= 	$data["OBLI-txtCodVendedor"];
	$vendedor 		= 	$data["OBLI-txtDescVendedor"];
	$v_inicio		=  	$data["OBLI-txtFechaInicio"];
	$v_termino		=  	$data["OBLI-txtFechaTermino"];
	$empresa 		= 	$_SESSION["alycar_sgyonley_empresa_rut"];
	$filtro_estado	= 	$data["cboEstado"];
	$fecha_actual	=	date("Y-m-d");
	$folio			=	$data["OBLI-txtFolio"];
	
	$sql = "select
			vent_ncorr as ncorr,
			vent_num_folio as folio,
			sect_ncorr as sector,
			DATE_FORMAT(vent_fecha,'%d/%m/%Y') as fecha,
			vent_num_boleta as num_boleta,
			clie_rut as cliente,
			vent_total_venta as total_venta,
			vent_pie as pie,
			vent_saldo as saldo,
			vent_valor_cuotas as valor_cuota,
			vent_estado_ingreso as estado_venta,
			vent_fecha,
			vend_ncorr as cod_vendedor
			
			from 
			ventas_antigua
			
			where 
			
			vent_num_folio = '".$folio."' and
			empe_rut = '".$empresa."' and
			vent_estado_ingreso = 'A' and
			vent_estado = 'FINALIZADA' and
			
			EXISTS
			(SELECT caut_folio FROM cargas_autorizadas 
			WHERE 
			caut_empresa = '".$empresa."' and 
			caut_folio = ventas_antigua.vent_num_folio)

			order by vent_num_folio";
	
	$res = mysql_query($sql, $conexion);
	
	if (mysql_num_rows($res) > 0){
										
		
		$i					=	1;
		$arrRegistros 		= 	array();
		$arrDetalle 		= 	array();
		$total_articulos 	= 	0;
		$total_ventas		=	0;
		
		while ($line = mysql_fetch_row($res)) {
			
			$folio		=	$line[1];
			
			// busca el cliente
			$sql_cli = "select clie_nombre from clientes where clie_rut = '".$line[5]."'";
			$res_cli = mysql_query($sql_cli, $conexion);
			$line_cli = mysql_fetch_row($res_cli);
			$cliente = $line_cli[0];
				
			$cod_vendedor = $line[12];
			
			// busca el vendedor
			$sql_vend = "select ve_vendedor from sgbodega.vendedores where ve_codigo = '".$cod_vendedor."' and ve_empresa = '".$empresa."'";
			$res_vend = mysql_query($sql_vend, $conexion);
			$nombre_vendedor = @mysql_result($res_vend,0,"ve_vendedor");
			
			$estado_venta = '';
			if (($line[10] != 'A') AND ($line[10] != 'N') AND ($line[10] != 'B') AND ($line[10] != 'D') AND ($line[10] != 'P'))
				{$estado_venta 	= 	'ACTIVA';}		//#FFFF00
			
			if ($line[10] == 'A'){$estado_venta 	= 	'POR APROBAR';}	//#00CC00
			if ($line[10] == 'N'){$estado_venta 	= 	'NULA';}		//#FF0000
			if ($line[10] == 'B'){$estado_venta 	= 	'DE BAJA';}		//#FF99CC
			if ($line[10] == 'D'){$estado_venta 	= 	'DEVOLUCION';}	//#FF9900
			if ($line[10] == 'P'){$estado_venta 	= 	'PAGADA';}		//#0066FF
			
			// se agrega nuevo filtro que une ventas activas con canceladas (06/10/2010)
			$estado_venta_doble = '';
			if ($filtro_estado == 'AP'){
				if ($estado_venta == 'ACTIVA'){
					$estado_venta_doble = 'AP';
				}
				if ($estado_venta == 'PAGADA'){
					$estado_venta_doble = 'AP';
				}
			}
			
			if (($filtro_estado == $estado_venta) OR ($filtro_estado == $estado_venta_doble) OR ($filtro_estado == 'TODAS')){
			
				// busca la aprobacion de la venta
					$sql_ap = "select 
								DATE_FORMAT(AP_FECAPROBACION,'%d/%m/%Y') as fecha_act,
								DATE_FORMAT(AP_FECEMISION,'%d/%m/%Y') as fecha_tarj
								from aprobaciones 
								where
								AP_FOLIO = '".$line[1]."'";
					$res_ap = mysql_query($sql_ap, $conexion);
					if (mysql_num_rows($res_ap) > 0){
						$line_ap = mysql_fetch_row($res_ap);
						$fecha_activacion = $line_ap[0];
						$fecha_tarjeta = $line_ap[1];
					}else{
						$fecha_activacion = "";
						$fecha_tarjeta = $line[3];
					}	
				// fin busqueda de aprobacion
				
				if ($estado_venta != 'NULA'){
					$total_ventas	=	$total_ventas + $line[6];
				}
				
				array_push($arrRegistros, array("item" 				=> 	$i, 
												"ncorr" 			=> 	$line[0], 
												"folio" 			=> 	$line[1], 
												"sector"			=> 	$line[2], 
												"fecha_activacion"	=> 	$fecha_activacion,  
												"fecha_tarjeta"		=> 	$fecha_tarjeta,
												"num_boleta"		=> 	$line[4], 
												"cliente"			=> 	$cliente,  
												"total_venta"		=> 	$line[6],  
												"pie"				=> 	$line[7],  
												"saldo"				=> 	$line[8],  
												"valor_cuota"		=> 	$line[9],
												"estado_venta"		=> 	$estado_venta));
				
				// busca los productos de cada folio.
				$sql_p = "select
						vdet_ncorr as ncorr_art,
						arti_codigo_largo as codigo,
						arti_desc as descripcion,
						arti_nu as nu,
						vent_cant as cantidad,
						vent_valor_venta as precio,
						vent_sub_total as total
							
							FROM 
							ventas_detalle_antigua
							
						WHERE
						vent_ncorr = '".$line[1]."'";
				
				$res_p = mysql_query($sql_p, $conexion);
				
				while ($line_p = mysql_fetch_row($res_p)) {
						
					// busca el total entregado por articulo
					$vdet_ncorr		= 	$line_p[0];
					$codigo 		= 	$line_p[1];
					$pend_entrega 	= 	$line_p[4];
					
					$sql_obs = "select * 
								from ventas_detalle_obs 
								where vent_det_ncorr = '".$vdet_ncorr."' 
								order by vdo_ncorr ";
					$res_obs = mysql_query($sql_obs,$conexion);
					$row_obs = mysql_fetch_array($res_obs);
					
					$observacion = $row_obs['observacion'];
					
					// muestra solo los productos autorizados de la venta
					$sql_pau = "select caut_ncorr from cargas_autorizadas where caut_empresa = '".$empresa."' and caut_folio = '".$folio."' and vdet_ncorr = '".$vdet_ncorr."'";
					$res_pau = mysql_query($sql_pau,$conexion);
					if (mysql_num_rows($res_pau) > 0){
					
						$sql_te 			= 	"select sum(crea_cant_cargada) as total_cargado from cargas_realizadas 
													where crea_empresa = '".$empresa."' and crea_folio = '".$folio."' and crea_codigo = '".$codigo."'";
						$res_te 			=	mysql_query($sql_te,$conexion);
						$total_entregado 	= 	@mysql_result($res_te,0,"total_cargado");
						
						$pend_entrega		=	$pend_entrega - $total_entregado;
						
						if ($pend_entrega < 1){
							$estado = 'ENTREGADO';
						}else{
							$estado = 'PENDIENTE';
						}
						
						//if ($pend_entrega > 0){
							// no debe mostrar los articulos ya entregados en un 100%
							array_push($arrDetalle, array(	"ncorr" 		=> 	$line[0], 
															"ncorr_art" 	=> 	$line_p[0], 
															"codigo" 		=> 	$line_p[1], 
															"descripcion"	=> 	$line_p[2], 
															"nu"			=> 	$line_p[3], 
															"cantidad"		=> 	$line_p[4],  
															"pend_entrega"	=> 	$pend_entrega,
															"estado"		=>	$estado,
															"tiempo_espera"	=>	$da,			
															"precio"		=> 	$line_p[5], 
															"total"			=> 	$line_p[6], 
															"observacion"	=> 	$observacion));
					}	
				}
				
				$i++;
			}	
		}
		
		$miSmarty->assign('VENDEDOR', $cod_vendedor." ".$nombre_vendedor);
		$miSmarty->assign('DESDE', $v_inicio);
		$miSmarty->assign('HASTA', $v_termino);
		$miSmarty->assign('TOTAL_ARTICULOS', $total_articulos);
		$miSmarty->assign('TOTAL_TARJETAS', $i - 1);
		$miSmarty->assign('TOTAL_VENTAS', $total_ventas);
		
		$miSmarty->assign('arrRegistros', $arrRegistros);
		$miSmarty->assign('arrDetalle', $arrDetalle);
		
		$objResponse->addAssign("divresultado", "innerHTML", $miSmarty->fetch('sg_nylor_ingreso_cargas_list.tpl'));
		
	
	}else{
		
		$objResponse->addAssign("divresultado", "innerHTML", "No Se Encontraron Registros.");
		
	}	
	
	return $objResponse->getXML();
}

function VerificaCantidad($data, $objeto, $pend_entrega, $codigo, $descripcion){
    global $conexion;
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	$cant_ingresada 	= 	$data["$objeto"];
	
	if ($cant_ingresada > $pend_entrega){
		$objResponse->addScript("alert('Cantidad Incorrecta')");
		$objResponse->addScript("document.getElementById('$objeto').focus();");
		$objResponse->addScript("document.getElementById('$objeto').select();");
	}
	
	return $objResponse->getXML();
}

function IngresaCargas($data){
    global $conexion;
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	$crea_empresa		=	$_SESSION["alycar_sgyonley_empresa_rut"];
	$crea_folio			=	$data["OBLI-txtFolio"];
	$crea_fecha_dig		=	date("Y-m-d H:i:s");
	$crea_usuario		=	$_SESSION["alycar_sgyonley_usuario"];
	$ingresa			=	'SI';
	
	//VERIFICA SI SE INGRESARON BIEN LAS CANTIDADES
	$sql_ve = "select
				a.vdet_ncorr as ncorr_art,
				a.arti_codigo_largo as codigo,
				a.vent_cant as cantidad,
				a.arti_nu as nu
				
				from
				ventas_detalle_antigua a, ventas_antigua b
				
				where
				a.vent_ncorr = '".$crea_folio."' and
				a.vent_ncorr = b.vent_num_folio and
				b.empe_rut = '".$crea_empresa."'";
	
	$res_ve = mysql_query($sql_ve, $conexion);
	
	while ($line_ve = mysql_fetch_row($res_ve)) {
			
		$ncorr_art			=	$line_ve[0];
		$crea_codigo		=	$line_ve[1];
		$crea_pend_entrega	=	$line_ve[2];
		$objeto				=	$ncorr_art."txtCantCarg";
		$crea_cant_cargada	=	$data["$objeto"];
		
		if ($crea_cant_cargada > $crea_pend_entrega){
			$ingresa = 'NO';
		}
		
	}
	
	if ($ingresa == 'NO'){
		$objResponse->addScript("alert('Existen Cantidades Incorrectas, Verifique...')");
	}
	
	if ($ingresa == 'SI'){

		// busca los productos de cada folio.
		$sql = "select
					a.vdet_ncorr as ncorr_art,
					a.arti_codigo_largo as codigo,
					a.vent_cant as cantidad,
					a.arti_nu as nu
					
					from
					ventas_detalle_antigua a, ventas_antigua b
					
					where
					a.vent_ncorr = '".$crea_folio."' and
					a.vent_ncorr = b.vent_num_folio and
					b.empe_rut = '".$crea_empresa."'";
		
		$res = mysql_query($sql, $conexion);
		
		while ($line = mysql_fetch_row($res)) {
				
			// busca el total entregado por articulo para el calculo del crea_pend_entrega
			
			$ncorr_art			=	$line[0];
			$crea_codigo		=	$line[1];
			$crea_pend_entrega	=	$line[2];
			$objeto				=	$ncorr_art."txtCantCarg";
			$crea_cant_cargada	=	$data["$objeto"];
			
			// muestra solo los productos autorizados de la venta
			$sql_pau = "select caut_ncorr from cargas_autorizadas where caut_empresa = '".$crea_empresa."' and caut_folio = '".$crea_folio."' and vdet_ncorr = '".$ncorr_art."'";
			$res_pau = mysql_query($sql_pau,$conexion);
			if (mysql_num_rows($res_pau) > 0){
				
				$sql_ing = "insert into cargas_realizadas (crea_empresa,crea_folio,vdet_ncorr,crea_codigo,crea_pend_entrega,crea_cant_cargada,crea_fecha_dig,crea_usuario)
							values ('".$crea_empresa."','".$crea_folio."','".$ncorr_art."','".$crea_codigo."','".$crea_pend_entrega."','".$crea_cant_cargada."',
									'".$crea_fecha_dig."','".$crea_usuario."')";
					
				$res_ing = mysql_query($sql_ing,$conexion);
			}
			
		}
		
		$objResponse->addScript("alert('Datos Grabados Correctamente')");
		
		$objResponse->addScript("window.document.Form1.submit();");		
	}
	
	return $objResponse->getXML();
}

function CargaPagina($data){
    global $conexion;
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	$objResponse->addScript("document.getElementById('OBLI-txtFolio').focus();");
	
	return $objResponse->getXML();
}
          

$xajax->registerFunction("CargaListado");
$xajax->registerFunction("IngresaCargas");
$xajax->registerFunction("CargaPagina");
$xajax->registerFunction("VerificaCantidad");


$xajax->processRequests();
$miSmarty->assign('xajax_js', $xajax->getJavascript());

$miSmarty->display('sg_nylor_ingreso_cargas.tpl');

?>

