<?php
session_start();

require_once 'includes/xajax/xajax.inc.php'; //archivo de configuracion de ajax
include "../includes/php/conf_smarty.php";//archivo de configuracion de smarty
include "../includes/php/conf_bd.php"; //archivo de coneccion al servidor y base de datos
//include "../includes/php/conf_bd_antigua.php"; //archivo de coneccion al servidor de yonley
include "../includes/php/validaciones.php"; 

$xajax = new xajax();

$xajax->setRequestURI("sg_informe_facturas_compras.php");
$xajax->setCharEncoding("ISO-8859-1");
$xajax->decodeUTF8InputOn();

function Grabar($data){
	global $conexion;
	global $miSmarty;
	
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	$empresa		= 	$data["OBLIempresa"];
	$fecha_inicio	= 	$data["txtFecha1"];
	$fecha_fin		= 	$data["txtFecha2"];
	$boleta			= 	$data['boleta'];
	$mes			=	$data['cboMes'];
	$anio			=	$data['cboAnio'];
	$estado			=	$data['estado_factura'];
	
	$objResponse->addScript("document.getElementById('divlistado').style.display='none';");
	
		if (($fecha_inicio != '')&&($fecha_fin != '')){
       	
			list($dia1,$mes1,$anio1) = split('[/.-]', $fecha_inicio);
				$nro_mes_anterior       = mktime(0, 0, 0, $mes1, $dia1,   $anio1);
				$fecha_inicio              = date("Y-m-d",$nro_mes_anterior);
				
			list($dia1,$mes1,$anio1) = split('[/.-]', $fecha_fin);
				$nro_mes_anterior       = mktime(0, 0, 0, $mes1, $dia1,   $anio1);
				$fecha_fin              = date("Y-m-d",$nro_mes_anterior);
				$and="";
			
			$and .= "and fecha between '".$fecha_inicio."' and '".$fecha_fin."' ";
			
			}
                    
        if ($empresa != '- - Seleccione - -'){
            $and .= " and empresa = '".$empresa."' " ;
        	}
        if ($boleta != ''){
            $and .= " and nro_factura = '".$boleta."' " ;
        	}
		if ($mes != ''){
			$and .= " and mes = '".$mes."' " ;
        	}
		if ($anio != ''){
			$and .= " and anio = '".$anio."' " ;
			}
		if ($estado != ''){
            $and .= " and estado_factura = '".$estado."' " ;
        }	
			
	$sql_ab = "select empresa, rut, factura_ncorr, fecha, facturas.nro_factura, neto, iva, total
                    from facturas
						inner join facturas_periodo
							on facturas.factura_ncorr = facturas_periodo.nro_factura
                    where tipo_factura = 'COMPRAS' 
					        ".$and."";
        $res_ab = mysql_query($sql_ab, $conexion) or die(mysql_error());
	if (mysql_num_rows($res_ab) > 0){
		$arrRegistros	= 	array();
		$i = 1;
		$total = 0;
		while ($line_ab_1 = mysql_fetch_array($res_ab)){
			
			$sql_pr = "select empe_desc from sgyonley.empresas where empe_rut = '".$line_ab_1['empresa']."'";
			$res_pr = mysql_query($sql_pr, $conexion);
			$nombre_empresa = @mysql_result($res_pr,0,"empe_desc");
			
			$sql_pr = "select PR_RAZON from sgbodega.proveedor where PR_RUT  = '".$line_ab_1['rut']."' union
						select PR_RAZON from sgbodega.proveedor where PR_NCORR  = '".$line_ab_1['rut']."'";
			$res_pr = mysql_query($sql_pr, $conexion);
			$nombre_persona = @mysql_result($res_pr,0,"PR_RAZON");
			
			$total += $line_ab_1['total'];
			
			$sql = "select cier_fecha
					from cierres where empe_rut = '".$line_ab_1['empresa']."' order by cier_fecha desc limit 1";
			$res = mysql_query($sql, $conexion);
			$ult_cierre = @mysql_result($res,0,"cier_fecha");
			// verifico que la fecha de cierre sea mayor que la fecha del ultimo cierre
			$sql_dif =	"SELECT DATEDIFF('".$line_ab_1['fecha']."','".$ult_cierre."') as dias_dif";
			$res_dif = mysql_query($sql_dif,$conexion);
			$dias_dif = @mysql_result($res_dif,0,"dias_dif");
			$ingresa = "SI";
			if ($dias_dif <= 0){
				$ingresa = 'NO';
				}
			
			array_push($arrRegistros, array("item"			=>	$i,
											"ncorr" 		=> 	$line_ab_1['factura_ncorr'],
											"empresa"  		=> 	$nombre_empresa,
											"fecha"   		=> 	$line_ab_1['fecha'],
											"cliente" 		=> 	$nombre_persona,
											"nro_boleta"   	=> 	$line_ab_1['nro_factura'],
											"neto"   		=> 	$line_ab_1['neto'],
											"iva"   		=> 	$line_ab_1['iva'],
											"total"   		=> 	$line_ab_1['total'],
											"cierre"		=>  $ingresa 
											));
			$i++;
			} 
		$_SESSION["alycar_matriz"] = $arrRegistros;
        $miSmarty->assign('arrRegistros', $arrRegistros);
		$objResponse->addAssign("divabonos", "innerHTML", $miSmarty->fetch('sg_informe_facturas_compras_list.tpl'));
		$objResponse->addAssign("total", "innerHTML", number_format($total,0 , '.', ','));
		
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
	$objResponse->addAssign("divabonos", "innerHTML", $miSmarty->fetch('sg_informe_facturas_compras_list.tpl'));
	
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
	
	echo $sql = "select $campo1 as rut, $campo2 as descripcion from $tabla $c_and ";
	
    $res = mysql_query($sql, $conexion) or die(mysql_error());
	
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
function Eliminar($data,$ncorr){
    global $conexion;
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	$sql ="delete from facturas_periodo where nro_factura = ".$ncorr."";
	$res = mysql_query($sql,$conexion);
	
		$objResponse->addScript("alert('Registro Eliminado')");
		$objResponse->addScript("document.Form1.submit();");
	
	return $objResponse->getXML();
}
function CargaPagina($data){
    global $conexion;
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	// carga empresas
	$objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'OBLIempresa','sgyonley.empresas','','- - Seleccione - -','empe_rut','empe_desc', 'order by empe_rut desc')");
		
	return $objResponse->getXML();
}  
$xajax->registerFunction("MuestraRegistro");
$xajax->registerFunction("CargaPagina");
$xajax->registerFunction("CargaDesc");
$xajax->registerFunction("CargaSelect");
$xajax->registerFunction("Grabar");
$xajax->registerFunction("Eliminar");
$xajax->registerFunction("Ordenar");
$xajax->registerFunction("Imprime");

$xajax->processRequests();
$miSmarty->assign('xajax_js', $xajax->getJavascript());

$miSmarty->display('sg_informe_facturas_compras.tpl');

?>

