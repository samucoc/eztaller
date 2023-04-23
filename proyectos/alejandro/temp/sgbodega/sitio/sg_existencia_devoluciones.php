<?php
session_start();

require_once 'includes/xajax/xajax.inc.php'; //archivo de configuracion de ajax
include "../includes/php/conf_smarty.php";//archivo de configuracion de smarty
include "../includes/php/conf_bd.php"; //archivo de coneccion al servidor y base de datos
//include "../includes/php/conf_bd_antigua.php"; //archivo de coneccion al servidor de yonley
include "../includes/php/validaciones.php"; 

$xajax = new xajax();

$xajax->setRequestURI("sg_existencia_devoluciones.php");
$xajax->setCharEncoding("ISO-8859-1");
$xajax->decodeUTF8InputOn();

function Grabar($data){
	global $conexion;
	
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	$tdev_ncorr		= 	$data["OBLI-cboTipoDevolucion"];
	$GD_FOLIO		= 	$data["txtNumFolio"];
	$GD_MONTO		= 	$data["OBLI-txtTotalDevolucion"];
	$nuevo_saldo	= 	$data["OBLI-txtNuevoSaldo"];
	$saldo_favor	= 	$data["OBLI-txtSaldoFavor"];
	$empresa		=	$_SESSION["alycar_sgyonley_empresa_rut"];
	
	// BUSCA EL SECTOR Y EL VENDEDOR DE LA VENTA
	$sql_v = "select sect_ncorr, vend_ncorr from sgyonley.ventas_antigua where vent_num_folio = '".$GD_FOLIO."' and empe_rut = '".$empresa."'";
	$res_v = mysql_query($sql_v, $conexion);
	
	$sector				=	@mysql_result($res_v, 0, "sect_ncorr");
	$GD_VENDEDOR		=	@mysql_result($res_v, 0, "vend_ncorr");
	
	$GD_EMPRESA			=	$_SESSION["alycar_sgyonley_empresa_rut"];
	$empresa			=	$_SESSION["alycar_sgyonley_empresa_rut"];
	$GD_USUARIO			=	$_SESSION["alycar_sgyonley_usuario"];	
	$GD_FECHADIG		=	date("Y-m-d h:i:s");	
	$fecha_revision		= 	$data["OBLI-txtFechaRevision"];
	$fecha_descuento	= 	$data["OBLI-txtFechaDescuento"];
	$GD_OBS				= 	strtoupper(trim($data["txtObservacion"]));
	$ingresa 			= 	'SI';
	
	list($dia1,$mes1,$anio1) = split('[/.-]', $fecha_revision);	$GD_FECHA 			= $anio1."-".$mes1."-".$dia1;
	list($dia2,$mes2,$anio2) = split('[/.-]', $fecha_descuento);$SV_FECHA_DESCUENTO = $anio2."-".$mes2."-".$dia2;
	
	//revisa si se digitaron cantidades
	$sql_rev = "select vdet_ncorr as ncorr FROM sgyonley.ventas_detalle_antigua WHERE vent_ncorr = '".$GD_FOLIO."'";
	$res_rev = mysql_query($sql_rev, $conexion);
	$total_dev = 0;
	while ($line_rev = mysql_fetch_row($res_rev)) {
		$obj_cantidad	= 	$line_rev[0].'txtDev';
		$cantidad		=	$data["$obj_cantidad"];
		
		if (($cantidad > 0) && (trim($cantidad) != '')){
			$total_dev = $total_dev + $cantidad;
		}
		
	}
	
	if ($total_dev > 0){
		$ingresa = 'SI';
	}else{
		$ingresa = 'NO';
		$objResponse->addScript("alert('No Ha Ingresado Cantidades a Devolver')");
	
	}

	
/*	############	ACTIVAR ESTE CODIGO PARA EL SISTEMA DE EXISTENCIA	####################################################
	// verifico que el movimiento se tenga fecha anterior a la del ultimo inventario del vendedor
	if ($ingresa == 'SI'){
		
		$tiene_inv = VerificaCierreInv($empresa,$GD_VENDEDOR,$fecha_revision);
		if ($tiene_inv != 'NO'){
			$objResponse->addScript("alert('Fecha Incorrecta, el vendedor tiene un cierre el $tiene_inv')");
			$ingresa = "NO";
		}
	}	
*/	############	FIN		################################################################################################
	
		// bloqueo los ingresos posteriores a la fecha de cierre.
	$sql_cierre			= 	"select cier_fecha as ultimocierre 
								from sgyonley.cierres_inventarios
								order by cier_fecha desc limit 1";
	$res_cierre			= 	mysql_query($sql_cierre, $conexion);
	$ult_cierre 		= 	@mysql_result($res_cierre,0,"ultimocierre");
	
	$sql_dif 			=	"SELECT DATEDIFF('".$GD_FECHA."','".$ult_cierre."') as dias_dif";
	$res_dif			=	mysql_query($sql_dif, $conexion);
	$dias_dif			=	@mysql_result($res_dif,0,"dias_dif");

	if ($dias_dif < 0){
			$ingresa 	= 	"NO";
			$objResponse->addScript("alert('Fecha antes del cierre.')");
		}
	if ($ingresa == 'SI'){

		$sql = "insert into  sgbodega.d_guiadev (GD_FOLIO, tdev_ncorr, GD_FECHA, GD_MONTO, GD_VENDEDOR, GD_EMPRESA, GD_USUARIO, GD_FECHADIG, GD_OBS) values
				('".$GD_FOLIO."','".$tdev_ncorr."','".$GD_FECHA."','".$GD_MONTO."','".$GD_VENDEDOR."','".$GD_EMPRESA."','".$GD_USUARIO."','".$GD_FECHADIG."','".$GD_OBS."')";
		
		$res = mysql_query($sql, $conexion);
		$ncorr = mysql_insert_id($conexion);
		
		//actualiza el nº de guia
		$sql_g = "update  sgbodega.d_guiadev set GD_GUIA = '".$ncorr."' where GD_NCORR = '".$ncorr."' and GD_FOLIO = '".$GD_FOLIO."'";
		$res_g = mysql_query($sql_g, $conexion);
		
		//ingresa el detalle de la devolucion
		$sql_pd = "select 
					a.vdet_ncorr as ncorr,
					a.arti_codigo_largo as codigo,
					a.arti_desc as descripcion,
					a.vent_valor_venta as precio
					
					FROM sgyonley.ventas_detalle_antigua a, sgyonley.ventas_antigua b
					
					WHERE 
					a.vent_ncorr = '".$GD_FOLIO."' and
					a.vent_ncorr = b.vent_num_folio and
					b.empe_rut = '".$empresa."'";
		
		$res_pd = mysql_query($sql_pd, $conexion);
		while ($line_pd = mysql_fetch_row($res_pd)) {
			
			$obj_cantidad	= 	$line_pd[0].'txtDev';
			$obj_nu			=	$line_pd[0].'cboNU';
			$cantidad		=	$data["$obj_cantidad"];
			$nu				=	$data["$obj_nu"];
			$SV_CODBUS		=	$line_pd[1];
			$SV_GLOSA		=	$line_pd[2];
			$SV_VALOR		=	$cantidad * $line_pd[3];
			$movim_bodega 		=	$_SESSION['alycar_sgyonley_bodega'];
	
			if ($cantidad > 0){
				
				$sql_det = "insert into sgbodega.sub_guiadev 
							(SV_EMPRESA, SV_FOLIO, SV_GUIADV, SV_VENDEDOR, SV_CODBUS, SV_GLOSA, SV_NU, SV_CANTIDAD, SV_VALOR, SV_FECHA, SV_FECHA_DESCUENTO, SV_BODEGA) values
							('".$GD_EMPRESA."', '".$GD_FOLIO."', '".$ncorr."', '".$GD_VENDEDOR."', '".$SV_CODBUS."',
							'".$SV_GLOSA."', 'N', '".$cantidad."', '".$SV_VALOR."','".$GD_FECHA."','".$SV_FECHA_DESCUENTO."','".$movim_bodega."')";
				
				$res_det = mysql_query($sql_det, $conexion);
				
				// no aumento el stock en bodega, los productos quedan pendientes de la confirmacion de bodega
				
			}
			
		}
		
		//DEJA LAS CUOTAS Y LOS ABONOS EN ESTADO E (ELIMINADOS), LUEGO GENERA NUEVAS CUOTAS.
		if (strlen(trim($sector)) == 1){$sector = "0".$sector;}
		$tabla_abonos	= 	"0".$_SESSION["alycar_sgyonley_empresa"]."_abonos".$sector;
		$tabla_cuotas	= 	"0".$_SESSION["alycar_sgyonley_empresa"]."_cuotas".$sector;
		
		$sql_c = "update sgyonley.$tabla_cuotas set CU_ESTADO = 'E' where CU_FOLIO = '".$GD_FOLIO."'";
		$res_c = mysql_query($sql_c, $conexion);
		
		$sql_a = "update sgyonley.$tabla_abonos set AB_ESTADO = 'E' where AB_FOLIO = '".$GD_FOLIO."'";
		$res_a = mysql_query($sql_a, $conexion);
		
		$saldo			=	$data["OBLI-txtNuevoSaldo"];
		$saldo_favor	=	$data["OBLI-txtSaldoFavor"];
		
		if ($saldo > 0){
			//GENERACION DE NUEVAS CUOTAS
			$num_cuotas		=	$data["OBLI-txtNumCuotas"]; 
			$valor_cuota	=	$data["OBLI-txtValorCuotas"];
			$saldo			=	$data["OBLI-txtNuevoSaldo"];
			$fecha_venc		=	$data["txtPrimerVencimiento"];
			$tfop_codigo	= 	$data["OBLI-txtCodFormaPago"];
			$i				= 	1;
			
			//deja la venta en estado D (DEVOLUCION), nº cuotas, valor cuotas.
			$sql_v = "update sgyonley.ventas_antigua set 
						vent_valor_cuotas 	= '".$valor_cuota."',
						vent_num_cuotas 	= '".$num_cuotas."',
						vent_estado_ingreso = ''
						
						where vent_num_folio = '".$GD_FOLIO."' and empe_rut = '".$empresa."'";
			$res_v = mysql_query($sql_v, $conexion);
			// fin de actualizacion de la venta
			
			list($dia2,$mes2,$anio2) = split('[/.-]', $fecha_venc);	$fecha1 = $anio2."-".$mes2."-".$dia2;
			
			$sql_cuo = "insert into sgyonley.$tabla_cuotas (CU_EMPRESA, CU_FOLIO, CU_NUMCUOTA, CU_FECVCTO, CU_DEBE, CU_HABER) values ";
			while ($i <= $num_cuotas) {
				if ($i < $num_cuotas){
					$separador = ",";
				}else{
					$separador = ";";
					$valor_cuota = $saldo - ($valor_cuota * ($num_cuotas - 1));
				}
				
				$sql_cuo .=	"('".$empresa."','".$GD_FOLIO."','".$i."','".$fecha1."','".$valor_cuota."', '0')".$separador;
				
				//busca los dias de calculo para las fecha de pago de las cuotas.
				$sql1 = "select 
							a.prim_dias as dias 
						from 
							sgyonley.primer_vencimiento a, sgyonley.tipos_formas_pagos b
						where 
							a.tfop_ncorr = b.tfop_ncorr and
							b.tfop_codigo = '".$tfop_codigo."'";
				
				$res = mysql_query($sql1, $conexion);
				$dias = @mysql_result($res,0,"dias");
				
				//armo la fecha del primer vencimiento
				$sql2 = "SELECT DATE_ADD('".$fecha1."',INTERVAL $dias DAY) as ultima_cuota";
				$res = mysql_query($sql2, $conexion);
				$fecha1 = @mysql_result($res,0,"ultima_cuota");
				
				$i++;
			}
		
			$res_cuo = mysql_query($sql_cuo, $conexion);
		
		}else{
			
			// CON LA DEVOLUCION YA NO QUEDA SALDO POR LO TANTO LA CUENTA ESTA CANCELADA, ADEMAS SI EXISTIERA UN SALDO A FAVOR TAMBIEN LO ASIGNO A LA CUENTA.
			// A PATICION DE PILAR SE CAMBIA Y SE DEJA EN VEZ DE CANCELADA, EN DEVOLUCION
			$sql_v = "update sgyonley.ventas_antigua set 
						vent_saldo_afavor	=	'".$saldo_favor."',
						vent_estado_ingreso = 'D'
						where vent_num_folio = '".$GD_FOLIO."' and empe_rut = '".$empresa."'";
			$res_v = mysql_query($sql_v, $conexion);
		
			
		}
		
		$objResponse->addScript("alert('Devolución Ingresada Correctamente, El Nº de Guía Asignado es:  $ncorr')");
		$objResponse->addScript("window.document.Form1.submit();");
	
	}
	
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
	
	$folio 		= 	$data["txtNumFolio"];
	$empresa	= 	$_SESSION["alycar_sgyonley_empresa_rut"];
	$empe_ncorr	= 	$_SESSION["alycar_sgyonley_empresa"];
	
	// busco datos de la venta
	$sql_se = "select sect_ncorr, (vent_total_venta - vent_pie) as total_venta, vent_pie, clie_rut, vent_num_cuotas, vent_descuento, 
				vent_saldo, vent_valor_cuotas, vent_estado_ingreso, DATE_FORMAT(vent_fecha_revision,'%d/%m/%Y') as fecha_ultima_revision,
				vent_fpago, DATE_FORMAT(vent_fecha,'%d/%m/%Y') as fecha_venta, vend_ncorr
				from 
				sgyonley.ventas_antigua where vent_num_folio = '".$folio."' and empe_rut = '".$empresa."'";
	$res_se = mysql_query($sql_se, $conexion);
	if (mysql_num_rows($res_se) > 0){
		
		$line_se = mysql_fetch_row($res_se);
		
		if (($line_se[8] != 'A') AND ($line_se[8] != 'N') AND ($line_se[8] != 'B') AND ($line_se[8] != 'P')){
		
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
			
			if (trim($line_se[8]) == ''){$estado_venta 	= 	'ACTIVA';}
			if ($line_se[8] == 'A'){$estado_venta 	= 	'POR APROBAR';}	//#00CC00
			if ($line_se[8] == 'N'){$estado_venta 	= 	'NULA';}		//#FF0000
			if ($line_se[8] == 'B'){$estado_venta 	= 	'DE BAJA';}		//#FF99CC
			if ($line_se[8] == 'D'){$estado_venta 	= 	'DEVOLUCION';}	//#FF9900
			if ($line_se[8] == 'P'){$estado_venta 	= 	'PAGADA';}		//#0066FF
			
			// busca el total de traspasos
			$sql_tr = "select sum(DA_VALOR) as total_traspasos from sgyonley.descaumebaja WHERE DA_MOVI = 'T' AND DA_TRASPASADO = '".$folio."'";
			$res_tr = mysql_query($sql_tr, $conexion);
			$total_traspasos = @mysql_result($res_tr, 0, "total_traspasos");
			
			//busca el total en devoluciones
			//$sql_dev = "select sum(sv_cantidad * sv_valor) as total_dev from sgbodega.sub_guiadev where sv_folio = '".$folio."'"; //DEVOLUCIONES DEL SISTEMA NUEVO
			$sql_dev = "select sum(sv_valor) as total_dev from sgbodega.sub_guiadev where sv_folio = '".$folio."'";
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
			$tabla_abonos	= 	"0".$_SESSION["alycar_sgyonley_empresa"]."_abonos".$sector_abono;
			$tabla_clientes	= 	"0".$_SESSION["alycar_sgyonley_empresa"]."_clientes".$sector_abono;
			
			/*
			$sql_ua = "select DATE_FORMAT(AB_FECHAPAGO,'%d/%m/%Y') as fecha_abono, AB_FECHAPAGO FROM $tabla_abonos
						WHERE AB_FOLIO = '".$folio."' and AB_EMPRESA = '".$empresa."' and AB_VALOR > '0' AND (AB_ESTADO != 'E' OR isnull(AB_ESTADO))
						ORDER BY AB_FECHAPAGO DESC LIMIT 1";
			*/
			
			$sql_ua = "select DATE_FORMAT(AB_FECHAPAGO,'%d/%m/%Y') as fecha_abono, AB_FECHAPAGO FROM sgyonley.$tabla_abonos
						WHERE AB_FOLIO = '".$folio."' and AB_EMPRESA = '".$empresa."' and AB_VALOR > '0' ORDER BY AB_FECHAPAGO DESC LIMIT 1";
			
			$res_ua = mysql_query($sql_ua, $conexion);
			$line_ua = mysql_fetch_row($res_ua);
			$ult_pago = $line_ua[0];
			$fecha_ult_pago = $line_ua[1];
			
			//busca el monto del ultimo abono
			/*
			$sql_ua = "select sum(AB_VALOR) FROM $tabla_abonos
						WHERE AB_FOLIO = '".$folio."' and AB_EMPRESA = '".$empresa."' and AB_FECHAPAGO = '".$fecha_ult_pago."' AND AB_VALOR > '0' AND (AB_ESTADO != 'E' OR isnull(AB_ESTADO))";
			*/
			
			$sql_ua = "select sum(AB_VALOR) FROM sgyonley.$tabla_abonos
						WHERE AB_FOLIO = '".$folio."' and AB_EMPRESA = '".$empresa."' and AB_FECHAPAGO = '".$fecha_ult_pago."' AND AB_VALOR > '0'";
			
			$res_ua = mysql_query($sql_ua, $conexion);
			$line_ua = mysql_fetch_row($res_ua);
			$monto_ult_pago = $line_ua[0];
			// fin busqueda fecha del ultimo pago
			
			// asigna los datos de la venta
			$objResponse->addAssign("tddet1", "innerHTML", number_format($total_venta,'0','.','.'));
			$objResponse->addAssign("tddet2", "innerHTML", number_format(0,'0','.','.')); // preguntar si es el descuento de comision o descuento para cancelacion
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
			$objResponse->addAssign("tddet16", "innerHTML", $estado_venta);
			$objResponse->addAssign("tddet17", "innerHTML", $ult_pago);
			$objResponse->addAssign("tddet18", "innerHTML", number_format($monto_ult_pago,'0','.','.'));
			
			// busca al cliente
			$sql_cli = "select clie_nombre, clie_bloqueado, clie_cupo, clie_direccion, 
						clie_ciudad, clie_barrio, clie_localidad, sect_ncorr from sgyonley.$tabla_clientes where clie_rut = '".$rut_cliente."'";
			$res_cli = mysql_query($sql_cli, $conexion);
			if (@mysql_num_rows($res_cli) > 0){
				$line_cli = mysql_fetch_row($res_cli);
			}else{
				// si no encuentro al cliente lo busco en la tabla antigua
				$sql_cli = "select clie_nombre, clie_bloqueado, clie_cupo, clie_direccion, 
							clie_ciudad, clie_barrio, clie_localidad, sect_ncorr from sgyonley.clientes where clie_rut = '".$rut_cliente."'";
				$res_cli = mysql_query($sql_cli, $conexion);
				$line_cli = mysql_fetch_row($res_cli);
			}
			
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
			
			// armo la estructura para la conexion a las tablas de abonos (estan relacionadas al rut de la empresa selecionada y al sector)
			if (strlen(trim($sector)) == 1){$sector = "0".$sector;}
			
			$tabla_abonos	= 	"0".$_SESSION["alycar_sgyonley_empresa"]."_abonos".$sector;
			$tabla_cuotas	= 	"0".$_SESSION["alycar_sgyonley_empresa"]."_cuotas".$sector;
			$empresa 		= 	$_SESSION["alycar_sgyonley_empresa_rut"];
			
			// busca el total de abonos
			$sql_ta = "select sum(AB_VALOR) as total_abonos
					
					FROM 
					sgyonley.$tabla_abonos
					
					WHERE
					AB_FOLIO = '".$folio."' and AB_EMPRESA = '".$empresa."' and AB_VALOR > '0'";
			
			$res_ta = mysql_query($sql_ta, $conexion);
			$total_abonos = @mysql_result($res_ta, 0, "total_abonos");
			
			
			// busca los productos
			$sql_pd = "select
						vdet_ncorr as ncorr,
						arti_codigo_largo as codigo,
						arti_desc as descripcion,
						arti_nu as nu,
						sum(vent_cant) as cantidad,
						vent_valor_venta as precio,
						sum(vent_sub_total) as total,
						vent_ncorr as folio
					
						FROM 
						sgyonley.ventas_detalle_antigua
					
						WHERE
						vent_ncorr = '".$folio."'
						
						group by vent_ncorr, arti_codigo_largo";
			
			$res_pd = mysql_query($sql_pd, $conexion);
			$i = 1;
			$arrProductos = array();
			while ($line_pd = mysql_fetch_row($res_pd)) {
				
				$cantidad 		= $line_pd[4];
				$precio 		= $line_pd[5];
				$total_pd 		= $line_pd[6];
				
				// verifica las devoluciones.
				$sql_dev = "select sum(sv_cantidad) as cantidad, sv_folio, sv_codbus from sgbodega.sub_guiadev where sv_folio = '".$folio."' and sv_codbus = '".$line_pd[1]."'
							group by sv_folio, sv_codbus";
				
				$res_dev = mysql_query($sql_dev, $conexion);
				$can_dev = @mysql_result($res_dev, 0, "cantidad");
				
				if ($can_dev > 0){
					$cantidad = $cantidad - $can_dev;
					$total_pd = $cantidad * $precio;
				}
				
				//$objResponse->addScript("alert('$cantidad $can_dev')");
				
				if ($cantidad > 0){
					array_push($arrProductos, array("ncorr"			=> 	$line_pd[0],
													"item"			=>	$i,
													"codigo" 		=> 	$line_pd[1],
													"descripcion" 	=> 	$line_pd[2],
													"nu" 			=> 	$line_pd[3],
													"cantidad"		=> 	$cantidad,
													"precio" 		=> 	$precio,
													"total" 		=> 	$total_pd));
					
					$i++;
				}
			}
			
			$miSmarty->assign('FOLIO', $folio);
			$miSmarty->assign('VALOR_CUOTA', $valor_cuota);
			$miSmarty->assign('TOTAL_VENTA', $total_venta);
			$miSmarty->assign('SALDO_VENTA', $saldo_venta_general);
			$miSmarty->assign('TOTAL_ABONOS', $total_abonos);
			
			$objResponse->addAssign("tddet8", "innerHTML", number_format($total_abonos,'0','.','.'));
			$objResponse->addAssign("tddet9", "innerHTML", number_format($total_venta + $total_traspasos - $total_abonos - $total_dev,'0','.','.'));
			
			// asingna valores para la devolucion
			$objResponse->addAssign("OBLI-txtSaldoVenta", "value", $total_venta - $total_abonos - $total_dev);
			$objResponse->addAssign("OBLI-txtCodFormaPago", "value", $vent_forma_pago);
			$objResponse->addAssign("OBLI-txtFormaPago", "value", $forma_pago);
			$objResponse->addAssign("txtFechaUltimoPago", "value", $ult_pago);
			
			
			// si el saldo de la venta es menor o igual a 0, la cuenta quedará cnacelada
			if ($saldo_venta_general <= 0){
				$vent_estado_ingreso = 'P';
			}else{
				$vent_estado_ingreso = '';
			}
			
			$sql_vent = "update sgyonley.ventas_antigua set vent_estado_ingreso = '".$vent_estado_ingreso."' where vent_num_folio = '".$folio."' AND empe_rut = '".$empresa."'";
			$res_vent = mysql_query($sql_vent, $conexion);
			
			$objResponse->addAssign("txtSaldoVenta", "value", $saldo_venta_general - $total_abonos);
			$objResponse->addAssign("vent_saldo", "innerHTML", number_format($saldo_venta_general - $total_abonos,'0','.','.'));
			$objResponse->addAssign("vent_total_abonos", "innerHTML", number_format($total_abonos,'0','.','.'));
			
			
			$miSmarty->assign('arrRegistros', $arrRegistros);
			
			$miSmarty->assign('arrProductos', $arrProductos);
			$objResponse->addAssign("divproductos", "innerHTML", $miSmarty->fetch('sg_existencia_devoluciones_productos_list.tpl'));
			
			$objResponse->addScript("document.getElementById('OBLI-txtFechaRevision').focus();");
			$objResponse->addScript("document.getElementById('OBLI-txtFechaRevision').select();");
			
			$objResponse->addScript("document.getElementById('divcontenedorcliente').style.display='block';");
			$objResponse->addScript("document.getElementById('divcontenedor').style.display='block';");
			$objResponse->addScript("document.getElementById('divlistado').style.display='block';");
			$objResponse->addScript("document.getElementById('divdetalleventa').style.display='block';");
		
		}else{
			
			$objResponse->addScript("alert('La Venta No Está ACTIVA')");
		}
		
	}else{
		
		$objResponse->addScript("alert('Folio No Existe')");
	}
	
	
	return $objResponse->getXML();
}
function LlamaMantenedorClientes($data){
	global $conexion;
	
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	$folio	=	$data["txtNumFolio"];
	
	$sql = "select clie_rut from sgyonley.ventas_antigua where vent_num_folio = '".$folio."'";
	$res = mysql_query($sql, $conexion);
	$clie_rut = @mysql_result($res,0,"clie_rut");
	
	// busca al cliente
	$sql_cli = "select clie_nombre from sgyonley.clientes where clie_rut = '".$clie_rut."'";
	$res_cli = mysql_query($sql_cli, $conexion);
	$clie_nombre = @mysql_result($res_cli,0,"clie_nombre");
		
	$_SESSION["alycar_sgyonley_ingreso_cliente"] = 'SI';
	
	$_SESSION["alycar_sgyonley_pagina_regreso"] = 'sg_existencia_devoluciones.php';
	
	$objResponse->addScript("document.location.href='sg_mantenedor_clientes.php?folio=$folio&clie_rut=$clie_rut&clie_nombre=$clie_nombre'");
	
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
	$objResponse->addScript("document.getElementById('divproductos').style.display='none';");
	
	$objResponse->addScript("document.getElementById('$div').style.display='block';");
	
	return $objResponse->getXML();
}
function CargaDesc($data, $tabla, $campo1, $campo2, $objeto1, $objeto2, $c_and){
    global $conexion;
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	//mysql_select_db("sgyonley", $conexion);
	
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
	
	$objResponse->addScript("document.Form1.txtNumFolio.readOnly = false;");
	
	$objResponse->addAssign("txtNumFolio", "value", $folio);
	$objResponse->addScript("document.getElementById('txtNumFolio').focus();");

	return $objResponse->getXML();
}

function CargaSelect($data, $select, $tabla, $codigo, $descripcion, $campo1, $campo2, $opt){
    global $conexion;
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	$objResponse->addAssign("$select","innerHTML",""); 		
	$sql = "select $campo1 as codigo, $campo2 as descripcion from $tabla";
	$res = mysql_query($sql, $conexion);
	
	if (mysql_num_rows($res) > 0) {
		if ($opt == '1'){
			$j = 0;
		}else{
			$objResponse->addCreate("$select","option",""); 		
			$objResponse->addAssign("$select","options[0].value", $codigo);
			$objResponse->addAssign("$select","options[0].text", $descripcion); 	
			$j = 1;
		}
		while ($line = mysql_fetch_array($res)) {
			$objResponse->addCreate("$select","option",""); 		
			$objResponse->addAssign("$select","options[".$j."].value", $line[0]);
			$objResponse->addAssign("$select","options[".$j."].text", $line[1]); 	
			$j++;
		}
	}
	return $objResponse->getXML();
}
function CargaPagina($data){
    global $conexion;
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	$objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'OBLI-cboTipoDevolucion','sgyonley.tipos_devoluciones','','- - Seleccione - -','tdev_ncorr', 'tdev_desc', '')");
	
	$folio = $data["txtFolioOculto"];
	if ($folio != ''){
		$objResponse->addAssign("txtNumFolio", "value", $folio);
		$objResponse->addScript("xajax_RevisarAbonos(xajax.getFormValues('Form1'));");
	}else{
		$objResponse->addScript("document.getElementById('txtNumFolio').focus();");
	}
	
	return $objResponse->getXML();
}          
function CalculaTotalesLinea($data, $ncorr, $cant_original, $precio, $item){
	global $conexion;
	
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	$obj_cantidad	= 	$ncorr.'txtDev';
	$obj_total 		= 	$ncorr.'txtTotalDev';
	
	$cantidad		= 	$data[$obj_cantidad];
	
	if ($cantidad > $cant_original){
		$objResponse->addScript("alert('Cantidad Incorrecta en Item: $item')");
		$objResponse->addAssign("$obj_cantidad", "value", 0);
		$objResponse->addAssign("$obj_total", "value", 0);
	}else{	
		$objResponse->addAssign("$obj_total", "value", $precio * $cantidad);
	}
	
	$objResponse->addScript("xajax_Totaliza(xajax.getFormValues('Form1'));");
	
	return $objResponse->getXML();
}
function Totaliza($data){
	global $conexion;
	
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	$folio 			= 	$data["txtNumFolio"];
	
	$sql_pd = "select vdet_ncorr as ncorr FROM sgyonley.ventas_detalle_antigua
				where vent_ncorr = '".$folio."'";
	
	$res_pd = mysql_query($sql_pd, $conexion);
	while ($line_pd = mysql_fetch_row($res_pd)) {
		
		$obj_total_linea 	= 	$line_pd[0].'txtTotalDev';
		$total_linea		= 	$data[$obj_total_linea];
		$total_devolucion 	= 	$total_devolucion + $total_linea;
	}

	$objResponse->addAssign("OBLI-txtTotalDevolucion", "value", $total_devolucion);
	
	$saldo_venta	=	$data["OBLI-txtSaldoVenta"];
	
	if ($total_devolucion > 0){
		$nuevo_saldo	=	$saldo_venta - $total_devolucion;
		if ($nuevo_saldo < 0){
			$saldo_favor = $nuevo_saldo * -1;
			$objResponse->addAssign("OBLI-txtSaldoFavor", "value", $saldo_favor);
		}else{
			$objResponse->addAssign("OBLI-txtNuevoSaldo", "value", $nuevo_saldo);
		}
		
		// busca el limite de cuotas permitido para el saldo de la venta
		$tfop_codigo = $data["OBLI-txtCodFormaPago"];
		if ($nuevo_saldo > 0){
			$lim_cuotas	= 1;
			
			$sql = "select 
						a.tram_cuotas_permitidas as limite
					from 
						sgyonley.tramos a, sgyonley.tipos_formas_pagos b
					
					where 
						a.tram_desde <= '".$nuevo_saldo."' and a.tram_hasta >= '".$nuevo_saldo."' and
						a.tfop_ncorr = b.tfop_ncorr and
						b.tfop_codigo = '".$tfop_codigo."'";
			
			$res = mysql_query($sql, $conexion);
			if (mysql_num_rows($res) > 0){
				$lim_cuotas = @mysql_result($res,0,"limite");
			}
			
			$objResponse->addAssign("OBLI-txtNumCuotas", "value", $lim_cuotas);
			$objResponse->addAssign("OBLI-txtLimiteCuotas", "value", $lim_cuotas);
			
			if ($nuevo_saldo > 0 && $lim_cuotas > 0){
				$objResponse->addAssign("OBLI-txtValorCuotas", "value", round($nuevo_saldo / $lim_cuotas));
			}else{
				$objResponse->addAssign("OBLI-txtValorCuotas", "value", 0);
			}
			
			$objResponse->addScript("xajax_CalculaPrimerVencimiento(xajax.getFormValues('Form1'));");
		
		}else{
			$objResponse->addAssign("OBLI-txtNumCuotas", "value", 0);
			$objResponse->addAssign("OBLI-txtLimiteCuotas", "value", 0);
			$objResponse->addAssign("OBLI-txtValorCuotas", "value", 0);
			$objResponse->addAssign("txtPrimerVencimiento", "value", '');
		}	
	
	}else{
		
		$objResponse->addAssign("OBLI-txtSaldoFavor", "value", 0);
		$objResponse->addAssign("OBLI-txtNuevoSaldo", "value", 0);
		$objResponse->addAssign("OBLI-txtNumCuotas", "value", 0);
		$objResponse->addAssign("OBLI-txtLimiteCuotas", "value", 0);
		$objResponse->addAssign("OBLI-txtValorCuotas", "value", 0);
		$objResponse->addAssign("txtPrimerVencimiento", "value", '');
		
	}		
	
	return $objResponse->getXML();
}

function CalculaPrimerVencimiento($data){
	global $conexion;
	
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	$tfop_codigo		= 	$data["OBLI-txtCodFormaPago"];
	$fecha_ult_pago		= 	$data["txtFechaUltimoPago"];
	$fecha_devolucion	= 	$data["OBLI-txtFechaRevision"];
	
	if ($fecha_ult_pago	== ''){
		if ($fecha_devolucion != ''){
			$fecha_ult_pago = $fecha_devolucion;
		}
	}
	if ($fecha_ult_pago != ''){
		list($dia1,$mes1,$anio1) = split('[/.-]', $fecha_ult_pago);
		$fecha_ini = $anio1."/".$mes1."/".$dia1;
		
		//busca el primer vencimiento asociado a la forma de pago.
		$sql = "select 
					a.prim_dias as dias
				
				from 
					sgyonley.primer_vencimiento a, sgyonley.tipos_formas_pagos b
				
				where 
					a.tfop_ncorr = b.tfop_ncorr and
					b.tfop_codigo = '".$tfop_codigo."'";
		
		$res = mysql_query($sql, $conexion);
		$dias_primer_venc = @mysql_result($res,0,"dias");
		
		//armo la fecha del primer vencimiento
		$sql = "SELECT DATE_FORMAT(DATE_ADD('".$fecha_ini."',INTERVAL $dias_primer_venc DAY),'%d/%m/%Y') as fecha_primer_venc";
		$res = mysql_query($sql, $conexion);
		$fecha_primer_venc = @mysql_result($res,0,"fecha_primer_venc");

		$objResponse->addAssign("txtPrimerVencimiento", "value", $fecha_primer_venc);
	}else{
		$objResponse->addAssign("txtPrimerVencimiento", "value", '');
	}
	
	return $objResponse->getXML();
}

$xajax->registerFunction("RevisarAbonos");
$xajax->registerFunction("MuestraRegistro");
$xajax->registerFunction("CargaDesc");
$xajax->registerFunction("Nueva");
$xajax->registerFunction("CargaPagina");
$xajax->registerFunction("Grabar");
$xajax->registerFunction("CalculaTotalesLinea");
$xajax->registerFunction("LlamaMantenedorClientes");
$xajax->registerFunction("MuestraDiv");
$xajax->registerFunction("Totaliza");
$xajax->registerFunction("CalculaPrimerVencimiento");
$xajax->registerFunction("CargaSelect");

$xajax->processRequests();
$miSmarty->assign('xajax_js', $xajax->getJavascript());

$miSmarty->assign('FOLIO', $_GET["folio"]);

$miSmarty->display('sg_existencia_devoluciones.tpl');

?>

