<?php
session_start();

require_once 'includes/xajax/xajax.inc.php'; //archivo de configuracion de ajax
include "../includes/php/conf_smarty.php";//archivo de configuracion de smarty
include "../includes/php/conf_bd.php"; //archivo de coneccion al servidor y base de datos
//include "../includes/php/conf_bd_antigua.php"; //archivo de coneccion al servidor de yonley
include "../includes/php/validaciones.php"; 

$xajax = new xajax();

$xajax->setRequestURI("sg_informe_siniestros.php");
$xajax->setCharEncoding("ISO-8859-1");
$xajax->decodeUTF8InputOn();

function Grabar($data){
	global $conexion;
	global $miSmarty;
	
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	$objResponse->addScript("document.getElementById('divlistado').style.display='none';");
	
	$fecha1 = $data['fecha1'];
	$fecha2 = $data['fecha2'];
	$patente = $data['cboPatente'];
	$trabajador = $data['rut_trab'];
	
	list($dia1,$mes1,$anio1)	= explode('/', $fecha1);
	$fecha1            			= $anio1.'-'.$mes1.'-'.$dia1;
	
	list($dia1,$mes1,$anio1)	= explode('/', $fecha2);
	$fecha2           			= $anio1.'-'.$mes1.'-'.$dia1;
	
	$and="";
        if ($trabajador != ''){
            $and .= " and trabajador = '".$trabajador."' " ;
        }
        
        if ($patente != ''){
            $and .= " and patente = '".$patente."' " ;
        }

        if ($fecha1 != '--'){
            $and .= " and fecha between '".$fecha1."' and '".$fecha2."' " ;
        }
	
	$sql = "select * 
			from siniestros
			where 1 ".$and."";
	$res = mysql_query($sql,$conexion);
	if (mysql_num_rows($res) > 0){
	$arrRegistros	= 	array();
	$i = 1;
        while ($line_ab = mysql_fetch_array($res)){
			
			$sql_dedu = "select * from vehiculos where veh_patente = '".$line_ab['patente']."'";
			$res_dedu = mysql_query($sql_dedu, $conexion);
			$row_dedu = mysql_fetch_array($res_dedu);
			
			$deducible = $row_dedu['veh_deducible'];
			
			 $sql_pr = "select concat(pers_nombre,' ',pers_ape_pat) as pers_nombre_com 
							from personas 
							where pers_rut = '".$line_ab['trabajador']."'";
			$res_pr = mysql_query($sql_pr, $conexion);
			$nombre_persona = @mysql_result($res_pr,0,"pers_nombre_com");
			
			array_push($arrRegistros, array(
			        					'fecha' 		=> $line_ab['fecha'],
										'patente' 		=> $line_ab['patente'],
										'trabajador'	=> $nombre_persona,
										'deducible'		=> $deducible,
										'observacion'	=> $line_ab['observacion']
									));
			}
        $miSmarty->assign('arrRegistros', $arrRegistros);
		$objResponse->addAssign("divabonos", "innerHTML", $miSmarty->fetch('sg_informe_siniestros_list.tpl'));
	}else{
		
		$objResponse->addAssign("divabonos", "innerHTML", "No Existen Registros");
	}
	$objResponse->addScript("document.getElementById('divlistado').style.display='block';");
		
	return $objResponse->getXML();
}

function Imprime(){
    global $conexion;
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	$objResponse->addScript("ImprimeDiv('divabonos');");
	
	return $objResponse->getXML();
}

function CargaPagina($data){
    global $conexion;
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	return $objResponse->getXML();
}  


$xajax->registerFunction("CargaPagina");
$xajax->registerFunction("Grabar");
$xajax->registerFunction("Imprime");

$xajax->processRequests();
$miSmarty->assign('xajax_js', $xajax->getJavascript());


$miSmarty->display('sg_informe_siniestros.tpl');

?>

