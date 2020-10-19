<?php
session_set_cookie_params('18000'); // 5 HORAS
session_start();

require_once 'includes/xajax/xajax.inc.php'; //archivo de configuracion de ajax
include "../includes/php/conf_smarty.php";//archivo de configuracion de smarty
include "../includes/php/conf_bd.php"; //archivo de coneccion al servidor y base de datos
//include "../includes/php/conf_bd_antigua.php"; //archivo de coneccion al servidor de yonley
include "../includes/php/validaciones.php"; 

$xajax = new xajax();

$xajax->setRequestURI("sg_bodega_elimina_guia_motivo.php");
$xajax->setCharEncoding("ISO-8859-1");
$xajax->decodeUTF8InputOn();

function Grabar($data){
	global $conexion;
	global $miSmarty;
	
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	$movim_ncorr		=	$data["txtNcorr"];
	$meli_ncorr			=	$data["OBLI-cboMotivo"];
	$geli_obs			=	$data["txtObservacion"];
	$geli_fecha_dig		=	date("Y-m-d H:i:s");
	$geli_usuario		=	$_SESSION["alycar_sgyonley_usuario"];
	
	// ingresa el registro
	$sql = "insert into sgbodega.guias_eliminadas (movim_ncorr,meli_ncorr,geli_obs,geli_fecha_dig,geli_usuario)
			values ('".$movim_ncorr."','".$meli_ncorr."','".$geli_obs."','".$geli_fecha_dig."','".$geli_usuario."')";
	
	$res = mysql_query($sql, $conexion);
	
	// elimina la guia
	$sql_del1 = "delete from sgbodega.movim where movim_ncorr = '".$movim_ncorr."'";
	$res_del1 = mysql_query($sql_del1, $conexion);
	
	// elimina el detalle de la guia
	$sql_del2 = "delete from sgbodega.movim_detalle where movim_ncorr = '".$movim_ncorr."'";
	$res_del2 = mysql_query($sql_del2, $conexion);
	
	$objResponse->addScript("alert('Guia Eliminada Correctamente')");
	
	$objResponse->addScript("window.parent.xajax_Volver(window.parent.xajax.getFormValues('Form1'))");
	$objResponse->addScript("window.parent.hidePopWin(true)");	
	
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
	
	$ncorr 		= 	$data["$objeto1"];
	
	$sql = "select $campo2 as descripcion from sgyonley.$tabla where $campo1 = '".$ncorr."' $and";
	
	$res = mysql_query($sql, $conexion);
	
	$objResponse->addAssign("$objeto2", "value", @mysql_result($res,0,"descripcion"));
	
	return $objResponse->getXML();
}
function Nueva($data){
    global $conexion;
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	$objResponse->addScript("window.document.Form1.submit();");

	return $objResponse->getXML();
}

function CargaPagina($data){
    global $conexion;
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	$ncorr = $data["txtNcorr"];
	
	$objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'OBLI-cboMotivo','sgbodega.motivos_eliminaciones','','- - Seleccione - -','meli_ncorr', 'meli_desc', '')");
	$objResponse->addScript("document.getElementById('OBLI-cboMotivo').focus();");
	
	return $objResponse->getXML();
}          
function Elimina($data, $ncorr){
	global $conexion;
	
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	// busca el folio y el sector del abono
	$sql = "select ab_folio, ab_sector from abonos where ab_index = '".$ncorr."'";
	$res = mysql_query($sql, $conexion);
	$folio = @mysql_result($res,0,"ab_folio");
	$sector = @mysql_result($res,0,"ab_sector");
	
	if (strlen(trim($sector)) == 1){$sector = "0".$sector;}
	$tabla_abonos	= 	"0".$_SESSION["alycar_sgyonley_empresa"]."_abonos".$sector;
	
	// elimino el abono
	$sql = "delete from abonos where ab_index = '".$ncorr."'";
	$res = mysql_query($sql, $conexion);
	
	// elimino el detalle de abonos y cuotas
	$sql = "delete from $tabla_abonos where ab_index = '".$ncorr."'";
	$res = mysql_query($sql, $conexion);
	
	$objResponse->addScript("xajax_Grabar(xajax.getFormValues('Form1'));");
	
	$objResponse->addScript("alert('Abono Eliminado')");
	
	return $objResponse->getXML();
}
function CargaSelect($data, $select, $tabla, $codigo, $descripcion, $campo1, $campo2, $opt){
    global $conexion;
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	$objResponse->addAssign("$select","innerHTML",""); 		
	$sql = "select $campo1 as codigo, $campo2 as descripcion from $tabla";
	$res = mysql_query($sql, $conexion);
	
	if (mysql_num_rows($res) > 0) {
		if ($opt == '1'){
			$j = 0;
		}else{
			$objResponse->addCreate("$select","option",""); 		
			$objResponse->addAssign("$select","options[0].value", $codigo);
			$objResponse->addAssign("$select","options[0].text", $descripcion); 	
			$j = 1;
		}
		while ($line = mysql_fetch_array($res)) {
			$objResponse->addCreate("$select","option",""); 		
			$objResponse->addAssign("$select","options[".$j."].value", $line[0]);
			$objResponse->addAssign("$select","options[".$j."].text", $line[1]); 	
			$j++;
		}
	}
	return $objResponse->getXML();
}

$xajax->registerFunction("MuestraRegistro");
$xajax->registerFunction("CargaDesc");
$xajax->registerFunction("Nueva");
$xajax->registerFunction("CargaPagina");
$xajax->registerFunction("Grabar");
$xajax->registerFunction("Elimina");
$xajax->registerFunction("CargaSelect");

$xajax->processRequests();
$miSmarty->assign('xajax_js', $xajax->getJavascript());

$miSmarty->assign('NCORR', $_GET["ncorr"]);

$miSmarty->display('sg_bodega_elimina_guia_motivo.tpl');

?>

