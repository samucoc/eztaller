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

$xajax->setRequestURI("sg_busqueda.php");
$xajax->setCharEncoding("ISO-8859-1");
$xajax->decodeUTF8InputOn();

function Grabar($data){
	global $conexion;
	global $miSmarty;
	
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	$tbl			=	$data["txtTbl"];
	$buscar_por		=	$data["OBLIcboBuscarPor"];
	$texto			=	$data["txtTexto"];
	
	if ($tbl == 'trabajadores'){
		if ($buscar_por == '01'){
			$where = "concat(trab_nombres,' ',trab_apellidos) like '%".$texto."%'";
		}
		if ($buscar_por == '02'){
			$where = "trab_rut like '%".$texto."%'";
		}
		
		$sql = "select 
				trab_ncorr as codigo,
				trab_rut as rut,
				concat(trab_nombres,' ',trab_apellidos) as nombre
				
				from 
				trabajadores
					
				where
				$where";
	}
	if ($tbl == 'proveedores'){
		if ($buscar_por == '01'){
			$where = "PR_RAZON like '%".$texto."%'";
		}
		if ($buscar_por == '02'){
			$where = "PR_RUT like '%".$texto."%'";
		}
		
		$sql = "select 
				PR_NCORR as codigo,
				PR_RUT as rut,
				PR_RAZON as nombre
				
				from 
				sgbodega.proveedor
					
				where
				$where";
	}
	
	$res = mysql_query($sql, $conexion);
	if (mysql_num_rows($res) > 0){
		$arrRegistros	= 	array();
		while ($line = mysql_fetch_row($res)) {
			
			array_push($arrRegistros, array("codigo"	=>	$line[0],
											"rut"		=> 	$line[1]."-".dv($line[1]),
											"nombre"	=> 	$line[2]));
		
		}
		
		$miSmarty->assign('arrRegistros', $arrRegistros);
		
	}
	
	$objResponse->addAssign("divresultado", "innerHTML", $miSmarty->fetch('sg_busqueda_list.tpl'));
	
	return $objResponse->getXML();
	
}

function TraeValor($data, $ncorr){
	global $conexion;
	
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	$tbl = $data["txtTbl"];
	
	if ($tbl == 'trabajadores'){
		$objResponse->addScript("document.location.href='sg_mant_trabajadores.php?ncorr=$ncorr'");
	}
	if ($tbl == 'proveedores'){
		$objResponse->addScript("document.location.href='sg_mant_proveedores.php?ncorr=$ncorr'");
	}
	
	return $objResponse->getXML();
}
function CargaPagina($data){
    global $conexion;
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	$objResponse->addScript("document.getElementById('txtTexto').focus();");
	
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

$xajax->registerFunction("CargaPagina");
$xajax->registerFunction("Grabar");
$xajax->registerFunction("TraeValor");
$xajax->registerFunction("CargaSelect");


$xajax->processRequests();
$miSmarty->assign('xajax_js', $xajax->getJavascript());

$tbl = $_GET["tbl"];

if ($tbl == 'trabajadores'){$titulo = 'Trabajadores';}
if ($tbl == 'proveedores'){$titulo = 'Proveedores';}

$miSmarty->assign('TBL', $tbl);
$miSmarty->assign('TITULO', $titulo);

$miSmarty->display('sg_busqueda.tpl');

?>

