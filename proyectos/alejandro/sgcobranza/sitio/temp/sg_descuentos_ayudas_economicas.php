<?php
session_start();

require_once 'includes/xajax/xajax.inc.php'; //archivo de configuracion de ajax
include "../includes/php/conf_smarty.php";//archivo de configuracion de smarty
include "../includes/php/conf_bd.php"; //archivo de coneccion al servidor y base de datos
//include "../includes/php/conf_bd_antigua.php"; //archivo de coneccion al servidor de yonley
//include "../includes/php/sgbodega.php"; 
include "../includes/php/validaciones.php"; 

$xajax = new xajax();

$xajax->setRequestURI("sg_descuentos_ayudas_economicas.php");
$xajax->setCharEncoding("ISO-8859-1");
$xajax->decodeUTF8InputOn();

function Grabar($data){
	global $conexion;
	global $miSmarty;
	
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	$fecha	 			= $data['OBLI-txtFecha'];
	$monto	 			= $data['OBLItxtMontoIngresar'];
	$trabajador_beneficiario = $data['OBLItxtRut1'];
	$trabajador_aportador	= $data['OBLItxtRut2'];
	$usuario			= $_SESSION['alycar_usuario'];
	$fecha_digitacion 	= date("Y-m-d H:i:s");
	$estado				= 'AUTORIZADO';

	list($dia3,$mes3,$anio3) = explode('/', $fecha);$fecha = $anio3."-".$mes3."-".$dia3;
	
	$monto = str_replace(".", "", $monto);
	//$objResponse->addAlert($fecha_ant.'->'.$fecha);
	$sql = "insert into ayudas_economicas (  `trabajador_beneficiario`, `trabajador_aportador`, `monto`, `fecha`, `usuario`, `fecha_digitacion`, `estado` ) 
			values ( '$trabajador_beneficiario','$trabajador_aportador','$monto','$fecha','$usuario','$fecha_digitacion','$estado' )";
			
	$res = mysql_query($sql,$conexion) or die(mysql_error());
	$objResponse->addAlert("Ayuda Economica ingresada correctamente.");
	$objResponse->addAssign("OBLItipo", "value","");
	$objResponse->addAssign("OBLI-txtFecha", "value","");
	$objResponse->addAssign("OBLItxtMontoIngresar", "value","");
	$objResponse->addAssign("OBLItxtRut1", "value","");
	$objResponse->addAssign("OBLItxtNombres1", "value","");
	$objResponse->addAssign("OBLItxtRut2", "value","");
	$objResponse->addAssign("OBLItxtNombres2", "value","");

	return $objResponse->getXML();
}


function MuestraRegistro($data, $campo1, $campo2, $obj1, $obj2){
	global $conexion;
	
        $objResponse = new xajaxResponse('ISO-8859-1');
	
	$objResponse->addAssign("$obj1", "value", $campo1);
	$objResponse->addAssign("$obj2", "value", $campo2);

	return $objResponse->getXML();
}

function CargaPagina($data){
    global $conexion;
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	$objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'OBLIcboEmpresa','sgyonley.empresas','','- - Seleccione - -','empe_rut','empe_desc', '')");
	$objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'OBLIcboEmpresa_1','sgyonley.empresas','','- - Seleccione - -','empe_rut','empe_desc', '')");
	
  	return $objResponse->getXML();

}  

function CargaDesc($data, $tabla, $campo1, $campo2, $objeto1, $objeto2, $c_and){
    global $conexion;
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	$rut = $data[$objeto1];
	$empresa = $data['OBLIcboEmpresa'];
	
	if ($tabla == 'sggeneral.trabajadores'){
		$campo2 = "concat(nombres,' ',apellido_pat,' ',apellido_mat)";
		}
	 $sql = "select $campo1 as rut, $campo2 as descripcion from $tabla where $campo1 = '$rut' $c_and and empresa_contr = '".$empresa."'";
	
	$res = mysql_query($sql, $conexion) or die(mysql_error());
	
	$objResponse->addAssign("$objeto1", "value", @mysql_result($res,0,"rut"));
	$objResponse->addAssign("$objeto2", "value", @mysql_result($res,0,"descripcion"));
	return $objResponse->getXML();
}

function CargaDesc_1($data, $tabla, $campo1, $campo2, $objeto1, $objeto2, $c_and){
    global $conexion;
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	$rut = $data[$objeto1];
	
	if ($tabla == 'sggeneral.trabajadores'){
		$campo2 = "concat(nombres,' ',apellido_pat,' ',apellido_mat)";
		}
	$sql = "select $campo1 as rut, $campo2 as descripcion from $tabla where $campo1 = '$rut' $c_and ";
	
	$res = mysql_query($sql, $conexion) or die(mysql_error());
	
	$objResponse->addAssign("$objeto1", "value", @mysql_result($res,0,"rut"));
	$objResponse->addAssign("$objeto2", "value", @mysql_result($res,0,"descripcion"));
	return $objResponse->getXML();
}

function CargaSelect($data, $select, $tabla, $codigo, $descripcion, $campo1, $campo2, $opt){
    global $conexion;
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	$objResponse->addAssign("$select","innerHTML",""); 		
	
    if ($tabla != 'personas'){
           $sql = "select $campo1 as codigo, $campo2 as descripcion from $tabla $opt";
        } 
    else{
            $sql = "select $campo1 as codigo, concat(pers_ape_pat,' ',pers_nombre) as descripcion from $tabla $opt";
        }
	$res = mysql_query($sql, $conexion);
	
	if (@mysql_num_rows($res) > 0) {
                $j=0;
                while ($line = mysql_fetch_array($res)) {
			$objResponse->addCreate("$select","option",""); 		
			$objResponse->addAssign("$select","options[".$j."].value", $line[0]);
			$objResponse->addAssign("$select","options[".$j."].text", $line[1]); 	
			$j++;
		}
	}
	
	return $objResponse->getXML();
}
function CargaPopWin($data, $url){
    global $conexion;
    $objResponse = new xajaxResponse('ISO-8859-1');

	$url = $url .'&empresa='.$data['OBLIcboEmpresa'];
	$objResponse->addScript("showPopWin('".$url."', 'Busca Trabajador', 550, 350, null);");

	return $objResponse->getXML();
	
}

function CargaPopWin_1($data, $url){
    global $conexion;
    $objResponse = new xajaxResponse('ISO-8859-1');

	$url = $url .'&empresa='.$data['OBLIcboEmpresa_1'];
	$objResponse->addScript("showPopWin('".$url."', 'Busca Trabajador', 550, 350, null);");

	return $objResponse->getXML();
	
}

$xajax->registerFunction("Grabar");
$xajax->registerFunction("MuestraRegistro");
$xajax->registerFunction("CargaPagina");
$xajax->registerFunction("CargaDesc");
$xajax->registerFunction("CargaDesc_1");
$xajax->registerFunction("CargaSelect");
$xajax->registerFunction("CargaPopWin");
$xajax->registerFunction("CargaPopWin_1");
$xajax->registerFunction("Eliminar");

$xajax->processRequests();
$miSmarty->assign('xajax_js', $xajax->getJavascript());

$miSmarty->display('sg_descuentos_ayudas_economicas.tpl');

?>

