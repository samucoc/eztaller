<?php
session_set_cookie_params('18000'); // 5 HORAS
session_start();

require_once 'includes/xajax/xajax.inc.php'; //archivo de configuracion de ajax
include "../includes/php/conf_smarty.php";//archivo de configuracion de smarty
include "../includes/php/conf_bd.php"; //archivo de coneccion al servidor y base de datos
//include "../includes/php/conf_bd_antigua.php"; //archivo de coneccion al servidor de yonley
include "../includes/php/validaciones.php"; 

$xajax = new xajax();

$xajax->setRequestURI("sg_bodega_informe_traspasos.php");
$xajax->setCharEncoding("ISO-8859-1");
$xajax->decodeUTF8InputOn();

function Grabar($data){
	global $conexion;
	global $miSmarty;
	
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	$fecha_desde		= 	$data["OBLI-txtFechaDesde"];
	$fecha_hasta		= 	$data["OBLI-txtFechaHasta"];
	$movim_tipo			= 	8;
	$rut_proveedor		=	$data["txtCodProveedor"];
	$nombre_proveedor	=	$data["txtDescProveedor"];
	
	$objResponse->addScript("document.getElementById('divlistado').style.display='none';");
	
	list($dia1,$mes1,$anio1) = split('[/.-]', $fecha_desde);$fecha1 	= $anio1."-".$mes1."-".$dia1;
	list($dia2,$mes2,$anio2) = split('[/.-]', $fecha_hasta);$fecha2 	= $anio2."-".$mes2."-".$dia2;

	$prov = 'Todos';
	if (($rut_proveedor != '') && ($nombre_proveedor != '')){
		$and = "a.pr_rut = '".$rut_proveedor."' and ";
		$prov	=	$rut_proveedor." ".$nombre_proveedor;
	}
	
	$sql = "select
				d.empe_desc as empresa,
				a.movim_ncorr as guia,
				DATE_FORMAT(a.movim_fecha,'%d/%m/%Y') as fecha,
				a.pr_rut as proveedor,
				sum(c.mdet_cantidad) as cant_articulos,
				sum(c.mdet_valor * c.mdet_cantidad) as total,
				a.movim_obs as obs,
				DATE_FORMAT(a.movim_fecha_dig,'%d/%m/%Y %T') as fecha_dig,
				a.usu_id as usuario,
				a.movim_numdoc as factura
				
				from 
				sgbodega.movim a, sgbodega.movim_detalle c, sgyonley.empresas d
					
				where
				a.movim_fecha >= '".$fecha1."' and a.movim_fecha <= '".$fecha2."' and
				a.movim_estado = 'FINALIZADO' and
				a.movim_tipo = '".$movim_tipo."' and
				a.empe_rut = d.empe_rut and
				$and
				a.movim_ncorr = c.movim_ncorr
				
				group by a.movim_ncorr
				
				order by a.movim_fecha asc, a.movim_ncorr asc";
	
	$res = mysql_query($sql, $conexion);
	if (mysql_num_rows($res) > 0){
		$arrRegistros	= 	array();
		$i = 1;
		while ($line = mysql_fetch_row($res)) {
			//busca al proveedor
			$sql_pr = "select pr_razon from sgbodega.proveedor where pr_rut = '".$line[3]."'";
			$res_pr = mysql_query($sql_pr, $conexion);
			$proveedor = @mysql_result($res_pr,0,"pr_razon");
			
			array_push($arrRegistros, array("item"				=>	$i,
											"empresa"			=> 	$line[0],
											"guia" 				=> 	$line[1],
											"fecha" 			=> 	$line[2],
											"proveedor"			=> 	$proveedor,
											"total_articulos" 	=> 	$line[4],
											"total" 			=> 	$line[5],
											"obs" 				=> 	$line[6],
											"fecha_dig"			=> 	$line[7],
											"usuario" 			=> 	$line[8],
											"factura" 			=> 	$line[9]));
		
			$i++;
		}
		
		$miSmarty->assign('DESDE', $fecha_desde);
		$miSmarty->assign('HASTA', $fecha_hasta);
		$miSmarty->assign('PROVEEDOR', $prov);
		$miSmarty->assign('MOVIMIENTO', $movimiento);
		$miSmarty->assign('TOTAL_MOVIM', $i - 1);
		$miSmarty->assign('arrRegistros', $arrRegistros);
		
		$objResponse->addAssign("divabonos", "innerHTML", $miSmarty->fetch('sg_bodega_informe_traspasos_list.tpl'));
	}else{
		$objResponse->addAssign("divabonos", "innerHTML", "No Existen Registros");
	}
	
	$objResponse->addScript("document.getElementById('divlistado').style.display='block';");
	
	return $objResponse->getXML();
}

function CargaPagina($data){
    global $conexion;
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	if (($_SESSION["alycar_fecha_desde"] != '') && ($_SESSION["alycar_fecha_hasta"] != '')){
		$objResponse->addAssign("OBLI-txtFechaDesde", "value", $_SESSION["alycar_fecha_desde"]);
		$objResponse->addAssign("OBLI-txtFechaHasta", "value", $_SESSION["alycar_fecha_hasta"]);
		$objResponse->addAssign("txtCodProveedor", "value", $_SESSION["alycar_rut_proveedor"]);
		$objResponse->addAssign("txtDescProveedor", "value", $_SESSION["alycar_nombre_proveedor"]);
		$objResponse->addScript("xajax_Grabar(xajax.getFormValues('Form1'))");
		
		unset($_SESSION["alycar_fecha_desde"]);
		unset($_SESSION["alycar_fecha_desde"]);
		unset($_SESSION["alycar_rut_proveedor"]);
		unset($_SESSION["alycar_nombre_proveedor"]);
		unset($_SESSION["alycar_pag_regreso"]);
	}
	
	$objResponse->addScript("document.getElementById('OBLI-txtFechaDesde').focus();");

	return $objResponse->getXML();
}          
function CargaSelect($data, $select, $tabla, $codigo, $descripcion, $campo1, $campo2){
    global $conexion;	
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	$objResponse->addAssign("$select","innerHTML",""); 		
	$sql = "select $campo1 as codigo, $campo2 as descripcion from $tabla ORDER BY $campo1 ASC";
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
function LlamaGuia($data, $guia){
	global $conexion;
	global $miSmarty;
	
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	$fecha_desde		= 	$data["OBLI-txtFechaDesde"];
	$fecha_hasta		= 	$data["OBLI-txtFechaHasta"];
	
	$_SESSION["alycar_fecha_desde"] 		= 	$fecha_desde;
	$_SESSION["alycar_fecha_hasta"] 		= 	$fecha_hasta;
	$_SESSION["alycar_rut_proveedor"] 		= 	$data["txtCodProveedor"];
	$_SESSION["alycar_nombre_proveedor"] 	= 	$data["txtDescProveedor"];;
	$_SESSION["alycar_pag_regreso"] 		= 	"sg_bodega_informe_traspasos.php";
	
	$objResponse->addScript("document.location.href='sg_bodega_imp_guia.php?guia=$guia'");
	
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
	
	if ($tabla == 'sgbodega.tallas'){
		$sql = "select ta_ncorr, ta_descripcion, ta_busqueda, ta_venta from $tabla where $campo1 = '".$ncorr."'";
		$res = mysql_query($sql, $conexion);
		
		$objResponse->addAssign("OBLItxtDescProducto", "value", @mysql_result($res,0,"ta_busqueda")." ".@mysql_result($res,0,"ta_descripcion"));
		
		//$objResponse->addScript("xajax_CalculaTotalesLinea(xajax.getFormValues('Form1'))");
	
	}else{
		
		$sql = "select $campo2 as descripcion from $tabla where $campo1 = '".$ncorr."' $and";
		$res = mysql_query($sql, $conexion);
		$objResponse->addAssign("$objeto2", "value", @mysql_result($res,0,"descripcion"));
	}	
	
	return $objResponse->getXML();
}

$xajax->registerFunction("CargaPagina");
$xajax->registerFunction("CargaSelect");
$xajax->registerFunction("Grabar");
$xajax->registerFunction("LlamaGuia");
$xajax->registerFunction("MuestraRegistro");
$xajax->registerFunction("CargaDesc");

$xajax->processRequests();
$miSmarty->assign('xajax_js', $xajax->getJavascript());

$miSmarty->assign('COD_VENDEDOR', $_GET["cod_vendedor"]);
$miSmarty->assign('VENDEDOR', $_GET["nombre_vendedor"]);
$miSmarty->assign('DESDE', $_GET["desde"]);
$miSmarty->assign('HASTA', $_GET["hasta"]);

$miSmarty->display('sg_bodega_informe_traspasos.tpl');

?>

