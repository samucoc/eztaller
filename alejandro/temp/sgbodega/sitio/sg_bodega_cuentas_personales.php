<?php
session_start();

require_once 'includes/xajax/xajax.inc.php'; //archivo de configuracion de ajax
include "../includes/php/conf_smarty.php";//archivo de configuracion de smarty
include "../includes/php/conf_bd.php"; //archivo de coneccion al servidor y base de datos
//include "../includes/php/conf_bd_antigua.php"; //archivo de coneccion al servidor de yonley
include "../includes/php/validaciones.php"; 

$xajax = new xajax();

$xajax->setRequestURI("sg_bodega_cuentas_personales.php");
$xajax->setCharEncoding("ISO-8859-1");
$xajax->decodeUTF8InputOn();

function Grabar($data, $ncorr){
    global $conexion;
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	$seleccion 	= 	$data['seleccion'];
	$ingresa 	= 	'SI';
		
		if ($ingresa == 'SI'){
				
			$sql = "update sgcompras.movim_detalle set 
								movim_conf_bodega	=	'1'
								
								where mdet_ncorr  = 	'".$ncorr."'";
			$res = mysql_query($sql, $conexion);
				
				//$objResponse->addScript("alert('$ncorr $nu_antiguo $nu')");
			
			$objResponse->addScript("alert('Registro Confirmado.')");

			$sql = "select movim_ncorr
						from sgcompras.movim_detalle
					where mdet_ncorr  = 	'".$ncorr."'";
			$res = mysql_query($sql, $conexion);
			
			$row = mysql_fetch_array($res);
			$ncorr = $row['movim_ncorr'];
			
			//INICIALIZA EL FORMULARIO
			//$objResponse->addScript("location.href='sg_bodega_imp_guia.php?guia=$ncorr'");
			
		}
	return $objResponse->getXML();
}

function CargaListado($data){
	global $conexion;
	global $miSmarty;
	
    	$objResponse = new xajaxResponse('ISO-8859-1');
	
	$empresa 			= 	$data["OBLI-cboEmpresa"];
	$folio 				= 	$data["OBLI-txtFolio"];
	$movim_bodega 		=	$_SESSION['alycar_sgyonley_bodega'];
	if ($movim_bodega==1){
		$mdet_nu = 'N';
		}
	elseif ($movim_bodega==2){
		$mdet_nu = 'U';
		}
	$objResponse->addScript("document.getElementById('divlistado').style.display='none';");
	
	// busca los registros
	$sql_ve = "select 
				movim_tipo,movim_guia,movim_fecha,movim_obs,usu_id,movim_estado,movim_fecha_dig,
				mdet_codigo,mdet_desc,mdet_cantidad,mdet_valor,mdet_ncorr
				
				from sgcompras.movim
					inner join sgcompras.movim_detalle
						on sgcompras.movim.movim_ncorr = sgcompras.movim_detalle.movim_ncorr
				
				where
				sgcompras.movim_detalle.movim_conf_bodega = '0' and
				sgcompras.movim.movim_tipo = '9' and
				sgcompras.movim.movim_estado = 'FINALIZADO' and 
				sgcompras.movim.movim_bodega = '".$movim_bodega."'
						
				
				order by sgcompras.movim.movim_ncorr asc";
	
	$res_ve = mysql_query($sql_ve, $conexion);
	if (mysql_num_rows($res_ve) > 0){
		$arrRegistros	= 	array();
		$i = 1;
		while ($line_ve = mysql_fetch_array($res_ve)) {
			
			array_push($arrRegistros, array("item"				=>	$i,
											"fecha" 			=> 	$line_ve['movim_fecha'],
											"fecha_dig"			=> 	$line_ve['movim_fecha_dig'],
											"usuario"			=> 	$line_ve['usu_id'],
											"guia" 				=> 	$line_ve['movim_guia'],
											"codigo"			=> 	$line_ve['mdet_codigo'],
											"descripcion" 		=> 	$line_ve['mdet_desc'],
											"cantidad" 			=> 	$line_ve['mdet_cantidad'],
											"mdet_ncorr" 		=> 	$line_ve['mdet_ncorr']));

			$i++;
			
		}
		
		$miSmarty->assign('arrRegistros', $arrRegistros);
		$objResponse->addAssign("divabonos", "innerHTML", $miSmarty->fetch('sg_bodega_cuentas_personales_list.tpl'));
		
	}else{
		
		$objResponse->addAssign("divabonos", "innerHTML", "No Existen Registros");
	}
	
	$objResponse->addScript("document.getElementById('divlistado').style.display='block';");
	
	return $objResponse->getXML();
}

$xajax->registerFunction("Grabar");
$xajax->registerFunction("CargaListado");

$xajax->processRequests();
$miSmarty->assign('xajax_js', $xajax->getJavascript());

$miSmarty->display('sg_bodega_cuentas_personales.tpl');

?>

