<?php
session_start();

require_once 'includes/xajax/xajax.inc.php'; //archivo de configuracion de ajax
include "../includes/php/conf_smarty.php";//archivo de configuracion de smarty
include "../includes/php/conf_bd.php"; //archivo de coneccion al servidor y base de datos
//include "../includes/php/conf_bd_antigua.php"; //archivo de coneccion al servidor de yonley
include "../includes/php/validaciones.php"; 
include "../includes/php/class.phpmailer.php";
include "../includes/php/class.pop3.php";
include "../includes/php/class.smtp.php";
include "../includes/php/PHPExcel.php";
include "../includes/php/PHPExcel/Reader/Excel2007.php";

$xajax = new xajax();

$xajax->setRequestURI("sg_informe_resumen.php");
$xajax->setCharEncoding("ISO-8859-1");
$xajax->decodeUTF8InputOn();

function Grabar($data){
	global $conexion;
	global $miSmarty;
        
	$objResponse = new xajaxResponse('ISO-8859-1');
	
	$trabajador         =   $data["OBLItxtCodCobrador"];
    $nombre_trabajador  =   $data["OBLIcboPersona"];
    $OBLItxtFecha1      =   $data["OBLItxtFecha1"];
    $OBLItxtFecha2 		=	$data["OBLItxtFecha2"];
	    
	$OBLItxtFecha1_1 = "";	
	$OBLItxtFecha1_2 = "";	
	$OBLItxtFecha2_1 = "";	
	$OBLItxtFecha2_2 = "";	

	if (($OBLItxtFecha1 != '') && ($OBLItxtFecha2 != '') ){
		list($dia3,$mes3,$anio3) = explode('/', $OBLItxtFecha1);$OBLItxtFecha1 = $anio3."-".$mes3."-".$dia3;
		list($dia3,$mes3,$anio3) = explode('/', $OBLItxtFecha2);$OBLItxtFecha2 = $anio3."-".$mes3."-".$dia3;
		$and .= " and anticipos.fecha between '".$OBLItxtFecha1."' and '".$OBLItxtFecha2."' ";
		
		$OBLItxtFecha1_1 = date("Y-m-d",mktime(0,0,0,$mes3-1,25,$anio3));
		$OBLItxtFecha1_2 = date("Y-m-d",mktime(0,0,0,$mes3-1,26,$anio3));
		$OBLItxtFecha2_1 = date("Y-m-d",mktime(0,0,0,$mes3,24,$anio3));
		$OBLItxtFecha2_2 = date("Y-m-d",mktime(0,0,0,$mes3,25,$anio3));
	}
	
	$nombre_trabajador = "";
	$monto_anticipo = 0;
	$total = 0;
	
	$objResponse->addScript("document.getElementById('divlistado').style.display='none';");
			
	$sql_pd="SELECT COALESCE(sum(monto),0) as monto
			 FROM  anticipos
			 where trabajador = $trabajador $and 
			 	and estado in ('PAGADO')";        
	$res_pd = mysql_query($sql_pd, $conexion) or die(mysql_error());
	if (mysql_num_rows($res_pd) > 0){
		$arrRegistros		= 	array();
		$i 					= 	1;
		$total = 0;
		while ($line_pd = mysql_fetch_array($res_pd)) {
			$sql_1 = "select concat(nombres,' ',apellido_pat,' ',apellido_mat) as nombres
						from sggeneral.trabajadores
						where rut = $trabajador";
			$res_1 = mysql_query($sql_1,$conexion) or die(mysql_error());
			$row_1 = mysql_fetch_array($res_1);
			
			$sql_2 = "select distinct tipo_trab from anticipos where trabajador = $trabajador and tipo_trab not in (1,5)";
			$res_2 = mysql_query($sql_2,$conexion) or die(mysql_error());
			$cantidad_tt = mysql_num_rows($res_2);
			$row_2 = mysql_fetch_array($res_2);
			
			$nombre_trabajador = $row_1['nombres'];
			$monto_anticipo = $line_pd['monto'];
			//$objResponse->addAlert($cantidad_tt);
			if (($row_2['tipo_trab']!='1')&&($row_2['tipo_trab']!='5')&&($row_2['tipo_trab']!=''))
				$monto_anticipo -= 600*$cantidad_tt;
			$total = $total + $monto_anticipo;
			}
		// asigno las sesiones para el ordenamiento
	}

	$total_sobrante = 0;
	$total_faltante = 0;		

	$co_codigo ="";
	for($i=1;$i<19;$i++){
		if (strlen(trim($i)) == 1){
			$i = "0".$i;
			}
		$tabla_abonos	= 	"01_abonos".$i;
		//seguir con el 6
					$sql_t1 = "select 
								SUM(AB_VALOR) as total_cobranza, AB_SUPERVISOR,AB_COBRADOR
								
								from 
								sgyonley.$tabla_abonos
								
								WHERE
								(
								AB_FECHAPAGO between '".$OBLItxtFecha1_1."' and '".$OBLItxtFecha2_1."'  AND
								AB_COBRADOR in ( select co_codigo from sgyonley.cobrador where co_rut = '".$trabajador."' ) AND
								ab_cambio_sector = 'NO' AND
								tabo_ncorr in ('1','4') and 
								AB_EMPRESA in ( select co_empresa from sgyonley.cobrador where co_rut = '".$trabajador."' ) 
								)
								or(
								AB_FECHAPAGO between '".$OBLItxtFecha1_1."' and '".$OBLItxtFecha2_1."'  AND
								AB_SUPERVISOR in ( select sp_codigo from sgyonley.supervisor where sp_rut = '".$trabajador."' ) AND
								ab_cambio_sector = 'NO' AND
								tabo_ncorr in ('1','4') and 
								AB_EMPRESA in ( select sp_empresa from sgyonley.supervisor where sp_rut = '".$trabajador."' ) 
								)";
					
					$res_t1 = mysql_query($sql_t1, $conexion);
					
					$total_cobranza = @mysql_result($res_t1,0,"total_cobranza");
					$sp_codigo = @mysql_result($res_t1,0,"AB_SUPERVISOR");
					$co_codigo = @mysql_result($res_t1,0,"AB_COBRADOR");
		
					// busca al supervisor
					$sql_sup = "select sp_nombre from sgyonley.supervisor where sp_codigo = '".$sp_codigo."' and sp_empresa = '".$empe_rut."'";
					$res_sup = mysql_query($sql_sup,$conexion);
					$sp_nombre 	= @mysql_result($res_sup,0,"sp_nombre");
					
					$sql_t1 = "select 
								SUM(AB_VALOR) as total_cobranza
								
								from 
								sgyonley.$tabla_abonos
								
								WHERE
								(
								AB_FECHAPAGO between '".$OBLItxtFecha1_1."' and '".$OBLItxtFecha2_1."'  AND
								AB_COBRADOR in ( select co_codigo from sgyonley.cobrador where co_rut = '".$trabajador."' ) AND
								ab_cambio_sector = 'NO' AND
								tabo_ncorr in ('4') and 
								AB_EMPRESA in ( select co_empresa from sgyonley.cobrador where co_rut = '".$trabajador."' ) 
								)
								or(
								AB_FECHAPAGO between '".$OBLItxtFecha1_1."' and '".$OBLItxtFecha2_1."'  AND
								AB_SUPERVISOR in ( select sp_codigo from sgyonley.supervisor where sp_rut = '".$trabajador."' ) AND
								ab_cambio_sector = 'NO' AND
								tabo_ncorr in ('4') and 
								AB_EMPRESA in ( select sp_empresa from sgyonley.supervisor where sp_rut = '".$trabajador."' ) 
								)
								";
					
					$res_t1 = mysql_query($sql_t1, $conexion);
					
					$total_cobranza_1 = @mysql_result($res_t1,0,"total_cobranza");
					$total_deposito	= 0;

					$fecha1 = $OBLItxtFecha1_1;
					$fecha2 = $OBLItxtFecha2_1;
			
					$sql_fec 	= 	"SELECT DATEDIFF('".$fecha2."','".$fecha1."') as dias";
					$res_fec 	=	mysql_query($sql_fec,$conexion);
					$dias		=	@mysql_result($res_fec,0,"dias");
			
					$total_deposito = 0;
					if ($dias >= 0){
						$k = 0;
						while ($k <= $dias) {
							$sql_t1 = "select  distinct ab_cobrador
										from sgyonley.$tabla_abonos
									WHERE
									AB_FECHAPAGO = '".$fecha1."'   AND
									AB_SUPERVISOR in ( select sp_codigo from sgyonley.supervisor where sp_rut = '".$trabajador."' ) AND
									ab_cambio_sector = 'NO' and 
									AB_EMPRESA in ( select co_empresa from sgyonley.cobrador where co_rut = '".$trabajador."' ) 
								";
					
							$res_t1 = mysql_query($sql_t1, $conexion);
							$co_codigo = @mysql_result($res_t1,0,"ab_supervisor");
							//busca la sumatoria del deposito
							$sql_dep = "select sum(depo_monto) as total_deposito from sgyonley.depositos
										where 
										(
										co_codigo = '".$co_codigo."'  and
										depo_fecha = '".$fecha1."' and
										sect_cod = '".$i."' and 
										empe_rut = '76112370' and 
										empe_rut in ( select sp_empresa from sgyonley.supervisor where sp_rut = '".$trabajador."' )
										)
										or
										(
										co_codigo in ( select co_codigo from sgyonley.cobrador where co_rut = '".$trabajador."' )  and
										depo_fecha = '".$fecha1."' and
										sect_cod = '".$i."' and 
										empe_rut = '76112370' and 
										empe_rut in ( select co_empresa from sgyonley.cobrador where co_rut = '".$trabajador."' )
					)
							";
							if ($sp_codigo=='99'){
								$sql_dep = "select sum(depo_monto) as total_deposito from sgyonley.depositos
											where 
											
											co_codigo  in ( select co_codigo from sgyonley.cobrador where co_rut = '".$trabajador."' ) and
											depo_fecha = '".$fecha1."' and
											sect_cod = '".$i."' and 
											empe_rut = '76112370' and 
											empe_rut in ( select co_empresa from sgyonley.cobrador where co_rut = '".$trabajador."' )
											
											";
								//$objResponse->addAlert($sql_dep);		
								$res_dep = mysql_query($sql_dep,$conexion) or die(mysql_error());
								$total_deposito	+=	@mysql_result($res_dep,0,"total_deposito");
								}
							else{
								$sql_dep = "select sum(depo_monto) as total_deposito from sgyonley.depositos
											where 
											
											co_codigo in ( select co_codigo from sgyonley.cobrador where co_rut = '".$trabajador."' )  and
											depo_fecha = '".$fecha1."' and
											sect_cod = '".$i."' and 
											empe_rut = '76112370' and 
											empe_rut in ( select co_empresa from sgyonley.cobrador where co_codigo in ( select co_codigo from sgyonley.cobrador where co_rut = '".$trabajador."' ))
											";
								//$objResponse->addAlert($sql_dep);		
								$res_dep = mysql_query($sql_dep,$conexion) or die(mysql_error());
								$total_deposito	+=	@mysql_result($res_dep,0,"total_deposito");
								}
								
						$res_dep = mysql_query($sql_dep,$conexion) or die(mysql_error());
						$total_deposito	+=	@mysql_result($res_dep,0,"total_deposito");		
						// incremento el dia a fecha1
						$sql_ife 	= 	"SELECT DATE_ADD('".$fecha1."', INTERVAL 1 DAY) as fecha1";
						$res_ife 	= 	mysql_query($sql_ife,$conexion);
						$fecha1		=	@mysql_result($res_ife,0,"fecha1");
						
						$k++;
						}
					}	
					//busca la sumatoria del pie vendedor
					$sql_pve = "select sum(pven_monto) as total_pie_vendedor from sgyonley.pie_vendedor
								where 
								co_codigo in ( select co_codigo from sgyonley.cobrador where co_rut = '".$trabajador."' ) and
								pven_fecha between '".$OBLItxtFecha1."' and '".$OBLItxtFecha2."' and
								sect_cod = '".$j."'";
								
					$res_pve = mysql_query($sql_pve,$conexion);
					$total_pie_vendedor		=	@mysql_result($res_pve,0,"total_pie_vendedor");
					
					//busca la sumatoria del sobrante cliente
					$sql_scli = "select sum(scli_monto) as total_sob_cliente from sgyonley.sobrante_cliente
								where 
								co_codigo in ( select co_codigo from sgyonley.cobrador where co_rut = '".$trabajador."' ) and
								scli_fecha between '".$OBLItxtFecha1_1."' and '".$OBLItxtFecha2_1."' and
								sect_cod = '".$i."' and empe_rut = '76112370' and empe_rut in ( select co_empresa from sgyonley.cobrador where co_rut = '".$trabajador."' )";
								
					$res_scli = mysql_query($sql_scli,$conexion);
					$total_sob_cliente		=	@mysql_result($res_scli,0,"total_sob_cliente");
					
					//busca la sumatoria del sobrante ocupado
					$sql_socu = "select sum(a.scas_monto) as total_sob_ocupado from 
								sgyonley.sobrante_cliente_asignacion a, sgyonley.sobrante_cliente b
								where 
								(
								b.co_codigo 	in ( select co_codigo from sgyonley.cobrador where co_rut = '".$trabajador."' )  and
								a.co_codigo 	in ( select co_codigo from sgyonley.cobrador where co_rut = '".$trabajador."' )  and
								b.scli_ncorr 	= 	a.scli_ncorr and
								a.scas_fechacob  between '".$OBLItxtFecha1_1."' and '".$OBLItxtFecha2_1."'  and
								b.sect_cod = '".$i."' and b.empe_rut = '76112370'  and b.empe_rut in ( select co_empresa from sgyonley.cobrador where co_rut = '".$trabajador."' ))
								or (
								b.co_codigo 	in ( select co_codigo from sgyonley.cobrador where co_rut = '".$trabajador."' ) and
								a.co_codigo 	= 	'' and
								b.scli_ncorr 	= 	a.scli_ncorr and
								a.scas_fechacob  between '".$OBLItxtFecha1_1."' and '".$OBLItxtFecha2_1."'  and
								b.sect_cod = '".$i."' and b.empe_rut = '76112370' and b.empe_rut in ( select co_empresa from sgyonley.cobrador where co_rut = '".$trabajador."' )
								)";
								
					$res_socu = mysql_query($sql_socu,$conexion);
					$total_sob_ocupado		=	@mysql_result($res_socu,0,"total_sob_ocupado");
						
					//busca la sumatoria del sobrante ocupado
					$sql_socu = "select sum(a.scas_monto) as total_sob_ocupado from 
								sgyonley.sobrante_cliente_asignacion a, sgyonley.sobrante_cliente b
								where 
								a.co_codigo 	in ( select co_codigo from sgyonley.cobrador where co_rut = '".$trabajador."' ) and
								b.co_codigo 	in ( select co_codigo from sgyonley.cobrador where co_rut = '".$trabajador."' ) and
								b.scli_ncorr 	= 	a.scli_ncorr and
								a.scas_fechacob  between '".$OBLItxtFecha1_1."' and '".$OBLItxtFecha2_1."'  and
								b.sect_cod = '".$i."' and b.empe_rut = '76112370' and b.empe_rut in ( select co_empresa from sgyonley.cobrador where co_rut = '".$trabajador."' )";
								
					$res_socu = mysql_query($sql_socu,$conexion);
					$total_sob_ocupado		+=	@mysql_result($res_socu,0,"total_sob_ocupado");
					
					$resultado = $total_cobranza - $total_cobranza_1 - $total_deposito - $total_pie_vendedor + $total_sob_cliente - $total_sob_ocupado;	
					//$objResponse->addAlert("normal -> sector $i : total_cobranza -> $total_cobranza - total_cobranza_1 -> $total_cobranza_1 - total_deposito -> $total_deposito - total_pie_vendedor -> $total_pie_vendedor + total_sob_cliente -> $total_sob_cliente - total_sob_ocupado -> $total_sob_ocupado;	");
					$resultado_sup = 0;	
					if (strlen($sp_codigo)>0 && ($sp_codigo != '99')){
						$total_cobranza_sup = $total_cobranza ;
						$total_cobranza_1_sup = $total_cobranza_1;
						$resultado_sup = $resultado;
						$resultado = 0;
						//$objResponse->addAlert("super -> $sp_codigo sector $i -> fecha $fecha1: $total_cobranza_sup - $total_cobranza_1_sup - $total_deposito - $total_pie_vendedor + $total_sob_cliente - $total_sob_ocupado;");
						}
					else{
						$resultado_sup = 0;
						}
		
					$sobrante = 0;
					$faltante = 0;
					
					$sobrante_sup = 0;
					$faltante_sup = 0;
					
					if ($resultado > 0){$faltante = $resultado;}
					if ($resultado < 0){$sobrante = $resultado; $sobrante = $sobrante * -1;}
					
					$total_sobrante = $total_sobrante + $sobrante;
					$total_faltante = $total_faltante + $faltante;
					
					if ($resultado_sup > 0){$faltante_sup = $resultado_sup;}
					if ($resultado_sup < 0){$sobrante_sup = $resultado_sup; $sobrante_sup = $sobrante_sup * -1;}
					
					$total_sobrante_sup = $total_sobrante_sup + $sobrante_sup;
					$total_faltante_sup = $total_faltante_sup + $faltante_sup;

		}
		
	$fecha1 = $OBLItxtFecha1_1;
	$fecha2 = $OBLItxtFecha2_1;

	for($j=1;$j<47;$j++){
		if (strlen(trim($j)) == 1){$j = "0".$j;}
		$tabla_abonos	= 	"02_abonos".$j;
		$sql_t1 = "select 
					SUM(AB_VALOR) as total_cobranza, AB_SUPERVISOR,AB_COBRADOR
					
					from 
					sgyonley.$tabla_abonos
					
					WHERE
					(
					AB_FECHAPAGO  between '".$OBLItxtFecha1_1."' and '".$OBLItxtFecha2_1."'  AND
					AB_COBRADOR in ( select co_codigo from sgyonley.cobrador where co_rut = '".$trabajador."' ) AND
					ab_cambio_sector = 'NO' AND
					tabo_ncorr in ('1','4') and 
					AB_EMPRESA in ( select co_empresa from sgyonley.cobrador where co_rut = '".$trabajador."' ) 
					)
					or(
					AB_FECHAPAGO  between '".$OBLItxtFecha1_1."' and '".$OBLItxtFecha2_1."'  AND
					AB_SUPERVISOR in ( select sp_codigo from sgyonley.supervisor where sp_rut = '".$trabajador."' ) AND
					ab_cambio_sector = 'NO' AND
					tabo_ncorr in ('1','4') and 
					AB_EMPRESA in ( select co_empresa from sgyonley.cobrador where co_rut = '".$trabajador."' ) 
					)";
		
		$res_t1 = mysql_query($sql_t1, $conexion);
		
		$total_cobranza = @mysql_result($res_t1,0,"total_cobranza");
		$sp_codigo = @mysql_result($res_t1,0,"AB_SUPERVISOR");
		$co_codigo = @mysql_result($res_t1,0,"AB_COBRADOR");
	
		// busca al supervisor
		$sql_sup = "select sp_nombre from sgyonley.supervisor where sp_codigo = '".$sp_codigo."' and sp_empresa = '".$empe_rut."'";
		$res_sup = mysql_query($sql_sup,$conexion);
		$sp_nombre 	= @mysql_result($res_sup,0,"sp_nombre");
		
		$sql_t1 = "select 
					SUM(AB_VALOR) as total_cobranza
					
					from 
					sgyonley.$tabla_abonos
					
					WHERE
					(
					AB_FECHAPAGO  between '".$OBLItxtFecha1_1."' and '".$OBLItxtFecha2_1."'   AND
					AB_COBRADOR in ( select co_codigo from sgyonley.cobrador where co_rut = '".$trabajador."' ) AND
					ab_cambio_sector = 'NO' AND
					tabo_ncorr in ('4') and 
					AB_EMPRESA in ( select co_empresa from sgyonley.cobrador where co_rut = '".$trabajador."' ) 
					)
					or(
					AB_FECHAPAGO  between '".$OBLItxtFecha1_1."' and '".$OBLItxtFecha2_1."'   AND
					AB_SUPERVISOR in ( select sp_codigo from sgyonley.supervisor where sp_rut = '".$trabajador."' ) AND
					ab_cambio_sector = 'NO' AND
					tabo_ncorr in ('4') and 
					AB_EMPRESA in ( select co_empresa from sgyonley.cobrador where co_rut = '".$trabajador."' ) 
					)";
		
		$res_t1 = mysql_query($sql_t1, $conexion);
		$total_cobranza_1 = @mysql_result($res_t1,0,"total_cobranza");
		
		$fecha1 = $OBLItxtFecha1_1;
		$fecha2 = $OBLItxtFecha2_1;
		$sql_fec 	= 	"SELECT DATEDIFF('".$fecha2."','".$fecha1."') as dias";
		$res_fec 	=	mysql_query($sql_fec,$conexion);
		$dias		=	@mysql_result($res_fec,0,"dias");
		$total_deposito = 0;
		if ($dias >= 0){
			$i = 0;
			while ($i <= $dias) {
				$sql_t1 = "select  distinct ab_cobrador
							from sgyonley.$tabla_abonos
						WHERE
						AB_FECHAPAGO = '".$fecha1."'   AND
						AB_SUPERVISOR in ( select sp_codigo from sgyonley.supervisor where sp_rut = '".$trabajador."' ) AND
						ab_cambio_sector = 'NO' and 
						AB_EMPRESA in ( select co_empresa from sgyonley.cobrador where co_rut = '".$trabajador."' ) 
					";
		
				$res_t1 = mysql_query($sql_t1, $conexion);
				$co_codigo = @mysql_result($res_t1,0,"ab_supervisor");
				//busca la sumatoria del deposito
				$sql_dep = "select sum(depo_monto) as total_deposito from sgyonley.depositos
							where 
							(
							co_codigo = '".$co_codigo."'  and
							depo_fecha = '".$fecha1."' and
							sect_cod = '".$j."' and 
							empe_rut = '78748930' and 
							empe_rut in ( select sp_empresa from sgyonley.supervisor where sp_rut = '".$trabajador."' )
							)
							or
							(
							co_codigo in ( select co_codigo from sgyonley.cobrador where co_rut = '".$trabajador."' )  and
							depo_fecha = '".$fecha1."' and
							sect_cod = '".$j."' and 
							empe_rut = '78748930' and 
							empe_rut in ( select co_empresa from sgyonley.cobrador where co_rut = '".$trabajador."' )
							)
							";
				//$objResponse->addAlert($sql_dep);		
				$res_dep = mysql_query($sql_dep,$conexion) or die(mysql_error());
				$total_deposito	+=	@mysql_result($res_dep,0,"total_deposito");
				// incremento el dia a fecha1
				$sql_ife 	= 	"SELECT DATE_ADD('".$fecha1."', INTERVAL 1 DAY) as fecha1";
				$res_ife 	= 	mysql_query($sql_ife,$conexion);
				$fecha1		=	@mysql_result($res_ife,0,"fecha1");
				
				$i++;
				}
			}					
		
	//					//busca la sumatoria del pie vendedor
	//					$sql_pve = "select sum(pven_monto) as total_pie_vendedor from sgyonley.pie_vendedor
	//								where 
	//								co_codigo in ( select co_codigo from sgyonley.cobrador where co_rut = '".$trabajador."' ) and
	//								pven_fecha between '".$OBLItxtFecha1."' and '".$OBLItxtFecha2."' and
	//								sect_cod = '".$j."'";
	//								
	//					$res_pve = mysql_query($sql_pve,$conexion);
	//					$total_pie_vendedor		=	@mysql_result($res_pve,0,"total_pie_vendedor");
	//					
		
		//busca la sumatoria del sobrante cliente
		$sql_scli = "select sum(scli_monto) as total_sob_cliente from sgyonley.sobrante_cliente
					where 
					co_codigo in ( select co_codigo from sgyonley.cobrador where co_rut = '".$trabajador."' ) and
					scli_fecha  between '".$OBLItxtFecha1_1."' and '".$OBLItxtFecha2_1."'  and
					sect_cod = '".$j."' and empe_rut = '78748930' and empe_rut in ( select co_empresa from sgyonley.cobrador where co_rut = '".$trabajador."' )";
					
		$res_scli = mysql_query($sql_scli,$conexion);
		$total_sob_cliente		=	@mysql_result($res_scli,0,"total_sob_cliente");
		
		//busca la sumatoria del sobrante ocupado
		$sql_socu = "select sum(a.scas_monto) as total_sob_ocupado from 
					sgyonley.sobrante_cliente_asignacion a, sgyonley.sobrante_cliente b
					where 
					(
					b.co_codigo 	in ( select co_codigo from sgyonley.cobrador where co_rut = '".$trabajador."' )  and
					a.co_codigo 	in ( select co_codigo from sgyonley.cobrador where co_rut = '".$trabajador."' )  and
					b.scli_ncorr 	= 	a.scli_ncorr and
					a.scas_fechacob between '".$OBLItxtFecha1_1."' and '".$OBLItxtFecha2_1."'  and
					b.sect_cod = '".$j."' and b.empe_rut = '78748930' and b.empe_rut in ( select co_empresa from sgyonley.cobrador where co_rut = '".$trabajador."' )
					)
					or (
					b.co_codigo 	in ( select co_codigo from sgyonley.cobrador where co_rut = '".$trabajador."' ) and
					a.co_codigo 	= 	'' and
					b.scli_ncorr 	= 	a.scli_ncorr and
					a.scas_fechacob  between '".$OBLItxtFecha1_1."' and '".$OBLItxtFecha2_1."'  and
					b.sect_cod = '".$j."' and b.empe_rut = '78748930' and b.empe_rut in ( select co_empresa from sgyonley.cobrador where co_rut = '".$trabajador."' )
					)";
					
		$res_socu = mysql_query($sql_socu,$conexion);
		$total_sob_ocupado		=	@mysql_result($res_socu,0,"total_sob_ocupado");
			
		//busca la sumatoria del sobrante ocupado
		$sql_socu = "select sum(a.scas_monto) as total_sob_ocupado from 
					sgyonley.sobrante_cliente_asignacion a, sgyonley.sobrante_cliente b
					where 
					a.co_codigo 	in ( select co_codigo from sgyonley.cobrador where co_rut = '".$trabajador."' ) and
					b.co_codigo 	in ( select co_codigo from sgyonley.cobrador where co_rut = '".$trabajador."' ) and
					b.scli_ncorr 	= 	a.scli_ncorr and
					a.scas_fechacob  between '".$OBLItxtFecha1_1."' and '".$OBLItxtFecha2_1."' and
					b.sect_cod = '".$j."' and b.empe_rut = '78748930' and b.empe_rut in ( select co_empresa from sgyonley.cobrador where co_rut = '".$trabajador."' ) ";
					
		$res_socu = mysql_query($sql_socu,$conexion);
		$total_sob_ocupado		+=	@mysql_result($res_socu,0,"total_sob_ocupado");
		
		$resultado = $total_cobranza - $total_cobranza_1 - $total_deposito - $total_pie_vendedor + $total_sob_cliente - $total_sob_ocupado;	
		//$objResponse->addAlert("sector : $j -> $total_cobranza - $total_cobranza_1 - $total_deposito - $total_pie_vendedor + $total_sob_cliente - $total_sob_ocupado;	");
		$resultado_sup = 0;	
		if (strlen($sp_codigo)>0 && ($sp_codigo != '99')){
			$total_cobranza_sup = $total_cobranza ;
			$total_cobranza_1_sup = $total_cobranza_1;
			$resultado_sup = $resultado;
			$resultado = 0;
			//$objResponse->addAlert("super -> sector $j $total_cobranza_sup - $total_cobranza_1_sup - $total_deposito - $total_pie_vendedor + $total_sob_cliente - $total_sob_ocupado;");
			}
		else{
			$resultado_sup = 0;
			}
	
		$sobrante = 0;
		$faltante = 0;
		
		$sobrante_sup = 0;
		$faltante_sup = 0;
		
		if ($resultado > 0){$faltante = $resultado;}
		if ($resultado < 0){$sobrante = $resultado; $sobrante = $sobrante * -1;}
		
		$total_sobrante = $total_sobrante + $sobrante;
		$total_faltante = $total_faltante + $faltante;
		
		if ($resultado_sup > 0){$faltante_sup = $resultado_sup;}
		if ($resultado_sup < 0){$sobrante_sup = $resultado_sup; $sobrante_sup = $sobrante_sup * -1;}
		
		$total_sobrante_sup = $total_sobrante_sup + $sobrante_sup;
		$total_faltante_sup = $total_faltante_sup + $faltante_sup;
		}

		
		$resultado_total 	= 	$total_sobrante - $total_faltante;
		$texto_total		=	"Total Sobrante/Faltante Cobrador";	
		
		$resultado_total_sup 	= 	$total_sobrante_sup - $total_faltante_sup;
		$texto_total_sup		=	"Total Sobrante/Faltante  Supervisor";	
		
	$total = $total + $resultado_total;
	$total = $total + $resultado_total_sup;
		
		
		
	
	//busca la sumatoria del pie vendedor
		$sql_pve = "select COALESCE(sum(pven_monto),0) as total_pie_vendedor from sgyonley.pie_vendedor
					where 
					(
					co_codigo in ( select co_codigo from sgyonley.cobrador where co_rut = '".$trabajador."' ) and
					pven_fecha  between '".$OBLItxtFecha1_1."' and '".$OBLItxtFecha2_1."'  and 
					empe_rut in ( select CO_EMPRESA from sgyonley.cobrador where  co_rut = '".$trabajador."' )
					)
					or
					(
					co_codigo in ( select co_codigo from sgyonley.cobrador where co_rut = '".$trabajador."' )and
					pven_fecha  between '".$OBLItxtFecha1_1."' and '".$OBLItxtFecha2_1."' and 
					empe_rut in ( select co_empresa from sgyonley.cobrador where co_codigo in ( select co_codigo from sgyonley.cobrador where co_rut = '".$trabajador."' ))
					)";
						
		$res_pve = mysql_query($sql_pve,$conexion);
		$total_pie_vendedor		=	@mysql_result($res_pve,0,"total_pie_vendedor");

	$objResponse->addAssign("texto_pie_vendedor", "innerHTML", 'Total Pie Vendedor');
	$objResponse->addAssign("total_pie_vendedor", "innerHTML", $total_pie_vendedor);
	
	$total = $total + $total_pie_vendedor;
	
	$objResponse->addAssign("anticipo", "innerHTML", $monto_anticipo);
	$objResponse->addAssign("trabajador", "innerHTML", $nombre_trabajador);
	
	$objResponse->addAssign("total_cob_sup", "innerHTML", $resultado_total_sup);
	$objResponse->addAssign("total_cob_co", "innerHTML", $resultado_total);
	$objResponse->addAssign("texto_1", "innerHTML", $texto_total_sup);
	$objResponse->addAssign("texto_2", "innerHTML", $texto_total);
	//ayuda economica
	$sql_pve = "select COALESCE(sum(monto),0) as total_pie_vendedor from sgvales.ayudas_economicas
				where 
				trabajador_beneficiario = '".$trabajador."'  and
				fecha between '".$OBLItxtFecha1."' and '".$OBLItxtFecha2."' ";
					
	$res_pve = mysql_query($sql_pve,$conexion);
	$total_pie_vendedor		=	@mysql_result($res_pve,0,"total_pie_vendedor");

	$total = $total + $total_pie_vendedor;

	$objResponse->addAssign("texto_ae", "innerHTML", 'Total Ayuda Economica Beneficiario');
	$objResponse->addAssign("total_ae", "innerHTML", $total_pie_vendedor);
	
	//ayuda economica
	$sql_pve = "select COALESCE(sum(monto),0) as total_pie_vendedor from sgvales.ayudas_economicas
				where 
				trabajador_aportador	 = '".$trabajador."'  and
				fecha between '".$OBLItxtFecha1."' and '".$OBLItxtFecha2."' ";
					
	$res_pve = mysql_query($sql_pve,$conexion);
	$total_pie_vendedor		=	@mysql_result($res_pve,0,"total_pie_vendedor");

	$total = $total - $total_pie_vendedor;

	$objResponse->addAssign("texto_ae_1", "innerHTML", 'Total Ayuda Economica Aportador');
	$objResponse->addAssign("total_ae_1", "innerHTML", $total_pie_vendedor*(-1));
	
	//ayuda economica
	$sql_pve = "select COALESCE(sum(monto),0) as total_pie_vendedor from sgvales.vales_pie_vendedor
				where 
				trabajador	 = '".$trabajador."'  and
				fecha between '".$OBLItxtFecha1."' and '".$OBLItxtFecha2."' and
				estado = 'AUTORIZADO-FECHA'";
					
	$res_pve = mysql_query($sql_pve,$conexion);
	$total_pie_vendedor		=	@mysql_result($res_pve,0,"total_pie_vendedor");

	$total = $total + $total_pie_vendedor;

	$objResponse->addAssign("texto_vpv", "innerHTML", 'Total Vales Pie Vendedor');
	$objResponse->addAssign("total_vpv", "innerHTML", $total_pie_vendedor);
	
	//control vendedor
	$sql_pve = "select COALESCE(sum(monto),0) as total_pie_vendedor from sgvales.control_vendedor
				where 
				trabajador = '".$trabajador."'  and
				fecha between '".$OBLItxtFecha1."' and '".$OBLItxtFecha2."' ";
					
	$res_pve = mysql_query($sql_pve,$conexion);
	$total_pie_vendedor		=	@mysql_result($res_pve,0,"total_pie_vendedor");

	$total = $total + $total_pie_vendedor;

	$objResponse->addAssign("texto_cv", "innerHTML", 'Total Control Vendedor');
	$objResponse->addAssign("total_cv", "innerHTML", $total_pie_vendedor);
	
	//vales celular
		$sql_pve = "select COALESCE(sum(monto),0) as total_pie_vendedor from sgvales.vales_celular
					where 
					trabajador = '".$trabajador."'  and
					fecha between '".$OBLItxtFecha1."' and '".$OBLItxtFecha2."' ";
						
		$res_pve = mysql_query($sql_pve,$conexion);
		$total_pie_vendedor		=	@mysql_result($res_pve,0,"total_pie_vendedor");

	$total = $total + $total_pie_vendedor;

	$objResponse->addAssign("texto_vc", "innerHTML", 'Total Vales Celular');
	$objResponse->addAssign("total_vc", "innerHTML", $total_pie_vendedor);
	
	//mutual
		$sql_pve = "select COALESCE(sum(monto),0) as total_pie_vendedor from sgvales.mutual
					where 
					trabajador = '".$trabajador."'  and
					fecha between '".$OBLItxtFecha1."' and '".$OBLItxtFecha2."' ";
						
		$res_pve = mysql_query($sql_pve,$conexion);
		$total_pie_vendedor		=	@mysql_result($res_pve,0,"total_pie_vendedor");

	$total = $total + $total_pie_vendedor;

	$objResponse->addAssign("texto_m", "innerHTML", 'Total Mutual');
	$objResponse->addAssign("total_m", "innerHTML", $total_pie_vendedor);
	
	//seguro vida
		$sql_pve = "select COALESCE(sum(monto),0) as total_pie_vendedor from sgvales.seguro_vida
					where 
					trabajador = '".$trabajador."'  and
					fecha between '".$OBLItxtFecha1."' and '".$OBLItxtFecha2."' ";
						
		$res_pve = mysql_query($sql_pve,$conexion);
		$total_pie_vendedor		=	@mysql_result($res_pve,0,"total_pie_vendedor");

	$total = $total + $total_pie_vendedor;

	$objResponse->addAssign("texto_sv", "innerHTML", 'Total Seguro Vida');
	$objResponse->addAssign("total_sv", "innerHTML", $total_pie_vendedor);
	
	//otros
		$sql_pve = "select COALESCE(sum(monto),0) as total_pie_vendedor from sgvales.otros_descuentos
					where 
					trabajador = '".$trabajador."'  and
					fecha between '".$OBLItxtFecha1."' and '".$OBLItxtFecha2."' ";
						
		$res_pve = mysql_query($sql_pve,$conexion);
		$total_pie_vendedor		=	@mysql_result($res_pve,0,"total_pie_vendedor");

	$total = $total + $total_pie_vendedor;

	$objResponse->addAssign("texto_o", "innerHTML", 'Total Otros Descuentos');
	$objResponse->addAssign("total_o", "innerHTML", $total_pie_vendedor);
	
	//cuentas personales
		$sql_pve = "select COALESCE(sum(ccu_monto_pago),0) as total_pie_vendedor 
						from  yonleycp.cuentas_cuotas
							inner join yonleycp.cuentas
								on 	yonleycp.cuentas_cuotas.cue_ncorr = yonleycp.cuentas.cue_ncorr
					where 
					tra_ncorr in ( select tra_ncorr from yonleycp.trabajadores where tra_rut = '".$trabajador."' )  and
					ccu_fecha_pago between '".$OBLItxtFecha1."' and '".$OBLItxtFecha2."' and
					cue_tipo_trans in ('1','0') ";
						
		$res_pve = mysql_query($sql_pve,$conexion) or die(mysql_error());
		$total_pie_vendedor		=	@mysql_result($res_pve,0,"total_pie_vendedor");
		
	$total = $total + $total_pie_vendedor;

	$objResponse->addAssign("texto_cp", "innerHTML", 'Total Cuentas Personales');
	$objResponse->addAssign("total_cp", "innerHTML", $total_pie_vendedor);
	
	//Folios por Trabajador
		$sql_pve = "select COALESCE(sum(ftrab_monto),0) as total_pie_vendedor 
						from  sgyonley.folio_trabajador
					where 
					rut_trab = '".$trabajador."'  and
					ftrab_fecha	 between '".$OBLItxtFecha1."' and '".$OBLItxtFecha2."' ";
						
		$res_pve = mysql_query($sql_pve,$conexion) or die(mysql_error());
		$total_pie_vendedor		=	@mysql_result($res_pve,0,"total_pie_vendedor");
		
	$total = $total + $total_pie_vendedor;

	$objResponse->addAssign("texto_ft", "innerHTML", 'Total Folios Trabajador');
	$objResponse->addAssign("total_ft", "innerHTML", $total_pie_vendedor);
	
	//cuentas personales
		$sql_pve = "select COALESCE(sum(ccu_monto_pago),0) as total_pie_vendedor 
						from  yonleycp.cuentas_cuotas
							inner join yonleycp.cuentas
								on 	yonleycp.cuentas_cuotas.cue_ncorr = yonleycp.cuentas.cue_ncorr
					where 
					tra_ncorr in ( select tra_ncorr from yonleycp.trabajadores where tra_rut = '".$trabajador."' )  and
					ccu_fecha_pago between '".$OBLItxtFecha1."' and '".$OBLItxtFecha2."' and
					tpro_ncorr	= '1' ";
						
		$res_pve = mysql_query($sql_pve,$conexion) or die(mysql_error());
		$total_pie_vendedor		=	@mysql_result($res_pve,0,"total_pie_vendedor");
		
	$total = $total + $total_pie_vendedor;

	$objResponse->addAssign("texto_pc", "innerHTML", 'Total Prestamos Caja');
	$objResponse->addAssign("total_pc", "innerHTML", $total_pie_vendedor);
	
	$objResponse->addAssign("texto_total", "innerHTML", 'Total');
	$objResponse->addAssign("total_total", "innerHTML", $total);
	
	
	$objResponse->addScript("document.getElementById('divlistado').style.display='block';");
		
	return $objResponse->getXML();
}
function Ordenar($data, $campo){
	global $conexion;
	global $miSmarty;
	
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	$orden_asc 	= 'ASC';
	$orden_desc = 'DESC';
	if ($_SESSION["alycar_orden"] == $campo.$orden_asc){
		$campo_orden 		= 	$campo.$orden_desc;
		$direccion_orden	=	$orden_desc;
	}else{
		$campo_orden 		= 	$campo.$orden_asc;
		$direccion_orden	=	$orden_asc;
	}		
	
	$arrRegistros = array();
	$arrRegistros = ordenar_matriz_multidimensionada($_SESSION["alycar_matriz"],$campo,$direccion_orden);
	$_SESSION["alycar_orden"] = $campo_orden;
	
	$miSmarty->assign('arrRegistros', $arrRegistros);
	$objResponse->addAssign("divabonos", "innerHTML", $miSmarty->fetch('sg_informe_anticipos_trabajador_list.tpl'));
	
	
	return $objResponse->getXML();
}

function MuestraRegistro($data, $campo1, $campo2, $obj1, $obj2){
	global $conexion;
	
        $objResponse = new xajaxResponse('ISO-8859-1');
	
        $objResponse->addAssign("$obj1", "value", $campo1);
	$objResponse->addAssign("$obj2", "value", $campo2);
	$objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'cboFamilia','sgbodega.familias','','Todas','fa_codigo', 'fa_nombre', '')");
	//$objResponse->addScript("xajax_CargaSubFamilias(xajax.getFormValues('Form1'))");
        return $objResponse->getXML();
}

function CargaDesc($data, $tabla, $campo1, $campo2, $objeto1, $objeto2, $c_and){
    global $conexion;
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	//mysql_select_db("sgyonley", $conexion);
	
	$ncorr 		= 	$data["$objeto1"];
	
	if (($tabla == 'sgbodega.tallas') OR ($tabla == 'sgbodega.tallasnew')){
		$sql = "select ta_ncorr, ta_descripcion, ta_busqueda, ta_venta from sgbodega.tallasnew where $campo1 = '".$ncorr."'";
		$res = mysql_query($sql, $conexion);
		
		$objResponse->addAssign("OBLItxtDescProducto", "value", @mysql_result($res,0,"ta_busqueda")." ".@mysql_result($res,0,"ta_descripcion"));
                $objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'cboFamilia','sgbodega.familias','','Todas','fa_codigo', 'fa_nombre', '')");
	
		//$objResponse->addScript("xajax_CalculaTotalesLinea(xajax.getFormValues('Form1'))");
	
	}else{
		
		$sql = "select $campo2 as descripcion from $tabla where $campo1 = '".$ncorr."' $and";
		$res = mysql_query($sql, $conexion);
		$objResponse->addAssign("$objeto2", "value", @mysql_result($res,0,"descripcion"));
	}	
	
	return $objResponse->getXML();
}
function CargaSelect($data, $select, $tabla, $codigo, $descripcion, $campo1, $campo2, $opt){
    global $conexion;
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	$objResponse->addAssign("$select","innerHTML",""); 		
	$sql = "select $campo1 as codigo, $campo2 as descripcion from ".$tabla;
	$res = mysql_query($sql, $conexion);
	if (mysql_num_rows($res) > 0) {
            $objResponse->addCreate("$select","option",""); 		
            $objResponse->addAssign("$select","options[0].value", $codigo);
            $objResponse->addAssign("$select","options[0].text", $descripcion); 	
            $j = 1;
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
	
	//carga familias
	$objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'cboFamilia','sgbodega.familias','','Todos','fa_codigo', 'fa_nombre', '')");
	$objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'cboTipo','tipo_anticipos','','Todos','ta_ncorr','nombre', '')");
	//$objResponse->addScript("document.getElementById('OBLIcboEmpresa').focus();");

	return $objResponse->getXML();
}          

function Imprime(){
    global $conexion;
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	$objResponse->addScript("ImprimeDiv('divabonos');");
	
	return $objResponse->getXML();
}

$xajax->registerFunction("MuestraRegistro");
$xajax->registerFunction("Grabar");
$xajax->registerFunction("Ordenar");
$xajax->registerFunction("CargaPagina");
$xajax->registerFunction("CargaDesc");
$xajax->registerFunction("CargaSelect");
$xajax->registerFunction("Imprime");

$xajax->processRequests();
$miSmarty->assign('xajax_js', $xajax->getJavascript());

$miSmarty->display('sg_informe_resumen.tpl');

?>
<!---- phpMyAdmin SQL Dump
-- version 3.3.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Nov 08, 2013 at 03:48 PM
-- Server version: 5.1.54
-- PHP Version: 5.3.5-1ubuntu7.4

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Database: `sgbodega`
--

-- --------------------------------------------------------

--
-- Table structure for table `proveedor`
--

CREATE TABLE IF NOT EXISTS `proveedor` (
  `PR_NCORR` int(11) NOT NULL AUTO_INCREMENT,
  `PR_RUT` double(8,0) DEFAULT NULL COMMENT 'Rut',
  `PR_DIGITO` varchar(1) DEFAULT NULL COMMENT 'Digito',
  `PR_RAZON` varchar(100) DEFAULT NULL COMMENT 'Razon Social',
  `PR_GIRO` varchar(100) DEFAULT NULL COMMENT 'Giro',
  `PR_DIRECCION` varchar(100) DEFAULT NULL COMMENT 'Direccion',
  `PR_CIUDAD` varchar(20) DEFAULT NULL COMMENT 'Ciudad',
  `PR_FONO1` varchar(20) DEFAULT NULL COMMENT 'Fono 1',
  `PR_FONO2` varchar(20) DEFAULT NULL COMMENT 'Fono 2',
  `PR_FAX` varchar(20) DEFAULT NULL COMMENT 'Fax',
  `PR_ATENCION` longtext COMMENT 'Nombre de Contacto',
  `PR_INDEX` double DEFAULT NULL COMMENT 'Index',
  `PR_MAIL` varchar(100) DEFAULT NULL COMMENT 'Email',
  PRIMARY KEY (`PR_NCORR`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=311 ;

--
-- Dumping data for table `proveedor`
--

INSERT INTO `proveedor` (`PR_NCORR`, `PR_RUT`, `PR_DIGITO`, `PR_RAZON`, `PR_GIRO`, `PR_DIRECCION`, `PR_CIUDAD`, `PR_FONO1`, `PR_FONO2`, `PR_FAX`, `PR_ATENCION`, `PR_INDEX`, `PR_MAIL`) VALUES
(0, 1, '9', 'SIN PROVEEDOR', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(1, 84420400, '0', 'JOSE LORCA ALVAREZ Y CIA. LTDA.', 'REPUESTOS VEHICULOS MOTORIZADOS', 'ARLEGUI 758 - 764', 'VIÑA DEL MAR', '882684', '680788', '884920', '0', 1, '0'),
(2, 85896100, '9', 'DICOM S.A.', 'SERVICIOS DE INFORMACION', '', 'VALPARAISO', '218383', '686825', '0', '', 2, NULL),
(3, 80192600, '2', 'TEXTIL CHAFIK NALLAR E HIJOS LTDA.', 'FABRICA DE PLASTICOS', 'LORETO 575   RECOLETA', 'SANTIAGO', '7371299', '7374792', '7375791', '', 3, NULL),
(4, 88937800, 'K', 'K', 'REPUESTOS DE VEHICULO', 'CHACABUCO 2306', 'VALPARAISO', '256724', '211905', '211905', '123', 4, 'a'),
(5, 92139000, '9', 'SINDELEN S.A.', 'ELECTRODOMESTICOS', 'AV.VICUNA MACKENNA 9840   LA FLORIDA', 'SANTIAGO', '2811001', '2819240', '2820447', 'FERNANDO NAGATTA', 5, '123'),
(6, 80388800, '0', 'ANTONIO GARCIA Y CIA. LTDA.', 'MENAJE Y ROPA BLANCA', 'INDEPENDENCIA 2308', 'VALPARAISO', '256950', '0', '0', 'SRA. LAURA   LA ROSA CHILENA', 6, NULL),
(7, 93149000, '1', 'TEXTIL CASSIS S.A.', 'TEJIDOS DE PUNTO Y TELAS PLANAS', 'J.P. ALESSANDRI 1880', 'SANTIAGO', '2380571', '2380679', '2380563', '', 7, NULL),
(8, 50159080, '0', 'INDUSTRIAS CELTA LTDA.', 'COLCHONES', 'LARRONDO Nº180 ', 'COQUIMBO', '311693', '0', '312385', 'EDGARDO GUZMAN  09 4337568  CELTA', 8, ''),
(9, 89200200, '2', 'CONFECCIONES SAO PAULO S.A.', 'FABRICA DE CONFECCIONES', 'ESMERALDA 6876-A', 'SANTIAGO', '5251846', '5252455', '5261013', 'PAMELA   09 2387995  - VANKS', 9, NULL),
(10, 81756100, '4', 'HENRY ANANIAS CIA. LTDA.', 'CONFECCIONES', 'PATRONATO 169', 'SANTIAGO', '7352993', '0', '0', '', 10, NULL),
(11, 80909400, '6', 'RADIO CENTER LTDA.', 'VENTA DE CALZADO', '', 'SANTIAGO', '5525873', '0', '2333737', 'LAURA BERNALES', 11, NULL),
(12, 96811370, '4', 'LOTTO CHILE S.A.', 'ARTICULOS DEPORTIVOS', 'AV. LAS CONDES 10440', 'SANTIAGO', '3659303', '0', '3659302', 'MIGUEL RIVERA  09 4355236', 12, NULL),
(13, 85413400, '0', 'MASHINI Y CIA. LTDA.', 'VENTA DE TOALLAS', 'SAN ANTONIO 597', 'SANTIAGO', '2379797', '0', '0', '', 13, NULL),
(14, 89089500, 'K', 'DOLZ CHILE Y TORRES LTDA.', 'FABRICA TEXTIL', 'AV.SEXTA 0354', 'VILLA ALEMANA', '953060', '503060', '953061', 'JUAN HURBINA', 14, NULL),
(15, 86718800, '2', 'TRANSPORTES ESPINOZA HNOS.LTDA.', 'TRANSPORTE DE CARGA', 'MORRIS 421', 'VALPARAISO', '234055', '223055', '223055', '', 15, NULL),
(16, 78025820, '9', 'LO VASQUEZ LTDA.', 'FABRICA DE MUEBLES', '', 'VALPARAISO', '212893', '0', '0', 'SRA. LAURA', 16, NULL),
(17, 78209360, '6', 'CARONI Y TORRES LTDA.', 'FABRICA UTILES COCINA ALUMINIO', '', 'LIMACHE', '411270', '0', '411258', '', 17, NULL),
(18, 79900660, 'K', 'IMPORTADORA CHIN CHIL LTDA.', 'IMPORTADORA', 'PATRONATO 378', 'SANTIAGO', '7778555', '0', '0', '', 18, NULL),
(19, 78377830, '0', 'ENRIQUE JADUE Y CIA. LTDA.', 'PAQUETERIA', 'ROSAS 1156', 'SANTIAGO', '6966878', '0', '0', '', 19, NULL),
(20, 77031030, 'K', 'VIVACOL LTDA.', 'FABRICA DE ACOLCHADOS', 'LORETO 435   RECOLETA', 'SANTIAGO', '7355677', '7355845', '7355677', '', 20, NULL),
(21, 9871487, '1', 'MILO EDGARDO GUTIERREZ SANDOVAL', 'LUBRICANTES - REPUESTOS', '', 'BELLOTO', '0', '0', '0', 'LUBRICENTRO EL PINO', 21, NULL),
(22, 10748167, '2', 'LUIS  HUMBERTO ESPINOZA ACEVEDO', 'TRANSPORTE DE CARGA', 'CENTRAL 81 PLACILLA', 'VALPARAISO', '291156', '214903', '292686', 'FLET SER', 22, NULL),
(23, 93640000, '0', 'AUTOPLAST', '', '', 'SANTIAGO', '6712832', '3962997', '6953196', '', 23, NULL),
(24, 80053100, '4', 'ARAYA E HIJO LTDA.', 'MENAJE Y ARTICULOS PARA EL HOGAR', 'AGUA SANTA 139', '', '663822', '662900', '668619', '', 24, NULL),
(25, 9403000, '5', 'PARKAS SEN', 'VENTA PRENDAS DE VESTIR', 'FILOMENA 340', 'SANTIAGO', '7320270', '7375922', '7378318', '', 25, NULL),
(26, 14434901, '6', 'KWAN HO BANG', 'CONFECCION E IMPORTACION', 'PATRONATO 407-409', 'SANTIAGO', '7770599', '7379783', '0', '', 26, NULL),
(27, 6360973, '0', 'CREACIONES MUCKI', 'CONFECCIONES PARA DAMAS', 'PATRONATO 235', 'SANTIAGO', '4429454', '7772569', '0', '', 27, NULL),
(28, 78420410, '3', 'CONFECCIONES FIMAR LTDA.', 'CONFECCION TEXTIL', '', '', '862245', '0', '862245', '', 28, NULL),
(29, 96728840, '3', 'PROMUVAL S.A.', 'FABRICA DE MUEBLES', 'PEDRO MONTT 2338', 'VALPARAISO', '596449', '0', '0', '', 29, NULL),
(30, 84271000, '6', 'ISAAC BORIZON E HIJOS LTDA.', 'ARTICULOS DE PAQUETERIA', 'ROSAS 1202', 'SANTIAGO', '6885787', '0', '6984225', '', 30, NULL),
(31, 5076224, '6', 'COHACHE', 'VENTA DE ROPA', 'PATRONATO 354       RECOLETA', 'SANTIAGO', '7372202', '7378957', '0', '', 31, NULL),
(32, 85644700, '6', 'INVERSIERRA S.A.', 'COMERCIALIZACION DE MENAJES', 'PEDRO FONTOVA 6350', 'SANTIAGO', '6246788', '0', '6246771', '', 32, NULL),
(33, 4038663, '7', 'ROLANDO EMILIO ESPINOZA MARTINO', 'ARTICULOS DE ESCRITORIO', 'VICTORIA 2632 LOCAL 1', 'VALPARAISO', '211155', '0', '0', 'LIBRERIA MARTINO', 33, NULL),
(34, 5018674, '1', 'PATRICIO VASQUEZ VALDERRAMA', 'FABRICA DE ALUMINIO', 'SANTA ESTELA 124', 'VALPARAISO', '245763', '0', '243066', 'INDUSTRIA KROMO', 34, NULL),
(35, 84851800, 'K', 'MENESES Y DIAZ LTDA.', 'SERVICIO Y REPUESTOS VEHICULOS', 'CHACABUCO 2080', 'VALPARAISO', '250152', '0', '234183', '', 35, NULL),
(36, 83005400, '6', 'JUAN DIUNA E HIJOS LTDA.', 'FABRICA DE CIERRES', 'JOSE ANANIAS 561      MACUL', 'SANTIAGO', '2384143', '612367', '2385202', 'LYNSA VIRGINIA SAAVEDRA 09 3464571', 36, NULL),
(37, 82511000, '3', 'SAIEG Y CIA.LTDA.', '', 'TIL TIL 2467       MACUL', 'SANTIAGO', '2383159', '2381863', '0', '', 37, NULL),
(38, 81840000, '4', 'EL AGUILA LTDA.', 'FABRICA DE ROPA', 'GAMERO 2085', 'SANTIAGO', '7377208', '7774500', '0', '', 38, NULL),
(39, 91727000, '7', 'MARMICOC CHILENA S.A.', 'FABRICA DE OLLAS DE PRESION', 'SAN FRANCISCO 2020', 'SANTIAGO', '5552921', '5566421', '5566421', '', 39, NULL),
(40, 86847300, '2', 'CASA XIMENA', '', 'AV.PEDRO MONTT 2004', 'VALPARAISO', '266819', '266820', '0', 'LINEA BLANCA-ELECTRODOMESTICOS', 40, NULL),
(41, 80478200, '1', 'ILOP S.A.', 'LIBRERIA LAPIZ LOPEZ', 'CONDELL 1541', 'VALPARAISO', '255700', '0', '0', '', 41, NULL),
(42, 87745700, '1', 'ANICEL MANCILLA Y OTROS LTDA.', 'TRANSPORTE DE CARGA POR CARRETERA', 'PSJE. SAN LUIS 1040', '', '683657', '0', '682509', '', 42, NULL),
(43, 85891400, '0', 'IMPORTADORA IMOTO LTDA.', 'VENTA MOTOCICLETAS NUEVAS Y USADAS', 'LIRA 669', 'SANTIAGO', '2227001', '2222295', '6359116', '', 43, NULL),
(44, 7748968, '1', 'ALICE CHAIN HODALI', 'CONFECCIONES Y VENTAS DE TELAS', 'INDEPENDENCIA 384 -388', 'SANTIAGO', '7357879', '0', '7352839', '', 44, NULL),
(45, 80019100, '9', 'SALVADOR ALAMO E HIJOS LTDA.', 'FABRICA DE CONFECCIONES', 'SANTA FILOMENA 424', 'SANTIAGO', '7770551', '7353109', '7770551', 'LA ORIENTAL', 45, NULL),
(46, 80314700, '0', 'EMPRESA DE TRANSPORTES RURALES LTDA.', 'TRANSPORTE DE CARGA', 'DOLORES 800', 'SANTIAGO', '2707500', '2707300', '0', 'TUR BUS', 46, NULL),
(47, 84426200, '0', 'INDUSTRIA TEXTIL SUPREMA LTDA.', 'FABRICA DE LANAS, FIBRAS Y ALGODONES', 'EXEQUIEL FERNANDEZ 2321', 'SANTIAGO', '2384707', '2384687', '2384687', 'SUPREMATEX', 47, NULL),
(48, 53020120, '1', 'SUC. MANUEL HIRNHEIMER EPSTEIN', 'LAVAPLATOS, CERAMICA.', 'INDEPENDENCIA 2433', 'VALPARAISO', '213709', '0', '213709', 'SANITARIOS EUROPEA', 48, NULL),
(49, 79897500, '5', 'CARTONAJES GRAU LTDA.', 'FABRICA DE CAJAS Y CARTONES', 'J. FCO. RIVAS 9435   LA CISTERNA', 'SANTIAGO', '5581159', '0', '0', '', 49, NULL),
(50, 89597000, 'K', 'IMACAL LTDA.', 'INDUSTRIA DE CALZADO', '', 'SANTIAGO', '5521278', '0', '0', '', 50, NULL),
(51, 93441000, '9', 'DUCASSE COMERCIAL LTDA.', 'COM.RODAMIENTOS', 'CHACABUCO 1936 LOC.5-6', 'VALPARAISO', '257891', '0', '257891', '', 51, NULL),
(52, 84922000, '4', 'TAUFIG HALES Y CIA. LTDA.', 'VENTA DE TEXTILES EN GENERAL', 'VICTORIA 2398', 'VALPARAISO', '255217', '214225', '214225', '', 52, NULL),
(53, 96755630, '0', 'ALINSA S.A.', 'VENTA DE ZAPATILLAS', 'CAMINO A MELIPILLA 9070    MAIPU', 'SANTIAGO', '5388343', '5388344', '5388343', '', 53, NULL),
(54, 8853454, '9', 'JAZMIN ELIZABETH KAISER CONTRERAS', 'VENTA DE FILTROS Y LUBRICANTES', 'AV.COLON 2878', 'VALPARAISO', '218048', '0', '0', '', 54, NULL),
(55, 78464040, 'K', 'SOCIEDAD MENDEZ & MENDEZ LTDA.', 'DISTRIBUIDORA DE CALZADOS', 'PLACER 911 LOC. 353', 'SANTIAGO', '5541643', '5513325', '5541544', '', 55, NULL),
(56, 1892570, '2', 'ROMULO FERNANDO SORUCO EWER', 'ART.DE GOMA Y ACCESORIOS PARA VEHICULOS', 'CARRERA 398', 'VALPARAISO', '213112', '0', '213112', '', 56, NULL),
(57, 5107007, '0', 'AQUILES CARDOZA MENDOZA', 'FABRICA DE TEJIDOS', 'ESMERALDA 260 VALLE HERMOSO', 'LA LIGUA', '712816', '0', '0', '', 57, NULL),
(58, 79724330, '2', 'COMERCIAL E IND. TRAMAHUEL LTDA.', 'FAB.Y VENTA DE ART. PARA EL HOGAR', 'LAS DELIAS 2773', 'SANTIAGO', '2380688', '0', '2380579', 'SR. URT PIANO', 58, NULL),
(59, 78905040, '6', 'COMERCIAL HERSOFT LTDA.', 'COM.DE EQUIPOS COMPUTACIONALES', '', 'CONCEPCION', '241170', '0', '241170', 'JOSE HEREDIA', 59, NULL),
(60, 78533100, '1', 'COMERCIAL CHIEN Y CIA. LTDA.', 'COMERCIALIZACION PRENDAS DE VESTIR', 'PATRONATO 498', 'SANTIAGO', '0', '0', '0', '', 60, NULL),
(61, 86963200, '7', 'FORUS S.A.', 'FABRICA DE CALZADO', 'AV. DEPARTAMENTAL 01053  LA FLORIDA', 'SANTIAGO', '2210422', '2216115', '2215895', 'HECTOR VASQUEZ', 61, NULL),
(62, 10969348, '0', 'JORGE EDUARDO PICHARA SHAHWAN', 'FABRICA PRODUCTOS PLASTICOS', 'SANTA FILOMENA 314 RECOLETA', 'SANTIAGO', '7775239', '0', '0', 'TODOPACK', 62, NULL),
(63, 78628950, '5', 'IMATEX LIMITADA', 'FABRICACION DE PRENDAS DE VESTIR', 'PINTO 1281 INDEPENDENCIA', 'SANTIAGO', '7356163', '0', '7379187', 'HECTOR VASQUEZ', 63, NULL),
(64, 78341130, 'K', 'TEXTIL HOGAR LTDA.', 'ELABORACION PRODUCTOS TEXTILES', 'AV.PRESIDENTE EDUARDO FREI M. 9315', 'SANTIAGO', '6233890', '0', '6233996', '', 64, NULL),
(65, 96619620, '3', 'SPORTING GOODS S.A.', 'ARTICULOS DEPORTIVOS', 'RECOLETA 418', 'SANTIAGO', '7320398', '0', '7379524', '', 65, NULL),
(66, 96530870, '9', 'CALZADOS KIM LTDA.', 'FABRICA DE CALZADOS', 'EULOGIO ALMIRANTE 7059', 'SANTIAGO', '5580403', '5273475', '5273157', '', 66, NULL),
(67, 77008690, '6', 'COM.OFF RANGE CHILE LTDA.', 'IMP.CALZADO Y PRENDAS DE VESTIR', 'AV.LAS CONDES 12256 OF.202 VITACURA', 'SANTIAGO', '2175362', '2459629', '2173431', 'MIGUEL RIVERA 09 4355236', 67, NULL),
(68, 91601000, '1', 'ENLOZADOS CONDOR S.A.', 'FAB.DE VAJILLERIA DE FIERRO ENLOZADO', 'SANTA ROSA 6583 SAN RAMON', 'SANTIAGO', '5251963', '0', '5252761', '', 68, NULL),
(69, 77273560, 'K', 'LA GUARDIA LTDA.', 'VENTA DE ARTICULOS PLASTICOS', 'CHACABUCO 7-A', 'SANTIAGO', '6817695', '0', '6817695', 'GUSTAVO DUPRE', 69, NULL),
(70, 92380000, 'K', 'ACSA S.A.', '', 'NUEVA DE MATTE #2549 INDEPENDENCIA', 'SANTIAGO', '7370553', '7379522', '7379522', '', 70, NULL),
(71, 3873038, 'K', 'EULOGIO VILLA CANDIA', 'FABRICA DE CALZADOS', 'GRAN AVENIDA 5764 SAN MIGUEL', 'SANTIAGO', '5215299', '0', '0', '', 71, NULL),
(72, 6359117, '3', 'CLAUDIO LEFEVER BILBAO', 'MENAJE', '12 NORTE 1165', '', '685764', '0', '0', '', 72, NULL),
(73, 87889300, 'K', 'ACO METAL', 'MENAJE', 'GAETE 424 RECREO', '', '775060', '0', '0', '', 73, NULL),
(74, 89524100, '8', 'COMERCIAL WINDSOR LIMITADA', 'COMERCIAL', 'GENERAL MACKENNA 1238 SANTIAGO CENTRO', 'SANTIAGO', '6967664', '6990228', '6970571', '', 74, NULL),
(75, 77472210, '6', 'COMERCIAL FENOMENAL LIMITADA', 'IMPORTACION Y COMPRAVENTA DE ROPA,', 'PROVIDENCIA 2435', 'SANTIAGO', '6811760', '0', '0', 'ZAPATO, JUGUETES Y BAZAR.', 75, NULL),
(76, 9254555, '5', 'BERNARDO ANTONIO FLORES MARIN', 'VENTA DE MATERIALES Y FABRICACION DE', 'GASPAR DE SOTO 539', 'SANTIAGO', '5530402', '0', '0', 'CALZADO.', 76, NULL),
(77, 79535340, '2', 'MALERBA Y CORREA LTDA.', 'FABRICA DE CALZADO.', 'CHILOE 1970. SANTIAGO.', 'SANTIAGO.', '5514763', '5545519', '5545519', '', 77, NULL),
(78, 80767700, '4', 'QUEZADA Y CIA. LTDA.', 'MENAJE', '', 'SANTIAGO', '2224545', '2220575', '0', '', 78, NULL),
(79, 96816740, '5', 'ITALY SPORT S.A.', 'VENTA DE ZAPATILLAS.', 'AV. AMERICA VESPUCIO SUR 652', 'SANTIAGO', '2074411', '0', '2075322', '', 79, NULL),
(80, 95271000, '1', 'DONORS S.A.', 'VENTA DE ZAPATILLAS', 'ROSAS 2451', 'SANTIAGO', '6726000', '0', '6973283', '', 80, NULL),
(81, 50143670, '4', 'MANUFACTURAS LOUIS PHILIPPE LTDA.', 'VENTA ZAPATILLAS', 'SANTOS DUMONT 560. RECOLETA.', 'SANTIAGO', '4214400', '0', '4214490', '', 81, NULL),
(82, 93358000, '8', 'INDUSTRIA LATINOAMERICANA DE METALURGIA', 'METALURGIAS', 'AVDA. PDTE. EDUARDO FREI 1499', 'SANTIAGO', '7772864', '7375045', '7351212', '', 82, NULL),
(83, 80404100, '1', 'MANUFACTURAS CANON S.A.', 'TEXTIL', 'CERRO SAN CRISTOBAL 9560', 'SANTIAGO', '7386041', '0', '7386042', '', 83, NULL),
(84, 77307200, '0', 'IMPORTADORA Y COMERCIALIZADORA FERO LTDA', 'ZAPATERIA', 'CALLE LIMACHE 3253', '', '857758', '0', '857758', '', 84, NULL),
(85, 96895700, '7', 'NEXT S.A', 'COMERCIALIZACION DE CALZADO', 'AVDA. APOQUINDO 3000', 'SANTIAGO', '3350500', '0', '3352070', '', 85, NULL),
(86, 6492299, '8', 'PIER GUZMAN VALLEJOS', 'PIER ANGELI', 'AV.1440 SAN MIGUEL', 'SANTIAGO', '3120146', '0', '0', '', 86, NULL),
(87, 77237060, '1', 'SOCIEDAD COMERCIAL DEEJAY LTDA', 'DISTRIBUICION DE ROPA', 'MAIPO 347 RECOLETA', 'SANTIAGO', '6215980', '0', '6215976', '', 87, NULL),
(88, 96612230, '7', 'CAIMI S.A.C.', 'OTROS', 'RUTA 68 S/N', 'CASABLANCA', '279600', '0', '279700', '', 88, NULL),
(89, 7014944, '3', 'AQUILES VELOSO CATALAN', 'VENTA DE ROPA Y MENAJE', 'MONTEVIDEO 531 OF. 202 RECOLETA', 'SANTIAGO', '0', '0', '0', '', 89, NULL),
(90, 80934500, '9', 'SOC. TEXTIL KATTAN HERMANOS', 'VENTA DE TELAS', 'AV. JOSE P. ALESSANDRI 1498', 'SANTIAGO', '2712000', '2712085', '2712000', '', 90, NULL),
(91, 96665360, '4', 'MAREGGI SOCIEDAD ANONIMA', 'VENTA DE TELAS', 'SANTA ELENA 2035', 'SANTIAGO', '5545336', '0', '5547101', '', 91, NULL),
(92, 11606641, '6', 'CARLOS CABRERA FAUNDES', 'FABRICA DE MUEBLES', 'AV.TOME 672 LA GRANJA', 'SANTIAGO', '5116540', '0', '0', '', 92, NULL),
(93, 92632000, '9', 'ELECTRON CHILENA S.A.', 'INDUSTRIA ELECTRO-METALURGICA', 'GASPAR DE ORENSE 859 QUINTA NORMAL', 'SANTIAGO', '7753114', '0', '7732002', '', 93, NULL),
(94, 77845170, '0', 'COMERCIAL U.SM. LTDA.', 'TIENDA Y PAQUETERIA', 'HOEVEL 5067. QUINTA NORMAL', 'SANTIAGO', '7728400', '0', '7728374', '', 94, NULL),
(95, 51049410, '5', 'ALUMINIOS ORBE', 'COMERCIANTE', 'HUNNEUS 300-C BARRIO OHIGGINS', 'VALPARAISO', '376595', '0', '0', '', 95, NULL),
(96, 81415800, '4', 'SANGIOVANNI ITALY', 'COMERCIO', 'DARDIGNAC 285', 'SANTIAGO', '7776580', '0', '7372898', '', 96, NULL),
(97, 77046440, '4', 'INDUSTRIAL SERENADE SERENATTA LTDA.', 'VENTA ROPA Y MENAJE', 'CORONAL ALVARADO 2497 INDEPENDENCIA .', 'SANTIAGO', '7774111', '0', '7358544', '', 97, NULL),
(98, 78166390, '5', 'INVERSIONES KARHU S.A.', 'DISTR. IMPORT. Y EXPOR. PRENDAS VESTIR.', '', 'SANTIAGO', '7385500', '0', '7385500', '', 98, NULL),
(99, 79646530, '1', 'EXPORT. IMPORT. MORANI LTDA.', 'EXPORTACION E IMPORTACION DE CALZADO', 'VICTOR MANUEL 1427', 'SANTIAGO', '5519697', '0', '5545807', '', 100, NULL),
(100, 77872140, '6', 'COMERCIAL SUMESA LTDA.', 'MENAJES', 'LONGITUDINAL SUR KM. 514', 'SANTIAGO', '7378756', '0', '2387995', '', 101, NULL),
(101, 96955720, '7', 'BIG BRANS CO S.A.', 'COMERCIALIZADORA DE CALZADOS', 'HELVECIA 240 OF. 1.LAS CONDES', 'SANTIAGO', '2323405', '0', '2323405', '', 102, NULL),
(102, 83744600, '7', 'GONZALEZ HNOS. Y CIA. LTDA.', 'COLCHONES, MUEBLES, ART. DE DECORACION', '', 'VALPARAISO', '291051', '291888', '291153', '', 103, NULL),
(103, 76110670, '8', 'SOCIEDAD COMERCIAL MAYORISTA LTDA.', 'DISTRIBUCION MENAJE DE HOGAR', '19 DE JUNIO 1480 FORSTAL BAJO', '', '675308', '0', '0', 'O', 104, NULL),
(104, 90718000, 'K', 'MANUFACTURAS SUMAR S.A.', 'INDUSTRIA TEXTIL', 'AVDA. CARLOS VALDOVINO 200 SAN JOAQUIN', 'SANTIAGO', '5525738', '0', '5522646', '', 105, NULL),
(105, 78057530, '1', 'CORP. MANUFACTURERA SAN JUAN S.A.', 'FABRICA DE CONFECCIONES DE ART. DE VESTI', 'JUAN ELIAS 1701 RECOLETA', 'SANTIAGO', '6756200', '0', '6756201', '', 106, NULL),
(106, 81031100, '2', 'LUIS VIELVA Y CIA. LIMITADA', 'FERRETERIA - IMPORTACIONES', 'SAN FRANCISCO 144', 'SANTIAGO', '3890000', '0', '6337795', '', 107, NULL),
(107, 77585610, '6', 'TREVISO SPORT LIMITADA', 'IMPORT., DISTRIBUCION, COMERCIALIZACION', 'ROSAS 2451 SANTIAGO CENTRO', 'SANTIAGO', '6726000', '0', '6973283', '', 108, NULL),
(108, 77895920, '8', 'CONFECCIONES S & T LIMITADA', 'CONFECCION DE PRENDAS DE VESTIR', 'PATRONATO 281 RECOLETA SANTIAGO', 'SANTIAGO', '7321852', '7778699', '0', '', 109, NULL),
(109, 78028420, 'K', 'FILPUCCI SOCIEDAD COMERCIAL LIMITADA', 'COMPRA Y VTA DE ART. TEXTILES', 'LOS TRES ANTONIOS 2799', 'SANTIAGO', '2393955', '2371800', '3190224', '', 110, NULL),
(110, 5883754, '7', 'MARGARITA EUGENIA ANANIAS ANANIAS', 'CONFECCIONES DE PRENDAS DE VESTIR', 'PATRONATO 341 RECOLETA', 'SANTIAGO', '7374957', '0', '0', '', 111, NULL),
(111, 77261820, '4', 'COMERCIAL RON DO TEX LIMITADA', 'FABRIC. Y COMERC. DE PRENDAS DE VESTIR', 'AVENIDA RECOLETA 223', 'SANTIAGO', '7373973', '0', '0', '', 112, NULL),
(112, 78464140, '6', 'COMERCIAL E IND. STROLLER LIMITADA', 'COMERCIALIZACION DE PRENDAS DE VESTIR', 'SAN IGNACIO 451, QUILICURA', 'SANTIAGO', '7386359', '0', '7386365', '', 113, NULL),
(113, 77315630, '1', 'M. & PRODUCT. CHILE LIMITADA', 'COMER., IMPORT., PRODUCT. L. BLANCA, MEN', '', 'SANTIAGO', '8576488', '0', '8576488', '', 114, NULL),
(114, 82833200, '7', 'CRISTALERIAS VIDECOR CHILE LTDA.', 'IMPOT.,DISTRIB.,Y DECORACION DE ART.VIDR', 'POETA PEDRO PRADO 1617 QUINTA NORMAL', 'SANTIAGO', '5103400', '0', '7736274', '', 115, NULL),
(115, 99537150, '2', 'SOC. DE INVERSIONES TERRANOVA S.A.', 'FABR. DE CALZADO Y BOTAS DE CUERO, TELA', '', 'SANTIAGO', '5515789', '0', '5515789', '', 116, NULL),
(116, 77783030, '9', 'SOC. COMERC. INDUSTR. NORMA SEGUIN LTDA.', 'VENTA DE PRODUCTOS TEXTILES', '', 'SANTIAGO', '4555189', '0', '0', '', 117, NULL),
(117, 76198160, '9', 'SOC. IMP. Y EXP. LIA LIMITADA', '', '', '', '867234', '860243', '0', '', 118, NULL),
(118, 8265044, 'K', 'CASA YON LEY', '', '', 'VALPARAISO', '0', '0', '0', '', 119, NULL),
(119, 12682598, '6', 'JUAN ANTONIO SOLAR ESPINOZA', 'VENTA DE MUBLES', 'SAN DIEGO 2330 LOCAL 79 - 113 STGO.', 'SANTIAGO', '0', '0', '0', '', 120, NULL),
(120, 77916500, '0', 'MADERAS IMPERIAL VALPARAISO LIMITADA', 'VENTA DE MADERAS Y MATERIALES DE CONST.', 'AV. INDEPENDENCIA 3033 VALPARAISO', 'VALPARAISO', '230443', '230523', '0', '', 121, NULL),
(121, 81482800, 'K', 'COOPERATIVA SOCOMADE LTDA.', 'BARRACA MADERAS, MATERIALES DE CONST.', 'JUANA ROSS 171 VALPARAISO', 'VALPARAISO', '216824', '234220', '0', '', 122, NULL),
(122, 84176000, 'K', 'TEXTIL RANDATEX LIMITADA', 'VTA DE TELAS AL POR MENOR', 'RECOLETA 414-420', 'SANTIAGO', '7379524', '0', '0', '', 123, NULL),
(123, 15464474, '1', 'NATALIA CAROLINA MARCHANT AMAYA', 'VENTA DE MUEBLES', 'ARTURO PRAT 2251 SANTIAGO', 'SANTIAGO', '0', '0', '0', '', 124, NULL),
(124, 3167050, '0', 'MARIA ESTER ZAMORA CATALDO', 'MUEBLERIA, BAZAR Y PAQUETERIA', 'INDEPENDENCIA 2336 VALPO', 'VALPARAISO', '0', '0', '0', '', 125, NULL),
(125, 96792430, 'K', 'SODIMAC S.A.', 'DISTR. MATERIALES DE CONTRUCCION', 'PTE. EDUARDO FREI M. 3092 RENCA', 'SANTIAGO', '0', '0', '0', '', 126, NULL),
(126, 99577480, '1', 'COMERCIAL MARMICOC S.A.', 'COMERC. MENAJE Y ELECTRODOMESTICOS', 'AV. AMERICO VESPUCIO 2880 CONCHALI', 'SANTIAGO', '6243264', '6242321', '6241994', '', 127, NULL),
(127, 77418920, '3', 'BARRIOS T MISLE LIMITADA', 'COMPRA VENTA DE TELAS, HILADOS MAQUINAS', 'INDEPENDENCIA 402 COMUNA INDEPENDENCIA', 'SANTIAGO', '7359182', '0', '0', '', 128, NULL),
(128, 78702260, 'K', 'COMERCIALIZADORA DE TELAS LIMITADA', 'TELAS NACIONALES E IMPORTADAS', 'DAVILA BAESA 1009 COMUNA INDEPENDENCIA', 'SANTIAGO', '7375013', '0', '0', '', 129, NULL),
(129, 78748930, '3', 'COMERCIAL YON LEY LIMITADA', '', '', 'VALPARAISO', '0', '0', '0', '', 130, NULL),
(130, 96539970, '4', 'PERNOVAL S.A.', '', '', '', '0', '0', '0', '', 131, NULL),
(131, 96756430, '3', 'CHILEXPRESS S.A.', '', '', '', '0', '0', '0', '', 132, NULL),
(132, 78381520, '6', 'ALBORNOZ Y LAMA LIMITADA', '', '', '', '0', '0', '0', '', 133, NULL),
(133, 9525177, '3', 'OLGA INES RIVERA JARA', 'TALLER DE MUEBLES METALICOS', 'PJE. 34 #909 VILLA O''HIGGINS LA FLORIDA', 'SANTIAGO', '5110775', '0', '0', '', 134, NULL),
(134, 99519540, '2', 'CHILE TRADE S.A', 'COMPRA VENTA VIDRIOS Y CRISTALES', 'CAMINO LOS PINOS PONIENTE SAN BERNARDO', 'SANTIAGO', '5284582', '0', '0', '', 135, NULL),
(135, 4703434, '5', 'CARLOS ARIAS GARRIDO', 'MUEBLES Y MENAJE', '', 'SANTIAGO', '0', '0', '0', '', 136, NULL),
(136, 96949900, '2', 'TITO YARAD S.A.', 'MAQUINARIA, REPUESTOS PARA CONFECCION', 'RIO DE JANEIRO 470 RECOLETA', 'SANTIAGO', '7374547', '0', '0', '', 137, NULL),
(137, 78596540, 'K', 'DISTRIBUIDORA Y COMERCIALIZADORA TEXTIL', '', 'AV. MEXICO 852 RECOLETA', 'SANTIAGO', '6227746', '0', '0', '', 138, NULL),
(138, 9218711, 'K', 'YEN MING CHEN CHUANG', 'PRENDAS DE VESTIR, CALZADO, GUANTES', 'SAN ALFONSO 91', 'SANTIAGO', '6890360', '0', '0', '', 139, NULL),
(139, 76112370, 'K', 'COMERCIAL SOL Y VALLE', '', '', '', '0', '0', '0', '', 140, NULL),
(140, 77577180, '1', 'TIMBER WOLF SPORT LIMITADA', 'PRENDAS DE VESTIR, ART. DEPORTIVOS', 'AV. CHESTERTON LAS CONDES STGO', 'SANTIAGO', '2201486', '0', '0', '', 141, NULL),
(141, 86394600, 'K', 'FERRETERIA IMPERIAL LIMITADA', 'FERRETERIA', 'SANTA ROSA 7876 LA GRANJA', 'SANTIAGO', '3997029', '0', '0', '', 142, NULL),
(142, 78435730, '9', 'TEXTIL CUBRETEX', '', 'LA PINTANA', 'SANTIAGO', '0', '0', '0', '', 143, NULL),
(143, 79651270, '9', 'SOCIEDAD COMERCIAL LI-HUE LIMITADA', 'GENEROS,TELAS,VENTA', 'SAN DIEGO 1361 SANTIAGO', 'SANTIAGO', '5569314', '0', '0', '', 144, NULL),
(144, 8019677, '6', 'DELFIN ANTONIO NEIRA VARGAS', 'FAB. DE ART. DOMESTICOS', '', 'SANTIAGO', '5253596', '0', '0', '', 145, NULL),
(145, 78129360, '1', 'JIMENEZ CERASA S.A.', 'FABR. DE TEXTILES Y EXPORTACION', 'AV. LOS CERRILLOS 564 CERRILLOS SANTIAGO', 'SANTIAGO', '5574964', '0', '0', '', 146, NULL),
(146, 4754521, '8', 'LUIS ALARCON BUSTOS', 'VTA DE TELAS NACIONALES TIENDA DE GENERO', 'DAVILA BAEZA 1027 INDEPENDENCIA STGO.', 'SANTIAGO', '7372883', '0', '0', '', 147, NULL),
(147, 96628710, '1', 'CONFECCIONES NACIONALES S.A.', 'CONFECCIONES DE PRENDAS DE VESTIR', 'ANTONIA LOPEZ DE BELLO 414 RECOLETA', 'SANTIAGO', '7745783', '0', '0', '', 148, NULL),
(148, 5578831, '6', 'JEDA ANDRES AGUILERA ECHEGARAY', 'TALLER DE CALZADO', 'COMUNA SAN MIGUEL SANTIAGO', 'SANTIAGO', '3126085', '0', '0', '', 149, NULL),
(149, 50483420, '4', 'ACEVEDO TESSINI JULIO ANTONIO Y OTRO', 'TALLER ARTESANAL FABR. DE MARCOS Y ESPEJ', '', 'SANTIAGO', '7751493', '0', '0', '', 150, NULL),
(150, 5801177, '8', 'ROSA MARGARITA BARAHONA LOYOLA', 'COMPRA VENTA DE MADERAS FABR. DE MUEBLES', 'AV. COMBARBARA 0579 LA GRANJA STGO.', 'SANTIAGO', '5250622', '0', '0', '', 151, NULL),
(151, 77444930, '2', 'BREMEN LIMITADA', '', '', '', '487573', '0', '0', '', 152, NULL),
(152, 7574404, '8', 'MARIA IRENE FLORES RIQUELME', '', 'LA GRANJA', 'SANTIAGO', '0', '0', '0', '', 153, NULL),
(153, 78068690, '1', 'LAVANDERIA RIVET LIMITADA', 'LAVANDERIA Y TINTORERIA', 'ROSAS 2105 - 2123', 'SANTIAGO', '0', '0', '0', '', 154, NULL),
(154, 78089750, '3', 'SOCIEDAD TELAS VITACURA LIMITADA', 'TIENDA DE VESTIR Y DE GENEROS', 'DAVILA BAEZA 1000 COM. INDEPENDENCIA', 'SANTIAGO', '7771571', '0', '0', '', 155, NULL),
(155, 4006588, '1', 'HUGO KUPERMAN FROIMOVICH', 'COMPRA-VTA DE METALES, FIERROS, ETC+', 'CHACABUCO 2621 VALPARAISO', 'VALPARAISO', '255830', '0', '0', '', 156, NULL),
(156, 77935650, '7', 'COMERCIAL IMPOGAR LTDA.', 'COMPRA - VTA MENAJE, ART. HOGAR', 'LO BOZO 8887 PUDAHUEL', 'SANTIAGO', '7392705', '0', '0', '', 157, NULL),
(157, 7564983, '5', 'CARLOS EDUARDO LOPEZ CARVAJAL', '', 'SAN MARTIN', 'RANCAGUA', '235502', '0', '0', '', 158, NULL),
(158, 93049000, '8', 'TEXTILES ZAHR S.A.', 'FABRICA DE FRAZADAS', 'LOS CARRERA 01682', 'QUILPUE', '567986', '0', '0', '', 159, NULL),
(159, 4334855, '8', 'JUAN HERNAN LORCA PEREZ', '', '', 'SANTIAGO', '0', '0', '0', '', 160, NULL),
(160, 6020832, '8', 'ERICK ELADIO LEIVA OLGUIN', 'TELAS', '', 'SANTIAGO', '7792391', '0', '0', '', 161, NULL),
(161, 10202098, '7', 'PEDRO DEL CARMEN GANGA VERA', 'TALLER DE ESPEJOS Y BOTIQUINES GANGA', 'COMUNA LO PRADO', 'SANTIAGO', '7720915', '0', '0', '', 162, NULL),
(162, 83498900, 'K', 'IMPORTADORA SANTA ELENA LIMITADA', 'DISTR. DE MENAJE', '', 'SANTIAGO', '6958587', '0', '0', '', 163, NULL),
(163, 9099626, '6', 'FREDDY ALEX HUERTA SIERRA', 'COMERCIALIZACION DE PRENDAS DE VESTIR', '', 'SANTIAGO', '0', '0', '0', '', 164, NULL),
(164, 96771220, '5', 'COMERCIAL AZUL S.A.', 'COMPRA VENTA PRENDAS DE VESTIR', 'NATANIEL COX 2142', 'SANTIAGO', '5443372', '0', '0', '', 165, NULL),
(165, 96671750, '5', 'EASY S.A.', '', '', '', '0', '0', '0', '', 166, NULL),
(166, 79588270, '7', 'COMERCIALIZADORA ARAYA HNOS Y CIA LTDA', 'COMERC. ART. DE ALUMINIO', 'VON SCHROEDERS 446', '', '0', '0', '0', '', 167, NULL),
(167, 79536070, '0', 'COMERCIAL DORAL LIMITADA', '', '', 'STGO', '0', '0', '0', '', 168, NULL),
(168, 3465168, 'K', 'NIBALDO ENRIQUE SILVA SILVA', 'FABRICACION Y VENTA MUEBLES DE MADERA', 'POBL. MALAQUIAS LA GRANJA STGO', 'SANTIAGO', '5259998', '0', '0', '', 169, NULL),
(169, 76362190, '1', 'CALZADOS VITANOVA LIMATADA', 'COMERCIALIZACION DE CALZADO', 'SAN DIEGO 1716 STGO', 'SANTIAGO', '0', '0', '0', '', 170, NULL),
(170, 10771795, '1', 'CAROLINA M. HERRERA BARRA', 'CONFECION Y VTA DE PRENDAS DE VESTIR', 'AVDA. PERU 932 RECOLETA', 'SANTIAGO', '7356927', '0', '0', '', 171, NULL),
(171, 92017000, '5', 'SOMELA S.A.', 'FABRICA DE ELECTRODOMESTICOS', 'A. ESCOBAR WILLIAMS 600', 'SANTIAGO', '5574225', '0', '0', '', 172, NULL),
(172, 76348630, '3', 'IMPORTADORA Y EXPORT. YIXIN LTDA.', '', '', 'SANTIAGO', '0', '0', '0', '', 173, NULL),
(173, 8406500, '5', 'BEATRIZ A. MORAN CACERES', 'COMPRA Y VENTA DE ART. DE HOGAR', '', 'SANTIAGO', '5569637', '0', '0', '', 174, NULL),
(174, 9577955, '7', 'ALEJANDRO S. ROMAN SILVA', '', '', 'SANTIAGO', '6893081', '0', '0', '', 175, NULL),
(175, 53297431, '3', 'GUO WEI Y OTRO', 'IMPORTACION ARTESANIA Y PORCELANA CHINA', '', 'SANTIAGO', '0', '0', '0', '', 176, NULL),
(176, 85146000, '4', 'IMPORTADORA B.S. SOCIEDAD ANONIMA', '', 'AV. FRANCIA 984', 'VALPARAISO', '0', '0', '0', '', 177, NULL),
(177, 77623040, '5', 'IMPORTADORA SAI RAM LIMITADA', '', 'SAZIE 2880', 'SANTIAGO', '6890987', '0', '0', '', 178, NULL),
(178, 96959860, '4', 'COMERCIALIZADORA DIRECTO CHILE LIMITADA', '', 'SAN ALFONSO 236', 'SANTIAGO', '0', '0', '0', '', 179, NULL),
(179, 13767102, '6', 'MYLENE C. TRONCOSO MENDEZ', '', 'SAN ALFONSO 242', 'SANTIAGO', '0', '0', '0', '', 180, NULL),
(180, 76146740, '9', 'COMERCIAL UNILAYS LIMITADA', '', 'EUSEBIO LILLO 321', 'SANTIAGO', '0', '0', '0', '', 181, NULL),
(181, 77917030, '6', 'IMPORTADORA Y EXPORT. SHALINI LTDA.', '', '', 'STGO', '0', '0', '0', '', 182, NULL),
(182, 76376520, '2', 'INVERSIONES JEDA AGUILERA E.I.R.L.', '', '', 'SANTIAGO', '0', '0', '0', '', 183, NULL),
(183, 10700067, '4', 'TODO DEPORTES', '', '', 'STGO', '0', '0', '0', '', 184, NULL),
(184, 76410880, '9', 'SOCIEDAD IMP. FENIX LTDA', '', 'SAN ALFONSO 242', 'SANTIAGO', '6895485', '0', '0', '', 185, NULL),
(185, 5537550, 'K', 'VERONICA VICENCIO', '', 'RIO ALVAREZ  17 FORESTAL', '', '0', '0', '0', '', 186, NULL),
(186, 11111111, '1', 'MARIO VERGARA', '', '', '', '0', '0', '0', '', 187, NULL),
(187, 99591700, '9', 'AKATEC S.A.', 'VTA DE PAPELES Y ETIQUETAS EN TODO TIPO', '', 'SANTIAGO', '6322454', '6322454', '0', '', 188, NULL),
(188, 77511090, '2', 'COMERCIAL EUROTEX LIMITADA', 'VTA DE TELA, SEDAS Y OTROS', 'INDEPENDENCIA 315', 'SANTIAGO', '7359186', '7372122', '7372136', '', 189, NULL),
(189, 76474780, '1', 'SOCIEDAD COMERCIAL ARTE ANDINO LIMITADA', 'COMPRA Y VENTA DE PRODUCTOS TEXTILES', 'COMUNA ESTACION CENTRAL', 'SANTIAGO', '6840784', '0', '0', '', 190, NULL),
(190, 78924490, '1', 'MILLENIUM PRODUCTS CHILE', 'VTA DE PRODUCTOS PLASTICOS', '', 'STGO', '4436515', '4436514', '0', '', 191, NULL),
(191, 76284180, '0', 'TRANSPORTES VALDES Y CIA LTDA.', '', '', 'STGO', '7746719', '0', '0', '', 191, NULL),
(192, 76511980, '4', 'IMPORTACIONES GUO WEI LIMITADA', '', '', 'SANTIAGO', '0', '0', '0', '', 192, NULL),
(193, 77854550, '0', 'COMERCIAL HISPORT LIMITADA', 'IMP.,DISTR., Y VTA DE ART. DEPORTIVOS', 'AVENIDA PROVIDENCIA 2349', 'SANTIAGO', '0', '0', '0', '', 193, NULL),
(194, 78036990, '6', 'DISTRIBUIDORA ARQUETIPO LIMITADA', '', 'EXPOSICION 13543', 'SANTIAGO', '0', '0', '0', '', 194, NULL),
(195, 76541940, '9', 'SOCIEDAD COMERCIAL KING SHENG LIMITADA', 'VTA DE TELAS', 'INDEPENDENCIA 333', 'SANTIAGO', '0', '0', '0', '', 195, NULL),
(196, 9707321, 'K', 'PEDRO ENRIQUE NAVARRETE LEON', 'COMERCIALIZADORA DE PRODUCTOS TEXTILES', 'ISABEL CARRERA 5938 CONCHALI', 'SANTIAGO', '0', '0', '0', '', 196, NULL),
(197, 9876714, '2', 'CARLOS ALBERTO JARA BASCUR', 'FABRICA Y VENTA DE MUEBLES', '11 PONIENTE 8048 LA GRANJA', 'SANTIAGO', '5266194', '5414494', '0', '', 197, NULL),
(198, 76748650, '2', 'EMPRESA ARTEX-CHILE S.A', 'ROPA CAMA-DECORACION TEXTIL DEL HOGAR', '', 'SANTIAGO', '6967664', '0', '0', '', 198, NULL),
(199, 96725740, '0', 'PLACART S.A.', 'FABRICA DE ENVASES PLASTICOS', 'LOS CARRERA 01682', 'QUILPUE', '2566559', '0', '0', '', 199, NULL),
(200, 22222222, '2', 'VERONICA VICENCIO', '', '', '', '0', '0', '0', '', 200, NULL),
(201, 76437130, '5', 'KOLOMANO HUBER VALDERRAMA', '', '', '', '0', '0', '0', '', 201, NULL),
(202, 88610100, '7', 'EDUARDO DIB H. Y CIA. LTDA.', '', 'PLAZA PARROQUIA 319', '', '2382780', '0', '0', '', 202, NULL),
(203, 76533310, '5', 'S&N TEKNOLOGICA S.A', 'COMPRA Y VENTA DE ART DEL HOGAR', 'DIAGONAL CERVANTES 625', 'SANTIAGO', '6334305', '0', '0', 'CECILIA', 203, NULL),
(204, 79569830, '2', 'COMERCIAL DALCAHUE LIMITADA', 'COMERC., DISTRIB., Y VTA DE BIENES MUEBL', 'EL MARISCAL 2665', 'SANTIAGO', '8497593', '0', '0', '', 204, NULL),
(205, 99571070, '6', 'PH GLASS S.A.', '', 'AVDA. EL BOSQUE 1471', 'SANTIAGO', '4967300', '0', '0', '', 205, NULL),
(206, 77465560, '3', 'FERRETERIA INDUSTRIAL GALIANO LTDA', 'FERRETERIA', 'CARLOS VALDOVINOS 1989 P.AGUIRRE CERDA', 'SANTIAGO', '0', '0', '0', '', 206, NULL),
(207, 76513970, '8', 'ROSA HORTENCIA CONTRERAS BENITES E.I.R.L', '', 'DEPARTAMENTAL 929', 'SANTIAGO', '0', '0', '0', '', 207, NULL),
(208, 15634288, '2', 'LUIS ANTONIO CRUZ ULLOA', 'FCA DE MUEBLES - COMPRA VTA', 'PARAGUAY 1522', 'SANTIAGO', '2597998', '0', '0', '', 208, NULL),
(209, 77836020, '9', 'NOVA IDEA', '', 'LAS VERTIENTES NORTE 6970 EL OLMO', 'SANTIAGO', '4186076', '0', '0', '', 209, NULL),
(210, 87860400, '8', 'RECUPERADORA TEXTIL LTDA', 'RECUPERACION-HILANDERIA-TEJEDURIA-VTA DE', 'CAUQUENES 6609 CERRO NAVIA', 'SANTIAGO', '0', '0', '0', '', 210, NULL),
(211, 79730210, '4', 'SOC DEINV SERVICIOS Y ACS IVC LTDA', '', '', 'SANTIAGO', '0', '0', '0', '', 211, NULL),
(212, 76000893, '1', 'SOC COMERCIAL SOLO DEPORTES LTDA', '', 'PJE ALMERIA 2277', 'SANTIAGO', '0', '0', '0', '', 212, NULL),
(213, 78744360, '5', 'ADIDAS CHILE LIMITADA', 'VTAS DE PRODUCTOS DEPORTIVOS', 'AV. SANTA MARIA 6350 VITACURA', 'SANTIAGO', '7156800', '7156800', '0', 'DANIELA ORELLANA', 213, NULL),
(214, 77304340, 'K', 'DISTRIB Y COMERC TEXTIL LTDA', '', '', 'SANTIAGO', '0', '0', '0', '', 214, NULL),
(215, 76002148, '2', 'INDUMUEBLES S.P.A.', '', '', 'SANTIAGO', '5729976', '5450724', '0', 'VTA MUEBLES', 215, NULL),
(216, 13682249, '7', 'MARCELO ANDRES OLIVARES FIGUEROA', '', 'FREIRE 1052 SAN BERNARDO', 'SANTIAGO', '0', '0', '0', '', 216, NULL),
(217, 90761000, '4', 'PHILIPS CHILENA S.A', '', 'AV STA MARIA 760 PRROVIDENCIA', 'SANTIAGO', '0', '0', '0', '', 217, NULL),
(218, 76667750, '9', 'TOTAL SPORTS GROUPS S.A', '', 'AVDA MANQUEHUE 1337 OF 52', 'VITACURA SANTIAGO', '4865000', '4896505', '0', '', 218, NULL),
(219, 9822684, '2', 'SAMUEL RODRIGO VALENCIA ESCALA (I-PORA)', 'DECORACION Y ART. DE REGALO', '', '', '2821887', '0', '0', '', 219, NULL),
(220, 77224930, '6', 'COMERCIAL UP-TOP LTDA.', 'COM. DE CALZADOS Y CARTERAS EN CUERO', 'EBRO 2799 OF-2A, LAS CONDES', 'SANTIAGO', '2319313', '2322057', '0', '', 220, NULL),
(221, 79999300, '7', 'GASTON PIZARRO MAUREIRA Y CIA. LTDA.', 'AGENCIA DE ADUANAS', 'ESMERALDA 973 OF.301 VALPO', 'VALPARAISO', '2213708', '0', '0', '', 221, NULL),
(222, 76009017, '4', 'IMPORTADORA BELPAC LIMITADA', 'IMP. Y COM. DE PRENDAS DE VESTIR Y CALZA', 'DARDINAC 217, RECOLETA STGO', 'SANTIAGO', '7380352', '7772544', '0', '', 222, NULL),
(223, 96311000, '6', 'LAHSEN HERMANOS LIMITADA', 'FABRICA DE ARMADO DE MUEBLES', 'AYSEN 564 MACUL STGO', 'STGO', '0', '0', '0', '', 223, NULL),
(224, 11626427, '7', 'VISION DEPORTES (MARCELO PEREZ VERGARA)', 'CALZADO Y DEPORTES', '', 'SANTIAGO', '0', '0', '0', '', 224, NULL),
(225, 77771760, 'K', 'DECORACIONES Y CORTINAS LTDA', 'DISTRIB.DE MATERIALES DE CONSTRUCCION', '4 NORTE 465 LOCAL 4', '', '2695493', '2695896', '2695896', '', 225, NULL),
(226, 77751990, '5', 'ELECTRONICA KOLM LIMITADA', 'VENTA DE ART.ELECTRICOS Y ELECTRONICOS', '', 'SANTIAGO', '6894324', '0', '6894324', '', 226, NULL),
(227, 92819000, '5', 'FELTREX S.A.', '', 'OBISPO ARTURO ESPINOZA CAMPOS 2587 MACUL', 'SANTIAGO', '3450500', '0', '3450505', 'MARILU', 227, NULL),
(228, 7938663, '4', 'ETELVINA DEL CARMEN ARTIAGA ARTIAGA', 'FABRICACION Y VTA DE ART. DE ALUMINIO', 'LAS PALMAS 541 EX 563 VILLA LA SELVA', 'SANTIAGO SN BERNARDO', '8571767', '0', '0', '', 228, NULL),
(229, 76011333, '6', 'CAIMI CHILE S.A', 'CUEROS SINTETICOS Y OTROS', '', 'SANTIAGO', '5920112', '5920113', '0', '', 229, NULL),
(230, 76015143, '2', 'IMPORT. Y EXPOR. PACIFICO SUR LTDA.', 'IMPORT.EXPORT.DISTRIB.Y COM.PROD.TEXTILS', 'MARQUEZ DE OVANDO 1775 PEDRO P.A. CERDA', 'SANTIAGO', '7932119', '0', '0', '', 230, NULL),
(231, 76009813, '2', '"FERCOM"', 'COMERC. DE ART. DE FERRETERIA', '', 'SANTIAGO', '5613774', '0', '0', '', 231, NULL),
(232, 76011948, '2', 'COMERCIALIZADORA B-MIND LTDA.', 'ART. PARA EL HOGAR', 'AV. GABRIELA 02881 PONIENTE L PINTANA', 'SANTIAGO', '0', '0', '0', '', 232, NULL),
(233, 76064030, '1', 'BASAURE IMPORTADORA COMERCIAL LIMITADA', 'IMP.DE ENV.PLASTICOS,IMP.DE TELAS', 'SAN ISIDRO 19 DEPTO.1108', 'SANTIAGO', '2228005', '0', '2228132', '', 233, NULL),
(234, 77919450, '7', 'DISTRIBUIDORA ALBA SUAREZ Y CIA. LTDA.', '', 'AVDA.LIBERTAD 919 OF.94', '', '2790000', '2790009', '0', '', 234, NULL),
(235, 11664658, '7', 'RAFAEL ABELARDO AGUILERA GONZALEZ', 'FABRICACION Y VENTA DE CALZADO', '', 'SANTIAGO', '3126085', '0', '0', '', 235, NULL),
(236, 76024023, '0', 'LAVANDERIAS LASAN S.P.A.', 'LAVANDERIA-COMERCIO TEXTIL POR MAYOR', 'SAN GERARDO 862 RECOLETA', 'SANIAGO', '6216164', '0', '0', '', 236, NULL),
(237, 4438609, '7', 'DAGOBERTO GUTIERREZ RETAMAL', '', '3 NORTE 0641 LA GRANJA', 'SANTIAGO', '5260313', '0', '0', '', 237, NULL),
(238, 2811982, '8', 'EMILIO JASEN GALAZ', 'ARRIENDO DE INMUEBLES AMOBLADOS', 'AV J.M CARRERA 11743', 'SANTIAGO', '5281933', '0', '0', '', 238, NULL),
(239, 76526170, '8', 'SOC.COMERCIAL CAP MASTERS LTDA.', '', 'DARDIGNAC 377 RECOLETA', 'SANTIAGO', '7379435', '7324891', '0', '', 239, NULL),
(240, 6946365, '7', 'BENEDICTO ALFREDO CACERES ALLENDE', 'FABRICA DE MUEBLES', '', 'SANTIAGO', '7990530', '0', '0', '', 240, NULL),
(241, 76100330, '5', 'COMERCIALIZ Y DISTRIB GOOD FORTUNE LTDA', '', 'DAVILA BAEZA 1027', 'SANTIAGO', '0', '0', '0', '', 241, NULL),
(242, 76043567, '8', 'CANTABRICA CHILE S.A', '', '', 'SANTIAGO', '6239460', '0', '0', '', 242, NULL),
(243, 78748930, '2', 'COMERCIAL YONLEY', 'COMERCIAL', 'EL VERGEL', 'VALPARAISO', '0', '0', '0', ' ', 0, NULL),
(244, 76892250, '0', 'ASIPAC LIMITADA', 'DISTRIBUIDORA', 'SANTA MARIA 381', 'RANCAGUA', '0', '0', '0', '0', 243, NULL),
(245, 77811990, '0', 'IMPORTADORA MATRIX LTDA.', 'IMPORTADORA', '.', '.', '.', '.', '.', '.', 244, NULL),
(246, 77820410, 'K', 'INVERSIONES INMOBILIARIA VALLE ESCONDIDO LTDA.', 'INVERSIONES', '.', '.', '.', '.', '.', '.', 245, NULL),
(247, 92124000, '7', 'INDUSTRIAS REUNIDAS ANDES', 'COMERCIAL', 'AV.LOS CERRILLOS 564', 'SANTIAGO', '.', '.', '.', '.', 245, NULL),
(248, 6387083, '8', 'ALAN ENRIQUE MARTINEZ SORIANO', 'COMERCIALIZACION DE PRODUCTOS', 'SACRAMENTO 1191', 'SANTIAGO', '22113714', '0', '0', ' ', 99, NULL),
(249, 9497805, NULL, 'MARIA LUZ SANDOVAL OTAROLA', 'TALLER DE MUEBLES', 'ALVEAR 650 SAN RAMON', 'SANTIAGO', '5266865', NULL, NULL, NULL, NULL, NULL),
(250, 13312481, NULL, 'ALONSO ROJAS', 'DSDS', 'SDSD', 'SDSDS', NULL, NULL, NULL, NULL, NULL, NULL),
(251, 13312481, NULL, 'ALONSO ROJAS', 'DSDS', 'SDSD', 'SDSDS', NULL, NULL, NULL, NULL, NULL, NULL),
(252, 11620872, NULL, 'CARLOS SALAZAR DIAZ', 'DDDA', 'SDSDS', 'SDSDS', '123', '123', '123', 'FDFDFDF', NULL, 'prueba@123.cl'),
(253, 13514036, NULL, 'CAROLINA INOSTROZA', 'WQWQW DD', 'AASA', 'SDSDS', NULL, NULL, NULL, NULL, NULL, NULL),
(254, 1, NULL, 'PRUEBA', 'SDSDS', 'SDS', 'DSDSDS', '123', '', '', '', NULL, ''),
(255, 76105961, NULL, 'ESTRUCTURAS METALICAS CINKAM MET LTDA.', 'FABRICACION DE PRD.METALICOS', 'NECOCHEA # 686,LO PRADO ', 'SANTIAGO', '7746719', '', '', '', NULL, 'cinkammet@hotmail.com'),
(256, 8759876, NULL, 'HERNAN HIPOLITO TRIPAILAF MANQUEHUAL', 'FABRICACION DE MUEBLES', 'QUILPUE 7768 - LA GRANJA', 'SANTIAGO', '88087007', '', '', 'MUEBLES LIVING', NULL, ''),
(257, 15770832, NULL, 'JUAN ALEJANDRO ASTUDILLO GODOY', 'FABRICACION.COMERCIALIZACION DE MUEBLES Y TRANSPORTE DE CARGA', 'ELQUI 7825 - LA GRANJA', 'SANTIAGO', '5366022', '87742763', '', 'PROVEEDOR GABRIELA ASTUDILLO', NULL, ''),
(258, 76639120, NULL, 'COMERCIAL TAAS LTDA.', 'VENTA Y DISTRIBUCION DE EQUIPOS DE PREPAGO', '2 NORTE 505 ', 'VIÑA DEL MAR', '2790000', '', '', '', NULL, ''),
(259, 7804155, NULL, 'MIGUEL ANGEL ASTUDILLO GHO', 'FABRICACION DE MUEBLES .', 'AVDA.GABRIELA 02881 GALPO B - LA PINTANA', 'SANTIAGO', '5366022', '87742763', '', '', NULL, ''),
(260, 76045645, NULL, 'CALTEX  ADMINISTRADORA LTDA.', 'COM.DE CALZADO Y PRD.TEXTILES', 'EL TAQUERAL PARCELA 4 LOTE 1 SITIO 9', 'LAMPA SANTIAGO', '7453636', '7453819', '', '', NULL, ''),
(261, 77025310, NULL, 'FABRICOLCHAS LTDA.', 'FABRICA DE MUEBLES - ACC. NO METALICOS', 'CAÑETE Nº7765-LA GRANJA ', 'SANTIAGO', 'S/N', '', '', '', NULL, ''),
(262, 15541335, NULL, 'CLAUDIO EVARISTO PEREIRA QUEIPUL', 'COMPRA Y VENTA DE MUEBLES', 'BERMANN 566, SAN MIGUEL', 'SANTIAGO', '5252906', '', '', '', NULL, ''),
(263, 4333886, NULL, 'JORGE ADOLFO VERA FIERRO', 'FERRETERIA INDUSTRIAL', 'CARLOS VALVINOS 1989, P. AGUIRRE CERDA', 'SANTIAGO', '5636667', '3135160', '5634960', '', NULL, ''),
(264, 76136631, NULL, 'COMERCIAL LOMA LTDA.', 'FAB. DE MUEBLES U ESTRUCTURAS METAL.', 'PUERTO VARAS 7825, LA GRANJA', 'SANTIAGO', '5115874', '', '5115874', 'SERVICIOS PINTURA ELECTROSTATICA', NULL, 'comercializadora.loma@gmail.com'),
(265, 92817000, NULL, 'CIA. DE TEJIDOS PRIMATEX S. A.', 'INDUSTRIA TEXTIL', 'GRAL. BRAYER 2120, QUINTA NORMAL', 'SANTIAGO', '(2)77330011', '', '(2)7737573', 'PRIMATEX', NULL, ''),
(266, 4363647, NULL, 'ULDARICO RETAMALES ARANDA "RECORD"', 'COMPRA-VENTA ARTS. DE CALZADO Y ROPA', 'PEDRO MIRA Nº 844, SAN MIGUEL', 'SANTIAGO', '7236484', '09-8221075', '7236484', 'ROPA DE TRABAJO', NULL, ''),
(267, 6151772, NULL, 'BERNARDO ROCA SANHUEZA', 'TALLER DE MUEBLES Y ACC. METALICOS', 'CAÑETE Nº 7860, LA GRANJA', 'SANTIAGO', '79123435', '', '', 'LINEA KID', NULL, ''),
(268, 6446093, NULL, 'FERNANDO IVAN ROJAS ORELLANA', 'FABRICA DE ARTICULOS DOMESTICOS', 'AV CORONEL 7824 LA GRANJA', 'SANTIAGO', '098553252', '', '', '"PANCHITO"', NULL, ''),
(269, 5385541, NULL, 'ROLANDO ROCA SANHUEZA', 'TALLER DE MUEBLES Y ACCESORIOS METALICOS', 'CORONEL Nº7905 POBL. MALAQUIAS CONCHA CUM. LA GRANGA', 'SANTIAGO', '5255164', '', '', 'LA ROCA', NULL, ''),
(270, 10419434, NULL, 'JUAN AGUSTIN REYES MONDACA', 'VTA. ARTICULOA  PARA EL HORA Y MENAJE', 'ANITA LIZANA Nº 5226, VILLA LOS CALVELES', 'MAIPU, SANTIAGO', '076971503', '', '', '', NULL, ''),
(271, 76435650, NULL, 'TEXORA SOCIEDAD ANONIMA', 'COM. Y DISTRIBUCION TEXTILES MANOFACTUDADOS', 'AV. EDO. FREI MONTALVA Nº 9931', 'QULICURA - SANTIAGO', '3524000', '3524010', '7335516', 'CASCOS\n\n\n\n\n\n\n\n\n', NULL, 'VENTAS@TEXORA.CL'),
(272, 79995160, NULL, 'COM. E INDUSTRIAL ROVIGO LTDA.', 'FABRICA DE CALZADO', 'CHILOE 1970', 'SANTIAGO', '5552712', '5518636', '5518636', 'ZAPATOS DE SEGURIDAD', NULL, 'OVERLAND@CALZADOSOVERLAND.CL'),
(273, 11316243, NULL, 'LUZ IRENE BARAHONA VALENZUELA', 'ARMADO DE MUEBLES', 'CAñETE Nº7850 LA GRANJA', 'SANTIAGO', '1', '', '', 'LUZ', NULL, ''),
(274, 0, NULL, 'SIN PROVEEDOR', '.', '.', '.', '.', '.', '.', '.', NULL, '.'),
(275, 0, NULL, 'SIN PROVEEDOR', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(276, 76164615, NULL, 'BERNARDO ROCA SANHUEZA E.I.R.L', 'FABRICA E INSTALACION DE MUEBLES', 'LOS VILOS Nº7919 LA GRANJA', 'SANTIAGO', '1', '1', '1', 'MUEBLES ROCA E.I.R.L', NULL, '1'),
(277, 77704530, NULL, 'CHANTILLY JOSE MORENO Y CIA. LTDA ', 'VENTAS TELAS DE VESTIR, ARTS. HOGAR', 'MATIAS COUSIÑO 143', 'SANTIAGO', '(02)6381517', '(02)6722921', '(02)6337442', '', NULL, ''),
(278, 99585800, NULL, 'COMERCIALIZADORA SEARCH S. A.', 'IMP. EXPO. Y COM. LOZA ARTS. FERRETERIA', 'LUIS THAYER OJEDA 95 OFICINA 9810 PROVIDENCIA', 'SANTIAGO', '3345892', '', '3344905', '', NULL, ''),
(279, 88347700, NULL, 'COMERCIAL E INDUSTRIAL DI TREVI LTDA', 'CONFECCION DE SABANAS FUNDAS Y MANTELERIA', 'CUEVAS 1366', 'SANTIAGO', '5552878', '5540324', '5552878', 'DI TREVI LTDA.', NULL, ''),
(280, 76242150, NULL, 'CABALLERO & CABALLERO LIMITADA', 'FABRICA Y VENTAS DE MUEBLES', 'MAPOCHO 5810', 'SANTIAGO', '7736614', '7752847', '7752847', '"MUEBLES FRANZY"', NULL, 'mueblesfranzy@terra.cl'),
(281, 16028962, NULL, 'HECTOR ALONSO MATURANA CERPA', 'COMPRA VENTAS DE MUEBLES Y COLCHONES', 'CALLE PLACER #911, CALLE 12 LOCAL Nº252', 'SANTIAGO CENTRO', '1', '', '', 'HECTOR ALONSO MATURANA CERPA', NULL, ''),
(282, 96542490, NULL, 'TRECK S. A.', 'FABRICA CALZADO DE SEGURIDAD E IMPORTACION', 'SANTA ROSA 5220, SAN JOAQUIN', 'SANTIAGO', '2-4909900', '', '4909901', 'CALZADO DE SEGURIDAD', NULL, ''),
(283, 11693744, NULL, 'JUAN DE DIOS CURIHUINCA CARILAO', 'FABRICA DE MUEBLES MADERA Y METALICAS', 'BERMANN 571-B SAN MIGUEL', 'SANTIAGO', '5250779', '0', '5250779', '"MUEBLES J.C."', NULL, '0'),
(284, 12653909, NULL, 'CLAUDIO FABRICIO RETAMAL PALMA', 'VENTA DE MUEBLES Y MENAJES', 'GASPAR DE ORENSE Nº716 QUINTA NORMAL', 'SANTIAGO', '8809645', '', '', '', NULL, ''),
(285, 76147465, NULL, 'IMPORTADORA DKORA & AMUEBLA ROMAN ANGELO CABALLERO E.I.R.L.', 'VENTA AL POR MAYOR Y MENOR DE MUEBLES, COLCHONES', 'MAPOCHO 5810 QUINTA NORMAL', 'SANTIAGO', '7752847', '0', '0', '', NULL, 'BERNARDA@MUEBLESFRANZY.CL'),
(286, 76199938, NULL, 'FAMILIA MARDESUEÑOS FABRICA DE MUEBLES LTDA.', 'FABRICACION, COMERCIALIZACION COMPRA Y VENTA MATERIALES DE CONSTRUCCION Y ARTICULOS DE HOGAR', 'CAMINO LOS MORROS A PIRQUE Nº670 P.11 BUIN', 'SANTIAGO', '5278483', '0', '0', '"MAR DE SUEÑOS"', NULL, '0'),
(287, 12491124, NULL, 'FREDDY ANIBAL CERNA CORONADO', 'FABRICA DE MUEBLES', 'PARRAL Nº 7878 LA GRANJA', 'SANTIA', '5265368', '0', '0', '"ARTE-CERNA"', NULL, '0'),
(288, 12159040, NULL, 'JESSICA MARY AGUILERA GONZALEZ', 'COMERCIALIZADORA DE ROPA Y CALZADO', 'SANTA MARIA Nº 371, LOCALES 43-60', 'RANCAGUA', '230967', '', '', '', NULL, ''),
(289, 76051618, NULL, 'COMERCIALIZADORA A &V LIMITADA', 'IMPORTACION - EXPORTACION - COMERCIALIZACION', 'ERNESTO REYES Nº 04, PROVIDENCIA', 'SANTIAGO', '22222222', '22222222', '22222222', '', NULL, ''),
(290, 53314063, NULL, 'VERA MUÑOZ RAFAEL ALEJANDRO Y OTRO', 'COMERCIALIZACION DE MUEBLES METAL MADERA Y COMPRA Y VENTA IMPORTACION', 'PICHIMAHUIDA Nº911 LA FLORIDA SANTIAGO', 'LA FLORIDA - SANTIAG', '84914721', '99788888', '', '"MUEBLES VERA MUÑOZ"', NULL, ''),
(291, 7812492, NULL, 'JUAN CARLOS FELIUN VERDUGO', 'FABRICA DE MUEBLES', 'LINCOYAN Nº13598 LA PINTANA', 'LA PINTANA - SANTIAG', '5456933', '0', '0', '"MUEBLES JCF.CL"', NULL, 'FELIUMUEBLES@LIVE.CL'),
(292, 8661974, NULL, 'JUAN SEGUNDO ALTAMIRANO ROJAS', 'MUEBLERIA ARMADO DE MUEBLESN Y TAPICERIA', 'VIÑA DEL MAR Nº476 LA GRANJA', 'SANTIAGO', '94674493', '', '', '"JUAN ALTAMIRANO"', NULL, ''),
(293, 13815876, NULL, 'OSCAR ARNOLDO AREVELO MORENO', 'TALLER DE MUEBLES', 'PARRAL Nº7747', 'COMUNA LA GRANGA SAN', '62676931', '', '', 'OSCAR AREVALO MORENO', NULL, ''),
(294, 15447667, NULL, 'MARJORIE ANDREA PEREZ IBARRA', 'FABRICA MUEBLES Y ESTRUCTURA METALICAS', 'PUERTO VARAS Nº7825 LA GRANJA', 'SANTIAGO', '25115874', '', '', 'MUEBLES ESTILO', NULL, ''),
(295, 76115079, NULL, 'COMERCIAL UNILAYS LIMITADA', 'IMPORTADORA Y EXPORTADORA DE PRENDAS DE VESTIR', 'EUSEBIO LILLO 321 LOCAL 327-329 RECOLETA', 'SANTIAGO', '27320951', '09-88181672', '27320943', '"UNILAYS"', NULL, 'INFO@UNILAYS.COM'),
(296, 6344328, NULL, 'JULIO RAUL SANCHEZ OSORIO', 'TALLER Y REPARACION DE MUEBLES', '5 NORTE N° 0960 SAN GREGORIO', 'LA GRANJA - SANTIAGO', '05-3619521', '', '', '', NULL, ''),
(297, 0, '.', 'URRUTIA Y OTAROLA LTDA', 'IMPORTACION Y VENTA DE NEUMATICOS', '..', '..', '68657367', '..', '..', 'LEOPOLDO ACEVEDO', 0, 'LEOPOLDOACEVEDO@LIVE.CL'),
(298, 76676820, NULL, 'IDETEX S.A.', 'VENTA DE PRODUCTOS TEXTILES', 'AVDA. JUAN DE LA FUENTE 353 BODEGA F', 'COMUNA LAMPA - SANTI', '24825011', '24816894', '', '"IDETEX S.A."', NULL, ''),
(301, 76291284, NULL, 'ANDRADE Y ASTUDILLO LTDA', 'FABRICA DE MUEBLES', 'CAMINO LOS MORROS A PIRQUE N° 670, LOTE 11', 'BUIN, SANTIAGO', '25278483', '', '', '', NULL, ''),
(302, 76676820, '2', 'IDETEX S.A.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(303, 12345, 'P', 'proveedor prueba', '1', '1', '1', '1', '1', '1', '1', 1, '1'),
(304, 8321138, NULL, 'LUIS MARCO CHANDIA BARRIA', 'FABRICA DE MUEBLES', 'AVDA. COMBARBALA N°0190', 'LA GRANJA - SANTIAGO', '5116519', '', '', '"LUCHO CHANDIA"', NULL, ''),
(305, 11313653, NULL, 'RICARDO PIZARRO GUTIERREZ', 'COMERC. Y DISTRIBUIDORA DE MUEBLES', 'LOS CONQUISTADORES 1202 DPTO. 11', 'PUENTE ALTO, SANTIAG', '94323110', '', '', 'COMERCIALIZADORA RIPA-VALMAT', NULL, 'rpizarrogutierrez@gmail.com'),
(306, 96567090, NULL, 'PROYECCION SOCIEDAD ANONIMA', 'VTA ART. ELECTRONICO, LINEA BLANCA, ELECTRODOMESTICOS, IMPORTACIONES, REPRESENTACIONES, INMOBILIARIA', 'VILLAGRA 080 PROVIDENCIA', 'PROVIDENCIA - SANTIA', '26343371', '', '22227088', '"PROYECCION S.A."', NULL, 'PROYECCION@PROY.CL'),
(307, 13288290, NULL, 'LORETO DEL ROSARIO IBACACHE ARMIJO', 'TALLER Y ARMADO DE MUEBLES', 'CAÑETE N° 7754, LA GRANJA', 'SANTIAGO', '7006543', '', '', '', NULL, ''),
(308, 76094327, NULL, 'COMERCIAL FBT LIMITADA', 'COMERCIALIZADORA ARTICULOS ELECTRODOMESTICOS', 'MARURI 1609 INDEPENDENCIA', 'SANTIAGO', '56-2-7354911', '56-2-7357583', '56-2-7357583', '"FBT"', NULL, 'VENTAS@FBT.CL'),
(309, 77194520, '1', 'AUTO STOCK LIMITADA', '0', '0', '0', '0', '0', '0', '0', 0, '0'),
(310, 86869400, '9', 'AUTOMOTRIZ Y COMERCIAL LONCOMILLA LTDA.', '0', '0', '0', '0', '0', '0', '0', 0, '0');

insert into proveedor (PR_RUT,PR_DIGITO,PR_RAZON) values ('86718800','2','TRANS ESPINOZA HNOS LTDA'),('6837389','1','REPUESTOS DARS'),('84420400','0','JOSE LORCA ALVAREZ Y CIA LTDA'),('78248640','3','SOC COMERCIAL MANCINI Y COLEMAN LTDA'),('10424176','K','HENRY VALLEJOS LASTRA'),('77837520','6','COMERCIAL FERRARI Y CIA LTDA'),('96806980','2','ENTEL PCS TELECOMUNICACIONES SA'),('96719620','7','ADT SECURITY SERVICES SA'),('96756430','3','CHILEXPRESS SA'),('51087170','7','VIDAL LERDO DE TEJADA PAULA CAROLINA Y OTRO'),('94510000','1','RENTA NACIONAL CIA DE SEGUROS GENERALES SA'),('7677439','0','MAURICIO DIAZ FERNANDEZ'),('80192600','2','TEXTIL CHAFIK NALLAR E HIJOS LTDA'),('6359117','3','CLAUDIO LEFEVER BILBAO'),('85896100','9','EQUIFAX SA'),('8853454','9','JAZMIN KAISER CONTRERAS'),('76060172','1','SOCIEDAD ALBURQUENQUE Y DROGUETT LTDA'),('76821330','5','IMPERIAL SA'),('9295414','5','ALDO AGUILAR CACERES'),('6336713','3','JORGE MOLINA OLAVE'),('76306380','1','SANDRO ANTONIO DE LA FUENTE RAMOS EIRL'),('11374327','1','AIDA ROJAS ALMUNA'),('76495470','K','REPUESTOS Y LUBRICANTES JM LTDA'),('79536070','0','COMERCIAL DORAL SA'),('5672825','2','ROBERTO ZARZAR ANDONIE'),('96612230','7','CAIMI SAC'),('81031100','2','LUIS VIELVA Y CIA LTDA'),('89117600','7','COMERCIAL ROSSELOT LTDA'),('90635000','9','TELEFONICA CHILE SA'),('96661420','K','SERVICIOS COMPUTACIONALES GLOBAL SA'),('86847300','2','GUILLERMO AHUMADA SA'),('96671750','5','EASY SA'),('87889300','K','INDUSTRIA DE ARTICULOS METALICOS LTDA'),('9497805','K','MARIA LUZ SANDOVAL OTAROLA'),('78385640','9','BELL TELEPHONE LTDA'),('76136631','9','COMERCIAL LOMA LTDA'),('93049000','8','TEXTILES ZAHR SA'),('10748167','2','LUIS ESPINOZA ACEVEDO'),('16860374','6','VICENTE ORMAZABAL MEDINA'),('78867220','9','NELSON LOPEZ LAZO Y CIA LTDA'),('76022098','1','DISTRIBUIDORA LONCOMILLA LTDA'),('96895700','7','NEXT SA'),('76781580','8','NEUMARED SA'),('16028962','7','HECTOR MATURANA CERPA'),('6469429','4','JORGE CIFUENTES CALCAGNO'),('78419560','0','DISTRIBUIDORA DE VEHICULOS SUZUVAL LTDA'),('12603670','1','MIGUEL SAAVEDRA TAPIA'),('92139000','9','SINDELEN SA'),('7535085','6','MAXIMO FERRARI GUZMAN'),('88937800','K','AUTOFRAM SA'),('76073040','8','SOC IMP Y EXP DE REPTOS DE AUTO FLEXMAR LTDA'),('76146740','9','COMERCIAL UNILAYS LTDA'),('96542490','3','TRECK SA'),('96813520','1','CHILQUINTA ENERGIA SA'),('81756100','4','CONFECCIONES E IMPORTACIONES Y CIA LTDA'),('7181005','4','LEONARDO RAMIREZ RODRIGUEZ'),('93441000','9','DUCASSE COMERCIAL LTDA'),('76522480','2','MOTORES PIDDO LTDA'),('84851800','K','MENESES Y DIAZ LTDA'),('76198160','9','SOC IMPORT Y EXPORT LIA LTDA'),('77031030','K','SOC COMERCIAL E INDUSTRIAL VIVACOL LTDA'),('10700067','4','MARIO PEREZ REVECO'),('96311000','6','LAHSEN HERMANOS LTDA'),('77704530','K','JOSE MORENO Y CIA LTDA'),('76107992','1','CTROL PLAGAS Y SERV GNRALES JETTYCHILE LTDA'),('77261280','K','FALABELLA RETAIL SA'),('6387083','8','ALAN ENRIQUE MARTINEZ SORIANO'),('90761000','4','PHILIPS CHILENA SA'),('92817000','4','CIADE TEJIDOS PRIMATEX SA'),('76242150','K','CABALLERO & CABALLERO LTDA'),('12653909','6','CLAUDIO RETAMAL PALMA'),('15770832','5','JUAN ASTUDILLO GODOY'),('76496130','7','SOCIEDAD CONCESIONARIA COSTANERA NORTE SA'),('7804155','2','MIGUEL ASTUDILLO GHO'),('77025310','1','FAB DE MUEBLES Y ACOLCHADOS RIVAS Y RIVAS LTDA'),('76164615','K','MUEBLES BERNARDO ROCA SANHUEZA EIRL'),('11693744','1','JUAN DE DIOS CURIHUINCA CARILAO'),('78646200','2','COMERCIAL NEUMAVAL LTDA'),('80522900','4','E KOVACS SA'),('50159080','0','INDUSTRIAS CELTA LTDA'),('6446093','5','FERNANDO ROJAS ORELLANA'),('79689550','0','ADM DE ESTACIONES DE SERV SERCO LTDA'),('50980600','4','DAZA RETAMAL ROLANDO ALFONSO Y OTRO'),('81605600','4','ABRAHAM ZEDAN E HIJOS LTDA'),('10974873','0','ALVARO CANCINO PALACIOS'),('77067560','K','FERRETERIA EL CANDADO LTDA'),('77373610','3','COMERCIAL AROS PIZARRO LTDA'),('78553150','7','AGUILERA BUSTAMANTE Y CIA LTDA'),('9225888','2','IVAN BIZAMA DAMKE'),('11567000','K','ISIDORO MUÑOZ BRIONES'),('77835380','6','SAN & GUI CARVAJAL Y CARVAJAL LTDA'),('77118260','7','SCHMIDT Y CIA LTDA'),('78885550','8','PERSONAL COMPUTER FACTORY SA'),('76046123','7','COMER Y DIST ERICA SOTO NARANJO EIRL'),('5825307','3','CARLOS SANDOVAL MALDONADO'),('76147465','0','IMPT DKORA & AMUEBLA  ROMAN CABALLERO C EIRL'),('12491124','9','FREDDY CERNA CORONADO'),('76199938','9','FAMILIA MARDESUEÑOS FABRICA DE MUEBLES LTDA'),('84879700','6','SOC MECANICA EDUARDO ASPILLAGA H Y CIA LTDA'),('79646530','1','EXPORT IMPORT MORANI LTDA'),('15541335','2','CLAUDIO PEREIRA QUEIPUL'),('76064382','3','TELECOMUNICACIONES RICARDO RUBEM EIRL'),('80404100','1','MANUFACTURAS CANNON SA'),('8091646','9','LUIS COLQUE LERICI'),('85644700','6','INVERSIERRA SA'),('89524100','8','COMERCIAL WINDSOR LTDA'),('92017000','5','SOMELA SA'),('76134946','5','ADM DE SUPERMERCADOS EXPRESS LTDA'),('77751990','5','ELECTRONICA KOLM LTDA'),('92854000','6','INDUSTRIA RECUPERADORA DE NEUMATICOS SAC'),('78435150','5','CORVALAN ABEDRAPO LTDA'),('14017226','K','FRANCISCO LAGOS ROCO'),('77991290','6','REVISIONES MAULE LTDA'),('84426200','0','INDUSTRIA TEXTIL SUPREMA LTDA'),('76474780','1','SOCIEDAD COMERCIAL ARTE ANDINO LTDA'),('6120633','7','EDELMIRO NAHUELQUIN GUTIERREZ'),('77925940','4','SOC COM DE NEU LUB REP ACCES Y SERV AUTO BUSTAMANTE LTDA'),('8158986','0','HUMBERTO FUENTES SALGADO'),('6705133','5','RUBEN VALENZUELA MEDINA'),('77982260','5','ALTAMIRANO BUONO CORE HERMANOS LTDA'),('76873770','3','EUGENIO SILVA RAMIREZ EIRL'),('77721980','4','COMERCIAL CQ LTDA'),('77334050','1','COMBUSTIBLES HUIFQUENCO LTDA'),('5972202','6','JOSE CORTES PEREZ'),('96875770','9','REVISIONES TECNICAS SA'),('7134269','7','GLADYS VERGARA CANCINO'),('9518363','8','BERNARDO RIVEROS NUÑEZ'),('78419210','5','EDUARDO LUTFY Y CIA LTDA'),('76245690','7','COMERCIAL AUTOMOTRIZ G Y G LTDA'),('11470178','5','PATRICIO OYANADEL TABILO'),('99528560','6','SOC DE SERVICIOS Y PRODUCTOS AUTOMOTRICES SA'),('96992030','1','SOC CONCESIONARIA VESPUCIO NORTE EXPRESS SA'),('96556940','5','PROVEEDORES INTEGRALES PRISA SA'),('10202098','7','PEDRO GANGA VERA'),('10419434','6','JUAN REYES MONCADA'),('76081334','6','COMERCIAL ITAKURA LTDA'),('53258730','1','SUCESION JORGE URZUA VENEGAS'),('89200200','2','CONFECCIONES SAO PAULO SA'),('9464392','9','PATRICIO FRANCO BAEZA'),('13685636','7','IVAN AGUILERA TOLEDO'),('10704140','0','LUIS GUZMAN SALFATE'),('9198099','1','EDICTO ARENAS POBLETE'),('8406500','5','BEATRIZ MORAN CACERES'),('76161124','0','SOC DE TRANSPORTES QUALITY RENT A CAR LTDA'),('77355970','8','LUIS FLORES Y COMPAÑÍA LTDA'),('8019677','6','DELFIN NEIRA VARGAS'),('7135351','6','NANCY ABURTO ORTEGA'),('6390859','2','JAIME PALACIOS CORNEJO'),('3237471','9','ALFONSO COLLADO VIÑES'),('16070204','4','CRISTIAN ROJAS CASTILLO'),('88347700','6','COMERCIAL E INDUSTRIAL DI TREVI LTDA'),('78399110','1','SOC MONTERO LTDA'),('8218163','6','ANTONIO FERNANDEZ GARAY'),('3078110','4','ENRIQUE PIZARRO GUZMAN'),('9362903','5','MIGUEL OYANEDEL HERNANDEZ'),('77456370','9','SOC ESCOBAR HERMANOS LTDA'),('84831100','6','COMERCIAL ARTIGUES SA'),('77574330','1','SERVICIOS Y TECNOLOGIA LTDA'),('12159040','9','JESSICA AGUILERA GONZALEZ'),('78748930','3','COMERCIAL YONLEY LTDA'),('76112370','K','COMERCIAL SOL Y VALLE LTDA'),('76083098','4','COMERCIAL ECHAURREN LTDA'),('76039636','2','COMERCIAL HUAYU LTDA'),('7957378','7','BERNARDO ESPINOZA CALDERON'),('77428640','3','IMPORT Y EXPORT D Y S LTDA'),('78818900','1','BOZO Y COMPAÑÍA LTDA'),('16104296','K','ROXANA VARGAS ELLIGQUE'),('99585800','2','IMPORT EXPORT Y COMER SEARCH SA'),('77961730','0','COMERCIAL JAIME MARDONES H Y CIA LTDA'),('14053472','2','SOLEDAD TORRES GUERRA'),('9811452','1','VICTOR ARAYA VERGARA'),('6442992','2','ENRIQUE AGUILAR SEITZ'),('9410455','6','REINALDO PEREZ ZULUETA'),('4052233','6','ANTONIO ROZZI AYALA'),('3966247','7','MIGUEL OÑATE COLLADO'),('76692550','2','FRANCISCO DIAZ Y CIA LTDA'),('78098600','K','MARCELO FRONZA Y CIA LTDA'),('78876320','4','SOC COMER SHARPE HNAS LTDA'),('78864230','K','DIST DE PRODUCTOS Y SERVICIOS SALDAÑA Y CIA LTDA'),('76051618','K','COMERCIALIZADORA A & V LTDA'),('4333886','2','JORGE VERA FIERRO'),('76134941','4','ADMIN DE SUPERMERCADOS HIPER LTDA'),('76124915','0','H MOTORES SA'),('99017000','2','RSA SEGUROS CHILE SA'),('76124255','5','COMERCIALIZADORA ROBERTO IBAÑEZ PARRA EIRL'),('96792430','K','SODIMAC SA'),('7178566','1','GRACIELA DE LAS MERCEDES CASTRO DROGUETT'),('13576649','6','LAURA YAÑEZ ROCHA'),('77777060','8','ASIA LINE TRANSPORTES AEREOS Y MARITIMOS LTDA'),('76303540','9','IMPORT Y EXPORT KOREA MULTIMOTRIZ LTDA'),('88610100','7','EDUARDO DIB H Y COMPAÑÍA LTDA'),('14443818','3','RUBEN DANIEL TALLARINO'),('77935650','7','COMERCIAL IMPOGAR LTDA'),('77329980','3','COMERCIAL HYUNKIA LTDA'),('79899310','0','REPUESTOS MAC LTDA'),('8759876','4','HERNAN TRIPAILAF MANQUEHUAL'),('76116435','K','SOCIEDAD COMERCIAL E INVERSIONES LEOLOA SA'),('15072929','7','CLAUDIO VILLALOBOS BARCOS'),('77891770','K','ASIA LINE TRANSPORTES AEREOS Y MARITIMOS LTDA'),('96642610','1','CHUBB DE CHILE CIA DE SEGUROS GENRALES SA'),('99225000','3','ACE SEGUROS SA'),('80992000','3','ULTRAMAR AGENCIA MARITIMA LTDA'),('76083504','8','FERRETERIA AUTOMOTRIZ EL COLOSO EIRL'),('5757071','7','CLAUDIO JEREZ CAMUS'),('88780000','6','TRANSPORTE CASTAÑO LTDA'),('79999300','7','GASTON PIZARRO MAUREIRA Y CIA LTDA'),('96769130','5','SOC INVER ANDES, AGRICOLA, GANADERA E INDUSTRIAL SAC'),('76068115','6','TOP PC COMPUTACION LTDA'),('7174254','7','MIGUEL CORREA VARGAS'),('78286850','0','SOC TRANSPORTES TASSARA Y CIA LTDA'),('77194520','1','AUTO STOCK LIMITADA'),('4083412','5','JUAN CERVA ALMEYDA'),('14525124','9','ALBERTO TOLOZA BUSTAMANTE'),('6488681','9','MARIA FUENTES AREVALO'),('10426188','4','JAIME VARGAS VARGAS'),('77903220','5','MORALES DURAN Y CIA LIMITADA'),('7321509','9','WALDO CASTRO ARANCIBIA'),('5214380','2','JUAN BRAVO NAVARRO'),('76248710','1','NEUMATICOS LIMITADA'),('78815840','8','SOC DE INGENIERIA Y CERTIFICACION DE CALIDAD LTDA'),('76482100','9','EXPLOTACION DE SERVICIOS PMS CHILE LTDA'),('9296894','4','PABLO DAMES BIEGINO'),('78724740','7','SOC IMPORTADORA Y EXPORTADORA ANCO LTDA'),('10352805','4','JOEL LAGUNAS ARDILES'),('78213050','1','MIDDLETON Y COMPAÑÍA LIMITADA'),('50110590','2','BELMAR LANDAETA HNOS LTDA'),('78305030','7','REPUESTOS ZENTENO Y CIA LTDA'),('76549970','4','JESSICA CORREA ALVARADO EIRL'),('3909143','7','IRMA CAVALLIERI VIGNOZZI'),('77194830','8','SOC MADERERA LOS MOLI LTDA'),('79898120','K','UNIVERSAL REPUESTOS TAGUA TAGUA LTDA'),('8792483','1','JUAN ROJAS PONCE'),('5389184','5','FRANZ CATALDO GUERRERO'),('88460200','9','JORGE LARACH Y CIA LTDA'),('7016051','K','ENRIQUE ISAAC NUÑEZ GALLARDO'),('8418743','7','MARIANO ELIECER ABRIGO NAVARRO'),('5345820','3','FERMIN H REYNALDO RODRIGUEZ'),('85232200','4','PATRICIO CARVALLO Y CIA LTDA'),('79848180','0','COMERCIAL AUTOMOTRIZ VIMAE LTDA'),('76202131','5','VTAS Y SERVICIOS JOSE REYES ARAVENA EIRL'),('77130590','3','SOCIEDAD COMERCIAL ESPINOZA Y OLGUIN LTDA'),('7085186','5','GERARDO BARRERA BARRERA'),('88025500','2','VALLEJO Y CIA LTDA'),('76090771','5','COMERCIAL REPUESTOS PEÑA HNOS LTDA'),('79506670','5','PLASTICOS EUROPLAST LTDA'),('76193955','6','COMERCIAL RINGO LTDA'),('9125226','0','ULISES ISAAC DOUSSANG AGUILERA'),('51034020','5','SILVA NOVOA ROBERTO FERNANDO JESUS Y OTRO'),('50858360','5','MENESES PINO ALBERTO LUIS Y OTRO'),('78025820','9','SOCIEDAD COMERCIAL LO VASQUEZ LTDA'),('86457900','0','SERVICIO TECNICO VIÑA DEL MAR LTDA'),('76083730','K','COMERCIALIZADORA LATIN PARTS CHILE LTDA'),('77394570','5','CHELSEA AUTOTECNICA LTDA'),('76017636','2','COMERCIALIZADORA Y DISTRIBUIDORA DEL NORTE LTDA'),('53314063','7','VERA MUÑOZ RAFAEL ALEJANDRO Y OTRO'),('76163593','K','E & R SA'),('8948592','4','GABRIEL ZEPEDA LEON'),('96689970','0','COMPUTACION INTEGRAL SA'),('76042965','1','ORION SEGUROS GENERALES SA'),('76392500','5','COMER Y DIST RUBEN GUERRERO NAVARRO EIRL'),('96566940','K','AGENCIA UNIVERSALES SA'),('96628710','1','CONFECCIONES NACIONALES SA'),('76432810','8','BENEDICTO BUSTOS Y CIA LTDA'),('8071254','5','ALEX VALDES HERRERA'),('77771520','8','IMPORT EXPORT Y COMER CIPRESES LTDA'),('7812492','K','JUAN FELIU VERDUGO'),('2098429','5','NESTOR VALENCIA FUENTES'),('96888000','4','REVISIONES TECNICAS SAN DAMASO SA'),('76199190','6','AUTO TRUCK LIMITADA'),('76859970','K','SOCIEDAD COMERCIAL TECLUBE LTDA'),('10851137','0','GABRIEL OLIVOS MUÑOZ'),('76211240','K','TRANSPORTES, TECNOLOGIA Y GIROS EGT LIMITADA'),('92307000','1','RHONA SA'),('91601000','1','ENLOZADOS CONDOR SA'),('13815876','4','OSCAR AREVALO MORENO'),('8661974','1','JUAN ALTAMIRANO ROJAS'),('92632000','9','ELECTRON SA'),('77606620','6','IMPORT Y COMER PACIFICO LTDA'),('85274100','7','DISTRIBUIDORA BARRERA Y CIA LTDA'),('76801030','7','EMPRESA COMERCIAL CARLOS CAJAS DAZA EIRL'),('96896480','1','REXEL CHILE SA'),('89622400','K','PULLMAN CARGO SA'),('3721296','2','CARLOS CUETO TORO'),('15447667','9','MARJORIE PEREZ IBARRA'),('76013234','9','EMPRESA COMER Y DE TRANSP CAROLINA CHINCON T EIRL'),('76029032','7','SOCIEDAD COMERCIAL TORRERO LTDA'),('76186213','8','COMERCIAL E INVERSIONES SANTA CATALINA LTDA'),('92280000','6','UNIVERSAL REPUESTOS SA'),('6093444','4','MARCELINO SANCHEZ NOGUERA'),('96945400','9','IMPORTADORA COSTABAL Y ECHENIQUE SA'),('76296220','9','COMERCIAL EXPRESS DEL PACIFICO LTDA'),('7598735','8','JOSE TORO LEIVA'),('99577480','1','COMERCIAL MARMICOC SA'),('4006588','1','HUGO KUPERMAN FROIMOVICH'),('82215600','2','RECAUCHAJES INSAMAR LTDA'),('12827571','1','BEATRIZ ARCE ESPINOZA'),('86869400','9','AUTOMOTRIZ Y COMERCIAL LONCOMILLA LTDA'),('77410900','5','IMPORT EXPORT PANAMERICANA LTDA'),('8265044','K','JOSE GARRIDO CACERES'),('76115079','0','COMERCIAL UNILAYS LTDA'),('4327346','9','SERGIO ARAYA FIGUEROA'),('76296478','3','CONTROL DE PLAGAS Y SERV GNRALES JETTYSERVICES EIRL'),('6344328','K','JULIO SANCHEZ OSORIO'),('10243285','1','RENZO FERRADA ALVAREZ'),('11864722','K','JESSICA JIMENEZ RETAMAL'),('78555650','K','COMERCIAL E INVERSIONES LOS TRES ANTONIOS LTDA'),('78818720','3','SOCIEDAD COMERCIAL MIRADOR LTDA'),('76524460','9','GAETE Y DIAZ COMERCIAL Y SERVICIOS LTDA'),('76004297','8','SOCIEDAD COMERCIAL MAS LTDA'),('76122021','7','FERNANDEZ ALVAREZ Y CIA LTDA'),('17948710','1','MAURICIO TORRES SMALL'),('84783300','9','MATECO LTDA'),('9591500','0','ERIKA ZAPATA MARABOLI'),('76035100','8','COMERCIAL UBILLA DAZA LTDA'),('4310599','K','LUIS MORENO ROMAN'),('11172969','7','ROSALINDA REYES VARGAS'),('8939062','1','BLANCA NAVARRO NAVARRO'),('8382743','2','GERALDO ALCAYAGA OLIVARES'),('99501180','8','SAVINO DEL BENE CHILE SA'),('76058494','0','ABRAHAM MARTINEZ SALAZAR INGENIERIA Y CONSTRUCCION EIRL'),('12621482','0','KATTERINNE LOBOS LOBOS'),('76248698','9','RAMON VILOS ORTIZ LUBRICENTRO EIRL'),('76027394','5','REPUESTOS REPAJ LIMITADA'),('76142101','8','SERV AUTOMOTRICES JUANTOBORGA PEREZ EIRL'),('4832819','9','RENE CARRIZO PEREZ'),('12821769','K','ENRIQUE PIZARRO BAHAMONDES'),('8771638','4','PATRICIO CRISOSTOMO SANCHEZ'),('96705640','5','EMPRESA EL MERCURIO DE VALPARAISO SAP'),('76676820','2','IDETEX SA'),('77232300','K','RAMELLI Y OTRO LTDA'),('76291284','8','ANDRADE Y ASTUDILLO LTDA'),('76104908','9','SEGURA REPUESTOS LTDA'),('8321138','5','LUIS CHANDIA BARRIA')-->