<?php
session_start();

require_once 'includes/xajax/xajax.inc.php'; //archivo de configuracion de ajax
include "../includes/php/conf_smarty.php";//archivo de configuracion de smarty
include "../includes/php/conf_bd.php"; //archivo de coneccion al servidor y base de datos
//include "../includes/php/conf_bd_antigua.php"; //archivo de coneccion al servidor de yonley
//include "../includes/php/sgbodega.php"; 
include "../includes/php/validaciones.php"; 

$xajax = new xajax();

$xajax->setRequestURI("sg_cobranza_registro_pie_vendedor.php");
$xajax->setCharEncoding("ISO-8859-1");
$xajax->decodeUTF8InputOn();

function Grabar($data){
	global $conexion;
	
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	$pven_ncorr			=	$data["txtNcorr"];
	$empe_rut			=	$data["OBLIcboEmpresa"];
	$sect_cod			=	$data["OBLIcboSector"];
	$ve_codigo			=	$data["OBLIcboVendedor"];
	$co_codigo			=	$data["OBLIcboCobrador"];
	$pven_folio			=	$data["txtFolio"];
	$pven_fecha			=	$data["OBLItxtFecha1"];
	$pven_monto			=	$data["OBLItxtMonto"];
	$pven_usuario		=	$_SESSION["alycar_sgyonley_usuario"];
	$pven_fechadig		=	date("Y-m-d H:i:s");
	$ingresa			=	'SI';
	
	list($dia1,$mes1,$anio1) = split('[/.-]', $pven_fecha);	$pven_fecha	= $anio1."-".$mes1."-".$dia1;
	
	if ($ingresa == 'SI'){
		// valido el folio ingresado
		if ($pven_folio != ''){
			$sql_fo = "select vent_num_folio from ventas_antigua where vent_num_folio = '".$pven_folio."' and empe_rut = '".$empe_rut."'";
			$res_fo = mysql_query($sql_fo,$conexion);
			if (@mysql_num_rows($res_fo) < 1){
				$ingresa = 'NO';
				$objResponse->addScript("document.getElementById('txtFolio').select();");
				$objResponse->addScript("document.getElementById('txtFolio').focus();");
				$objResponse->addScript("alert('El Folio Ingresado No Existe')");
			}
		}
	}
	
	if ($ingresa == 'SI'){
	
		if ($pven_ncorr == ''){
			//	inserto el registro
			$sql = "insert into pie_vendedor(empe_rut,sect_cod,ve_codigo,co_codigo,pven_folio,pven_fecha,pven_monto,pven_usuario,pven_fechadig)
					values (
					'".$empe_rut."','".$sect_cod."','".$ve_codigo."','".$co_codigo."','".$pven_folio."','".$pven_fecha."',
					'".$pven_monto."','".$pven_usuario."','".$pven_fechadig."')";
			$res = mysql_query($sql,$conexion);
		
		}else{
			//	modifica el registro
			$sql = "update pie_vendedor set
					empe_rut			=	'".$empe_rut."',
					sect_cod			=	'".$sect_cod."',
					ve_codigo			=	'".$ve_codigo."',
					co_codigo			=	'".$co_codigo."',
					pven_folio			=	'".$pven_folio."',
					pven_fecha			=	'".$pven_fecha."',
					pven_monto			=	'".$pven_monto."',
					pven_usuario		=	'".$pven_usuario."',
					pven_fechadig		=	'".$pven_fechadig."'
					
					where
					pven_ncorr = '".$pven_ncorr."'";
			
			$res = mysql_query($sql,$conexion);
		}
		
		$objResponse->addScript("alert('Registro Grabado Correctamente.')");
		$objResponse->addScript("document.location.href='sg_cobranza_registro_pie_vendedor.php';");
	}
	
	return $objResponse->getXML();
}
function Eliminar($data){
	global $conexion;
	
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	$depo_ncorr			=	$data["txtNcorr"];
	
	if ($depo_ncorr != ''){
		//	inserto el registro
		$sql = "delete from pie_vendedor where pven_ncorr = '".$depo_ncorr."'";
		$res = mysql_query($sql,$conexion);
		
		$objResponse->addScript("alert('Registro Eliminado Correctamente.')");
		$objResponse->addScript("document.location.href='sg_cobranza_registro_pie_vendedor.php';");
	}
	
	
	return $objResponse->getXML();
}

function CargaListado($data){
    global $conexion;
	global $miSmarty;
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	$empe_rut			= 	$data["OBLIcboEmpresa"];
	$sect_ncorr			= 	$data["cboSector"];
	$sp_codigo			= 	$data["cboSupervisor"];
	$fecha1				= 	$data["OBLItxtFecha1"];
	$fecha2				= 	$data["OBLItxtFecha2"];
	
	$objResponse->addScript("document.getElementById('divresultado').style.display='none';");
	
	// busca empresa
	$sql_emp = "select empe_ncorr, empe_desc from empresas where empe_rut = '".$empe_rut."'";
	$res_emp = mysql_query($sql_emp,$conexion);
	$empe_ncorr = @mysql_result($res_emp,0,"empe_ncorr");
	$empe_desc  = @mysql_result($res_emp,0,"empe_desc");
	
	// busca sector
	$sql_sec = "select sect_desc from sectores where empe_ncorr = '".$empe_ncorr."' and sect_cod = '".$sect_ncorr."'";
	$res_sec = mysql_query($sql_sec,$conexion);
	$sect_desc = $sect_ncorr." ".@mysql_result($res_sec,0,"sect_desc");
	
	if ($sect_ncorr != '' && $sect_ncorr != 'Todos'){
		$and_sec = " and sect_cod = '".$sect_ncorr."'";
	}
	if ($sp_codigo != '' && $sp_codigo != 'Todos'){
		$and = " and ab_supervisor = '".$sp_codigo."'";
	}
	
	list($dia1,$mes1,$anio1) = split('[/.-]', $fecha1);$fecha1 	= 	$anio1."-".$mes1."-".$dia1;
	list($dia2,$mes2,$anio2) = split('[/.-]', $fecha2);$fecha2 	= 	$anio2."-".$mes2."-".$dia2;
	
	// busca todos los sectores asociados a la empresa
	$sql_sec = "select sect_cod as codigo, sect_desc as descripcion from sectores 
				where 
				empe_ncorr = '".$empe_ncorr."' 
				$and_sec
				order by sect_cod asc";
	$res_sec = mysql_query($sql_sec, $conexion);
	if (@mysql_num_rows($res_sec) > 0) {
		$fecha	=	date("d/m/Y");
		$tbl 	.=	"<table id='tabla' class='grilla-tab' border='0' cellspacing='0' cellpadding='0' width='100%'>";
		$tbl 	.=	"<tr>";
		$tbl 	.=	"<td colspan='4' class='grilla-tab-fila-titulo-rev' align='center'><b>Sectores Visitados Por Supervisor al $fecha</b></td>";
		$tbl 	.=	"</tr>";
		$tbl 	.=	"<tr>";
		$tbl 	.=	"<td class='grilla-tab-fila-titulo-rev' align='center'><b>Empresa</b></td>";
		$tbl 	.=	"<td class='grilla-tab-fila-titulo-rev' align='center'><b>Sector</b></td>";
		$tbl 	.=	"<td class='grilla-tab-fila-titulo-rev' align='center'><b>Supervisor</b></td>";
		$tbl 	.=	"<td class='grilla-tab-fila-titulo-rev' align='center'><b>Fecha</b></td>";
		$tbl 	.=	"</tr>";
		
		while ($line_sec = mysql_fetch_array($res_sec)) {
			$sector 	= $line_sec[0];
			$tbl_sector = $line_sec[0];
			
			// busca la desc del sector
			$sql_dsec = "select sect_desc from sectores where sect_cod = '".$sector."' and empe_ncorr = '".$empe_ncorr."'";
			$res_dsec = mysql_query($sql_dsec,$conexion);
			$sect_desc = $sector." ".@mysql_result($res_dsec,0,"sect_desc");
			
			// arma la tabla abonos
			if (strlen(trim($tbl_sector)) == 1){$tbl_sector = "0".$tbl_sector;}
			$tabla_abonos	= 	"0".$empe_ncorr."_abonos".$tbl_sector;

			// busco los registros
			$sql = "select ab_supervisor, DATE_FORMAT(ab_fechapago,'%d/%m/%Y') from $tabla_abonos 
					where 
					ab_numcuota > '0' and 
					ab_supervisor != '99' and
					ab_fechapago >= '".$fecha1."' and ab_fechapago <= '".$fecha2."'
					$and
					group by ab_supervisor, ab_fechapago
					order by ab_supervisor asc, ab_fechapago asc";
			$res = mysql_query($sql,$conexion);
			while ($line = mysql_fetch_row($res)) {
				$cod_sup 	= 	$line[0];
				
				$fecha 		= 	$line[1];
				
				// busca al supervisor
				$sql_sup = "select sp_nombre from supervisor where sp_codigo = '".$cod_sup."' and sp_empresa = '".$empe_rut."'";
				$res_sup = mysql_query($sql_sup, $conexion);
				$supervisor = $cod_sup." ".@mysql_result($res_sup,0,"sp_nombre");
				
				$tbl 	.=	"<tr>";
				$tbl 	.=	"<td class='grilla-tab-fila-campo-rev' align='left'>".$empe_desc."</td>";
				$tbl 	.=	"<td class='grilla-tab-fila-campo-rev' align='left'>".$sect_desc."</td>";
				$tbl 	.=	"<td class='grilla-tab-fila-campo-rev' align='left'>".$supervisor."</td>";
				$tbl 	.=	"<td class='grilla-tab-fila-campo-rev' align='left'>".$fecha."</td>";
				$tbl 	.=	"</tr>";
			}
		}
		
		$tbl 	.=	"</table>";
		
		// deja visible el div de los botones (impresion, exportacion a excel)
		$objResponse->addScript("document.getElementById('divbotones').style.display='block';");	
		
		$objResponse->addAssign("divresultado", "innerHTML", $tbl);
		$objResponse->addScript("document.getElementById('divresultado').style.display='block';");
	}
	
	return $objResponse->getXML();
}

function CargaPagina($data){
    global $conexion;
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	$ncorr = $data["txtNcorr"];
	
	// busco los datos del pie
	if ($ncorr != ''){
		$sql = "select  
					pven_ncorr,
					empe_rut,
					sect_cod,
					ve_codigo,
					co_codigo,
					pven_folio,
					DATE_FORMAT(pven_fecha,'%d/%m/%Y') as fecha,
					pven_monto
				from 
					pie_vendedor
				where 
					pven_ncorr = '".$ncorr."'";
		
		$res = mysql_query($sql,$conexion);
		
		//  carga las empresas
		$sql_b = "select empe_desc from empresas where empe_rut = '".@mysql_result($res,0,"empe_rut")."'";
		$res_b = mysql_query($sql_b,$conexion);	
		$objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'OBLIcboEmpresa','empresas','".@mysql_result($res,0,"empe_rut")."','".@mysql_result($res_b,0,"empe_desc")."','empe_rut', 'empe_desc', '')");
		
		// carga sectores
		$sql_b = "select sect_desc from sectores where sect_cod = '".@mysql_result($res,0,"sect_cod")."'";
		$res_b = mysql_query($sql_b,$conexion);	
		$objResponse->addScript("xajax_CargaSectores(xajax.getFormValues('Form1'),'".@mysql_result($res,0,"empe_rut")."','".@mysql_result($res,0,"sect_cod")."','".@mysql_result($res_b,0,"sect_desc")."')");
	
		// carga vendedores
		$sql_b = "select ve_vendedor from vendedores where ve_codigo = '".@mysql_result($res,0,"ve_codigo")."' and ve_empresa = '".@mysql_result($res,0,"empe_rut")."'";
		$res_b = mysql_query($sql_b,$conexion);	
		$objResponse->addScript("xajax_CargaVendedores(xajax.getFormValues('Form1'),'".@mysql_result($res,0,"empe_rut")."','".@mysql_result($res,0,"ve_codigo")."','".@mysql_result($res_b,0,"ve_vendedor")."')");
		
		// carga cobradores
		$sql_b = "select co_nombre from cobrador where co_codigo = '".@mysql_result($res,0,"co_codigo")."' and co_empresa = '".@mysql_result($res,0,"empe_rut")."'";
		$res_b = mysql_query($sql_b,$conexion);	
		$objResponse->addScript("xajax_CargaCobradores(xajax.getFormValues('Form1'),'".@mysql_result($res,0,"empe_rut")."','".@mysql_result($res,0,"co_codigo")."','".@mysql_result($res_b,0,"co_nombre")."')");
	

		$objResponse->addAssign("txtFolio", "value", @mysql_result($res,0,"pven_folio"));
		
		$objResponse->addAssign("OBLItxtFecha1", "value", @mysql_result($res,0,"fecha"));
		$objResponse->addAssign("OBLItxtMonto", "value", @mysql_result($res,0,"pven_monto"));
	
	}else{
		//  carga las empresas
		$objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'OBLIcboEmpresa','empresas','','- - Seleccione - -','empe_rut', 'empe_desc', '')");
		
	}	
	
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

function CargaSectores($data,$emp,$cod,$desc){
    global $conexion;
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	
	$empe_rut	=	$data["OBLIcboEmpresa"];
	$select		=	"OBLIcboSector";
	
	$objResponse->addAssign("$select","innerHTML",""); 		
	
	if ($emp != ''){
		$empe_rut = $emp;
	}
	
	// busca empe_ncorr
	$sql_emp = "select empe_ncorr from empresas where empe_rut = '".$empe_rut."'";
	$res_emp = mysql_query($sql_emp,$conexion);
	$empe_ncorr = @mysql_result($res_emp,0,"empe_ncorr");
	
	$sql = "select sect_cod as codigo, sect_desc as descripcion from sectores where empe_ncorr = '".$empe_ncorr."' order by sect_cod asc";
	$res = mysql_query($sql, $conexion);
	$objResponse->addCreate("$select","option",""); 		
	
	if ($cod != '' && $desc != ''){
		$objResponse->addAssign("$select","options[0].value", $cod);
		$objResponse->addAssign("$select","options[0].text", $cod." -- ".$desc); 	
	}else{
		$objResponse->addAssign("$select","options[0].value", '');
		$objResponse->addAssign("$select","options[0].text", '- - Seleccione - -'); 	
	}
	
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
function CargaCobradores($data,$emp,$cod,$desc){
    global $conexion;
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	
	$empe_rut	=	$data["OBLIcboEmpresa"];
	$select		=	"OBLIcboCobrador";
	
	$objResponse->addAssign("$select","innerHTML",""); 		
	
	if ($emp != ''){
		$empe_rut = $emp;
	}
	
	$sql = "select co_codigo as codigo, co_nombre as nombre from cobrador where co_empresa = '".$empe_rut."' order by co_codigo asc";
	$res = mysql_query($sql, $conexion);
	$objResponse->addCreate("$select","option",""); 		
	
	if ($cod != '' && $desc != ''){
		$objResponse->addAssign("$select","options[0].value", $cod);
		$objResponse->addAssign("$select","options[0].text", $cod." -- ".$desc); 	
	}else{
		$objResponse->addAssign("$select","options[0].value", '');
		$objResponse->addAssign("$select","options[0].text", '- - Seleccione - -'); 	
	}
	
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
function CargaVendedores($data,$emp,$cod,$desc){
    global $conexion;
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	
	$empe_rut	=	$data["OBLIcboEmpresa"];
	$select		=	"OBLIcboVendedor";
	
	$objResponse->addAssign("$select","innerHTML",""); 		
	
	if ($emp != ''){
		$empe_rut = $emp;
	}
	
	$sql = "select ve_codigo as codigo, ve_vendedor as nombre from vendedores where ve_empresa = '".$empe_rut."' order by ve_codigo asc";
	$res = mysql_query($sql, $conexion);
	$objResponse->addCreate("$select","option",""); 		
	
	if ($cod != '' && $desc != ''){
		$objResponse->addAssign("$select","options[0].value", $cod);
		$objResponse->addAssign("$select","options[0].text", $cod." -- ".$desc); 	
	}else{
		$objResponse->addAssign("$select","options[0].value", '');
		$objResponse->addAssign("$select","options[0].text", '- - Seleccione - -'); 	
	}
	
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
$xajax->registerFunction("Eliminar");


$xajax->processRequests();
$miSmarty->assign('xajax_js', $xajax->getJavascript());
$miSmarty->assign('NCORR', $_GET["ncorr"]);

$miSmarty->display('sg_cobranza_registro_pie_vendedor.tpl');

?>

