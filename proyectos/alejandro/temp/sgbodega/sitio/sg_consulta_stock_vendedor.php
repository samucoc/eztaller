<?php
session_start();

require_once 'includes/xajax/xajax.inc.php'; //archivo de configuracion de ajax
include "../includes/php/conf_smarty.php";//archivo de configuracion de smarty
include "../includes/php/conf_bd.php"; //archivo de coneccion al servidor y base de datos
//include "../includes/php/conf_bd_antigua.php"; //archivo de coneccion al servidor de yonley
include "../includes/php/validaciones.php"; 

$xajax = new xajax();

$xajax->setRequestURI("sg_consulta_stock_vendedor.php");
$xajax->setCharEncoding("ISO-8859-1");
$xajax->decodeUTF8InputOn();

function Grabar($data){
	global $conexion;
	global $miSmarty;
	
 	set_time_limit(10000);
	
	$objResponse = new xajaxResponse('ISO-8859-1');
	
	$fecha_desde		= 	$data["txtFechaDesde"];
	$fecha_hasta		= 	$data["OBLI-txtFechaHasta"]; //date("d-m-Y");
	$cobrador			= 	$data["OBLI-txtCodCobrador"];
	$nombre_cobrador	= 	$data["OBLI-txtDescCobrador"];
	$empresa 			= 	$data["OBLI-cboEmpresa"];
	$ult_guia 			= 	$data["txtUltGuia"];
	$cod_poducto		=	$data["txtCodProducto"];
	$desc_poducto		=	$data["txtDescProducto"];
	$filtro				=	$data["cboFiltro"];
	$arrRegistros		= 	array();
	$arrRegistrosRev	=	array();
	$i 					= 	1;
	$TOTAL_INICIAL_N	=	0;
	$TOTAL_INICIAL_U	=	0;
	$TOTAL_AUMENTOS_N	=	0;
	$TOTAL_AUMENTOS_U	=	0;
	$TOTAL_VENTAS_N		=	0;
	$TOTAL_VENTAS_U		=	0;
	$TOTAL_REBAJAS_N	=	0;
	$TOTAL_REBAJAS_U	=	0;
	$TOTAL_NULAS_N		=	0;
	$TOTAL_NULAS_U		=	0;
	$TOTAL_ACTUAL_N		=	0;
	$TOTAL_ACTUAL_U		=	0;
	
	if (trim($ult_guia) == ''){
		$objResponse->addScript("alert('El Vendedor No Tiene Guía Inicial')");
	}else{
	
		$sql_emp = "select empe_desc from sgyonley.empresas where empe_rut = '".$empresa."'";
		$res_emp = mysql_query($sql_emp, $conexion);
		$nombre_empresa = @mysql_result($res_emp, 0, "empe_desc");
		
		$objResponse->addScript("document.getElementById('divlistado').style.display='none';");
		
		list($dia1,$mes1,$anio1) = split('[/.-]', $fecha_desde);$fecha1 	= $anio1."-".$mes1."-".$dia1;
		list($dia2,$mes2,$anio2) = split('[/.-]', $fecha_hasta);$fecha2 	= $anio2."-".$mes2."-".$dia2;

		if (($cod_poducto != '') && ($desc_poducto != '')){
			// busca el ta_codigo
			$sql_codigo 	= 	"select ta_codigo from sgbodega.tallasnew where ta_ncorr = '".$cod_poducto."'";
			$res_codigo 	= 	mysql_query($sql_codigo, $conexion);
			$and 			=	" and bv_codbus = '".@mysql_result($res_codigo, 0, "ta_codigo")."'";
		}
		
		// busca todos los productos del vendedor
		// se quita el filtro por empresa (bv_empresa = '".$empresa."')
		$sql_pd = "select 
					bv_codbus as codigo_largo,
					bv_glosa as descripcion,
					bv_valornuevo as valor_nuevo,
					bv_valorusado as valor_usado
					
					from 
					sgbodega.bodvendedor
					
					where
					bv_vendedor = '".$cobrador."' and bv_codbus != ''
					$and
					
					group by bv_codbus";
		
		//$sql_pd = "select sg_codbus, sg_glosa, sg_valornuevo, sg_valorusado from sgbodega.subgdcontrol
		//			where sg_numero = '".$ult_guia."' and sg_empresa = '".$empresa."' and sg_vendedor = '".$cobrador."'";
		
		$res_pd = mysql_query($sql_pd, $conexion);
		if (mysql_num_rows($res_pd) > 0){
			$productos_no_encontrados = "";
			
			/*
			$sql_del = "delete from verifica_guia_bodvendedor where vgui_guia = '".$ult_guia."'";
			$res_del = mysql_query($sql_del, $conexion);
			*/
			
			while ($line_pd = mysql_fetch_row($res_pd)) {
				
				//busca el ncorr del producto
				$codigo_antiguo 	= 	$line_pd[0];
				
				$sql_ncorr 			= 	"select ta_ncorr, ta_familia, ta_subfamilia from sgbodega.tallasnew where ta_codigo = '".$line_pd[0]."' order by ta_ncorr desc limit 1";
				$res_ncorr 			= 	mysql_query($sql_ncorr, $conexion);
				$codigo				=	@mysql_result($res_ncorr,0,"ta_ncorr");
				$familia			=	@mysql_result($res_ncorr,0,"ta_familia");
				$subfamilia			=	@mysql_result($res_ncorr,0,"ta_subfamilia");
				
				/*
				if (@mysql_num_rows($res_ncorr) < 1){
					$sql_ncorr 			= 	"select ta_ncorr, ta_familia, ta_subfamilia from sgbodega.tallasnew where ta_ncorr = '".$line_pd[0]."' order by ta_ncorr desc limit 1";
					$res_ncorr 			= 	mysql_query($sql_ncorr, $conexion);
				}
				*/
				
				/*
				$sql_cod = "select ta_codigo, ta_familia, ta_subfamilia from sgbodega.tallasnew where ta_ncorr = '".$line_pd[0]."'";
				$res_cod = mysql_query($sql_cod, $conexion);
				$codigo				=	@mysql_result($res_cod,0,"ta_codigo");
				$familia			=	@mysql_result($res_cod,0,"ta_familia");
				$subfamilia			=	@mysql_result($res_cod,0,"ta_subfamilia");
				*/
				
				
				/*
				}else{
					$sql_ncorr 			= 	"select ta_ncorr, ta_familia, ta_subfamilia from sgbodega.tallasnew where ta_ncorr = '".$line_pd[0]."' order by ta_ncorr desc limit 1";
					$res_ncorr 			= 	mysql_query($sql_ncorr, $conexion);
					$codigo				=	@mysql_result($res_ncorr,0,"ta_ncorr");
					$familia			=	@mysql_result($res_ncorr,0,"ta_familia");
					$subfamilia			=	@mysql_result($res_ncorr,0,"ta_subfamilia");
				}		
				*/
				
				$inicial_n 			= 	0;
				$inicial_u 			= 	0;
				$aumentos_n 		= 	0;
				$aumentos_u 		= 	0;
				$aumentos_nb 		= 	0;
				$aumentos_ub 		= 	0;
				$ventas_n 			= 	0;
				$ventas_u 			= 	0;
				$ventasnew_n 		= 	0;
				$ventasnew_u 		= 	0;
				$dv_nuevo 			= 	0;
				$dv_usado 			= 	0;
				$nulas_n 			= 	0;
				$nulas_u 			= 	0;
				$actual_n 			= 	0;
				$actual_u 			= 	0;
				
				if ($codigo != ''){
					
					/*
					//inserta en la tabla para verificar guia v/s bodvendedor
					$sql_veri = "insert into verifica_guia_bodvendedor (vgui_guia,vgui_cod,vgui_desc) values 
								('".$ult_guia."','".$codigo."','".$line_pd[1]."')";
					$res_veri = mysql_query($sql_veri,$conexion);
					*/
					
					//busca familia
						$sql_f = "select fa_nombre from sgbodega.familias where fa_codigo = '".$familia."'";
						$res_f = mysql_query($sql_f, $conexion);
						$familia = @mysql_result($res_f,0,"fa_nombre");
					//fin
					
					//busca subfamilia
						$sql_sf = "select sf_nombre from sgbodega.subfamilias where sf_subcodigo = '".$subfamilia."'";
						$res_sf = mysql_query($sql_sf, $conexion);
						$subfamilia = @mysql_result($res_sf,0,"sf_nombre");
					//fin
					
					// busca el stock inicial de la ultima guia y el codigo
						$sql_sguia = "select sg_stocknuevo as inicial_n, sg_stockusado as inicial_u from sgbodega.subgdcontrol 
										where sg_numero = '".$ult_guia."' and sg_codbus = '".$codigo."'";
						$res_sguia = mysql_query($sql_sguia, $conexion);
						$inicial_n = @mysql_result($res_sguia, 0, "inicial_n");
						$inicial_u = @mysql_result($res_sguia, 0, "inicial_u");
						$TOTAL_INICIAL_N = $TOTAL_INICIAL_N + $inicial_n;
						$TOTAL_INICIAL_U = $TOTAL_INICIAL_U + $inicial_u;
					//fin

/////////// SE SACA EL FILTRO POR EMPRESA 08/10/2010(b.empe_rut = '".$empresa."')				
					
					//busca los aumentos en el periodo (movim 2)
						$sql_saumentos 	= "select a.mdet_nu as nu, a.mdet_cantidad as cantidad
											from 
											sgbodega.movim_detalle a, sgbodega.movim b
											
											where
											a.mdet_codigo = '".$codigo."' and
											a.movim_ncorr = b.movim_ncorr and
											b.movim_tipo = '2' and
											b.vend_ncorr = '".$cobrador."' and
											b.empe_rut = '".$empresa."' and
											b.movim_fecha >= '".$fecha1."' and b.movim_fecha <= '".$fecha2."' and
											b.movim_estado = 'FINALIZADO'";
						$res_saumentos 	= 	mysql_query($sql_saumentos, $conexion);
						$aumentos_n 	= 	0;
						$aumentos_u 	= 	0;
						while ($line_saumentos = mysql_fetch_row($res_saumentos)) {
							$nu 		= 	$line_saumentos[0];
							$cantidad	= 	$line_saumentos[1];
						
							if ($nu == 'N'){
								$aumentos_n 	= 	$aumentos_n + $cantidad;
							}
							if ($nu == 'U'){
								$aumentos_u 	= 	$aumentos_u + $cantidad;
							}
						}
						$TOTAL_AUMENTOS_N = $TOTAL_AUMENTOS_N + $aumentos_n;
						$TOTAL_AUMENTOS_U = $TOTAL_AUMENTOS_U + $aumentos_u;
					//fin
					
					//busca los aumentos que hace existencia (movim 6)
						$sql_aum_exis 	= "select a.mdet_nu as nu, a.mdet_cantidad as cantidad
											from 
											sgbodega.movim_detalle a, sgbodega.movim b
											
											where
											a.mdet_codigo = '".$codigo."' and
											a.movim_ncorr = b.movim_ncorr and
											b.movim_tipo = '6' and
											b.vend_ncorr = '".$cobrador."' and
											b.empe_rut = '".$empresa."' and
											b.movim_fecha >= '".$fecha1."' and b.movim_fecha <= '".$fecha2."' and
											b.movim_estado = 'FINALIZADO'";
						$res_aum_exis 	= 	mysql_query($sql_aum_exis, $conexion);
						$aumentos_nb 	= 	0;
						$aumentos_ub 	= 	0;
						while ($line_aum_exis = mysql_fetch_row($res_aum_exis)) {
							$nu 		= 	$line_aum_exis[0];
							$cantidad	= 	$line_aum_exis[1];
						
							if ($nu == 'N'){
								$aumentos_nb 	= 	$aumentos_nb + $cantidad;
							}
							if ($nu == 'U'){
								$aumentos_ub 	= 	$aumentos_ub + $cantidad;
							}
						}
						
						$TOTAL_AUMENTOS_N = $TOTAL_AUMENTOS_N + $aumentos_nb;
						$TOTAL_AUMENTOS_U = $TOTAL_AUMENTOS_U + $aumentos_ub;
					//fin
						
						//busca las rebajas por ventas (ventas nuevas)
						$sql_ventasnew 	= "select a.arti_nu as nu, a.vent_cant as cantidad, a.arti_codigo_largo as codigo_largo, b.vent_estado_ingreso
											from 
											sgyonley.ventas_detalle_antigua a, sgyonley.ventas_antigua b
											
											where
											a.arti_codigo_largo = '".$codigo."' and
											a.vent_ncorr = b.vent_num_folio and
											b.vent_estado_ingreso <> 'PV' and 
											b.vend_ncorr = '".$cobrador."' and
											b.empe_rut = '".$empresa."' and
											b.vent_fecha >= '".$fecha1."' and b.vent_fecha <= '".$fecha2."' and
											b.vent_estado = 'FINALIZADA'";
											
						$res_ventasnew 	= 	mysql_query($sql_ventasnew, $conexion);
						$ventasnew_n 	= 	0;
						$ventasnew_u 	= 	0;
						while ($line_ventasnew = mysql_fetch_row($res_ventasnew)) {
							
							if (trim($line_ventasnew[3]) == ''){$estado_venta 	= 	'ACTIVA';}
							if ($line_ventasnew[3] == 'A'){$estado_venta 	= 	'POR APROBAR';}	//#00CC00
							if ($line_ventasnew[3] == 'N'){$estado_venta 	= 	'NULA';}			//#FF0000
							if ($line_ventasnew[3] == 'B'){$estado_venta 	= 	'DE BAJA';}		//#FF99CC
							if ($line_ventasnew[3] == 'D'){$estado_venta 	= 	'DEVOLUCION';}	//#FF9900
							if ($line_ventasnew[3] == 'P'){$estado_venta 	= 	'PAGADA';}		//#0066FF
							
							if ($estado_venta != 'POR APROBAR' && $estado_venta != 'NULA' ){
							//if ($estado_venta = 'ACTIVA'){
								$nu 		= 	$line_ventasnew[0];
								$cantidad	= 	$line_ventasnew[1];
							
								if ($nu == 'N'){
									$ventasnew_n 	= 	$ventasnew_n + $cantidad;
								}
								if ($nu == 'U'){
									$ventasnew_u 	= 	$ventasnew_u + $cantidad;
								}
							}
						}
						$TOTAL_VENTAS_N = $TOTAL_VENTAS_N + $ventasnew_n;
						$TOTAL_VENTAS_U = $TOTAL_VENTAS_U + $ventasnew_u;
					//FIN
					
					//busca las devoluciones de vendedor en el periodo (movim 4) rebajas por devoluciones de vendedor
						$dv_nuevo = 0;
						$dv_usado = 0;
						$sql_dev 	= "select a.mdet_nu as nu, a.mdet_cantidad as cantidad
											from 
											sgbodega.movim_detalle a, sgbodega.movim b
											
											where
											a.mdet_codigo = '".$codigo."' and
											a.movim_ncorr = b.movim_ncorr and
											b.movim_tipo = '4' and
											b.vend_ncorr = '".$cobrador."' and
											b.empe_rut = '".$empresa."' and
											b.movim_fecha >= '".$fecha1."' and b.movim_fecha <= '".$fecha2."' and
											b.movim_estado = 'FINALIZADO'";
						$res_dev 	= 	mysql_query($sql_dev, $conexion);
						//$objResponse->addAlert($sql_dev);
						while ($line_dev = mysql_fetch_row($res_dev)) {
							$nu 		= 	$line_dev[0];
							$cantidad	= 	$line_dev[1];
						
							if ($nu == 'N'){
								$dv_nuevo 	= 	$dv_nuevo + $cantidad;
							}
							if ($nu == 'U'){
								$dv_usado 	= 	$dv_usado + $cantidad;
								
							}
						}
						$TOTAL_REBAJAS_N = $TOTAL_REBAJAS_N + $dv_nuevo;
						$TOTAL_REBAJAS_U = $TOTAL_REBAJAS_U + $dv_usado;
					//fin
					
					//busca las rebajas de vendedor en el periodo (movim 10) rebajas por devoluciones de vendedor
						$re_nuevo = 0;
						$re_usado = 0;
						$sql_dev 	= "select a.mdet_nu as nu, a.mdet_cantidad as cantidad
											from 
											sgbodega.movim_detalle a, sgbodega.movim b
											
											where
											a.mdet_codigo = '".$codigo."' and
											a.movim_ncorr = b.movim_ncorr and
											b.movim_tipo = '10' and
											b.vend_ncorr = '".$cobrador."' and
											b.empe_rut = '".$empresa."' and
											b.movim_fecha >= '".$fecha1."' and b.movim_fecha <= '".$fecha2."' and
											b.movim_estado = 'FINALIZADO'";
						$res_dev 	= 	mysql_query($sql_dev, $conexion);
						//$objResponse->addAlert($sql_dev);
						while ($line_dev = mysql_fetch_row($res_dev)) {
							$nu 		= 	$line_dev[0];
							$cantidad	= 	$line_dev[1];
						
							if ($nu == 'N'){
								$re_nuevo 	= 	$re_nuevo + $cantidad;
							}
							if ($nu == 'U'){
								$re_usado 	= 	$re_usado + $cantidad;
								
							}
						}
						$TOTAL_REBAJAS_N = $TOTAL_REBAJAS_N - $re_nuevo;
						$TOTAL_REBAJAS_U = $TOTAL_REBAJAS_U - $re_usado;
					//fin
					
					//busca las ventas nulas
						$sql_nulas 	= "select a.arti_nu as nu, a.vent_cant as cantidad
											from 
											sgyonley.ventas_detalle_antigua a, sgyonley.ventas_antigua b
											
											where
											a.arti_codigo_largo = '".$codigo."' and
											a.vent_ncorr = b.vent_num_folio and
											b.vend_ncorr = '".$cobrador."' and
											b.empe_rut = '".$empresa."' and
											b.vent_fecha >= '".$fecha1."' and b.vent_fecha <= '".$fecha2."' and
											b.vent_estado = 'FINALIZADA' and
											b.vent_estado_ingreso = 'N'";
						$res_nulas 	= 	mysql_query($sql_nulas, $conexion);
						$nulas_n 	= 	0;
						$nulas_u 	= 	0;
						while ($line_nulas = mysql_fetch_row($res_nulas)) {
							$nu 		= 	$line_nulas[0];
							$cantidad	= 	$line_nulas[1];
						
							if ($nu == 'N'){
								$nulas_n 	= 	$nulas_n + $cantidad;
							}
							if ($nu == 'U'){
								$nulas_u 	= 	$nulas_u + $cantidad;
							}
						}
						$TOTAL_NULAS_N = $TOTAL_NULAS_N + $nulas_n;
						$TOTAL_NULAS_U = $TOTAL_NULAS_U + $nulas_u;
					//FIN
					
					$actual_n = $inicial_n + $aumentos_n + $aumentos_nb - $ventasnew_n - $ventas_n - $dv_nuevo - $re_nuevo;
					$actual_u = $inicial_u + $aumentos_u + $aumentos_ub - $ventasnew_u - $ventas_u - $dv_usado - $re_usado;
					
					$TOTAL_ACTUAL_N = $TOTAL_ACTUAL_N + $actual_n;
					$TOTAL_ACTUAL_U = $TOTAL_ACTUAL_U + $actual_u;
					
					$aumentos_n = $aumentos_n + $aumentos_nb;
					$aumentos_u = $aumentos_u + $aumentos_ub;
					
					$ventas_n = $ventas_n + $ventasnew_n;
					$ventas_u = $ventas_u + $ventasnew_u;
				}
				
					//$desc 	= 	str_replace('"', '', $line_pd[1]);
				$desc = 	$line_pd[1];
				//if ($codigo != ''){
				
					if ($filtro == '1'){
						array_push($arrRegistros, array("item"				=>	$i,
														"familia"			=>	$familia,
														"subfamilia"		=>	$subfamilia,
														"codigo" 			=> 	$codigo,
														"descripcion" 		=> 	$desc,
														"valor_n" 			=> 	$line_pd[2],
														"valor_u" 			=> 	$line_pd[3],
														"inicial_n"			=> 	$inicial_n,
														"inicial_u" 		=> 	$inicial_u,
														"aumentos_n" 		=> 	$aumentos_n,
														"aumentos_u" 		=> 	$aumentos_u,
														"ventas_n" 			=> 	$ventas_n,
														"ventas_u" 			=> 	$ventas_u,
														"rebajas_n" 		=> 	$dv_nuevo,
														"rebajas_u" 		=> 	$dv_usado,
														"nulas_n" 			=> 	$nulas_n,
														"nulas_u" 			=> 	$nulas_u,
														"actual_n" 			=> 	$actual_n,
														"actual_u"			=> 	$actual_u));
						$i++;
						
						// arreglo p/revision
						array_push($arrRegistrosRev, array("item"				=>	$i,
															"codigo" 			=> 	$codigo,
															"descripcion" 		=> 	$line_pd[1],
															"valor" 			=> 	$line_pd[2],
															"stock_nuevo"		=> 	$actual_n,
															"dv_nuevo" 			=> 	0,
															"stock_usado"		=> 	$actual_u,
															"dv_usado" 			=> 	0));
						$i++;
					}
					if ($filtro == '2'){
						if (($actual_n != 0) OR ($actual_u != 0)){
							array_push($arrRegistros, array("item"				=>	$i,
															"familia"			=>	$familia,
															"subfamilia"		=>	$subfamilia,
															"codigo" 			=> 	$codigo,
															"descripcion" 		=> 	$desc,
															"valor_n" 			=> 	$line_pd[2],
															"valor_u" 			=> 	$line_pd[3],
															"inicial_n"			=> 	$inicial_n,
															"inicial_u" 		=> 	$inicial_u,
															"aumentos_n" 		=> 	$aumentos_n,
															"aumentos_u" 		=> 	$aumentos_u,
															"ventas_n" 			=> 	$ventas_n,
															"ventas_u" 			=> 	$ventas_u,
															"rebajas_n" 		=> 	$dv_nuevo,
															"rebajas_u" 		=> 	$dv_usado,
															"nulas_n" 			=> 	$nulas_n,
															"nulas_u" 			=> 	$nulas_u,
															"actual_n" 			=> 	$actual_n,
															"actual_u"			=> 	$actual_u));
							$i++;
							
							// arreglo p/revision
							array_push($arrRegistrosRev, array("item"				=>	$i,
																"codigo" 			=> 	$codigo,
																"descripcion" 		=> 	$line_pd[1],
																"valor" 			=> 	$line_pd[2],
																"stock_nuevo"		=> 	$actual_n,
																"dv_nuevo" 			=> 	0,
																"stock_usado"		=> 	$actual_u,
																"dv_usado" 			=> 	0));
							$i++;
						}
					}
					
				//}
			}
			
			/*
			$sql_in = "select sum(sg_stocknuevo) as inicial_n, sum(sg_stockusado) as inicial_u from sgbodega.subgdcontrol where sg_numero = '".$ult_guia."'";
			$res_in = mysql_query($sql_in,$conexion);
			$TOTAL_INICIAL_N = @mysql_result($res_in,0,"inicial_n");
			$TOTAL_INICIAL_U = @mysql_result($res_in,0,"inicial_u");
			*/
			
			//$sql_iu = "select sum(sg_stockusado) as inicial_u from sgbodega.subgdcontrol where sg_numero = '".$ult_guia."'";
			//$res_iu = mysql_query($sql_iu,$conexion);
			//$TOTAL_INICIAL_U = @myql_result($res_in,0,"inicial_u");
			
			// SE ANULA ESTE PROCEDIMIENTO 19112010
			/*
			//segun la ultima guia inicial verifico cuales son los codigos que estan en la guia y no estan en la bodega vendedor
			$sql_gbod = "select sg_codbus, sg_glosa from sgbodega.subgdcontrol where sg_numero = '".$ult_guia."'";
			$res_gbod = mysql_query($sql_gbod,$conexion);
			while ($line_gbod = mysql_fetch_row($res_gbod)) {
				$codigo 		= 	$line_gbod[0];
				$descripcion	= 	$line_gbod[1];
				
				$sql_veri = "select vgui_ncorr from verifica_guia_bodvendedor where vgui_guia = '".$ult_guia."' and vgui_cod = '".$codigo."'";
				$res_veri = mysql_query($sql_veri,$conexion);
				if (@mysql_num_rows($res_veri) <= 0){
					$productos_no_encontrados .= " -- ".$codigo." ".$descripcion;
				}
			}
			*/
			
			// asigno las sesiones para el ordenamiento
			$_SESSION["alycar_matriz"] 				= 	$arrRegistros;
			$_SESSION["alycar_matriz_rev"] 			= 	$arrRegistrosRev;
			$_SESSION["alycar_desde"] 				= 	$fecha_desde;
			$_SESSION["alycar_hasta"] 				= 	$fecha_hasta;
			$_SESSION["alycar_empresa"] 			= 	$empresa;
			$_SESSION["alycar_nombre_empresa"]		= 	$nombre_empresa;
			$_SESSION["alycar_cobrador"] 			= 	$cobrador." ".$nombre_cobrador;
			$_SESSION["alycar_ultguia"] 			= 	$ult_guia." (".$fecha_desde.") ";
			$_SESSION["alycar_total_inicial_n"] 	= 	$TOTAL_INICIAL_N;
			$_SESSION["alycar_total_inicial_u"] 	= 	$TOTAL_INICIAL_U;
			$_SESSION["alycar_total_aumentos_n"] 	= 	$TOTAL_AUMENTOS_N;
			$_SESSION["alycar_total_aumentos_u"] 	= 	$TOTAL_AUMENTOS_U;
			$_SESSION["alycar_total_ventas_n"] 		= 	$TOTAL_VENTAS_N;
			$_SESSION["alycar_total_ventas_u"] 		= 	$TOTAL_VENTAS_U;
			$_SESSION["alycar_total_rebajas_n"] 	= 	$TOTAL_REBAJAS_N;
			$_SESSION["alycar_total_rebajas_u"] 	= 	$TOTAL_REBAJAS_U;
			$_SESSION["alycar_total_nulas_n"] 		= 	$TOTAL_NULAS_N;
			$_SESSION["alycar_total_nulas_u"] 		= 	$TOTAL_NULAS_U;
			$_SESSION["alycar_total_actual_n"] 		= 	$TOTAL_ACTUAL_N;
			$_SESSION["alycar_total_actual_u"] 		= 	$TOTAL_ACTUAL_U;
			
			$miSmarty->assign('DESDE', $fecha_desde);
			$miSmarty->assign('HASTA', $fecha_hasta);
			$miSmarty->assign('EMPRESA', $nombre_empresa);
			$miSmarty->assign('COBRADOR', $cobrador." ".$nombre_cobrador);
			$miSmarty->assign('ULTGUIA', $ult_guia." (".$fecha_desde.") ");
			$miSmarty->assign('TOTAL_INICIAL_N', $TOTAL_INICIAL_N);
			$miSmarty->assign('TOTAL_INICIAL_U', $TOTAL_INICIAL_U);
			$miSmarty->assign('TOTAL_AUMENTOS_N', $TOTAL_AUMENTOS_N);
			$miSmarty->assign('TOTAL_AUMENTOS_U', $TOTAL_AUMENTOS_U);
			$miSmarty->assign('TOTAL_VENTAS_N', $TOTAL_VENTAS_N);
			$miSmarty->assign('TOTAL_VENTAS_U', $TOTAL_VENTAS_U);
			$miSmarty->assign('TOTAL_REBAJAS_N', $TOTAL_REBAJAS_N);
			$miSmarty->assign('TOTAL_REBAJAS_U', $TOTAL_REBAJAS_U);
			$miSmarty->assign('TOTAL_NULAS_N', $TOTAL_NULAS_N);
			$miSmarty->assign('TOTAL_NULAS_U', $TOTAL_NULAS_U);
			$miSmarty->assign('TOTAL_ACTUAL_N', $TOTAL_ACTUAL_N);
			$miSmarty->assign('TOTAL_ACTUAL_U', $TOTAL_ACTUAL_U);
			
			$miSmarty->assign('arrRegistros', $arrRegistros);
			$miSmarty->assign('arrRegistrosRev', $arrRegistrosRev);
			
			$objResponse->addScript("xajax_OrdenarRevision(xajax.getFormValues('Form1'), 'descripcion');");
			$objResponse->addScript("xajax_Ordenar(xajax.getFormValues('Form1'), 'familia');");
			
			//$objResponse->addAssign("divabonos", "innerHTML", $miSmarty->fetch('sg_existencia_movimientos_vendedor_list.tpl'));
			if ($productos_no_encontrados != ''){
				$objResponse->addAssign("divnoencontrados", "innerHTML", "Estos Productos Están en la Ult. Guia Inicial y no figuran en este listado, posiblemente fueron eliminados: ".$productos_no_encontrados);
			}
			
		}else{
			
			$objResponse->addAssign("divabonos", "innerHTML", "No Existen Registros");
		}
	}
	
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
	
	$miSmarty->assign('DESDE', $_SESSION["alycar_desde"]);
	$miSmarty->assign('HASTA', $_SESSION["alycar_hasta"]);
	$miSmarty->assign('EMPRESA', $_SESSION["alycar_nombre_empresa"]);
	$miSmarty->assign('COBRADOR', $_SESSION["alycar_cobrador"]);
	$miSmarty->assign('ULTGUIA', $_SESSION["alycar_ultguia"]);
	
	$miSmarty->assign('TOTAL_INICIAL_N', $_SESSION["alycar_total_inicial_n"]);
	$miSmarty->assign('TOTAL_INICIAL_U', $_SESSION["alycar_total_inicial_u"]);
	$miSmarty->assign('TOTAL_AUMENTOS_N', $_SESSION["alycar_total_aumentos_n"]);
	$miSmarty->assign('TOTAL_AUMENTOS_U', $_SESSION["alycar_total_aumentos_u"]);
	$miSmarty->assign('TOTAL_VENTAS_N', $_SESSION["alycar_total_ventas_n"]);
	$miSmarty->assign('TOTAL_VENTAS_U', $_SESSION["alycar_total_ventas_u"]);
	$miSmarty->assign('TOTAL_REBAJAS_N', $_SESSION["alycar_total_rebajas_n"]);
	$miSmarty->assign('TOTAL_REBAJAS_U', $_SESSION["alycar_total_rebajas_u"]);
	$miSmarty->assign('TOTAL_NULAS_N', $_SESSION["alycar_total_nulas_n"]);
	$miSmarty->assign('TOTAL_NULAS_U', $_SESSION["alycar_total_nulas_u"]);
	$miSmarty->assign('TOTAL_ACTUAL_N', $_SESSION["alycar_total_actual_n"]);
	$miSmarty->assign('TOTAL_ACTUAL_U', $_SESSION["alycar_total_actual_u"]);
	
	$miSmarty->assign('arrRegistros', $arrRegistros);
	$objResponse->addAssign("divabonos", "innerHTML", $miSmarty->fetch('sg_consulta_stock_vendedor_list.tpl'));
	
	return $objResponse->getXML();
}

function OrdenarRevision($data, $campo){
	global $conexion;
	global $miSmarty;
	
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	$orden_asc 	= 'ASC';
	$orden_desc = 'DESC';
	
	/*
	if ($_SESSION["alycar_orden"] == $campo.$orden_asc){
		$campo_orden 		= 	$campo.$orden_desc;
		$direccion_orden	=	$orden_desc;
	}else{
		$campo_orden 		= 	$campo.$orden_asc;
		$direccion_orden	=	$orden_asc;
	}		
	*/
	
	$campo_orden 		= 	$campo.$orden_asc;
	$direccion_orden	=	$orden_asc;
	
	$arrRegistrosRev = array();
	$arrRegistrosRev = ordenar_matriz_multidimensionada($_SESSION["alycar_matriz_rev"],$campo,$direccion_orden);
	$_SESSION["alycar_orden"] = $campo_orden;
	
	$miSmarty->assign('DESDE', $_SESSION["alycar_desde"]);
	$miSmarty->assign('HASTA', $_SESSION["alycar_hasta"]);
	$miSmarty->assign('EMPRESA', $_SESSION["alycar_nombre_empresa"]);
	$miSmarty->assign('COBRADOR', $_SESSION["alycar_cobrador"]);
	$miSmarty->assign('ULTGUIA', $_SESSION["alycar_ultguia"]);
	
	$miSmarty->assign('arrRegistrosRev', $arrRegistrosRev);
	$objResponse->addAssign("divrevision", "innerHTML", $miSmarty->fetch('sg_consulta_stock_vendedor_revision_list.tpl'));
	
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
	
	$ncorr 		= 	$data["$objeto1"];
	
	if ($tabla != 'sgbodega.tallasnew'){
		
		$sql = "select $campo2 as descripcion from sgyonley.$tabla where $campo1 = '".$ncorr."' $and";
		
		$res = mysql_query($sql, $conexion);
		
		$objResponse->addScript("xajax_BuscaUltGuia(xajax.getFormValues('Form1'))");
		
		$objResponse->addAssign("$objeto2", "value", @mysql_result($res,0,"descripcion"));
	}else{
		$sql = "select ta_ncorr, ta_descripcion, ta_busqueda, ta_venta from $tabla where $campo1 = '".$ncorr."'";
		$res = mysql_query($sql, $conexion);
		
		$objResponse->addAssign("txtDescProducto", "value", @mysql_result($res,0,"ta_busqueda")." ".@mysql_result($res,0,"ta_descripcion"));
	}	
	
	return $objResponse->getXML();
}

function BuscaUltGuia($data){
    global $conexion;
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	$vendedor			= 	$data["OBLI-txtCodCobrador"];
	$empresa 			= 	$data["OBLI-cboEmpresa"];
	
	$sql = "select 
				b.gd_numero as numero,
				DATE_FORMAT(b.gd_fecha,'%d/%m/%Y') as fecha		
				
				from 
				sgbodega.subgdcontrol a, sgbodega.gdcontrol b
				
				where 
				a.sg_empresa = '".$empresa."' and a.sg_vendedor = '".$vendedor."' and
				a.sg_numero  = b.gd_numero and
				b.gd_estado  = 'FINALIZADA'
				
				order by b.gd_numero desc limit 1";
	
	$res = mysql_query($sql, $conexion);
	
	$objResponse->addAssign("txtUltGuia", "value", @mysql_result($res,0,"numero"));
	$objResponse->addAssign("txtFechaDesde", "value", @mysql_result($res,0,"fecha"));
				
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
	
	$objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'OBLI-cboEmpresa','sgyonley.empresas','','- - Seleccione - -','empe_rut', 'empe_desc', '')");
	$objResponse->addScript("document.getElementById('OBLI-cboEmpresa').focus();");

	return $objResponse->getXML();
}
     
function LlamaDetalle($data, $codigo, $descripcion){
    global $conexion;
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	$fecha_desde		= 	$data["txtFechaDesde"];
	$fecha_hasta		= 	$data["OBLI-txtFechaHasta"]; //date("d-m-Y");
	$cobrador			= 	$data["OBLI-txtCodCobrador"];
	$nombre_cobrador	= 	$data["OBLI-txtDescCobrador"];
	$empresa 			= 	$data["OBLI-cboEmpresa"];
	$ult_guia 			= 	$data["txtUltGuia"];
	
	list($dia1,$mes1,$anio1) = split('[/.-]', $fecha_desde);	$fecha1 = $anio1."-".$mes1."-".$dia1;
	list($dia2,$mes2,$anio2) = split('[/.-]', $fecha_hasta);	$fecha2 = $anio2."-".$mes2."-".$dia2;
	
	$objResponse->addScript("showPopWin('sg_existencia_movimientos_vendedor_detalle.php?codigo=$codigo&descripcion=$descripcion&fecha1=$fecha1&fecha2=$fecha2&cobrador=$cobrador&empresa=$empresa', '$codigo $descripcion', 700, 280, null);");
	
	return $objResponse->getXML();
}

$xajax->registerFunction("CargaDesc");
$xajax->registerFunction("CargaPagina");
$xajax->registerFunction("Grabar");
$xajax->registerFunction("Ordenar");
$xajax->registerFunction("OrdenarRevision");
$xajax->registerFunction("CargaSelect");
$xajax->registerFunction("BuscaUltGuia");
$xajax->registerFunction("MuestraRegistro");
$xajax->registerFunction("LlamaDetalle");

$xajax->processRequests();
$miSmarty->assign('xajax_js', $xajax->getJavascript());

$miSmarty->assign('COD_VENDEDOR', $_GET["cod_vendedor"]);
$miSmarty->assign('VENDEDOR', $_GET["nombre_vendedor"]);
$miSmarty->assign('DESDE', $_GET["desde"]);
$miSmarty->assign('HASTA', $_GET["hasta"]);

$miSmarty->display('sg_consulta_stock_vendedor.tpl');

?>

