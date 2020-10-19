<?php
session_start();

require_once 'includes/xajax/xajax.inc.php'; //archivo de configuracion de ajax
include "../includes/php/conf_smarty.php";//archivo de configuracion de smarty
include "../includes/php/conf_bd.php"; //archivo de coneccion al servidor y base de datos
//include "../includes/php/conf_bd_antigua.php"; //archivo de coneccion al servidor de yonley
include "../includes/php/validaciones.php"; 

$xajax = new xajax();

$xajax->setRequestURI("sg_autorizar_pies_vendedor_ventas.php");
$xajax->setCharEncoding("ISO-8859-1");
$xajax->decodeUTF8InputOn();

function Grabar($data){
    global $conexion;
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	$usuario 	=	$_SESSION["alycar_usuario"];
	$seleccion 	= 	$data['seleccion'];
	$ingresa 	= 	'SI';
	
	if (count($seleccion) > 0){
		
		if ($ingresa == 'SI'){
			$total = count($seleccion);
			
			foreach ($data['seleccion'] as $ncorr) {
				$fecha		=	$data['fecha_vale_'.$ncorr];
				list($dia3,$mes3,$anio3) = explode('/', $fecha);$fecha = $anio3."-".$mes3."-".$dia3;
				$sigue="SI";

				$sql_001 = "select fecha from vales_pie_vendedor where vpv_ncorr  = '".$ncorr."' ";
				$res_001 = mysql_query($sql_001,$conexion) or die(mysql_error());
				$row_001 = mysql_fetch_array($res_001);
				$fecha_vpv = $row_001['fecha'];
				
				$sql_ab = "select DATEDIFF('".$fecha."','".$fecha_vpv."') as nro"; 
				$res_ab = mysql_query($sql_ab, $conexion);
				$row_ab = mysql_fetch_array($res_ab);
				$nro = $row_ab['nro'];
				if ( $nro > (30)){
					$objResponse->addScript("alert('Fecha superior a 30 dias a la fecha asignada.')");
					$sigue = 'NO';
					}
				$sql_ab = "select DATEDIFF('".$fecha."','".$fecha_vpv."') as nro"; 
				$res_ab = mysql_query($sql_ab, $conexion);
				$row_ab = mysql_fetch_array($res_ab);
				$nro = $row_ab['nro'];
				if ( $nro < 0){
					$objResponse->addScript("alert('La fecha ingresada no puede ser menor a la fecha de venta.')");
					$sigue = 'NO';
					}
				if($sigue=="SI"){
					$sql = "update vales_pie_vendedor set
								fecha   = 	'".$fecha."', 
								estado	 =	 'AUTORIZADO-FECHA'
								where vpv_ncorr  = 	'".$ncorr."' and 
									fecha <= '".$fecha."'";
					$res = mysql_query($sql, $conexion) or die(mysql_error());
					$affected = mysql_affected_rows();
					$objResponse->addScript("alert('Se ha confirmado correctamente.')");
					}
				else{
					$objResponse->addScript("No fue modificado");
					}
			}
			$objResponse->addScript("window.document.Form1.submit();");
		}
	}else{
		$objResponse->addScript("alert('Debe Seleccionar al Menos un Registro')");
	}
	return $objResponse->getXML();
}

function CargaListado($data){
	global $conexion;
	global $miSmarty;
	
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	$empresa 			= 	$data["OBLI-cboEmpresa"];
	$folio 				= 	$data["OBLI-txtFolio"];
	$total 				=	0;
	$objResponse->addScript("document.getElementById('divlistado').style.display='none';");
	
	// busca los registros
	$sql_ve = "select 
				`trabajador`, `fecha`, `monto`, `usuario`, `fecha_digitacion`, 
				`estado`, observacion, vpv_ncorr, folio
				
				from vales_pie_vendedor
				
				where
				estado = 'AUTORIZADO' 
				order by `vpv_ncorr`";
	
	$res_ve = mysql_query($sql_ve, $conexion);
	if (mysql_num_rows($res_ve) > 0){
		$arrRegistros	= 	array();
		$i = 1;
		while ($line_ve = mysql_fetch_row($res_ve)) {
			
			$sql_1 = "select concat(nombres,' ',apellido_pat,' ',apellido_mat) as nombres
						from sggeneral.trabajadores
						where rut = ".$line_ve[0];
			$res_1 = mysql_query($sql_1,$conexion) or die(mysql_error());
			$row_1 = mysql_fetch_array($res_1);
			
			$nombre_trabajador = $row_1['nombres'];
			
			array_push($arrRegistros, array("item"					=>	$i,
											"trabajador" 			=> 	$nombre_trabajador,
											"fecha"					=> 	$line_ve[1],
											"monto"					=> 	$line_ve[2],
											"usuario" 				=> 	$line_ve[3],
											"fecha_digitacion" 		=> 	$line_ve[4],
											"estado"				=> 	$line_ve[5],
											"observacion"			=> 	$line_ve[6],
											"ncorr"					=> 	$line_ve[7],
											"folio"					=> 	$line_ve[8]));
			$total += 	$line_ve[2]; 
			$i++;
			
		}
		
		$miSmarty->assign('arrRegistros', $arrRegistros);
		$miSmarty->assign('TOTAL_FOLIOS', $total);

		$objResponse->addAssign("divabonos", "innerHTML", $miSmarty->fetch('sg_autorizar_pies_vendedor_ventas_list.tpl'));
		
	}else{
		
		$objResponse->addAssign("divabonos", "innerHTML", "No Existen Registros");
	}
	
	$objResponse->addScript("document.getElementById('divlistado').style.display='block';");
	
	
	return $objResponse->getXML();
}

function LlamaVenta($data, $ncorr){
    global $conexion;
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	$objResponse->addScript("showPopWin('sg_ventas_revisar_preventas_informe_hv.php?folio=".$ncorr."', 'Revision', 800, 600, null);");
	
	return $objResponse->getXML();
}

$xajax->registerFunction("CargaListado");
$xajax->registerFunction("LlamaVenta");
$xajax->registerFunction("Grabar");

$xajax->processRequests();
$miSmarty->assign('xajax_js', $xajax->getJavascript());

$miSmarty->display('sg_autorizar_pies_vendedor_ventas.tpl');

?>

