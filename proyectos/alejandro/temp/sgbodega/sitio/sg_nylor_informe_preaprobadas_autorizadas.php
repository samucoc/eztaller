<?php
session_start();

require_once 'includes/xajax/xajax.inc.php'; //archivo de configuracion de ajax
include "../includes/php/conf_smarty.php";//archivo de configuracion de smarty
include "../includes/php/conf_bd.php"; //archivo de coneccion al servidor y base de datos
//include "../includes/php/conf_bd_antigua.php"; //archivo de coneccion al servidor de yonley
include "../includes/php/validaciones.php"; 

$xajax = new xajax();

$xajax->setRequestURI("sg_nylor_informe_preaprobadas_autorizadas.php");
$xajax->setCharEncoding("ISO-8859-1");
$xajax->decodeUTF8InputOn();

function CargaListado($data){
    global $conexion;
    global $miSmarty;
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	$objResponse->addAssign("divresultado", "innerHTML", "");
	
	$cod_vendedor 	= 	$data["txtCodVendedor"];
	$miSmarty->assign('VENDEDOR', $cod_vendedor);
	$vendedor 		= 	$data["txtDescVendedor"];
	$v_inicio		=  	$data["OBLI-txtFechaInicio"];
	$v_termino		=  	$data["OBLI-txtFechaTermino"];
	$folio			=  	$data["txtFolio"];
	$empresa 		= 	$_SESSION["alycar_sgyonley_empresa_rut"];
	$fecha_actual	=	date("Y-m-d");

	$and_1="";
	if ($v_inicio != '' && $v_termino != ''){
		list($dia1,$mes1,$anio1) =  explode('/', $v_inicio);$fecha1 	= $anio1."-".$mes1."-".$dia1;
		list($dia2,$mes2,$anio2) =  explode('/', $v_termino);$fecha2 	= $anio2."-".$mes2."-".$dia2;
		$and_1 .= "vent_fecha >= '".$fecha1."' and vent_fecha <= '".$fecha2."' and ";
		}
	
	if ($cod_vendedor != '' && $vendedor != ''){
		$and_1 .= "vend_ncorr = '".$cod_vendedor."' and ";
		}
	
	if ($folio != '' ){
		$and_1 .= "vent_num_folio = '".$folio."' and ";
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
			($and_1
			empe_rut = '".$empresa."' and
			vent_estado = 'FINALIZADA' and 
			vent_num_folio in (select folio 
						from sgyonley.cargas_aprobadas
						where estado = 'autorizado'
							or estado = 'anulado' ) and 
			vent_num_folio in (select caut_folio
						from cargas_autorizadas) 			
				
			)
			order by vent_num_folio";
	
	$res = mysql_query($sql, $conexion) or die(mysql_error());
	
	if (mysql_num_rows($res) > 0){
		$i					=	1;
		$arrRegistros 		= 	array();
		$arrDetalle 		= 	array();
		$total_articulos 	= 	0;
		$total_ventas		=	0;
		$arrRegistrosVend	= 	array();	
		
		$sql_vend = "select distinct ve_codigo
				from sgbodega.vendedores WHERE ve_codigo in (select
			vend_ncorr
			
			from 
			ventas_antigua
			
			where 
			($and_1
			empe_rut = '".$empresa."' and
			vent_estado = 'FINALIZADA' and 
			vent_num_folio in (select folio 
						from sgyonley.cargas_aprobadas
						where estado = 'autorizado'
							or estado = 'anulado' ) and 
			vent_num_folio in (select caut_folio
						from cargas_autorizadas) 	
				)
			)
			";
		$res_vend = mysql_query($sql_vend,$conexion) or die(mysql_error());
		while ($row_vend = mysql_fetch_array($res_vend)){
			$ve_ncorr = $row_vend["ve_codigo"];
			$sql_nom_vend = "select ve_vendedor 
					from sgbodega.vendedores 
					where ve_codigo = '".$ve_ncorr."'";
			$res_nom_vend = mysql_query($sql_nom_vend,$conexion) or die(mysql_error());
			$nombre_vendedor = @mysql_result($res_nom_vend,0,"ve_vendedor");;
			array_push($arrRegistrosVend, array(
					"ncorr" => 	$ve_ncorr,
					"nombre"=>	$nombre_vendedor));

			}
		while ($line = mysql_fetch_row($res)) {
			
			$folio		=	$line[1];
			$vent_fecha = 	$line[11];
			$vend_ncorr =	$line[12];
			// busca al vendedor
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

			// busca el cliente
			$sector = $line[2];
			if (strlen($sector) == 1){$sector = '0'.$sector;}
			$tabla_clientes	= 	"0".$_SESSION["alycar_sgyonley_empresa"]."_clientes".$sector;
			$sql_cli = "select clie_nombre from $tabla_clientes where clie_rut = '".$line[4]."'";
			$res_cli = mysql_query($sql_cli, $conexion);
			$cliente="";
			if (@mysql_num_rows($res_cli) > 0){
				$cliente=   $line[5].' - '.@mysql_result($res_cli,0,"clie_nombre");
			}else{
				$sql_cli = "select clie_nombre from clientes where clie_rut = '".$line[5]."'";
				$res_cli = mysql_query($sql_cli, $conexion);
				$cliente=  $line[5].' - '.@mysql_result($res_cli,0,"clie_nombre");
			}	
			$fecha_tarjeta = $line[3];
			if ($estado_venta != 'NULA'){
				$total_ventas	=	$total_ventas + $line[6];
				}
			array_push($arrRegistros, array(
					"item" 			=> 	$i, 
					"ncorr" 		=> 	$line[0], 
					"folio" 		=> 	$line[1], 
					"sector"		=> 	$line[2], 
					"cod_vendedor"		=> 	$vend_ncorr,  
					"nombre_vendedor"	=> 	$nombre_vendedor,
					"num_boleta"		=> 	$line[4], 
					"cliente"		=> 	$cliente,  
					"fecha_tarjeta"		=> 	$fecha_tarjeta,
					"total_venta"		=> 	$line[6],  
					"pie"			=> 	$line[7],  
					"saldo"			=> 	$line[8],  
					"valor_cuota"		=> 	$line[9],
					"estado_venta"		=> 	$estado_venta ));
			
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
					vent_ncorr = '".$folio."' and 
					arti_codigo_largo in (select codigo
											from sgyonley.cargas_aprobadas
											where (estado = 'autorizado' and
												folio = '".$folio."')
												or 
												(estado = 'anulado'  and
												folio = '".$folio."')
											) ";
			
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

				$sql_obtener = "select fecha_aprobacion
							from cargas_aprobadas
							where folio = '".$folio."' and
								codigo = '".$line_p[1]."' and
								estado = 'rechazado'
							limit 0,1";
				$res_obtener = mysql_query($sql_obtener,$conexion) or die(mysql_error());
				$fecha_pedido ="";
				$fecha_despacho ="";
				if (mysql_num_rows($res_obtener)>0){
					$sql_cp = "select fecha_pedida
							from cargas_pedidas 
							where (
								folio = '".$folio."' and
								codigo = '".$line_p[1]."' and
								fecha_pedida > (select fecha_aprobacion
								from cargas_aprobadas
								where folio = '".$folio."' and
									codigo = '".$line_p[1]."' and
									estado = 'rechazado'
									order by fecha_aprobacion desc
								limit 0,1)
								)
							order by fecha_pedida desc
							limit 0,1";
					$res_cp = mysql_query($sql_cp,$conexion) or die(mysql_error());
					$row_cp = mysql_fetch_array($res_cp);
					$fecha_pedido = $row_cp['fecha_pedida'];
					
					$sql_cp = "select fecha_despacho
							from cargas_despachadas
							where (
								folio = '".$folio."' and
								codigo = '".$line_p[1]."' and
								fecha_despacho > (select fecha_aprobacion
								from cargas_aprobadas
								where folio = '".$folio."' and
									codigo = '".$line_p[1]."' and
									estado = 'rechazado'
									order by fecha_aprobacion desc
								limit 0,1)
								)
							order by fecha_despacho desc
							limit 0,1";
					$res_cp = mysql_query($sql_cp,$conexion) or die(mysql_error());
					$row_cp = mysql_fetch_array($res_cp);
					$fecha_despacho = $row_cp['fecha_despacho'];
					}
				else{
					$sql_cp = "select fecha_pedida
							from cargas_pedidas 
							where (
								folio = '".$folio."' and
								codigo = '".$line_p[1]."' 
								)
							order by fecha_pedida desc
							limit 0,1";
					$res_cp = mysql_query($sql_cp,$conexion) or die(mysql_error());
					$row_cp = mysql_fetch_array($res_cp);
					$fecha_pedido = $row_cp['fecha_pedida'];
					
					$sql_cp = "select fecha_despacho
							from cargas_despachadas
							where (
								folio = '".$folio."' and
								codigo = '".$line_p[1]."' 
								)
							order by fecha_despacho desc
							limit 0,1";
					$res_cp = mysql_query($sql_cp,$conexion) or die(mysql_error());
					$row_cp = mysql_fetch_array($res_cp);
					$fecha_despacho = $row_cp['fecha_despacho'];
					}
				
				$sql_cp = "select fecha_aprobacion
								from cargas_aprobadas
								where folio = '".$folio."' and
									codigo = '".$line_p[1]."' and
									estado = 'autorizado'
									order by fecha_aprobacion desc
									limit 0,1";
					$res_cp = mysql_query($sql_cp,$conexion) or die(mysql_error());
					$row_cp = mysql_fetch_array($res_cp);
					$fecha_aprobacion = $row_cp['fecha_aprobacion'];
				
				$sql_anulado = "select fecha_aprobacion
								from cargas_aprobadas
								where folio = '".$folio."' and
									codigo = '".$line_p[1]."' and
									estado = 'anulado'
									order by fecha_aprobacion desc
									limit 0,1";
					$res_anulado = mysql_query($sql_anulado,$conexion) or die(mysql_error());
					$row_anulado = mysql_fetch_array($res_anulado);
					$fecha_anulado = $row_anulado['fecha_aprobacion'];
					
				array_push($arrDetalle, array(	
						"ncorr" 	  => 	$line[0], 
						"codigo" 	  => 	$line_p[1],
						"descripcion"	  => 	$line_p[2],
						"nu"		  => 	$line_p[3],
						"cantidad"	  => 	$line_p[4],
						"precio"	  => 	$line_p[5], 
						"total"		  => 	$line_p[6], 
						"cod_vendedor"	  => 	$vend_ncorr,  
						"anulado"      	  	=> 	$fecha_anulado, 
						"autorizado"      => 	$fecha_aprobacion, 
						"observacion"	  => 	$observacion));
					
			}
			$i++;
			
		}
		
		//$miSmarty->assign('VENDEDOR', $cod_vendedor." ".$vendedor);
		$miSmarty->assign('TOTAL_ARTICULOS', $total_articulos);
		$miSmarty->assign('TOTAL_TARJETAS', $i - 1);
		$miSmarty->assign('TOTAL_VENTAS', $total_ventas);
		
		$miSmarty->assign('arrRegistros', $arrRegistros);
		$miSmarty->assign('arrDetalle', $arrDetalle);
		$miSmarty->assign('arrRegistrosVend', $arrRegistrosVend);
		
		$objResponse->addAssign("divresultado", "innerHTML", $miSmarty->fetch('sg_nylor_informe_preaprobadas_autorizadas_list.tpl'));
		
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
	
	$sql = "delete from ventas_antigua where vent_num_folio = '".$ncorr."'";
	$res = mysql_query($sql, $conexion);
	
	$sql_det = "delete from ventas_detalle_antigua where vent_ncorr = '".$ncorr."'";
	$res_det = mysql_query($sql_det, $conexion);
	
	$objResponse->addScript("xajax_CargaListado(xajax.getFormValues('Form1'))");
	
	return $objResponse->getXML();
}
function Pedido($data, $vent_ncorr, $codigo){
    global $conexion;
    $objResponse = new xajaxResponse('ISO-8859-1');
    $objResponse->addScript("showPopWin('sg_nylor_informe_preaprobadas_autorizadas_pedidos.php?folio=$vent_ncorr&codigo=$codigo', 'Pedidos - Pendientes', 500, 250, null);");
    return $objResponse->getXML();
}

function Despacho($data, $vent_ncorr, $codigo){
    global $conexion;
    $objResponse = new xajaxResponse('ISO-8859-1');
    $objResponse->addScript("showPopWin('sg_nylor_informe_preaprobadas_autorizadas_despacho.php?folio=$vent_ncorr&codigo=$codigo', 'Despachos', 500, 250, null);");
    return $objResponse->getXML();
}

function Aprobado($data, $vent_ncorr, $codigo){
    global $conexion;
    $objResponse = new xajaxResponse('ISO-8859-1');
    $objResponse->addScript("showPopWin('sg_nylor_informe_preaprobadas_autorizadas_aprobado.php?folio=$vent_ncorr&codigo=$codigo', 'Aprobados', 600, 300, null);");
    return $objResponse->getXML();
}

function Historial($data, $vent_ncorr, $codigo){
    global $conexion;
    $objResponse = new xajaxResponse('ISO-8859-1');
    $objResponse->addScript("showPopWin('sg_nylor_informe_precargas_2_historial.php?folio=$vent_ncorr&codigo=$codigo', 'Historial', 800, 600, null);");
    return $objResponse->getXML();
}

function HV($data,$folio){
	global $conexion;
    $objResponse = new xajaxResponse('ISO-8859-1');
	$empresa 		= 	$_SESSION["alycar_sgyonley_empresa_rut"];
	$objResponse->addScript("showPopWin('sg_ventas_revisar_preventas_informe_hv.php?folio=".$folio."&empresa=".$empresa."', 'Revision', 800, 600, null);");
	
	
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
$xajax->registerFunction("Pedido");
$xajax->registerFunction("Despacho");
$xajax->registerFunction("Aprobado");
$xajax->registerFunction("Historial");
$xajax->registerFunction("HV");

$xajax->processRequests();
$miSmarty->assign('xajax_js', $xajax->getJavascript());

$miSmarty->assign('COD_VENDEDOR', $_GET["cod_vendedor"]);
$miSmarty->assign('VENDEDOR', $_GET["nombre_vendedor"]);
$miSmarty->assign('DESDE', $_GET["desde"]);
$miSmarty->assign('HASTA', $_GET["hasta"]);

$miSmarty->display('sg_nylor_informe_preaprobadas_autorizadas.tpl');

?>

