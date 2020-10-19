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

$xajax->setRequestURI("sg_informe_anticipos_trabajador.php");
$xajax->setCharEncoding("ISO-8859-1");
$xajax->decodeUTF8InputOn();

function Grabar($data){
	global $conexion;
	global $miSmarty;
        
	$objResponse = new xajaxResponse('ISO-8859-1');
	
	$trabajador         =   $data["OBLItxtCodCobrador"];
    	$OBLItxtFecha1      =   $data["OBLItxtFecha1"];
    	$OBLItxtFecha2 		=	$data["OBLItxtFecha2"];
	$cboTipo			= 	$data["cboTipo"];
	$cboEstado   		= 	$data["cboEstado"];
        
	$objResponse->addScript("document.getElementById('divlistado').style.display='none';");
	
	if (($cboTipo != '') && ($cboTipo != 'Todos')){
		$and = " and anticipos.tipo = '".$cboTipo."'";
	}
	if (($trabajador != '')){
		$and .= " and anticipos.trabajador = '".$trabajador."'";
	}
	
	if (($cboEstado != '') && ($cboEstado != 'Todos')){
		$and .= " and anticipos.estado = '".$cboEstado."'";
	}

	if (($OBLItxtFecha1 != '') && ($OBLItxtFecha2 != '') ){
		list($dia3,$mes3,$anio3) = explode('/', $OBLItxtFecha1);$OBLItxtFecha1 = $anio3."-".$mes3."-".$dia3;
		list($dia3,$mes3,$anio3) = explode('/', $OBLItxtFecha2);$OBLItxtFecha2 = $anio3."-".$mes3."-".$dia3;
		$and .= " and anticipos.fecha between '".$OBLItxtFecha1."' and '".$OBLItxtFecha2."' ";
	}

	$sql_pd="SELECT sgyonley.empresas.empe_desc as centro_costo,
					fecha,
					trabajador,
					tipo_anticipos.nombre as tipo,
					monto,
					sgcompras.forma_pago.nombre as forma_pago,
					observacion,
					estado,
					usuario,
					fecha_digitacion 
			 FROM  anticipos
			 	inner join sgyonley.empresas
					on sgyonley.empresas.empe_rut = anticipos.centro_costo
				left join tipo_anticipos
					on anticipos.tipo = tipo_anticipos.ta_ncorr	
				left join sgcompras.forma_pago
					on anticipos.caja = sgcompras.forma_pago.fp_ncorr 
			 where anticipos.estado <> 'ESPERANDO_CORREO' $and 
			 order by fecha asc";        
	$res_pd = mysql_query($sql_pd, $conexion) or die(mysql_error());
	if (mysql_num_rows($res_pd) > 0){
		$arrRegistros		= 	array();
		$i 					= 	1;
		$total = 0;
		while ($line_pd = mysql_fetch_array($res_pd)) {
			$sql_1 = "select concat(apellido_pat,' ',apellido_mat,' ',nombres) as nombres
						from sggeneral.trabajadores
						where rut = ".$line_pd['trabajador'];
			$res_1 = mysql_query($sql_1,$conexion) or die(mysql_error());
			$row_1 = mysql_fetch_array($res_1);
			
			$nombre_trabajador = $row_1['nombres'];
			
			array_push($arrRegistros, array(
						"centro_costo" 		=> 	$line_pd['centro_costo'],
						"fecha"  		=> 	$line_pd['fecha'],
						"trabajador"		=> 	$nombre_trabajador,
						"tipo"   		=> 	$line_pd['tipo'],
						"monto" 		=> 	$line_pd['monto'],
						"forma_pago"   		=> 	$line_pd['forma_pago'],
						"observacion"   	=> 	$line_pd['observacion'],
						"estado"   		=> 	$line_pd['estado'],
						"usuario"   		=> 	$line_pd['usuario'],
						"fecha_digitacion"	=>  $line_pd['fecha_digitacion']
						));
			$total = $total + $line_pd['monto'];
			}
		// asigno las sesiones para el ordenamiento
		$_SESSION["alycar_matriz"] 				= 	$arrRegistros;
		$arrRegistros = ordenar_matriz_multidimensionada($_SESSION["alycar_matriz"],"trabajador",'ASC');
	
		$miSmarty->assign('arrRegistros', $arrRegistros);
		$miSmarty->assign('total', $total);		
		$objResponse->addAssign("divabonos", "innerHTML", $miSmarty->fetch('sg_informe_anticipos_trabajador_list.tpl'));
			
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
	$objResponse->addAssign("divabonos", "innerHTML", $miSmarty->fetch('sg_informe_anticipos_trabajador_list.tpl'));
	
	
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

$miSmarty->display('sg_informe_anticipos_trabajador.tpl');

?>

