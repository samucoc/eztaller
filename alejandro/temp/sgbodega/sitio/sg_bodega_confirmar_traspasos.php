<?php
session_start();

require_once 'includes/xajax/xajax.inc.php'; //archivo de configuracion de ajax
include "../includes/php/conf_smarty.php";//archivo de configuracion de smarty
include "../includes/php/conf_bd.php"; //archivo de coneccion al servidor y base de datos
//include "../includes/php/conf_bd_antigua.php"; //archivo de coneccion al servidor de yonley
include "../includes/php/validaciones.php"; 

$xajax = new xajax();

$xajax->setRequestURI("sg_bodega_confirmar_traspasos.php");
$xajax->setCharEncoding("ISO-8859-1");
$xajax->decodeUTF8InputOn();

function Grabar($data){
    global $conexion;
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	$usuario 	=	$_SESSION["alycar_usuario"];
	$seleccion 	= 	$data['seleccion'];
	$ingresa 	= 	'SI';
	
	if (count($seleccion) > 0){
		
		// valido la fecha de la dv
		if ($ingresa == 'SI'){
			//if ($tdev_ncorr	 == 1){
			$movim_fecha = date("d/m/Y");
			$total_1 = count($seleccion);
			
			foreach ($data['seleccion'] as $ncorr) {

				$sql = "update sgcompras.movim_detalle set 
							mdet_conf_tras	= 	'1'
							where mdet_ncorr  = '".$ncorr."'";
				
				$res = mysql_query($sql, $conexion);

				$sql_1 = "select count(movim_ncorr) as nc
						from sgcompras.movim_detalle
						where movim_ncorr in (select movim_ncorr
								  from sgcompras.movim_detalle
								  where mdet_ncorr  = '".$ncorr."')";
				$res_1 = mysql_query($sql_1,$conexion) or die(mysql_error());
				$row_1 = mysql_fetch_array($res_1);
				
				$total = $row_1['nc'];
				
				$sql_1 = "select count(movim_ncorr) as mc
						from sgcompras.movim_detalle
						where movim_ncorr in (select movim_ncorr
								  from sgcompras.movim_detalle
								  where mdet_ncorr  = '".$ncorr."')
							and mdet_conf_tras	= 	'1'";
				$res_1 = mysql_query($sql_1,$conexion) or die(mysql_error());
				$row_1 = mysql_fetch_array($res_1);
				
				$resto = $row_1['mc'];
				
				$total = $total-$resto;
				if ($total==0){
					$sql = "update sgcompras.movim set 
						movim_estado	= 	'FINALIZADO',
						movim_ncorr_ant	= 	movim_ncorr
						where movim_ncorr in (select movim_ncorr
								  from sgcompras.movim_detalle
								  where mdet_ncorr  = '".$ncorr."')";
					
					$res = mysql_query($sql, $conexion);
					}
				//$objResponse->addScript("alert('$ncorr $nu_antiguo $nu')");
			}
			
			$objResponse->addScript("alert('Se Han Confirmado $total_1 Registro(s).')");

			//INICIALIZA EL FORMULARIO
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
	
	$objResponse->addScript("document.getElementById('divlistado').style.display='none';");
	$movim_bodega 		=	$_SESSION['alycar_sgyonley_bodega'];

	// busca los registros
	$sql_ve = "select 
				sgcompras.movim.movim_fecha,
				sgcompras.movim_detalle.mdet_codigo,
				sgcompras.movim_detalle.mdet_desc,
				sgcompras.movim_detalle.mdet_cantidad,
				sgcompras.movim.usu_id,
				sgcompras.movim.movim_fecha_dig,
				sgcompras.movim_detalle.mdet_ncorr,
				sgcompras.movim.movim_bodega_tras
				
				from sgcompras.movim
					inner join sgcompras.movim_detalle
						on sgcompras.movim.movim_ncorr = sgcompras.movim_detalle.movim_ncorr
				
				where
				sgcompras.movim_detalle.mdet_conf_tras = '0' and
				sgcompras.movim.movim_bodega = '$movim_bodega' and
				sgcompras.movim.movim_tipo = '8'";
	
	$res_ve = mysql_query($sql_ve, $conexion);
	if (mysql_num_rows($res_ve) > 0){
		$arrRegistros	= 	array();
		$i = 1;
		while ($line_ve = mysql_fetch_array($res_ve)) {
			$sql_bo = "select * 
						from sgbodega.bodegas
						where sgbodega.bodegas.bodega_ncorr = '".$line_ve[7]."'";
			$res_bo = mysql_query($sql_bo,$conexion) or die(mysql_error());
			$row_bo = mysql_fetch_array($res_bo);
			$bod_origen = $row_bo['nombre'];
			array_push($arrRegistros, array("item"				=>	$i,
											"fecha" 			=> 	$line_ve[0],
											"codigo"			=> 	$line_ve[1],
											"descripcion" 		=> 	$line_ve[2],
											"cantidad" 			=> 	$line_ve[3],
											"bod_origen"		=> 	$bod_origen,
											"usuario"			=> 	$line_ve[4],
											"fecha_dig"			=> 	$line_ve[5],
											"ncorr"				=>	$line_ve[6]));

			$i++;
			
		}
		
		$miSmarty->assign('arrRegistros', $arrRegistros);
		$objResponse->addAssign("divabonos", "innerHTML", $miSmarty->fetch('sg_bodega_confirmar_traspasos_list.tpl'));
		
	}else{
		
		$objResponse->addAssign("divabonos", "innerHTML", "No Existen Registros");
	}
	
	$objResponse->addScript("document.getElementById('divlistado').style.display='block';");
	
	
	return $objResponse->getXML();
}

$xajax->registerFunction("CargaListado");
$xajax->registerFunction("Grabar");

$xajax->processRequests();
$miSmarty->assign('xajax_js', $xajax->getJavascript());

$miSmarty->display('sg_bodega_confirmar_traspasos.tpl');

?>

