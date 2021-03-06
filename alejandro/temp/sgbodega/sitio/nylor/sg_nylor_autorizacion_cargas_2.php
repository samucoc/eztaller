<?php
session_start();

require_once 'includes/xajax/xajax.inc.php'; //archivo de configuracion de ajax
include "../includes/php/conf_smarty.php";//archivo de configuracion de smarty
include "../includes/php/conf_bd.php"; //archivo de coneccion al servidor y base de datos
//include "../includes/php/conf_bd_antigua.php"; //archivo de coneccion al servidor de yonley
include "../includes/php/validaciones.php"; 

$xajax = new xajax();

$xajax->setRequestURI("sg_nylor_autorizacion_cargas_2.php");
$xajax->setCharEncoding("ISO-8859-1");
$xajax->decodeUTF8InputOn();

function CargaListado($data){
    global $conexion;
	global $miSmarty;
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	$objResponse->addAssign("divresultado", "innerHTML", "");
	
	$empresa 		= 	$_SESSION["alycar_sgyonley_empresa_rut"];
	$empe_ncorr		= 	$_SESSION["alycar_sgyonley_empresa"];
	$cod_vendedor 	= 	$data["txtCodVendedor"];
	$vendedor 		= 	$data["txtDescVendedor"];
	
	$and="";
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
				vend_ncorr
				
				from 
				sgyonley.ventas_antigua
				
				where 
				$and
				empe_rut = '".$empresa."' and
				vent_estado_ingreso = 'A' and
				vent_estado = 'FINALIZADA' 
				
				order by vent_num_folio";
		
		$res = mysql_query($sql, $conexion);
		
		if (mysql_num_rows($res) > 0){
			
			$i			=	1;
			$arrRegistros 		= 	array();
			$arrDetalle 		= 	array();
			$total_articulos 	= 	0;
			$total_ventas		=	0;
			
			while ($line = mysql_fetch_row($res)) {
				
				$vend_ncorr =	$line[11];
				
				// busca al vendedor
					$sql_vend = "select ve_vendedor from sgbodega.vendedores where ve_codigo = '".$vend_ncorr."' and ve_empresa = '".$empresa."'";
					$res_vend = mysql_query($sql_vend,$conexion);
					$nombre_vendedor = @mysql_result($res_vend,0,"ve_vendedor");
				
				// busca el cliente
				$sql_cli = "select clie_nombre from sgyonley.$tabla_clientes where clie_rut = '".$line[5]."'";
				$res_cli = mysql_query($sql_cli, $conexion);
				$tabla_clientes ="";
				if (@mysql_num_rows($res_cli) < 1){
					$sql2 = "select vent_num_folio, sect_ncorr, clie_rut from sgyonley.ventas_antigua where clie_rut = '".$line[5]."' AND empe_rut = '".$empresa."' order by vent_ncorr desc";
					$res2 = mysql_query($sql2, $conexion);
					$encontrado = 'NO';
					while ($line2 = mysql_fetch_row($res2)) {
						if ($encontrado == 'NO'){
							$sector = trim($line2[1]);
							if (strlen($sector) == 1){$sector = '0'.$sector;}
							$tabla_cli = '0'.$empe_ncorr.'_clientes'.$sector;
							$sql_cl = "select clie_ncorr from sgyonley.$tabla_cli where clie_rut = '".$line[5]."'";
							$res_cl = mysql_query($sql_cl,$conexion);
							if (@mysql_num_rows($res_cl) > 0){
								$tabla_clientes =	$tabla_cli;
								$encontrado = 'SI';
							}
						}
					}
					$sql_cli = "select clie_nombre from sgyonley.$tabla_clientes where clie_rut = '".$line[5]."'";
					$res_cli = mysql_query($sql_cli, $conexion);
					if (@mysql_num_rows($res_cli) < 1){
						$sql_cli = "select clie_nombre from sgyonley.clientes where clie_rut = '".$line[5]."'";
						$res_cli = mysql_query($sql_cli, $conexion);
					}	
				}	
				
				$line_cli = mysql_fetch_row($res_cli);
				$cliente = $line_cli[0]; //"HABLO EN SERIO, EL CLIENTE FUE ELIMINADO";
				
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
									from sgyonley.aprobaciones 
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
					$sql_busqueda = "SELECT * 
										FROM  sgyonley.cargas_autorizadas
										where vdet_ncorr in (select	 distinct vdet_ncorr
															FROM 	 ventas_detalle_antigua
															WHERE
															vent_ncorr = '".$line[1]."')
												";
					$res_busqueda = mysql_query($sql_busqueda,$conexion);
					
					$valor_auto = mysql_num_rows($res_busqueda);
					$sql_busqueda_1 = "SELECT * 
											FROM  sgyonley.cargas_eliminadas
											where vdet_ncorr in (select	 distinct vdet_ncorr
															FROM 	 ventas_detalle_antigua
															WHERE
															vent_ncorr = '".$line[1]."')
													";
					$res_busqueda_1 = mysql_query($sql_busqueda_1,$conexion);
					$valor_elimi = mysql_num_rows($res_busqueda_1);
					
					$sql_total = " SELECT COUNT(distinct vdet_ncorr )  as contador
									FROM sgyonley.ventas_detalle_antigua
									WHERE vent_ncorr =  '".$line[1]."'";
					$res_total = mysql_query($sql_total,$conexion);
					$row_total = mysql_fetch_array($res_total);
					
					$valor_total = $row_total['contador'];
					
						if ($valor_total > ($valor_auto+$valor_elimi)){
							array_push($arrRegistros, array("item" 				=> 	$i, 
															"ncorr" 			=> 	$line[0], 
															"folio" 			=> 	$line[1], 
															"sector"			=> 	$line[2], 
															"vend_ncorr"		=> 	$vend_ncorr,  
															"nombre_vendedor"	=> 	$nombre_vendedor,  
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
									vdet_ncorr,
									arti_codigo_largo as codigo,
									arti_desc as descripcion,
									arti_nu as nu,
									vent_cant as cantidad,
									vent_valor_venta as precio,
									vent_sub_total as total,
									observacion
									
									FROM 
									sgyonley.ventas_detalle_antigua
										left join sgyonley.ventas_detalle_obs
											on sgyonley.ventas_detalle_antigua.vdet_ncorr = sgyonley.ventas_detalle_obs.vent_det_ncorr
									WHERE
									vent_ncorr = '".$line[1]."' ";
							
							$res_p = mysql_query($sql_p, $conexion);
							
							while ($line_p = mysql_fetch_row($res_p)) {
								
								$sql_busqueda = "SELECT * 
													FROM  sgyonley.cargas_autorizadas
													where vdet_ncorr = '".$line_p[0]."' ";
								$res_busqueda = mysql_query($sql_busqueda,$conexion);
								
								if (mysql_num_rows($res_busqueda)==0){
									$sql_busqueda_1 = "SELECT * 
											FROM  sgyonley.cargas_eliminadas
											where vdet_ncorr = '".$line_p[0]."' ";
									$res_busqueda_1 = mysql_query($sql_busqueda_1,$conexion);
									
									if (mysql_num_rows($res_busqueda_1)==0){
										
												$aut 		= 	'NO';
												$vdet_ncorr = 	$line_p[0];
												$vdet_ncorr = 	$line_p[7];
												
												$sql_pd = "select caut_fecha_dig as fecha_aut from sgyonley.cargas_autorizadas where vdet_ncorr = '".$vdet_ncorr."'";
												$res_pd = mysql_query($sql_pd,$conexion);
												
												
												if (mysql_num_rows($res_pd) > 0){
													$aut 		= 	'SI';
													$fecha_aut 	= 	@mysql_result($res_pd,0,"fecha_aut");
												}
												
												array_push($arrDetalle, array(	"ncorr" 		=> 	$line[0], 
																				"vdet_ncorr" 	=> 	$line_p[0],
																				"codigo" 		=> 	$line_p[1], 
																				"descripcion"	=> 	$line_p[2], 
																				"nu"			=> 	$line_p[3], 
																				"cantidad"		=> 	$line_p[4],  
																				"precio"		=> 	$line_p[5], 
																				"aut"			=>	$aut,
																				"fecha_aut"		=>	$fecha_aut,
																				"total"			=> 	$line_p[6],
																				"observacion"	=> 	$line_p[7]));
									
								}
							}
						}
					}
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
			
			$objResponse->addAssign("divresultado", "innerHTML", $miSmarty->fetch('sg_nylor_autorizacion_cargas_2_list.tpl'));
		
		
		}else{
			
			$objResponse->addAssign("divresultado", "innerHTML", "No Se Encontraron Registros.");
			
		}	
	
	
	return $objResponse->getXML();
}

function AutorizaCarga($data, $folio, $ncorr,$codigo){
    global $conexion;
    $objResponse = new xajaxResponse('ISO-8859-1');
	$observacion = $data['observacion_'.$folio.'_'.$codigo]; 
	$objResponse->addScript("confirmacion = confirm('\BFConfirma Autorizacion Carga?');
		if (confirmacion == true)
		{
			xajax_AutorizaCarga_1(xajax.getFormValues('Form1'),'$folio','$ncorr','$observacion');
		}
		");
	
	return $objResponse->getXML();
}


function EliminaCarga($data, $folio, $ncorr,$codigo){
    global $conexion;
    $objResponse = new xajaxResponse('ISO-8859-1');
	$objResponse->addScript("confirmacion = confirm('\BFConfirma Eliminacion Carga?');
		if (confirmacion == true)
		{
			xajax_EliminaCarga_1(xajax.getFormValues('Form1'),'$folio','$ncorr');
		}
		");
	
	return $objResponse->getXML();
}


function AutorizaCarga_1($data, $folio, $ncorr,$observacion){
    global $conexion;
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	$caut_empresa 		= 	$_SESSION["alycar_sgyonley_empresa_rut"];
	$caut_folio 		= 	$folio;
	$caut_usuario 		= 	$_SESSION["alycar_sgyonley_usuario"];
	$caut_fecha_dig		= 	date("Y-m-d H:i:s");
	
	$sql = "insert into sgyonley.cargas_autorizadas (caut_empresa,caut_folio,vdet_ncorr,caut_usuario,caut_fecha_dig)
			values ('".$caut_empresa."','".$caut_folio."','".$ncorr."','".$caut_usuario."','".$caut_fecha_dig."')";
	
	$res = mysql_query($sql,$conexion);
	
	$sql = "select observacion 
				from sgyonley.ventas_detalle_obs
				where vent_det_ncorr = '".$ncorr."'";
	$res = mysql_query($sql,$conexion);
	$row = mysql_fetch_array($res);
	
	$observacion = $observacion." - ".$row['observacion'];
	
	$sql = "update sgyonley.ventas_detalle_obs 
				set observacion = '".$observacion."'
				where vent_det_ncorr = '".$ncorr."'";
	
	$res = mysql_query($sql,$conexion);
	
	// busca el producto
	$sql_pd = "select arti_codigo_largo as codigo, arti_desc as descripcion from sgyonley.ventas_detalle_antigua where vdet_ncorr = '".$ncorr."'";
	$res_pd = mysql_query($sql_pd,$conexion);
	$producto = @mysql_result($res_pd,0,"codigo")." ".@mysql_result($res_pd,0,"descripcion");
	
	$objResponse->addScript("alert('Se Ha Autorizado la Carga del Producto $producto para el Folio: $caut_folio.')");
	
	$objResponse->addScript("xajax_CargaListado(xajax.getFormValues('Form1'))");
	
	return $objResponse->getXML();
}


function EliminaCarga_1($data, $folio, $ncorr){
    global $conexion;
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	$caut_empresa 		= 	$_SESSION["alycar_sgyonley_empresa_rut"];
	$caut_folio 		= 	$folio;
	$caut_usuario 		= 	$_SESSION["alycar_sgyonley_usuario"];
	$caut_fecha_dig		= 	date("Y-m-d H:i:s");
	
	$sql = "insert into sgyonley.cargas_eliminadas (celi_empresa,celi_folio,vdet_ncorr,celi_usuario,celi_fecha_dig)
			values ('".$caut_empresa."','".$caut_folio."','".$ncorr."','".$caut_usuario."','".$caut_fecha_dig."')";
	
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
	
	$objResponse->addScript("showPopWin('sg_aprobar_ventas_aprobar.php?folio=$folio', 'Aprobaci\F3n de Venta', 600, 280, null);");
	
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
	$sql = "select sect_ncorr from sgyonley.ventas_antigua where vent_num_folio = '".$ncorr."'";
	$res = mysql_query($sql, $conexion);
	$sector = @mysql_result($res, 0, "sect_ncorr");
	
	//armo la tabla de abonos
	if (strlen($sector) < 2){
		$sector = '0'.$sector;
	}
	
	$tabla_abonos	= 	"0".$_SESSION["alycar_sgyonley_empresa"]."_abonos".$sector;

	// busco los abonos
	//$objResponse->addScript("alert('$ncorr')");

	$sql_ab = "select AB_FOLIO from sgyonley.$tabla_abonos where AB_FOLIO = '".$ncorr."' AND AB_EMPRESA = '".$empresa."' and AB_VALOR > '0' AND (AB_ESTADO != 'E' OR isnull(AB_ESTADO))";
	$res_ab = mysql_query($sql_ab, $conexion);
	if (mysql_num_rows($res_ab) > 0){
		$objResponse->addScript("alert('No Se Puede Eliminar la Venta Porque Ya Tiene Abonos.')");
	}else{	
		
		$objResponse->addScript("confirmacion = confirm('\BF Confirma la Eliminaci\F3n de la Venta ?');
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
	
	$sql = "delete from sgyonley.ventas_antigua where vent_num_folio = '".$ncorr."'";
	$res = mysql_query($sql, $conexion);
	
	$sql_det = "delete from sgyonley.ventas_detalle_antigua where vent_ncorr = '".$ncorr."'";
	$res_det = mysql_query($sql_det, $conexion);
	
	$objResponse->addScript("xajax_CargaListado(xajax.getFormValues('Form1'))");
	
	return $objResponse->getXML();
}

$xajax->registerFunction("CargaListado");
$xajax->registerFunction("MuestraRegistro");
$xajax->registerFunction("CargaDesc");
$xajax->registerFunction("AutorizaCarga");
$xajax->registerFunction("AutorizaCarga_1");
$xajax->registerFunction("EliminaCarga");
$xajax->registerFunction("EliminaCarga_1");
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

$miSmarty->display('sg_nylor_autorizacion_cargas_2.tpl');

?>

