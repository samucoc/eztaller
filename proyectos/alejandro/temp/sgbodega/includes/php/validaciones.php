<?php
include "../includes/php/conf_bd.php"; //archivo de coneccion al servidor y base de datos

function TotalCV($tabla_abonos,$tabla_cuotas,$empe_rut,$fecha_limite,$fecha_termino,$sector,$fecha_rev_kardex,$sector_format,$empe_ncorr) {
	
	global $conexion;	
	
	// ##############################################################################################################################################						
	// #####################	INICIO DE RUTINA PARA EL CALCULO DEL TOTAL DE CUOTAS VENCIDAS #######################################################						
	//	ACTUALIZADO AL 15/06/2012 A SOLICITUD DE JAVIER
	$sql_tr = "truncate table temp_folios_cv";	
	$res_tr = mysql_query($sql_tr,$conexion);
	
	// nueva consulta, considera solo las cv cuya fecha de ultimo abono sea menor a fecha_limite (inicio del periodo)
	// solicitado por javier (27/04/2011)
	$sql_tcv 	= "select 
					a.CU_FOLIO, a.CU_NUMCUOTA, a.CU_DEBE, b.vent_estado_ingreso, b.vent_num_cuotas, a.CU_NCORR
					from $tabla_cuotas a, ventas_antigua b
					WHERE 
					a.CU_EMPRESA = '".$empe_rut."' and a.CU_FECVCTO < '".$fecha_limite."' AND 
					a.CU_FOLIO = b.vent_num_folio and
					b.empe_rut = '".$empe_rut."' and
					b.sect_ncorr = '".$sector."' and
					b.vent_estado_ingreso != 'A' and b.vent_estado_ingreso != 'N' and
					b.vent_num_cuotas > '0' and b.vent_valor_cuotas > '0' and
					b.vent_estado = 'FINALIZADA' and
					b.vent_fecha_revision >= '".$fecha_rev_kardex."'
					
					GROUP BY 
					a.cu_folio, a.CU_NUMCUOTA
					
					ORDER BY
					a.cu_folio, a.CU_NUMCUOTA asc, a.CU_NCORR desc";
					
	$res_tcv 	= mysql_query($sql_tcv, $conexion);
	
	$total_cuotas_vencidas	=	0;
	
	while ($line_tcv = @mysql_fetch_row($res_tcv)) {
		
		$folio				=	$line_tcv[0];
		$cuota				=	$line_tcv[1];
		$debe				=	$line_tcv[2];
		$haber 				= 	0;
		$saldo				=	0;
		$estado				=	trim($line_tcv[3]);
		$num_cuotas			=	$line_tcv[4];
		$cobranza_vencida	=	0;
		
		// verifica si tiene descuadre
		// 27/08/2012
		$descuadre = 'NO';
		//$descuadre = RevisaDescuadre($folio,$empe_rut,$sector_format,$empe_ncorr);
		
		if ($descuadre == 'NO'){
		
			$canc_con_desc	= 	'NO';
			$con_dv			= 	'NO';
			$logica 		= 	'CA';
			$cambio_sector	=	'NO';
			
			// verifico si el folio estuvo en otro sector
			// antes de la fecha del primer filtro
			// si estuvo en otro sector entonces el resultado será cero
			// para periodos anteriores al cambio de sector
			$sql_osec = "select sect_ncorr_actual from ventas_cambio_sector 
							where
							empe_rut = '".$empe_rut."' and
							vent_num_folio = '".$folio."' and
							sect_ncorr_nuevo = '".$sector."' and
							vcse_fecha_dig > '".$fecha_limite."' and
							vcse_fecha_dig > '".$fecha_termino."'";
			
			$res_osec = mysql_query($sql_osec,$conexion);
			if (@mysql_num_rows($res_osec) > 0){
				$logica = 'CF';			
				$cambio_sector = 'SI';
			}
			
			if ($cambio_sector == 'NO'){
				// 15/06/2012 busco si el folio fue cancelado con descuento, solicitado por javier
				// el total de cuotas vencidas omite los folios cancelados con descuentos
				// 28/06/2012 nueva modificacion, javier pide que considere los folios cancelados con descuento
				// que estuvieron activos en el periodo consultado
				//	CA = logica cuentas activas
				//	CD = logica canceladas con descuento
				
				if ($estado == 'P'){ // CANC CON DESC
					
					// busco si la cuenta fue cancelada con descuento
					$sql_desc = "select desc_ncorr, desc_fecha from descuentos where empe_ncorr = '".$empe_ncorr."' and 
								vent_num_folio = '".$folio."' and desc_fecha >= '".$fecha_limite."' and desc_fecha <= '".$fecha_termino."' and
								desc_autorizado = 'SI'";
					$res_desc = mysql_query($sql_desc,$conexion);
					if (@mysql_num_rows($res_desc) > 0){
						$canc_con_desc	= 'SI';
						$desc_fecha		= @mysql_result($res_desc,0,"desc_fecha");
					}
					
					$sql_desc = "select desc_ncorr, desc_fecha from descuentos where empe_ncorr = '".$empe_ncorr."' and 
								vent_num_folio = '".$folio."' and desc_fecha < '".$fecha_limite."' and desc_fecha < '".$fecha_termino."' and
								desc_autorizado = 'SI'";
					$res_desc = mysql_query($sql_desc,$conexion);
					if (@mysql_num_rows($res_desc) > 0){
						$logica = 'CF';
					}
					
				}
				if ($estado == 'B'){ // DE BAJA
					// busco si la cuenta fue dada de baja
					$sql_desc = "select da_ncorr, da_fecha from descaumebaja where da_folio = '".$folio."' and 
								da_movi = 'B' and da_fecha >= '".$fecha_limite."' and da_fecha <= '".$fecha_termino."'";
					$res_desc = mysql_query($sql_desc,$conexion);
					if (@mysql_num_rows($res_desc) > 0){
						$canc_con_desc	= 'SI';
						$desc_fecha		= @mysql_result($res_desc,0,"da_fecha");
					}
					
					$sql_desc = "select da_ncorr, da_fecha from descaumebaja where da_folio = '".$folio."' and 
								da_movi = 'B' and da_fecha < '".$fecha_limite."' and da_fecha < '".$fecha_termino."'";
					$res_desc = mysql_query($sql_desc,$conexion);
					if (@mysql_num_rows($res_desc) > 0){
						$logica = 'CF';
					}
				}
				
				if ($canc_con_desc == 'NO'){
					// busca si la cuenta tuvo devoluciones
					$sql_dv = "select gd_ncorr, gd_fecha from d_guiadev where gd_empresa = '".$empe_rut."' and 
								gd_folio = '".$folio."' and gd_fecha >= '".$fecha_limite."' and gd_fecha <= '".$fecha_termino."'";
					$res_dv = mysql_query($sql_dv,$conexion);
					if (@mysql_num_rows($res_dv) > 0){
						$con_dv	= 'SI';
						$desc_fecha		= 	@mysql_result($res_dv,0,"gd_fecha");
						//$filtro_dv		=	" and AB_FECHAPAGO > '".$desc_fecha."'";
					}
					
					$sql_dv2 = "select gd_ncorr, gd_fecha from d_guiadev where gd_empresa = '".$empe_rut."' and 
								gd_folio = '".$folio."' and gd_fecha < '".$fecha_limite."' and gd_fecha < '".$fecha_termino."'";
					$res_dv2 = mysql_query($sql_dv2,$conexion);
					if (@mysql_num_rows($res_dv2) > 0){
						if ($estado == 'D' OR $estado == 'P'){
							$logica = 'CF';
						}else{
							$filtro_fecha 	= 	@mysql_result($res_dv2,0,"gd_fecha");
							$logica 		= 	'CA2';
						}	
					}
				}	
				
				if ($canc_con_desc == 'SI' OR $con_dv == 'SI'){
					// verifico si la fecha de descuento esta entre las fechas del periodo
					$sql_f1		= 	"SELECT DATEDIFF('".$desc_fecha."','".$fecha_limite."') as dias_f1";
					$res_f1		= 	mysql_query($sql_f1,$conexion);
					$dias_f1	=	@mysql_result($res_f1,0,"dias_f1");
					
					$sql_f2		= 	"SELECT DATEDIFF('".$desc_fecha."','".$fecha_termino."') as dias_f2";
					$res_f2		= 	mysql_query($sql_f2,$conexion);
					$dias_f2	=	@mysql_result($res_f2,0,"dias_f2");
					
					// fecha de descuento dentro del periodo consultado
					if ($dias_f1 >= 0 && $dias_f2 <= 0){
						$logica = 'CD';
					}	
				
				}
			}
			
			if ($logica == 'CA'){
				$sql_tabo 	= "select 
								sum(AB_VALOR) as total_haber
								from $tabla_abonos
								WHERE 
								AB_EMPRESA = '".$empe_rut."' and AB_SECTOR = '".$sector."' AND
								AB_FECHAPAGO < '".$fecha_limite."' and
								ab_folio = '".$folio."' and
								ab_numcuota = '".$cuota."'";
				$res_tabo 	=  	mysql_query($sql_tabo, $conexion);
				$haber		=	@mysql_result($res_tabo,0,"total_haber");
			}
			if ($logica == 'CA2'){
				// busco el debe de la cuota activa
				$sql_dca	=	"select cu_debe from $tabla_cuotas where 
									cu_folio = '".$folio."' and 
									cu_numcuota = '".$cuota."' AND
									CU_FECVCTO < '".$fecha_limite."' and
									(CU_ESTADO != 'E' OR isnull(CU_ESTADO))
									order by cu_ncorr desc limit 1";
				$res_dca	=	mysql_query($sql_dca,$conexion);
				
				if (@mysql_num_rows($res_dca) > 0){
					$debe		=	@mysql_result($res_dca,0,"cu_debe");
					
					$sql_tabo 	= "select 
									sum(AB_VALOR) as total_haber
									from $tabla_abonos
									WHERE 
									AB_EMPRESA = '".$empe_rut."' and AB_SECTOR = '".$sector."' AND
									AB_FECHAPAGO < '".$fecha_limite."' and
									ab_folio = '".$folio."' and
									ab_numcuota = '".$cuota."' and
									(AB_ESTADO != 'E' OR isnull(AB_ESTADO))";
					$res_tabo 	=  	mysql_query($sql_tabo, $conexion);
					$haber		=	@mysql_result($res_tabo,0,"total_haber");
				}else{
					$debe		=	0;
				}
			}
			
			if ($logica == 'CD'){
				$sql_cv = "select tfcv_ncorr from temp_folios_cv where tfcv_folio = '".$folio."'";
				$res_cv = mysql_query($sql_cv,$conexion);
				if (@mysql_num_rows($res_cv) < 1){
					
					$sql_cape 	= "select 
									sum(AB_VALOR) as total_haber_per
									from $tabla_abonos
									WHERE 
									AB_EMPRESA = '".$empe_rut."' and AB_SECTOR = '".$sector."' AND
									ab_folio = '".$folio."' and
									AB_FECHAPAGO >= '".$fecha_limite."' and AB_FECHAPAGO <= '".$fecha_termino."' and
									AB_FECHAVENCI < '".$fecha_limite."'";
					$res_cape	=  	mysql_query($sql_cape, $conexion);
					
					$haber		=	@mysql_result($res_cape,0,"total_haber_per");
						
					$sql_ing 	= "insert into temp_folios_cv (tfcv_folio) values ('".$folio."')";
					$res_ing 	= mysql_query($sql_ing,$conexion);
				}
			}
			
			// busca los traspasos que ha hecho el folio a otros folios antes de la fecha de término
			$sql_trp = "select sum(da_valor) as total_traspasado from descaumebaja
						where 
						da_folio = '".$folio."' and
						da_movi = 'T' and 
						da_fecha <= '".$fecha_termino."'";
			$res_trp = mysql_query($sql_trp,$conexion);
			$total_traspasado = @mysql_result($res_trp,0,"total_traspasado");		
		
			// busca los traspasos que le han hecho al folio desde otros folios antes de la fecha de termino
			$sql_tra = "select sum(da_valor) as total_traspasos from descaumebaja
						where 
						da_traspasado = '".$folio."' and
						da_movi = 'T' and 
						da_fecha <= '".$fecha_termino."'";
			$res_tra = mysql_query($sql_tra,$conexion);
			$total_traspasos = @mysql_result($res_tra,0,"total_traspasos");		
			
			if ($logica == 'CA' OR $logica == 'CA2'){
				$saldo		=	$debe + $total_traspasado - $haber - $total_traspasos;
			}
			if ($logica == 'CD'){
				$saldo		=	$haber + $total_traspasos - $total_traspasado;
			
			}
			if ($logica == 'CF'){
				$saldo		=	0;
			
			}
			if ($saldo > 0){
				$total_cuotas_vencidas = $total_cuotas_vencidas + $saldo;
			
				/*
				// ingresa en la tabla temporal
				$tfcv_origen	=	$logica." "."SIN CAMBIO SECTOR";
				$sql_temp 		= 	"insert into temp_folios_cv (tfcv_folio,tfcv_cuota,tfcv_saldo,tfcv_origen)
									values ('".$folio."','".$cuota."','".$saldo."','".$tfcv_origen."')";
				$res_temp 		= 	mysql_query($sql_temp,$conexion);
				*/
			}
			
		}
		
	}

	// busca el total de cuotas vencidas pero de los folios con cambios de sector
	// que en el rango consultado estaban en el sector
	// solicitado por javier (07/06/2012)
	// busco los folios que estaban en el sector dentro del rango consultado
	$sql_tcvcs 	= "select 
					a.CU_FOLIO, a.CU_NUMCUOTA, a.CU_DEBE, b.vent_estado_ingreso, b.vent_num_cuotas, a.CU_NCORR
					from $tabla_cuotas a, ventas_antigua b, ventas_cambio_sector c
					WHERE 
					a.CU_EMPRESA = '".$empe_rut."' and a.CU_FECVCTO < '".$fecha_limite."' AND 
					(a.CU_ESTADO != 'E' OR isnull(a.CU_ESTADO)) AND
					a.CU_FOLIO = b.vent_num_folio and
					b.empe_rut = '".$empe_rut."' and
					b.vent_estado_ingreso != 'A' and b.vent_estado_ingreso != 'N' and
					b.vent_num_cuotas > '0' and b.vent_valor_cuotas > '0' and
					b.vent_estado = 'FINALIZADA' and
					b.vent_fecha_revision >= '".$fecha_rev_kardex."' and
					b.vent_num_folio = c.vent_num_folio and
					c.empe_rut = '".$empe_rut."' and 
					c.vcse_fecha_dig > '".$fecha_termino."' and
					c.sect_ncorr_actual = '".$sector."'
					
					GROUP BY 
					a.cu_folio, a.CU_NUMCUOTA
					
					ORDER BY
					a.cu_folio, a.CU_NUMCUOTA asc, a.CU_NCORR desc";
	
	$res_tcvcs 	= mysql_query($sql_tcvcs, $conexion);

	while ($line_tcvcs = @mysql_fetch_row($res_tcvcs)) {
		
		$folio			= 	$line_tcvcs[0];
		$cuota			=	$line_tcvcs[1];
		$debe			=	$line_tcvcs[2];
		$haber			=	0;
		$saldo			=	0;
		$estado			=	$line_tcvcs[3];
		$num_cuotas		=	$line_tcvcs[4];
		
		
		// verifica si tiene descuadre
		// 27/08/2012
		$descuadre = 'NO';
		//$descuadre = RevisaDescuadre($folio,$empe_rut,$sector_format,$empe_ncorr);
		
		if ($descuadre == 'NO'){
		
			// 15/06/2012 busco si el folio fue cancelado con descuento, solicitado por javier
			// el total de cuotas vencidas omite los folios cancelados con descuentos
			// 28/06/2012 nueva modificacion, javier pide que considere los folios cancelados con descuento
			// que estuvieron activos en el periodo consultado
			
			$canc_con_desc	= 	'NO';
			$con_dv			= 	'NO';
			$logica 		= 	'CA';
			
			if ($estado == 'P'){
				
				// busco si la cuenta fue cancelada con descuento
				$sql_desc = "select desc_ncorr, desc_fecha from descuentos where empe_ncorr = '".$empe_ncorr."' and 
							vent_num_folio = '".$folio."' and desc_fecha >= '".$fecha_limite."' and desc_fecha <= '".$fecha_termino."' and
							desc_autorizado = 'SI'";
				$res_desc = mysql_query($sql_desc,$conexion);
				if (@mysql_num_rows($res_desc) > 0){
					$canc_con_desc	= 'SI';
					$desc_fecha		= @mysql_result($res_desc,0,"desc_fecha");
				}
				
				$sql_desc = "select desc_ncorr, desc_fecha from descuentos where empe_ncorr = '".$empe_ncorr."' and 
							vent_num_folio = '".$folio."' and desc_fecha < '".$fecha_limite."' and desc_fecha < '".$fecha_termino."' and
							desc_autorizado = 'SI'";
				$res_desc = mysql_query($sql_desc,$conexion);
				if (@mysql_num_rows($res_desc) > 0){
					$logica = 'CF';
				}
			}
			if ($estado == 'B'){ // DE BAJA
				// busco si la cuenta fue dada de baja
				$sql_desc = "select da_ncorr, da_fecha from descaumebaja where da_folio = '".$folio."' and 
							da_movi = 'B' and da_fecha >= '".$fecha_limite."' and da_fecha <= '".$fecha_termino."'";
				$res_desc = mysql_query($sql_desc,$conexion);
				if (@mysql_num_rows($res_desc) > 0){
					$canc_con_desc	= 'SI';
					$desc_fecha		= @mysql_result($res_desc,0,"da_fecha");
				}
				
				$sql_desc = "select da_ncorr, da_fecha from descaumebaja where da_folio = '".$folio."' and 
							da_movi = 'B' and da_fecha < '".$fecha_limite."' and da_fecha < '".$fecha_termino."'";
				$res_desc = mysql_query($sql_desc,$conexion);
				if (@mysql_num_rows($res_desc) > 0){
					$logica = 'CF';
				}
			}
			
			if ($canc_con_desc == 'NO'){
				// busca si la cuenta tuvo devoluciones
				$sql_dv = "select gd_ncorr, gd_fecha from d_guiadev where gd_empresa = '".$empe_rut."' and 
							gd_folio = '".$folio."' and gd_fecha >= '".$fecha_limite."' and gd_fecha <= '".$fecha_termino."'";
				$res_dv = mysql_query($sql_dv,$conexion);
				if (@mysql_num_rows($res_dv) > 0){
					$con_dv	= 'SI';
					$desc_fecha		= 	@mysql_result($res_dv,0,"gd_fecha");
					//$filtro_dv		=	" and AB_FECHAPAGO > '".$desc_fecha."'";
				}
				
				$sql_dv2 = "select gd_ncorr, gd_fecha from d_guiadev where gd_empresa = '".$empe_rut."' and 
							gd_folio = '".$folio."' and gd_fecha < '".$fecha_limite."' and gd_fecha < '".$fecha_termino."'";
				$res_dv2 = mysql_query($sql_dv2,$conexion);
				if (@mysql_num_rows($res_dv2) > 0){
					if ($estado == 'D'  OR $estado == 'P'){
						$logica = 'CF';
					}else{
						$filtro_fecha 	= 	@mysql_result($res_dv2,0,"gd_fecha");
						$logica 		= 	'CA2';
					}
				}
			}	
			
			if ($canc_con_desc == 'SI' OR $con_dv == 'SI'){
				// verifico si la fecha de descuento esta entre las fechas del periodo
				$sql_f1		= 	"SELECT DATEDIFF('".$desc_fecha."','".$fecha_limite."') as dias_f1";
				$res_f1		= 	mysql_query($sql_f1,$conexion);
				$dias_f1	=	@mysql_result($res_f1,0,"dias_f1");
				
				$sql_f2		= 	"SELECT DATEDIFF('".$desc_fecha."','".$fecha_termino."') as dias_f2";
				$res_f2		= 	mysql_query($sql_f2,$conexion);
				$dias_f2	=	@mysql_result($res_f2,0,"dias_f2");
				
				// fecha de descuento dentro del periodo consultado
				if ($dias_f1 >= 0 && $dias_f2 <= 0){
					$logica = 'CD';
				}	
			
			}
			
			if ($logica == 'CA'){
				$sql_tabo 	= "select 
								sum(AB_VALOR) as total_haber
								from $tabla_abonos
								WHERE 
								AB_EMPRESA = '".$empe_rut."' and AB_SECTOR = '".$sector."' AND
								AB_FECHAPAGO < '".$fecha_limite."' and
								ab_folio = '".$folio."' and
								ab_numcuota = '".$cuota."'";
				$res_tabo 	=  	mysql_query($sql_tabo, $conexion);
				$haber		=	@mysql_result($res_tabo,0,"total_haber");
			}
			if ($logica == 'CA2'){
				// busco el debe de la cuota activa
				$sql_dca	=	"select cu_debe from $tabla_cuotas where 
									cu_folio = '".$folio."' and 
									cu_numcuota = '".$cuota."' AND
									CU_FECVCTO < '".$fecha_limite."' and
									(CU_ESTADO != 'E' OR isnull(CU_ESTADO))
									order by cu_ncorr desc limit 1";
				$res_dca	=	mysql_query($sql_dca,$conexion);
				
				if (@mysql_num_rows($res_dca) > 0){
					$debe		=	@mysql_result($res_dca,0,"cu_debe");
					
					$sql_tabo 	= "select 
									sum(AB_VALOR) as total_haber
									from $tabla_abonos
									WHERE 
									AB_EMPRESA = '".$empe_rut."' and AB_SECTOR = '".$sector."' AND
									AB_FECHAPAGO < '".$fecha_limite."' and
									ab_folio = '".$folio."' and
									ab_numcuota = '".$cuota."' and
									(AB_ESTADO != 'E' OR isnull(AB_ESTADO))";
					$res_tabo 	=  	mysql_query($sql_tabo, $conexion);
					$haber		=	@mysql_result($res_tabo,0,"total_haber");
				}else{
					$debe		=	0;
				}
			}
			
			if ($logica == 'CD'){
				$sql_cv = "select tfcv_ncorr from temp_folios_cv where tfcv_folio = '".$folio."'";
				$res_cv = mysql_query($sql_cv,$conexion);
				if (@mysql_num_rows($res_cv) < 1){
					
					$sql_cape 	= "select 
									sum(AB_VALOR) as total_haber_per
									from $tabla_abonos
									WHERE 
									AB_EMPRESA = '".$empe_rut."' and AB_SECTOR = '".$sector."' AND
									ab_folio = '".$folio."' and
									AB_FECHAPAGO >= '".$fecha_limite."' and AB_FECHAPAGO <= '".$fecha_termino."' and
									AB_FECHAVENCI < '".$fecha_limite."'";
					$res_cape	=  	mysql_query($sql_cape, $conexion);
					
					$haber	=	@mysql_result($res_cape,0,"total_haber_per");
						
					$sql_ing = "insert into temp_folios_cv (tfcv_folio) values ('".$folio."')";
					$res_ing = mysql_query($sql_ing,$conexion);
				}
			}
			
			// busca los traspasos que ha hecho el folio a otros folios antes de la fecha de término
			$sql_trp = "select sum(da_valor) as total_traspasado from descaumebaja
						where 
						da_folio = '".$folio."' and
						da_movi = 'T' and 
						da_fecha <= '".$fecha_termino."'";
			$res_trp = mysql_query($sql_trp,$conexion);
			$total_traspasado = @mysql_result($res_trp,0,"total_traspasado");		
		
			// busca los traspasos que le han hecho al folio desde otros folios antes de la fecha de termino
			$sql_tra = "select sum(da_valor) as total_traspasos from descaumebaja
						where 
						da_traspasado = '".$folio."' and
						da_movi = 'T' and 
						da_fecha <= '".$fecha_termino."'";
			$res_tra = mysql_query($sql_tra,$conexion);
			$total_traspasos = @mysql_result($res_tra,0,"total_traspasos");		
			
			if ($logica == 'CA' OR $logica == 'CA2'){
				$saldo		=	$debe + $total_traspasado - $haber - $total_traspasos;
			}
			if ($logica == 'CD'){
				$saldo		=	$haber + $total_traspasos - $total_traspasado;
			
			}
			if ($logica == 'CF'){
				$saldo		=	0;
			
			}
			if ($saldo > 0){
				$total_cuotas_vencidas = $total_cuotas_vencidas + $saldo;
				
				/*
				// ingresa en la tabla temporal
				$tfcv_origen	=	$logica." "."CON CAMBIO SECTOR";
				$sql_temp 		= 	"insert into temp_folios_cv (tfcv_folio,tfcv_cuota,tfcv_saldo,tfcv_origen)
									values ('".$folio."','".$cuota."','".$saldo."','".$tfcv_origen."')";
				$res_temp 		= 	mysql_query($sql_temp,$conexion);
				*/
				
			}
		}
	}
	
// #####################	FIN DE RUTINA PARA EL CALCULO DEL TOTAL DE CUOTAS VENCIDAS		#######################################################						
// ################################################################################################################################################						
	return $total_cuotas_vencidas."#".$logica;

}

function TotalCV_folio($tabla_abonos,$tabla_cuotas,$empe_rut,$fecha_limite,$fecha_termino,$sector,$fecha_rev_kardex,$sector_format,$empe_ncorr,$folio_buscar) {
	
	global $conexion;	
	
	// ##############################################################################################################################################						
	// #####################	INICIO DE RUTINA PARA EL CALCULO DEL TOTAL DE CUOTAS VENCIDAS #######################################################						
	//	ACTUALIZADO AL 15/06/2012 A SOLICITUD DE JAVIER
	$logica = "";
	// nueva consulta, considera solo las cv cuya fecha de ultimo abono sea menor a fecha_limite (inicio del periodo)
	// solicitado por javier (27/04/2011)
	$sql_tcv 	= "select 
					a.CU_FOLIO, a.CU_NUMCUOTA, a.CU_DEBE, b.vent_estado_ingreso, b.vent_num_cuotas, a.CU_NCORR
					from $tabla_cuotas a, ventas_antigua b
					WHERE 
					a.CU_EMPRESA = '".$empe_rut."' and a.CU_FECVCTO < '".$fecha_limite."' AND 
					a.CU_FOLIO = b.vent_num_folio and
					b.vent_num_folio = '".$folio_buscar."'
					
					GROUP BY 
					a.cu_folio, a.CU_NUMCUOTA
					
					ORDER BY
					a.cu_folio, a.CU_NUMCUOTA asc, a.CU_NCORR desc";
					
	$res_tcv 	= mysql_query($sql_tcv, $conexion);
	
	$total_cuotas_vencidas	=	0;
	
	while ($line_tcv = @mysql_fetch_row($res_tcv)) {
		
		$folio				=	$line_tcv[0];
		$cuota				=	$line_tcv[1];
		$debe				=	$line_tcv[2];
		$haber 				= 	0;
		$saldo				=	0;
		$estado				=	trim($line_tcv[3]);
		$num_cuotas			=	$line_tcv[4];
		$cobranza_vencida	=	0;
		
		// verifica si tiene descuadre
		// 27/08/2012
		$descuadre = 'NO';
		//$descuadre = RevisaDescuadre($folio,$empe_rut,$sector_format,$empe_ncorr);
		
		if ($descuadre == 'NO'){
		
			$canc_con_desc	= 	'NO';
			$con_dv			= 	'NO';
			$logica 		= 	'CA';
			$cambio_sector	=	'NO';
			
			// verifico si el folio estuvo en otro sector
			// antes de la fecha del primer filtro
			// si estuvo en otro sector entonces el resultado será cero
			// para periodos anteriores al cambio de sector
			$sql_osec = "select sect_ncorr_actual from ventas_cambio_sector 
							where
							empe_rut = '".$empe_rut."' and
							vent_num_folio = '".$folio."' and
							sect_ncorr_nuevo = '".$sector."' and
							vcse_fecha_dig > '".$fecha_limite."' and
							vcse_fecha_dig > '".$fecha_termino."'";
			
			$res_osec = mysql_query($sql_osec,$conexion);
			if (@mysql_num_rows($res_osec) > 0){
				$logica = 'CF';			
				$cambio_sector = 'SI';
			}
			
			if ($cambio_sector == 'NO'){
				// 15/06/2012 busco si el folio fue cancelado con descuento, solicitado por javier
				// el total de cuotas vencidas omite los folios cancelados con descuentos
				// 28/06/2012 nueva modificacion, javier pide que considere los folios cancelados con descuento
				// que estuvieron activos en el periodo consultado
				//	CA = logica cuentas activas
				//	CD = logica canceladas con descuento
				
				if ($estado == 'P'){ // CANC CON DESC
					
					// busco si la cuenta fue cancelada con descuento
					$sql_desc = "select desc_ncorr, desc_fecha from descuentos where empe_ncorr = '".$empe_ncorr."' and 
								vent_num_folio = '".$folio."' and desc_fecha >= '".$fecha_limite."' and desc_fecha <= '".$fecha_termino."' and
								desc_autorizado = 'SI'";
					$res_desc = mysql_query($sql_desc,$conexion);
					if (@mysql_num_rows($res_desc) > 0){
						$canc_con_desc	= 'SI';
						$desc_fecha		= @mysql_result($res_desc,0,"desc_fecha");
					}
					
					$sql_desc = "select desc_ncorr, desc_fecha from descuentos where empe_ncorr = '".$empe_ncorr."' and 
								vent_num_folio = '".$folio."' and desc_fecha < '".$fecha_limite."' and desc_fecha < '".$fecha_termino."' and
								desc_autorizado = 'SI'";
					$res_desc = mysql_query($sql_desc,$conexion);
					if (@mysql_num_rows($res_desc) > 0){
						$logica = 'CF';
					}
					
				}
				if ($estado == 'B'){ // DE BAJA
					// busco si la cuenta fue dada de baja
					$sql_desc = "select da_ncorr, da_fecha from descaumebaja where da_folio = '".$folio."' and 
								da_movi = 'B' and da_fecha >= '".$fecha_limite."' and da_fecha <= '".$fecha_termino."'";
					$res_desc = mysql_query($sql_desc,$conexion);
					if (@mysql_num_rows($res_desc) > 0){
						$canc_con_desc	= 'SI';
						$desc_fecha		= @mysql_result($res_desc,0,"da_fecha");
					}
					
					$sql_desc = "select da_ncorr, da_fecha from descaumebaja where da_folio = '".$folio."' and 
								da_movi = 'B' and da_fecha < '".$fecha_limite."' and da_fecha < '".$fecha_termino."'";
					$res_desc = mysql_query($sql_desc,$conexion);
					if (@mysql_num_rows($res_desc) > 0){
						$logica = 'CF';
					}
				}
				
				if ($canc_con_desc == 'NO'){
					// busca si la cuenta tuvo devoluciones
					$sql_dv = "select gd_ncorr, gd_fecha from d_guiadev where gd_empresa = '".$empe_rut."' and 
								gd_folio = '".$folio."' and gd_fecha >= '".$fecha_limite."' and gd_fecha <= '".$fecha_termino."'";
					$res_dv = mysql_query($sql_dv,$conexion);
					if (@mysql_num_rows($res_dv) > 0){
						$con_dv	= 'SI';
						$desc_fecha		= 	@mysql_result($res_dv,0,"gd_fecha");
						//$filtro_dv		=	" and AB_FECHAPAGO > '".$desc_fecha."'";
					}
					
					$sql_dv2 = "select gd_ncorr, gd_fecha from d_guiadev where gd_empresa = '".$empe_rut."' and 
								gd_folio = '".$folio."' and gd_fecha < '".$fecha_limite."' and gd_fecha < '".$fecha_termino."'";
					$res_dv2 = mysql_query($sql_dv2,$conexion);
					if (@mysql_num_rows($res_dv2) > 0){
						if ($estado == 'D' OR $estado == 'P'){
							$logica = 'CF';
						}else{
							$filtro_fecha 	= 	@mysql_result($res_dv2,0,"gd_fecha");
							$logica 		= 	'CA2';
						}	
					}
				}	
				
				if ($canc_con_desc == 'SI' OR $con_dv == 'SI'){
					// verifico si la fecha de descuento esta entre las fechas del periodo
					$sql_f1		= 	"SELECT DATEDIFF('".$desc_fecha."','".$fecha_limite."') as dias_f1";
					$res_f1		= 	mysql_query($sql_f1,$conexion);
					$dias_f1	=	@mysql_result($res_f1,0,"dias_f1");
					
					$sql_f2		= 	"SELECT DATEDIFF('".$desc_fecha."','".$fecha_termino."') as dias_f2";
					$res_f2		= 	mysql_query($sql_f2,$conexion);
					$dias_f2	=	@mysql_result($res_f2,0,"dias_f2");
					
					// fecha de descuento dentro del periodo consultado
					if ($dias_f1 >= 0 && $dias_f2 <= 0){
						$logica = 'CD';
					}	
				
				}
			}
			
			if ($logica == 'CA'){
				$sql_tabo 	= "select 
								sum(AB_VALOR) as total_haber
								from $tabla_abonos
								WHERE 
								AB_EMPRESA = '".$empe_rut."' and AB_SECTOR = '".$sector."' AND
								AB_FECHAPAGO < '".$fecha_limite."' and
								ab_folio = '".$folio."' and
								ab_numcuota = '".$cuota."'";
				$res_tabo 	=  	mysql_query($sql_tabo, $conexion);
				$haber		=	@mysql_result($res_tabo,0,"total_haber");
			}
			if ($logica == 'CA2'){
				// busco el debe de la cuota activa
				$sql_dca	=	"select cu_debe from $tabla_cuotas where 
									cu_folio = '".$folio."' and 
									cu_numcuota = '".$cuota."' AND
									CU_FECVCTO < '".$fecha_limite."' and
									(CU_ESTADO != 'E' OR isnull(CU_ESTADO))
									order by cu_ncorr desc limit 1";
				$res_dca	=	mysql_query($sql_dca,$conexion);
				
				if (@mysql_num_rows($res_dca) > 0){
					$debe		=	@mysql_result($res_dca,0,"cu_debe");
					
					$sql_tabo 	= "select 
									sum(AB_VALOR) as total_haber
									from $tabla_abonos
									WHERE 
									AB_EMPRESA = '".$empe_rut."' and AB_SECTOR = '".$sector."' AND
									AB_FECHAPAGO < '".$fecha_limite."' and
									ab_folio = '".$folio."' and
									ab_numcuota = '".$cuota."' and
									(AB_ESTADO != 'E' OR isnull(AB_ESTADO))";
					$res_tabo 	=  	mysql_query($sql_tabo, $conexion);
					$haber		=	@mysql_result($res_tabo,0,"total_haber");
				}else{
					$debe		=	0;
				}
			}
			
			if ($logica == 'CD'){
				$sql_cv = "select tfcv_ncorr from temp_folios_cv where tfcv_folio = '".$folio."'";
				$res_cv = mysql_query($sql_cv,$conexion);
				if (@mysql_num_rows($res_cv) < 1){
					
					$sql_cape 	= "select 
									sum(AB_VALOR) as total_haber_per
									from $tabla_abonos
									WHERE 
									AB_EMPRESA = '".$empe_rut."' and AB_SECTOR = '".$sector."' AND
									ab_folio = '".$folio."' and
									AB_FECHAPAGO >= '".$fecha_limite."' and AB_FECHAPAGO <= '".$fecha_termino."' and
									AB_FECHAVENCI < '".$fecha_limite."'";
					$res_cape	=  	mysql_query($sql_cape, $conexion);
					
					$haber		=	@mysql_result($res_cape,0,"total_haber_per");
						
					$sql_ing 	= "insert into temp_folios_cv (tfcv_folio) values ('".$folio."')";
					$res_ing 	= mysql_query($sql_ing,$conexion);
				}
			}
			
			// busca los traspasos que ha hecho el folio a otros folios antes de la fecha de término
			$sql_trp = "select sum(da_valor) as total_traspasado from descaumebaja
						where 
						da_folio = '".$folio."' and
						da_movi = 'T' and 
						da_fecha <= '".$fecha_termino."'";
			$res_trp = mysql_query($sql_trp,$conexion);
			$total_traspasado = @mysql_result($res_trp,0,"total_traspasado");		
		
			// busca los traspasos que le han hecho al folio desde otros folios antes de la fecha de termino
			$sql_tra = "select sum(da_valor) as total_traspasos from descaumebaja
						where 
						da_traspasado = '".$folio."' and
						da_movi = 'T' and 
						da_fecha <= '".$fecha_termino."'";
			$res_tra = mysql_query($sql_tra,$conexion);
			$total_traspasos = @mysql_result($res_tra,0,"total_traspasos");		
			
			if ($logica == 'CA' OR $logica == 'CA2'){
				$saldo		=	$debe + $total_traspasado - $haber - $total_traspasos;
			}
			if ($logica == 'CD'){
				$saldo		=	$haber + $total_traspasos - $total_traspasado;
			
			}
			if ($logica == 'CF'){
				$saldo		=	0;
			
			}
			if ($saldo > 0){
				$total_cuotas_vencidas = $total_cuotas_vencidas + $saldo;
			
				/*
				// ingresa en la tabla temporal
				$tfcv_origen	=	$logica." "."SIN CAMBIO SECTOR";
				$sql_temp 		= 	"insert into temp_folios_cv (tfcv_folio,tfcv_cuota,tfcv_saldo,tfcv_origen)
									values ('".$folio."','".$cuota."','".$saldo."','".$tfcv_origen."')";
				$res_temp 		= 	mysql_query($sql_temp,$conexion);
				*/
			}
			
		}
		
	}

	// busca el total de cuotas vencidas pero de los folios con cambios de sector
	// que en el rango consultado estaban en el sector
	// solicitado por javier (07/06/2012)
	// busco los folios que estaban en el sector dentro del rango consultado
	$sql_tcvcs 	= "select 
					a.CU_FOLIO, a.CU_NUMCUOTA, a.CU_DEBE, b.vent_estado_ingreso, b.vent_num_cuotas, a.CU_NCORR
					from $tabla_cuotas a, ventas_antigua b, ventas_cambio_sector c
					WHERE 
					a.CU_EMPRESA = '".$empe_rut."' and a.CU_FECVCTO < '".$fecha_limite."' AND 
					(a.CU_ESTADO != 'E' OR isnull(a.CU_ESTADO)) AND
					a.CU_FOLIO = b.vent_num_folio and
					b.vent_num_folio = '".$folio_buscar."' and
					b.vent_num_folio = c.vent_num_folio and
					c.empe_rut = '".$empe_rut."' and 
					c.vcse_fecha_dig > '".$fecha_termino."' and
					c.sect_ncorr_actual = '".$sector."'
					
					GROUP BY 
					a.cu_folio, a.CU_NUMCUOTA
					
					ORDER BY
					a.cu_folio, a.CU_NUMCUOTA asc, a.CU_NCORR desc";
	
	$res_tcvcs 	= mysql_query($sql_tcvcs, $conexion);

	while ($line_tcvcs = @mysql_fetch_row($res_tcvcs)) {
		
		$folio			= 	$line_tcvcs[0];
		$cuota			=	$line_tcvcs[1];
		$debe			=	$line_tcvcs[2];
		$haber			=	0;
		$saldo			=	0;
		$estado			=	$line_tcvcs[3];
		$num_cuotas		=	$line_tcvcs[4];
		
		
		// verifica si tiene descuadre
		// 27/08/2012
		$descuadre = 'NO';
		//$descuadre = RevisaDescuadre($folio,$empe_rut,$sector_format,$empe_ncorr);
		
		if ($descuadre == 'NO'){
		
			// 15/06/2012 busco si el folio fue cancelado con descuento, solicitado por javier
			// el total de cuotas vencidas omite los folios cancelados con descuentos
			// 28/06/2012 nueva modificacion, javier pide que considere los folios cancelados con descuento
			// que estuvieron activos en el periodo consultado
			
			$canc_con_desc	= 	'NO';
			$con_dv			= 	'NO';
			$logica 		= 	'CA';
			
			if ($estado == 'P'){
				
				// busco si la cuenta fue cancelada con descuento
				$sql_desc = "select desc_ncorr, desc_fecha from descuentos where empe_ncorr = '".$empe_ncorr."' and 
							vent_num_folio = '".$folio."' and desc_fecha >= '".$fecha_limite."' and desc_fecha <= '".$fecha_termino."' and
							desc_autorizado = 'SI'";
				$res_desc = mysql_query($sql_desc,$conexion);
				if (@mysql_num_rows($res_desc) > 0){
					$canc_con_desc	= 'SI';
					$desc_fecha		= @mysql_result($res_desc,0,"desc_fecha");
				}
				
				$sql_desc = "select desc_ncorr, desc_fecha from descuentos where empe_ncorr = '".$empe_ncorr."' and 
							vent_num_folio = '".$folio."' and desc_fecha < '".$fecha_limite."' and desc_fecha < '".$fecha_termino."' and
							desc_autorizado = 'SI'";
				$res_desc = mysql_query($sql_desc,$conexion);
				if (@mysql_num_rows($res_desc) > 0){
					$logica = 'CF';
				}
			}
			if ($estado == 'B'){ // DE BAJA
				// busco si la cuenta fue dada de baja
				$sql_desc = "select da_ncorr, da_fecha from descaumebaja where da_folio = '".$folio."' and 
							da_movi = 'B' and da_fecha >= '".$fecha_limite."' and da_fecha <= '".$fecha_termino."'";
				$res_desc = mysql_query($sql_desc,$conexion);
				if (@mysql_num_rows($res_desc) > 0){
					$canc_con_desc	= 'SI';
					$desc_fecha		= @mysql_result($res_desc,0,"da_fecha");
				}
				
				$sql_desc = "select da_ncorr, da_fecha from descaumebaja where da_folio = '".$folio."' and 
							da_movi = 'B' and da_fecha < '".$fecha_limite."' and da_fecha < '".$fecha_termino."'";
				$res_desc = mysql_query($sql_desc,$conexion);
				if (@mysql_num_rows($res_desc) > 0){
					$logica = 'CF';
				}
			}
			
			if ($canc_con_desc == 'NO'){
				// busca si la cuenta tuvo devoluciones
				$sql_dv = "select gd_ncorr, gd_fecha from d_guiadev where gd_empresa = '".$empe_rut."' and 
							gd_folio = '".$folio."' and gd_fecha >= '".$fecha_limite."' and gd_fecha <= '".$fecha_termino."'";
				$res_dv = mysql_query($sql_dv,$conexion);
				if (@mysql_num_rows($res_dv) > 0){
					$con_dv	= 'SI';
					$desc_fecha		= 	@mysql_result($res_dv,0,"gd_fecha");
					//$filtro_dv		=	" and AB_FECHAPAGO > '".$desc_fecha."'";
				}
				
				$sql_dv2 = "select gd_ncorr, gd_fecha from d_guiadev where gd_empresa = '".$empe_rut."' and 
							gd_folio = '".$folio."' and gd_fecha < '".$fecha_limite."' and gd_fecha < '".$fecha_termino."'";
				$res_dv2 = mysql_query($sql_dv2,$conexion);
				if (@mysql_num_rows($res_dv2) > 0){
					if ($estado == 'D'  OR $estado == 'P'){
						$logica = 'CF';
					}else{
						$filtro_fecha 	= 	@mysql_result($res_dv2,0,"gd_fecha");
						$logica 		= 	'CA2';
					}
				}
			}	
			
			if ($canc_con_desc == 'SI' OR $con_dv == 'SI'){
				// verifico si la fecha de descuento esta entre las fechas del periodo
				$sql_f1		= 	"SELECT DATEDIFF('".$desc_fecha."','".$fecha_limite."') as dias_f1";
				$res_f1		= 	mysql_query($sql_f1,$conexion);
				$dias_f1	=	@mysql_result($res_f1,0,"dias_f1");
				
				$sql_f2		= 	"SELECT DATEDIFF('".$desc_fecha."','".$fecha_termino."') as dias_f2";
				$res_f2		= 	mysql_query($sql_f2,$conexion);
				$dias_f2	=	@mysql_result($res_f2,0,"dias_f2");
				
				// fecha de descuento dentro del periodo consultado
				if ($dias_f1 >= 0 && $dias_f2 <= 0){
					$logica = 'CD';
				}	
			
			}
			
			if ($logica == 'CA'){
				$sql_tabo 	= "select 
								sum(AB_VALOR) as total_haber
								from $tabla_abonos
								WHERE 
								AB_EMPRESA = '".$empe_rut."' and AB_SECTOR = '".$sector."' AND
								AB_FECHAPAGO < '".$fecha_limite."' and
								ab_folio = '".$folio."' and
								ab_numcuota = '".$cuota."'";
				$res_tabo 	=  	mysql_query($sql_tabo, $conexion);
				$haber		=	@mysql_result($res_tabo,0,"total_haber");
			}
			if ($logica == 'CA2'){
				// busco el debe de la cuota activa
				$sql_dca	=	"select cu_debe from $tabla_cuotas where 
									cu_folio = '".$folio."' and 
									cu_numcuota = '".$cuota."' AND
									CU_FECVCTO < '".$fecha_limite."' and
									(CU_ESTADO != 'E' OR isnull(CU_ESTADO))
									order by cu_ncorr desc limit 1";
				$res_dca	=	mysql_query($sql_dca,$conexion);
				
				if (@mysql_num_rows($res_dca) > 0){
					$debe		=	@mysql_result($res_dca,0,"cu_debe");
					
					$sql_tabo 	= "select 
									sum(AB_VALOR) as total_haber
									from $tabla_abonos
									WHERE 
									AB_EMPRESA = '".$empe_rut."' and AB_SECTOR = '".$sector."' AND
									AB_FECHAPAGO < '".$fecha_limite."' and
									ab_folio = '".$folio."' and
									ab_numcuota = '".$cuota."' and
									(AB_ESTADO != 'E' OR isnull(AB_ESTADO))";
					$res_tabo 	=  	mysql_query($sql_tabo, $conexion);
					$haber		=	@mysql_result($res_tabo,0,"total_haber");
				}else{
					$debe		=	0;
				}
			}
			
			if ($logica == 'CD'){
				$sql_cv = "select tfcv_ncorr from temp_folios_cv where tfcv_folio = '".$folio."'";
				$res_cv = mysql_query($sql_cv,$conexion);
				if (@mysql_num_rows($res_cv) < 1){
					
					$sql_cape 	= "select 
									sum(AB_VALOR) as total_haber_per
									from $tabla_abonos
									WHERE 
									AB_EMPRESA = '".$empe_rut."' and AB_SECTOR = '".$sector."' AND
									ab_folio = '".$folio."' and
									AB_FECHAPAGO >= '".$fecha_limite."' and AB_FECHAPAGO <= '".$fecha_termino."' and
									AB_FECHAVENCI < '".$fecha_limite."'";
					$res_cape	=  	mysql_query($sql_cape, $conexion);
					
					$haber	=	@mysql_result($res_cape,0,"total_haber_per");
						
					$sql_ing = "insert into temp_folios_cv (tfcv_folio) values ('".$folio."')";
					$res_ing = mysql_query($sql_ing,$conexion);
				}
			}
			
			// busca los traspasos que ha hecho el folio a otros folios antes de la fecha de término
			$sql_trp = "select sum(da_valor) as total_traspasado from descaumebaja
						where 
						da_folio = '".$folio."' and
						da_movi = 'T' and 
						da_fecha <= '".$fecha_termino."'";
			$res_trp = mysql_query($sql_trp,$conexion);
			$total_traspasado = @mysql_result($res_trp,0,"total_traspasado");		
		
			// busca los traspasos que le han hecho al folio desde otros folios antes de la fecha de termino
			$sql_tra = "select sum(da_valor) as total_traspasos from descaumebaja
						where 
						da_traspasado = '".$folio."' and
						da_movi = 'T' and 
						da_fecha <= '".$fecha_termino."'";
			$res_tra = mysql_query($sql_tra,$conexion);
			$total_traspasos = @mysql_result($res_tra,0,"total_traspasos");		
			
			if ($logica == 'CA' OR $logica == 'CA2'){
				$saldo		=	$debe + $total_traspasado - $haber - $total_traspasos;
			}
			if ($logica == 'CD'){
				$saldo		=	$haber + $total_traspasos - $total_traspasado;
			
			}
			if ($logica == 'CF'){
				$saldo		=	0;
			
			}
			if ($saldo > 0){
				$total_cuotas_vencidas = $total_cuotas_vencidas + $saldo;
				
				/*
				// ingresa en la tabla temporal
				$tfcv_origen	=	$logica." "."CON CAMBIO SECTOR";
				$sql_temp 		= 	"insert into temp_folios_cv (tfcv_folio,tfcv_cuota,tfcv_saldo,tfcv_origen)
									values ('".$folio."','".$cuota."','".$saldo."','".$tfcv_origen."')";
				$res_temp 		= 	mysql_query($sql_temp,$conexion);
				*/
				
			}
		}
	}
	
// #####################	FIN DE RUTINA PARA EL CALCULO DEL TOTAL DE CUOTAS VENCIDAS		#######################################################						
// ################################################################################################################################################						
	return $total_cuotas_vencidas."#".$logica;

}

function TotalPorCobrarPeriodo_folio($tabla_abonos,$tabla_cuotas,$empe_rut,$fecha_limite,$fecha_termino,$sector,$fecha_rev_kardex,$sector_format,$empe_ncorr,$folio_buscar) {
	
	global $conexion;	
	
	// ##############################################################################################################################################						
	// #####################	INICIO DE RUTINA PARA EL CALCULO DEL TOTAL DE CUOTAS VENCIDAS #######################################################						
	//	ACTUALIZADO AL 15/06/2012 A SOLICITUD DE JAVIER
	$sql_tr = "truncate table temp_folios_tpcp";	
	$res_tr = mysql_query($sql_tr,$conexion);
	$total_por_cobrar_periodo = 0;
	// nueva consulta, considera solo las cv cuya fecha de ultimo abono sea menor a fecha_limite (inicio del periodo)
	// solicitado por javier (27/04/2011)
	$sql_tcv 	= "select 
					a.CU_FOLIO, a.CU_NUMCUOTA, a.CU_DEBE, b.vent_estado_ingreso, b.vent_num_cuotas, a.CU_NCORR
					from $tabla_cuotas a, ventas_antigua b
					WHERE 
					a.CU_EMPRESA = '".$empe_rut."' and a.CU_FECVCTO >= '".$fecha_limite."' and a.CU_FECVCTO <= '".$fecha_termino."' AND 
					a.CU_FOLIO = b.vent_num_folio and
					b.vent_num_folio = '".$folio_buscar."'
					
					GROUP BY 
					a.cu_folio, a.CU_NUMCUOTA
					
					ORDER BY
					a.cu_folio, a.CU_NUMCUOTA asc, a.CU_NCORR desc";
					
	$res_tcv 	= mysql_query($sql_tcv, $conexion);
	
	$total_cuotas_vencidas	=	0;
	
	while ($line_tcv = @mysql_fetch_row($res_tcv)) {
		
		$folio				=	$line_tcv[0];
		$cuota				=	$line_tcv[1];
		$debe				=	$line_tcv[2];
		$haber 				= 	0;
		$saldo				=	0;
		$estado				=	trim($line_tcv[3]);
		$num_cuotas			=	$line_tcv[4];
		$cobranza_vencida	=	0;
		
		// verifica si tiene descuadre
		// 27/08/2012
		$descuadre = 'NO';
		//$descuadre = RevisaDescuadre($folio,$empe_rut,$sector_format,$empe_ncorr);
		
		if ($descuadre == 'NO'){
		
			$canc_con_desc	= 	'NO';
			$con_dv			= 	'NO';
			$logica 		= 	'CA';
			$cambio_sector	=	'NO';
			
			// verifico si el folio estuvo en otro sector
			// antes de la fecha del primer filtro
			// si estuvo en otro sector entonces el resultado será cero
			// para periodos anteriores al cambio de sector
			$sql_osec = "select sect_ncorr_actual from ventas_cambio_sector 
							where
							empe_rut = '".$empe_rut."' and
							vent_num_folio = '".$folio."' and
							sect_ncorr_nuevo = '".$sector."' and
							vcse_fecha_dig > '".$fecha_limite."' and
							vcse_fecha_dig > '".$fecha_termino."'";
			
			$res_osec = mysql_query($sql_osec,$conexion);
			if (@mysql_num_rows($res_osec) > 0){
				$logica = 'CF';			
				$cambio_sector = 'SI';
			}
			
			if ($cambio_sector == 'NO'){
				// 15/06/2012 busco si el folio fue cancelado con descuento, solicitado por javier
				// el total de cuotas vencidas omite los folios cancelados con descuentos
				// 28/06/2012 nueva modificacion, javier pide que considere los folios cancelados con descuento
				// que estuvieron activos en el periodo consultado
				//	CA = logica cuentas activas
				//	CD = logica canceladas con descuento
				
				if ($estado == 'P'){
					
					// busco si la cuenta fue cancelada con descuento
					$sql_desc = "select desc_ncorr, desc_fecha from descuentos where empe_ncorr = '".$empe_ncorr."' and 
								vent_num_folio = '".$folio."' and desc_fecha >= '".$fecha_limite."' and desc_fecha <= '".$fecha_termino."' and
								desc_autorizado = 'SI'";
					$res_desc = mysql_query($sql_desc,$conexion);
					if (@mysql_num_rows($res_desc) > 0){
						$canc_con_desc	= 'SI';
						$desc_fecha		= @mysql_result($res_desc,0,"desc_fecha");
					}
					
					$sql_desc = "select desc_ncorr, desc_fecha from descuentos where empe_ncorr = '".$empe_ncorr."' and 
								vent_num_folio = '".$folio."' and desc_fecha < '".$fecha_limite."' and desc_fecha < '".$fecha_termino."' and
								desc_autorizado = 'SI'";
					$res_desc = mysql_query($sql_desc,$conexion);
					if (@mysql_num_rows($res_desc) > 0){
						$logica = 'CF';
					}
				}
				if ($estado == 'B'){ // DE BAJA
					// busco si la cuenta fue dada de baja
					$sql_desc = "select da_ncorr, da_fecha from descaumebaja where da_folio = '".$folio."' and 
								da_fecha >= '".$fecha_limite."' and da_fecha <= '".$fecha_termino."'";
					$res_desc = mysql_query($sql_desc,$conexion);
					if (@mysql_num_rows($res_desc) > 0){
						$canc_con_desc	= 'SI';
						$desc_fecha		= @mysql_result($res_desc,0,"da_fecha");
					}
					
					$sql_desc = "select da_ncorr, da_fecha from descaumebaja where da_folio = '".$folio."' and 
								da_fecha < '".$fecha_limite."' and da_fecha < '".$fecha_termino."'";
					$res_desc = mysql_query($sql_desc,$conexion);
					if (@mysql_num_rows($res_desc) > 0){
						$logica = 'CF';
					}
				}
				
				if ($canc_con_desc == 'NO'){
					// busca si la cuenta tuvo devoluciones
					$sql_dv = "select gd_ncorr, gd_fecha from d_guiadev where gd_empresa = '".$empe_rut."' and 
								gd_folio = '".$folio."' and gd_fecha >= '".$fecha_limite."' and gd_fecha <= '".$fecha_termino."'";
					$res_dv = mysql_query($sql_dv,$conexion);
					if (@mysql_num_rows($res_dv) > 0){
						$con_dv	= 'SI';
						$desc_fecha		= 	@mysql_result($res_dv,0,"gd_fecha");
						//$filtro_dv		=	" and AB_FECHAPAGO > '".$desc_fecha."'";
					}
					
					$sql_dv2 = "select gd_ncorr, gd_fecha from d_guiadev where gd_empresa = '".$empe_rut."' and 
								gd_folio = '".$folio."' and gd_fecha < '".$fecha_limite."' and gd_fecha < '".$fecha_termino."'";
					$res_dv2 = mysql_query($sql_dv2,$conexion);
					if (@mysql_num_rows($res_dv2) > 0){
						if ($estado == 'D' OR $estado == 'P'){
							$logica = 'CF';
						}else{
							$filtro_fecha 	= 	@mysql_result($res_dv2,0,"gd_fecha");
							$logica 		= 	'CA2';
						}	
					}
				}	
				
				if ($canc_con_desc == 'SI' OR $con_dv == 'SI'){
					// verifico si la fecha de descuento esta entre las fechas del periodo
					$sql_f1		= 	"SELECT DATEDIFF('".$desc_fecha."','".$fecha_limite."') as dias_f1";
					$res_f1		= 	mysql_query($sql_f1,$conexion);
					$dias_f1	=	@mysql_result($res_f1,0,"dias_f1");
					
					$sql_f2		= 	"SELECT DATEDIFF('".$desc_fecha."','".$fecha_termino."') as dias_f2";
					$res_f2		= 	mysql_query($sql_f2,$conexion);
					$dias_f2	=	@mysql_result($res_f2,0,"dias_f2");
					
					// fecha de descuento dentro del periodo consultado
					if ($dias_f1 >= 0 && $dias_f2 <= 0){
						$logica = 'CD';
					}	
				
				}
			}
			
			if ($logica == 'CA'){
				$sql_tabo 	= "select 
								sum(AB_VALOR) as total_haber
								from $tabla_abonos
								WHERE 
								AB_EMPRESA = '".$empe_rut."' and AB_SECTOR = '".$sector."' AND
								AB_FECHAPAGO < '".$fecha_limite."' and
								ab_folio = '".$folio."' and
								ab_numcuota = '".$cuota."'";
				$res_tabo 	=  	mysql_query($sql_tabo, $conexion);
				$haber		=	@mysql_result($res_tabo,0,"total_haber");
			}
			if ($logica == 'CA2'){
				// busco el debe de la cuota activa
				$sql_dca	=	"select cu_debe from $tabla_cuotas where 
									cu_folio = '".$folio."' and 
									cu_numcuota = '".$cuota."' AND
									CU_FECVCTO >= '".$fecha_limite."' and CU_FECVCTO <= '".$fecha_termino."' and
									(CU_ESTADO != 'E' OR isnull(CU_ESTADO))
									order by cu_ncorr desc limit 1";
				$res_dca	=	mysql_query($sql_dca,$conexion);
				
				if (@mysql_num_rows($res_dca) > 0){
					$debe		=	@mysql_result($res_dca,0,"cu_debe");
					
					$sql_tabo 	= "select 
									sum(AB_VALOR) as total_haber
									from $tabla_abonos
									WHERE 
									AB_EMPRESA = '".$empe_rut."' and AB_SECTOR = '".$sector."' AND
									AB_FECHAPAGO < '".$fecha_limite."' and
									ab_folio = '".$folio."' and
									ab_numcuota = '".$cuota."' and
									(AB_ESTADO != 'E' OR isnull(AB_ESTADO))";
					$res_tabo 	=  	mysql_query($sql_tabo, $conexion);
					$haber		=	@mysql_result($res_tabo,0,"total_haber");
				}else{
					$debe		=	0;
				}
			}
			
			if ($logica == 'CD'){
				$sql_cv = "select tfcv_ncorr from temp_folios_tpcp where tfcv_folio = '".$folio."'";
				$res_cv = mysql_query($sql_cv,$conexion);
				if (@mysql_num_rows($res_cv) < 1){
					
					$sql_cape 	= "select 
									sum(AB_VALOR) as total_haber_per
									from $tabla_abonos
									WHERE 
									AB_EMPRESA = '".$empe_rut."' and AB_SECTOR = '".$sector."' AND
									ab_folio = '".$folio."' and
									AB_FECHAPAGO >= '".$fecha_limite."' and AB_FECHAPAGO <= '".$fecha_termino."' and
									AB_FECHAVENCI >= '".$fecha_limite."' and AB_FECHAVENCI <= '".$fecha_termino."'";
					$res_cape	=  	mysql_query($sql_cape, $conexion);
					
					$haber	=	@mysql_result($res_cape,0,"total_haber_per");
						
					//$sql_ing = "insert into temp_folios_tpcp (tfcv_folio) values ('".$folio."')";
					//$res_ing = mysql_query($sql_ing,$conexion);
				}
			}
			
			// busca los traspasos que ha hecho el folio a otros folios antes de la fecha de término
			$sql_trp = "select sum(da_valor) as total_traspasado from descaumebaja
						where 
						da_folio = '".$folio."' and
						da_movi = 'T' and 
						da_fecha <= '".$fecha_termino."'";
			$res_trp = mysql_query($sql_trp,$conexion);
			$total_traspasado = @mysql_result($res_trp,0,"total_traspasado");		
		
			// busca los traspasos que le han hecho al folio desde otros folios antes de la fecha de termino
			$sql_tra = "select sum(da_valor) as total_traspasos from descaumebaja
						where 
						da_traspasado = '".$folio."' and
						da_movi = 'T' and 
						da_fecha <= '".$fecha_termino."'";
			$res_tra = mysql_query($sql_tra,$conexion);
			$total_traspasos = @mysql_result($res_tra,0,"total_traspasos");		
			
			if ($logica == 'CA' OR $logica == 'CA2'){
				$saldo		=	$debe + $total_traspasado - $haber - $total_traspasos;
			}
			if ($logica == 'CD'){
				$saldo		=	$haber + $total_traspasos - $total_traspasado;
			
			}
			if ($logica == 'CF'){
				$saldo		=	0;
			
			}
			if ($saldo > 0){
				$total_por_cobrar_periodo = $total_por_cobrar_periodo + $saldo;
			
				/*
				// ingresa en la tabla temporal
				$tfcv_origen	=	$logica." "."SIN CAMBIO SECTOR";
				$sql_temp 		= 	"insert into temp_folios_tpcp (tfcv_folio,tfcv_cuota,tfcv_saldo,tfcv_origen)
									values ('".$folio."','".$cuota."','".$saldo."','".$tfcv_origen."')";
				$res_temp 		= 	mysql_query($sql_temp,$conexion);
				*/
				
			}
			
		}
		
	}

	// busca el total de cuotas vencidas pero de los folios con cambios de sector
	// que en el rango consultado estaban en el sector
	// solicitado por javier (07/06/2012)
	// busco los folios que estaban en el sector dentro del rango consultado
	$sql_tcvcs 	= "select 
					a.CU_FOLIO, a.CU_NUMCUOTA, a.CU_DEBE, b.vent_estado_ingreso, b.vent_num_cuotas, a.CU_NCORR
					from $tabla_cuotas a, ventas_antigua b, ventas_cambio_sector c
					WHERE 
					a.CU_EMPRESA = '".$empe_rut."' and a.CU_FECVCTO >= '".$fecha_limite."' and a.CU_FECVCTO <= '".$fecha_termino."' AND 
					(a.CU_ESTADO != 'E' OR isnull(a.CU_ESTADO)) AND
					a.CU_FOLIO = b.vent_num_folio and
					b.vent_num_folio = '".$folio_buscar."' and
					b.vent_num_folio = c.vent_num_folio and
					c.empe_rut = '".$empe_rut."' and 
					c.vcse_fecha_dig > '".$fecha_termino."' and
					c.sect_ncorr_actual = '".$sector."' and
					
					GROUP BY 
					a.cu_folio, a.CU_NUMCUOTA
					
					ORDER BY
					a.cu_folio, a.CU_NUMCUOTA asc, a.CU_NCORR desc";
	
	$res_tcvcs 	= mysql_query($sql_tcvcs, $conexion);

	while ($line_tcvcs = @mysql_fetch_row($res_tcvcs)) {
		
		$folio			= 	$line_tcvcs[0];
		$cuota			=	$line_tcvcs[1];
		$debe			=	$line_tcvcs[2];
		$haber			=	0;
		$saldo			=	0;
		$estado			=	$line_tcvcs[3];
		$num_cuotas		=	$line_tcvcs[4];
		
		
		// verifica si tiene descuadre
		// 27/08/2012
		$descuadre = 'NO';
		//$descuadre = RevisaDescuadre($folio,$empe_rut,$sector_format,$empe_ncorr);
		
		if ($descuadre == 'NO'){
		
			// 15/06/2012 busco si el folio fue cancelado con descuento, solicitado por javier
			// el total de cuotas vencidas omite los folios cancelados con descuentos
			// 28/06/2012 nueva modificacion, javier pide que considere los folios cancelados con descuento
			// que estuvieron activos en el periodo consultado
			
			$canc_con_desc	= 	'NO';
			$con_dv			= 	'NO';
			$logica 		= 	'CA';
			
			if ($estado == 'P'){
				
				// busco si la cuenta fue cancelada con descuento
				$sql_desc = "select desc_ncorr, desc_fecha from descuentos where empe_ncorr = '".$empe_ncorr."' and 
							vent_num_folio = '".$folio."' and desc_fecha >= '".$fecha_limite."' and desc_fecha <= '".$fecha_termino."' and
							desc_autorizado = 'SI'";
				$res_desc = mysql_query($sql_desc,$conexion);
				if (@mysql_num_rows($res_desc) > 0){
					$canc_con_desc	= 'SI';
					$desc_fecha		= @mysql_result($res_desc,0,"desc_fecha");
				}
				
				$sql_desc = "select desc_ncorr, desc_fecha from descuentos where empe_ncorr = '".$empe_ncorr."' and 
							vent_num_folio = '".$folio."' and desc_fecha < '".$fecha_limite."' and desc_fecha < '".$fecha_termino."' and
							desc_autorizado = 'SI'";
				$res_desc = mysql_query($sql_desc,$conexion);
				if (@mysql_num_rows($res_desc) > 0){
					$logica = 'CF';
				}
			}
			if ($estado == 'B'){ // DE BAJA
				// busco si la cuenta fue dada de baja
				$sql_desc = "select da_ncorr, da_fecha from descaumebaja where da_folio = '".$folio."' and 
							da_fecha >= '".$fecha_limite."' and da_fecha <= '".$fecha_termino."'";
				$res_desc = mysql_query($sql_desc,$conexion);
				if (@mysql_num_rows($res_desc) > 0){
					$canc_con_desc	= 'SI';
					$desc_fecha		= @mysql_result($res_desc,0,"da_fecha");
				}
				
				$sql_desc = "select da_ncorr, da_fecha from descaumebaja where da_folio = '".$folio."' and 
							da_fecha < '".$fecha_limite."' and da_fecha < '".$fecha_termino."'";
				$res_desc = mysql_query($sql_desc,$conexion);
				if (@mysql_num_rows($res_desc) > 0){
					$logica = 'CF';
				}
			}
			
			if ($canc_con_desc == 'NO'){
				// busca si la cuenta tuvo devoluciones
				$sql_dv = "select gd_ncorr, gd_fecha from d_guiadev where gd_empresa = '".$empe_rut."' and 
							gd_folio = '".$folio."' and gd_fecha >= '".$fecha_limite."' and gd_fecha <= '".$fecha_termino."'";
				$res_dv = mysql_query($sql_dv,$conexion);
				if (@mysql_num_rows($res_dv) > 0){
					$con_dv	= 'SI';
					$desc_fecha		= 	@mysql_result($res_dv,0,"gd_fecha");
					//$filtro_dv		=	" and AB_FECHAPAGO > '".$desc_fecha."'";
				}
				
				$sql_dv2 = "select gd_ncorr, gd_fecha from d_guiadev where gd_empresa = '".$empe_rut."' and 
							gd_folio = '".$folio."' and gd_fecha < '".$fecha_limite."' and gd_fecha < '".$fecha_termino."'";
				$res_dv2 = mysql_query($sql_dv2,$conexion);
				if (@mysql_num_rows($res_dv2) > 0){
					if ($estado == 'D'  OR $estado == 'P'){
						$logica = 'CF';
					}else{
						$filtro_fecha 	= 	@mysql_result($res_dv2,0,"gd_fecha");
						$logica 		= 	'CA2';
					}
				}
			}	
			
			if ($canc_con_desc == 'SI' OR $con_dv == 'SI'){
				// verifico si la fecha de descuento esta entre las fechas del periodo
				$sql_f1		= 	"SELECT DATEDIFF('".$desc_fecha."','".$fecha_limite."') as dias_f1";
				$res_f1		= 	mysql_query($sql_f1,$conexion);
				$dias_f1	=	@mysql_result($res_f1,0,"dias_f1");
				
				$sql_f2		= 	"SELECT DATEDIFF('".$desc_fecha."','".$fecha_termino."') as dias_f2";
				$res_f2		= 	mysql_query($sql_f2,$conexion);
				$dias_f2	=	@mysql_result($res_f2,0,"dias_f2");
				
				// fecha de descuento dentro del periodo consultado
				if ($dias_f1 >= 0 && $dias_f2 <= 0){
					$logica = 'CD';
				}	
			
			}
			
			if ($logica == 'CA'){
				$sql_tabo 	= "select 
								sum(AB_VALOR) as total_haber
								from $tabla_abonos
								WHERE 
								AB_EMPRESA = '".$empe_rut."' and AB_SECTOR = '".$sector."' AND
								AB_FECHAPAGO < '".$fecha_limite."' and
								ab_folio = '".$folio."' and
								ab_numcuota = '".$cuota."'";
				$res_tabo 	=  	mysql_query($sql_tabo, $conexion);
				$haber		=	@mysql_result($res_tabo,0,"total_haber");
			}
			if ($logica == 'CA2'){
				// busco el debe de la cuota activa
				$sql_dca	=	"select cu_debe from $tabla_cuotas where 
									cu_folio = '".$folio."' and 
									cu_numcuota = '".$cuota."' AND
									CU_FECVCTO >= '".$fecha_limite."' and CU_FECVCTO <= '".$fecha_termino."' and
									(CU_ESTADO != 'E' OR isnull(CU_ESTADO))
									order by cu_ncorr desc limit 1";
				$res_dca	=	mysql_query($sql_dca,$conexion);
				
				if (@mysql_num_rows($res_dca) > 0){
					$debe		=	@mysql_result($res_dca,0,"cu_debe");
					
					$sql_tabo 	= "select 
									sum(AB_VALOR) as total_haber
									from $tabla_abonos
									WHERE 
									AB_EMPRESA = '".$empe_rut."' and AB_SECTOR = '".$sector."' AND
									AB_FECHAPAGO < '".$fecha_limite."' and
									ab_folio = '".$folio."' and
									ab_numcuota = '".$cuota."' and
									(AB_ESTADO != 'E' OR isnull(AB_ESTADO))";
					$res_tabo 	=  	mysql_query($sql_tabo, $conexion);
					$haber		=	@mysql_result($res_tabo,0,"total_haber");
				}else{
					$debe		=	0;
				}
			}
			
			if ($logica == 'CD'){
				$sql_cv = "select tfcv_ncorr from temp_folios_cv where tfcv_folio = '".$folio."'";
				$res_cv = mysql_query($sql_cv,$conexion);
				if (@mysql_num_rows($res_cv) < 1){
					
					$sql_cape 	= "select 
									sum(AB_VALOR) as total_haber_per
									from $tabla_abonos
									WHERE 
									AB_EMPRESA = '".$empe_rut."' and AB_SECTOR = '".$sector."' AND
									ab_folio = '".$folio."' and
									AB_FECHAPAGO >= '".$fecha_limite."' and AB_FECHAPAGO <= '".$fecha_termino."' and
									AB_FECHAVENCI >= '".$fecha_limite."' and AB_FECHAVENCI <= '".$fecha_termino."'";
					$res_cape	=  	mysql_query($sql_cape, $conexion);
					
					$haber	=	@mysql_result($res_cape,0,"total_haber_per");
						
					//$sql_ing = "insert into temp_folios_tpcp (tfcv_folio) values ('".$folio."')";
					//$res_ing = mysql_query($sql_ing,$conexion);
				}
			}
			
			// busca los traspasos que ha hecho el folio a otros folios antes de la fecha de término
			$sql_trp = "select sum(da_valor) as total_traspasado from descaumebaja
						where 
						da_folio = '".$folio."' and
						da_movi = 'T' and 
						da_fecha <= '".$fecha_termino."'";
			$res_trp = mysql_query($sql_trp,$conexion);
			$total_traspasado = @mysql_result($res_trp,0,"total_traspasado");		
		
			// busca los traspasos que le han hecho al folio desde otros folios antes de la fecha de termino
			$sql_tra = "select sum(da_valor) as total_traspasos from descaumebaja
						where 
						da_traspasado = '".$folio."' and
						da_movi = 'T' and 
						da_fecha <= '".$fecha_termino."'";
			$res_tra = mysql_query($sql_tra,$conexion);
			$total_traspasos = @mysql_result($res_tra,0,"total_traspasos");		
			
			if ($logica == 'CA' OR $logica == 'CA2'){
				$saldo		=	$debe + $total_traspasado - $haber - $total_traspasos;
			}
			if ($logica == 'CD'){
				$saldo		=	$haber + $total_traspasos - $total_traspasado;
			
			}
			if ($logica == 'CF'){
				$saldo		=	0;
			
			}
			if ($saldo > 0){
				$total_por_cobrar_periodo = $total_por_cobrar_periodo + $saldo;
				
				/*
				// ingresa en la tabla temporal
				$tfcv_origen	=	$logica." "."CON CAMBIO SECTOR";
				$sql_temp 		= 	"insert into temp_folios_tpcp (tfcv_folio,tfcv_cuota,tfcv_saldo,tfcv_origen)
									values ('".$folio."','".$cuota."','".$saldo."','".$tfcv_origen."')";
				$res_temp 		= 	mysql_query($sql_temp,$conexion);
				*/
				
			}
		}
	}
	
	return $total_por_cobrar_periodo;
}




function TotalPorCobrarPeriodo($tabla_abonos,$tabla_cuotas,$empe_rut,$fecha_limite,$fecha_termino,$sector,$fecha_rev_kardex,$sector_format,$empe_ncorr) {
	
	global $conexion;	
	
	// ##############################################################################################################################################						
	// #####################	INICIO DE RUTINA PARA EL CALCULO DEL TOTAL DE CUOTAS VENCIDAS #######################################################						
	//	ACTUALIZADO AL 15/06/2012 A SOLICITUD DE JAVIER
	$sql_tr = "truncate table temp_folios_tpcp";	
	$res_tr = mysql_query($sql_tr,$conexion);
	
	// nueva consulta, considera solo las cv cuya fecha de ultimo abono sea menor a fecha_limite (inicio del periodo)
	// solicitado por javier (27/04/2011)
	$sql_tcv 	= "select 
					a.CU_FOLIO, a.CU_NUMCUOTA, a.CU_DEBE, b.vent_estado_ingreso, b.vent_num_cuotas, a.CU_NCORR
					from $tabla_cuotas a, ventas_antigua b
					WHERE 
					a.CU_EMPRESA = '".$empe_rut."' and a.CU_FECVCTO >= '".$fecha_limite."' and a.CU_FECVCTO <= '".$fecha_termino."' AND 
					a.CU_FOLIO = b.vent_num_folio and
					b.empe_rut = '".$empe_rut."' and
					b.sect_ncorr = '".$sector."' and
					b.vent_estado_ingreso != 'A' and b.vent_estado_ingreso != 'N' and
					b.vent_num_cuotas > '0' and b.vent_valor_cuotas > '0' and
					b.vent_estado = 'FINALIZADA' and
					b.vent_fecha_revision >= '".$fecha_rev_kardex."'
					
					GROUP BY 
					a.cu_folio, a.CU_NUMCUOTA
					
					ORDER BY
					a.cu_folio, a.CU_NUMCUOTA asc, a.CU_NCORR desc";
					
	$res_tcv 	= mysql_query($sql_tcv, $conexion);
	
	$total_cuotas_vencidas	=	0;
	
	while ($line_tcv = @mysql_fetch_row($res_tcv)) {
		
		$folio				=	$line_tcv[0];
		$cuota				=	$line_tcv[1];
		$debe				=	$line_tcv[2];
		$haber 				= 	0;
		$saldo				=	0;
		$estado				=	trim($line_tcv[3]);
		$num_cuotas			=	$line_tcv[4];
		$cobranza_vencida	=	0;
		
		// verifica si tiene descuadre
		// 27/08/2012
		$descuadre = 'NO';
		//$descuadre = RevisaDescuadre($folio,$empe_rut,$sector_format,$empe_ncorr);
		
		if ($descuadre == 'NO'){
		
			$canc_con_desc	= 	'NO';
			$con_dv			= 	'NO';
			$logica 		= 	'CA';
			$cambio_sector	=	'NO';
			
			// verifico si el folio estuvo en otro sector
			// antes de la fecha del primer filtro
			// si estuvo en otro sector entonces el resultado será cero
			// para periodos anteriores al cambio de sector
			$sql_osec = "select sect_ncorr_actual from ventas_cambio_sector 
							where
							empe_rut = '".$empe_rut."' and
							vent_num_folio = '".$folio."' and
							sect_ncorr_nuevo = '".$sector."' and
							vcse_fecha_dig > '".$fecha_limite."' and
							vcse_fecha_dig > '".$fecha_termino."'";
			
			$res_osec = mysql_query($sql_osec,$conexion);
			if (@mysql_num_rows($res_osec) > 0){
				$logica = 'CF';			
				$cambio_sector = 'SI';
			}
			
			if ($cambio_sector == 'NO'){
				// 15/06/2012 busco si el folio fue cancelado con descuento, solicitado por javier
				// el total de cuotas vencidas omite los folios cancelados con descuentos
				// 28/06/2012 nueva modificacion, javier pide que considere los folios cancelados con descuento
				// que estuvieron activos en el periodo consultado
				//	CA = logica cuentas activas
				//	CD = logica canceladas con descuento
				
				if ($estado == 'P'){
					
					// busco si la cuenta fue cancelada con descuento
					$sql_desc = "select desc_ncorr, desc_fecha from descuentos where empe_ncorr = '".$empe_ncorr."' and 
								vent_num_folio = '".$folio."' and desc_fecha >= '".$fecha_limite."' and desc_fecha <= '".$fecha_termino."' and
								desc_autorizado = 'SI'";
					$res_desc = mysql_query($sql_desc,$conexion);
					if (@mysql_num_rows($res_desc) > 0){
						$canc_con_desc	= 'SI';
						$desc_fecha		= @mysql_result($res_desc,0,"desc_fecha");
					}
					
					$sql_desc = "select desc_ncorr, desc_fecha from descuentos where empe_ncorr = '".$empe_ncorr."' and 
								vent_num_folio = '".$folio."' and desc_fecha < '".$fecha_limite."' and desc_fecha < '".$fecha_termino."' and
								desc_autorizado = 'SI'";
					$res_desc = mysql_query($sql_desc,$conexion);
					if (@mysql_num_rows($res_desc) > 0){
						$logica = 'CF';
					}
				}
				if ($estado == 'B'){ // DE BAJA
					// busco si la cuenta fue dada de baja
					$sql_desc = "select da_ncorr, da_fecha from descaumebaja where da_folio = '".$folio."' and 
								da_fecha >= '".$fecha_limite."' and da_fecha <= '".$fecha_termino."'";
					$res_desc = mysql_query($sql_desc,$conexion);
					if (@mysql_num_rows($res_desc) > 0){
						$canc_con_desc	= 'SI';
						$desc_fecha		= @mysql_result($res_desc,0,"da_fecha");
					}
					
					$sql_desc = "select da_ncorr, da_fecha from descaumebaja where da_folio = '".$folio."' and 
								da_fecha < '".$fecha_limite."' and da_fecha < '".$fecha_termino."'";
					$res_desc = mysql_query($sql_desc,$conexion);
					if (@mysql_num_rows($res_desc) > 0){
						$logica = 'CF';
					}
				}
				
				if ($canc_con_desc == 'NO'){
					// busca si la cuenta tuvo devoluciones
					$sql_dv = "select gd_ncorr, gd_fecha from d_guiadev where gd_empresa = '".$empe_rut."' and 
								gd_folio = '".$folio."' and gd_fecha >= '".$fecha_limite."' and gd_fecha <= '".$fecha_termino."'";
					$res_dv = mysql_query($sql_dv,$conexion);
					if (@mysql_num_rows($res_dv) > 0){
						$con_dv	= 'SI';
						$desc_fecha		= 	@mysql_result($res_dv,0,"gd_fecha");
						//$filtro_dv		=	" and AB_FECHAPAGO > '".$desc_fecha."'";
					}
					
					$sql_dv2 = "select gd_ncorr, gd_fecha from d_guiadev where gd_empresa = '".$empe_rut."' and 
								gd_folio = '".$folio."' and gd_fecha < '".$fecha_limite."' and gd_fecha < '".$fecha_termino."'";
					$res_dv2 = mysql_query($sql_dv2,$conexion);
					if (@mysql_num_rows($res_dv2) > 0){
						if ($estado == 'D' OR $estado == 'P'){
							$logica = 'CF';
						}else{
							$filtro_fecha 	= 	@mysql_result($res_dv2,0,"gd_fecha");
							$logica 		= 	'CA2';
						}	
					}
				}	
				
				if ($canc_con_desc == 'SI' OR $con_dv == 'SI'){
					// verifico si la fecha de descuento esta entre las fechas del periodo
					$sql_f1		= 	"SELECT DATEDIFF('".$desc_fecha."','".$fecha_limite."') as dias_f1";
					$res_f1		= 	mysql_query($sql_f1,$conexion);
					$dias_f1	=	@mysql_result($res_f1,0,"dias_f1");
					
					$sql_f2		= 	"SELECT DATEDIFF('".$desc_fecha."','".$fecha_termino."') as dias_f2";
					$res_f2		= 	mysql_query($sql_f2,$conexion);
					$dias_f2	=	@mysql_result($res_f2,0,"dias_f2");
					
					// fecha de descuento dentro del periodo consultado
					if ($dias_f1 >= 0 && $dias_f2 <= 0){
						$logica = 'CD';
					}	
				
				}
			}
			
			if ($logica == 'CA'){
				$sql_tabo 	= "select 
								sum(AB_VALOR) as total_haber
								from $tabla_abonos
								WHERE 
								AB_EMPRESA = '".$empe_rut."' and AB_SECTOR = '".$sector."' AND
								AB_FECHAPAGO < '".$fecha_limite."' and
								ab_folio = '".$folio."' and
								ab_numcuota = '".$cuota."'";
				$res_tabo 	=  	mysql_query($sql_tabo, $conexion);
				$haber		=	@mysql_result($res_tabo,0,"total_haber");
			}
			if ($logica == 'CA2'){
				// busco el debe de la cuota activa
				$sql_dca	=	"select cu_debe from $tabla_cuotas where 
									cu_folio = '".$folio."' and 
									cu_numcuota = '".$cuota."' AND
									CU_FECVCTO >= '".$fecha_limite."' and CU_FECVCTO <= '".$fecha_termino."' and
									(CU_ESTADO != 'E' OR isnull(CU_ESTADO))
									order by cu_ncorr desc limit 1";
				$res_dca	=	mysql_query($sql_dca,$conexion);
				
				if (@mysql_num_rows($res_dca) > 0){
					$debe		=	@mysql_result($res_dca,0,"cu_debe");
					
					$sql_tabo 	= "select 
									sum(AB_VALOR) as total_haber
									from $tabla_abonos
									WHERE 
									AB_EMPRESA = '".$empe_rut."' and AB_SECTOR = '".$sector."' AND
									AB_FECHAPAGO < '".$fecha_limite."' and
									ab_folio = '".$folio."' and
									ab_numcuota = '".$cuota."' and
									(AB_ESTADO != 'E' OR isnull(AB_ESTADO))";
					$res_tabo 	=  	mysql_query($sql_tabo, $conexion);
					$haber		=	@mysql_result($res_tabo,0,"total_haber");
				}else{
					$debe		=	0;
				}
			}
			
			if ($logica == 'CD'){
				$sql_cv = "select tfcv_ncorr from temp_folios_tpcp where tfcv_folio = '".$folio."'";
				$res_cv = mysql_query($sql_cv,$conexion);
				if (@mysql_num_rows($res_cv) < 1){
					
					$sql_cape 	= "select 
									sum(AB_VALOR) as total_haber_per
									from $tabla_abonos
									WHERE 
									AB_EMPRESA = '".$empe_rut."' and AB_SECTOR = '".$sector."' AND
									ab_folio = '".$folio."' and
									AB_FECHAPAGO >= '".$fecha_limite."' and AB_FECHAPAGO <= '".$fecha_termino."' and
									AB_FECHAVENCI >= '".$fecha_limite."' and AB_FECHAVENCI <= '".$fecha_termino."'";
					$res_cape	=  	mysql_query($sql_cape, $conexion);
					
					$haber	=	@mysql_result($res_cape,0,"total_haber_per");
						
					//$sql_ing = "insert into temp_folios_tpcp (tfcv_folio) values ('".$folio."')";
					//$res_ing = mysql_query($sql_ing,$conexion);
				}
			}
			
			// busca los traspasos que ha hecho el folio a otros folios antes de la fecha de término
			$sql_trp = "select sum(da_valor) as total_traspasado from descaumebaja
						where 
						da_folio = '".$folio."' and
						da_movi = 'T' and 
						da_fecha <= '".$fecha_termino."'";
			$res_trp = mysql_query($sql_trp,$conexion);
			$total_traspasado = @mysql_result($res_trp,0,"total_traspasado");		
		
			// busca los traspasos que le han hecho al folio desde otros folios antes de la fecha de termino
			$sql_tra = "select sum(da_valor) as total_traspasos from descaumebaja
						where 
						da_traspasado = '".$folio."' and
						da_movi = 'T' and 
						da_fecha <= '".$fecha_termino."'";
			$res_tra = mysql_query($sql_tra,$conexion);
			$total_traspasos = @mysql_result($res_tra,0,"total_traspasos");		
			
			if ($logica == 'CA' OR $logica == 'CA2'){
				$saldo		=	$debe + $total_traspasado - $haber - $total_traspasos;
			}
			if ($logica == 'CD'){
				$saldo		=	$haber + $total_traspasos - $total_traspasado;
			
			}
			if ($logica == 'CF'){
				$saldo		=	0;
			
			}
			if ($saldo > 0){
				$total_por_cobrar_periodo = $total_por_cobrar_periodo + $saldo;
			
				/*
				// ingresa en la tabla temporal
				$tfcv_origen	=	$logica." "."SIN CAMBIO SECTOR";
				$sql_temp 		= 	"insert into temp_folios_tpcp (tfcv_folio,tfcv_cuota,tfcv_saldo,tfcv_origen)
									values ('".$folio."','".$cuota."','".$saldo."','".$tfcv_origen."')";
				$res_temp 		= 	mysql_query($sql_temp,$conexion);
				*/
				
			}
			
		}
		
	}

	// busca el total de cuotas vencidas pero de los folios con cambios de sector
	// que en el rango consultado estaban en el sector
	// solicitado por javier (07/06/2012)
	// busco los folios que estaban en el sector dentro del rango consultado
	$sql_tcvcs 	= "select 
					a.CU_FOLIO, a.CU_NUMCUOTA, a.CU_DEBE, b.vent_estado_ingreso, b.vent_num_cuotas, a.CU_NCORR
					from $tabla_cuotas a, ventas_antigua b, ventas_cambio_sector c
					WHERE 
					a.CU_EMPRESA = '".$empe_rut."' and a.CU_FECVCTO >= '".$fecha_limite."' and a.CU_FECVCTO <= '".$fecha_termino."' AND 
					(a.CU_ESTADO != 'E' OR isnull(a.CU_ESTADO)) AND
					a.CU_FOLIO = b.vent_num_folio and
					b.empe_rut = '".$empe_rut."' and
					b.vent_estado_ingreso != 'A' and b.vent_estado_ingreso != 'N' and
					b.vent_num_cuotas > '0' and b.vent_valor_cuotas > '0' and
					b.vent_estado = 'FINALIZADA' and
					b.vent_fecha_revision >= '".$fecha_rev_kardex."' and
					b.vent_num_folio = c.vent_num_folio and
					c.empe_rut = '".$empe_rut."' and 
					c.vcse_fecha_dig > '".$fecha_termino."' and
					c.sect_ncorr_actual = '".$sector."'
					
					GROUP BY 
					a.cu_folio, a.CU_NUMCUOTA
					
					ORDER BY
					a.cu_folio, a.CU_NUMCUOTA asc, a.CU_NCORR desc";
	
	$res_tcvcs 	= mysql_query($sql_tcvcs, $conexion);

	while ($line_tcvcs = @mysql_fetch_row($res_tcvcs)) {
		
		$folio			= 	$line_tcvcs[0];
		$cuota			=	$line_tcvcs[1];
		$debe			=	$line_tcvcs[2];
		$haber			=	0;
		$saldo			=	0;
		$estado			=	$line_tcvcs[3];
		$num_cuotas		=	$line_tcvcs[4];
		
		
		// verifica si tiene descuadre
		// 27/08/2012
		$descuadre = 'NO';
		//$descuadre = RevisaDescuadre($folio,$empe_rut,$sector_format,$empe_ncorr);
		
		if ($descuadre == 'NO'){
		
			// 15/06/2012 busco si el folio fue cancelado con descuento, solicitado por javier
			// el total de cuotas vencidas omite los folios cancelados con descuentos
			// 28/06/2012 nueva modificacion, javier pide que considere los folios cancelados con descuento
			// que estuvieron activos en el periodo consultado
			
			$canc_con_desc	= 	'NO';
			$con_dv			= 	'NO';
			$logica 		= 	'CA';
			
			if ($estado == 'P'){
				
				// busco si la cuenta fue cancelada con descuento
				$sql_desc = "select desc_ncorr, desc_fecha from descuentos where empe_ncorr = '".$empe_ncorr."' and 
							vent_num_folio = '".$folio."' and desc_fecha >= '".$fecha_limite."' and desc_fecha <= '".$fecha_termino."' and
							desc_autorizado = 'SI'";
				$res_desc = mysql_query($sql_desc,$conexion);
				if (@mysql_num_rows($res_desc) > 0){
					$canc_con_desc	= 'SI';
					$desc_fecha		= @mysql_result($res_desc,0,"desc_fecha");
				}
				
				$sql_desc = "select desc_ncorr, desc_fecha from descuentos where empe_ncorr = '".$empe_ncorr."' and 
							vent_num_folio = '".$folio."' and desc_fecha < '".$fecha_limite."' and desc_fecha < '".$fecha_termino."' and
							desc_autorizado = 'SI'";
				$res_desc = mysql_query($sql_desc,$conexion);
				if (@mysql_num_rows($res_desc) > 0){
					$logica = 'CF';
				}
			}
			if ($estado == 'B'){ // DE BAJA
				// busco si la cuenta fue dada de baja
				$sql_desc = "select da_ncorr, da_fecha from descaumebaja where da_folio = '".$folio."' and 
							da_fecha >= '".$fecha_limite."' and da_fecha <= '".$fecha_termino."'";
				$res_desc = mysql_query($sql_desc,$conexion);
				if (@mysql_num_rows($res_desc) > 0){
					$canc_con_desc	= 'SI';
					$desc_fecha		= @mysql_result($res_desc,0,"da_fecha");
				}
				
				$sql_desc = "select da_ncorr, da_fecha from descaumebaja where da_folio = '".$folio."' and 
							da_fecha < '".$fecha_limite."' and da_fecha < '".$fecha_termino."'";
				$res_desc = mysql_query($sql_desc,$conexion);
				if (@mysql_num_rows($res_desc) > 0){
					$logica = 'CF';
				}
			}
			
			if ($canc_con_desc == 'NO'){
				// busca si la cuenta tuvo devoluciones
				$sql_dv = "select gd_ncorr, gd_fecha from d_guiadev where gd_empresa = '".$empe_rut."' and 
							gd_folio = '".$folio."' and gd_fecha >= '".$fecha_limite."' and gd_fecha <= '".$fecha_termino."'";
				$res_dv = mysql_query($sql_dv,$conexion);
				if (@mysql_num_rows($res_dv) > 0){
					$con_dv	= 'SI';
					$desc_fecha		= 	@mysql_result($res_dv,0,"gd_fecha");
					//$filtro_dv		=	" and AB_FECHAPAGO > '".$desc_fecha."'";
				}
				
				$sql_dv2 = "select gd_ncorr, gd_fecha from d_guiadev where gd_empresa = '".$empe_rut."' and 
							gd_folio = '".$folio."' and gd_fecha < '".$fecha_limite."' and gd_fecha < '".$fecha_termino."'";
				$res_dv2 = mysql_query($sql_dv2,$conexion);
				if (@mysql_num_rows($res_dv2) > 0){
					if ($estado == 'D'  OR $estado == 'P'){
						$logica = 'CF';
					}else{
						$filtro_fecha 	= 	@mysql_result($res_dv2,0,"gd_fecha");
						$logica 		= 	'CA2';
					}
				}
			}	
			
			if ($canc_con_desc == 'SI' OR $con_dv == 'SI'){
				// verifico si la fecha de descuento esta entre las fechas del periodo
				$sql_f1		= 	"SELECT DATEDIFF('".$desc_fecha."','".$fecha_limite."') as dias_f1";
				$res_f1		= 	mysql_query($sql_f1,$conexion);
				$dias_f1	=	@mysql_result($res_f1,0,"dias_f1");
				
				$sql_f2		= 	"SELECT DATEDIFF('".$desc_fecha."','".$fecha_termino."') as dias_f2";
				$res_f2		= 	mysql_query($sql_f2,$conexion);
				$dias_f2	=	@mysql_result($res_f2,0,"dias_f2");
				
				// fecha de descuento dentro del periodo consultado
				if ($dias_f1 >= 0 && $dias_f2 <= 0){
					$logica = 'CD';
				}	
			
			}
			
			if ($logica == 'CA'){
				$sql_tabo 	= "select 
								sum(AB_VALOR) as total_haber
								from $tabla_abonos
								WHERE 
								AB_EMPRESA = '".$empe_rut."' and AB_SECTOR = '".$sector."' AND
								AB_FECHAPAGO < '".$fecha_limite."' and
								ab_folio = '".$folio."' and
								ab_numcuota = '".$cuota."'";
				$res_tabo 	=  	mysql_query($sql_tabo, $conexion);
				$haber		=	@mysql_result($res_tabo,0,"total_haber");
			}
			if ($logica == 'CA2'){
				// busco el debe de la cuota activa
				$sql_dca	=	"select cu_debe from $tabla_cuotas where 
									cu_folio = '".$folio."' and 
									cu_numcuota = '".$cuota."' AND
									CU_FECVCTO >= '".$fecha_limite."' and CU_FECVCTO <= '".$fecha_termino."' and
									(CU_ESTADO != 'E' OR isnull(CU_ESTADO))
									order by cu_ncorr desc limit 1";
				$res_dca	=	mysql_query($sql_dca,$conexion);
				
				if (@mysql_num_rows($res_dca) > 0){
					$debe		=	@mysql_result($res_dca,0,"cu_debe");
					
					$sql_tabo 	= "select 
									sum(AB_VALOR) as total_haber
									from $tabla_abonos
									WHERE 
									AB_EMPRESA = '".$empe_rut."' and AB_SECTOR = '".$sector."' AND
									AB_FECHAPAGO < '".$fecha_limite."' and
									ab_folio = '".$folio."' and
									ab_numcuota = '".$cuota."' and
									(AB_ESTADO != 'E' OR isnull(AB_ESTADO))";
					$res_tabo 	=  	mysql_query($sql_tabo, $conexion);
					$haber		=	@mysql_result($res_tabo,0,"total_haber");
				}else{
					$debe		=	0;
				}
			}
			
			if ($logica == 'CD'){
				$sql_cv = "select tfcv_ncorr from temp_folios_cv where tfcv_folio = '".$folio."'";
				$res_cv = mysql_query($sql_cv,$conexion);
				if (@mysql_num_rows($res_cv) < 1){
					
					$sql_cape 	= "select 
									sum(AB_VALOR) as total_haber_per
									from $tabla_abonos
									WHERE 
									AB_EMPRESA = '".$empe_rut."' and AB_SECTOR = '".$sector."' AND
									ab_folio = '".$folio."' and
									AB_FECHAPAGO >= '".$fecha_limite."' and AB_FECHAPAGO <= '".$fecha_termino."' and
									AB_FECHAVENCI >= '".$fecha_limite."' and AB_FECHAVENCI <= '".$fecha_termino."'";
					$res_cape	=  	mysql_query($sql_cape, $conexion);
					
					$haber	=	@mysql_result($res_cape,0,"total_haber_per");
						
					//$sql_ing = "insert into temp_folios_tpcp (tfcv_folio) values ('".$folio."')";
					//$res_ing = mysql_query($sql_ing,$conexion);
				}
			}
			
			// busca los traspasos que ha hecho el folio a otros folios antes de la fecha de término
			$sql_trp = "select sum(da_valor) as total_traspasado from descaumebaja
						where 
						da_folio = '".$folio."' and
						da_movi = 'T' and 
						da_fecha <= '".$fecha_termino."'";
			$res_trp = mysql_query($sql_trp,$conexion);
			$total_traspasado = @mysql_result($res_trp,0,"total_traspasado");		
		
			// busca los traspasos que le han hecho al folio desde otros folios antes de la fecha de termino
			$sql_tra = "select sum(da_valor) as total_traspasos from descaumebaja
						where 
						da_traspasado = '".$folio."' and
						da_movi = 'T' and 
						da_fecha <= '".$fecha_termino."'";
			$res_tra = mysql_query($sql_tra,$conexion);
			$total_traspasos = @mysql_result($res_tra,0,"total_traspasos");		
			
			if ($logica == 'CA' OR $logica == 'CA2'){
				$saldo		=	$debe + $total_traspasado - $haber - $total_traspasos;
			}
			if ($logica == 'CD'){
				$saldo		=	$haber + $total_traspasos - $total_traspasado;
			
			}
			if ($logica == 'CF'){
				$saldo		=	0;
			
			}
			if ($saldo > 0){
				$total_por_cobrar_periodo = $total_por_cobrar_periodo + $saldo;
				
				/*
				// ingresa en la tabla temporal
				$tfcv_origen	=	$logica." "."CON CAMBIO SECTOR";
				$sql_temp 		= 	"insert into temp_folios_tpcp (tfcv_folio,tfcv_cuota,tfcv_saldo,tfcv_origen)
									values ('".$folio."','".$cuota."','".$saldo."','".$tfcv_origen."')";
				$res_temp 		= 	mysql_query($sql_temp,$conexion);
				*/
				
			}
		}
	}
	
	return $total_por_cobrar_periodo;
}

// funcion creada 23/08/2012 para descartar las cuentas con problema de 
//	descuadre en el informe general de cobranza, solictado por Javier
function RevisaDescuadre($folio,$empresa,$sector,$empe_ncorr) {
	
	global $conexion;	
	
	$folio			= 	$folio; 
	$empresa		= 	$empresa;
	$sector			=	$sector;
	$tabla_abonos	= 	"0".$empe_ncorr."_abonos".$sector;
	$tabla_cuotas	= 	"0".$empe_ncorr."_cuotas".$sector;
	
	
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

		if ($estado_antiguo == "CUOTA NO CUADRADA" && $estado == "OK"){
			$mensaje = 1;
		}
		
		$estado_antiguo = $estado;
		
	}

	if ($mensaje == 1){
		$descuadre = 'SI';
	}else{
		$descuadre = 'NO';
	}
	
	return $descuadre;
}
function BloqueaMovim($movim_fecha) {
	global $conexion;
	
	$ingresa	=	'SI';
	
	// valido la fecha del movim
	list($dia1,$mes1,$anio1) = split('[/.-]', $movim_fecha);$movim_fecha = $anio1."-".$mes1."-".$dia1;
	
	if ($dia1 != '' && $mes1 != '' && $anio1 != ''){
		if (checkdate ($mes1, $dia1, $anio1))
		{
			$ingresa		=	'SI';
		}else{
			$ingresa = "NO";
		}
	}else{
		$ingresa = "NO";
	}	
	
	//busco la fecha de cierre 27112012
	$sql_fc = "select cinv_fecha from cierres_inventarios order by cinv_fecha desc limit 1";
	$res_fc = mysql_query($sql_fc,$conexion);
	if (@mysql_num_rows($res_fc) > 0){
		$fecha_cierre = @mysql_result($res_fc,0,"cinv_fecha");
		
		$sql_f			=	"SELECT DATEDIFF('".$fecha_cierre."','".$movim_fecha."') as dias";
		$res_f			=	mysql_query($sql_f,$conexion);
		if (@mysql_result($res_f,0,"dias") >= 0){
			$ingresa 	= 	"NO";
		}
		
	}
	
	/*
	// buscos los dias para el bloqueo asociados en la bd (bloqueo_movim)
	$sql_b 			= 	"select bloq_dias from bloqueo_movim";
	$res_b 			= 	mysql_query($sql_b, $conexion);
	$dias_bloqueo 	= 	@mysql_result($res_b,0,"bloq_dias");
	$fecha_actual	=	date("Y-m-d");
	
	$sql_f			=	"SELECT DATEDIFF('".$fecha_actual."','".$movim_fecha."') as dias";
	$res_f			=	mysql_query($sql_f,$conexion);
	if (@mysql_result($res_f,0,"dias") > $dias_bloqueo){
		$ingresa 	= 	"NO";
	}
	*/
	
	return $ingresa;
  
}

function ValidaMontoPag($monto) {
	global $conexion;
	
	/*
	// buscos los dias para el bloqueo asociados en la bd (bloqueo_movim)
	$sql_b 			= 	"select bloq_dias from bloqueo_movim";
	$res_b 			= 	mysql_query($sql_b, $conexion);
	$dias_bloqueo 	= 	@mysql_result($res_b,0,"bloq_dias");
	$fecha_actual	=	date("Y-m-d");
	
	$sql_f			=	"SELECT DATEDIFF('".$fecha_actual."','".$movim_fecha."') as dias";
	$res_f			=	mysql_query($sql_f,$conexion);
	if (@mysql_result($res_f,0,"dias") > $dias_bloqueo){
		$ingresa 	= 	"NO";
	}
	*/
	
	$status			=	'NO';
	$fecha_actual 	= 	date("Y-m-d");
	
	$sql = "select abfe_fecha from temp_abonos_fechas limit 1";
	$res = mysql_query($sql,$conexion);
	$abfe_fecha 	= 	@mysql_result($res,0,"abfe_fecha");
	
	if (@mysql_num_rows($res) > 0){
		$sql_f			=	"SELECT DATEDIFF('".$abfe_fecha."','".$fecha_actual."') as dias";
		$res_f			=	mysql_query($sql_f,$conexion);
		if (@mysql_result($res_f,0,"dias") <= 0){
			$status 	= 	"OK";
		}else{
			$status 	= 	"OK";
		}
	}
	
	//$status 	= 	"OK";
	
	return $status;
	
}
function VerificaCierreInv($empresa,$vendedor,$fechamov) {
	/*
	$servidor 	= 	"localhost";
	$usuario 	= 	"root";
	$pass 		= 	"admin";
	$bd 		= 	"sgexistencia";
	$conexion 	= 	mysql_connect($servidor, $usuario, $pass);
	mysql_select_db($bd, $conexion);
	*/
	
	global $conexion;
	
	list($dia1,$mes1,$anio1) = split('[/.-]', $fechamov);$fechamov 	= $anio1."-".$mes1."-".$dia1;
	$tiene_inv	=	'NO';
	
	// verifico que le movimiento no sean antes de la fecha de un inventario
	$sql_inv 	= 	"select inve_ncorr, DATE_FORMAT(inve_fecha,'%d/%m/%Y') as fechainv from sgexistencia.inventarios 
					where empe_rut = '".$empresa."' and vend_cod = '".$vendedor."' and inve_fecha >= '".$fechamov."'"; 
	$res_inv 	= 	mysql_query($sql_inv,$conexion);
	if (@mysql_num_rows($res_inv) > 0){
		$inve_ncorr		=	@mysql_result($res_inv,0,"inve_ncorr");
		$fechainv		=	@mysql_result($res_inv,0,"fechainv");
		$tiene_inv		=	$fechainv;
	}
	
	return $tiene_inv;
  
}

//funcion para calculo de los días de atraso.
function da ($estado_venta,$folio,$empresa,$tabla_cuotas,$tabla_abonos) {
	/*
	$servidor = "localhost";
	$usuario = "root";
	$pass = "admin";
	$bd = "sgyonley";

	$conexion = mysql_connect($servidor, $usuario, $pass);
	mysql_select_db($bd, $conexion);
	*/
	
	global $conexion;
	
	$fecha_actual 	= 	date("Y-m-d");
	$da 			= 	0;
	$sql_da="";
	$sql_mcas ="";
	$sql_vab ="";
	$sql_csal="";
	$num_cuota_sig_no_saldada  =0;
	$num_cuota_mayor_saldada = 0;
	//if ($estado_venta != 'PAGADA' && $estado_venta != 'DEVOLUCION'){
//		
//		// verifico si tiene cuotas saldadas...
//		$sql_csal = "select CU_NUMCUOTA from $tabla_cuotas 
//					WHERE 
//					CU_FOLIO = '".$folio."' AND CU_EMPRESA = '".$empresa."' AND
//					CU_DEBE = CU_HABER AND
//					(CU_ESTADO != 'E' OR isnull(CU_ESTADO)) LIMIT 1";
//		$res_csal = mysql_query($sql_csal, $conexion);
//		if (@mysql_num_rows($res_csal) > 0){
//			
//			// verifico si la venta tiene abonos, busca la mayor cuota activa saldada
//			//	si tiene saco la fecha de pago y num cuota
//			$sql_vab = "select AB_FECHAPAGO, AB_NUMCUOTA
//						FROM 
//						$tabla_abonos
//					
//						WHERE
//						AB_FOLIO = '".$folio."' and AB_EMPRESA = '".$empresa."' and AB_VALOR > '0' AND (AB_ESTADO != 'E' OR isnull(AB_ESTADO))
//						ORDER BY AB_FECHAPAGO DESC, AB_NUMCUOTA DESC LIMIT 1";
//			
//			$res_vab = mysql_query($sql_vab, $conexion);
//			if (@mysql_num_rows($res_vab) > 0){
//				
//				// busca la mayor cuota activa saldada
//				$sql_mcas = "select CU_NUMCUOTA, CU_FECVCTO from $tabla_cuotas 
//							WHERE 
//							CU_FOLIO = '".$folio."' AND CU_EMPRESA = '".$empresa."' AND
//							CU_DEBE = CU_HABER AND
//							(CU_ESTADO != 'E' OR isnull(CU_ESTADO))
//							ORDER BY CU_NUMCUOTA DESC LIMIT 1";
//				$res_mcas = mysql_query($sql_mcas, $conexion);
//				if (@mysql_num_rows($res_mcas) > 0){
//					$num_cuota_mayor_saldada = @mysql_result($res_mcas,0,"CU_NUMCUOTA");
//					$fecha_venc_mayor_saldada = @mysql_result($res_mcas,0,"CU_FECVCTO");
//					
//					// busca la fecha del ult. abono de la mayor cuota saldada
//					$sql_fuam = "select AB_FECHAPAGO
//								FROM 
//								$tabla_abonos
//							
//								WHERE
//								AB_FOLIO = '".$folio."' and AB_EMPRESA = '".$empresa."' and AB_VALOR > '0' AND 
//								AB_NUMCUOTA = '".$num_cuota_mayor_saldada."' AND
//								(AB_ESTADO != 'E' OR isnull(AB_ESTADO))
//								ORDER BY AB_FECHAPAGO DESC LIMIT 1";
//					
//					$res_fuam = mysql_query($sql_fuam, $conexion);
//					if (@mysql_num_rows($res_fuam) > 0){
//						$fecha_ult_ab_mayor_saldada = @mysql_result($res_fuam,0,"AB_FECHAPAGO");
//						
//						// busca la fecha vencimiento de la cuota sig. a la ult. saldada
//							/*
//							$sql_csig = "select CU_FECVCTO from $tabla_cuotas 
//									WHERE 
//									CU_FOLIO = '".$folio."' AND CU_EMPRESA = '".$empresa."' AND
//									CU_DEBE > CU_HABER AND
//									(CU_ESTADO != 'E' OR isnull(CU_ESTADO))
//									ORDER BY CU_FECVCTO ASC LIMIT 1";
//							$res_csig = mysql_query($sql_csig, $conexion);
//							*/
//							
//						// MODIFICACION 02/05/2011
//						$num_cuota_sig_no_saldada = $num_cuota_mayor_saldada + 1;
//						$sql_csig = "select CU_FECVCTO from $tabla_cuotas 
//									WHERE 
//									CU_FOLIO = '".$folio."' AND CU_EMPRESA = '".$empresa."' AND
//									CU_NUMCUOTA = '".$num_cuota_sig_no_saldada."' AND
//									(CU_ESTADO != 'E' OR isnull(CU_ESTADO))";
//						$res_csig = mysql_query($sql_csig, $conexion);
//						$fecha_venc_cuota_sig = @mysql_result($res_csig,0,"CU_FECVCTO");
//						
//						// determino cuota anticipada
//						if ($fecha_ult_ab_mayor_saldada <= $fecha_venc_mayor_saldada){
//							
//							// DA = fecha actual - fecha venc. ult. cuota saldada
//							$sql_da = "SELECT DATEDIFF('".$fecha_actual."','".$fecha_venc_cuota_sig."') as da";
//							$res_da = mysql_query($sql_da, $conexion);
//							$da 	= @mysql_result($res_da,0,"da");
//							
//							if ($fecha_venc_mayor_saldada > $fecha_actual){ // agregado 4/4/2011
//								if ($da > 0){
//									$da = $da * -1;
//								}
//							}// agregado 4/4/2011
//							
//						}else{
//							// DA = fecha actual - fecha venc. ult. cuota saldada
//							$sql_da = "SELECT DATEDIFF('".$fecha_actual."','".$fecha_venc_cuota_sig."') as da";
//							$res_da = mysql_query($sql_da, $conexion);
//							$da 	= @mysql_result($res_da,0,"da");
//						}
//					}
//				}
//			
//			}else{
//				
//				// no tiene abonos
//				// busco la fecha venc. primera cuota pactada
//				$sql_par1 = "select CU_FECVCTO from $tabla_cuotas 
//							WHERE 
//							CU_FOLIO = '".$folio."' AND CU_EMPRESA = '".$empresa."' AND
//							CU_NUMCUOTA > '0' AND
//							(CU_ESTADO != 'E' OR isnull(CU_ESTADO))
//							
//							ORDER BY CU_NUMCUOTA ASC LIMIT 1";
//				$res_par1 = mysql_query($sql_par1, $conexion);
//				if (@mysql_num_rows($res_par1) > 0){
//					$fecha_venc_prim_cuota = @mysql_result($res_par1,0,"CU_FECVCTO");
//					$sql_da = "SELECT DATEDIFF('".$fecha_actual."','".$fecha_venc_prim_cuota."') as da";
//					$res_da = mysql_query($sql_da, $conexion);
//					$da 	= @mysql_result($res_da,0,"da");
//					if ($fecha_venc_prim_cuota > $fecha_actual){
//						if ($da > 0){
//							$da = $da * -1;
//						}
//					}
//				}
//			}
//		
//		}else{
//			// no tiene cuotas saldadas.
//			// busco la fecha venc. primera cuota
//			$sql_par1 = "select CU_FECVCTO from $tabla_cuotas 
//						WHERE 
//						CU_FOLIO = '".$folio."' AND CU_EMPRESA = '".$empresa."' AND
//						CU_NUMCUOTA > '0' AND
//						(CU_ESTADO != 'E' OR isnull(CU_ESTADO))
//						
//						ORDER BY CU_NUMCUOTA ASC LIMIT 1";
//			$res_par1 = mysql_query($sql_par1, $conexion);
//			if (@mysql_num_rows($res_par1) > 0){
//				$fecha_venc_prim_cuota = @mysql_result($res_par1,0,"CU_FECVCTO");
//				$sql_da = "SELECT DATEDIFF('".$fecha_actual."','".$fecha_venc_prim_cuota."') as da";
//				$res_da = mysql_query($sql_da, $conexion);
//				$da 	= @mysql_result($res_da,0,"da");
//				if ($fecha_venc_prim_cuota > $fecha_actual){
//					if ($da > 0){
//						$da = $da * -1;
//					}
//				}
//			}
//		}	
//	
//	}else{
//		
		if ($estado_venta != 'PAGADA' && $estado_venta != 'DEVOLUCION'){

			// busca todas las cuota pactadas para el folio (no considera las pactadas anteriores a una devolucion)
			$sql = "select
					CU_NUMCUOTA as num_cuota,
					CU_DEBE as valor_cuota
					FROM 
					$tabla_cuotas
					WHERE
					CU_FOLIO = '".$folio."' and 
					CU_EMPRESA = '".$empresa."' AND 
					(CU_ESTADO != 'E' OR isnull(CU_ESTADO)) and
					cu_debe <> 0
					
					ORDER BY CU_NUMCUOTA DESC";
			
			$res = mysql_query($sql, $conexion);
			$nro_cuota = 1;
			$estado="00";
			while (($line = mysql_fetch_row($res)) && ($estado!='OK')) {
			
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
				}
				else{
					$estado="OK";
					$nro_cuota = $numcuota+1;
					}
			}
			
			// no tiene cuotas saldadas.
			// busco la fecha venc. primera cuota
			$sql_par1 = "select CU_FECVCTO from $tabla_cuotas 
						WHERE 
						CU_FOLIO = '".$folio."' AND CU_EMPRESA = '".$empresa."' AND
						CU_NUMCUOTA = '".$nro_cuota."' AND
						(CU_ESTADO != 'E' OR isnull(CU_ESTADO))
						
						ORDER BY CU_NUMCUOTA ASC LIMIT 1";
			$res_par1 = mysql_query($sql_par1, $conexion);
			if (@mysql_num_rows($res_par1) > 0){
				$fecha_venc_prim_cuota = @mysql_result($res_par1,0,"CU_FECVCTO");
				$sql_da = "SELECT DATEDIFF('".$fecha_actual."','".$fecha_venc_prim_cuota."') as da";
				$res_da = mysql_query($sql_da, $conexion);
				$da 	= @mysql_result($res_da,0,"da");
				if ($fecha_venc_prim_cuota > $fecha_actual){
					if ($da > 0){
						$da = $da * -1;
					}
				}
			}
	
	}else{

	if ($estado_venta == 'DEVOLUCION'){
			
			$da 	= 	0;
			
		}else{
			
			//la cuenta esta cancelada (compara ultima_fecha_vcto v/s fecha ult. abono)
			$sql_par3 = "select CU_FECVCTO from $tabla_cuotas 
						WHERE 
						CU_FOLIO = '".$folio."' AND CU_EMPRESA = '".$empresa."' AND
						CU_NUMCUOTA > '0' AND
						(CU_ESTADO != 'E' OR isnull(CU_ESTADO))
						
						ORDER BY CU_NUMCUOTA DESC LIMIT 1";
			$res_par3 = mysql_query($sql_par3, $conexion);
			if (@mysql_num_rows($res_par3) > 0){
				$fecha_ult_vcto 	= 	@mysql_result($res_par3,0,"CU_FECVCTO");
				
				// busca la fecha del ult. abono de la mayor cuota saldada
				$sql_fuam = "select AB_FECHAPAGO
							FROM 
							$tabla_abonos
						
							WHERE
							AB_FOLIO = '".$folio."' and AB_EMPRESA = '".$empresa."' and AB_VALOR > '0' AND 
							(AB_ESTADO != 'E' OR isnull(AB_ESTADO))
							ORDER BY AB_FECHAPAGO DESC LIMIT 1";
				
				$res_fuam = mysql_query($sql_fuam, $conexion);
				if (@mysql_num_rows($res_fuam) > 0){
					$fecha_ult_abono = @mysql_result($res_fuam,0,"AB_FECHAPAGO");
				}
				
				$sql_da = "SELECT DATEDIFF('".$fecha_ult_abono."','".$fecha_ult_vcto."') as dias_atraso";
				$res_da = mysql_query($sql_da, $conexion);
				$da 	= @mysql_result($res_da,0,"dias_atraso");
			}	
		}
	}
	
	return strval($da);
}
function saldo ($folio,$empresa,$empe_ncorr) {
	/*
	$servidor = "localhost";
	$usuario = "root";
	$pass = "admin";
	$bd = "sgyonley";

	$conexion = mysql_connect($servidor, $usuario, $pass);
	mysql_select_db($bd, $conexion);
	*/
	
	global $conexion;

	$sql_vent = "select vent_total_venta, vent_descuento, vent_pie, sect_ncorr from ventas_antigua 
				where vent_num_folio = '".$folio."' and empe_rut = '".$empresa."'";
	$res_vent = mysql_query($sql_vent,$conexion);
	
	$total_venta 		= 	@mysql_result($res_vent,0,"vent_total_venta");
	$total_descuentos 	= 	@mysql_result($res_vent,0,"vent_descuento");
	$total_pie 			= 	@mysql_result($res_vent,0,"vent_pie");
	$sector 			= 	@mysql_result($res_vent,0,"sect_ncorr");
	
	if (strlen(trim($sector)) == 1){
		$sector = "0".$sector;
	}
	
	$tabla_abonos	= 	"0".$empe_ncorr."_abonos".$sector;
	
	// descuentos del sistema nuevo
	$sql_dc = "select sum(desc_monto) as total_descuentos from descuentos WHERE vent_num_folio = '".$folio."' AND empe_ncorr = '".$empe_ncorr."' AND desc_autorizado = 'SI'";
	$res_dc = mysql_query($sql_dc, $conexion);
	$total_descuentos = $total_descuentos + @mysql_result($res_dc, 0, "total_descuentos");
	
	// busca el total de traspasos al folio
	$sql_tr = "select sum(DA_VALOR) as total_traspasos from descaumebaja WHERE DA_MOVI = 'T' AND DA_TRASPASADO = '".$folio."'";
	$res_tr = mysql_query($sql_tr, $conexion);
	$total_traspasos = @mysql_result($res_tr, 0, "total_traspasos");
	
	// busca el total de traspasos del folio
	$sql_tr = "select sum(DA_VALOR) as total_traspasos from descaumebaja WHERE DA_MOVI = 'T' AND DA_FOLIO = '".$folio."'";
	$res_tr = mysql_query($sql_tr, $conexion);
	$total_traspasado = @mysql_result($res_tr, 0, "total_traspasos");
	
	//busca el total en devoluciones
	$sql_dev = "select sum(sv_valor) as total_dev from sub_guiadev where sv_folio = '".$folio."' and sv_empresa = '".$empresa."'";
	$res_dev = mysql_query($sql_dev, $conexion);
	$total_dev = @mysql_result($res_dev, 0, "total_dev");

	$sql_ta = "select sum(AB_VALOR) as total_abonos from $tabla_abonos 
				where 
				AB_FOLIO = '".$folio."' and 
				AB_EMPRESA = '".$empresa."'";
				
	$res_ta = mysql_query($sql_ta, $conexion);
	$total_abonos = @mysql_result($res_ta, 0, "total_abonos");
	
	$saldo_venta  = $total_venta - $total_pie - $total_abonos - $total_dev - $total_traspasos - $total_descuentos + $total_traspasado;

	return $saldo_venta;
}

// funcion que ordena una matriz
function ordenar_matriz_multidimensionada($m,$ordenar,$direccion) {
  usort($m, create_function('$item1, $item2', 'return strtoupper($item1[\'' . $ordenar . '\']) ' . ($direccion === 'ASC' ? '>' : '<') . ' strtoupper($item2[\'' . $ordenar . '\']);'));
  return $m;
}

//funcion resta horas
function RestaHoras($horaIni, $horaFin){
    return (date("H:i:s", strtotime("00:00:00") + strtotime($horaFin) - strtotime($horaIni) ));
}

//funcion valida rut.
function dv($r){$s=1;for($m=0;$r!=0;$r/=10)$s=($s+$r%10*(9-$m++%6))%11;
return chr($s?$s+47:75);}

//valida numeros enteros
function ValidaNumeros ($x) {
    return (is_numeric($x) ? intval($x) == $x : false);
}

//valida el ingreso de fecha correcta
function ValidaFecha ($f) {
	list($dia,$mes,$anio) = split('[/.-]', $f);
	return checkdate($mes, $dia, $anio);
}
//valida numeros decimales
function verifRealConDosDecimales($valor,$signo=3){
    if($signo==1)
        $patron = "/^[0-9]+(.[0-9]{1,2}|[0-9]*)$/";
    elseif($signo==2)
        $patron = "/^-[0-9]+(.[0-9]{1,2}|[0-9]*)$/";
    else
        $patron = "/^-?[0-9]+(.[0-9]{1,2}|[0-9]*)$/";
        
    if(!preg_match($patron,$valor))
        return true;
    else
        return false;
}

//compara fechas
function ComparaFechas ($f1, $f2) {
	list($dia1,$mes1,$anio1) = split('[/.-]', $f1);
	list($dia2,$mes2,$anio2) = split('[/.-]', $f2);

	//$fecha1 = mktime(0, 0, 0, $mes1, $dia1, $anio1);
	//$fecha2 = mktime(0, 0, 0, $mes2, $dia2, $anio2);
	
	return (mktime(0, 0, 0, $mes2, $dia2, $anio2) - mktime(0, 0, 0, $mes1, $dia1, $anio1));
}
function DevuelveDias ($f1, $f2) {
	list($dia1,$mes1,$anio1) = split('[/.-]', $f1);
	list($dia2,$mes2,$anio2) = split('[/.-]', $f2);
	

	$fecha1 = mktime(0, 0, 0, $mes1, $dia1, $anio1);
	$fecha2 = mktime(4, 12, 0, $mes2, $dia2, $anio2);
	
	//resto a una fecha la otra 
	$segundos_diferencia = $fecha1 - $fecha2; 
	//echo $segundos_diferencia; 

	//convierto segundos en días 
	$dias_diferencia = $segundos_diferencia / (60 * 60 * 24); 

	//obtengo el valor absoulto de los días (quito el posible signo negativo) 
	$dias_diferencia = abs($dias_diferencia); 

	//quito los decimales a los días de diferencia 
	$dias_diferencia = floor($dias_diferencia); 

	//echo $dias_diferencia; 
	
	//$total_dias = 0;
	
	//while ($fecha1 < $fecha2){
	//		$total_dias = $total_dias + 1;
	//		$fecha1 += 86400;
	//}
	//$total_dias++;
	
	return $dias_diferencia;
}
function SumaDias($mes, $anio, $dia, $dias)
{
     
	 		$ultimo_dia = date( "d", mktime(0, 0, 0, $mes + 1, 0, $anio) ) ;
      		$dias_adelanto = $dias;
      		$siguiente = $dia + $dias_adelanto;
      		if ($ultimo_dia < $siguiente)
      		{
         		$dia_final = $siguiente - $ultimo_dia;
         		$mes++;
         		if ($mes == '13')
         		{
            		$anio++;
            		$mes = '01';
         		}
         			$fecha_final = $dia_final.'/'.$mes.'/'.$anio;         
      		}
      		else
      		{
  				$fecha_final = $siguiente .'/'.$mes.'/'.$anio;         
      		}
      		return $fecha_final;
 }
function RestaDias($mes, $anio, $dia, $dias)
{
     
	 		$ultimo_dia = date( "d", mktime(0, 0, 0, $mes + 1, 0, $anio) ) ;
      		$dias_adelanto = $dias;
      		$siguiente = $dia + $dias_adelanto;
      		if ($ultimo_dia < $siguiente)
      		{
         		$dia_final = $siguiente - $ultimo_dia;
         		$mes--;
         		if ($mes == '13')
         		{
            		$anio--;
            		$mes = '01';
         		}
         			$fecha_final = $dia_final.'/'.$mes.'/'.$anio;         
      		}
      		else
      		{
  				$fecha_final = $siguiente .'/'.$mes.'/'.$anio;         
      		}
      		return $fecha_final;
 }


//arreglos...
//arreglo de horas
$arrHoras=array(array("IDHora" => "01"), array("IDHora" => "02"), array("IDHora" => "03"),
                array("IDHora" => "04"), array("IDHora" => "05"), array("IDHora" => "06"), array("IDHora" => "07"),
               	array("IDHora" => "08"), array("IDHora" => "09"), array("IDHora" => "10"), array("IDHora" => "11"),
               	array("IDHora" => "12"), array("IDHora" => "13"), array("IDHora" => "14"), array("IDHora" => "15"),
              	array("IDHora" => "16"), array("IDHora" => "17"), array("IDHora" => "18"), array("IDHora" => "19"),
              	array("IDHora" => "20"), array("IDHora" => "21"), array("IDHora" => "22"), array("IDHora" => "23"),
				array("IDHora" => "24"));


//sql para unir tablas...
//SELECT *, comunas_descripcion FROM usuarios,comunas 
//WHERE usuarios.comuna = comunas.id;

//transforma a letras los montos...
function num2letras($num, $fem = true, $dec = true) { 
//if (strlen($num) > 14) die("El n?mero introducido es demasiado grande"); 
   $matuni[2]  = "dos"; 
   $matuni[3]  = "tres"; 
   $matuni[4]  = "cuatro"; 
   $matuni[5]  = "cinco"; 
   $matuni[6]  = "seis"; 
   $matuni[7]  = "siete"; 
   $matuni[8]  = "ocho"; 
   $matuni[9]  = "nueve"; 
   $matuni[10] = "diez"; 
   $matuni[11] = "once"; 
   $matuni[12] = "doce"; 
   $matuni[13] = "trece"; 
   $matuni[14] = "catorce"; 
   $matuni[15] = "quince"; 
   $matuni[16] = "dieciseis"; 
   $matuni[17] = "diecisiete"; 
   $matuni[18] = "dieciocho"; 
   $matuni[19] = "diecinueve"; 
   $matuni[20] = "veinte"; 
   $matunisub[2] = "dos"; 
   $matunisub[3] = "tres"; 
   $matunisub[4] = "cuatro"; 
   $matunisub[5] = "quin"; 
   $matunisub[6] = "seis"; 
   $matunisub[7] = "sete"; 
   $matunisub[8] = "ocho"; 
   $matunisub[9] = "nove"; 

   $matdec[2] = "veint"; 
   $matdec[3] = "treinta"; 
   $matdec[4] = "cuarenta"; 
   $matdec[5] = "cincuenta"; 
   $matdec[6] = "sesenta"; 
   $matdec[7] = "setenta"; 
   $matdec[8] = "ochenta"; 
   $matdec[9] = "noventa"; 
   $matsub[3]  = 'mill'; 
   $matsub[5]  = 'bill'; 
   $matsub[7]  = 'mill'; 
   $matsub[9]  = 'trill'; 
   $matsub[11] = 'mill'; 
   $matsub[13] = 'bill'; 
   $matsub[15] = 'mill'; 
   $matmil[4]  = 'millones'; 
   $matmil[6]  = 'billones'; 
   $matmil[7]  = 'de billones'; 
   $matmil[8]  = 'millones de billones'; 
   $matmil[10] = 'trillones'; 
   $matmil[11] = 'de trillones'; 
   $matmil[12] = 'millones de trillones'; 
   $matmil[13] = 'de trillones'; 
   $matmil[14] = 'billones de trillones'; 
   $matmil[15] = 'de billones de trillones'; 
   $matmil[16] = 'millones de billones de trillones'; 

   $num = trim((string)@$num); 
   if ($num[0] == '-') { 
      $neg = 'menos '; 
      $num = substr($num, 1); 
   }else 
      $neg = ''; 
   while ($num[0] == '0') $num = substr($num, 1); 
   if ($num[0] < '1' or $num[0] > 9) $num = '0' . $num; 
   $zeros = true; 
   $punt = false; 
   $ent = ''; 
   $fra = ''; 
   for ($c = 0; $c < strlen($num); $c++) { 
      $n = $num[$c]; 
      if (! (strpos(".,'''", $n) === false)) { 
         if ($punt) break; 
         else{ 
            $punt = true; 
            continue; 
         } 

      }elseif (! (strpos('0123456789', $n) === false)) { 
         if ($punt) { 
            if ($n != '0') $zeros = false; 
            $fra .= $n; 
         }else 

            $ent .= $n; 
      }else 

         break; 

   } 
   $ent = '     ' . $ent; 
   if ($dec and $fra and ! $zeros) { 
      $fin = ' coma'; 
      for ($n = 0; $n < strlen($fra); $n++) { 
         if (($s = $fra[$n]) == '0') 
            $fin .= ' cero'; 
         elseif ($s == '1') 
            $fin .= $fem ? ' uno' : ' un'; 
         else 
            $fin .= ' ' . $matuni[$s]; 
      } 
   }else 
      $fin = ''; 
   if ((int)$ent === 0) return 'Cero ' . $fin; 
   $tex = ''; 
   $sub = 0; 
   $mils = 0; 
   $neutro = false; 
   while ( ($num = substr($ent, -3)) != '   ') { 
      $ent = substr($ent, 0, -3); 
      if (++$sub < 3 and $fem) { 
         $matuni[1] = 'uno'; 
         $subcent = 'os'; 
      }else{ 
         $matuni[1] = $neutro ? 'un' : 'uno'; 
         $subcent = 'os'; 
      } 
      $t = ''; 
      $n2 = substr($num, 1); 
      if ($n2 == '00') { 
      }elseif ($n2 < 21) 
         $t = ' ' . $matuni[(int)$n2]; 
      elseif ($n2 < 30) { 
         $n3 = $num[2]; 
         if ($n3 != 0) $t = 'i' . $matuni[$n3]; 
         $n2 = $num[1]; 
         $t = ' ' . $matdec[$n2] . $t; 
      }else{ 
         $n3 = $num[2]; 
         if ($n3 != 0) $t = ' y ' . $matuni[$n3]; 
         $n2 = $num[1]; 
         $t = ' ' . $matdec[$n2] . $t; 
      } 
      $n = $num[0]; 
      if ($n == 1) { 
         $t = ' ciento' . $t; 
      }elseif ($n == 5){ 
         $t = ' ' . $matunisub[$n] . 'ient' . $subcent . $t; 
      }elseif ($n != 0){ 
         $t = ' ' . $matunisub[$n] . 'cient' . $subcent . $t; 
      } 
      if ($sub == 1) { 
      }elseif (! isset($matsub[$sub])) { 
         if ($num == 1) { 
            $t = ' mil'; 
         }elseif ($num > 1){ 
            $t .= ' mil'; 
         } 
      }elseif ($num == 1) { 
         $t .= ' ' . $matsub[$sub] . '?n'; 
      }elseif ($num > 1){ 
         $t .= ' ' . $matsub[$sub] . 'ones'; 
      }   
      if ($num == '000') $mils ++; 
      elseif ($mils != 0) { 
         if (isset($matmil[$sub])) $t .= ' ' . $matmil[$sub]; 
         $mils = 0; 
      } 
      $neutro = true; 
      $tex = $t . $tex; 
   } 
   $tex = $neg . substr($tex, 1) . $fin; 
   return ucfirst($tex); 
} 


?>
