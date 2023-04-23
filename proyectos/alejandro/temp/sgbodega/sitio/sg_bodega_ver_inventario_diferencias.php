<?php
session_start();


require_once 'includes/xajax/xajax.inc.php'; //archivo de configuracion de ajax
include "../includes/php/conf_smarty.php";//archivo de configuracion de smarty
include "../includes/php/conf_bd.php"; //archivo de coneccion al servidor y base de datos
//include "../includes/php/conf_bd_antigua.php"; //archivo de coneccion al servidor de yonley
include "../includes/php/validaciones.php"; 
set_time_limit ( 0 );
$xajax = new xajax();

$xajax->setRequestURI("sg_bodega_ver_inventario_diferencias.php");
$xajax->setCharEncoding("ISO-8859-1");
$xajax->decodeUTF8InputOn();

function Grabar($data){
	global $conexion;
	global $miSmarty;
	
	$objResponse = new xajaxResponse('ISO-8859-1');
	
	$fecha 			= 	$data["OBLItxtFecha"];
	list($d,$m,$a) 	=	explode('/',$fecha); $fecha = $a.'-'.$m.'-'.$d;

	$miSmarty->assign('fecha',$data["OBLItxtFecha"]);

	// busca todos los productos
	$sql_pd = "select *	
				from sgcompras.diferencias_inventario
				where fecha = '".$fecha."' and codigo > 0
				order by codigo";
	
	$res_pd = mysql_query($sql_pd, $conexion) or die(mysql_error());
	if (mysql_num_rows($res_pd) > 0){
		$arrRegistros		= 	array();
		$arrRegistrosTI		= 	array();
		$i 					= 	1;
		while ($line_pd = mysql_fetch_row($res_pd)) {
			
			array_push($arrRegistros, array("item"				=>	$i,
											"fecha"				=>	$line_pd[1],
											"codigo_barra"		=>	$line_pd[2],
											"codigo"			=> 	$line_pd[3],
											"deascripcion"		=> 	$line_pd[4],
											"cantidad" 			=> 	$line_pd[5],
											"contado"			=> 	$line_pd[6],
											"diferencia"		=> 	$line_pd[7],
											"observacion"		=> 	$line_pd[8],
											"usuario"			=> 	$line_pd[9],
											"fecha_dig"			=> 	$line_pd[10]));
			$i++;
		}
		       
		$_SESSION["alycar_matriz"] 				= 	$arrRegistros;
		
		$miSmarty->assign('arrRegistros', $arrRegistros);
	
		
		$objResponse->addAssign("divabonos", "innerHTML", $miSmarty->fetch('sg_bodega_ver_inventario_diferencias_list.tpl'));
		
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

	$objResponse->addAssign("divabonos", "innerHTML", $miSmarty->fetch('sg_bodega_ver_inventario_diferencias_list.tpl'));
	
	
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
//		$objResponse->addScript("showPopWin('sg_bodega_ver_inventario_diferencias.php_cierre.php', 'Cierre para Inventario', 400, 220, null);");
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


$miSmarty->display('sg_bodega_ver_inventario_diferencias.tpl');

?>

