<?php
session_start();

require_once 'includes/xajax/xajax.inc.php'; //archivo de configuracion de ajax
include "../includes/php/conf_smarty.php";//archivo de configuracion de smarty
include "../includes/php/conf_bd.php"; //archivo de coneccion al servidor y base de datos
//include "../includes/php/conf_bd_antigua.php"; //archivo de coneccion al servidor de yonley
include "../includes/php/validaciones.php"; 

$xajax = new xajax();

$xajax->setRequestURI("sg_bodega_consulta_stock.php");
$xajax->setCharEncoding("ISO-8859-1");
$xajax->decodeUTF8InputOn();

function Grabar($data){
	global $conexion;
	global $miSmarty;
	
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	//$empresa 		= 	$data["OBLI-cboEmpresa"];
	$ncorr 			= 	$data["OBLI-txtCodProducto"];
	
	$objResponse->addScript("document.getElementById('divlistado').style.display='none';");
	
	// busca todos los productos
	$sql_pd = "select 
				concat(ta_busqueda,' ',ta_descripcion) as descripcion,
				ta_ncorr as codigo,
				ta_codigo as codigo_antiguo,
				ta_familia as familia,
				ta_subfamilia as subfamilia
				
				from 
				sgbodega.tallasnew
				
				where
				ta_ncorr = '".$ncorr."'";
	
	$res_pd = mysql_query($sql_pd, $conexion);
	if (mysql_num_rows($res_pd) > 0){
		$arrRegistros		= 	array();
		$i 					= 	1;
		while ($line_pd = mysql_fetch_row($res_pd)) {
			
			$codigo_antiguo = $line_pd[2];
			
			//busca familia
				$sql_f = "select fa_nombre from sgbodega.familias where fa_codigo = '".$line_pd[3]."'";
				$res_f = mysql_query($sql_f, $conexion);
				$familia = @mysql_result($res_f,0,"fa_nombre");
			//fin
			
			//busca subfamilia
				$sql_sf = "select sf_nombre from sgbodega.subfamilias where sf_subcodigo = '".$line_pd[4]."'";
				$res_sf = mysql_query($sql_sf, $conexion);
				$subfamilia = @mysql_result($res_sf,0,"sf_nombre");
			//fin
			
			$codigo = $line_pd[1];
			

//14/10/2010 se saca el filtro por empresa (b.empe_rut = '".$empresa."' and)		
			//busca todos los aumentos a bodega central (movim 1)
			$sql_saumentos 	= "select mdet_nu as nu, mdet_cantidad as cantidad
								from 
								sgbodega.movim_detalle a, sgbodega.movim b
								
								where
								a.mdet_codigo = '".$codigo."' and
								a.movim_ncorr = b.movim_ncorr and
								b.movim_tipo = '1' and
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
			
			//busca todos los aumentos por traspasos de concon (movim 8)
			$sql_trasp_con 	= "select mdet_nu as nu, mdet_cantidad as cantidad
								from 
								sgbodega.movim_detalle a, sgbodega.movim b
								
								where
								a.mdet_codigo = '".$codigo."' and
								a.movim_ncorr = b.movim_ncorr and
								b.movim_tipo = '8' and
								b.movim_estado = 'FINALIZADO'";
			$res_trasp_con 	= 	mysql_query($sql_trasp_con, $conexion);
			$trasp_con_n 	= 	0;
			$trasp_con_u 	= 	0;
			while ($line_trasp_con = mysql_fetch_row($res_trasp_con)) {
				$nu 		= 	$line_trasp_con[0];
				$cantidad	= 	$line_trasp_con[1];
			
				if ($nu == 'N'){
					$trasp_con_n 	= 	$trasp_con_n + $cantidad;
				}
				if ($nu == 'U'){
					$trasp_con_u 	= 	$trasp_con_u + $cantidad;
				}
			}
			
			//busca todos los aumentos por devoluciones de vendedor (movim 4)
			$sql_dev_vend 	= "select mdet_nu as nu, mdet_cantidad as cantidad
								from 
								sgbodega.movim_detalle a, sgbodega.movim b
								
								where
								a.mdet_codigo = '".$codigo."' and
								a.movim_ncorr = b.movim_ncorr and
								b.movim_tipo = '4' and
								b.movim_estado = 'FINALIZADO'";
			$res_dev_vend 	= 	mysql_query($sql_dev_vend, $conexion);
			$dev_vend_n 	= 	0;
			$dev_vend_u 	= 	0;
			while ($line_dev_vend = mysql_fetch_row($res_dev_vend)) {
				$nu 		= 	$line_dev_vend[0];
				$cantidad	= 	$line_dev_vend[1];
			
				if ($nu == 'N'){
					$dev_vend_n 	= 	$dev_vend_n + $cantidad;
				}
				if ($nu == 'U'){
					$dev_vend_u 	= 	$dev_vend_u + $cantidad;
				}
			}
			//fin
			
			/*
			//busca todos los aumentos por devoluciones de clientes (devoluciones que genera existencia que afecta bodega tdev_ncorr = 1)
			//busqueda por codigo antiguo
			$sql_dev_clie 	= "select b.sv_nu as nu, b.sv_cantidad as cantidad

								from 
								d_guiadev a, sub_guiadev b
								
								where
								b.sv_codbus = '".$codigo_antiguo."' and
								b.sv_conf_bodega = 'SI' and 
								b.sv_guiadv = a.gd_guia and
								a.gd_fecha > '2010-09-26' and
								(a.tdev_ncorr = '1' OR a.tdev_ncorr = '0')";
			
			$res_dev_clie 	= 	mysql_query($sql_dev_clie, $conexion);
			$dev_clie_n 	= 	0;
			$dev_clie_u 	= 	0;
			while ($line_dev_clie = mysql_fetch_row($res_dev_clie)) {
				$nu 		= 	$line_dev_clie[0];
				$cantidad	= 	$line_dev_clie[1];
			
				if ($nu == 'N'){
					$dev_clie_n 	= 	$dev_clie_n + $cantidad;
				}
				if ($nu == 'U'){
					$dev_clie_u 	= 	$dev_clie_u + $cantidad;
				}
			}
			*/
			
			//busqueda por codigo nuevo
			$sql_dev_clienew 	= "select b.sv_nu as nu, b.sv_cantidad as cantidad

								from 
								d_guiadev a, sub_guiadev b
								
								where
								b.sv_codbus = '".$codigo."' and
								b.sv_conf_bodega = 'SI' and 
								b.sv_guiadv = a.gd_guia and
								a.gd_fecha > '2010-09-26' and
								a.tdev_ncorr = '1'";
			
			$res_dev_clienew 	= 	mysql_query($sql_dev_clienew, $conexion);
			$dev_clie_n_new 	= 	0;
			$dev_clie_u_new 	= 	0;
			while ($line_dev_clienew = mysql_fetch_row($res_dev_clienew)) {
				$nu 		= 	$line_dev_clienew[0];
				$cantidad	= 	$line_dev_clienew[1];
			
				if ($nu == 'N'){
					$dev_clie_n_new 	= 	$dev_clie_n_new + $cantidad;
				}
				if ($nu == 'U'){
					$dev_clie_u_new 	= 	$dev_clie_u_new + $cantidad;
				}
			}
			//fin

			//busca decuentos por aumento a vendedor (movim 2)
			$sql_aum_vend 	= "select mdet_nu as nu, mdet_cantidad as cantidad
								from 
								sgbodega.movim_detalle a, sgbodega.movim b
								
								where
								a.mdet_codigo = '".$codigo."' and
								a.movim_ncorr = b.movim_ncorr and
								b.movim_tipo = '2' and
								b.movim_estado = 'FINALIZADO'";
			$res_aum_vend 	= 	mysql_query($sql_aum_vend, $conexion);
			$aum_vend_n 	= 	0;
			$aum_vend_u 	= 	0;
			while ($line_aum_vend = mysql_fetch_row($res_aum_vend)) {
				$nu 		= 	$line_aum_vend[0];
				$cantidad	= 	$line_aum_vend[1];
			
				if ($nu == 'N'){
					$aum_vend_n 	= 	$aum_vend_n + $cantidad;
				}
				if ($nu == 'U'){
					$aum_vend_u 	= 	$aum_vend_u + $cantidad;
				}
			}
			//fin
			
			//busca decuentos por devolucion a proveedor (movim 3)
			$sql_dev_pro 	= "select mdet_nu as nu, mdet_cantidad as cantidad
								from 
								sgbodega.movim_detalle a, sgbodega.movim b
								
								where
								a.mdet_codigo = '".$codigo."' and
								a.movim_ncorr = b.movim_ncorr and
								b.movim_tipo = '3' and
								b.movim_estado = 'FINALIZADO'";
			$res_dev_pro 	= 	mysql_query($sql_dev_pro, $conexion);
			$dev_pro_n 	= 	0;
			$dev_pro_u 	= 	0;
			while ($line_dev_pro = mysql_fetch_row($res_dev_pro)) {
				$nu 		= 	$line_dev_pro[0];
				$cantidad	= 	$line_dev_pro[1];
			
				if ($nu == 'N'){
					$dev_pro_n 	= 	$dev_pro_n + $cantidad;
				}
				if ($nu == 'U'){
					$dev_pro_u 	= 	$dev_pro_u + $cantidad;
				}
			}
			//fin
			
			//busca descuentos por cuentas personales (movim 9)
			$sql_cp 	= "select mdet_nu as nu, mdet_cantidad as cantidad
								from 
								sgbodega.movim_detalle a, sgbodega.movim b
								
								where
								a.mdet_codigo = '".$codigo."' and
								a.movim_ncorr = b.movim_ncorr and
								b.movim_tipo = '9' and
								b.movim_estado = 'FINALIZADO'";
			$res_cp 	= 	mysql_query($sql_cp, $conexion);
			$desc_cp_n 	= 	0;
			$desc_cp_u 	= 	0;
			while ($line_cp = mysql_fetch_row($res_cp)) {
				$nu 		= 	$line_cp[0];
				$cantidad	= 	$line_cp[1];
			
				if ($nu == 'N'){
					$desc_cp_n 	= 	$desc_cp_n + $cantidad;
				}
				if ($nu == 'U'){
					$desc_cp_u 	= 	$desc_cp_u + $cantidad;
				}
			}
			//fin
			
			$stock_nuevo = $aumentos_n + $trasp_con_n + $dev_vend_n + $dev_clie_n + $dev_clie_n_new - $aum_vend_n - $dev_pro_n - $desc_cp_n;
			$stock_usado = $aumentos_u + $trasp_con_u + $dev_vend_u + $dev_clie_u + $dev_clie_u_new - $aum_vend_u - $dev_pro_u - $desc_cp_u;
			$objResponse->addAlert(" $aumentos_n + $trasp_con_n + $dev_vend_n + $dev_clie_n + $dev_clie_n_new - $aum_vend_n - $dev_pro_n - $desc_cp_n");
			/*
			$objResponse->addScript("alert('aumentos_u=$aumentos_u');");
			$objResponse->addScript("alert('trasp_con_u=$trasp_con_u');");
			$objResponse->addScript("alert('dev_vend_u=$dev_vend_u');");
			$objResponse->addScript("alert('dev_clie_u=$dev_clie_u');");
			$objResponse->addScript("alert('dev_clie_u_new=$dev_clie_u_new');");
			$objResponse->addScript("alert('aum_vend_u=$aum_vend_u');");
			$objResponse->addScript("alert('dev_pro_u=$dev_pro_u');");
			*/
			
			array_push($arrRegistros, array("item"				=>	$i,
											"familia"			=>	$familia,
											"subfamilia"		=>	$subfamilia,
											"descripcion"		=> 	$line_pd[0],
											"codigo" 			=> 	$line_pd[1],
											"codigo_antiguo"	=> 	$line_pd[2],
											"stock_nuevo"		=> 	$stock_nuevo,
											"stock_usa"			=> 	$stock_usado));
			$i++;
		}
		       
		// asigno las sesiones para el ordenamiento
		$_SESSION["alycar_matriz"] 				= 	$arrRegistros;
		$_SESSION["alycar_empresa"] 			= 	$empresa;
		$_SESSION["alycar_nombre_empresa"]		= 	$nombre_empresa;
		
		
		$miSmarty->assign('arrRegistros', $arrRegistros);
		
		//$objResponse->addScript("xajax_Ordenar(xajax.getFormValues('Form1'), 'familia');");
		
		$objResponse->addAssign("divabonos", "innerHTML", $miSmarty->fetch('sg_bodega_consulta_stock_list.tpl'));
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
	$objResponse->addAssign("divabonos", "innerHTML", $miSmarty->fetch('sg_bodega_toma_inventario_list.tpl'));
	
	
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
	
	if (($tabla == 'sgbodega.tallas') OR ($tabla == 'sgbodega.tallasnew')){
		$sql = "select ta_ncorr, ta_descripcion, ta_busqueda, ta_venta from sgbodega.tallasnew where $campo1 = '".$ncorr."'";
		$res = mysql_query($sql, $conexion);
		
		$objResponse->addAssign("OBLI-txtDescProducto", "value", @mysql_result($res,0,"ta_busqueda")." ".@mysql_result($res,0,"ta_descripcion"));
		
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
		
		$sql = "select SF_SUBCODIGO as codigo, SF_NOMBRE as descripcion from sgbodega.subfamilias WHERE SF_CODIGO = '".$familia."' ORDER BY SF_NOMBRE ASC";
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
	
	$objResponse->addScript("document.getElementById('OBLI-txtCodProducto').focus();");

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
	
	//$objResponse->addScript("showPopWin('sg_bodega_movimientos_producto.php?codigo=$codigo&descripcion=$descripcion', '$codigo $descripcion', 700, 280, null);");
	
	$objResponse->addScript("document.location.href='sg_bodega_movimientos_producto.php?codigo=$codigo&descripcion=$descripcion'");
	
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

$xajax->processRequests();
$miSmarty->assign('xajax_js', $xajax->getJavascript());

$miSmarty->assign('COD_VENDEDOR', $_GET["cod_vendedor"]);
$miSmarty->assign('VENDEDOR', $_GET["nombre_vendedor"]);
$miSmarty->assign('DESDE', $_GET["desde"]);
$miSmarty->assign('HASTA', $_GET["hasta"]);

$miSmarty->display('sg_bodega_consulta_stock.tpl');

?>

