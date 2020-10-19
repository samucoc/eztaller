<?php
session_start();

require_once 'includes/xajax/xajax.inc.php'; //archivo de configuracion de ajax
include "../includes/php/conf_smarty.php";//archivo de configuracion de smarty
include "../includes/php/conf_bd.php"; //archivo de coneccion al servidor y base de datos
include "../includes/php/PHPExcel.php"; //archivo de coneccion al servidor y base de datos
//include "../includes/php/PHPExcel/IOFactory.php"; //archivo de coneccion al servidor y base de datos


$xajax = new xajax();

$xajax->setRequestURI("sg_bodega_subir_inventario.php");
$xajax->setCharEncoding("ISO-8859-1");
$xajax->decodeUTF8InputOn();

if ($_POST['btnBuscar']=='Grabar'){
	global $conexion;
		
	$fecha	 			= date("Y-m-d");
	$usuario			= $_SESSION['alycar_usuario'];
	$fecha_digitacion 	= date("Y-m-d H:i:s");

	$tipo = $_FILES['archivo']['type'];
	$tamanio = $_FILES['archivo']['size'];
	$archivotmp = $_FILES['archivo']['tmp_name'];

	$archivo = "archivos/".date("Y-m-d_H:i:s").".xls";
	if (move_uploaded_file($archivotmp, $archivo) ){
			
		// Let IOFactory determine the spreadsheet format
		$document = PHPExcel_IOFactory::load($archivo);

		// Get the active sheet as an array
		$activeSheetData = $document->getActiveSheet()->toArray(null, true, true, true);

		for ($i=2; $i < count($activeSheetData); $i++) {
			$codigo_barra 		= $activeSheetData[$i]['A'];
			$codigo 			= $activeSheetData[$i]['B'];
			$descripcion 		= $activeSheetData[$i]['C'];
			$cantidad 			= $activeSheetData[$i]['D'];
			$contado 			= $activeSheetData[$i]['E'];
			$diferencia 		= $activeSheetData[$i]['F'];
			$observacion 		= $activeSheetData[$i]['G'];
			
			$sql = "INSERT INTO sgcompras.diferencias_inventario(`fecha`, `codigo_barra`, `codigo`, `deascripcion`, `cantidad`, 
															`contado`, `diferencia`, `observacion`, `usuario`, `fecha_dig`) 
					VALUES ('".$fecha."','".$codigo_barra."','".$codigo."','".$descripcion."','".$cantidad."',
								'".$contado."','".$diferencia."','".$observacion."','".$usuario."','".$fecha_digitacion."')";
			$res = mysql_query($sql,$conexion);

			}
		}
	else{
		echo "error"; 
		}
	header('location: sg_bodega_subir_inventario.php');
	}


$xajax->processRequests();
$miSmarty->assign('xajax_js', $xajax->getJavascript());

$miSmarty->display('sg_bodega_subir_inventario.tpl');

?>
