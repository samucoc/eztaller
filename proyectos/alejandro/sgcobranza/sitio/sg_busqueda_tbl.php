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

$xajax->setRequestURI("sg_busqueda_tbl.php");
$xajax->setCharEncoding("UTF8");
$xajax->decodeUTF8InputOn();

function Busca($data, $opt){
	global $conexion;
	global $miSmarty;
	
    $objResponse = new xajaxResponse('UTF8');
	
	$tbl			=	$data["txtTbl"];
	$ncorr			=	$data["txtObj1"];
	$desc			=	$data["txtObj2"];
	
	if ($tbl == 'cuentas'){
		if ($opt == '1'){$campo = "CaId"; $texto = $ncorr;}
		if ($opt == '2'){$campo = "CaNombre";	$texto = $desc;}
		
		$sql = "select CaId, CaNombre from $tbl where $campo like '".$texto."%' order by CaId asc";
	}
	$res = mysql_query($sql,$conexion);
	
	$arrRegistros	= 	array();
	while ($line = mysql_fetch_row($res)) {
		
		array_push($arrRegistros, array("ncorr"	=>	$line[0],
										"desc"	=> 	$line[1]));
	
	}
	
	$miSmarty->assign('arrRegistros', $arrRegistros);
	
	$objResponse->addAssign("divresultado", "innerHTML", $miSmarty->fetch('sg_busqueda_tbl_list.tpl'));
	
	return $objResponse->getXML();
	
}

function TraeValor($data, $ncorr, $desc){
	global $conexion;
	
    $objResponse = new xajaxResponse('UTF8');
	
	$tbl = $data["txtTbl"];
	
	if ($tbl == 'cuentas'){
		$obj1	=	"OBLItxtCodCuenta";
		$obj2	=	"OBLItxtDescCuenta";
		$objResponse->addScript("window.parent.xajax_MuestraRegistro(xajax.getFormValues('Form1'), '$ncorr', '$desc', '$obj1', '$obj2')");
	}
	
	$objResponse->addScript("window.parent.hidePopWin(true)");
	
	return $objResponse->getXML();
}
function CargaPagina($data){
    global $conexion;
	global $miSmarty;
	
    $objResponse = new xajaxResponse('UTF8');
	
	$tbl		=	$data["txtTbl"];
	
	if ($tbl == 'cuentas'){
		$sql = "select CaId, CaNombre from $tbl order by CaId asc";
	}
	
	$res = mysql_query($sql, $conexion);
	if (mysql_num_rows($res) > 0){
		$arrRegistros	= 	array();
		while ($line = mysql_fetch_row($res)) {
			
			array_push($arrRegistros, array("ncorr"	=>	$line[0],
											"desc"	=> 	$line[1]));
		
		}
		
		$miSmarty->assign('arrRegistros', $arrRegistros);
		
	}
	
	$objResponse->addAssign("divresultado", "innerHTML", $miSmarty->fetch('sg_busqueda_tbl_list.tpl'));
	
	$objResponse->addScript("document.getElementById('txtObj2').focus();");
	
	return $objResponse->getXML();
}
function CargaSelect($data, $select, $tabla, $codigo, $descripcion, $campo1, $campo2, $opt){
    global $conexion;
    $objResponse = new xajaxResponse('UTF8');
	
	
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

$xajax->registerFunction("CargaPagina");
$xajax->registerFunction("Busca");
$xajax->registerFunction("TraeValor");
$xajax->registerFunction("CargaSelect");


$xajax->processRequests();
$miSmarty->assign('xajax_js', $xajax->getJavascript());

$tbl 		= $_GET["tbl"];
$tgas_ncorr = $_GET["tgas_ncorr"];

if ($tbl == 'trabajadores'){$titulo = 'Trabajadores';}
if ($tbl == 'proveedores'){$titulo = 'Proveedores';}

$miSmarty->assign('TBL', $tbl);
$miSmarty->assign('TGAS_NCORR', $tgas_ncorr);

$miSmarty->assign('TITULO', $titulo);

$miSmarty->display('sg_busqueda_tbl.tpl');

?>

