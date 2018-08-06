<?php
session_start();

require_once 'includes/xajax/xajax.inc.php'; //archivo de configuracion de ajax
include "../includes/php/conf_smarty.php";//archivo de configuracion de smarty
include "../includes/php/conf_bd.php"; //archivo de coneccion al servidor y base de datos
//include "../includes/php/conf_bd_antigua.php"; //archivo de coneccion al servidor de yonley
//include "../includes/php/sgbodega.php"; 
include "../includes/php/validaciones.php"; 

$xajax = new xajax();

$xajax->setRequestURI("sg_vehiculos_ingresar_carga.php");
$xajax->setCharEncoding("ISO-8859-1");
$xajax->decodeUTF8InputOn();

function Grabar($data){
	global $conexion;
	
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	$carga_veh		=	$data["cboPatente"];
	$carga_pers		=	$data["OBLI-txtCodCobrador"];
	$carga_monto		=	ereg_replace("[.]", "", $data["OBLItxtMontoIngresar"]);
	$carga_fecha		=	$data["OBLI-txtFecha"];
	$carga_tipo		=	$data["cboCarga"];
	
	list($dia1,$mes1,$anio1) = split('[/.-]', $carga_fecha);	$carga_fecha	= $anio1."-".$mes1."-".$dia1;
	if ($carga_tipo==2){
            
            $sql = "insert into cargas_extras (ce_pers,ce_veh,ce_monto,ce_fecha,ce_autorizado)
                            values ('".$carga_pers."','".$carga_veh."','".$carga_monto."','".$carga_fecha."','NO')";
            //$res = mysql_query($sql,$conexion);
            //$id = mysql_insert_id($conexion);
            $objResponse->addScript("showPopWin('sg_vehiculos_ingresar_carga_envio_correo.php?carga_monto=".$carga_monto."&carga_pers=".$carga_pers."&id_carga=".$id."', 'Enviar Solicitud', 640, 370, null);");
			}
        else{
            //	inserto el registro
            $sql = "insert into cargas_vehiculos (carga_veh,carga_pers,carga_monto,carga_fecha,carga_tipo)
                            values ('".$carga_veh."','".$carga_pers."','".$carga_monto."','".$carga_fecha."','".$carga_tipo."')";
            $res = mysql_query($sql,$conexion);
            $objResponse->addScript("alert('Registro Grabado Correctamente.')");
            $objResponse->addScript("document.location.href='sg_vehiculos_ingresar_carga.php';");
        }
        return $objResponse->getXML();
}


function MuestraRegistro($data, $campo1, $campo2, $obj1, $obj2){
	global $conexion;
	
        $objResponse = new xajaxResponse('ISO-8859-1');
	
	$objResponse->addAssign("$obj1", "value", $campo1);
	$objResponse->addAssign("$obj2", "value", $campo2);
	if ($obj1 == 'OBLI-txtCodCobrador'){
        	$objResponse->addScript("xajax_CalcularCupo(xajax.getFormValues('Form1'))");
        
            }
	return $objResponse->getXML();
}

function CargaPagina($data){
    global $conexion;
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	$objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'cboCarga','tipo_carga_comb','','Todos','tipo_carg_ncorr', 'nombre', '')");
       
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
function LlamaMantenedorVxC($data){
	global $conexion;
	
        $objResponse = new xajaxResponse('ISO-8859-1');
	
        $carga_veh		=	$data["cboPatente"];
	$carga_nom_pers		=	$data["cboPersona"];
	$carga_pers		=	$data["OBLI-txtCodCobrador"];
	$carga_monto		=	$data["OBLItxtMontoIngresar"];
	$carga_fecha		=	$data["OBLI-txtFecha"];
	
	$_SESSION["alycar_volver"]	=	'si';
	
        $objResponse->addScript("document.location.href='sg_vehiculo_asociar_pv.php?carga_veh=".$carga_veh."&carga_nom_pers=".$carga_nom_pers."&carga_pers=".$carga_pers."&carga_monto=".$carga_monto."&carga_fecha=".$carga_fecha."'");
	
	return $objResponse->getXML();
}
$xajax->registerFunction("Grabar");
$xajax->registerFunction("MuestraRegistro");
$xajax->registerFunction("CargaPagina");
$xajax->registerFunction("CargaDesc");
$xajax->registerFunction("CargaSelect");
$xajax->registerFunction("LlamaMantenedorVxC");

$xajax->processRequests();
$miSmarty->assign('xajax_js', $xajax->getJavascript());

$miSmarty->assign('carga_veh', $_GET["carga_veh"]);
$miSmarty->assign('CARGA_NOM_PERS', $_GET["carga_nom_pers"]);
$miSmarty->assign('carga_pers', $_GET["carga_pers"]);
$miSmarty->assign('carga_monto', $_GET["carga_monto"]);
$miSmarty->assign('carga_fecha', $_GET["carga_fecha"]);

$miSmarty->display('sg_vehiculos_ingresar_carga.tpl');
 
?>

