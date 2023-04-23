<?php
session_start();

require_once 'includes/xajax/xajax.inc.php'; //archivo de configuracion de ajax
include "../includes/php/conf_smarty.php";//archivo de configuracion de smarty
include "../includes/php/conf_bd.php"; //archivo de coneccion al servidor y base de datos
//include "../includes/php/conf_bd_antigua.php"; //archivo de coneccion al servidor de yonley
//include "../includes/php/sgbodega.php"; 
include "../includes/php/validaciones.php"; 

$xajax = new xajax();

$xajax->setRequestURI("sg_vehiculo_asociar_pv.php");
$xajax->setCharEncoding("ISO-8859-1");
$xajax->decodeUTF8InputOn();
        
function Grabar($data){
	global $conexion;
	global $miSmarty;
        
        $objResponse = new xajaxResponse('ISO-8859-1');
	
	$carga_veh		=	$data["cboPatente"];
	$carga_pers		=	$data["OBLI-txtCodCobrador"];
	$carga_funcion          =       $data['OBLI-txtptv'];
         
        $sql = "select *
                from personas_tienen_vehiculos 
                where rut = '".$carga_pers."' ";
        $res = mysql_query($sql,$conexion);
        $row = mysql_fetch_array($res);
        if ($row['rut']!=''){
            $objResponse->addScript("alert('No puede estar asociado un rut a varios vehiculos')");
            }
        else{
            //	inserto el registro
            $sql = "update personas_tienen_vehiculos 
                    set patente = '".$carga_veh."',
                        rut = '".$carga_pers."'
                    where  ptv_ncorr = ".$carga_funcion;
            $res = mysql_query($sql,$conexion);
            $objResponse->addScript("alert('Registro Grabado Correctamente.')");
            $objResponse->addScript("xajax_CargaPagina(xajax.getFormValues('Form1'));");
            }
	return $objResponse->getXML();
}

function TraeValores($data,$ncorr,$patente,$rut){
    global $conexion;
    $objResponse = new xajaxResponse('ISO-8859-1');
    $objResponse->addScript("document.getElementById('OBLI-txtptv').value=".$ncorr.";");
    $sql = "select  *
            from personas_tienen_vehiculos
            where ptv_ncorr = ".$ncorr;
    $res = mysql_query($sql) or die(mysql_error());
    $row = mysql_fetch_array($res);
    $objResponse->addAssign("cboPersona", "value", $rut);
    $objResponse->addAssign("OBLI-txtCodCobrador", "value",$row['rut']);
    $objResponse->addAssign("cboPatente", "value", $patente);
    $objResponse->addScript("document.getElementById('btnGrabar').style.display='block';");           
    return $objResponse->getXML();
}
function CargaPagina($data){
    global $conexion;
    global $miSmarty;
    $objResponse = new xajaxResponse('ISO-8859-1');
    
    $sql = "select  personas_tienen_vehiculos.ptv_ncorr,	
                    personas_tienen_vehiculos.patente, 
                    concat(pers_nombre, ' ', pers_ape_pat) as nombre_completo,
                    tipo_vehiculo.nombre
            from personas_tienen_vehiculos
            left join personas
                on personas_tienen_vehiculos.rut =  personas.pers_rut
            left join vehiculos
                on personas_tienen_vehiculos.patente =  vehiculos.veh_patente
            inner join tipo_vehiculo
                on vehiculos.veh_tipo_veh = tipo_vehiculo.tipo_veh_ncorr";
    $res = mysql_query($sql) or die(mysql_error());
    $arrRegistros = array();
    while($line = mysql_fetch_row($res)){
        array_push($arrRegistros, array("ncorr"         => $line[0], 
                                        "patente"       => $line[1], 
                                        "rut"           => $line[2], 
                                        "tipo_veh"      => $line[3]));
        }
    $_SESSION["alycar_matriz"] = $arrRegistros;
    $miSmarty->assign('arrRegistros', $arrRegistros);
    $objResponse->addAssign("divabonos", "innerHTML", $miSmarty->fetch('sg_vehiculo_asociar_pv_list.tpl'));
    $objResponse->addScript("document.getElementById('btnGrabar').style.display='none';");           
    $objResponse->addScript("document.getElementById('divlistado').style.display='block';");  
    if ($_SESSION["alycar_volver"]=='si'){
        $objResponse->addScript("document.getElementById('btnVolver').style.display='block';");     
        $_SESSION["alycar_volver"] = 'no';
        }
    return $objResponse->getXML();
}  

function Ordenar($data, $campo){
	global $conexion;
	global $miSmarty;
	
        $objResponse = new xajaxResponse('ISO-8859-1');
	
	$orden_asc 	= 'ASC';
	$orden_desc = 'DESC';
	if ($_SESSION["alycar_orden"] == $campo.$orden_asc){
		$campo_orden 		= 	$campo.$orden_desc;
		$direccion_orden	=	$orden_desc;
	}else{
		$campo_orden 		= 	$campo.$orden_asc;
		$direccion_orden	=	$orden_asc;
	}		
	
	$arrRegistros = array();
	$arrRegistros = ordenar_matriz_multidimensionada($_SESSION["alycar_matriz"],$campo,$direccion_orden);
	$_SESSION["alycar_orden"] = $campo_orden;
	
	$_SESSION["alycar_matriz"] = $arrRegistros;
	
	$miSmarty->assign('arrRegistros', $arrRegistros);
	$objResponse->addAssign("divabonos", "innerHTML", $miSmarty->fetch('sg_vehiculo_asociar_pv_list.tpl'));
	
	return $objResponse->getXML();
}

$xajax->registerFunction("Grabar");
$xajax->registerFunction("CargaPagina");
$xajax->registerFunction("Ordenar");
$xajax->registerFunction("TraeValores");

$xajax->processRequests();
$miSmarty->assign('xajax_js', $xajax->getJavascript());

$miSmarty->assign('carga_veh', $_GET["carga_veh"]);
$miSmarty->assign('carga_nom_pers', $_GET["carga_nom_pers"]);
$miSmarty->assign('carga_pers', $_GET["carga_pers"]);
$miSmarty->assign('carga_monto', $_GET["carga_monto"]);
$miSmarty->assign('carga_fecha', $_GET["carga_fecha"]);

$miSmarty->display('sg_vehiculo_asociar_pv.tpl');

?>

