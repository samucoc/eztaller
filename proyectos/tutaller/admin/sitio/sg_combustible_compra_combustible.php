<?php
session_start();

require_once 'includes/xajax/xajax.inc.php'; //archivo de configuracion de ajax
include "../includes/php/conf_smarty.php";//archivo de configuracion de smarty
include "../includes/php/conf_bd.php"; //archivo de coneccion al servidor y base de datos
//include "../includes/php/conf_bd_antigua.php"; //archivo de coneccion al servidor de yonley
include "../includes/php/validaciones.php"; 

$xajax = new xajax();

$xajax->setRequestURI("sg_combustible_compra_combustible.php");
$xajax->setCharEncoding("ISO-8859-1");
$xajax->decodeUTF8InputOn();

function Grabar($data){
	global $conexion;
	global $miSmarty;
	
        $objResponse = new xajaxResponse('ISO-8859-1');

	$sql_1 = "insert into compra_combustible(usuario) values ('".$_SESSION['alycar_usuario']."')"	;
	$res_1 = mysql_query($sql_1,$conexion) or die(mysql_error());
	
	$fecha_arr 				= explode(',',$data['arr_fecha']);
	$empresa_arr 			= explode(',',$data['arr_empresa']);
	$tipoCombustible_arr 	= explode(',',$data['arr_tipo']);
	$depto_arr				= explode(',',$data['arr_depto']);
	$monto_arr 				= explode(',',$data['arr_monto']);

	$id = mysql_insert_id();
	for($i=0; $i< count($fecha_arr); $i++){
		list($dia1,$mes1,$anio1) = explode('/', $fecha_arr[$i]);	$carga_fecha	= $anio1."-".$mes1."-".$dia1;
		$sql_2 = "insert into detalle_compra_combustible(monto, tipo_combustible, empresa, fecha, cc_ncorr, departamento) 
					values ('".ereg_replace("[.]", "", $monto_arr[$i])."','".$tipoCombustible_arr[$i]."','".$empresa_arr[$i]."','".$carga_fecha."','".$id."','".$depto_arr[$i]."')"	;
		$res_2 = mysql_query($sql_2,$conexion) or die(mysql_error());
		
		}
	$objResponse->addAlert("Registro Guardado Existosamente");
	$objResponse->addScript("document.Form1.submit();");
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
	$ncorr_1 	= 	$data["$objeto2"];

    $sql = "select $campo1 as rut, $campo2 as descripcion from $tabla where $campo1 = '".$ncorr."' or $campo2 = '".$ncorr_1."'  ";
	
	$res = mysql_query($sql, $conexion);
	
	$objResponse->addAssign("$objeto1", "value", @mysql_result($res,0,"rut"));
	$objResponse->addAssign("$objeto2", "value", @mysql_result($res,0,"descripcion"));
	return $objResponse->getXML();
}
function CargaSelect($data, $select, $tabla, $codigo, $descripcion, $campo1, $campo2, $opt){
    global $conexion;
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	$objResponse->addAssign("$select","innerHTML",""); 		
	
        $sql = "select $campo1 as codigo, $campo2 as descripcion from $tabla $opt";
	$res = mysql_query($sql, $conexion);
	
        
	if (@mysql_num_rows($res) > 0) {

		$j = 0;
                while ($line = mysql_fetch_array($res)) {
			$objResponse->addCreate("$select","option",""); 		
			$objResponse->addAssign("$select","options[".$j."].value", $line[0]);
			$objResponse->addAssign("$select","options[".$j."].text", $line[1]); 	
			$j++;
		}
	}
	
	return $objResponse->getXML();
}

function Imprime(){
    global $conexion;
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	$objResponse->addScript("ImprimeDiv('divabonos');");
	
	return $objResponse->getXML();
}

$xajax->registerFunction("MuestraRegistro");
$xajax->registerFunction("CargaDesc");
$xajax->registerFunction("CargaSelect");
$xajax->registerFunction("Grabar");
$xajax->registerFunction("EliminarItem");
$xajax->registerFunction("Imprime");

$xajax->processRequests();
$miSmarty->assign('xajax_js', $xajax->getJavascript());

$miSmarty->display('sg_combustible_compra_combustible.tpl');

?>

