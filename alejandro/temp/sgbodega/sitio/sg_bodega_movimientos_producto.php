<?php
session_start();

require_once 'includes/xajax/xajax.inc.php'; //archivo de configuracion de ajax
include "../includes/php/conf_smarty.php";//archivo de configuracion de smarty
include "../includes/php/conf_bd.php"; //archivo de coneccion al servidor y base de datos
//include "../includes/php/conf_bd_antigua.php"; //archivo de coneccion al servidor de yonley
include "../includes/php/validaciones.php"; 

$xajax = new xajax();

$xajax->setRequestURI("sg_bodega_movimientos_producto.php");
$xajax->setCharEncoding("ISO-8859-1");
$xajax->decodeUTF8InputOn();

function Grabar($data){
	global $conexion;
	global $miSmarty;
	
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	$objResponse->addScript("document.getElementById('divabonos').style.display='none';");
	
	$codigo			= 	$data["txtCodigo"];
	$descripcion	= 	$data["txtDescripcion"];
	$fecha1			= 	$data["txtFecha1"];
	$fecha2			= 	$data["txtFecha2"];
	$cobrador		= 	$data["txtCobrador"];
	$empresa		= 	$data["txtEmpresa"];
	
	
	//busca el codigo antiguo
	$sql_ncorr 	= 	"select ta_codigo from sgbodega.tallasnew where ta_ncorr = '".$codigo."'";
	$res_ncorr 	= 	mysql_query($sql_ncorr, $conexion);
	$codigo_antiguo		=	@mysql_result($res_ncorr,0,"ta_codigo");

	$arrRegistros = array();
	$total_n = 0;
	$total_u = 0;
	
	//busca todos los aumentos a bodega central (movim 1)
	//NUEVO
	$sql_saumentos 	= "select 
						DATE_FORMAT(b.movim_fecha,'%d/%m/%Y') as fecha,
						a.mdet_codigo as codigo,
						a.mdet_desc as descripcion,
						a.mdet_nu as nu,
						a.movim_ncorr_ant as guia,
						a.mdet_cantidad as cantidad,
						b.usu_id as usuario,
						b.pr_rut as rut_proveedor,
						b.movim_numdoc as factura
						
						from 
						sgbodega.movim_detalle a, sgbodega.movim b
						
						where
						a.mdet_codigo = '".$codigo."' and
						a.mdet_nu = 'N' and
						a.movim_ncorr = b.movim_ncorr and
						b.movim_tipo = '1' and
						b.movim_estado = 'FINALIZADO' order by b.movim_fecha asc";
	
	$res_saumentos 	= 	mysql_query($sql_saumentos, $conexion);
	while ($line_saumentos = mysql_fetch_row($res_saumentos)) {
		
		$pr_rut = $line_saumentos[7];
		
		//define el nombre de la transaccion (busca al proveedor) 
		$sql_pr = "select pr_razon from sgbodega.proveedor where pr_rut = '".$pr_rut."'";
		$res_pr = mysql_query($sql_pr,$conexion);
		$pr_razon = @mysql_result($res_pr,0,"pr_razon");
		$transaccion = "+A "."[ P=".$pr_razon."] [F=".$line_saumentos[8]."]";
		
		array_push($arrRegistros, array("fecha"			=>	$line_saumentos[0],
										"codigo"		=>	$line_saumentos[1],
										"descripcion"	=>	$line_saumentos[2],
										"nu"			=>	$line_saumentos[3],
										"guia" 			=> 	$line_saumentos[4],
										"tarjeta" 		=> 	'',
										"movim"	 		=> 	$transaccion,
										"cantidad" 		=> 	$line_saumentos[5],
										"usuario"		=> 	$line_saumentos[6]));
		$i++;
		$total_n = $total_n + $line_saumentos[5];
	}
	//USADO
	$sql_saumentos 	= "select 
						DATE_FORMAT(b.movim_fecha,'%d/%m/%Y') as fecha,
						a.mdet_codigo as codigo,
						a.mdet_desc as descripcion,
						a.mdet_nu as nu,
						a.movim_ncorr_ant as guia,
						a.mdet_cantidad as cantidad,
						b.usu_id as usuario,
						b.pr_rut as rut_proveedor,
						b.movim_numdoc as factura
						
						from 
						sgbodega.movim_detalle a, sgbodega.movim b
						
						where
						a.mdet_codigo = '".$codigo."' and
						a.mdet_nu = 'U' and
						a.movim_ncorr = b.movim_ncorr and
						b.movim_tipo = '1' and
						b.movim_estado = 'FINALIZADO' order by b.movim_fecha asc";
	
	$res_saumentos 	= 	mysql_query($sql_saumentos, $conexion);
	while ($line_saumentos = mysql_fetch_row($res_saumentos)) {
		
		$pr_rut = $line_saumentos[7];
		
		//define el nombre de la transaccion (busca al proveedor) 
		$sql_pr = "select pr_razon from sgbodega.proveedor where pr_rut = '".$pr_rut."'";
		$res_pr = mysql_query($sql_pr,$conexion);
		$pr_razon = @mysql_result($res_pr,0,"pr_razon");
		$transaccion = "+A "."[ P=".$pr_razon."] [F=".$line_saumentos[8]."]";
		
		array_push($arrRegistros, array("fecha"			=>	$line_saumentos[0],
										"codigo"		=>	$line_saumentos[1],
										"descripcion"	=>	$line_saumentos[2],
										"nu"			=>	$line_saumentos[3],
										"guia" 			=> 	$line_saumentos[4],
										"tarjeta" 		=> 	'',
										"movim"	 		=> 	$transaccion,
										"cantidad" 		=> 	$line_saumentos[5],
										"usuario"		=> 	$line_saumentos[6]));
		$i++;
		$total_u = $total_u + $line_saumentos[5];
	}
	//busca todos los aumentos por traspasos de concon (movim 8)
	//NUEVO
	$sql_trasp_con 	= "select 
						DATE_FORMAT(b.movim_fecha,'%d/%m/%Y') as fecha,
						a.mdet_codigo as codigo,
						a.mdet_desc as descripcion,
						a.mdet_nu as nu,
						a.movim_ncorr_ant as guia,
						a.mdet_cantidad as cantidad,
						b.usu_id as usuario
						
						from 
						sgbodega.movim_detalle a, sgbodega.movim b
						
						where
						a.mdet_codigo = '".$codigo."' and
						a.mdet_nu = 'N' and
						a.movim_ncorr = b.movim_ncorr and
						b.movim_tipo = '8' and
						b.movim_estado = 'FINALIZADO' order by b.movim_fecha asc";
	
	$res_trasp_con 	= 	mysql_query($sql_trasp_con, $conexion);
	while ($line_trasp_con = mysql_fetch_row($res_trasp_con)) {
		
		array_push($arrRegistros, array("fecha"			=>	$line_trasp_con[0],
										"codigo"		=>	$line_trasp_con[1],
										"descripcion"	=>	$line_trasp_con[2],
										"nu"			=>	$line_trasp_con[3],
										"guia" 			=> 	$line_trasp_con[4],
										"tarjeta" 		=> 	'',
										"movim"	 		=> 	'TRASPASO DE BODEGA CON CON',
										"cantidad" 		=> 	$line_trasp_con[5],
										"usuario"		=> 	$line_trasp_con[6]));
		$i++;
		$total_n = $total_n + $line_trasp_con[5];
	}
	//USADO
	$sql_trasp_con 	= "select 
						DATE_FORMAT(b.movim_fecha,'%d/%m/%Y') as fecha,
						a.mdet_codigo as codigo,
						a.mdet_desc as descripcion,
						a.mdet_nu as nu,
						a.movim_ncorr_ant as guia,
						a.mdet_cantidad as cantidad,
						b.usu_id as usuario
						
						from 
						sgbodega.movim_detalle a, sgbodega.movim b
						
						where
						a.mdet_codigo = '".$codigo."' and
						a.mdet_nu = 'U' and
						a.movim_ncorr = b.movim_ncorr and
						b.movim_tipo = '8' and
						b.movim_estado = 'FINALIZADO' order by b.movim_fecha asc";
	

	$res_trasp_con 	= 	mysql_query($sql_trasp_con, $conexion);
	while ($line_trasp_con = mysql_fetch_row($res_trasp_con)) {
		
		array_push($arrRegistros, array("fecha"			=>	$line_trasp_con[0],
										"codigo"		=>	$line_trasp_con[1],
										"descripcion"	=>	$line_trasp_con[2],
										"nu"			=>	$line_trasp_con[3],
										"guia" 			=> 	$line_trasp_con[4],
										"tarjeta" 		=> 	'',
										"movim"	 		=> 	'TRASPASO DE BODEGA CON CON',
										"cantidad" 		=> 	$line_trasp_con[5],
										"usuario"		=> 	$line_trasp_con[6]));
		$i++;
		$total_u = $total_u + $line_trasp_con[5];
	}
	
	//busca todos los aumentos por devoluciones de vendedor (movim 4)
	// se llamara rebaja de stock y nombre del vendedor 26/10/2010
	
	//NUEVO
	$sql_dev_ven 	= "select 
						DATE_FORMAT(b.movim_fecha,'%d/%m/%Y') as fecha,
						a.mdet_codigo as codigo,
						a.mdet_desc as descripcion,
						a.mdet_nu as nu,
						a.movim_ncorr_ant as guia,
						a.mdet_cantidad as cantidad,
						b.usu_id as usuario,
						b.empe_rut as empresa,
						b.vend_ncorr as cod_vendedor
						
						from 
						sgbodega.movim_detalle a, sgbodega.movim b
						
						where
						a.mdet_codigo = '".$codigo."' and
						a.mdet_nu = 'N' and
						a.movim_ncorr = b.movim_ncorr and
						b.movim_tipo = '4' and
						b.movim_estado = 'FINALIZADO' order by b.movim_fecha asc";
	
	$res_dev_ven 	= 	mysql_query($sql_dev_ven, $conexion);
	while ($line_dev_ven = mysql_fetch_row($res_dev_ven)) {
		
		$ve_empresa = $line_dev_ven[7];
		$ve_codigo 	= $line_dev_ven[8];
		
		//define el nombre de la transaccion (busca al vendedor) 
		// si existe mas de un vendedor hago la ldiferencia por empresa...
		$sql_cv = "select count(*) as total from sgbodega.vendedores where ve_codigo = '".$ve_codigo."'";
		$res_cv = mysql_query($sql_cv, $conexion);
		$cant_vend = @mysql_result($res_cv,0,"total");
		if ($cant_vend > 1){
			$sql_ve = "select ve_vendedor from sgbodega.vendedores where ve_empresa = '".$ve_empresa."' and ve_codigo = '".$ve_codigo."'";
		}else{
			$sql_ve = "select ve_vendedor from sgbodega.vendedores where ve_codigo = '".$ve_codigo."'";
		}
		
		$res_ve = mysql_query($sql_ve,$conexion);
		$vendedor = @mysql_result($res_ve,0,"ve_vendedor");
		$transaccion = "+A "."[ R=REBAJA STOCK] [".$vendedor."]";
		
		array_push($arrRegistros, array("fecha"			=>	$line_dev_ven[0],
										"codigo"		=>	$line_dev_ven[1],
										"descripcion"	=>	$line_dev_ven[2],
										"nu"			=>	$line_dev_ven[3],
										"guia" 			=> 	$line_dev_ven[4],
										"tarjeta" 		=> 	'',
										"movim"	 		=> 	$transaccion,
										"cantidad" 		=> 	$line_dev_ven[5],
										"usuario"		=> 	$line_dev_ven[6]));
		$i++;
		$total_n = $total_n + $line_dev_ven[5];
	}
	//USADO
	$sql_dev_ven 	= "select 
						DATE_FORMAT(b.movim_fecha,'%d/%m/%Y') as fecha,
						a.mdet_codigo as codigo,
						a.mdet_desc as descripcion,
						a.mdet_nu as nu,
						a.movim_ncorr_ant as guia,
						a.mdet_cantidad as cantidad,
						b.usu_id as usuario,
						b.empe_rut as empresa,
						b.vend_ncorr as cod_vendedor
						
						from 
						sgbodega.movim_detalle a, sgbodega.movim b
						
						where
						a.mdet_codigo = '".$codigo."' and
						a.mdet_nu = 'U' and
						a.movim_ncorr = b.movim_ncorr and
						b.movim_tipo = '4' and
						b.movim_estado = 'FINALIZADO' order by b.movim_fecha asc";
	

	$res_dev_ven 	= 	mysql_query($sql_dev_ven, $conexion);
	while ($line_dev_ven = mysql_fetch_row($res_dev_ven)) {
		
		$ve_empresa = $line_dev_ven[7];
		$ve_codigo 	= $line_dev_ven[8];
		
		//define el nombre de la transaccion (busca al vendedor) 
		// si existe mas de un vendedor hago la ldiferencia por empresa...
		$sql_cv = "select count(*) as total from sgbodega.vendedores where ve_codigo = '".$ve_codigo."'";
		$res_cv = mysql_query($sql_cv, $conexion);
		$cant_vend = @mysql_result($res_cv,0,"total");
		if ($cant_vend > 1){
			$sql_ve = "select ve_vendedor from sgbodega.vendedores where ve_empresa = '".$ve_empresa."' and ve_codigo = '".$ve_codigo."'";
		}else{
			$sql_ve = "select ve_vendedor from sgbodega.vendedores where ve_codigo = '".$ve_codigo."'";
		}
		
		$res_ve = mysql_query($sql_ve,$conexion);
		$vendedor = @mysql_result($res_ve,0,"ve_vendedor");
		$transaccion = "+A "."[ R=REBAJA STOCK] [".$vendedor."]";
		
		array_push($arrRegistros, array("fecha"			=>	$line_dev_ven[0],
										"codigo"		=>	$line_dev_ven[1],
										"descripcion"	=>	$line_dev_ven[2],
										"nu"			=>	$line_dev_ven[3],
										"guia" 			=> 	$line_dev_ven[4],
										"tarjeta" 		=> 	'',
										"movim"	 		=> 	$transaccion,
										"cantidad" 		=> 	$line_dev_ven[5],
										"usuario"		=> 	$line_dev_ven[6]));
		$i++;
		$total_u = $total_u + $line_dev_ven[5];
	}
	
	/*
	//busca todos los aumentos por devoluciones de clientes (devoluciones que genera existencia que afecta bodega tdev_ncorr = 1)
	//busqueda por codigo antiguo
	//NUEVO
	
	$sql_dev_clie 	= "select 
						DATE_FORMAT(a.gd_fecha,'%d/%m/%Y') as fecha,
						b.sv_codbus as codigo,
						b.sv_glosa as descripcion,
						b.sv_nu as nu, 
						a.gd_guia as guia,
						a.gd_folio as tarjeta,
						b.sv_cantidad as cantidad,
						a.gd_usuario,
						a.gd_empresa

						from 
						d_guiadev a, sub_guiadev b
						
						where
						b.sv_codbus = '".$codigo_antiguo."' and
						b.sv_nu = 'N' and
						b.sv_conf_bodega = 'SI' and 
						b.sv_guiadv = a.gd_guia and
						a.gd_fecha > '2010-09-26' and
						(a.tdev_ncorr = '1' OR a.tdev_ncorr = '0') order by a.gd_fecha asc";
	
	$res_dev_clie 	= 	mysql_query($sql_dev_clie, $conexion);
	while ($line_dev_clie = mysql_fetch_row($res_dev_clie)) {
		
		$empresa_movim = $line_dev_clie[8];
		
		//define el nombre de la transaccion (busca la empresa) 
		$sql_emp = "select empe_desc from empresas where empe_rut = '".$empresa_movim."'";
		$res_emp = mysql_query($sql_emp,$conexion);
		$nombre_empresa_movim = @mysql_result($res_emp,0,"empe_desc");
		$transaccion = "+A "."[ DV=DEVOLUCION CLIENTE] [".$nombre_empresa_movim."]";
		
		array_push($arrRegistros, array("fecha"			=>	$line_dev_clie[0],
										"codigo"		=>	$codigo,
										"descripcion"	=>	$line_dev_clie[2],
										"nu"			=>	$line_dev_clie[3],
										"guia" 			=> 	$line_dev_clie[4],
										"tarjeta" 		=> 	$line_dev_clie[5],
										"movim"	 		=> 	$transaccion,
										"cantidad" 		=> 	$line_dev_clie[6],
										"usuario"		=> 	$line_dev_clie[7]));
		$i++;
		$total_n = $total_n + $line_dev_clie[6];
	}
	
	//USADO
	$sql_dev_clie 	= "select 
						DATE_FORMAT(a.gd_fecha,'%d/%m/%Y') as fecha,
						b.sv_codbus as codigo,
						b.sv_glosa as descripcion,
						b.sv_nu as nu, 
						a.gd_guia as guia,
						a.gd_folio as tarjeta,
						b.sv_cantidad as cantidad,
						a.gd_usuario,
						a.gd_empresa

						from 
						d_guiadev a, sub_guiadev b
						
						where
						b.sv_codbus = '".$codigo_antiguo."' and
						b.sv_nu = 'U' and
						b.sv_conf_bodega = 'SI' and 
						b.sv_guiadv = a.gd_guia and
						a.gd_fecha > '2010-09-26' and
						(a.tdev_ncorr = '1' OR a.tdev_ncorr = '0') order by a.gd_fecha asc";
	
	$res_dev_clie 	= 	mysql_query($sql_dev_clie, $conexion);
	while ($line_dev_clie = mysql_fetch_row($res_dev_clie)) {
		
		$empresa_movim = $line_dev_clie[8];
		
		//define el nombre de la transaccion (busca la empresa) 
		$sql_emp = "select empe_desc from empresas where empe_rut = '".$empresa_movim."'";
		$res_emp = mysql_query($sql_emp,$conexion);
		$nombre_empresa_movim = @mysql_result($res_emp,0,"empe_desc");
		$transaccion = "+A "."[ DV=DEVOLUCION CLIENTE] [".$nombre_empresa_movim."]";
		
		array_push($arrRegistros, array("fecha"			=>	$line_dev_clie[0],
										"codigo"		=>	$codigo,
										"descripcion"	=>	$line_dev_clie[2],
										"nu"			=>	$line_dev_clie[3],
										"guia" 			=> 	$line_dev_clie[4],
										"tarjeta" 		=> 	$line_dev_clie[5],
										"movim"	 		=> 	$transaccion,
										"cantidad" 		=> 	$line_dev_clie[6],
										"usuario"		=> 	$line_dev_clie[7]));
		$i++;
		$total_u = $total_u + $line_dev_clie[6];
	}
	*/
	
	//busqueda por codigo nuevo
	//NUEVO
	$sql_dev_clie 	= "select 
						DATE_FORMAT(a.gd_fecha,'%d/%m/%Y') as fecha,
						b.sv_codbus as codigo,
						b.sv_glosa as descripcion,
						b.sv_nu as nu, 
						a.gd_guia as guia,
						a.gd_folio as tarjeta,
						b.sv_cantidad as cantidad,
						a.gd_usuario,
						a.gd_empresa

						from 
						d_guiadev a, sub_guiadev b
						
						where
						b.sv_codbus = '".$codigo."' and
						b.sv_nu = 'N' and
						b.sv_conf_bodega = 'SI' and 
						b.sv_guiadv = a.gd_guia and
						a.gd_fecha > '2010-09-26' and
						
						(a.tdev_ncorr = '1' OR a.tdev_ncorr = '0') order by a.gd_fecha asc";
	
	$res_dev_clie 	= 	mysql_query($sql_dev_clie, $conexion);
	while ($line_dev_clie = mysql_fetch_row($res_dev_clie)) {
		
		$empresa_movim = $line_dev_clie[8];
		
		//define el nombre de la transaccion (busca la empresa) 
		$sql_emp = "select empe_desc from empresas where empe_rut = '".$empresa_movim."'";
		$res_emp = mysql_query($sql_emp,$conexion);
		$nombre_empresa_movim = @mysql_result($res_emp,0,"empe_desc");
		$transaccion = "+A "."[ DV=DEVOLUCION CLIENTE] [".$nombre_empresa_movim."]";
		
		array_push($arrRegistros, array("fecha"			=>	$line_dev_clie[0],
										"codigo"		=>	$line_dev_clie[1],
										"descripcion"	=>	$line_dev_clie[2],
										"nu"			=>	$line_dev_clie[3],
										"guia" 			=> 	$line_dev_clie[4],
										"tarjeta" 		=> 	$line_dev_clie[5],
										"movim"	 		=> 	$transaccion,
										"cantidad" 		=> 	$line_dev_clie[6],
										"usuario"		=> 	$line_dev_clie[7]));
		$i++;
		$total_n = $total_n + $line_dev_clie[6];
	}
	//USADO
	$sql_dev_clie 	= "select 
						DATE_FORMAT(a.gd_fecha,'%d/%m/%Y') as fecha,
						b.sv_codbus as codigo,
						b.sv_glosa as descripcion,
						b.sv_nu as nu, 
						a.gd_guia as guia,
						a.gd_folio as tarjeta,
						b.sv_cantidad as cantidad,
						a.gd_usuario,
						a.gd_empresa

						from 
						d_guiadev a, sub_guiadev b
						
						where
						b.sv_codbus = '".$codigo."' and
						b.sv_nu = 'U' and
						b.sv_conf_bodega = 'SI' and 
						b.sv_guiadv = a.gd_guia and
						a.gd_fecha > '2010-09-26' and
						(a.tdev_ncorr = '1' OR a.tdev_ncorr = '0') order by a.gd_fecha asc";
	
	$res_dev_clie 	= 	mysql_query($sql_dev_clie, $conexion);
	while ($line_dev_clie = mysql_fetch_row($res_dev_clie)) {
		
		$empresa_movim = $line_dev_clie[8];
		
		//define el nombre de la transaccion (busca la empresa) 
		$sql_emp = "select empe_desc from empresas where empe_rut = '".$empresa_movim."'";
		$res_emp = mysql_query($sql_emp,$conexion);
		$nombre_empresa_movim = @mysql_result($res_emp,0,"empe_desc");
		$transaccion = "+A "."[ DV=DEVOLUCION CLIENTE] [".$nombre_empresa_movim."]";
		
		array_push($arrRegistros, array("fecha"			=>	$line_dev_clie[0],
										"codigo"		=>	$line_dev_clie[1],
										"descripcion"	=>	$line_dev_clie[2],
										"nu"			=>	$line_dev_clie[3],
										"guia" 			=> 	$line_dev_clie[4],
										"tarjeta" 		=> 	$line_dev_clie[5],
										"movim"	 		=> 	$transaccion,
										"cantidad" 		=> 	$line_dev_clie[6],
										"usuario"		=> 	$line_dev_clie[7]));
		$i++;
		$total_u = $total_u + $line_dev_clie[6];
	}
	
	//busca decuentos por aumento a vendedor (movim 2)
	//NUEVO
	$sql_desc_av = "select 
						DATE_FORMAT(b.movim_fecha,'%d/%m/%Y') as fecha,
						a.mdet_codigo as codigo,
						a.mdet_desc as descripcion,
						a.mdet_nu as nu,
						a.movim_ncorr_ant as guia,
						a.mdet_cantidad as cantidad,
						b.usu_id as usuario,
						b.empe_rut as empresa,
						b.vend_ncorr as vendedor
						
						from 
						sgbodega.movim_detalle a, sgbodega.movim b
						
						where
						a.mdet_codigo = '".$codigo."' and
						a.mdet_nu = 'N' and
						a.movim_ncorr = b.movim_ncorr and
						b.movim_tipo = '2' and
						b.movim_estado = 'FINALIZADO' order by b.movim_fecha asc";
	
	$res_desc_av 	= 	mysql_query($sql_desc_av, $conexion);
	while ($line_desc_av = mysql_fetch_row($res_desc_av)) {
		
		$ve_empresa = $line_desc_av[7];
		$ve_codigo 	= $line_desc_av[8];
		
		//define el nombre de la transaccion (busca al vendedor) 
		// si existe mas de un vendedor hago la ldiferencia por empresa...
		$sql_cv = "select count(*) as total from sgbodega.vendedores where ve_codigo = '".$ve_codigo."'";
		$res_cv = mysql_query($sql_cv, $conexion);
		$cant_vend = @mysql_result($res_cv,0,"total");
		if ($cant_vend > 1){
			$sql_ve = "select ve_vendedor from sgbodega.vendedores where ve_empresa = '".$ve_empresa."' and ve_codigo = '".$ve_codigo."'";
		}else{
			$sql_ve = "select ve_vendedor from sgbodega.vendedores where ve_codigo = '".$ve_codigo."'";
		}
		
		$res_ve = mysql_query($sql_ve,$conexion);
		$vendedor = @mysql_result($res_ve,0,"ve_vendedor");
		$transaccion = "-D "."[".$vendedor."]";
		
		array_push($arrRegistros, array("fecha"			=>	$line_desc_av[0],
										"codigo"		=>	$line_desc_av[1],
										"descripcion"	=>	$line_desc_av[2],
										"nu"			=>	$line_desc_av[3],
										"guia" 			=> 	$line_desc_av[4],
										"tarjeta" 		=> 	'',
										"movim"	 		=> 	$transaccion,
										"cantidad" 		=> 	$line_desc_av[5],
										"usuario"		=> 	$line_desc_av[6]));
		$i++;
		$total_n = $total_n - $line_desc_av[5];
	}
	
	//USADO
	$sql_desc_av = "select 
						DATE_FORMAT(b.movim_fecha,'%d/%m/%Y') as fecha,
						a.mdet_codigo as codigo,
						a.mdet_desc as descripcion,
						a.mdet_nu as nu,
						a.movim_ncorr_ant as guia,
						a.mdet_cantidad as cantidad,
						b.usu_id as usuario,
						b.empe_rut as empresa,
						b.vend_ncorr as vendedor
						
						from 
						sgbodega.movim_detalle a, sgbodega.movim b
						
						where
						a.mdet_codigo = '".$codigo."' and
						a.mdet_nu = 'U' and
						a.movim_ncorr = b.movim_ncorr and
						b.movim_tipo = '2' and
						b.movim_estado = 'FINALIZADO' order by b.movim_fecha asc";
	
	$res_desc_av 	= 	mysql_query($sql_desc_av, $conexion);
	while ($line_desc_av = mysql_fetch_row($res_desc_av)) {
		
		$ve_empresa = $line_desc_av[7];
		$ve_codigo 	= $line_desc_av[8];
		
		//define el nombre de la transaccion (busca al vendedor) 
		// si existe mas de un vendedor hago la ldiferencia por empresa...
		$sql_cv = "select count(*) as total from sgbodega.vendedores where ve_codigo = '".$ve_codigo."'";
		$res_cv = mysql_query($sql_cv, $conexion);
		$cant_vend = @mysql_result($res_cv,0,"total");
		if ($cant_vend > 1){
			$sql_ve = "select ve_vendedor from sgbodega.vendedores where ve_empresa = '".$ve_empresa."' and ve_codigo = '".$ve_codigo."'";
		}else{
			$sql_ve = "select ve_vendedor from sgbodega.vendedores where ve_codigo = '".$ve_codigo."'";
		}
		
		$res_ve = mysql_query($sql_ve,$conexion);
		$vendedor = @mysql_result($res_ve,0,"ve_vendedor");
		$transaccion = "-D "."[".$vendedor."]";
		
		array_push($arrRegistros, array("fecha"			=>	$line_desc_av[0],
										"codigo"		=>	$line_desc_av[1],
										"descripcion"	=>	$line_desc_av[2],
										"nu"			=>	$line_desc_av[3],
										"guia" 			=> 	$line_desc_av[4],
										"tarjeta" 		=> 	'',
										"movim"	 		=> 	$transaccion,
										"cantidad" 		=> 	$line_desc_av[5],
										"usuario"		=> 	$line_desc_av[6]));
		$i++;
		$total_u = $total_u - $line_desc_av[5];
	}
	
	//busca decuentos por devolucion a proveedor (movim 3)
	//NUEVO
	$sql_dev_prov = "select 
						DATE_FORMAT(b.movim_fecha,'%d/%m/%Y') as fecha,
						a.mdet_codigo as codigo,
						a.mdet_desc as descripcion,
						a.mdet_nu as nu,
						a.movim_ncorr_ant as guia,
						a.mdet_cantidad as cantidad,
						b.usu_id as usuario,
						b.pr_rut as proveedor
						
						from 
						sgbodega.movim_detalle a, sgbodega.movim b
						
						where
						a.mdet_codigo = '".$codigo."' and
						a.mdet_nu = 'N' and
						a.movim_ncorr = b.movim_ncorr and
						b.movim_tipo = '3' and
						b.movim_estado = 'FINALIZADO' order by b.movim_fecha asc";
	
	$res_dev_prov 	= 	mysql_query($sql_dev_prov, $conexion);
	while ($line_dev_prov = mysql_fetch_row($res_dev_prov)) {
		
		$pr_rut = $line_dev_prov[7];
		
		//define el nombre de la transaccion (busca al proveedor) 
		$sql_pr = "select pr_razon from sgbodega.proveedor where pr_rut = '".$pr_rut."'";
		$res_pr = mysql_query($sql_pr,$conexion);
		$pr_razon = @mysql_result($res_pr,0,"pr_razon");
		$transaccion = "-D "."[ P=".$pr_razon."]";
		
		array_push($arrRegistros, array("fecha"			=>	$line_dev_prov[0],
										"codigo"		=>	$line_dev_prov[1],
										"descripcion"	=>	$line_dev_prov[2],
										"nu"			=>	$line_dev_prov[3],
										"guia" 			=> 	$line_dev_prov[4],
										"tarjeta" 		=> 	'',
										"movim"	 		=> 	$transaccion,
										"cantidad" 		=> 	$line_dev_prov[5],
										"usuario"		=> 	$line_dev_prov[6]));
		$i++;
		$total_n = $total_n - $line_dev_prov[5];
	}
	
	//USADO
	$sql_dev_prov = "select 
						DATE_FORMAT(b.movim_fecha,'%d/%m/%Y') as fecha,
						a.mdet_codigo as codigo,
						a.mdet_desc as descripcion,
						a.mdet_nu as nu,
						a.movim_ncorr_ant as guia,
						a.mdet_cantidad as cantidad,
						b.usu_id as usuario,
						b.pr_rut as proveedor
						
						from 
						sgbodega.movim_detalle a, sgbodega.movim b
						
						where
						a.mdet_codigo = '".$codigo."' and
						a.mdet_nu = 'U' and
						a.movim_ncorr = b.movim_ncorr and
						b.movim_tipo = '3' and
						b.movim_estado = 'FINALIZADO' order by b.movim_fecha asc";
	
	$res_dev_prov 	= 	mysql_query($sql_dev_prov, $conexion);
	while ($line_dev_prov = mysql_fetch_row($res_dev_prov)) {
		
		$pr_rut = $line_dev_prov[7];
		
		//define el nombre de la transaccion (busca al proveedor) 
		$sql_pr = "select pr_razon from sgbodega.proveedor where pr_rut = '".$pr_rut."'";
		$res_pr = mysql_query($sql_pr,$conexion);
		$pr_razon = @mysql_result($res_pr,0,"pr_razon");
		$transaccion = "-D "."[ P=".$pr_razon."]";
		
		array_push($arrRegistros, array("fecha"			=>	$line_dev_prov[0],
										"codigo"		=>	$line_dev_prov[1],
										"descripcion"	=>	$line_dev_prov[2],
										"nu"			=>	$line_dev_prov[3],
										"guia" 			=> 	$line_dev_prov[4],
										"tarjeta" 		=> 	'',
										"movim"	 		=> 	$transaccion,
										"cantidad" 		=> 	$line_dev_prov[5],
										"usuario"		=> 	$line_dev_prov[6]));
		$i++;
		$total_u = $total_u - $line_dev_prov[5];
	}
	
	//busca decuentos por cuentas personales (movim 9)
	//NUEVO
	$sql_cp = "select 
						DATE_FORMAT(b.movim_fecha,'%d/%m/%Y') as fecha,
						a.mdet_codigo as codigo,
						a.mdet_desc as descripcion,
						a.mdet_nu as nu,
						a.movim_ncorr_ant as guia,
						a.mdet_cantidad as cantidad,
						b.usu_id as usuario,
						b.movim_trabajador as trabajador
						
						from 
						sgbodega.movim_detalle a, sgbodega.movim b
						
						where
						a.mdet_codigo = '".$codigo."' and
						a.mdet_nu = 'N' and
						a.movim_ncorr = b.movim_ncorr and
						b.movim_tipo = '9' and
						b.movim_estado = 'FINALIZADO' order by b.movim_fecha asc";
	
	$res_cp  = 	mysql_query($sql_cp, $conexion);
	while ($line_cp = mysql_fetch_row($res_cp)) {
		
		$trabajador = $line_cp[7];
		
		$transaccion = "-D "."[ CP=CUENTA PERSONAL] [".$trabajador."]";
		
		array_push($arrRegistros, array("fecha"			=>	$line_cp[0],
										"codigo"		=>	$line_cp[1],
										"descripcion"	=>	$line_cp[2],
										"nu"			=>	$line_cp[3],
										"guia" 			=> 	$line_cp[4],
										"tarjeta" 		=> 	'',
										"movim"	 		=> 	$transaccion,
										"cantidad" 		=> 	$line_cp[5],
										"usuario"		=> 	$line_cp[6]));
		$i++;
		$total_n = $total_n - $line_cp[5];
	}
	
	//USADO
	$sql_cp = "select 
						DATE_FORMAT(b.movim_fecha,'%d/%m/%Y') as fecha,
						a.mdet_codigo as codigo,
						a.mdet_desc as descripcion,
						a.mdet_nu as nu,
						a.movim_ncorr_ant as guia,
						a.mdet_cantidad as cantidad,
						b.usu_id as usuario,
						b.movim_trabajador as trabajador
						
						from 
						sgbodega.movim_detalle a, sgbodega.movim b
						
						where
						a.mdet_codigo = '".$codigo."' and
						a.mdet_nu = 'U' and
						a.movim_ncorr = b.movim_ncorr and
						b.movim_tipo = '9' and
						b.movim_estado = 'FINALIZADO' order by b.movim_fecha asc";
	
	$res_cp 	= 	mysql_query($sql_cp, $conexion);
	while ($line_cp = mysql_fetch_row($res_cp)) {
		
		$trabajador = $line_cp[7];
		
		$transaccion = "-D "."[ CP=CUENTA PERSONAL] [".$trabajador."]";
		
		array_push($arrRegistros, array("fecha"			=>	$line_cp[0],
										"codigo"		=>	$line_cp[1],
										"descripcion"	=>	$line_cp[2],
										"nu"			=>	$line_cp[3],
										"guia" 			=> 	$line_cp[4],
										"tarjeta" 		=> 	'',
										"movim"	 		=> 	$transaccion,
										"cantidad" 		=> 	$line_cp[5],
										"usuario"		=> 	$line_cp[6]));
		$i++;
		$total_u = $total_u - $line_cp[5];
	}
	
	
	$miSmarty->assign('arrRegistros', $arrRegistros);
	$miSmarty->assign('TOTAL_N', $total_n);
	$miSmarty->assign('TOTAL_U', $total_u);
	$miSmarty->assign('TOTAL', $total_n + $total_u);
	
	$objResponse->addAssign("divabonos", "innerHTML", $miSmarty->fetch('sg_bodega_movimientos_producto_list.tpl'));
	
	$objResponse->addScript("document.getElementById('divabonos').style.display='block';");
	
	return $objResponse->getXML();
}

$xajax->registerFunction("Grabar");

$xajax->processRequests();
$miSmarty->assign('xajax_js', $xajax->getJavascript());

$miSmarty->assign('CODIGO', $_GET["codigo"]);
$miSmarty->assign('DESCRIPCION', $_GET["descripcion"]);
$miSmarty->assign('FECHA1', $_GET["fecha1"]);
$miSmarty->assign('FECHA2', $_GET["fecha2"]);
$miSmarty->assign('COBRADOR', $_GET["cobrador"]);
$miSmarty->assign('EMPRESA', $_GET["empresa"]);

$miSmarty->display('sg_bodega_movimientos_producto.tpl');

?>

