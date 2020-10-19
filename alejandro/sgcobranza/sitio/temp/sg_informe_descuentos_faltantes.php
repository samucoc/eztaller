<?php
session_start();

require_once 'includes/xajax/xajax.inc.php'; //archivo de configuracion de ajax
include "../includes/php/conf_smarty.php";//archivo de configuracion de smarty
include "../includes/php/conf_bd.php"; //archivo de coneccion al servidor y base de datos
//include "../includes/php/conf_bd_antigua.php"; //archivo de coneccion al servidor de yonley
//include "../includes/php/sgbodega.php"; 
include "../includes/php/validaciones.php"; 

$xajax = new xajax();

$xajax->setRequestURI("sg_informe_descuentos_faltantes.php");
$xajax->setCharEncoding("ISO-8859-1");
$xajax->decodeUTF8InputOn();

function Grabar($data){
	global $conexion;
	
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	$objResponse->addScript("document.getElementById('divprogreso').style.display='block';");
	$objResponse->addScript("document.getElementById('divresultado').style.display='none';");
	$objResponse->addScript("document.getElementById('divbotones').style.display='none';");	
	
	$objResponse->addScript("xajax_CargaListado(xajax.getFormValues('Form1'))");
	
	return $objResponse->getXML();
}

function CargaListado($data){
    global $conexion;
	global $miSmarty;
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	$empe_rut		= 	$data["OBLIcboEmpresa"];
	$sect_cod		= 	$data["OBLIcboSector"];
	$co_codigo		= 	$data["OBLIcboCobrador"];
	$sp_codigo		= 	$data["OBLIcboSupervisor"];
	$fecha1			= 	$data["OBLItxtFecha1"];
	$fecha2			= 	$data["OBLItxtFecha2"];
	$sector			=	$sect_cod;
	$fecha1esp		= 	$data["OBLItxtFecha1"];
	
	//$objResponse->addScript("document.getElementById('divresultado').style.display='none';");
	//$objResponse->addScript("document.getElementById('divbotones').style.display='none';");	
	
	list($dia1,$mes1,$anio1) = explode('/', $fecha1);	$fecha1 	= 	$anio1."-".$mes1."-".$dia1;
	list($dia2,$mes2,$anio2) = explode('/', $fecha2);	$fecha2 	= 	$anio2."-".$mes2."-".$dia2;
	
	$sql_fec 	= 	"SELECT DATEDIFF('".$fecha2."','".$fecha1."') as dias";
	$res_fec 	=	mysql_query($sql_fec,$conexion);
	$dias		=	@mysql_result($res_fec,0,"dias");
	if ($dias >= 0){
	
		// busca la empe_ncorr
		$sql_emp = "select empe_ncorr, empe_desc from sgyonley.empresas where empe_rut = '".$empe_rut."'";
		$res_emp = mysql_query($sql_emp,$conexion);
		$empe_ncorr = @mysql_result($res_emp,0,"empe_ncorr");
		$empe_desc 	= @mysql_result($res_emp,0,"empe_desc");
		
		// busca el sector
		$sql_sec = "select sect_desc from sgyonley.sectores where sect_cod = '".$sect_cod."' and empe_ncorr = '".$empe_ncorr."'";
		$res_sec = mysql_query($sql_sec,$conexion);
		$sect_desc 	= @mysql_result($res_sec,0,"sect_desc");
		
		// busca al cobrador
		$sql_cob = "select co_nombre from sgyonley.cobrador where co_codigo = '".$co_codigo."' and co_empresa = '".$empe_rut."'";
		$res_cob = mysql_query($sql_cob,$conexion);
		$co_nombre 	= @mysql_result($res_cob,0,"co_nombre");
		
		// busca al supervisor
		$sql_sup = "select sp_nombre from sgyonley.supervisor where sp_codigo = '".$sp_codigo."' and sp_empresa = '".$empe_rut."'";
		$res_sup = mysql_query($sql_sup,$conexion);
		$sp_nombre 	= @mysql_result($res_sup,0,"sp_nombre");
		
		if (strlen(trim($sector)) == 1){$sector = "0".$sector;}
		$tabla_abonos	= 	"0".$empe_ncorr."_abonos".$sector;
		
		$fecha	=	date("d/m/Y");
		
		$i = 0;
		
		while ($i <= $dias) {
		
			// busca la cobranza
			/*
			$sql_t1 = "select 
						SUM(AB_VALOR) as total_cobranza
						
						from 
						$tabla_abonos
						
						WHERE
						AB_FECHAPAGO = '".$fecha1."' AND
						AB_EMPRESA = '".$empe_rut."' AND
						AB_SECTOR = '".$sector."' AND
						AB_COBRADOR = '".$co_codigo."' AND
						ab_cambio_sector = 'NO'";
			*/
			
			// busca la cobranza (SOLO CONSIDERA LOS ABONOS NORMALES)
			$sql_t1 = "select 
						SUM(AB_VALOR) as total_cobranza, AB_SUPERVISOR
						
						from 
						sgyonley.$tabla_abonos
						
						WHERE
						AB_FECHAPAGO = '".$fecha1."' AND
						AB_EMPRESA = '".$empe_rut."' AND
						AB_SECTOR = '".$sector."' AND
						AB_COBRADOR = '".$co_codigo."' AND
						ab_cambio_sector = 'NO' AND
						tabo_ncorr in ('1','4')";
			
			$res_t1 = mysql_query($sql_t1, $conexion);
			
			$total_cobranza = @mysql_result($res_t1,0,"total_cobranza");
			$sp_codigo = @mysql_result($res_t1,0,"AB_SUPERVISOR");

			// busca al supervisor
			$sql_sup = "select sp_nombre from supervisor where sp_codigo = '".$sp_codigo."' and sp_empresa = '".$empe_rut."'";
			$res_sup = mysql_query($sql_sup,$conexion);
			$sp_nombre 	= @mysql_result($res_sup,0,"sp_nombre");
			
			$sql_t1 = "select 
						SUM(AB_VALOR) as total_cobranza
						
						from 
						sgyonley.$tabla_abonos
						
						WHERE
						AB_FECHAPAGO = '".$fecha1."' AND
						AB_EMPRESA = '".$empe_rut."' AND
						AB_SECTOR = '".$sector."' AND
						AB_COBRADOR = '".$co_codigo."' AND
						ab_cambio_sector = 'NO' AND
						tabo_ncorr = '4'";
			
			$res_t1 = mysql_query($sql_t1, $conexion);
			
			$total_cobranza_1 = @mysql_result($res_t1,0,"total_cobranza");
			
			
			//busca la sumatoria del deposito
			$sql_dep = "select sum(depo_monto) as total_deposito from sgyonley.depositos
						where 
						empe_rut = '".$empe_rut."' and
						sect_cod = '".$sect_cod."' and
						co_codigo = '".$co_codigo."' and
						depo_fecha = '".$fecha1."'";
						
			$res_dep = mysql_query($sql_dep,$conexion);
			$total_deposito	=	@mysql_result($res_dep,0,"total_deposito");
					
			//busca la sumatoria del pie vendedor
			$sql_pve = "select sum(pven_monto) as total_pie_vendedor from sgyonley.pie_vendedor
						where 
						empe_rut = '".$empe_rut."' and
						sect_cod = '".$sect_cod."' and
						co_codigo = '".$co_codigo."' and
						pven_fecha = '".$fecha1."'";
						
			$res_pve = mysql_query($sql_pve,$conexion);
			$total_pie_vendedor		=	@mysql_result($res_pve,0,"total_pie_vendedor");
			
			//busca la sumatoria del sobrante cliente
			$sql_scli = "select sum(scli_monto) as total_sob_cliente from sgyonley.sobrante_cliente
						where 
						empe_rut = '".$empe_rut."' and
						sect_cod = '".$sect_cod."' and
						co_codigo = '".$co_codigo."' and
						scli_fecha = '".$fecha1."'";
						
			$res_scli = mysql_query($sql_scli,$conexion);
			$total_sob_cliente		=	@mysql_result($res_scli,0,"total_sob_cliente");
			
			//busca la sumatoria del sobrante ocupado
			$sql_socu = "select sum(a.scas_monto) as total_sob_ocupado from 
						sgyonley.sobrante_cliente_asignacion a, sgyonley.sobrante_cliente b
						where 
						(b.empe_rut 		= 	'".$empe_rut."' and
						b.sect_cod 		= 	'".$sect_cod."' and
						b.co_codigo 	= 	'".$co_codigo."' and
						a.co_codigo 	= 	'".$co_codigo."' and
						b.scli_ncorr 	= 	a.scli_ncorr and
						a.scas_fechacob = 	'".$fecha1."')
						or (
						b.empe_rut 		= 	'".$empe_rut."' and
						b.sect_cod 		= 	'".$sect_cod."' and
						b.co_codigo 	= 	'".$co_codigo."' and
						a.co_codigo 	= 	'' and
						b.scli_ncorr 	= 	a.scli_ncorr and
						a.scas_fechacob = 	'".$fecha1."'
						)";
						
			$res_socu = mysql_query($sql_socu,$conexion);
			$total_sob_ocupado		=	@mysql_result($res_socu,0,"total_sob_ocupado");
				
			//busca la sumatoria del sobrante ocupado
			$sql_socu = "select sum(a.scas_monto) as total_sob_ocupado from 
						sgyonley.sobrante_cliente_asignacion a, sgyonley.sobrante_cliente b
						where 
						b.empe_rut 		= 	'".$empe_rut."' and
						b.sect_cod 		= 	'".$sect_cod."' and
						a.co_codigo 	= 	'".$co_codigo."' and
						b.co_codigo 	<> 	'".$co_codigo."' and
						b.scli_ncorr 	= 	a.scli_ncorr and
						a.scas_fechacob = 	'".$fecha1."'";
						
			$res_socu = mysql_query($sql_socu,$conexion);
			$total_sob_ocupado		+=	@mysql_result($res_socu,0,"total_sob_ocupado");
			$resultado = $total_cobranza - $total_cobranza_1 - $total_deposito - $total_pie_vendedor + $total_sob_cliente - $total_sob_ocupado;	
					//$objResponse->addAlert("$total_cobranza - $total_cobranza_1 - $total_deposito - $total_pie_vendedor + $total_sob_cliente - $total_sob_ocupado;	");
			$resultado_sup = 0;	
			if ($sp_codigo != '99'){
				$resultado_sup = $resultado;
				$resultado = 0;
					//$objResponse->addAlert("$total_cobranza_sup - $total_cobranza_1_sup - $total_deposito - $total_pie_vendedor + $total_sob_cliente - $total_sob_ocupado;");
				}
			else{
				$resultado_sup = 0;
				}

			$sobrante = 0;
			$faltante = 0;
			
			$sobrante_sup = 0;
			$faltante_sup = 0;
			
			/*
			if ($resultado > 0){$sobrante = $resultado;}
			if ($resultado < 0){$faltante = $resultado; $faltante = $faltante * -1;}
			*/
			
			if ($resultado > 0){$faltante = $resultado;}
			if ($resultado < 0){$sobrante = $resultado; $sobrante = $sobrante * -1;}
			
			$total_sobrante = $total_sobrante + $sobrante;
			$total_faltante = $total_faltante + $faltante;
			
			if ($resultado_sup > 0){$faltante_sup = $resultado_sup;}
			if ($resultado_sup < 0){$sobrante_sup = $resultado_sup; $sobrante_sup = $sobrante_sup * -1;}
			
			$total_sobrante_sup = $total_sobrante_sup + $sobrante_sup;
			$total_faltante_sup = $total_faltante_sup + $faltante_sup;
			
			if ($sp_nombre==''){
				$sp_nombre='SIN SUPERVISOR';
				}
			
			// incremento el dia a fecha1
			$sql_ife 	= 	"SELECT DATE_ADD('".$fecha1."', INTERVAL 1 DAY) as fecha1, DATE_FORMAT(DATE_ADD('".$fecha1."', INTERVAL 1 DAY),'%d/%m/%Y') as fecha1esp";
			$res_ife 	= 	mysql_query($sql_ife,$conexion);
			$fecha1		=	@mysql_result($res_ife,0,"fecha1");
			$fecha1esp	=	@mysql_result($res_ife,0,"fecha1esp");
			
			$i++;
			
		}

		
		$resultado_total 	= 	$total_sobrante - $total_faltante;
		$texto_total		=	"Total Cobrador";	
		
		if ($total_faltante > $total_sobrante){
			$texto_total	=	"Total Faltante Cobrador";
			$resultado_total = $resultado_total * -1;
		}
		if ($total_faltante < $total_sobrante){
			$texto_total	=	"Total Sobrante Cobrador";
		}
		
		$resultado_total_sup 	= 	$total_sobrante_sup - $total_faltante_sup;
		$texto_total_sup		=	"Total Supervisor";	
		
		if ($total_faltante_sup > $total_sobrante_sup){
			$texto_total_sup	=	"Total Faltante Supervisor:";
			$resultado_total_sup = $resultado_total_sup * -1;
		}
		if ($total_faltante_sup <= $total_sobrante_sup){
			$texto_total_sup	=	"Total Sobrante Supervisor:";
		}
		
		$tbl 	.=	"<table id='tabla' class='grilla-tab' border='0' cellspacing='0' cellpadding='0' width='100%'>";
		$tbl 	.=	"<tr>";
		$tbl 	.=	"<td colspan='12' class='grilla-tab-fila-titulo-rev' align='center'><b>Resumen de Sobrantes y Faltantes</b></td>";
		$tbl 	.=	"</tr>";
		$tbl 	.=	"<tr>";
		$tbl 	.=	"<td class='grilla-tab-fila-titulo-rev' align='center'><b>Empresa</b></td>";
		$tbl 	.=	"<td class='grilla-tab-fila-campo' align='left'>".$empe_desc."</td>";
		$tbl 	.=	"</tr>";
		$tbl 	.=	"<tr>";
		$tbl 	.=	"<td class='grilla-tab-fila-titulo-rev' align='center'><b>Sector</b></td>";
		$tbl 	.=	"<td class='grilla-tab-fila-campo' align='left'>".$sect_desc."</td>";
		$tbl 	.=	"</tr>";
		$tbl 	.=	"<tr>";
		$tbl 	.=	"<td class='grilla-tab-fila-titulo-rev' align='center'><b>Cobrador</b></td>";
		$tbl 	.=	"<td class='grilla-tab-fila-campo' align='left'>".$co_nombre."</td>";
		$tbl 	.=	"</tr>";
		$tbl 	.=	"<tr>";
		$tbl 	.=	"<td class='grilla-tab-fila-titulo-rev' align='center'><b>Supervisor</b></td>";
		$tbl 	.=	"<td class='grilla-tab-fila-campo' align='left'>".$sp_nombre."</td>";
		$tbl 	.=	"</tr>";
		$tbl 	.=	"<tr>";
		$tbl 	.=	"<td class='grilla-tab-fila-titulo-rev' align='center'><b>Fecha</b></td>";
		$tbl 	.=	"<td class='grilla-tab-fila-campo' align='left'>".$data["OBLItxtFecha1"]." al ".$data["OBLItxtFecha2"]."</td>";
		$tbl 	.=	"</tr>";
		$tbl 	.=	"<tr>";
		$tbl 	.=	"<td class='grilla-tab-fila-titulo-rev' align='center'><b>".$texto_total_sup."</b></td>";
		$tbl 	.=	"<td class='grilla-tab-fila-campo' align='left'><b>".number_format($resultado_total_sup, 0, ',', '.')."</b></td>";
		$tbl 	.=	"</tr>";
		$tbl 	.=	"<tr>";
		$tbl 	.=	"<td class='grilla-tab-fila-titulo-rev' align='center'><b>".$texto_total."</b></td>";
		$tbl 	.=	"<td class='grilla-tab-fila-campo' align='left'><b>".number_format($resultado_total, 0, ',', '.')."</b></td>";
		$tbl 	.=	"</tr>";
		
		$tbl 	.=	"</table>";
		
		// deja visible el div de los botones (impresion, exportacion a excel)
		$objResponse->addScript("document.getElementById('divbotones').style.display='block';");	
		
		$objResponse->addAssign("divresultado", "innerHTML", $tbl);
		//$objResponse->addScript("document.getElementById('divresultado').style.display='block';");
		
		$objResponse->addScript("document.getElementById('divresultado').style.display='block';");
		
		$objResponse->addScript("document.getElementById('divprogreso').style.display='none';");

	}
	
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
	$select		=	"OBLIcboSector";
	
	$objResponse->addAssign("$select","innerHTML",""); 		
	
	// busca empe_ncorr
	$sql_emp = "select empe_ncorr from sgyonley.empresas where empe_rut = '".$empe_rut."'";
	$res_emp = mysql_query($sql_emp,$conexion);
	$empe_ncorr = @mysql_result($res_emp,0,"empe_ncorr");
	
	$sql = "select sect_cod as codigo, sect_desc as descripcion from sgyonley.sectores where empe_ncorr = '".$empe_ncorr."' order by sect_cod asc";
	$res = mysql_query($sql, $conexion);
	$objResponse->addCreate("$select","option",""); 		
	$objResponse->addAssign("$select","options[0].value", '');
	$objResponse->addAssign("$select","options[0].text", '- - Seleccione - -'); 	
	
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
	$select		=	"OBLIcboCobrador";
	
	$objResponse->addAssign("$select","innerHTML",""); 		
	
	$sql = "select co_codigo as codigo, co_nombre as nombre from sgyonley.cobrador where co_empresa = '".$empe_rut."' order by co_codigo asc";
	$res = mysql_query($sql, $conexion);
	$objResponse->addCreate("$select","option",""); 		
	$objResponse->addAssign("$select","options[0].value", '');
	$objResponse->addAssign("$select","options[0].text", '- - Seleccione - -'); 	
	
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

function CargaSupervisores($data){
    global $conexion;
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	
	$empe_rut	=	$data["OBLIcboEmpresa"];
	$select		=	"OBLIcboSupervisor";
	
	$objResponse->addAssign("$select","innerHTML",""); 		
	
	$sql = "select sp_codigo as codigo, sp_nombre as nombre from sgyonley.supervisor where sp_empresa = '".$empe_rut."' order by sp_codigo asc";
	$res = mysql_query($sql, $conexion);
	$objResponse->addCreate("$select","option",""); 		
	$objResponse->addAssign("$select","options[0].value", '');
	$objResponse->addAssign("$select","options[0].text", '- - Seleccione - -'); 	
	
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
$xajax->registerFunction("CargaSupervisores");
$xajax->registerFunction("Mostrar");


$xajax->processRequests();
$miSmarty->assign('xajax_js', $xajax->getJavascript());

$miSmarty->display('sg_informe_descuentos_faltantes.tpl');

?>

