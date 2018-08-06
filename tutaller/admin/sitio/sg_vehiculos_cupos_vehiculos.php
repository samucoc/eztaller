<?php
session_start();

require_once 'includes/xajax/xajax.inc.php'; //archivo de configuracion de ajax
include "../includes/php/conf_smarty.php";//archivo de configuracion de smarty
include "../includes/php/conf_bd.php"; //archivo de coneccion al servidor y base de datos
//include "../includes/php/conf_bd_antigua.php"; //archivo de coneccion al servidor de yonley
//include "../includes/php/sgbodega.php"; 
include "../includes/php/validaciones.php"; 

$xajax = new xajax();

$xajax->setRequestURI("sg_vehiculos_cupos_vehiculos.php");
$xajax->setCharEncoding("ISO-8859-1");
$xajax->decodeUTF8InputOn();

function Grabar($data){
	global $conexion;
	
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	$cupo			=	$data["OBLItxtMonto_2"];
	$cupo_rut		=	$data["OBLI-txtCodCobrador"];
	$cupo_mes		=	$data["cboMes"];
	$cupo_anio		=	$data["cboAnio"];
	
	//comparar fechas
        $fecha        = date("Y-m-d",mktime(0, 0, 0, $cupo_mes , 1, $cupo_anio));
        // bloqueo los ingresos posteriores a la fecha de cierre.
	$sql_cierre			= 	"select cier_fecha as ultimocierre 
								from cierres
								order by cier_fecha desc limit 1";
	$res_cierre			= 	mysql_query($sql_cierre, $conexion);
	$ult_cierre 			= 	@mysql_result($res_cierre,0,"ultimocierre");
	
	$sql_dif 			=	"SELECT DATEDIFF('".$fecha."','".$ult_cierre."') as dias_dif";
	$res_dif			=	mysql_query($sql_dif, $conexion);
	$dias_dif			=	@mysql_result($res_dif,0,"dias_dif");
	$ingresa 	= 	"SI";
	// if ($dias_dif < 0){
	// 		$ingresa 	= 	"NO";
	// 		$objResponse->addScript("alert('Fecha antes del cierre.')");
	// 		$_SESSION["alycar_volver"] = 'si';
	// 		$objResponse->addScript("window.document.Form1.submit();");
	// 	}
	
	// $sql_cierre			= 	"select mes, anio
	// 							from persona_tiene_cupos
	// 							where rut_pers = '".$cupo_rut."'
	// 							order by ptc_ncorr desc limit 1";
	// $res_cierre			= 	mysql_query($sql_cierre, $conexion);
	// $ult_mes			= 	@mysql_result($res_cierre,0,"mes");
	// $ult_anio			= 	@mysql_result($res_cierre,0,"anio");
	
	// $ult_fecha =date("Y-m-d",mktime(0,0,0,$ult_mes,1,$ult_anio));

	// $sql_dif 			=	"SELECT DATEDIFF('".$fecha."','".$ult_fecha."') as dias_dif";
	// $res_dif			=	mysql_query($sql_dif, $conexion);
	// $dias_dif			=	@mysql_result($res_dif,0,"dias_dif");
	// $ingresa 	= 	"SI";
	// if ($dias_dif < 0){
	// 		$ingresa 	= 	"NO";
	// 		$objResponse->addScript("alert('Fecha antes del ultimo cupo.')");
	// 		$_SESSION["alycar_volver"] = 'si';
	// 		$objResponse->addScript("window.document.Form1.submit();");
	// 	}
	
	
	if ($ingresa == 'SI'){
	
                    $sql = "insert into persona_tiene_cupos (cupo,rut_pers,mes,anio,usuario)
                                    values ('".$cupo."','".$cupo_rut."','".$cupo_mes."','".$cupo_anio."', '".$_SESSION["alycar_usuario"]."')";
                    $res = mysql_query($sql,$conexion) or die(mysql_error());

                    $objResponse->addScript("alert('Registro Grabado Correctamente.')");
		    $objResponse->addAssign("cboPersona",'value','');
		    $objResponse->addAssign("OBLI-txtCodCobrador",'value','');
		    $objResponse->addAssign("OBLItxtMonto_1",'value','');
		    $objResponse->addAssign("OBLItxtMonto_2",'value','');
		    $objResponse->addAssign("OBLI-txtFecha",'value','');
                    if (isset($_SESSION["alycar_volver"])){
                    	if ($_SESSION["alycar_volver"]=='si'){
                    		//$objResponse->addScript("document.location.href='".$pagina_volver."?carga_veh=".$carga_veh."&carga_nom_pers=".$carga_nom_pers."&carga_pers=".$carga_pers."&carga_monto=".$carga_monto."&carga_fecha=".$carga_fecha."&pers_asig=".$pers_asig."&monto_dispo=".$monto_dispo."&cargado=".$cargado."'");
                    		$_SESSION["alycar_volver"] = 'no';
                    		}
                    	}
             
		
            }
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
	global $miSmarty;
	$objResponse = new xajaxResponse('ISO-8859-1');

	if (isset($_SESSION["alycar_volver"])){
		if ($_SESSION["alycar_volver"]=='si'){
			$objResponse->addScript("document.getElementById('btnVolver').style.display='block';");     
			$_SESSION["alycar_volver"] = 'no';
			}
		}
    return $objResponse->getXML();
}  
	
$xajax->registerFunction("Grabar");
$xajax->registerFunction("MuestraRegistro");
$xajax->registerFunction("CargaPagina");

if (isset($_GET["carga_veh"])){
	$miSmarty->assign('carga_veh', $_GET["carga_veh"]);
	}
if (isset($_GET["carga_nom_pers"])){
	$miSmarty->assign('carga_nom_pers', $_GET["carga_nom_pers"]);
	}
if (isset($_GET["carga_pers"])){
	$miSmarty->assign('carga_pers', $_GET["carga_pers"]);
	}
if (isset($_GET["pers_asig"]))    {  
	$miSmarty->assign('pers_asig', $_GET["pers_asig"]);
	}
if (isset($_GET["carga_monto"])){
	$miSmarty->assign('carga_monto', $_GET["carga_monto"]);
	}
if (isset($_GET["monto_dispo"]))    {  
	$miSmarty->assign('monto_dispo', $_GET["monto_dispo"]);
	}
if (isset($_GET["cargado"]))    {  
	$miSmarty->assign('cargado', $_GET["cargado"]);
	}
if (isset($_GET["carga_fecha"])){
	$miSmarty->assign('carga_fecha', $_GET["carga_fecha"]);
	}
if (isset($_SESSION["alycar_pagina_volver"])){
	$miSmarty->assign('pagina_volver',$_SESSION["alycar_pagina_volver"]);
	}


$xajax->processRequests();
$miSmarty->assign('xajax_js', $xajax->getJavascript());

$miSmarty->display('sg_vehiculos_cupos_vehiculos.tpl');

?>

