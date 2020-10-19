<?php
session_start();

require_once 'includes/xajax/xajax.inc.php'; //archivo de configuracion de ajax
include "../includes/php/conf_smarty.php";//archivo de configuracion de smarty
include "../includes/php/conf_bd.php"; //archivo de coneccion al servidor y base de datos
//include "../includes/php/conf_bd_antigua.php"; //archivo de coneccion al servidor de yonley
include "../includes/php/validaciones.php"; 

$xajax = new xajax();

$xajax->setRequestURI("sg_bodega_toma_inventario_concon.php");
$xajax->setCharEncoding("ISO-8859-1");
$xajax->decodeUTF8InputOn();

function Grabar($data){
	global $conexion;
	global $miSmarty;
	
	set_time_limit(500);
    
	$objResponse = new xajaxResponse('ISO-8859-1');
	
	//$empresa 			= 	$data["OBLI-cboEmpresa"];
	$familia 			= 	$data["cboFamilia"];
	$subfamilia			= 	$data["cboSubFamilia"];
	$filtro				= 	$data["cboFiltro"];
	
	$objResponse->addScript("document.getElementById('divlistado').style.display='none';");
	
	if (($familia != '') && ($familia != 'Todas')){
		$and .= " a.ta_familia = '".$familia."' and ";
	}
	if (($subfamilia != '') && ($subfamilia != 'Todas')){
		$and .= " a.ta_subfamilia = '".$subfamilia."' and ";
	}
	
	// busca todos los productos
	$sql_pd = "select 
				concat(a.ta_busqueda,' ',a.ta_descripcion) as descripcion,
				a.ta_ncorr as codigo,
				a.ta_codigo as codigo_antiguo,
				a.ta_familia as familia,
				a.ta_subfamilia as subfamilia,
				b.fa_nombre as nombre_familia,
				c.sf_nombre as nombre_subfamilia
				
				from 
				sgbodega.tallasnew a, sgbodega.familias b, sgbodega.subfamilias c
				
				where
				a.ta_empresa != '' and
				a.ta_estado = '1' and
				a.ta_familia != '' and a.ta_subfamilia != '' and
				a.ta_familia = b.fa_codigo and
				a.ta_subfamilia = c.sf_subcodigo
				$and 
				
				order by b.fa_nombre asc, c.sf_nombre asc, descripcion asc";
			
	$res_pd = mysql_query($sql_pd, $conexion);
	if (@mysql_num_rows($res_pd) > 0){
		$arrRegistros		= 	array();
		$i 					= 	1;
		while ($line_pd = mysql_fetch_row($res_pd)) {
			
			/*
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
			*/
			
			$codigo = $line_pd[1];
			
			//busca todos los aumentos a bodega concon (movim 7)
			$sql_saumentos 	= "select mdet_nu as nu, mdet_cantidad as cantidad
								from 
								sgbodega.movim_detalle a, sgbodega.movim b
								
								where
								a.mdet_codigo = '".$codigo."' and
								a.movim_ncorr = b.movim_ncorr and
								b.movim_tipo = '7' and
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
			
			//busca decuentos por traspasos a bodega central (movim 8)
			$sql_trasp 	= "select mdet_nu as nu, mdet_cantidad as cantidad
								from 
								sgbodega.movim_detalle a, sgbodega.movim b
								
								where
								a.mdet_codigo = '".$codigo."' and
								a.movim_ncorr = b.movim_ncorr and
								b.movim_tipo = '8' and
								b.movim_estado = 'FINALIZADO'";
			$res_trasp 	= 	mysql_query($sql_trasp, $conexion);
			$trasp_n 	= 	0;
			$trasp_u 	= 	0;
			while ($line_trasp = mysql_fetch_row($res_trasp)) {
				$nu 		= 	$line_trasp[0];
				$cantidad	= 	$line_trasp[1];
			
				if ($nu == 'N'){
					$trasp_n 	= 	$trasp_n + $cantidad;
				}
				if ($nu == 'U'){
					$trasp_u	= 	$trasp_u + $cantidad;
				}
			}
			
			//fin
			
			$stock_nuevo 	= 	$aumentos_n - $trasp_n;
			$stock_usado 	= 	$aumentos_u - $trasp_u;
			
			$muestra		=	'NO';
			
			if ($filtro == '' OR $filtro == 'Todos'){
				$muestra = 'SI';
			}
			if ($filtro == '1'){ // solo con stock
				if ($stock_nuevo > 0 OR $stock_usado > 0){
					$muestra = 'SI';
				}
			}
			if ($filtro == '2'){ // solo sin stock
				if ($stock_nuevo < 1 && $stock_usado < 1){
					$muestra = 'SI';
				}
			}
			
			if ($muestra == 'SI'){
				array_push($arrRegistros, array("item"				=>	$i,
												"familia"			=>	$line_pd[5],
												"subfamilia"		=>	$line_pd[6],
												"descripcion"		=> 	$line_pd[0],
												"codigo" 			=> 	$line_pd[1],
												"codigo_antiguo"	=> 	$line_pd[2],
												"stock_nuevo"		=> 	$stock_nuevo,
												"stock_usa"			=> 	$stock_usado));
				$i++;
			}
		}
		       
		// asigno las sesiones para el ordenamiento
		$_SESSION["alycar_matriz"] 				= 	$arrRegistros;
		$_SESSION["alycar_empresa"] 			= 	$empresa;
		$_SESSION["alycar_nombre_empresa"]		= 	$nombre_empresa;
		
		
		$miSmarty->assign('arrRegistros', $arrRegistros);
		
		//$objResponse->addScript("xajax_Ordenar(xajax.getFormValues('Form1'), 'familia');");
		
		$objResponse->addAssign("divabonos", "innerHTML", $miSmarty->fetch('sg_bodega_toma_inventario_concon_list.tpl'));
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
	$objResponse->addAssign("divabonos", "innerHTML", $miSmarty->fetch('sg_bodega_toma_inventario_concon_list.tpl'));
	
	
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
	
	$sql = "select $campo2 as descripcion from sgyonley.$tabla where $campo1 = '".$ncorr."' $and";
	
	$res = mysql_query($sql, $conexion);
	
	$objResponse->addScript("xajax_BuscaUltGuia(xajax.getFormValues('Form1'))");
	
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

$miSmarty->display('sg_bodega_toma_inventario_concon.tpl');

?>

