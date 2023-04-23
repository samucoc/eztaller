<?php
session_start();

require_once 'includes/xajax/xajax.inc.php'; //archivo de configuracion de ajax
include "../includes/php/conf_smarty.php";//archivo de configuracion de smarty
include "../includes/php/conf_bd.php"; //archivo de coneccion al servidor y base de datos
//include "../includes/php/conf_bd_antigua.php"; //archivo de coneccion al servidor de yonley
include "../includes/php/validaciones.php"; 

$xajax = new xajax();

$xajax->setRequestURI("sg_nylor_informe_precargas.php");
$xajax->setCharEncoding("ISO-8859-1");
$xajax->decodeUTF8InputOn();

function CargaListado($data){
    global $conexion;
	global $miSmarty;
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	$objResponse->addAssign("divresultado", "innerHTML", "");
	
	$cod_vendedor 	= 	$data["txtCodVendedor"];
	$vendedor 		= 	$data["txtDescVendedor"];
	$v_inicio		=  	$data["OBLI-txtFechaInicio"];
	$v_termino		=  	$data["OBLI-txtFechaTermino"];
	$empresa 		= 	$_SESSION["alycar_sgyonley_empresa_rut"];
	$filtro_estado	= 	$data["cboEstado"];
	$fecha_actual	=	date("Y-m-d");
	
	if ($cod_vendedor != '' && $vendedor != ''){
		$and = "vend_ncorr = '".$cod_vendedor."' and ";
		}
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
				vend_ncorr
				
				from 
				ventas_antigua
				
				where 
				$and
				empe_rut = '".$empresa."' and
				vent_estado_ingreso = 'A' and
				vent_estado = 'FINALIZADA' and
				
				EXISTS
				(SELECT caut_folio FROM cargas_autorizadas 
				WHERE 
				caut_empresa = '".$empresa."' and 
				caut_folio = ventas_antigua.vent_num_folio )

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
				$vent_fecha = 	$line[11];
				$vend_ncorr =	$line[12];
				
				// busca al vendedor
					$sql_vend = "select ve_vendedor from sgbodega.vendedores where ve_codigo = '".$vend_ncorr."' and ve_empresa = '".$empresa."'";
					$res_vend = mysql_query($sql_vend,$conexion);
					$nombre_vendedor = @mysql_result($res_vend,0,"ve_vendedor");
				
				//detecta si el folio tiene todo entregado
					
					// saco el total autorizado
					$total_autorizado = 0;
					$sql_taut = "select vdet_ncorr from cargas_autorizadas where caut_empresa = '".$empresa."' and caut_folio = '".$folio."'";
					$res_taut = mysql_query($sql_taut,$conexion);
					while ($line_taut = mysql_fetch_row($res_taut)) {
							$vdet_ncorr = $line_taut[0];
							
							// busca el total en la venta 
							$sql_tv = "select vent_cant from ventas_detalle_antigua where vdet_ncorr = '".$vdet_ncorr."'";
							$res_tv = mysql_query($sql_tv,$conexion);
							
							$total_autorizado = $total_autorizado + @mysql_result($res_tv,0,"vent_cant");
					}
					
					//saca el total entregado del folio
					$sql_te = "select sum(crea_cant_cargada) as total_entregado from cargas_realizadas where crea_empresa = '".$empresa."' and crea_folio = '".$folio."'";
					$res_te = mysql_query($sql_te,$conexion);
					$total_entregado = @mysql_result($res_te,0,"total_entregado");
					
					if ($total_autorizado >= $total_entregado){
						$folio_entregado = 'NO';
					}else{
						$folio_entregado = 'SI';
					}
						
				//calcula el tiempo de espera (dias)
				$sql_da = "SELECT DATEDIFF('".$fecha_actual."','".$vent_fecha."') as dias_atraso";
				$res_da = mysql_query($sql_da, $conexion);
				$da 	= @mysql_result($res_da,0,"dias_atraso");
				
				// busca el cliente
				$sql_cli = "select clie_nombre from clientes where clie_rut = '".$line[5]."'";
				$res_cli = mysql_query($sql_cli, $conexion);
				$line_cli = mysql_fetch_row($res_cli);
				$cliente = $line_cli[0];
				
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
					
					$sql_pau = "select count(caut_ncorr) as ca 
								from cargas_autorizadas 
								where caut_empresa = '".$empresa."' 
								and caut_folio = '".$folio."' ";
					$res_pau = mysql_query($sql_pau,$conexion);
					$row_pau = mysql_fetch_array($res_pau);
					
					$fila_pendiente = $row_pau['ca'];
					
					$sql_te = "select count(crea_ncorr) as total_cargado 
								from cargas_realizadas 
								where crea_empresa = '".$empresa."' 
									and crea_folio = '".$folio."'
									and crea_pend_entrega = crea_cant_cargada	";
					$res_te 			=	mysql_query($sql_te,$conexion);
					$total_entregado 	= 	@mysql_result($res_te,0,"total_cargado");
					
					$fila_pendiente		=	$fila_pendiente - $total_entregado;
					
					array_push($arrRegistros, array("item" 				=> 	$i, 
													"ncorr" 			=> 	$line[0], 
													"folio" 			=> 	$line[1], 
													"sector"			=> 	$line[2], 
													"folio_entregado"	=>	$folio_entregado,
													"fecha_activacion"	=> 	$fecha_activacion,  
													"fecha_tarjeta"		=> 	$fecha_tarjeta,
													"cod_vendedor"		=> 	$vend_ncorr,  
													"nombre_vendedor"	=> 	$nombre_vendedor,
													"num_boleta"		=> 	$line[4], 
													"cliente"			=> 	$cliente,  
													"total_venta"		=> 	$line[6],  
													"pie"				=> 	$line[7],  
													"saldo"				=> 	$line[8],  
													"valor_cuota"		=> 	$line[9],
													"estado_venta"		=> 	$estado_venta,
													"fila_pendiente"	=>	$fila_pendiente ));
					
					// busca los productos de cada folio.
					$sql_p = "select
							vdet_ncorr,
							arti_codigo_largo as codigo,
							arti_desc as descripcion,
							arti_nu as nu,
							vent_cant as cantidad,
							vent_valor_venta as precio,
							vent_sub_total as total
							
							FROM 
							ventas_detalle_antigua
							
							WHERE
							vent_ncorr = '".$folio."'";
					
					$res_p = mysql_query($sql_p, $conexion);
					
					while ($line_p = mysql_fetch_row($res_p)) {
							
						// busca el total entregado por articulo
						$vdet_ncorr		=	$line_p[0];
						$codigo			=	$line_p[1];
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
								//busca la fecha de la ultima carga
								$sql_uc = "select crea_fecha_dig as fecha_ult_carga from cargas_realizadas
											where crea_empresa = '".$empresa."' and crea_folio = '".$folio."' and crea_codigo = '".$codigo."' order by crea_ncorr desc limit 1";
								$res_uc = mysql_query($sql_uc,$conexion);
								$fecha_ult_carga = @mysql_result($res_uc,0,"fecha_ult_carga");
								
							}else{
								$estado = 'PENDIENTE';
							}
							
							array_push($arrDetalle, array(	"ncorr" 			=> 	$line[0], 
															"codigo" 			=> 	$line_p[1],                                 
															"descripcion"		=> 	$line_p[2], 
															"nu"				=> 	$line_p[3], 
															"cantidad"			=> 	$line_p[4],  
															"pend_entrega"		=> 	$pend_entrega,
															"estado"			=>	$estado,
															"fecha_ult_carga"	=>	$fecha_ult_carga,
															"tiempo_espera"		=>	$da,			
															"precio"			=> 	$line_p[5], 
															"total"				=> 	$line_p[6], 
															"observacion"		=> 	$observacion));
						}	
					}
					
					
					//if ($estado_venta != 'NULA'){
						$i++;
					//}
				}	
			}
			
			$miSmarty->assign('VENDEDOR', $cod_vendedor." ".$vendedor);
			$miSmarty->assign('DESDE', $v_inicio);
			$miSmarty->assign('HASTA', $v_termino);
			$miSmarty->assign('TOTAL_ARTICULOS', $total_articulos);
			$miSmarty->assign('TOTAL_TARJETAS', $i - 1);
			$miSmarty->assign('TOTAL_VENTAS', $total_ventas);
			
			$miSmarty->assign('arrRegistros', $arrRegistros);
			$miSmarty->assign('arrDetalle', $arrDetalle);
			
			$objResponse->addAssign("divresultado", "innerHTML", $miSmarty->fetch('sg_nylor_informe_precargas_list.tpl'));
			
			//llena div para la impresion del formulario de carga
			$objResponse->addAssign("divresultadocarga", "innerHTML", $miSmarty->fetch('sg_nylor_informe_precargas_form_list.tpl'));
		
		
		}else{
			
			$objResponse->addAssign("divresultado", "innerHTML", "No Se Encontraron Registros.");
			
		}	
	return $objResponse->getXML();
}

function AutorizaCarga($data, $folio){
    global $conexion;
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	$caut_empresa 		= 	$_SESSION["alycar_sgyonley_empresa_rut"];
	$caut_folio 		= 	$folio;
	$caut_usuario 		= 	$_SESSION["alycar_sgyonley_usuario"];
	$caut_fecha_dig		= 	date("Y-m-d H:i:s");
	
	$sql = "insert into cargas_autorizadas (caut_empresa,caut_folio,caut_usuario,caut_fecha_dig)
			values ('".$caut_empresa."','".$caut_folio."','".$caut_usuario."','".$caut_fecha_dig."')";
	
	$res = mysql_query($sql,$conexion);
	
	$objResponse->addScript("xajax_CargaListado(xajax.getFormValues('Form1'))");
	
	return $objResponse->getXML();
}

function MuestraRegistro($data, $campo1, $campo2, $obj1, $obj2){
	global $conexion;
	
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	$objResponse->addAssign("$obj1", "value", $campo1);
	$objResponse->addAssign("$obj2", "value", $campo2);
	
	return $objResponse->getXML();
}
function CargaDesc($data, $tabla, $campo1, $campo2, $objeto1, $objeto2, $c_and){
    global $conexion;
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	//mysql_select_db("sgyonley", $conexion);
	
	$ncorr 		= 	$data["$objeto1"];
	
	$sql = "select $campo2 as descripcion from $tabla where $campo1 = '".$ncorr."' $and";
	
	$res = mysql_query($sql, $conexion);
	
	$objResponse->addAssign("$objeto2", "value", @mysql_result($res,0,"descripcion"));
	
	return $objResponse->getXML();
}

function AprobarVenta($data, $folio){
    global $conexion;
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	$objResponse->addScript("showPopWin('sg_aprobar_ventas_aprobar.php?folio=$folio', 'Aprobación de Venta', 600, 280, null);");
	
	return $objResponse->getXML();
}
function CargaPagina($data){
    global $conexion;
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	$cod_vendedor 	= 	$data["OBLI-txtCodVendedor"];
	$vendedor 		= 	$data["OBLI-txtDescVendedor"];
	$v_inicio		=  	$data["OBLI-txtFechaInicio"];
	$v_termino		=  	$data["OBLI-txtFechaTermino"];
	
	if (($cod_vendedor != '') && ($vendedor != '') && ($v_inicio != '') && ($v_termino != '')){
		$objResponse->addScript("xajax_CargaListado(xajax.getFormValues('Form1'))");
	}
	
	$objResponse->addScript("document.getElementById('txtCodVendedor').focus();");
	
	return $objResponse->getXML();
}
          
function ConfirmaEliminaVenta($data, $ncorr){
    global $conexion;
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	$cod_vendedor						=	$data["OBLI-txtCodVendedor"];
	$nombre_vendedor					=	$data["OBLI-txtDescVendedor"];
	$desde								=	$data["OBLI-txtFechaInicio"];
	$hasta								=	$data["OBLI-txtFechaTermino"];
	$empresa 							= 	$_SESSION["alycar_sgyonley_empresa_rut"];
	
	// si la venta tiene abonos no se puede eliminar...
	// busco el sector
	$sql = "select sect_ncorr from ventas_antigua where vent_num_folio = '".$ncorr."'";
	$res = mysql_query($sql, $conexion);
	$sector = @mysql_result($res, 0, "sect_ncorr");
	
	//armo la tabla de abonos
	if (strlen($sector) < 2){
		$sector = '0'.$sector;
	}
	
	$tabla_abonos	= 	"0".$_SESSION["alycar_sgyonley_empresa"]."_abonos".$sector;

	// busco los abonos
	//$objResponse->addScript("alert('$ncorr')");

	$sql_ab = "select AB_FOLIO from $tabla_abonos where AB_FOLIO = '".$ncorr."' AND AB_EMPRESA = '".$empresa."' and AB_VALOR > '0' AND (AB_ESTADO != 'E' OR isnull(AB_ESTADO))";
	$res_ab = mysql_query($sql_ab, $conexion);
	if (mysql_num_rows($res_ab) > 0){
		$objResponse->addScript("alert('No Se Puede Eliminar la Venta Porque Ya Tiene Abonos.')");
	}else{	
		
		$objResponse->addScript("confirmacion = confirm('¿ Confirma la Eliminación de la Venta ?');
		if (confirmacion == true)
		{
			xajax_EliminaVenta(xajax.getFormValues('Form1'), '$ncorr');
		}
		");
	}
	
	return $objResponse->getXML();
}
function EliminaVenta($data, $ncorr){
    global $conexion;
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	$sql = "delete from ventas_antigua where vent_num_folio = '".$ncorr."'";
	$res = mysql_query($sql, $conexion);
	
	$sql_det = "delete from ventas_detalle_antigua where vent_ncorr = '".$ncorr."'";
	$res_det = mysql_query($sql_det, $conexion);
	
	$objResponse->addScript("xajax_CargaListado(xajax.getFormValues('Form1'))");
	
	return $objResponse->getXML();
}

$xajax->registerFunction("CargaListado");
$xajax->registerFunction("MuestraRegistro");
$xajax->registerFunction("CargaDesc");
$xajax->registerFunction("AutorizaCarga");
$xajax->registerFunction("CargaPagina");
$xajax->registerFunction("AprobarVenta");
$xajax->registerFunction("ConfirmaEliminaVenta");
$xajax->registerFunction("EliminaVenta");

$xajax->processRequests();
$miSmarty->assign('xajax_js', $xajax->getJavascript());

$miSmarty->assign('COD_VENDEDOR', $_GET["cod_vendedor"]);
$miSmarty->assign('VENDEDOR', $_GET["nombre_vendedor"]);
$miSmarty->assign('DESDE', $_GET["desde"]);
$miSmarty->assign('HASTA', $_GET["hasta"]);

$miSmarty->display('sg_nylor_informe_precargas.tpl');

?>

