<?php
session_start();

require_once 'includes/xajax/xajax.inc.php'; //archivo de configuracion de ajax
include "../includes/php/conf_smarty.php";//archivo de configuracion de smarty
include "../includes/php/conf_bd.php"; //archivo de coneccion al servidor y base de datos
//include "../includes/php/conf_bd_antigua.php"; //archivo de coneccion al servidor de yonley
include "../includes/php/validaciones.php"; 
include "../includes/php/class.phpmailer.php";
include "../includes/php/class.pop3.php";
include "../includes/php/class.smtp.php";
include "../includes/php/PHPExcel.php";
include "../includes/php/PHPExcel/Reader/Excel2007.php";

$xajax = new xajax();

$xajax->setRequestURI("sg_informe_ayudas_economicas.php");
$xajax->setCharEncoding("ISO-8859-1");
$xajax->decodeUTF8InputOn();

function Grabar($data){
	global $conexion;
	global $miSmarty;
        
	$objResponse = new xajaxResponse('ISO-8859-1');
	
	$trabajador         =   $data["txtCodCobrador"];
    $trabajador2        =   $data["txtCodCobrador_2"];
    $OBLItxtFecha1      =   $data["OBLItxtFecha1"];
    $OBLItxtFecha2 		=	$data["OBLItxtFecha2"];
	    
	$objResponse->addScript("document.getElementById('divlistado').style.display='none';");
	
	if (($trabajador2 != '')){
		$and .= " and ayudas_economicas.trabajador_aportador = '".$trabajador2."'";
	}
	if (($trabajador != '')){
		$and .= " and ayudas_economicas.trabajador_beneficiario = '".$trabajador."' ";
	}

	if (($OBLItxtFecha1 != '') && ($OBLItxtFecha2 != '') ){
		list($dia3,$mes3,$anio3) = explode('/', $OBLItxtFecha1);$OBLItxtFecha1 = $anio3."-".$mes3."-".$dia3;
		list($dia3,$mes3,$anio3) = explode('/', $OBLItxtFecha2);$OBLItxtFecha2 = $anio3."-".$mes3."-".$dia3;
		$and .= " and ayudas_economicas.fecha between '".$OBLItxtFecha1."' and '".$OBLItxtFecha2."' ";
	}

	$sql_pd="SELECT fecha,
					trabajador_beneficiario,
					trabajador_aportador,
					monto,
					estado,
					usuario,
					fecha_digitacion 
			 FROM  ayudas_economicas
			 where 1 $and 
			 order by fecha asc";        
	$res_pd = mysql_query($sql_pd, $conexion) or die(mysql_error());
	if (mysql_num_rows($res_pd) > 0){
		$arrRegistros		= 	array();
		$i 					= 	1;
		$total = 0;
		while ($line_pd = mysql_fetch_array($res_pd)) {
			$sql_1 = "select concat(nombres,' ',apellido_pat,' ',apellido_mat) as nombres
						from sggeneral.trabajadores
						where rut = '".$line_pd['trabajador_beneficiario']."'";
			$res_1 = mysql_query($sql_1,$conexion) or die(mysql_error());
			$row_1 = mysql_fetch_array($res_1);
			
			$nombre_trabajador = $row_1['nombres'];
			
			$sql_1 = "select concat(nombres,' ',apellido_pat,' ',apellido_mat) as nombres
						from sggeneral.trabajadores
						where rut = '".$line_pd['trabajador_aportador']."'";
			$res_1 = mysql_query($sql_1,$conexion) or die(mysql_error());
			$row_1 = mysql_fetch_array($res_1);
			
			$nombre_trabajador_2 = $row_1['nombres'];
			
			array_push($arrRegistros, array("fecha"  					=> 	$line_pd['fecha'],
											"trabajador_beneficiario"	=> 	$nombre_trabajador,
											"trabajador_aportador"		=> 	$nombre_trabajador_2,
											"monto" 					=> 	$line_pd['monto'],
											"estado"   					=> 	$line_pd['estado'],
											"usuario"   				=> 	$line_pd['usuario'],
											"fecha_digitacion"			=>  $line_pd['fecha_digitacion']
											));
			$total = $total + $line_pd['monto'];
			}
		// asigno las sesiones para el ordenamiento
		$_SESSION["alycar_matriz"] 				= 	$arrRegistros;
		
		$miSmarty->assign('arrRegistros', $arrRegistros);
		$miSmarty->assign('total', $total);		
		$objResponse->addAssign("divabonos", "innerHTML", $miSmarty->fetch('sg_informe_ayudas_economicas_list.tpl'));
			
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
	
	$miSmarty->assign('arrRegistros', $arrRegistros);
	$objResponse->addAssign("divabonos", "innerHTML", $miSmarty->fetch('sg_informe_ayudas_economicas_list.tpl'));
	
	
	return $objResponse->getXML();
}

function MuestraRegistro($data, $campo1, $campo2, $obj1, $obj2){
	global $conexion;
	
        $objResponse = new xajaxResponse('ISO-8859-1');
	
        $objResponse->addAssign("$obj1", "value", $campo1);
	$objResponse->addAssign("$obj2", "value", $campo2);
	$objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'cboFamilia','sgbodega.familias','','Todas','fa_codigo', 'fa_nombre', '')");
	//$objResponse->addScript("xajax_CargaSubFamilias(xajax.getFormValues('Form1'))");
        return $objResponse->getXML();
}

function CargaDesc($data, $tabla, $campo1, $campo2, $objeto1, $objeto2, $c_and){
    global $conexion;
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	//mysql_select_db("sgyonley", $conexion);
	
	$ncorr 		= 	$data["$objeto1"];
	
	if (($tabla == 'sgbodega.tallas') OR ($tabla == 'sgbodega.tallasnew')){
		$sql = "select ta_ncorr, ta_descripcion, ta_busqueda, ta_venta from sgbodega.tallasnew where $campo1 = '".$ncorr."'";
		$res = mysql_query($sql, $conexion);
		
		$objResponse->addAssign("OBLItxtDescProducto", "value", @mysql_result($res,0,"ta_busqueda")." ".@mysql_result($res,0,"ta_descripcion"));
                $objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'cboFamilia','sgbodega.familias','','Todas','fa_codigo', 'fa_nombre', '')");
	
		//$objResponse->addScript("xajax_CalculaTotalesLinea(xajax.getFormValues('Form1'))");
	
	}else{
		
		$sql = "select $campo2 as descripcion from $tabla where $campo1 = '".$ncorr."' $and";
		$res = mysql_query($sql, $conexion);
		$objResponse->addAssign("$objeto2", "value", @mysql_result($res,0,"descripcion"));
	}	
	
	return $objResponse->getXML();
}
function CargaSelect($data, $select, $tabla, $codigo, $descripcion, $campo1, $campo2, $opt){
    global $conexion;
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	$objResponse->addAssign("$select","innerHTML",""); 		
	$sql = "select $campo1 as codigo, $campo2 as descripcion from ".$tabla;
	$res = mysql_query($sql, $conexion);
	if (mysql_num_rows($res) > 0) {
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


function CargaPagina($data){
    global $conexion;
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	//carga familias
	$objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'cboFamilia','sgbodega.familias','','Todos','fa_codigo', 'fa_nombre', '')");
	$objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'cboTipo','tipo_anticipos','','Todos','ta_ncorr','nombre', '')");
	//$objResponse->addScript("document.getElementById('OBLIcboEmpresa').focus();");

	return $objResponse->getXML();
}          

function Imprime(){
    global $conexion;
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	$objResponse->addScript("ImprimeDiv('divabonos');");
	
	return $objResponse->getXML();
}

$xajax->registerFunction("MuestraRegistro");
$xajax->registerFunction("Grabar");
$xajax->registerFunction("Ordenar");
$xajax->registerFunction("CargaPagina");
$xajax->registerFunction("CargaDesc");
$xajax->registerFunction("CargaSelect");
$xajax->registerFunction("Imprime");

$xajax->processRequests();
$miSmarty->assign('xajax_js', $xajax->getJavascript());

$miSmarty->display('sg_informe_ayudas_economicas.tpl');

?>

