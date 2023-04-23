<?php
session_start();

require_once 'includes/xajax/xajax.inc.php'; //archivo de configuracion de ajax
include "../includes/php/conf_smarty.php";//archivo de configuracion de smarty
include "../includes/php/conf_bd.php"; //archivo de coneccion al servidor y base de datos
//include "../includes/php/conf_bd_antigua.php"; //archivo de coneccion al servidor de yonley
include "../includes/php/validaciones.php"; 

$xajax = new xajax();

$xajax->setRequestURI("sg_informe_compra_combustibles.php");
$xajax->setCharEncoding("ISO-8859-1");
$xajax->decodeUTF8InputOn();

function Grabar($data){
	global $conexion;
	global $miSmarty;
	
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	$cboEmpresa		= 	$data["cboEmpresa"];
	$cboTipo_Comb		= 	$data["cboTipo_Comb"];
	$fecha_inicio		= 	$data["OBLI-txtFecha1"];
	$fecha_fin		= 	$data["OBLI-txtFecha2"];
	$persona		= 	$data["OBLI-txtCodCobrador"];
	
	
	$objResponse->addScript("document.getElementById('divlistado').style.display='none';");
	
	list($dia1,$mes1,$anio1) = explode('/', $fecha_inicio);
        $nro_mes_anterior       = mktime(0, 0, 0, $mes1, $dia1,   $anio1);
        $fecha_inicio              = date("Y-m-d",$nro_mes_anterior);
        
	list($dia1,$mes1,$anio1) = explode('/', $fecha_fin);
        $nro_mes_anterior       = mktime(0, 0, 0, $mes1, $dia1,   $anio1);
        $fecha_fin              = date("Y-m-d",$nro_mes_anterior);
        $and="";
		
     if (($cboTipo_Comb != '')&&($cboTipo_Comb != 'Todos')){   
		$and = " and tipo_combustible like '%".$cboTipo_Comb."%'" ;
	 }
	 if (($cboEmpresa != '')&&($cboEmpresa != 'Todas')){   
		$and = " and detalle_compra_combustible.empresa like '%".$cboEmpresa."%'" ;
	 }
	 if ($persona != ''){   
		$and = " and usu_login like '%".$persona."%'" ;
	 }
	$sql_ab = "select compra_combustible.cc_ncorr, detalle_compra_combustible.empresa, 
						detalle_compra_combustible.tipo_combustible, detalle_compra_combustible.fecha,
						detalle_compra_combustible.monto, compra_combustible.usuario
                    from detalle_compra_combustible
						inner join compra_combustible 
							on detalle_compra_combustible.cc_ncorr = compra_combustible.cc_ncorr
                    where
                        detalle_compra_combustible.fecha between '".$fecha_inicio."' and '".$fecha_fin."' 
                            ".$and."";
        $res_ab = mysql_query($sql_ab, $conexion) or die(mysql_error());
	if (mysql_num_rows($res_ab) > 0){
		$arrRegistros	= 	array();
		$i = 0;
		while ($line_ab_1 = mysql_fetch_row($res_ab)){
			
			$sql_pr = "select empe_desc from empresas where empe_rut like '".$line_ab_1[1]."%'";
			$res_pr = mysql_query($sql_pr, $conexion);
			$nombre_empresa = @mysql_result($res_pr,0,"empe_desc");
			
			
			$sql_pr_1 = "select nombre from tipo_combustible where tip_com_ncorr = '".$line_ab_1[2]."'";
			$res_pr_1 = mysql_query($sql_pr_1, $conexion);
			$tipo_comb = @mysql_result($res_pr_1,0,"nombre");
			
			array_push($arrRegistros, array("item"			=>	$i,
											"ncorr"         => 	$line_ab_1[0],
											"empresa"  		=> 	$nombre_empresa,
											"tipo_comb"     => 	$tipo_comb,
											"fecha"      	=> 	$line_ab_1[3],
											"monto"     	=> 	$line_ab_1[4],
											"usuario"     	=> 	$line_ab_1[5]));
			$i++;
			
			} 
		$_SESSION["alycar_matriz"] = $arrRegistros;
        $miSmarty->assign('arrRegistros', $arrRegistros);
		$objResponse->addAssign("divabonos", "innerHTML", $miSmarty->fetch('sg_informe_compra_combustibles_list.tpl'));
		
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
	$objResponse->addAssign("divabonos", "innerHTML", $miSmarty->fetch('sg_informe_compra_combustibles_list.tpl'));
	
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
	
	$objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'cboPersona','personas','todos','Todos','pers_rut', 'pers_nombre', '')");
		
	return $objResponse->getXML();
}  
$xajax->registerFunction("MuestraRegistro");
$xajax->registerFunction("CargaPagina");
$xajax->registerFunction("CargaDesc");
$xajax->registerFunction("CargaSelect");
$xajax->registerFunction("Grabar");
$xajax->registerFunction("EliminarItem");
$xajax->registerFunction("Ordenar");
$xajax->registerFunction("Imprime");

$xajax->processRequests();
$miSmarty->assign('xajax_js', $xajax->getJavascript());


$miSmarty->display('sg_informe_compra_combustibles.tpl');

?>

