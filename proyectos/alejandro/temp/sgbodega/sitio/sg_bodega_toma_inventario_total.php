<?php
session_start();


require_once 'includes/xajax/xajax.inc.php'; //archivo de configuracion de ajax
include "../includes/php/conf_smarty.php";//archivo de configuracion de smarty
include "../includes/php/conf_bd.php"; //archivo de coneccion al servidor y base de datos
//include "../includes/php/conf_bd_antigua.php"; //archivo de coneccion al servidor de yonley
include "../includes/php/validaciones.php"; 
set_time_limit ( 0 );
$xajax = new xajax();

$xajax->setRequestURI("sg_bodega_toma_inventario_total.php");
$xajax->setCharEncoding("ISO-8859-1");
$xajax->decodeUTF8InputOn();

function Grabar($data){
	global $conexion;
	global $miSmarty;
	
	$objResponse = new xajaxResponse('ISO-8859-1');
	
	//$empresa 			= 	$data["OBLI-cboEmpresa"];
	$familia 			= 	$data["cboFamilia"];
	$subfamilia			= 	$data["cboSubFamilia"];
	$codigo				=	$data['txtCodProducto'];
	
	$objResponse->addScript("document.getElementById('divlistado').style.display='none';");
	
	if (($familia != '') && ($familia != 'Todas')){
		$and = " and a.ta_familia = '".$familia."'";
	}
	if (($subfamilia != '') && ($subfamilia != 'Todas')){
		$and .= " and a.ta_subfamilia = '".$subfamilia."'";
	}
	if (($codigo != '')){
		$and .= " and a.ta_ncorr = '".$codigo."'";
	}
	
	// busca todos los productos
	$sql_pd = "select 
				concat(a.ta_busqueda,' ',a.ta_descripcion) as descripcion,
				a.ta_ncorr as codigo,
				a.ta_codigo as codigo_antiguo,
				a.ta_familia as familia,
				a.ta_subfamilia as subfamilia,
				b.fa_nombre as nombre_familia,
				c.sf_nombre as nombre_subfamilia,
				a.ta_costo as ta_costo
				
				from 
				sgbodega.tallasnew a, sgbodega.familias b, sgbodega.subfamilias c
				
				where
				a.ta_empresa != '' and
				a.ta_familia != '' and a.ta_subfamilia != '' and
				a.ta_familia = b.fa_codigo and
				a.ta_subfamilia = c.sf_subcodigo
				$and 
				
				order by b.fa_nombre asc, c.sf_nombre asc, descripcion asc";
	
	$res_pd = mysql_query($sql_pd, $conexion) or die(mysql_error());
	if (mysql_num_rows($res_pd) > 0){
		$arrRegistros		= 	array();
		$arrRegistrosTI		= 	array();
		$i 					= 	1;
		while ($line_pd = mysql_fetch_row($res_pd)) {
			
			$codigo_antiguo = $line_pd[2];
			$familia 		= $line_pd[5];
			$subfamilia 	= $line_pd[6];
			$costo 			= $line_pd[7];
			$codigo = $line_pd[1];
			$codigo_antiguo = $line_pd[2];
			
			$sql_saumentos 	= "select  sum(mdet_cantidad) as cantidad, b.movim_bodega
						from 
						sgcompras.movim_detalle a, sgcompras.movim b
					
						where
						a.mdet_codigo = '".$codigo."' and
						a.movim_ncorr = b.movim_ncorr and
						b.movim_tipo = '1' and
						b.movim_estado = 'FINALIZADO'  
						group by b.movim_bodega";
			$res_saumentos 	= 	mysql_query($sql_saumentos, $conexion) or die(mysql_error());
			$aumentos_n_1 	= 	0;
			$aumentos_n_2 	= 	0;
			$aumentos_n_3 	= 	0;
			$aumentos_n_4 	= 	0;
			while ($line_saumentos = mysql_fetch_row($res_saumentos)) {
				$cantidad	= 	$line_saumentos[0];
				if ($line_saumentos[1]=='1'){
					$aumentos_n_1 	= 	$aumentos_n_1 + $cantidad;
					}
				if ($line_saumentos[1]=='2'){
					$aumentos_n_2 	= 	$aumentos_n_2 + $cantidad;
					}
				if ($line_saumentos[1]=='3'){
					$aumentos_n_3 	= 	$aumentos_n_3 + $cantidad;
					}
				if ($line_saumentos[1]=='4'){
					$aumentos_n_4 	= 	$aumentos_n_4 + $cantidad;
					}
				}
			
			//busca todos los aumentos por devoluciones de vendedor (movim 4)
			$sql_dev_vend 	= "select  sum(mdet_cantidad) as cantidad, b.movim_bodega
						from 
						sgcompras.movim_detalle a, sgcompras.movim b
						
						where
						a.mdet_codigo = '".$codigo."' and
						a.movim_ncorr = b.movim_ncorr and
						b.movim_tipo = '4'  and
						b.movim_estado = 'FINALIZADO'  
						group by b.movim_bodega";
			$res_dev_vend 	= 	mysql_query($sql_dev_vend, $conexion);
			$dev_vend_n_1 	= 	0;
			$dev_vend_n_2 	= 	0;
			$dev_vend_n_3 	= 	0;
			$dev_vend_n_4 	= 	0;
			while ($line_dev_vend = mysql_fetch_row($res_dev_vend)) {
				$cantidad	= 	$line_dev_vend[0];
				if ($line_dev_vend[1]=='1'){
					$dev_vend_n_1 	= 	$dev_vend_n_1 + $cantidad;
					}
				if ($line_dev_vend[1]=='2'){
					$dev_vend_n_2 	= 	$dev_vend_n_2 + $cantidad;
					}
				if ($line_dev_vend[1]=='3'){
					$dev_vend_n_3 	= 	$dev_vend_n_3 + $cantidad;
					}
				if ($line_dev_vend[1]=='4'){
					$dev_vend_n_4 	= 	$dev_vend_n_4 + $cantidad;
					}
				}
			//fin
			/*
			('154243','25278',NULL,'110','ZAPATILLA  ADULTO N 40','0','65','0','0','0','0','0','0','0','18-12-2013 15:29','0','1','0'),
			('154257','25279',NULL,'110','ZAPATILLA  ADULTO N 40','0','65','0','0','0','0','0','0','0','18-12-2013 15:31','1','0','0')
			*/
			//busca todos los aumentos por traspasos desde (movim 8)
			$sql_trasp 	= "select  sum(mdet_cantidad) as cantidad, b.movim_bodega
						from 
						sgcompras.movim_detalle a, sgcompras.movim b
						
						where
						a.mdet_codigo = '".$codigo."' and
						a.movim_ncorr = b.movim_ncorr and
						b.movim_tipo = '8' and
						b.movim_estado = 'FINALIZADO'  and 
						mdet_conf_tras = 1
						group by b.movim_bodega
						";
			$res_trasp 	= 	mysql_query($sql_trasp, $conexion);
			$trasp_n_1 	= 	0;
			$trasp_n_2 	= 	0;
			$trasp_n_3 	= 	0;
			$trasp_n_4 	= 	0;
			while ($line_trasp = mysql_fetch_row($res_trasp)) {
				$cantidad	= 	$line_trasp[0];
				if ($line_trasp[1]=='1'){
					$trasp_n_1 	= 	$trasp_n_1 + $cantidad;
					}
				if ($line_trasp[1]=='2'){
					$trasp_n_2 	= 	$trasp_n_2 + $cantidad;
					}
				if ($line_trasp[1]=='3'){
					$trasp_n_3 	= 	$trasp_n_3 + $cantidad;
					}
				if ($line_trasp[1]=='4'){
					$trasp_n_4 	= 	$trasp_n_4 + $cantidad;
					}
				}
			//fin

			//busca todos los aumentos por traspasos hacia (movim 8)
			$sql_trasp_tras	= "select  sum(mdet_cantidad) as cantidad, b.movim_bodega_tras
						from 
						sgcompras.movim_detalle a, sgcompras.movim b
						
						where
						a.mdet_codigo = '".$codigo."' and
						a.movim_ncorr = b.movim_ncorr and
						b.movim_tipo = '8' and
						b.movim_estado = 'FINALIZADO' 
						group by b.movim_bodega_tras
						";
			$res_trasp_tras 	= 	mysql_query($sql_trasp_tras, $conexion);
			$trasp_n_tras_1 	= 	0;
			$trasp_n_tras_2 	= 	0;
			$trasp_n_tras_3 	= 	0;
			$trasp_n_tras_4 	= 	0;
			while ($line_trasp_tras = mysql_fetch_row($res_trasp_tras)) {
				$cantidad	= 	$line_trasp_tras[0];
				if ($line_trasp_tras[1]=='1'){
					$trasp_n_tras_1 	= 	$trasp_n_tras_1 + $cantidad;
					}
				if ($line_trasp_tras[1]=='2'){
					$trasp_n_tras_2 	= 	$trasp_n_tras_2 + $cantidad;
					}
				if ($line_trasp_tras[1]=='3'){
					$trasp_n_tras_3 	= 	$trasp_n_tras_3 + $cantidad;
					}
				if ($line_trasp_tras[1]=='4'){
					$trasp_n_tras_4 	= 	$trasp_n_tras_4 + $cantidad;
					}
				}
			//fin

				
			//busqueda por codigo nuevo
				$sql_dev_clienew 	= "select b.sv_nu as nu, b.sv_cantidad as cantidad
								from 
								sgyonley.d_guiadev a, sgyonley.sub_guiadev b
								where
								b.sv_codbus = '".$codigo."' and
								b.sv_conf_bodega = 'SI' and 
								b.sv_guiadv = a.gd_guia  and
								a.tdev_ncorr = '1'  ";
			
				$res_dev_clienew 	= 	mysql_query($sql_dev_clienew, $conexion);
				$dev_clie_n_new_1 	= 	0;
				$dev_clie_n_new_2 	= 	0;
				$dev_clie_n_new_3 	= 	0;
				$dev_clie_n_new_4 	= 	0;
				while ($line_dev_clienew = mysql_fetch_row($res_dev_clienew)) {
					$cantidad			= 	$line_dev_clienew[1];
					if ($line_dev_clienew[0]=='N'){
						$dev_clie_n_new_1 	= 	$dev_clie_n_new_1 + $cantidad;
						}
					if ($line_dev_clienew[0]=='U'){
						$dev_clie_n_new_2 	= 	$dev_clie_n_new_2 + $cantidad;
						}
					
					}

			//busca decuentos por aumento a vendedor (movim 2)
			$sql_aum_vend 	= "select  sum(mdet_cantidad) as cantidad, b.movim_bodega
						from 
						sgcompras.movim_detalle a, sgcompras.movim b
						
						where
						a.mdet_codigo = '".$codigo."' and
						a.movim_ncorr = b.movim_ncorr and
						b.movim_tipo = '2'  and
						b.movim_estado = 'FINALIZADO'  
						group by b.movim_bodega";
			$res_aum_vend 	= 	mysql_query($sql_aum_vend, $conexion);
			$aum_vend_n_1 	= 	0;
			$aum_vend_n_2 	= 	0;
			$aum_vend_n_3 	= 	0;
			$aum_vend_n_4 	= 	0;
			while ($line_aum_vend = mysql_fetch_row($res_aum_vend)) {
				$cantidad	= 	$line_aum_vend[0];
				if ($line_aum_vend[1]=='1'){
					$aum_vend_n_1 	= 	$aum_vend_n_1 + $cantidad;
					}
				if ($line_aum_vend[1]=='2'){
					$aum_vend_n_2 	= 	$aum_vend_n_2 + $cantidad;
					}
				if ($line_aum_vend[1]=='3'){
					$aum_vend_n_3 	= 	$aum_vend_n_3 + $cantidad;
					}
				if ($line_aum_vend[1]=='4'){
					$aum_vend_n_4 	= 	$aum_vend_n_4 + $cantidad;
					}
				}
			//fin
			
			//busca decuentos por devolucion a proveedor (movim 3)
			$sql_dev_pro 	= "select  sum(mdet_cantidad) as cantidad, b.movim_bodega
						from 
						sgcompras.movim_detalle a, sgcompras.movim b
						
						where
						a.mdet_codigo = '".$codigo."' and
						a.movim_ncorr = b.movim_ncorr and
						b.movim_tipo = '3' and
						b.movim_estado = 'FINALIZADO'  
						group by b.movim_bodega";
			$res_dev_pro 	= 	mysql_query($sql_dev_pro, $conexion);
			$dev_pro_n_1 	= 	0;
			$dev_pro_n_2 	= 	0;
			$dev_pro_n_3 	= 	0;
			$dev_pro_n_4 	= 	0;
			while ($line_dev_pro = mysql_fetch_row($res_dev_pro)) {
				$cantidad	= 	$line_dev_pro[0];
				if ($line_dev_pro[1]=='1'){
					$dev_pro_n_1 	= 	$dev_pro_n_1 + $cantidad;
					}
				if ($line_dev_pro[1]=='2'){
					$dev_pro_n_2 	= 	$dev_pro_n_2 + $cantidad;
					}
				if ($line_dev_pro[1]=='3'){
					$dev_pro_n_3 	= 	$dev_pro_n_3 + $cantidad;
					}
				if ($line_dev_pro[1]=='4'){
					$dev_pro_n_4 	= 	$dev_pro_n_4 + $cantidad;
					}
				}
			//fin
			
			//busca descuentos por cuentas personales (movim 9)
			$sql_cp 	= "select  sum(mdet_cantidad) as cantidad, b.movim_bodega
						from 
						sgcompras.movim_detalle a, sgcompras.movim b
						
						where
						a.mdet_codigo = '".$codigo."' and
						a.movim_ncorr = b.movim_ncorr and
						b.movim_tipo = '9' and
						b.movim_estado = 'FINALIZADO'
						group by b.movim_bodega";
			$res_cp 	= 	mysql_query($sql_cp, $conexion);
			$desc_cp_n_1 	= 	0;
			$desc_cp_n_2 	= 	0;
			$desc_cp_n_3 	= 	0;
			$desc_cp_n_4 	= 	0;
			while ($line_cp = mysql_fetch_row($res_cp)) {
				$cantidad	= 	$line_cp[0];
				if ($line_cp[1]=='1'){
					$desc_cp_n_1 	= 	$desc_cp_n_1 + $cantidad;
					}
				if ($line_cp[1]=='2'){
					$desc_cp_n_2 	= 	$desc_cp_n_2 + $cantidad;
					}
				if ($line_cp[1]=='3'){
					$desc_cp_n_3 	= 	$desc_cp_n_3 + $cantidad;
					}
				if ($line_cp[1]=='4'){
					$desc_cp_n_4 	= 	$desc_cp_n_4 + $cantidad;
					}
				}
			//fin
			
			//ajustes aumentos
			$sql_ajustes_aumentos 	= "select sum(mdet_cantidad) as cantidad, b.movim_bodega
							from 
							sgcompras.movim_detalle a, sgcompras.movim b
						
							where
							a.mdet_codigo = '".$codigo."' and
							a.movim_ncorr = b.movim_ncorr and
							b.movim_tipo = '12' and
						b.movim_estado = 'FINALIZADO'  
						group by b.movim_bodega";
			$res_ajustes_saumentos 	= 	mysql_query($sql_ajustes_aumentos, $conexion) or die(mysql_error());
			$ajuste_aumentos_n_1 	= 	0;
			$ajuste_aumentos_n_2 	= 	0;
			$ajuste_aumentos_n_3 	= 	0;
			$ajuste_aumentos_n_4 	= 	0;
			while ($line_ajustes_saumentos = mysql_fetch_row($res_ajustes_saumentos)) {
				$cantidad	= 	$line_ajustes_saumentos[0];
				if ($line_ajustes_saumentos[1]=='1'){
					$ajuste_aumentos_n_1 	= 	$ajuste_aumentos_n_1 + $cantidad;
					}
				if ($line_ajustes_saumentos[1]=='2'){
					$ajuste_aumentos_n_2 	= 	$ajuste_aumentos_n_2 + $cantidad;
					}
				if ($line_ajustes_saumentos[1]=='3'){
					$ajuste_aumentos_n_3 	= 	$ajuste_aumentos_n_3 + $cantidad;
					}
				if ($line_ajustes_saumentos[1]=='4'){
					$ajuste_aumentos_n_4 	= 	$ajuste_aumentos_n_4 + $cantidad;
					}
				}
			
			//ajustes mermas
			$sql_merma 	= "select sum(mdet_cantidad) as cantidad, b.movim_bodega
						from 
						sgcompras.movim_detalle a, sgcompras.movim b
						
						where
						a.mdet_codigo = '".$codigo."' and
						a.movim_ncorr = b.movim_ncorr and
						b.movim_tipo = '13' and
						b.movim_estado = 'FINALIZADO'  
						group by b.movim_bodega";
			$res_merma 	= 	mysql_query($sql_merma, $conexion);
			$desc_merma_n_1 	= 	0;
			$desc_merma_n_2 	= 	0;
			$desc_merma_n_3 	= 	0;
			$desc_merma_n_4 	= 	0;
			while ($line_merma = mysql_fetch_row($res_merma)) {
				$cantidad	= 	$line_merma[0];
				if ($line_merma[1]=='1'){
					$desc_merma_n_1 	= 	$desc_merma_n_1 + $cantidad;
					}
				if ($line_merma[1]=='2'){
					$desc_merma_n_2 	= 	$desc_merma_n_2 + $cantidad;
					}
				if ($line_merma[1]=='3'){
					$desc_merma_n_3 	= 	$desc_merma_n_3 + $cantidad;
					}
				if ($line_merma[1]=='4'){
					$desc_merma_n_4 	= 	$desc_merma_n_4 + $cantidad;
					}
				}
			
			//ajuste castigo
			$sql_castigo 	= "select sum(mdet_cantidad) as cantidad, b.movim_bodega
						from 
						sgcompras.movim_detalle a, sgcompras.movim b
						
						where
						a.mdet_codigo = '".$codigo."' and
						a.movim_ncorr = b.movim_ncorr and
						b.movim_tipo = '14' and
						b.movim_estado = 'FINALIZADO'  
						group by b.movim_bodega";
			$res_castigo 	= 	mysql_query($sql_castigo, $conexion);
			$desc_castigo_n_1 	= 	0;
			$desc_castigo_n_2 	= 	0;
			$desc_castigo_n_3 	= 	0;
			$desc_castigo_n_4 	= 	0;
			while ($line_castigo = mysql_fetch_row($res_castigo)) {
				$cantidad	= 	$line_castigo[0];
				if ($line_castigo[1]=='1'){
					$desc_castigo_n_1 	= 	$desc_castigo_n_1 + $cantidad;
					}
				if ($line_castigo[1]=='2'){
					$desc_castigo_n_2 	= 	$desc_castigo_n_2 + $cantidad;
					}
				if ($line_castigo[1]=='3'){
					$desc_castigo_n_3 	= 	$desc_castigo_n_3 + $cantidad;
					}
				if ($line_castigo[1]=='4'){
					$desc_castigo_n_4 	= 	$desc_castigo_n_4 + $cantidad;
					}
				}
			
			$stock_nuevo_1 = $aumentos_n_1 + $trasp_n_1 - $trasp_n_tras_1 + $dev_vend_n_1 + $dev_clie_n_new_1 - $aum_vend_n_1 - $dev_pro_n_1 - $desc_cp_n_1 + $ajuste_aumentos_n_1  - $desc_merma_n_1  - $desc_castigo_n_1 ;
			$stock_nuevo_2 = $aumentos_n_2 + $trasp_n_2 - $trasp_n_tras_2 + $dev_vend_n_2 + $dev_clie_n_new_2 - $aum_vend_n_2 - $dev_pro_n_2 - $desc_cp_n_2 + $ajuste_aumentos_n_2  - $desc_merma_n_2  - $desc_castigo_n_2 ;
			$stock_nuevo_3 = $aumentos_n_3 + $trasp_n_3 - $trasp_n_tras_3 + $dev_vend_n_3 + $dev_clie_n_new_3 - $aum_vend_n_3 - $dev_pro_n_3 - $desc_cp_n_3 + $ajuste_aumentos_n_3  - $desc_merma_n_3  - $desc_castigo_n_3 ;
			$stock_nuevo_4 = $aumentos_n_4 + $trasp_n_4 - $trasp_n_tras_4 + $dev_vend_n_4 + $dev_clie_n_new_4 - $aum_vend_n_4 - $dev_pro_n_4 - $desc_cp_n_4 + $ajuste_aumentos_n_4  - $desc_merma_n_4  - $desc_castigo_n_4 ;
			
			//$objResponse->addAlert("$aumentos_n_1 + $trasp_n_1 - $trasp_n_tras_1 + $dev_vend_n_1 + $dev_clie_n_1 + $dev_clie_n_new_1 - $aum_vend_n_1 - $dev_pro_n_1 - $desc_cp_n_1 + $ajuste_aumentos_n_1  - $desc_merma_n_1  - $desc_castigo_n_1 ");
			
			//$objResponse->addAlert("$aumentos_n_2 + $trasp_n_2 - $trasp_n_tras_2 + $dev_vend_n_2 + $dev_clie_n_2 + $dev_clie_n_new_2 - $aum_vend_n_2 - $dev_pro_n_2 - $desc_cp_n_2 + $ajuste_aumentos_n_2  - $desc_merma_n_2  - $desc_castigo_n_2 ");
			
			//$objResponse->addAlert("$aumentos_n_3 + $trasp_n_3 - $trasp_n_tras_3 + $dev_vend_n_3 + $dev_clie_n_3 + $dev_clie_n_new_3 - $aum_vend_n_3 - $dev_pro_n_3 - $desc_cp_n_3 + $ajuste_aumentos_n_3  - $desc_merma_n_3  - $desc_castigo_n_3 ");
			
			//$objResponse->addAlert($aumentos_n_4 + $trasp_n_4 - $trasp_n_tras_4 + $dev_vend_n_4 + $dev_clie_n_4 + $dev_clie_n_new_4 - $aum_vend_n_4 - $dev_pro_n_4 - $desc_cp_n_4 + $ajuste_aumentos_n_4  - $desc_merma_n_4  - $desc_castigo_n_4 ");
			
			$sql_saumentos 	= "select sum(mdet_cantidad) as cantidad, b.movim_bodega
						from 
						sgcompras.movim_detalle a, sgcompras.movim b
						
						where
						a.mdet_codigo = '".$codigo."' and
						a.movim_ncorr = b.movim_ncorr and
						b.movim_tipo = '7' and
						b.movim_estado = 'FINALIZADO'  
						group by b.movim_bodega";
			$res_saumentos 	= 	mysql_query($sql_saumentos, $conexion);
			$aumentos_n_1 	= 	0;
			$aumentos_n_2 	= 	0;
			$aumentos_n_3 	= 	0;
			$aumentos_n_4 	= 	0;
			while ($line_saumentos = mysql_fetch_row($res_saumentos)) {
				$cantidad	= 	$line_saumentos[0];
				if ($line_saumentos[1]=='1'){
					$aumentos_n_1 	= 	$aumentos_n_1 + $cantidad;
					}
				if ($line_saumentos[1]=='2'){
					$aumentos_n_2 	= 	$aumentos_n_2 + $cantidad;
					}
				if ($line_saumentos[1]=='3'){
					$aumentos_n_3 	= 	$aumentos_n_3 + $cantidad;
					}
				if ($line_saumentos[1]=='4'){
					$aumentos_n_4 	= 	$aumentos_n_4 + $cantidad;
					}
				}
			
			//busca decuentos por traspasos a bodega central (movim 8)
			$sql_trasp 	= "select sum(mdet_cantidad) as cantidad, b.movim_bodega
							from 
							sgcompras.movim_detalle a, sgcompras.movim b
							
							where
							a.mdet_codigo = '".$codigo."' and
							a.movim_ncorr = b.movim_ncorr and
							b.movim_tipo = '8' and
							b.movim_estado = 'FINALIZADO' and 
							b.movim_bodega_tras = '' 
							group by b.movim_bodega";
			$res_trasp 	= 	mysql_query($sql_trasp, $conexion);
			$trasp_n_1 	= 	0;
			$trasp_n_2 	= 	0;
			$trasp_n_3 	= 	0;
			$trasp_n_4 	= 	0;
			while ($line_trasp = mysql_fetch_row($res_trasp)) {
				$cantidad	= 	$line_trasp[0];
				if ($line_trasp[1]=='1'){
					$trasp_n_1 	= 	$trasp_n_1 + $cantidad;
					}
				if ($line_trasp[1]=='2'){
					$trasp_n_2 	= 	$trasp_n_2 + $cantidad;
					}
				if ($line_trasp[1]=='3'){
					$trasp_n_3 	= 	$trasp_n_3 + $cantidad;
					}
				if ($line_trasp[1]=='4'){
					$trasp_n_4 	= 	$trasp_n_4 + $cantidad;
					}
				}
			
					//	echo "$aumentos_n_1 - $trasp_n_1";
					$stock_nuevo_1 += $aumentos_n_1 - $trasp_n_1;
					$stock_nuevo_2 += $aumentos_n_2 - $trasp_n_2;
					$stock_nuevo_3 += $aumentos_n_3 - $trasp_n_3;
					$stock_nuevo_4 += $aumentos_n_4 - $trasp_n_4;
			
			array_push($arrRegistros, array("item"				=>	$i,
											"familia"			=>	$familia,
											"subfamilia"		=>	$subfamilia,
											"descripcion"		=> 	$line_pd[0],
											"costo"				=> 	$costo,
											"codigo" 			=> 	$line_pd[1],
											"codigo_antiguo"	=> 	$line_pd[2],
											"cantidad"			=> 	$stock_nuevo_1,
											"cantidad_1"		=> 	$stock_nuevo_2,
											"cantidad_2"		=> 	$stock_nuevo_3,
											"cantidad_3"		=> 	$stock_nuevo_4));
			array_push($arrRegistrosTI, array("item"				=>	$i,
											"descripcion"		=> 	$line_pd[0],
											"codigo" 			=> 	$line_pd[1],
											"codigo_barra"		=> 	$line_pd[1],
											"cantidad"			=> 	$stock_nuevo_1));
			$i++;
		}
		       
		// asigno las sesiones para el ordenamiento
		$_SESSION["alycar_matriz"] 				= 	$arrRegistros;
		//$_SESSION["alycar_empresa"] 			= 	$empresa;
		//$_SESSION["alycar_nombre_empresa"]		= 	$nombre_empresa;
		
		$miSmarty->assign('arrRegistros', $arrRegistros);
		$miSmarty->assign('arrRegistrosTI', $arrRegistrosTI);

		$objResponse->addScript("xajax_Ordenar(xajax.getFormValues('Form1'), 'familia');");

		$sql_cierre			= 	"select date_format(cier_fecha, '%d/%m/%Y') as cinv_fecha, 
										cier_usuario as cinv_usuario,
										date_format(cier_fechadig, '%d/%m/%Y %H:%i:%s') as cinv_fechadig
								from sgbodega.cierres
								order by cier_fecha desc limit 1";
		$res_cierre			= 	mysql_query($sql_cierre, $conexion);
		$row_cierre = mysql_fetch_array($res_cierre);

		$fecha 		= $row_cierre['cinv_fecha'];
		$usuario 	= $row_cierre['cinv_usuario'];
		$fecha_dig 	= $row_cierre['cinv_fechadig'];
		
		
		$str_fecha = $fecha.' --- '.$usuario.' --- '.$fecha_dig;

		$miSmarty->assign('fecha_cierre', $str_fecha);

		
		$objResponse->addAssign("divabonos", "innerHTML", $miSmarty->fetch('sg_bodega_toma_inventario_total_list.tpl'));
		$objResponse->addAssign("divabonosTI", "innerHTML", $miSmarty->fetch('sg_bodega_toma_inventario_total_TI_list.tpl'));
		//$objResponse->addAssign("divabonos", "innerHTML", $sql_saumentos);
		
	}else{
		
		$objResponse->addAssign("divabonos", "innerHTML", "No Existen Registros");
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
	
	$miSmarty->assign('arrRegistros', $arrRegistros);

		$sql_cierre			= 	"select date_format(cier_fecha, '%d/%m/%Y') as cinv_fecha, 
										cier_usuario as cinv_usuario,
										date_format(cier_fechadig, '%d/%m/%Y %H:%i:%s') as cinv_fechadig
								from sgbodega.cierres
								order by cier_fecha desc limit 1";
		$res_cierre			= 	mysql_query($sql_cierre, $conexion);
		$row_cierre = mysql_fetch_array($res_cierre);

		$fecha 		= $row_cierre['cinv_fecha'];
		$usuario 	= $row_cierre['cinv_usuario'];
		$fecha_dig 	= $row_cierre['cinv_fechadig'];
		
		$str_fecha = $fecha.' --- '.$usuario.' --- '.$fecha_dig;

		$miSmarty->assign('fecha_cierre', $str_fecha);

	$objResponse->addAssign("divabonos", "innerHTML", $miSmarty->fetch('sg_bodega_toma_inventario_total_list.tpl'));
	
	
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
	
	$sql = "select concat(ta_busqueda,' ',ta_descripcion) as descripcion from $tabla where $campo1 = '".$ncorr."' $and";
	
	$res = mysql_query($sql, $conexion);
	
	$objResponse->addAssign("$objeto2", "value", @mysql_result($res,0,"descripcion"));
	
	
	return $objResponse->getXML();
}

function CargaSelect($data, $select, $tabla, $codigo, $descripcion, $campo1, $campo2, $opt){
    global $conexion;
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	$objResponse->addAssign("$select","innerHTML",""); 		
	$sql = "select $campo1 as codigo, $campo2 as descripcion from $tabla";
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

function CargaSubFamilias($data){
    global $conexion;	
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	$familia	=	$data["cboFamilia"];
	
	$objResponse->addAssign("cboSubFamilia","innerHTML",""); 		
	
	//if ((trim($familia) == '') or (trim($familia) == '- - Seleccione - -')){
	//	$objResponse->addCreate("cboSubFamilia","option",""); 		
	//	$objResponse->addAssign("cboSubFamilia","options[0].value", '');
	//	$objResponse->addAssign("cboSubFamilia","options[0].text", '- - Seleccione - -'); 	
	//}else{
		
		//$objResponse->addScript("alert('$familia');");
		
	if 	($familia != 'Todas' &&  $familia != ''){
		$sql = "select SF_SUBCODIGO as codigo, SF_NOMBRE as descripcion from sgbodega.subfamilias WHERE SF_CODIGO = '".$familia."' ORDER BY SF_NOMBRE ASC";
	}else{
		$sql = "select SF_SUBCODIGO as codigo, SF_NOMBRE as descripcion from sgbodega.subfamilias WHERE SF_CODIGO != '' group by SF_NOMBRE ORDER BY SF_NOMBRE ASC";
	}	
		$res = mysql_query($sql, $conexion);
		if (mysql_num_rows($res) > 0) {
			$objResponse->addCreate("cboSubFamilia","option",""); 		
			$objResponse->addAssign("cboSubFamilia","options[0].value", '');
			$objResponse->addAssign("cboSubFamilia","options[0].text", 'Todas'); 	
			$j = 1;
			while ($line = mysql_fetch_array($res)) {
				$objResponse->addCreate("cboSubFamilia","option",""); 		
				$objResponse->addAssign("cboSubFamilia","options[".$j."].value", $line[0]);
				$objResponse->addAssign("cboSubFamilia","options[".$j."].text", $line[1]); 	
				$j++;
			}
		}
	//}
	
	return $objResponse->getXML();
}

function CargaPagina($data){
    global $conexion;
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	//carga empresas
	$objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'OBLI-cboEmpresa','empresas','','- - Seleccione - -','empe_rut', 'empe_desc', '')");
	
	//carga familias
	$objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'cboFamilia','sgbodega.familias','','Todas','fa_codigo', 'fa_nombre', '')");
	
	$objResponse->addScript("document.getElementById('OBLI-cboEmpresa').focus();");

	return $objResponse->getXML();
}          
function LlamaDetalle($data, $codigo, $descripcion){
    global $conexion;
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	$fecha_desde		= 	$data["OBLI-txtFechaDesde"];
	$fecha_hasta		= 	$data["OBLI-txtFechaHasta"];
	$cobrador			= 	$data["OBLI-txtCodCobrador"];
	$nombre_cobrador	= 	$data["OBLI-txtDescCobrador"];
	$empresa 			= 	$data["OBLI-cboEmpresa"];
	$ult_guia 			= 	$data["txtUltGuia"];
	
	list($dia1,$mes1,$anio1) = split('[/.-]', $fecha_desde);$fecha1 	= $anio1."-".$mes1."-".$dia1;
	list($dia2,$mes2,$anio2) = split('[/.-]', $fecha_hasta);$fecha2 	= $anio2."-".$mes2."-".$dia2;
	
	$objResponse->addScript("showPopWin('sg_existencia_movimientos_vendedor_detalle.php?codigo=$codigo&descripcion=$descripcion&fecha1=$fecha1&fecha2=$fecha2&cobrador=$cobrador&empresa=$empresa', '$codigo $descripcion', 700, 280, null);");
	
	return $objResponse->getXML();
}
function Imprime(){
    global $conexion;
    $objResponse = new xajaxResponse('ISO-8859-1');
	//if ($_SESSION["alycar_sgyonley_usuario"] == 'jruz' OR $_SESSION["alycar_sgyonley_usuario"] == 'JRUZ' OR $_SESSION["alycar_sgyonley_usuario"] == 'arojas'){ 
//		$objResponse->addScript("showPopWin('sg_bodega_toma_inventario_total_cierre.php', 'Cierre para Inventario', 400, 220, null);");
//	}
	
	$objResponse->addScript("ImprimeDiv('divabonos');");
	
	return $objResponse->getXML();
}

function CB($data,$ncorr){
    global $conexion;
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	$objResponse->addScript("showPopWin('ejemplo.php?id=$ncorr', 'Codigo Barra', 700, 280, null);");
	
	return $objResponse->getXML();
}

$xajax->registerFunction("MuestraRegistro");
$xajax->registerFunction("CargaDesc");
$xajax->registerFunction("CargaPagina");
$xajax->registerFunction("Grabar");
$xajax->registerFunction("Ordenar");
$xajax->registerFunction("CargaSelect");
$xajax->registerFunction("BuscaUltGuia");
$xajax->registerFunction("LlamaDetalle");
$xajax->registerFunction("CargaSubFamilias");
$xajax->registerFunction("Imprime");
$xajax->registerFunction("CB");

$xajax->processRequests();
$miSmarty->assign('xajax_js', $xajax->getJavascript());


$miSmarty->display('sg_bodega_toma_inventario_total.tpl');

?>

