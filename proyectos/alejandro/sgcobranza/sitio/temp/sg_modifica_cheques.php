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

$xajax->setRequestURI("sg_modifica_cheques.php");
$xajax->setCharEncoding("ISO-8859-1");
$xajax->decodeUTF8InputOn();

function Grabar($data){
	global $conexion;
	
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	$ChId				=	trim($data["txtNcorr"]);
	$tope_ncorr			=	trim($data["OBLIcboOperacion"]);
	$ChCtaCte			=	trim($data["OBLItxtCodCuenta"]);
	$ChDocumento		=	trim($data["OBLItxtNumDoc"]);
	$ChFechaEmite		=	$data["OBLItxtFechaEmision"];
	$ChFechaVence		=	$data["OBLItxtFechaVencimiento"];
	$ChDetalle			=	trim(strtoupper($data["OBLItxtDetalle"]));
	$ChValor			=	trim($data["OBLItxtMonto"]);
	$ChPagado			=	$data["cboPagado"];
	$ChFechaPago		=	$data["txtFechaPago"];
	$ingresa			=	"SI";
	
	list($dia1,$mes1,$anio1) = split('[/.-]', $ChFechaEmite);$ChFechaEmite = $anio1."-".$mes1."-".$dia1;
	list($dia2,$mes2,$anio2) = split('[/.-]', $ChFechaVence);$ChFechaVence = $anio2."-".$mes2."-".$dia2;
	list($dia3,$mes3,$anio3) = split('[/.-]', $ChFechaPago);$ChFechaPago = $anio3."-".$mes3."-".$dia3;
	
	if ($ChPagado == 1 && $ChFechaPago == '--'){
		$objResponse->addScript("alert('Debe Ingresar la Fecha de Pago.')");
		$ingresa = 'NO';
	}
	
	/*
	if ($ChFechaVence != '--' && $ChFechaPago != '--' && $ChFechaPago != ''){
		$sql_dif = "SELECT DATEDIFF('".$ChFechaPago."','".$ChFechaVence."') as dif";
		$res_dif = mysql_query($sql_dif,$conexion);
		if (@mysql_result($res_dif,0,"dif") < 0){
			$objResponse->addScript("alert('La Fecha de Pago no puede ser menor a la Fecha de Vencimiento.')");
			$ingresa = 'NO';
		}
	}
	*/
	
	
	if ($ingresa == 'SI'){
	
		if ($ChId != ''){
			$sql = "update cheques set
						tope_ncorr		=	'".$tope_ncorr."',
						ChCtaCte		=	'".$ChCtaCte."',
						ChDocumento		=	'".$ChDocumento."',
						ChFechaEmite	=	'".$ChFechaEmite."',
						ChFechaVence	=	'".$ChFechaVence."',
						ChDetalle		=	'".$ChDetalle."',
						ChValor			=	'".$ChValor."',
						ChPagado		=	'".$ChPagado."',
						ChFechaPago		=	'".$ChFechaPago."'
					where
						ChId			=	'".$ChId."'";
						
		}else{
			$sql = "insert into cheques (tope_ncorr,ChCtaCte,ChDocumento,ChFechaEmite,ChFechaVence,ChDetalle,ChValor,ChPagado,ChFechaPago)
					values 
					('".$tope_ncorr."','".$ChCtaCte."','".$ChDocumento."','".$ChFechaEmite."','".$ChFechaVence."','".$ChDetalle."','".$ChValor."','".$ChPagado."','".$ChFechaPago."')";
		}
		
		$res = mysql_query($sql, $conexion);
		
		$objResponse->addScript("alert('Registro Grabado Correctamente.')");
		$objResponse->addScript("window.parent.xajax_Grabar(window.parent.xajax.getFormValues('Form1'))");
		$objResponse->addScript("window.parent.hidePopWin(true)");	
	}
	
	return $objResponse->getXML();
}

function CargaPagina($data){
    global $conexion;
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	// carga los tipos de operaciones
	//$objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'OBLIcboOperacion','tipos_operaciones','','- - Seleccione - -','tope_ncorr','tope_desc', '')");
	
	$ChId	=	trim($data["txtNcorr"]);
	
	// busca el cheque
	if ($ChId != ''){
		
		$sql = "select
					a.ChCtaCte as cod_cta,
					b.CaNombre as desc_cta,
					a.ChDocumento as num_doc,
					a.ChDetalle as detalle,
					DATE_FORMAT(a.ChFechaEmite,'%d/%m/%Y') as fecha_emision,
					DATE_FORMAT(a.ChFechaVence,'%d/%m/%Y') as fecha_vcto,
					DATE_FORMAT(a.ChFechaPago,'%d/%m/%Y') as fecha_pago,
					a.ChValor as valor,
					a.ChPagado as pagado,
					a.tope_ncorr as operacion
				
				from 
					cheques a, cuentas b
				
				where
					a.ChId = '".$ChId."' and
					a.ChCtaCte = b.CaId";
		
		$res = mysql_query($sql,$conexion);
		
		//$objResponse->addCreate("OBLIcboOperacion","option",""); 		
		//$objResponse->addAssign("OBLIcboOperacion","options[0].value", '1');
		//$objResponse->addAssign("cboPagado","options[0].text", "SI"); 	
		//$objResponse->addAssign("OBLIcboOperacion", "value", @mysql_result($res,0,"operacion"));
		$sql_ope = "select tope_desc from tipos_operaciones where tope_ncorr = '".@mysql_result($res,0,"operacion")."'";
		$res_ope = mysql_query($sql_ope,$conexion);
		
		$objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'OBLIcboOperacion','tipos_operaciones','".@mysql_result($res,0,"operacion")."','".@mysql_result($res_ope,0,"tope_desc")."','tope_ncorr','tope_desc', '')");
		
		$objResponse->addAssign("OBLItxtCodCuenta", "value", @mysql_result($res,0,"cod_cta"));
		$objResponse->addAssign("OBLItxtDescCuenta", "value", @mysql_result($res,0,"desc_cta"));
		$objResponse->addAssign("OBLItxtNumDoc", "value", @mysql_result($res,0,"num_doc"));
		$objResponse->addAssign("OBLItxtDetalle", "value", @mysql_result($res,0,"detalle"));
		$objResponse->addAssign("OBLItxtFechaEmision", "value", @mysql_result($res,0,"fecha_emision"));
		$objResponse->addAssign("OBLItxtFechaVencimiento", "value", @mysql_result($res,0,"fecha_vcto"));
		$objResponse->addAssign("OBLItxtMonto", "value", @mysql_result($res,0,"valor"));
		
		if (@mysql_result($res,0,"pagado") == 1){
			$objResponse->addAssign("cboPagado","innerHTML",""); 
			$objResponse->addCreate("cboPagado","option",""); 		
			$objResponse->addAssign("cboPagado","options[0].value", "1");
			$objResponse->addAssign("cboPagado","options[0].text", "SI"); 	
			$objResponse->addCreate("cboPagado","option",""); 		
			$objResponse->addAssign("cboPagado","options[1].value", "0");
			$objResponse->addAssign("cboPagado","options[1].text", "NO"); 	
		}
		
		$objResponse->addAssign("txtFechaPago", "value", @mysql_result($res,0,"fecha_pago"));
	}
	
	$objResponse->addScript("document.getElementById('OBLItxtCodCuenta').focus();");
	
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
			/*
			$sql_emp = "select empe_rut from trabajadores where trab_ncorr = '".$ncorr_trab."'"; $res_emp = mysql_query($sql_emp,$conexion);
			$empe_rut = @mysql_result($res_emp,0,"empe_rut");
			$objResponse->addAssign("txtRutEmpresa", "value", $empe_rut);
			*/
			
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
function MuestraRegistro($data, $campo1, $campo2, $obj1, $obj2){
	global $conexion;
	
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	$objResponse->addAssign("$obj1", "value", $campo1);
	$objResponse->addAssign("$obj2", "value", $campo2);
	
	return $objResponse->getXML();
}
function Eliminar($data){
	global $conexion;
	
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	$ChId	=	trim($data["txtNcorr"]);
	if ($ChId != ''){
		$sql = "delete from cheques where ChId = '".$ChId."'";
		$res = mysql_query($sql,$conexion);
		$objResponse->addScript("alert('Registro Eliminado Correctamente.')");
		$objResponse->addScript("window.parent.xajax_Grabar(window.parent.xajax.getFormValues('Form1'))");
		$objResponse->addScript("window.parent.hidePopWin(true)");	
		
	}
	
	return $objResponse->getXML();
}
$xajax->registerFunction("CargaPagina");
$xajax->registerFunction("Grabar");
$xajax->registerFunction("CargaSelect");
$xajax->registerFunction("CargaDesc");
$xajax->registerFunction("MuestraRegistro");
$xajax->registerFunction("Eliminar");


$xajax->processRequests();
$miSmarty->assign('xajax_js', $xajax->getJavascript());

$miSmarty->assign('NCORR', $_GET['ncorr']);

$miSmarty->display('sg_modifica_cheques.tpl');

?>

