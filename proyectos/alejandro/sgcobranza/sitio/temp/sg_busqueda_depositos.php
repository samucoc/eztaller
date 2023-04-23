<?php
session_start();

require_once 'includes/xajax/xajax.inc.php'; //archivo de configuracion de ajax
include "../includes/php/conf_smarty.php";//archivo de configuracion de smarty
include "../includes/php/conf_bd.php"; //archivo de coneccion al servidor y base de datos
//include "../includes/php/conf_bd_antigua.php"; //archivo de coneccion al servidor de yonley
//include "../includes/php/sgbodega.php"; 
include "../includes/php/validaciones.php"; 

//$servidor = "localhost";
//$usuario = "root";
//$pass = "admin";
//$bd = "sgyonley";
//
//$conexion = mysql_connect($servidor, $usuario, $pass);
//mysql_select_db($bd, $conexion);

$xajax = new xajax();

$xajax->setRequestURI("sg_busqueda_depositos.php");
$xajax->setCharEncoding("ISO-8859-1");
$xajax->decodeUTF8InputOn();

function Grabar($data){
	global $conexion;
	
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	$objResponse->addScript("document.getElementById('divprogreso').style.display='block';");	
	$objResponse->addScript("xajax_CargaListado(xajax.getFormValues('Form1'))");
	
	return $objResponse->getXML();
}

function CargaListado($data){
    global $conexion;
	global $miSmarty;
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	/*
	$empe_rut			= 	$data["OBLIcboEmpresa"];
	$sect_cod			= 	$data["cboSector"];
	$co_codigo			= 	$data["cboCobrador"];
	*/
	
	$banc_ncorr			= 	$data["cboBanco"];
	$cta_cte			= 	$data["cboCtaCte"];
	$tdep_ncorr			= 	$data["cboTipo"];
	$fecha1				= 	$data["OBLItxtFecha1"];
	$fecha2				= 	$data["OBLItxtFecha2"];
	
	$objResponse->addScript("document.getElementById('divresultado').style.display='none';");
	
	if ($banc_ncorr != '' && $banc_ncorr != 'Todos'){
		$and .= " and banc_ncorr = '".$banc_ncorr."'";
	}
	if ($cta_cte != '' && $cta_cte != 'Todas'){
		$and .= " and cta_cte = '".$cta_cte."'";
	}
	if ($tdep_ncorr != '' && $tdep_ncorr != 'Todos'){
		$and .= " and tdep_ncorr = '".$tdep_ncorr."'";
	}
	
	
	list($dia1,$mes1,$anio1) = split('[/.-]', $fecha1);	$fecha1 	= 	$anio1."-".$mes1."-".$dia1;
	list($dia2,$mes2,$anio2) = split('[/.-]', $fecha2);	$fecha2 	= 	$anio2."-".$mes2."-".$dia2;
	
	$fecha_inicial = "2012-01-24";
	
	// busco los registros
	$sql = "select 
				depo_ncorr as ncorr,
				empe_rut,
				sect_cod,
				co_codigo,
				banc_ncorr,
				DATE_FORMAT(depo_fecha,'%d/%m/%Y'),
				depo_numtransac,
				depo_monto,
				depo_usuario,
				DATE_FORMAT(depo_fechadeposito,'%d/%m/%Y'),
				tdep_ncorr as tipo_deposito,
				cta_cte as ctacte,
				depo_sucursal as sucursal

			from
				sgyonley.depositos
			where
				depo_fechadeposito > '".$fecha_inicial."' and
				depo_fechadeposito >= '".$fecha1."' and depo_fechadeposito <= '".$fecha2."'
				$and
				
				order by depo_fechadeposito asc, depo_ncorr asc";
	
	$res = mysql_query($sql, $conexion);
	
	if (@mysql_num_rows($res) > 0) {
		
		$arrRegistros		= 	array();
		
		while ($line = mysql_fetch_array($res)) {
			
			// si no esta confirmado muestro el registro
			$sql_conf = "select drev_ncorr from sgbanco.depositos_revisados where depo_ncorr = '".$line[0]."'";
			$res_conf = mysql_query($sql_conf,$conexion);
			
			if (@mysql_num_rows($res_conf) < 1){
				
				/*
				// busca empresa
				$sql_emp = "select empe_ncorr, empe_desc from empresas where empe_rut = '".$line[1]."'";
				$res_emp = mysql_query($sql_emp,$conexion);
				$empe_ncorr = @mysql_result($res_emp,0,"empe_ncorr");
				$empe_desc  = @mysql_result($res_emp,0,"empe_desc");
				
				// busca la desc del sector
				$sql_dsec = "select sect_desc from sectores where sect_cod = '".$line[2]."' and empe_ncorr = '".$empe_ncorr."'";
				$res_dsec = mysql_query($sql_dsec,$conexion);
				$sect_desc = $line[2]." ".@mysql_result($res_dsec,0,"sect_desc");
				
				// busca al cobrador
				$sql_dcob = "select co_nombre from cobrador where co_codigo = '".$line[3]."' and co_empresa = '".$empe_rut."'";
				$res_dcob = mysql_query($sql_dcob,$conexion);
				$cob_desc = $line[3]." ".@mysql_result($res_dcob,0,"co_nombre");
				*/
				
				// busca el tipo de depositos
				$sql_td = "select tdep_desc from tipos_depositos where tdep_ncorr = '".$line[10]."'";
				$res_td = mysql_query($sql_td,$conexion);
				$tdep_desc = @mysql_result($res_td,0,"tdep_desc");
				
				// busca la cuenta corriente
				$sql_ct = "select CaNumero from sgbanco.cuentas where CaId = '".$line[11]."'";
				$res_ct = mysql_query($sql_ct,$conexion);
				$CaNumero = @mysql_result($res_ct,0,"CaNumero");
				
				// busca al banco
				$sql_banc = "select banc_desc from bancos where banc_ncorr = '".$line[4]."'";
				$res_banc = mysql_query($sql_banc,$conexion);
				$banc_desc = $line[4]." ".@mysql_result($res_banc,0,"banc_desc");
				
				array_push($arrRegistros, array("ncorr"		=>	$line[0],
												"codigo"	=>	$line[0],
												"empresa"	=> 	$empe_desc,
												"sector"	=>	$sect_desc,
												"cobrador"	=>	$cob_desc,
												"tipo"		=> 	$tdep_desc,
												"banco"		=> 	$banc_desc,
												"cta"		=> 	$CaNumero,
												"fechacob"	=> 	$line[5],
												"fechadep"	=> 	$line[9],
												"transac"	=> 	$line[6],
												"monto"		=> 	number_format($line[7], 0, ',', '.'),
												"sucursal"	=> 	$line[12],
												"usuario"	=> $line[8]));
			}
		}
		
		$miSmarty->assign('arrRegistros', $arrRegistros);
		
		// deja visible el div de los botones (impresion, exportacion a excel)
		$objResponse->addScript("document.getElementById('divbotones').style.display='block';");	
		
		$objResponse->addAssign("divresultado", "innerHTML", $miSmarty->fetch('sg_busqueda_depositos_list.tpl'));
		$objResponse->addScript("document.getElementById('divresultado').style.display='block';");
		
		if ($_SESSION["alycar_ncorr"] != ''){
			$ncorrfocus = intval($_SESSION["alycar_ncorr"]) + 1;
			$objResponse->addScript("document.getElementById('$ncorrfocus').focus();");
		}
		
		$objResponse->addScript("document.getElementById('divprogreso').style.display='none';");
	
	}else{
		$objResponse->addScript("alert('No se encontraron registros.')");
		$objResponse->addScript("document.getElementById('divprogreso').style.display='none';");
	}
	
	
	return $objResponse->getXML();
}
function Confirmar($ncorr){
	global $conexion;
	
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	$depo_ncorr			=	$ncorr;
	$drev_fechadig		=	date("Y-m-d H:i:s");
	$drev_usuario		=	$_SESSION["alycar_usuario"];
	
	$sql = "insert into sgbanco.depositos_revisados (depo_ncorr,drev_fechadig,drev_usuario)
			values ('".$depo_ncorr."','".$drev_fechadig."','".$drev_usuario."')";
	$res = mysql_query($sql,$conexion);
	
	$_SESSION["alycar_ncorr"]	=	$ncorr;
	
	$objResponse->addScript("xajax_Grabar(xajax.getFormValues('Form1'))");	
	
	$objResponse->addScript("alert('Se ha confirmado correctamente el dep�sito c�d. $ncorr')");
	
	return $objResponse->getXML();
}

function CargaPagina($data){
    global $conexion;
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	//  carga las bancos
	$objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'cboBanco','sgyonley.bancos','','Todos','banc_ncorr', 'banc_desc', '')");
	
	//  carga los tipos de depositos
	$objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'cboTipo','sgyonley.tipos_depositos','','Todos','tdep_ncorr', 'tdep_desc', '')");
	
	$objResponse->addScript("document.getElementById('cboBanco').focus();");
	
	return $objResponse->getXML();
}

function CargaSelect($data, $select, $tabla, $codigo, $descripcion, $campo1, $campo2, $opt){
    global $conexion;
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	//mysql_select_db("sgyonley", $conexion);
	
	
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
function CargaCtasCtes($data){
    global $conexion;
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	
	$select 		= 	"cboCtaCte";
	$banc_ncorr 	=	$data["cboBanco"];
	
	$objResponse->addAssign("$select","innerHTML",""); 		
	$sql = "select CaId, CaNumero from sgbanco.cuentas where banc_ncorr = '".$banc_ncorr."'";
	$res = mysql_query($sql, $conexion);
	$objResponse->addCreate("$select","option",""); 		
	$objResponse->addAssign("$select","options[0].value", "");
	$objResponse->addAssign("$select","options[0].text", "Todas"); 	
	
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
	$sql_emp = "select empe_ncorr from empresas where empe_rut = '".$empe_rut."'";
	$res_emp = mysql_query($sql_emp,$conexion);
	$empe_ncorr = @mysql_result($res_emp,0,"empe_ncorr");
	
	$sql = "select sect_cod as codigo, sect_desc as descripcion from sectores where empe_ncorr = '".$empe_ncorr."' order by sect_cod asc";
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
	
	$sql = "select co_codigo as codigo, co_nombre as nombre from cobrador where co_empresa = '".$empe_rut."' order by co_codigo asc";
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
$xajax->registerFunction("Mostrar");
$xajax->registerFunction("Confirmar");
$xajax->registerFunction("CargaCtasCtes");

$xajax->processRequests();
$miSmarty->assign('xajax_js', $xajax->getJavascript());

$miSmarty->display('sg_busqueda_depositos.tpl');

?>

