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

$xajax->setRequestURI("sg_cierre.php");
$xajax->setCharEncoding("ISO-8859-1");
$xajax->decodeUTF8InputOn();

function Grabar($data){
	global $conexion;
	
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	$empe_rut			=	$data["OBLIcboEmpresa"];
	$cier_fecha			=	$data["OBLItxtFecha"];
	$trab_ncorr			=	$data["OBLItxtCodTrabajador"];
	$cier_usuario		=	$_SESSION["alycar_usuario"];
	$cier_fechadig		=	date("Y-m-d H:i:s");
	$cier_mes			=	$data["cboMes"];
	$cier_anio			=	$data["cboAnio"];
	$ult_cierre			=	$data["txtUltimoCierre"];
	$ingresa			=	'SI';
	
	list($dia2,$mes2,$anio2) = split('[/.-]', $cier_fecha);$cier_fecha = $anio2."-".$mes2."-".$dia2;
	
	if ($ult_cierre != ''){
		list($dia3,$mes3,$anio3) = split('[/.-]', $ult_cierre);$ult_cierre = $anio3."-".$mes3."-".$dia3;
		
		// verifico que la fecha de cierre sea mayor que la fecha del ultimo cierre
		$sql_dif =	"SELECT DATEDIFF('".$cier_fecha."','".$ult_cierre."') as dias_dif";
		$res_dif = mysql_query($sql_dif,$conexion);
		$dias_dif = @mysql_result($res_dif,0,"dias_dif");
		if ($dias_dif <= 0){
			$ingresa = 'NO';
			$objResponse->addScript("alert('Fecha de Cierre Incorrecta. Debe ser mayor a la fecha del último cierre.')");
		}	
	}
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
		$sql = "insert into cierres
				(trab_ncorr,empe_rut,cier_fecha,cier_usuario,cier_fechadig, cier_mes, cier_anio)
				
				values 
				('".$trab_ncorr."','".$empe_rut."','".$cier_fecha."','".$cier_usuario."','".$cier_fechadig."','".$cier_mes."','".$cier_anio."')";
		
		$res = mysql_query($sql, $conexion);
		
		if ($ult_cierre != ''){
			
			// graba el ncorr del cierre para diferenciar los movimientos en la tabla movim (cier_ncorr)
			$cier_ncorr = @mysql_insert_id();
			
			// sumo 1 dia a la fecha del ultimo cierre
			$sql_fecha1 = 	"SELECT DATE_FORMAT(DATE_ADD('".$ult_cierre."', INTERVAL 1 DAY),'%d/%m/%Y') as fecha1";
			$res_fecha1 = 	mysql_query($sql_fecha1,$conexion);
			$fecha1		=	@mysql_result($res_fecha1,0,"fecha1");
			$fecha2		=	$cier_fecha;
			
			$sql_upd = "update cierres set cier_ncorr = '".$cier_ncorr."' where movim_fecha >= '".$fecha1."' and movim_fecha <= '".$fecha2."'";
			$res_upd = mysql_query($sql_upd,$conexion);
		}
		
		$objResponse->addScript("alert('Registro Grabado Correctamente.')");
			
		$objResponse->addScript("document.Form1.submit();");
	}
	
	return $objResponse->getXML();
}
function MuestraUltCierre($data){
	global $conexion;
	
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	//$empe_rut		=	$data["OBLIcboEmpresa"];
	$OBLIcboEmpresa		=	$data["OBLIcboEmpresa"];
	
	$sql = "select DATE_FORMAT(cier_fecha,'%d/%m/%Y') as ultimocierre from cierres where empe_rut = '".$OBLIcboEmpresa."' order by cier_fecha desc limit 1";
	$res = mysql_query($sql, $conexion);
	
	$objResponse->addAssign("txtUltimoCierre", "value", @mysql_result($res,0,"ultimocierre"));
	
	return $objResponse->getXML();
}
function CargaPagina($data){
    global $conexion;
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	// carga empresas
	$objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'OBLIcboEmpresa','sgyonley.empresas','','- - Seleccione - -','empe_rut','empe_desc', 'order by empe_rut desc')");
	
	//$objResponse->addScript("document.getElementById('OBLIcboEmpresa').focus();");
	$objResponse->addScript("document.getElementById('OBLItxtCodTrabajador').focus();");
	
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


$miSmarty->display('sg_cierre.tpl');

?>

