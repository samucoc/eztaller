<?php
 // 5 HORAS
session_start();

require_once 'includes/xajax/xajax.inc.php'; //archivo de configuracion de ajax
include "../includes/php/conf_smarty.php";//archivo de configuracion de smarty
include "../includes/php/conf_bd.php"; //archivo de coneccion al servidor y base de datos
//include "../includes/php/conf_bd_antigua.php"; //archivo de coneccion al servidor de yonley
include "../includes/php/validaciones.php"; 

$xajax = new xajax();

$xajax->setRequestURI("sg_ventas_revisar_preventas_informe_hv.php");
$xajax->setCharEncoding("ISO-8859-1");
$xajax->decodeUTF8InputOn();

function Grabar($data){
	global $conexion;
	
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	$folio				= 	$data["txtNumFolio"];
	$fecha_revision		= 	$data["OBLI-txtFechaRevision"];
	$empresa 			= 	$data['txtEmpresa'];
	
	list($dia1,$mes1,$anio1) = explode('/', $fecha_revision);$fecha1 	= $anio1."-".$mes1."-".$dia1;

	// actualiza la fecha de revision en la venta
	$sql = "update ventas_antigua set vent_fecha_revision = '".$fecha1."' 
			where empe_rut = '".$empresa."' and vent_num_folio = '".$folio."'";
	
	$res = mysql_query($sql, $conexion);
	
	$objResponse->addScript("xajax_Nueva(xajax.getFormValues('Form1'));");
	
	return $objResponse->getXML();
}

function RevisarAbonos($data){
    global $conexion;
	global $miSmarty;
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	$objResponse->addScript("document.getElementById('divcontenedorcliente').style.display='none';");
	$objResponse->addScript("document.getElementById('divcontenedor').style.display='none';");
	$objResponse->addScript("document.getElementById('divlistado').style.display='none';");
	$objResponse->addScript("document.getElementById('divdetalleventa').style.display='none';");
	$objResponse->addScript("document.getElementById('divcuadratura').style.display='none';");	
	
	$folio 	   = 	$data["txtNumFolio"];
	
	$sql_001   = "select  empe_rut 
				from 
				sgyonley.ventas_antigua where vent_num_folio = '".$folio."' ";
	$res_001   = mysql_query($sql_001,$conexion);
	$empresa   = @mysql_result($res_001, 0, "empe_rut");
	//$empresa   = 	$data['txtEmpresa'];
	
		// busca el total de traspasos al folio
	$sql_tr = "select empe_ncorr from sgyonley.empresas WHERE empe_rut = '".$empresa."'";
	$res_tr = mysql_query($sql_tr, $conexion);
	$empe_ncorr = @mysql_result($res_tr, 0, "empe_ncorr");
	
	// busco datos de la venta
	$sql_se = "select sect_ncorr, vent_total_venta as total_venta, vent_pie, clie_rut, vent_num_cuotas, vent_descuento, 
				vent_saldo, vent_valor_cuotas, vent_estado_ingreso, DATE_FORMAT(vent_fecha_revision,'%d/%m/%Y') as fecha_ultima_revision,
				vent_fpago, DATE_FORMAT(vent_fecha,'%d/%m/%Y') as fecha_venta, vend_ncorr
				from 
				sgyonley.ventas_antigua where vent_num_folio = '".$folio."' and empe_rut = '".$empresa."'";
	$res_se = mysql_query($sql_se, $conexion);
	if (mysql_num_rows($res_se) > 0){
		
		// busco si la venta esta como problema
		$cuenta_problema = '';
		$sql_p = "select rfpo_ncorr from sgyonley.registro_folios_problema where rfpo_folio = '".$folio."' and rfpo_empresa = '".$empresa."' and rfpo_ctaproblema = 'SI'";
		$res_p = mysql_query($sql_p,$conexion);
		if (@mysql_num_rows($res_p) > 0){
			$cuenta_problema = 'CUENTA PROBLEMA';
		}	
		
		// busco si la venta esta como devolucion
		$sql_p = "select rfd_ncorr from sgyonley.registro_folios_devolucion where rfd_folio = '".$folio."' and rfd_empresa = '".$empresa."' and rfd_ctaproblema <> 'NO'";
		$res_p = mysql_query($sql_p,$conexion);
		if (@mysql_num_rows($res_p) > 0){
			$cuenta_problema = 'DEVOLUCION A CARGO';
		}	
		
		// busco si la venta esta como dicom
		$sql_p = "select rd_ncorr from sgyonley.registro_dicom where folio = '".$folio."' ";
		$res_p = mysql_query($sql_p,$conexion);
		if (@mysql_num_rows($res_p) > 0){
			$cuenta_problema = 'EN DICOM';
		}	
		
		$line_se = mysql_fetch_row($res_se);
		
		//if (($line_se[8] != 'A') AND ($line_se[8] != 'N') AND ($line_se[8] != 'B') AND ($line_se[8] != 'D') AND ($line_se[8] != 'P')){
		
			if (trim($line_se[8]) == ''){$estado_venta 	= 	'ACTIVA';}
			if ($line_se[8] == 'A'){$estado_venta 	= 	'POR APROBAR';}	//#00CC00
			if ($line_se[8] == 'N'){$estado_venta 	= 	'NULA';}		//#FF0000
			if ($line_se[8] == 'B'){$estado_venta 	= 	'DE BAJA';}		//#FF99CC
			if ($line_se[8] == 'D'){$estado_venta 	= 	'DEVOLUCION';}	//#FF9900
			if ($line_se[8] == 'P'){$estado_venta 	= 	'PAGADA';}		//#0066FF
			
			
			if ($estado_venta == 'NULA'){
				
				$objResponse->addScript("alert('La Venta se Encuentra NULA')");				
			
			}else{
			
				$objResponse->addScript("document.Form1.txtNumFolio.readOnly = true;");
			
				$sector 				= 	$line_se[0];
				$total_venta 			= 	$line_se[1];
				$pie 					= 	$line_se[2];
				$rut_cliente			= 	$line_se[3];
				$num_cuotas				= 	$line_se[4];
				//$descuentos				= 	$line_se[5];
				$vent_saldo				= 	$line_se[6];
				$vent_valor_cuotas		= 	$line_se[7];
				$fecha_ultima_revision	= 	$line_se[9];
				$vent_forma_pago		= 	$line_se[10];
				$vent_fecha_venta		= 	$line_se[11];
				$vendedor				= 	$line_se[12];
			
				$objResponse->addAssign("txtSectNcorr", "value", $sector);

				// busca el total en descuentos
				$total_descuentos = $line_se[5]; // DESCUENTO QUE VIENE DE LA TABLA ANTIGUA
				// descuentos del sistema nuevo
				//$empe_ncorr	= $_SESSION["alycar_sgyonley_empresa"];	
				$sql_dc = "select sum(desc_monto) as total_descuentos from sgyonley.descuentos WHERE vent_num_folio = '".$folio."' AND empe_ncorr = '".$empe_ncorr."' AND desc_autorizado = 'SI'";
				$res_dc = mysql_query($sql_dc, $conexion);
				$total_descuentos = $total_descuentos + @mysql_result($res_dc, 0, "total_descuentos");
			
				// busca la fecha del ultimo descuento ingresado
				$sql_fd = "SELECT 
							DATE_FORMAT(desc_fecha,'%d/%m/%Y') as fecha_descuento,
							DATE_FORMAT(desc_fecha_autorizacion,'%d/%m/%Y') as fecha_autorizacion_descuento
							FROM 
							sgyonley.descuentos 
							WHERE vent_num_folio = '".$folio."' AND empe_ncorr = '".$empe_ncorr."' AND desc_autorizado = 'SI'
							order by desc_fecha desc limit 1";
				$res_fd = mysql_query($sql_fd, $conexion);
				if (@mysql_num_rows($res_fd) > 0){
					$fecha_descuento 				= 	@mysql_result($res_fd,0,"fecha_descuento");
					$fecha_autorizacion_descuento 	= 	@mysql_result($res_fd,0,"fecha_autorizacion_descuento");
					$fecha_descuento_mostrar		=	$fecha_descuento;
					if (($fecha_autorizacion_descuento != '' && $fecha_autorizacion_descuento != "00/00/0000")){
						$fecha_descuento_mostrar = $fecha_autorizacion_descuento;
					}
				}
				
			
				// busca el total de traspasos al folio
				$sql_tr = "select sum(DA_VALOR) as total_traspasos from sgyonley.descaumebaja WHERE DA_MOVI = 'T' AND DA_TRASPASADO = '".$folio."'";
				$res_tr = mysql_query($sql_tr, $conexion);
				$total_traspasos = @mysql_result($res_tr, 0, "total_traspasos");
			
				// busca el total de traspasos del folio
				$sql_tr = "select sum(DA_VALOR) as total_traspasos from dsgyonley.escaumebaja WHERE DA_MOVI = 'T' AND DA_FOLIO = '".$folio."'";
				$res_tr = mysql_query($sql_tr, $conexion);
				$total_traspasado = @mysql_result($res_tr, 0, "total_traspasos");
			
				//busca el total en devoluciones
				$sql_dev = "select sum(sv_valor) as total_dev from sgyonley.sub_guiadev where sv_folio = '".$folio."' and sv_empresa = '".$empresa."'";
				$res_dev = mysql_query($sql_dev, $conexion);
				$total_dev = @mysql_result($res_dev, 0, "total_dev");
			
				// busca lc
				$sql_lc = "select clie_lc from sgyonley.clientes WHERE clie_rut = '".$rut_cliente."'";
				$res_lc = mysql_query($sql_lc, $conexion);
				$lc = @mysql_result($res_lc, 0, "clie_lc");
			
				// busca la descripcion del sector de la venta
				$sql_se = "select sect_desc from sgyonley.sectores WHERE sect_cod = '".$sector."' and empe_ncorr = '".$empe_ncorr."'";
				$res_se = mysql_query($sql_se, $conexion);
				$sector_venta = $sector." ".@mysql_result($res_se, 0, "sect_desc");
			
				// busca la forma de pago
				$sql_fp = "select tfop_desc from sgyonley.tipos_formas_pagos WHERE tfop_codigo = '".$vent_forma_pago."'";
				$res_fp = mysql_query($sql_fp, $conexion);
				$forma_pago = @mysql_result($res_fp, 0, "tfop_desc");
			
			
				// busca la fecha del ultimo pago (ultimo abono)
				if (strlen(trim($sector)) == 1){
					$sector_abono = "0".$sector;
				}else{
					$sector_abono = $sector;
				}	
			
				$tabla_abonos	= 	"0".$empe_ncorr."_abonos".$sector_abono;
				$tabla_cuotas	= 	"0".$empe_ncorr."_cuotas".$sector_abono;
				$tabla_clientes	= 	"0".$empe_ncorr."_clientes".$sector_abono;
			
				$sql_ua = "select DATE_FORMAT(AB_FECHAPAGO,'%d/%m/%Y') as fecha_abono, AB_FECHAPAGO FROM sgyonley.$tabla_abonos
							WHERE AB_FOLIO = '".$folio."' and AB_EMPRESA = '".$empresa."' and AB_VALOR > '0' ORDER BY AB_FECHAPAGO DESC LIMIT 1";
			
				$res_ua = mysql_query($sql_ua, $conexion);
				$line_ua = mysql_fetch_row($res_ua);
				$ult_pago = $line_ua[0];
				$fecha_ult_pago = $line_ua[1];
			
				$sql_ua = "select sum(AB_VALOR) FROM sgyonley.$tabla_abonos
							WHERE AB_FOLIO = '".$folio."' and AB_EMPRESA = '".$empresa."' and AB_FECHAPAGO = '".$fecha_ult_pago."' AND AB_VALOR > '0'";
			
				$res_ua = mysql_query($sql_ua, $conexion);
				$line_ua = mysql_fetch_row($res_ua);
			
				$monto_ult_pago = $line_ua[0];
				// fin busqueda fecha del ultimo pago
			
				// asigna los datos de la venta
				$objResponse->addAssign("tddet1", "innerHTML", number_format($total_venta,'0','.','.'));
				$objResponse->addAssign("tddet2", "innerHTML", number_format($total_descuentos,'0','.','.')." "."Fecha: "." ".$fecha_descuento_mostrar);
				$objResponse->addAssign("tddet3", "innerHTML", number_format($pie,'0','.','.'));
				$objResponse->addAssign("tddet4", "innerHTML", number_format($total_dev,'0','.','.'));
				$objResponse->addAssign("tddet5", "innerHTML", number_format($total_traspasos,'0','.','.'));
				$objResponse->addAssign("tddet6", "innerHTML", number_format($lc,'0','.','.'));
				$objResponse->addAssign("tddet7", "innerHTML", number_format($abono_traspaso,'0','.','.'));
				$objResponse->addAssign("tddet10", "innerHTML", $sector_venta);
				$objResponse->addAssign("tddet11", "innerHTML", $forma_pago);
				$objResponse->addAssign("tddet12", "innerHTML", number_format($vent_valor_cuotas,'0','.','.'));
				$objResponse->addAssign("tddet13", "innerHTML", number_format($num_cuotas,'0','.','.'));
				$objResponse->addAssign("tddet14", "innerHTML", $vent_fecha_venta);
				$objResponse->addAssign("tddet15", "innerHTML", $fecha_ultima_revision);
				
				$cuenta_problema = "<label class='requeridopeq'><b>".$cuenta_problema."</b></label>";
				
				$objResponse->addAssign("tddet16", "innerHTML", $estado_venta." ".$cuenta_problema);
				
				$objResponse->addAssign("tddet17", "innerHTML", $ult_pago);
				$objResponse->addAssign("tddet18", "innerHTML", number_format($monto_ult_pago,'0','.','.'));
				
				$sql_aprob = "select usuario_aprobacion, DATE_FORMAT(fecha_aprobacion,'%d/%m/%Y') as fecha_aprobacion from sgyonley.ventas_preaprobas where folio = '".$folio."'";
				$res_aprob = mysql_query($sql_aprob,$conexion);
				$row_aprob = mysql_fetch_array($res_aprob);
								
				$objResponse->addAssign("tddet19", "innerHTML", $row_aprob['usuario_aprobacion']);
				$objResponse->addAssign("tddet20", "innerHTML", $row_aprob['fecha_aprobacion']);
				
				// busca al cliente
				$sql_cli = "select clie_nombre, clie_bloqueado, clie_cupo, clie_direccion, 
							clie_ciudad, clie_barrio, clie_localidad, sect_ncorr from sgyonley.$tabla_clientes where clie_rut = '".$rut_cliente."'";
				$res_cli = mysql_query($sql_cli, $conexion);
				if (@mysql_num_rows($res_cli) < 1){
					// busca al cliente en todos los sectores
					$sql_sec = "select sect_cod from sgyonley.sectores where empe_ncorr = '".$empe_ncorr."'";
					$res_sec = mysql_query($sql_sec,$conexion);
					$encontrado = 'NO';
					while ($line_sec = mysql_fetch_row($res_sec)) {
						if ($encontrado == 'NO'){
							$sector = trim($line_sec[0]);
							if (strlen($sector) == 1){$sector = '0'.$sector;}
							$tabla_cli = '0'.$empe_ncorr.'_clientes'.$sector;
							$sql_cl = "select clie_ncorr from sgyonley.$tabla_cli where clie_rut = '".$rut_cliente."'";
							$res_cl = mysql_query($sql_cl,$conexion);
							if (@mysql_num_rows($res_cl) > 0){
								$tabla_clientes 	=	$tabla_cli;
								$_SESSION["alycar_sgyonley_sect_ncorr"] = $line_sec[0];
								$encontrado 		= 	'SI';
							}
						}
					}
					if ($encontrado == 'SI'){
						$sql_cli = "select clie_nombre, clie_bloqueado, clie_cupo, clie_direccion, 
									clie_ciudad, clie_barrio, clie_localidad, sect_ncorr from sgyonley.$tabla_clientes where clie_rut = '".$rut_cliente."'";
						$res_cli = mysql_query($sql_cli, $conexion);
					}
					else{
						$sql_cli = "select clie_nombre, clie_bloqueado, clie_cupo, clie_direccion, 
									clie_ciudad, clie_barrio, clie_localidad, sect_ncorr from sgyonley.clientes where clie_rut = '".$rut_cliente."'";
						}
				}
				
				$line_cli = mysql_fetch_row($res_cli);
			
				// busco al vendedor
				$sql_vd = "select VE_VENDEDOR from sgbodega.vendedores where VE_CODIGO = '".$vendedor."' and ve_empresa = '".$empresa."'";
				$res_vd = mysql_query($sql_vd, $conexion);
				$vendedor = $vendedor." ".@mysql_result($res_vd,0,"VE_VENDEDOR");
			
				// busco el sector del cliente
				$sql_sv = "select sect_desc from sgyonley.sectores where sect_cod = '".$line_cli[7]."' and empe_ncorr = '".$empe_ncorr."'";
				$res_sv = mysql_query($sql_sv, $conexion);
				$sector_vendedor = $line_cli[7]." ".@mysql_result($res_sv,0,"sect_desc");
			
				$objResponse->addAssign("clie1", "innerHTML", number_format($rut_cliente,'0','.','.')."-".dv($rut_cliente)." ".$line_cli[0]);
				$objResponse->addAssign("clie2", "innerHTML", "&nbsp;".$vendedor);
				$objResponse->addAssign("clie3", "innerHTML", "&nbsp;".$line_cli[1]);
				$objResponse->addAssign("clie4", "innerHTML", "&nbsp;".$line_cli[3]);
				$objResponse->addAssign("clie5", "innerHTML", "&nbsp;".$line_cli[5]);
				$objResponse->addAssign("clie6", "innerHTML", "&nbsp;".$estado_cliente);
				$objResponse->addAssign("clie7", "innerHTML", "&nbsp;".$line_cli[4]);
				$objResponse->addAssign("clie8", "innerHTML", "&nbsp;".$line_cli[6]);
				$objResponse->addAssign("clie9", "innerHTML", "&nbsp;".$sector_vendedor);
			
				$objResponse->addAssign("clie_estado", "innerHTML", $line_cli[1]);
				$objResponse->addAssign("clie_cupo", "innerHTML", $line_cli[2]);
			
				// asigno el sector por defecto
				$objResponse->addAssign("OBLI-txtCodSector", "value", $sector);
				$objResponse->addScript("xajax_CargaDesc(xajax.getFormValues('Form1'),'sectores', 'sect_ncorr', 'sect_desc', 'OBLI-txtCodSector', 'OBLI-txtDescSector', '');");
			
				// fecha de ultima revision
				$objResponse->addAssign("tdultimarevision", "innerHTML", $fecha_ultima_revision);
			
				// armo la estructura para la conexion a las tablas de abonos (estan relacionadas al rut de la empresa selecionada y al sector)
				if (strlen(trim($sector)) == 1){$sector = "0".$sector;}
			
				$_SESSION["alycar_sgyonley_sector_cuadratura"] = $sector_abono;
			
				//$tabla_abonos	= 	"0".$_SESSION["alycar_sgyonley_empresa"]."_abonos".$sector;
				//$tabla_cuotas	= 	"0".$_SESSION["alycar_sgyonley_empresa"]."_cuotas".$sector;
				
				$empresa 		= 	$_SESSION["alycar_sgyonley_empresa_rut"];
			
				$sql = "select
						AB_NCORR as ncorr,
						AB_FECHAPAGO as fecha_abono_sin_formato,
						DATE_FORMAT(AB_FECHAPAGO,'%d/%m/%Y') as fecha_abono,
						AB_VALOR as monto_abono,
						AB_NUMCUOTA as num_cuota
					
						FROM 
						sgyonley.$tabla_abonos
					
						WHERE
						AB_FOLIO = '".$folio."' and AB_EMPRESA = '".$empresa."' and AB_VALOR > '0'
					
						ORDER BY AB_FECHAPAGO ASC";
			
				$res = mysql_query($sql, $conexion);
			
				$arrRegistros			= 	array();
				$saldo_venta_general	=	$total_venta;
				$saldo_venta			=	$total_venta;
				$total_abonos			=	0;
				$i						=	1;
				
				while ($line = mysql_fetch_assoc($res)) {
					// calculo del saldo
					$saldo_venta_linea 	= 	$saldo_venta - $line['monto_abono'];
					$saldo_venta 		= 	$saldo_venta - $line['monto_abono'];
					
					// busca datos de la cuota
					$sql_c 	= "select 
								DATE_FORMAT(CU_FECVCTO,'%d/%m/%Y') as fecha_venc_cuota,
								CU_DEBE as valor_cuota,
								CU_FECVCTO as fecha_venc_cuota_sin_formato
								from sgyonley.$tabla_cuotas
								where CU_FOLIO = '".$folio."' and CU_NUMCUOTA = '".$line['num_cuota']."' order by CU_FECVCTO asc";
					$res_c 	= mysql_query($sql_c, $conexion);
					$line_c = mysql_fetch_row($res_c);
					
					// busco el saldo de la cuota por linea
					$sql_sc = "select sum(AB_VALOR) as total_abonos_cuota from sgyonley.$tabla_abonos 
								where 
								AB_FOLIO = '".$folio."' and 
								AB_EMPRESA = '".$empresa."' and 
								AB_NUMCUOTA = '".$line['num_cuota']."' and
								AB_NCORR <= '".$line['ncorr']."'";
					$res_sc = mysql_query($sql_sc, $conexion);
					$line_sc = mysql_fetch_row($res_sc);
					$saldo_cuota = $line_c[1] - $line_sc[0];
					
					// calcula los dias de atraso.
					$sql_at = "SELECT DATEDIFF('".$line['fecha_abono_sin_formato']."','".$line_c[2]."') as dias_atraso";
					$res_at = mysql_query($sql_at, $conexion);
					$line_at = mysql_fetch_row($res_at);
					
					$total_abonos = $total_abonos + $line['monto_abono'];
					
					array_push($arrRegistros, array("item"				=>	$i,
													"ncorr" 			=> 	$line['ncorr'],
													"fecha_abono" 		=> 	$line['fecha_abono'],
													"monto_abono" 		=> 	$line['monto_abono'],
													"num_cuota" 		=> 	$line['num_cuota'],
													"saldo_venta" 		=> 	$saldo_venta_linea,
													"fecha_venc_cuota" 	=> 	$line_c[0],
													"valor_cuota" 		=> 	$line_c[1],
													"saldo_cuota" 		=> 	$saldo_cuota,
													"dias_atraso" 		=> 	$line_at[0]));
				
					$i++;
				}
			
				$sql = "select
						AB_NCORR as ncorr,
						AB_FECHAPAGO as fecha_abono_sin_formato,
						DATE_FORMAT(AB_FECHAPAGO,'%d/%m/%Y') as fecha_abono,
						SUM(AB_VALOR) as monto_abono,
						AB_NUMCUOTA as num_cuota,
						AB_COBRADOR as cobrador,
						AB_SUPERVISOR as supervisor
					
						FROM 
						sgyonley.$tabla_abonos
					
						WHERE
						AB_FOLIO = '".$folio."' and AB_EMPRESA = '".$empresa."' and AB_VALOR > '0' GROUP BY AB_FECHAPAGO ORDER BY AB_FECHAPAGO ASC";
			
				$res = mysql_query($sql, $conexion);
			
				$arrRegistrosUni		= 	array();
				$saldo_venta_general	=	$total_venta;
				$saldo_venta			=	$total_venta;
				$total_abonos			=	0;
				$j						=	1;
				while ($line = mysql_fetch_assoc($res)) {
					// calculo del saldo
					$saldo_venta_linea 	= 	$saldo_venta - $line['monto_abono'];
					$saldo_venta 		= 	$saldo_venta - $line['monto_abono'];
					
					// busca datos de la cuota
					$sql_c 	= "select 
								DATE_FORMAT(CU_FECVCTO,'%d/%m/%Y') as fecha_venc_cuota,
								CU_DEBE as valor_cuota,
								CU_FECVCTO as fecha_venc_cuota_sin_formato
								from sgyonley.$tabla_cuotas
								where CU_FOLIO = '".$folio."' and CU_NUMCUOTA = '".$line['num_cuota']."' order by CU_FECVCTO asc";
					$res_c 	= mysql_query($sql_c, $conexion);
					$line_c = mysql_fetch_row($res_c);
					
					// busco el saldo de la cuota por linea
					$sql_sc = "select sum(AB_VALOR) as total_abonos_cuota from sgyonley.$tabla_abonos 
								where 
								AB_FOLIO = '".$folio."' and 
								AB_EMPRESA = '".$empresa."' and 
								AB_NUMCUOTA = '".$line['num_cuota']."' and
								AB_NCORR <= '".$line['ncorr']."'";
					$res_sc = mysql_query($sql_sc, $conexion);
					$line_sc = mysql_fetch_row($res_sc);
					$saldo_cuota = $line_c[1] - $line_sc[0];
					
					// calcula los dias de atraso.
					$sql_at = "SELECT DATEDIFF('".$line['fecha_abono_sin_formato']."','".$line_c[2]."') as dias_atraso";
					$res_at = mysql_query($sql_at, $conexion);
					$line_at = mysql_fetch_row($res_at);
					
					$total_abonos = $total_abonos + $line['monto_abono'];
					
					array_push($arrRegistrosUni, array("item"			=>	$j,
													"ncorr" 			=> 	$line['ncorr'],
													"fecha_abono" 		=> 	$line['fecha_abono'],
													"monto_abono" 		=> 	$line['monto_abono'],
													"cobrador"			=>	$line['cobrador'],
													"supervisor"		=>	$line['supervisor'],
													"num_cuota" 		=> 	$line['num_cuota'],
													"saldo_venta" 		=> 	$saldo_venta_linea,
													"fecha_venc_cuota" 	=> 	$line_c[0],
													"valor_cuota" 		=> 	$line_c[1],
													"saldo_cuota" 		=> 	$saldo_cuota,
													"dias_atraso" 		=> 	$line_at[0]));
				
					$j++;
				}
			
				// busca los productos
				$sql_pd = "select
							vdet_ncorr as ncorr,
							arti_codigo_largo as codigo,
							arti_desc as descripcion,
							arti_nu as nu,
							vent_cant as cantidad,
							vent_valor_venta as precio,
							vent_sub_total as total
					
							FROM 
							sgyonley.ventas_detalle_antigua
					
							WHERE
							vent_ncorr = '".$folio."'";
			
				$res_pd = mysql_query($sql_pd, $conexion);
				$i = 1;
				$arrProductos = array();
				
				while ($line_pd = mysql_fetch_row($res_pd)) {
					array_push($arrProductos, array("ncorr"			=>	$line_pd[0],
												"item"			=>	$i,
												"codigo" 		=> 	$line_pd[1],
												"descripcion" 	=> 	$line_pd[2],
												"nu" 			=> 	$line_pd[3],
												"cantidad"		=> 	$line_pd[4],
												"precio" 		=> 	$line_pd[5],
												"total" 		=> 	$line_pd[6]));
				
					$i++;
				}
			
				$miSmarty->assign('FOLIO', $folio);
				$miSmarty->assign('VALOR_CUOTA', $valor_cuota);
				$miSmarty->assign('TOTAL_VENTA', $total_venta);
				$miSmarty->assign('SALDO_VENTA', $saldo_venta_general);
				$miSmarty->assign('TOTAL_ABONOS', $total_abonos);
				$miSmarty->assign('NOMBRE_EMPRESA', $_SESSION["alycar_sgyonley_empresa_nombre"]);
			
				$objResponse->addAssign("tddet8", "innerHTML", number_format($total_abonos,'0','.','.'));
			
				// ESTE ES EL SALDO DE LA VENTA
				$saldo_actual_venta = $saldo_venta_general - $pie - $total_abonos - $total_dev - $total_traspasos - $total_descuentos + $total_traspasado;
				$objResponse->addAssign("tddet9", "innerHTML", number_format($saldo_actual_venta,'0','.','.'));
			
				// si el saldo de la venta es menor o igual a 0, la cuenta quedará cnacelada
				if ($saldo_actual_venta <= 0 && $estado_venta == 'ACTIVA'){
					$vent_estado_ingreso = 'P';
					$sql_vent = "update sgyonley.ventas_antigua set 
									vent_estado_ingreso = '".$vent_estado_ingreso."' 
									where vent_num_folio = '".$folio."' AND empe_rut = '".$empresa."'";
					$res_vent = mysql_query($sql_vent, $conexion);
				}
				
				/*
				}else{
					if ($estado_venta != 'DEVOLUCION'){
						$vent_estado_ingreso = '';
					}
				}
				*/
				
			
				$objResponse->addAssign("txtSaldoVenta", "value", $saldo_actual_venta);
				$objResponse->addAssign("vent_saldo", "innerHTML", number_format($saldo_actual_venta,'0','.','.'));
				$objResponse->addAssign("vent_total_abonos", "innerHTML", number_format($total_abonos,'0','.','.'));
			
				$miSmarty->assign('arrRegistros', $arrRegistros);
				$miSmarty->assign('arrRegistrosUni', $arrRegistrosUni);
			
				$objResponse->addAssign("divabonos", "innerHTML", $miSmarty->fetch('sg_revision_kardex_list.tpl'));
				$objResponse->addAssign("divabonosimp", "innerHTML", $miSmarty->fetch('sg_revision_kardex_list.tpl'));
				$objResponse->addAssign("divabonosuni", "innerHTML", $miSmarty->fetch('sg_revision_kardex_uni_list.tpl'));
			
				$miSmarty->assign('arrProductos', $arrProductos);
				$objResponse->addAssign("divproductos", "innerHTML", $miSmarty->fetch('sg_ventas_revisar_preventas_informe_hv_articulos_list.tpl'));
				$objResponse->addAssign("divproductosimp", "innerHTML", $miSmarty->fetch('sg_revision_kardex_articulos_imp_list.tpl'));
			
				$objResponse->addScript("document.getElementById('OBLI-txtFechaRevision').focus();");
				$objResponse->addScript("document.getElementById('OBLI-txtFechaRevision').select();");
			
				$objResponse->addScript("document.getElementById('divcontenedorcliente').style.display='block';");
				$objResponse->addScript("document.getElementById('divcontenedor').style.display='block';");
				$objResponse->addScript("document.getElementById('divlistado').style.display='block';");
				$objResponse->addScript("document.getElementById('divdetalleventa').style.display='block';");
		
				// asigna los valor para la impresion
				$objResponse->addAssign("imp", "innerHTML", "&nbsp; Ficha del Folio Nº ".$folio);
				$objResponse->addAssign("imp1", "innerHTML", "&nbsp;".date("d/m/Y"));
				$objResponse->addAssign("imp2", "innerHTML", "&nbsp;".$sector_venta);
				$objResponse->addAssign("imp3", "innerHTML", "&nbsp;".$line_cli[3]);
				$objResponse->addAssign("imp4", "innerHTML", "&nbsp;".$line_cli[4]);
				$objResponse->addAssign("imp5", "innerHTML", "&nbsp;".$line_cli[5]);
				$objResponse->addAssign("imp6", "innerHTML", "&nbsp;".number_format($rut_cliente,'0','.','.')."-".dv($rut_cliente)." ".$line_cli[0]);
				$objResponse->addAssign("imp7", "innerHTML", "&nbsp;".$vendedor);
				$objResponse->addAssign("imp8", "innerHTML", "&nbsp;".$vent_fecha_venta);
				$objResponse->addAssign("imp9", "innerHTML", "&nbsp;".number_format($total_venta,'0','.','.'));
				$objResponse->addAssign("imp10", "innerHTML", "&nbsp;".number_format($total_descuentos,'0','.','.')." "."Fecha: "." ".$fecha_descuento_mostrar); // preguntar si es el descuento por comision o descuento para cancelacion
				$objResponse->addAssign("imp11", "innerHTML", "&nbsp;".number_format($pie,'0','.','.'));
				$objResponse->addAssign("imp12", "innerHTML", "&nbsp;".number_format($total_dev,'0','.','.')); // terminar cuendo se analice existencia
				$objResponse->addAssign("imp13", "innerHTML", "&nbsp;".number_format($total_traspasos,'0','.','.'));
				$objResponse->addAssign("imp14", "innerHTML", "&nbsp;".number_format($saldo_venta,'0','.','.'));
				$objResponse->addAssign("imp15", "innerHTML", "&nbsp;".$forma_pago);
				$objResponse->addAssign("imp16", "innerHTML", "&nbsp;".number_format($total_abonos,'0','.','.'));
				$objResponse->addAssign("imp17", "innerHTML", "&nbsp;".number_format($lc,'0','.','.'));
				$objResponse->addAssign("imp18", "innerHTML", "&nbsp;".number_format($saldo_actual_venta,'0','.','.'));
			
		
			}
			
		//}else{
			
		//	$objResponse->addScript("alert('La Venta No Está ACTIVA')");
		//}
		
	}else{
		
		$objResponse->addScript("alert('Folio No Existe')");
	}

	return $objResponse->getXML();
}

function LlamaMantenedorClientes($data){
	global $conexion;
	
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	$folio									=	$data["txtNumFolio"];
	$empresa 								= 	$_SESSION["alycar_sgyonley_empresa_rut"];
	$empe_ncorr								= 	$_SESSION["alycar_sgyonley_empresa"];
	$sect_ncorr								= 	$data["txtSectNcorr"];
	$fecha_revision							=	$data["OBLI-txtFechaRevision"];
	$_SESSION["alycar_sgyonley_sect_ncorr"]	=	$sect_ncorr;
	
	// armo la tabla de clientes
	$sector = trim($sect_ncorr);
	if (strlen($sector) == 1){$sector = '0'.$sector;}
	$tabla_clientes = '0'.$empe_ncorr.'_clientes'.$sector;
	
	$sql = "select clie_rut from ventas_antigua where vent_num_folio = '".$folio."' and empe_rut = '".$empresa."'";
	$res = mysql_query($sql, $conexion);
	$clie_rut = @mysql_result($res,0,"clie_rut");
	
	//$objResponse->addScript("alert('$clie_rut')");
	
	// busca al cliente
	$sql_cli = "select clie_nombre from $tabla_clientes where clie_rut = '".$clie_rut."'";
	$res_cli = mysql_query($sql_cli, $conexion);
	$clie_nombre = @mysql_result($res_cli,0,"clie_nombre");
		
	$_SESSION["alycar_sgyonley_ingreso_cliente"] = 'SI';
	
	$_SESSION["alycar_sgyonley_fecha_revision"] = $fecha_revision;
	$_SESSION["alycar_sgyonley_pagina_regreso"] = 'sg_revision_kardex.php';
	
	$objResponse->addScript("document.location.href='sg_mantenedor_clientes.php?folio=$folio&clie_rut=$clie_rut&clie_nombre=$clie_nombre&sect_ncorr=$sect_ncorr'");
	
	return $objResponse->getXML();
}

function MuestraRegistro($data, $campo1, $campo2, $obj1, $obj2){
	global $conexion;
	
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	$objResponse->addAssign("$obj1", "value", $campo1);
	$objResponse->addAssign("$obj2", "value", $campo2);
	
	return $objResponse->getXML();
}
function MuestraDiv($data, $div){
	global $conexion;
	
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	$objResponse->addScript("document.getElementById('divabonos').style.display='none';");
	$objResponse->addScript("document.getElementById('divabonosuni').style.display='none';");
	$objResponse->addScript("document.getElementById('divproductos').style.display='none';");
	$objResponse->addScript("document.getElementById('divdevoluciones').style.display='none';");
	$objResponse->addScript("document.getElementById('divcuadratura').style.display='none';");	
	
	$objResponse->addScript("document.getElementById('$div').style.display='block';");
	
	return $objResponse->getXML();
}
function CargaDesc($data, $tabla, $campo1, $campo2, $objeto1, $objeto2, $c_and){
    global $conexion;
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	$ncorr 	=	$data["$objeto1"];
	
	$sql = "select $campo2 as descripcion from sgyonley.$tabla where $campo1 = '".$ncorr."' $and";
	
	$res = mysql_query($sql, $conexion);
	
	$objResponse->addAssign("$objeto2", "value", @mysql_result($res,0,"descripcion"));
	
	return $objResponse->getXML();
}
function Nueva($data){
    global $conexion;
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	$objResponse->addScript("document.getElementById('divcontenedorcliente').style.display='none';");
	$objResponse->addScript("document.getElementById('divcontenedor').style.display='none';");
	$objResponse->addScript("document.getElementById('divlistado').style.display='none';");
	$objResponse->addScript("document.getElementById('divdetalleventa').style.display='none';");
	$objResponse->addScript("document.getElementById('divcuadratura').style.display='none';");	
	
	$objResponse->addScript("document.Form1.txtNumFolio.readOnly = false;");
	
	$objResponse->addAssign("txtNumFolio", "value", $folio);
	$objResponse->addScript("document.getElementById('txtNumFolio').focus();");

	return $objResponse->getXML();
}

function CargaPagina($data){
    global $conexion;
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	$folio 			= 	$data["txtNumFolio"];
	$fecha_revision	=	$_SESSION["alycar_sgyonley_fecha_revision"];
	
	if ($folio != ''){
		$objResponse->addAssign("txtNumFolio", "value", $folio);
		
		if (isset($_SESSION["alycar_sgyonley_fecha_revision"])){
			$objResponse->addAssign("OBLI-txtFechaRevision", "value", $fecha_revision);
			unset($_SESSION["alycar_sgyonley_fecha_revision"]);
		}
		
		$objResponse->addScript("xajax_RevisarAbonos(xajax.getFormValues('Form1'));");
	}else{
		$objResponse->addScript("document.getElementById('txtNumFolio').focus();");
	}
	
	return $objResponse->getXML();
}          
function EliminarItem($data, $ncorr){
	global $conexion;
	
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	$sector		= 	$data["OBLI-txtCodSector"];
	
	if (strlen(trim($sector)) == 1){$sector = "0".$sector;}
	$tabla_abonos	= 	"0".$_SESSION["alycar_sgyonley_empresa"]."_abonos".$sector;
	
	$sql = "delete from $tabla_abonos where AB_NCORR = '".$ncorr."'";
	$res = mysql_query($sql, $conexion);
	
	$objResponse->addScript("xajax_RevisarAbonos(xajax.getFormValues('Form1'));");
	
	$objResponse->addScript("alert('Se Eliminó un Registro de Abono')");
	
	return $objResponse->getXML();
}
function MuestraDevoluciones($data){
	global $conexion;
	global $miSmarty;
	
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	$empresa 		= 	$_SESSION["alycar_sgyonley_empresa_rut"];
	$folio 			= 	$data["txtNumFolio"];
	
	$objResponse->addScript("document.getElementById('divabonos').style.display='none';");
	$objResponse->addScript("document.getElementById('divabonosuni').style.display='none';");
	$objResponse->addScript("document.getElementById('divproductos').style.display='none';");
	$objResponse->addScript("document.getElementById('divdevoluciones').style.display='none';");
	$objResponse->addScript("document.getElementById('divDABT').style.display='none';");
	$objResponse->addScript("document.getElementById('divcuadratura').style.display='none';");	
	
	// busca los registros
	$sql_ve = "select 
				sv_fecha as fecha,
				sv_folio as folio,
				sv_guiadv as guia,
				sv_codbus as codigo,
				sv_glosa as descripcion,
				sv_nu as nu,
				sv_cantidad as cantidad,
				sv_valor as valor
				
				from sub_guiadev
				
				where
				sv_empresa = '".$empresa."' and
				sv_folio = '".$folio."'
				
				order by sv_fecha asc";
	
	$res_ve = mysql_query($sql_ve, $conexion);
	if (mysql_num_rows($res_ve) > 0){
		$arrRegistros	= 	array();
		$i = 1;
		while ($line_ve = mysql_fetch_row($res_ve)) {
			array_push($arrRegistros, array("item"				=>	$i,
											"fecha" 			=> 	$line_ve[0],
											"folio" 			=> 	$line_ve[1],
											"guia" 				=> 	$line_ve[2],
											"codigo"			=> 	$line_ve[3],
											"descripcion" 		=> 	$line_ve[4],
											"nu" 				=> 	$line_ve[5],
											"cantidad" 			=> 	$line_ve[6],
											"valor"				=> 	$line_ve[7]));
	
			$i++;
		}
		
		$sql_e = "select empe_desc from empresas where empe_rut = '".$empresa."'";
		$res_e = mysql_query($sql_e, $conexion);
		$nombre_empresa = @mysql_result($res_e, 0, "empe_desc");
		
		// asigno las sesiones para el ordenamiento
		$_SESSION["alycar_matriz"] 			= 	$arrRegistros;
		$_SESSION["alycar_empresa"] 		= 	$nombre_empresa;
		$_SESSION["alycar_folio"] 			= 	$folio;
		$_SESSION["alycar_total_folios"] 	= 	$i - 1;
		
		$miSmarty->assign('EMPRESA', $nombre_empresa);
		$miSmarty->assign('FOLIO', $folio);
		$miSmarty->assign('TOTAL_FOLIOS', $i - 1);
		
		$miSmarty->assign('arrRegistros', $arrRegistros);
		$objResponse->addAssign("divdevoluciones", "innerHTML", $miSmarty->fetch('sg_revision_kardex_devoluciones_list.tpl'));
		
	}else{
		
		$objResponse->addAssign("divdevoluciones", "innerHTML", "No Existen Registros");
	}
	
	$objResponse->addScript("document.getElementById('divdevoluciones').style.display='block';");
	
	
	return $objResponse->getXML();
}

function MuestraDABT($data){
	global $conexion;
	global $miSmarty;
	
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	$empresa 		= 	$_SESSION["alycar_sgyonley_empresa_rut"];
	$folio 			= 	$data["txtNumFolio"];
	
	$objResponse->addScript("document.getElementById('divabonos').style.display='none';");
	$objResponse->addScript("document.getElementById('divabonosuni').style.display='none';");
	$objResponse->addScript("document.getElementById('divproductos').style.display='none';");
	$objResponse->addScript("document.getElementById('divdevoluciones').style.display='none';");
	$objResponse->addScript("document.getElementById('divDABT').style.display='none';");
	$objResponse->addScript("document.getElementById('divcuadratura').style.display='none';");	
	// busca las transacciones por descuentos, aumentos, bajas, traspasos
	
	$sql_ve = "select 
				da_movi as movimiento,
				da_folio as folio_origen,
				da_traspasado as folio_destino,
				da_fecha as fecha,
				da_valor as valor,
				da_usuario as usuario
				
				from descaumebaja
				
				where
				da_folio = '".$folio."' OR da_traspasado = '".$folio."'
				
				order by da_fecha asc";
	
	$res_ve = mysql_query($sql_ve, $conexion);
	if (mysql_num_rows($res_ve) > 0){
		$arrRegistros	= 	array();
		$i = 1;
		while ($line_ve = mysql_fetch_row($res_ve)) {
			if ($line_ve[0] == 'D'){$mov = "DESCUENTO";}
			if ($line_ve[0] == 'A'){$mov = "AUMENTO";}
			if ($line_ve[0] == 'B'){$mov = "BAJA";}
			if ($line_ve[0] == 'T'){$mov = "TRASPASO";}
			array_push($arrRegistros, array("item"				=>	$i,
											"movimiento"		=> 	$mov,
											"folio_origen" 		=> 	$line_ve[1],
											"folio_destino"		=> 	$line_ve[2],
											"fecha" 			=> 	$line_ve[3],
											"valor"				=> 	$line_ve[4],
											"usuario"			=> 	$line_ve[5]));
	
			$i++;
		}
		
		$miSmarty->assign('arrRegistros', $arrRegistros);
		$objResponse->addAssign("divDABT", "innerHTML", $miSmarty->fetch('sg_revision_kardex_descaumebaja_list.tpl'));
		
	}else{
		
		$objResponse->addAssign("divDABT", "innerHTML", "No Existen Registros");
	}
	
	$objResponse->addScript("document.getElementById('divDABT').style.display='block';");
	
	
	return $objResponse->getXML();
}

function EliminarCuenta($data){
	global $conexion;
	
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	$folio			= 	$data["txtNumFolio"];
	$objResponse->addScript("document.location.href='sg_elimina_cuenta.php?folio=$folio'");
	
	return $objResponse->getXML();
}
function GrabarProductos($data){
	global $conexion;
	
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	$folio			= 	$data["txtNumFolio"];
	$empresa 		= 	$_SESSION["alycar_sgyonley_empresa_rut"];
	
	// busca los productos
	$sql_pd = "select 
				a.vdet_ncorr as ncorr
				
				from 
				ventas_detalle_antigua a, ventas_antigua b
				
				where
				b.vent_num_folio = '".$folio."' and
				b.empe_rut = '".$empresa."' and
				b.vent_num_folio = a.vent_ncorr";
	
	$res_pd = mysql_query($sql_pd, $conexion);
	while ($line_pd = mysql_fetch_row($res_pd)) {
		
		$ncorr		=	$line_pd[0];
		$obj_desc	= 	$line_pd[0].'txtDesc';
		$desc		=	strtoupper($data["$obj_desc"]);

		//$objResponse->addScript("alert('$obj_desc')");
		
		$sql_upd = "update ventas_detalle_antigua set
					arti_desc = '".$desc."'
					
					where vdet_ncorr = '".$ncorr."'";
		
		$res_upd = mysql_query($sql_upd,$conexion);
		
	}
	
	$objResponse->addScript("alert('Productos Modificados.')");
	
	return $objResponse->getXML();
}

function RevisaCuadratura($data){
	global $conexion;
	global $miSmarty;
	
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	$folio			= 	$data["txtNumFolio"];
	$sector			=	$_SESSION["alycar_sgyonley_sector_cuadratura"];
	$tabla_abonos	= 	"0".$_SESSION["alycar_sgyonley_empresa"]."_abonos".$sector;
	$tabla_cuotas	= 	"0".$_SESSION["alycar_sgyonley_empresa"]."_cuotas".$sector;
	$empresa		= 	$_SESSION["alycar_sgyonley_empresa_rut"];
	$usuario		= 	$_SESSION["alycar_sgyonley_usuario"];
	
	$arrRegistros	=	array();
	
	$objResponse->addScript("document.getElementById('divabonos').style.display='none';");
	$objResponse->addScript("document.getElementById('divabonosuni').style.display='none';");
	$objResponse->addScript("document.getElementById('divproductos').style.display='none';");
	$objResponse->addScript("document.getElementById('divdevoluciones').style.display='none';");
	$objResponse->addScript("document.getElementById('divDABT').style.display='none';");
	
	// busca todas las cuota pactadas para el folio (no considera las pactadas anteriores a una devolucion)
	$sql = "select
			CU_NUMCUOTA as num_cuota,
			CU_DEBE as valor_cuota
			
			FROM 
			$tabla_cuotas
			
			WHERE
			CU_FOLIO = '".$folio."' and CU_EMPRESA = '".$empresa."' AND (CU_ESTADO != 'E' OR isnull(CU_ESTADO))
			
			ORDER BY CU_NUMCUOTA ASC";
	
	$res = mysql_query($sql, $conexion);
	
	$mensaje = 0;
	
	while ($line = mysql_fetch_row($res)) {
	
		$numcuota 		= 	$line[0];
		$valorcuota		=	$line[1];
		
		$sql_ab = "select
					SUM(AB_VALOR) as monto_abono
				
					FROM 
					$tabla_abonos
				
					WHERE
					AB_FOLIO = '".$folio."' and AB_EMPRESA = '".$empresa."' AND
					AB_NUMCUOTA = '".$numcuota."' AND 
					(AB_ESTADO != 'E' OR isnull(AB_ESTADO)) 
					
					GROUP BY AB_NUMCUOTA ORDER BY AB_NUMCUOTA ASC";
		$res_ab = mysql_query($sql_ab, $conexion);
		$total_ab_cuota = @mysql_result($res_ab,0,"monto_abono");
		
		if ($valorcuota != $total_ab_cuota){
			$estado = "CUOTA NO CUADRADA";
		}else{
			$estado = "OK";
		}
		
		array_push($arrRegistros, array("folio"				=>	$folio,
										"sector"			=>	$sector,
										"cuota"				=>	$numcuota,
										"total_cuota"		=> 	$valorcuota,
										"total_abonado"		=> 	$total_ab_cuota,
										"estado"			=> 	$estado));

		if ($estado_antiguo == "CUOTA NO CUADRADA" && $estado == "OK"){
			$mensaje = 1;
		}
		
		$estado_antiguo = $estado;
		
	}
	
	
	$miSmarty->assign('USUARIO', $usuario);
	$miSmarty->assign('arrRegistros', $arrRegistros);
	$objResponse->addAssign("divcuadratura", "innerHTML", $miSmarty->fetch('sg_revision_kardex_descuadre_list.tpl'));
	$objResponse->addScript("document.getElementById('divcuadratura').style.display='block';");

	if ($mensaje == 1){
		$objResponse->addScript("alert('La Cuenta Puede Tener Descuadre, Revisar...')");
	}else{
		$objResponse->addScript("alert('Al Parecer la Cuenta No Presenta Problemas de Cuadratura...')");
	}
	
	return $objResponse->getXML();
}

function EliminaPorSoporte($data, $folio, $sector, $numcuota){
	global $conexion;
	global $miSmarty;
	
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	$tabla_abonos	= 	"0".$_SESSION["alycar_sgyonley_empresa"]."_abonos".$sector;
	$tabla_cuotas	= 	"0".$_SESSION["alycar_sgyonley_empresa"]."_cuotas".$sector;
	$empresa		= 	$_SESSION["alycar_sgyonley_empresa_rut"];
	$usuario		= 	$_SESSION["alycar_sgyonley_usuario"];
	$fechadig		= 	date("Y-m-d H:i:s");
	
	//busca la ultima fecha de la cuota seleccionada
	$sql_fup = "select AB_FECHAPAGO from $tabla_abonos where ab_folio = '".$folio."' and ab_numcuota = '".$numcuota."' and (AB_ESTADO != 'E' OR isnull(AB_ESTADO)) order by ab_numcuota asc, ab_fechapago asc limit 1";
	$res_fup = mysql_query($sql_fup,$conexion);
	$fecha_ult_pago = @mysql_result($res_fup,0,"AB_FECHAPAGO");

	//$objResponse->addScript("alert('$fecha_ult_pago')");	
	
	//borra las cuota 0 por si tuviera
	$sql_abc0 = "delete from $tabla_abonos where ab_folio = '".$folio."' and ab_numcuota = '0' and (AB_ESTADO != 'E' OR isnull(AB_ESTADO))";
	$res_abc0 = mysql_query ($sql_abc0, $conexion);

	//borra los abonos desde la $fecha_ult_pago hacia delante
	$sql_ab = "delete from $tabla_abonos where ab_folio = '".$folio."' and ab_fechapago >= '".$fecha_ult_pago."' and (AB_ESTADO != 'E' OR isnull(AB_ESTADO))";
	$res_ab = mysql_query ($sql_ab, $conexion);
	
	//busca la ultima cuota y fecha
	$sql_uca = "select ab_numcuota, DATE_FORMAT(AB_FECHAPAGO,'%d/%m/%Y') as fecha_pago from $tabla_abonos where ab_folio = '".$folio."' and (AB_ESTADO != 'E' OR isnull(AB_ESTADO)) order by ab_numcuota desc, ab_fechapago desc limit 1";
	$res_uca = mysql_query($sql_uca,$conexion);
	if (mysql_num_rows($res_uca) > 0){
		$ult_cuota 	= @mysql_result($res_uca,0,"ab_numcuota");
		$fecha_pago = @mysql_result($res_uca,0,"fecha_pago");
		
		//hace la sumatoria de la ultima cuota detectada
		$sql_suc = "select sum(ab_valor) as total_cuota from $tabla_abonos where ab_folio = '".$folio."' and ab_numcuota = '".$ult_cuota."' and (AB_ESTADO != 'E' OR isnull(AB_ESTADO))";
		$res_suc = mysql_query($sql_suc,$conexion);
		$sum_ult_cuota = @mysql_result($res_suc,0,"total_cuota");
		
		//actualiza en la tabla cuotas el valor de la sumatoria de la ult. cuota detectada
		$sql_auc = "update $tabla_cuotas set cu_haber = '".$sum_ult_cuota."' where cu_folio = '".$folio."' and cu_numcuota = '".$ult_cuota."' and (CU_ESTADO != 'E' OR isnull(CU_ESTADO))";
		$res_auc = mysql_query($sql_auc,$conexion);
		
		// igualo debe y haber de las cuotas anteriores
		$sql_idh = "update $tabla_cuotas set cu_haber = cu_debe where cu_folio = '".$folio."' and cu_numcuota < '".$ult_cuota."' and (CU_ESTADO != 'E' OR isnull(CU_ESTADO))";
		$res_idh = mysql_query($sql_idh,$conexion);
		
		// dejo las cuotas posteriores en 0
		$sql_cp = "update $tabla_cuotas set cu_haber = '0' where cu_folio = '".$folio."' and cu_numcuota > '".$ult_cuota."' and (CU_ESTADO != 'E' OR isnull(CU_ESTADO))";
		$res_cp = mysql_query($sql_cp,$conexion);
		
		$objResponse->addScript("alert('ATENCION: Abonos y Cuotas Actualizadas Correctamente, La redigitación debe considerar los abonos posteriores a $fecha_pago')");

	}else{
		
		// no tiene abonos, dejo todos los haber en 0
		// dejo las cuotas posteriores en 0
		$sql_cp = "update $tabla_cuotas set cu_haber = '0' where cu_folio = '".$folio."' and (CU_ESTADO != 'E' OR isnull(CU_ESTADO))";
		$res_cp = mysql_query($sql_cp,$conexion);
		
		$objResponse->addScript("alert('ATENCION: Se deben digitar todos los abonos de la cuenta.')");
	
	}
	
	// se bloquea el folio 02/01/2011
	$sql_bloq = "insert into folios_bloqueados_soporte (fbloq_empresa,fbloq_folio,fbloq_usuario,fbloq_fechadig)
				 values ('".$empresa."','".$folio."','".$usuario."','".$fechadig."')";
	
	$res_bloq = mysql_query($sql_bloq,$conexion);
	
	$objResponse->addScript("alert('ATENCION: Recuerde que el Folio se ha Bloqueado para el Ingreso de Cobranza...')");
	
	
	return $objResponse->getXML();
}

function Desbloquear($data){
	global $conexion;
	global $miSmarty;
	
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	$empresa		= 	$_SESSION["alycar_sgyonley_empresa_rut"];
	$folio			= 	$data["txtNumFolio"];
	$usuario		= 	$_SESSION["alycar_sgyonley_usuario"];
	$fechadig		= 	date("Y-m-d H:i:s");
	
	$sql_desbloq 	=	"select fbloq_ncorr from folios_bloqueados_soporte where fbloq_empresa = '".$empresa."' and fbloq_folio = '".$folio."' and fbloq_bloq = 'SI' order by fbloq_ncorr desc limit 1";
	$res_desbloq	=	mysql_query($sql_desbloq,$conexion);
	if (@mysql_num_rows($res_desbloq) > 0){
		$fbloq_ncorr	=	@mysql_result($res_desbloq,0,"fbloq_ncorr");
		
		$sql_upd = "update folios_bloqueados_soporte set 
						fbloq_bloq 				= 	'NO',
						fbloq_usuario_desbloq	=	'".$usuario."',
						fbloq_fechadesbloq		=	'".$fechadig."'
					where
						fbloq_ncorr = '".$fbloq_ncorr."'";
		$res_upd = mysql_query($sql_upd,$conexion);
		
		$objResponse->addScript("alert('Folio Desbloqueado, ya se puede ingresar cobranza')");
	
	}else{
		
		$objResponse->addScript("alert('El Folio ya está Desbloqueado')");
	}
	
	return $objResponse->getXML();
}


$xajax->registerFunction("RevisarAbonos");
$xajax->registerFunction("MuestraRegistro");
$xajax->registerFunction("CargaDesc");
$xajax->registerFunction("Nueva");
$xajax->registerFunction("CargaPagina");
$xajax->registerFunction("Grabar");
$xajax->registerFunction("EliminarItem");
$xajax->registerFunction("LlamaMantenedorClientes");
$xajax->registerFunction("MuestraDiv");
$xajax->registerFunction("MuestraDevoluciones");
$xajax->registerFunction("MuestraDABT");
$xajax->registerFunction("EliminarCuenta");
$xajax->registerFunction("GrabarProductos");
$xajax->registerFunction("RevisaCuadratura");
$xajax->registerFunction("EliminaPorSoporte");
$xajax->registerFunction("Desbloquear");


$xajax->processRequests();
$miSmarty->assign('xajax_js', $xajax->getJavascript());

$miSmarty->assign('folio', $_GET["folio"]);
$miSmarty->assign('empresa', $_GET["empresa"]);
$miSmarty->assign('USUARIO', $_SESSION["alycar_sgyonley_usuario"]);
$miSmarty->assign('PERFIL', $_SESSION["alycar_sgyonley_perfil"]);


$miSmarty->display('sg_ventas_revisar_preventas_informe_hv.tpl');

?>

