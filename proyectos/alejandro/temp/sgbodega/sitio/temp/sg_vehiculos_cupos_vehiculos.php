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
	$cupo_fecha		=	$data["OBLI-txtFecha"];
	
	list($dia1,$mes1,$anio1) = split('[/.-]', $cupo_fecha);	$cupo_fecha	= $anio1."-".$mes1."-".$dia1;
	//comparar fechas
        $nro_fecha        = mktime(0, 0, 0, $mes1 , $dia1, $anio1);
        $hoy              = mktime(0, 0, 0, date("m"), date("d"),   date("Y"));
        if (!($hoy > $nro_fecha)){
            $sql = "SELECT * 
            FROM `persona_tiene_cupos` 
            WHERE `rut_pers` = '".$cupo_rut."'
                order by fecha desc
                limit 0,1";
            $res = mysql_query($sql, $conexion);
            $row  =  mysql_fetch_array($res);
            
            $fecha_guardada = $row['fecha'];
            $nro_fg=0;
            $arr_fg = array();
            if (isset($fecha_guardada)){
                $arr_fg = explode('-',$fecha_guardada);
                $nro_fg = mktime(0,0,0,$arr_fg[1],$arr_fg[2],$arr_fg[0]);
                }
            
            if ($nro_fg < $nro_fecha){
                if (($mes1>$arr_fg[1])&&($anio1>=$arr_fg[0])){
                    $sql = "insert into persona_tiene_cupos (cupo,rut_pers,fecha,usuario)
                                    values ('".$cupo."','".$cupo_rut."','".$cupo_fecha." ".date("H:i:s")."','".$_SESSION["alycar_usuario"]."')";
                    $res = mysql_query($sql,$conexion);

                    $objResponse->addScript("alert('Registro Grabado Correctamente.')");
                    $objResponse->addScript("document.Form1.submit();");
                    }
                else{
                     $objResponse->addScript("alert('Fecha elegida menor a un mes.')");
                    }    
                }
            else{
                 $objResponse->addScript("alert('Fecha elegida menor o igual a la guardada.')");
                }
            }
        else{
            $objResponse->addScript("alert('Fecha menor a la de hoy.')");
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


$xajax->registerFunction("Grabar");
$xajax->registerFunction("MuestraRegistro");

$xajax->processRequests();
$miSmarty->assign('xajax_js', $xajax->getJavascript());

$miSmarty->display('sg_vehiculos_cupos_vehiculos.tpl');

?>

