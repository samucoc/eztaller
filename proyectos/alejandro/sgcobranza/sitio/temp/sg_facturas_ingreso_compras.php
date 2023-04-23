<?php
session_start();

require_once 'includes/xajax/xajax.inc.php'; //archivo de configuracion de ajax
include "../includes/php/conf_smarty.php";//archivo de configuracion de smarty
include "../includes/php/conf_bd.php"; //archivo de coneccion al servidor y base de datos
//include "../includes/php/conf_bd_antigua.php"; //archivo de coneccion al servidor de yonley
//include "../includes/php/sgbodega.php"; 
include "../includes/php/validaciones.php"; 

$xajax = new xajax();

$xajax->setRequestURI("sg_facturas_ingreso_compras.php");
$xajax->setCharEncoding("ISO-8859-1");
$xajax->decodeUTF8InputOn();

function Grabar($data){
	global $conexion;
	
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	$empresa 		= $data['rut_empresa'];
	$fecha			= $data['OBLI-txtFecha'];
	$rut	 		= $data['rut_cliente'];
	$nro_factura	= $data['OBLIboleta'];
	$clase_factura	= $data['tipo_factura'];
	$estado_factura	= $data['estado_factura'];
	$especifico		= $data['especifico'];
	$neto	 		= $data['OBLItxtMontoIngresar'];
	$iva			= $data['iva'];
	$total	 		= $data['total'];
	
	list($dia3,$mes3,$anio3) = split('[/.-]', $fecha);$fecha = $anio3."-".$mes3."-".$dia3;
	
	$sql = "select cier_fecha from cierres where empe_rut = '".$empresa."' order by cier_fecha desc limit 1";
	$res = mysql_query($sql, $conexion);
	
	$ult_cierre = @mysql_result($res,0,"cier_fecha");
	
	// verifico que la fecha de cierre sea mayor que la fecha del ultimo cierre
	$sql_dif =	"SELECT DATEDIFF('".$fecha."','".$ult_cierre."') as dias_dif";
	$res_dif = mysql_query($sql_dif,$conexion);
	$dias_dif = @mysql_result($res_dif,0,"dias_dif");
	$ingresa = 'SI';
	if ($dias_dif <= 0){
		$ingresa = 'NO';
		$objResponse->addScript("alert('Fecha Incorrecta. Debe ser mayor a la fecha del ultimo cierre.')");
	}	
	$sql = "select * from facturas where nro_factura = ".$nro_factura;
	$res = mysql_query($sql,$conexion);
	if (mysql_num_rows($res)==0){
		if ($ingresa == 'SI'){
		$neto = str_replace(".", "", $neto);
		if ($rut != ''){
			$sql = "insert into `facturas` (`fecha`, empresa,`rut`, `nro_factura`,`clase_factura`, `neto`, `iva`, `total`, `tipo_factura`, `estado_factura`, especifico) values 
					('".$fecha."','".$empresa."','".$rut."','".$nro_factura."','".$clase_factura."','".$neto."','".$iva."','".$total."','COMPRAS','".$estado_factura."','".$especifico."')";
			$res = mysql_query($sql, $conexion);
			$objResponse->addScript("alert('Registro guardado correctamente')");
			$objResponse->addScript("document.Form1.submit();");
			}
		else{
			$objResponse->addScript("alert('Agregar Proveedor')");
			}
		}
	}
	else{
		$objResponse->addScript("alert('Factura repetida')");
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
	
	// carga empresas
	$objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'empresa','sgyonley.empresas','','- - Seleccione - -','empe_rut','empe_desc', 'order by empe_rut desc')");
	       
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
	
	$nombre_empresa = $data['nombre_empresa'];
	$empresa 		= $data['rut_empresa'];
	$fecha			= $data['OBLI-txtFecha'];
	$cliente		= $data['OBLIcliente'];
	$rut	 		= $data['rut_cliente'];
	$nro_factura	= $data['OBLIboleta'];
	$neto	 		= $data['OBLItxtMontoIngresar'];
	$iva			= $data['iva'];
	$total	 		= $data['total'];
	
	$_SESSION["alycar_volver"]			=	'si';
	$_SESSION["alycar_pagina_volver"]	=   'sg_facturas_ingreso_compras.php';
	
    $objResponse->addScript("document.location.href='sg_mant_tablas.php?tbl=proveedores&nombre_empresa=".$nombre_empresa."&empresa=".$empresa."&fecha=".$fecha."&cliente=".$cliente."&rut=".$rut."&nro_factura=".$nro_factura."&neto=".$neto."&iva=".$iva."&total=".$total."'");
	 
	return $objResponse->getXML();
}
$xajax->registerFunction("LlamaMantenedorVxC");

$xajax->registerFunction("Grabar");
$xajax->registerFunction("MuestraRegistro");
$xajax->registerFunction("CargaPagina");
$xajax->registerFunction("CargaDesc");
$xajax->registerFunction("CargaSelect");

$xajax->processRequests();
$miSmarty->assign('xajax_js', $xajax->getJavascript());

$miSmarty->assign('nombre_empresa', $_GET["nombre_empresa"]);
$miSmarty->assign('empresa', $_GET["empresa"]);
$miSmarty->assign('fecha', $_GET["fecha"]);
$miSmarty->assign('cliente', $_GET["cliente"]);
$miSmarty->assign('rut', $_GET["rut"]);
$miSmarty->assign('nro_factura', $_GET["nro_factura"]);
$miSmarty->assign('neto', $_GET["neto"]);
$miSmarty->assign('iva', $_GET["iva"]);
$miSmarty->assign('total', $_GET["total"]);

$miSmarty->display('sg_facturas_ingreso_compras.tpl');

?>

