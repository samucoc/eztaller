<?php
session_set_cookie_params('18000'); // 5 HORAS
session_start();
if (!isset($_SESSION['alycar_usuario'])){
	?>
	<script>top.location.href='sg_index.php'</script>
	<?php
}


require_once 'includes/xajax/xajax.inc.php'; //archivo de configuracion de ajax
include "../includes/php/conf_smarty.php";//archivo de configuracion de smarty
include "../includes/php/conf_bd.php"; //archivo de coneccion al servidor y base de datos
include "../includes/php/validaciones.php"; //validaciones

$xajax = new xajax();

$xajax->setRequestURI("sg_ppm.php");
$xajax->setCharEncoding("ISO-8859-1");
$xajax->decodeUTF8InputOn();

function Grabar($data){
	global $conexion;
	
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	$empe_rut			=	$data["OBLIcboEmpresa"];
	$monto			=	$data["OBLImonto"];
	$cier_mes			=	$data["cboMes"];
	$cier_anio			=	$data["cboAnio"];
	$ingresa			=	'SI';
	
	if ($ingresa == 'SI'){
		if ($cier_mes == '' OR $cier_mes == '- - Seleccione - -'){
			$ingresa = 'NO';
			$objResponse->addScript("alert('Mes incorrecto.')");
		}
	}
	if ($ingresa == 'SI'){
		if ($cier_anio == '' OR $cier_anio == '- - Seleccione - -'){
			$ingresa = 'NO';
			$objResponse->addScript("alert('Año incorrecto.')");
		}
	}
	if ($ingresa == 'SI'){
		$sql = "select * 
				from ppm
				where mes = '".$cier_mes."' and
					anio = '".$cier_anio."'";
		$res = mysql_query($sql);
		if (mysql_num_rows($res)>0){
			$ingresa = 'NO';
			$objResponse->addScript("alert('Periodo Asociado ya Ingresado')");
			}
	}
	if ($ingresa == 'SI'){
		$sql = "insert into ppm
				( `empresa`, `monto`, `mes`, `anio`)
				
				values 
				('".$empe_rut."','".$monto."','".$cier_mes."','".$cier_anio."')";
		
		$res = mysql_query($sql, $conexion);
		
		$objResponse->addScript("alert('Registro Grabado Correctamente.')");
			
		$objResponse->addScript("document.Form1.submit();");
	}
	
	return $objResponse->getXML();
}

function CargaPagina($data){
    global $conexion;
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	// carga empresas
	$objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'OBLIcboEmpresa','sgyonley.empresas','','- - Seleccione - -','empe_rut','empe_desc', 'order by empe_rut desc')");
	
	return $objResponse->getXML();
}
function CargaSelect($data, $select, $tabla, $codigo, $descripcion, $campo1, $campo2, $opt){
    global $conexion;
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	
	$objResponse->addAssign("$select","innerHTML",""); 		
	$sql = "select $campo1 as codigo, $campo2 as descripcion from $tabla $opt";
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
	
	$ncorr_trab		= 	$data["OBLItxtCodTrabajador"];
	$ncorr 			= 	$data["$objeto1"];
	$empe_rut		=	$data["OBLIcboEmpresa"];
	$tgas_ncorr 	= 	$data["OBLItxtCodGasto"];
	
	if ($tabla == 'trabajadores'){
		$sql = "select concat(trab_nombres,' ',trab_apellidos) as descripcion from $tabla where $campo1 = '".$ncorr."' $and";
	}else{
	
		if ($tabla == 'sgyonley.sectores'){
			$sql_eco = "select empe_ncorr from sgyonley.empresas where empe_rut = '".$empe_rut."'"; $res_eco = mysql_query($sql_eco,$conexion);
			$empe_ncorr = @mysql_result($res_eco,0,"empe_ncorr");
			
			$sql = "select sect_desc as descripcion from $tabla where sect_cod = '".$ncorr."' and empe_ncorr = '".$empe_ncorr."'";
		
		}else{
		
			if ($tabla == 'tipos_subgastos'){
				$sql = "select tsga_desc as descripcion from tipos_subgastos where tsga_ncorr = '".$ncorr."' and tgas_ncorr = '".$tgas_ncorr."'";
			}else{	
				if ($tabla == 'tipos_gastos'){
					$objResponse->addAssign("OBLItxtCodSubGasto", "value", "");
					$objResponse->addAssign("OBLItxtDescSubGasto", "value", "");
				}
				$sql = "select $campo2 as descripcion from $tabla where $campo1 = '".$ncorr."' $and";
			}
		}
	}
	
	$res = mysql_query($sql, $conexion);
	
	$objResponse->addAssign("$objeto2", "value", @mysql_result($res,0,"descripcion"));
	
	return $objResponse->getXML();
}

$xajax->registerFunction("CargaPagina");
$xajax->registerFunction("Grabar");
$xajax->registerFunction("CargaSelect");
$xajax->registerFunction("MuestraUltCierre");
$xajax->registerFunction("MuestraRegistro");
$xajax->registerFunction("CargaDesc");


$xajax->processRequests();
$miSmarty->assign('xajax_js', $xajax->getJavascript());


$miSmarty->display('sg_ppm.tpl');

?>

