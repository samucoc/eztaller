<?php
session_start();

require_once 'includes/xajax/xajax.inc.php'; //archivo de configuracion de ajax
include "../includes/php/conf_smarty.php";//archivo de configuracion de smarty
include "../includes/php/conf_bd.php"; //archivo de coneccion al servidor y base de datos
//include "../includes/php/conf_bd_antigua.php"; //archivo de coneccion al servidor de yonley
include "../includes/php/validaciones.php"; 

$xajax = new xajax();

$xajax->setRequestURI("sg_informe_cargas_ingresadas_modificar.php");
$xajax->setCharEncoding("ISO-8859-1");
$xajax->decodeUTF8InputOn();

function Grabar($data){
	global $conexion;
	global $miSmarty;
	
    $objResponse = new xajaxResponse('ISO-8859-1');

    $ncorr  = $data['ncorr'];

	$sql_empe = "SELECT veh_emp, veh_depto
        FROM vehiculos
		WHERE `veh_patente` = '".$data['patente']."'
            ";
	$res_empe = mysql_query($sql_empe, $conexion);
	$row_empe = mysql_fetch_array($res_empe);

	$veh_empe = $row_empe['veh_emp'];
	$veh_depto = $row_empe['veh_depto'];

	list($anio,$mes,$dia) = explode('/',$data['fecha']);

	$monto = str_replace('.', '', $data['monto']);

	$sql_ab_1 = "update cargas_vehiculos 
			        set 
			        `veh_empe`			=	'".$veh_empe."',
			        `carga_veh`			=	'".$data['patente']."',
			        `carga_pers`		=	'".$data['trabajador']."',
			        `carga_monto`		=	'".$monto."',
			        `carga_fecha`		=	'".$dia."-".$mes."-".$anio."',
			        `carga_tipo`		=	'".$data['tipo']."',
			        `carga_observacion`	=	'".$data['observacion']."',
			        `carga_boleta`		=	'".$data['boleta']."',
			        `veh_depto`			=	'".$veh_depto."'
			        where
			            carga_ncorr  = '".$ncorr."'";
    $res_ab_1 = mysql_query($sql_ab_1, $conexion) or die(mysql_error());

    $objResponse->addScript("window.parent.hidePopWin(true)");
	$objResponse->addScript("window.parent.ValidaFormularioMantenedor();");
	$objResponse->addAlert("Registro Modificado.");
   	
   	return $objResponse->getXML();
	}

function CargaPagina($data){
    global $conexion;
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	$ncorr = $data['ncorr'];

	$sql_ab_1 = "select *
			        from cargas_vehiculos 
			        where
			            carga_ncorr  = '".$ncorr."'";
    $res_ab_1 = mysql_query($sql_ab_1, $conexion) or die(mysql_error());
	
	while ($line = mysql_fetch_array($res_ab_1)){
		$sql_pr = "select concat(pers_nombre,' ',pers_ape_pat) as pers_nombre_com 
							from personas 
							where pers_rut = '".$line['carga_pers']."'";
		$res_pr = mysql_query($sql_pr, $conexion);
		$nombre_persona = @mysql_result($res_pr,0,"pers_nombre_com");
					    
		//PATENTE
		$objResponse->addScript("document.getElementById('patente').value= '".$line['carga_veh']."'");
		//TRABAJADOR
		$objResponse->addScript("document.getElementById('trabajador').value= '".$line['carga_pers']."'");
		$objResponse->addScript("document.getElementById('nombre_trabajador').value= '".$nombre_persona."'");
		//MONTO
		$objResponse->addScript("document.getElementById('monto').value= '".$line['carga_monto']."'");
		//FECHA
		list($anio,$mes,$dia) = explode('-',$line['carga_fecha']);
		$objResponse->addScript("document.getElementById('fecha').value= '".$dia."/".$mes."/".$anio."'");
		//TIPO
		$objResponse->addScript("document.getElementById('tipo').value= '".$line['carga_tipo']."'");
		//BOLETA
		$objResponse->addScript("document.getElementById('boleta').value= '".$line['carga_boleta']."'");
		//OBSERVACION
		$objResponse->addScript("document.getElementById('observacion').value= '".$line['carga_observacion']."'");
		
		}

			
	return $objResponse->getXML();
	}  

$xajax->registerFunction("CargaPagina");
$xajax->registerFunction("Grabar");

$xajax->processRequests();
$miSmarty->assign('xajax_js', $xajax->getJavascript());
$miSmarty->assign('ncorr', $_GET['ncorr']);


$miSmarty->display('sg_informe_cargas_ingresadas_modificar.tpl');

?>
