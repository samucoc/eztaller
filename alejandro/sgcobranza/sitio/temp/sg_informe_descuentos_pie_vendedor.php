<?php
session_start();

require_once 'includes/xajax/xajax.inc.php'; //archivo de configuracion de ajax
include "../includes/php/conf_smarty.php";//archivo de configuracion de smarty
include "../includes/php/conf_bd.php"; //archivo de coneccion al servidor y base de datos
//include "../includes/php/conf_bd_antigua.php"; //archivo de coneccion al servidor de yonley
//include "../includes/php/sgbodega.php"; 
include "../includes/php/validaciones.php"; 

$xajax = new xajax();

$xajax->setRequestURI("sg_informe_descuentos_pie_vendedor.php");
$xajax->setCharEncoding("ISO-8859-1");
$xajax->decodeUTF8InputOn();

function Grabar($data){
	global $conexion;
	
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	$objResponse->addScript("xajax_CargaListado(xajax.getFormValues('Form1'))");
	
	return $objResponse->getXML();
}

function CargaListado($data){
    global $conexion;
	global $miSmarty;
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	$empe_rut			= 	$data["OBLIcboEmpresa"];
	$sect_cod			= 	$data["cboSector"];
	$ve_codigo			= 	$data["cboVendedor"];
	$co_codigo			= 	$data["cboCobrador"];
	$fecha1				= 	$data["OBLItxtFecha1"];
	$fecha2				= 	$data["OBLItxtFecha2"];
	
	$objResponse->addScript("document.getElementById('divresultado').style.display='none';");
	
	// busca empresa
	$sql_emp = "select empe_ncorr, empe_desc from sgyonley.empresas where empe_rut = '".$empe_rut."'";
	$res_emp = mysql_query($sql_emp,$conexion);
	$empe_ncorr = @mysql_result($res_emp,0,"empe_ncorr");
	$empe_desc  = @mysql_result($res_emp,0,"empe_desc");
	
	if ($sect_cod != '' && $sect_cod != 'Todos'){
		$and .= " and sect_cod = '".$sect_cod."'";
	}
	if ($ve_codigo != '' && $ve_codigo != 'Todos'){
		$and .= " and ve_codigo = '".$ve_codigo."'";
	}
	if ($co_codigo != '' && $co_codigo != 'Todos'){
		$and .= " and co_codigo = '".$co_codigo."'";
	}
	
	list($dia1,$mes1,$anio1) = explode('/', $fecha1);	$fecha1 	= 	$anio1."-".$mes1."-".$dia1;
	list($dia2,$mes2,$anio2) = explode('/', $fecha2);	$fecha2 	= 	$anio2."-".$mes2."-".$dia2;
	
	// busco los registros
	$sql = "select 
				empe_rut,
				sect_cod,
				ve_codigo,
				co_codigo,
				sum(pven_monto)
			from
				sgyonley.pie_vendedor
			where
				empe_rut = '".$empe_rut."' and
				pven_fecha >= '".$fecha1."' and pven_fecha <= '".$fecha2."'
				
				$and
				
			group by 	
				empe_rut,
				sect_cod,
				ve_codigo,
				co_codigo
			";
	
	$res = mysql_query($sql, $conexion);
	
	if (@mysql_num_rows($res) > 0) {
		$fecha	=	date("d/m/Y");
		
		while ($line = mysql_fetch_array($res)) {
			
			// busca la desc del sector
			$sql_dsec = "select sect_desc from sgyonley.sectores where sect_cod = '".$line[1]."' and empe_ncorr = '".$empe_ncorr."'";
			$res_dsec = mysql_query($sql_dsec,$conexion);
			$sect_desc = $line[1]." ".@mysql_result($res_dsec,0,"sect_desc");
			
			// busca al vendedor
			$sql_vend = "select ve_vendedor from sgyonley.vendedores where ve_codigo = '".$line[2]."' and ve_empresa = '".$empe_rut."'";
			$res_vend = mysql_query($sql_vend,$conexion);
			$vend_desc = $line[2]." ".@mysql_result($res_vend,0,"ve_vendedor");
			
			// busca al cobrador
			$sql_dcob = "select co_nombre from sgyonley.cobrador where co_codigo = '".$line[3]."' and co_empresa = '".$empe_rut."'";
			$res_dcob = mysql_query($sql_dcob,$conexion);
			$cob_desc = $line[3]." ".@mysql_result($res_dcob,0,"co_nombre");
		
			$tbl 	.=	"<table id='tabla' class='grilla-tab' border='0' cellspacing='0' cellpadding='0' width='100%'>";
			$tbl 	.=	"<tr>";
			$tbl 	.=	"<td colspan='10' class='grilla-tab-fila-titulo' align='center'><b>Pie de Vendedor al $fecha</b></td>";
			$tbl 	.=	"</tr>";
			$tbl 	.=	"<tr>";
			$tbl 	.=	"<td class='grilla-tab-fila-titulo' align='center'><b>Empresa</b></td><td class='grilla-tab-fila-campo' align='center'>".$empe_desc."</td>";
			$tbl 	.=	"</tr>";
			$tbl 	.=	"<tr>";
			$tbl 	.=	"<td class='grilla-tab-fila-titulo' align='center'><b>Sector</b></td>";
			$tbl 	.=	"<td class='grilla-tab-fila-campo' align='center'>".$sect_desc."</td>";
			$tbl 	.=	"</tr>";
			$tbl 	.=	"<tr>";
			$tbl 	.=	"<td class='grilla-tab-fila-titulo' align='center'><b>Vendedor</b></td>";
			$tbl 	.=	"<td class='grilla-tab-fila-campo' align='center'>".$vend_desc."</td>";
			$tbl 	.=	"</tr>";
			$tbl 	.=	"<tr>";
			$tbl 	.=	"<td class='grilla-tab-fila-titulo' align='center'><b>Cobrador</b></td>";
			$tbl 	.=	"<td class='grilla-tab-fila-campo' align='center'>".$cob_desc."</td>";
			$tbl 	.=	"</tr>";
			$tbl 	.=	"<tr>";
			$tbl 	.=	"<td class='grilla-tab-fila-titulo' align='center'><b>Monto</b></td>";
			$tbl 	.=	"<td class='grilla-tab-fila-campo' align='center'>".number_format($line[4], 0, ',', '.')."</td>";
			$tbl 	.=	"</tr>";
			$tbl 	.=	"</table>";
		}
		
		
		// deja visible el div de los botones (impresion, exportacion a excel)
		$objResponse->addScript("document.getElementById('divbotones').style.display='block';");	
		
		$objResponse->addAssign("divresultado", "innerHTML", $tbl);
		$objResponse->addScript("document.getElementById('divresultado').style.display='block';");
	}
	
	return $objResponse->getXML();
}
function Mostrar($ncorr){
	global $conexion;
	
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	$objResponse->addScript("document.location.href='sg_cobranza_registro_pie_vendedor.php?ncorr=$ncorr'");
	
	return $objResponse->getXML();
}

function CargaPagina($data){
    global $conexion;
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	//  carga las empresas
	$objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'OBLIcboEmpresa','sgyonley.empresas','','- - Seleccione - -','empe_rut', 'empe_desc', '')");
	
	$objResponse->addScript("document.getElementById('OBLIcboEmpresa').focus();");
	
	return $objResponse->getXML();
}

function CargaSelect($data, $select, $tabla, $codigo, $descripcion, $campo1, $campo2, $opt){
    global $conexion;
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	
	$objResponse->addAssign("$select","innerHTML",""); 		
	if($tabla == 'trabajadores'){$campo2 = "concat(trab_nombres, ' ', trab_apellidos)";}
	$sql = "select $campo1 as codigo, $campo2 as descripcion from $tabla $opt";
	$res = mysql_query($sql, $conexion);
	$objResponse->addCreate("$select","option",""); 		
	$objResponse->addAssign("$select","options[0].value", $codigo);
	$objResponse->addAssign("$select","options[0].text", $descripcion); 	
	
	if (@mysql_num_rows($res) > 0) {
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

function CargaSectores($data){
    global $conexion;
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	
	$empe_rut	=	$data["OBLIcboEmpresa"];
	$select		=	"cboSector";
	
	$objResponse->addAssign("$select","innerHTML",""); 		
	
	// busca empe_ncorr
	$sql_emp = "select empe_ncorr from sgyonley.empresas where empe_rut = '".$empe_rut."'";
	$res_emp = mysql_query($sql_emp,$conexion);
	$empe_ncorr = @mysql_result($res_emp,0,"empe_ncorr");
	
	$sql = "select sect_cod as codigo, sect_desc as descripcion from sgyonley.sectores where empe_ncorr = '".$empe_ncorr."' order by sect_cod asc";
	$res = mysql_query($sql, $conexion);
	$objResponse->addCreate("$select","option",""); 		
	$objResponse->addAssign("$select","options[0].value", '');
	$objResponse->addAssign("$select","options[0].text", 'Todos'); 	
	
	if (@mysql_num_rows($res) > 0) {
		$j = 1;
		while ($line = mysql_fetch_array($res)) {
			$objResponse->addCreate("$select","option",""); 		
			$objResponse->addAssign("$select","options[".$j."].value", $line[0]);
			$objResponse->addAssign("$select","options[".$j."].text", $line[0]." -- ".$line[1]); 	
			$j++;
		}
	}
	
	return $objResponse->getXML();
}
function CargaCobradores($data){
    global $conexion;
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	
	$empe_rut	=	$data["OBLIcboEmpresa"];
	$select		=	"cboCobrador";
	
	$objResponse->addAssign("$select","innerHTML",""); 		
	
	$sql = "select co_codigo as codigo, co_nombre as nombre from sgyonley.cobrador where co_empresa = '".$empe_rut."' order by co_codigo asc";
	$res = mysql_query($sql, $conexion);
	$objResponse->addCreate("$select","option",""); 		
	$objResponse->addAssign("$select","options[0].value", '');
	$objResponse->addAssign("$select","options[0].text", 'Todos'); 	
	
	if (@mysql_num_rows($res) > 0) {
		$j = 1;
		while ($line = mysql_fetch_array($res)) {
			$objResponse->addCreate("$select","option",""); 		
			$objResponse->addAssign("$select","options[".$j."].value", $line[0]);
			$objResponse->addAssign("$select","options[".$j."].text", $line[0]." -- ".$line[1]); 	
			$j++;
		}
	}
	
	return $objResponse->getXML();
}
function CargaVendedores($data){
    global $conexion;
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	
	$empe_rut	=	$data["OBLIcboEmpresa"];
	$select		=	"cboVendedor";
	
	$objResponse->addAssign("$select","innerHTML",""); 		
	
	$sql = "select ve_codigo as codigo, ve_vendedor as nombre from sgyonley.vendedores where ve_empresa = '".$empe_rut."' order by ve_codigo asc";
	$res = mysql_query($sql, $conexion);
	$objResponse->addCreate("$select","option",""); 		
	$objResponse->addAssign("$select","options[0].value", '');
	$objResponse->addAssign("$select","options[0].text", 'Todos'); 	
	
	if (@mysql_num_rows($res) > 0) {
		$j = 1;
		while ($line = mysql_fetch_array($res)) {
			$objResponse->addCreate("$select","option",""); 		
			$objResponse->addAssign("$select","options[".$j."].value", $line[0]);
			$objResponse->addAssign("$select","options[".$j."].text", $line[0]." -- ".$line[1]); 	
			$j++;
		}
	}
	
	return $objResponse->getXML();
}

$xajax->registerFunction("CargaPagina");
$xajax->registerFunction("Grabar");
$xajax->registerFunction("CargaSelect");
$xajax->registerFunction("CargaListado");
$xajax->registerFunction("CargaSectores");
$xajax->registerFunction("CargaCobradores");
$xajax->registerFunction("CargaVendedores");
$xajax->registerFunction("Mostrar");


$xajax->processRequests();
$miSmarty->assign('xajax_js', $xajax->getJavascript());

$miSmarty->display('sg_informe_descuentos_pie_vendedor.tpl');

?>

