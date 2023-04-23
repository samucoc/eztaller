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

$xajax->setRequestURI("sg_informe_locomocion.php");
$xajax->setCharEncoding("ISO-8859-1");
$xajax->decodeUTF8InputOn();

function Grabar($data){
	global $conexion;
	global $miSmarty;
        
	$objResponse = new xajaxResponse('ISO-8859-1');
	
	$OBLItxtFecha1  =   $data["OBLItxtFecha1"];
     $OBLItxtFecha2 		=	$data["OBLItxtFecha2"];
	
		$centro_costo	= $data['centro_costo'];     
	$tt		= $data['tt'];     
	$grupo	 	= $data['grupo'];     
	$objResponse->addScript("document.getElementById('divlistado').style.display='none';");
	
	if (($OBLItxtFecha1 != '')){
		list($dia3,$mes3,$anio3) = explode('/', $OBLItxtFecha1);$OBLItxtFecha1 = $anio3."-".$mes3."-".$dia3;
		list($dia3,$mes3,$anio3) = explode('/', $OBLItxtFecha2);$OBLItxtFecha2 = $anio3."-".$mes3."-".$dia3;
		$and .= " and locomocion.fecha between '".$OBLItxtFecha1."' and '".$OBLItxtFecha2."' ";
	}

	if (($centro_costo != '')&&($centro_costo != '- - Seleccione - -')){
		$and .= " and locomocion.empresa = '".$centro_costo."' ";
	}
	if (($tt != '')&&($tt != 'Todos')){
		$and .= " and locomocion.tipo_trab = '".$tt."' ";
	}
	
	$sql_pd="SELECT fecha,
				rut_trab,
				total,
				cantidad_dias
			 FROM  locomocion
			 where estado = 'PAGADO' $and 
			 order by fecha asc";        
	$res_pd = mysql_query($sql_pd, $conexion) or die(mysql_error());
	if (mysql_num_rows($res_pd) > 0){
		$arrRegistros		= 	array();
		$i 					= 	1;
		$total = 0;
		while ($line_pd = mysql_fetch_array($res_pd)) {
			
			$dias = $line_pd['cantidad_dias'];
			
			$sql_1 = "select concat(apellido_pat,' ',apellido_mat,' ',nombres) as nombres
						from sggeneral.trabajadores
						where rut = ".$line_pd['rut_trab'];
			$res_1 = mysql_query($sql_1,$conexion) or die(mysql_error());
			$row_1 = mysql_fetch_array($res_1);
			
			$nombre_trabajador = $row_1['nombres'];
			
			
			array_push($arrRegistros, array("fecha"  => 	$line_pd['fecha'],
							"rut_trab"	=> 	$line_pd['rut_trab'].'-'.dv($line_pd['rut_trab']),
							"trabajador"	=> 	$nombre_trabajador,
							"dias"	=> 	$dias,
							"monto" 	=> 	$line_pd['total'],
							"grupo"		=> 	$tipo_trabajador));
			$total = $total + $line_pd['total'];
			}
		// asigno las sesiones para el ordenamiento
		$_SESSION["alycar_matriz"] 				= 	$arrRegistros;
		$arrRegistros = ordenar_matriz_multidimensionada($_SESSION["alycar_matriz"],"trabajador",'ASC');
	
		$miSmarty->assign('arrRegistros', $arrRegistros);
		$miSmarty->assign('total', $total);
		
		$sql_1 = "select empe_desc as nombre from sgyonley.empresas where empe_rut = '".$centro_costo."'";
		$res_1 = mysql_query($sql_1,$conexion);
		$row_1 = mysql_fetch_array($res_1);
		$miSmarty->assign('empresa', $row_1['nombre']);
		
		list($anio3,$mes3,$dia3) = explode('-', $OBLItxtFecha1);
		$mes="";
		if ($mes3=='01')$mes =  'Enero' ;
		elseif( $mes3=='02') $mes =  'Febrero' ; 
		elseif( $mes3=='03') $mes = 'Marzo' ; 
		elseif( $mes3=='04') $mes = 'Abril' ; 
		elseif( $mes3=='05') $mes = 'Mayo' ;
		elseif( $mes3=='06') $mes = 'Junio' ; 
		elseif( $mes3=='07') $mes = 'Julio' ; 
		elseif( $mes3=='08') $mes = 'Agosto' ; 
		elseif( $mes3=='09') $mes = 'Septiembre' ; 
		elseif( $mes3=='10') $mes = 'Octubre' ; 
		elseif( $mes3=='11') $mes = 'Noviembre' ; 
		elseif( $mes3=='12') $mes = 'Diciembre' ;
		$miSmarty->assign('mes', $mes.' '.$anio3);
		
		$objResponse->addAssign("divabonos", "innerHTML", $miSmarty->fetch('sg_informe_locomocion_list.tpl'));
			
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
	$objResponse->addAssign("divabonos", "innerHTML", $miSmarty->fetch('sg_informe_locomocion_list.tpl'));
	
	
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
	$objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'tt','sgvales.tipos_trabajadores','','Todos','tt_ncorr', 'nombre', '')");
	$objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'cboFamilia','sgbodega.familias','','Todos','fa_codigo', 'fa_nombre', '')");
	$objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'cboTipo','tipo_anticipos','','Todos','ta_ncorr','nombre', '')");
	$objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'centro_costo','sgyonley.empresas','','- - Seleccione - -','empe_rut','empe_desc', '')");//$objResponse->addScript("document.getElementById('OBLIcboEmpresa').focus();");

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

$miSmarty->display('sg_informe_locomocion.tpl');

?>

