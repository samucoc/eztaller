<?php
session_start();

require_once 'includes/xajax/xajax.inc.php'; //archivo de configuracion de ajax
include "../includes/php/conf_smarty.php";//archivo de configuracion de smarty
include "../includes/php/conf_bd.php"; //archivo de coneccion al servidor y base de datos
//include "../includes/php/conf_bd_antigua.php"; //archivo de coneccion al servidor de yonley
include "../includes/php/validaciones.php"; 

$xajax = new xajax();

$xajax->setRequestURI("sg_informe_oc.php");
$xajax->setCharEncoding("ISO-8859-1");
$xajax->decodeUTF8InputOn();

function Grabar($data){
	global $conexion;
	global $miSmarty;
	
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	$estado = $data['estado'];
	$nro_oc = $data['nro_oc'];
	$and ="";
	if (($data['txtFecha1']!='')&&($data['txtFecha2']!='')){

		list($dia1,$mes1,$anio1) = explode('/', $data['txtFecha1']);	
		$fecha_inicio	= $anio1."-".$mes1."-".$dia1;
				
		list($dia1,$mes1,$anio1) = explode('/', $data['txtFecha2']);	
		$fecha_termino	= $anio1."-".$mes1."-".$dia1;

		$and .=" and fecha between '$fecha_inicio' and '$fecha_termino' ";
		}
		if (($estado!='')&&($estado!='Todos')){
			$and .= " and estado = '$estado' ";
			}
		else{
			$and .= " and (estado in ('AUTORIZADO') or estado in ('CANCELADO') or estado in ('AUTORIZADO-FP')  or estado in ('RECEPCION-PRODUCTOS') or estado in ('RECEPCION-PENDIENTE-PRODUCTOS') or estado in ('PENDIENTE')) ";
			}
		if (($nro_oc!='')){
			$and .= " and orden_compra_ncorr = '$nro_oc' ";
			}
		$sql_ab = "select *
						from  sgcompras.ordenes_compras
						where 1 $and
						";
		$res_ab = mysql_query($sql_ab, $conexion) or die(mysql_error());
		if (mysql_num_rows($res_ab) > 0){
			$arrRegistros	= 	array();
			$i = 1;
			while ($line_ab_1 = mysql_fetch_array($res_ab)){
				
				$sql = "SELECT * 
						FROM sgbodega.proveedor
							WHERE PR_NCORR = '".$line_ab_1['proveedor']."'";
				$res = mysql_query($sql, $conexion);
				$row = mysql_fetch_array($res);
				$proveedor = $row['PR_RAZON'];
				$estado	= $line_ab_1['estado'];
				if ($estado=='AUTORIZADO'){
					$estado='AUTORIZADO';
					}					
				elseif ($estado =='CANCELADO'){
					$estado='RECHAZADO';
					}
				elseif ($estado =='AUTORIZADO-FP'){
					$estado='AUTORIZADO FORMAS PAGO';
					}
				elseif ($estado =='RECEPCION-PRODUCTOS'){
					$estado='RECEPCION COMPLETA PRODUCTOS';
					}
				elseif ($estado =='RECEPCION-PENDIENTE-PRODUCTOS'){
					$estado='RECEPCION PARCIAL PRODUCTOS';
					}
				elseif ($estado =='PENDIENTE'){
					$estado='PENDIENTE';
					}
				array_push($arrRegistros, array("item"		=>	$i,
							"nro_oc"    => $line_ab_1['orden_compra_ncorr'],
							"proveedor" => $proveedor,
							'estado'    => $estado,
							'monto'	    => $line_ab_1['monto_total']));
				$i++;
				} 
			$_SESSION["alycar_matriz"] = $arrRegistros;
			$miSmarty->assign('arrRegistros', $arrRegistros);
			$objResponse->addAssign("divabonos", "innerHTML", $miSmarty->fetch('sg_informe_oc_list.tpl'));
		}else{
			$objResponse->addAssign("divabonos", "innerHTML", "No Existen Registros");
		}
		$objResponse->addScript("document.getElementById('divlistado').style.display='block';");
		
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
	$objResponse->addAssign("divabonos", "innerHTML", $miSmarty->fetch('sg_informe_oc_list.tpl'));
	
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
                $objResponse->addCreate("$select","option",""); 		
		$objResponse->addAssign("$select","options[0].value", $codigo);
		$objResponse->addAssign("$select","options[0].text", $descripcion); 	
		$j = 1;
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

function CargaPagina($data){
    global $conexion;
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	$objResponse->addScript("xajax_Grabar(xajax.getFormValues('Form1'))");
		
	return $objResponse->getXML();
}  

function BuscarOc($data,$id){
	global $conexion;
	
    $objResponse = new xajaxResponse('ISO-8859-1');
	$oc_ncorr = $id;
	$objResponse->addScript("showPopWin('sg_orden_compra_imprime.php?oc_ncorr=$oc_ncorr', 'Imprime Orden Compra', 900, 650, null);");
	//$objResponse->addScript("document.getElementById('btnGrabar').style.display='none';");
	return $objResponse->getXML();
	}
	
function AutorizaOC($data,$id){
	global $conexion;
	
    $objResponse = new xajaxResponse('ISO-8859-1');
	$oc_ncorr = $id;
	
	$sql = "update sgcompras.ordenes_compras
				set estado = 'AUTORIZADO'
				where orden_compra_ncorr = ".$oc_ncorr."";
	$res = mysql_query($sql,$conexion) or die(mysql_error());
	
	$objResponse->addScript("document.Form1.submit();");
	
	return $objResponse->getXML();
	}
	
function CancelarOC($data,$id){
	global $conexion;
	
    $objResponse = new xajaxResponse('ISO-8859-1');
	$oc_ncorr = $id;
	$sql = "update sgcompras.ordenes_compras
				set estado = 'CANCELADO'
				where orden_compra_ncorr = ".$oc_ncorr."";
	$res = mysql_query($sql,$conexion) or die(mysql_error());
	
	$objResponse->addScript("document.Form1.submit();");
	
	return $objResponse->getXML();
	}
	
$xajax->registerFunction("MuestraRegistro");
$xajax->registerFunction("CargaPagina");
$xajax->registerFunction("CargaDesc");
$xajax->registerFunction("CargaSelect");
$xajax->registerFunction("Grabar");
$xajax->registerFunction("Ordenar");
$xajax->registerFunction("Imprime");
$xajax->registerFunction("BuscarOc");
$xajax->registerFunction("AutorizaOC");
$xajax->registerFunction("CancelarOC");

$xajax->processRequests();
$miSmarty->assign('xajax_js', $xajax->getJavascript());

$miSmarty->display('sg_informe_oc.tpl');

?>

