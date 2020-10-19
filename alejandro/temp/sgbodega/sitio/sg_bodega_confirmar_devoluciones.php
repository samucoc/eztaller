<?php
session_start();

require_once 'includes/xajax/xajax.inc.php'; //archivo de configuracion de ajax
include "../includes/php/conf_smarty.php";//archivo de configuracion de smarty
include "../includes/php/conf_bd.php"; //archivo de coneccion al servidor y base de datos
//include "../includes/php/conf_bd_antigua.php"; //archivo de coneccion al servidor de yonley
include "../includes/php/validaciones.php"; 

$xajax = new xajax();

$xajax->setRequestURI("sg_bodega_confirmar_devoluciones.php");
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
				
				$cadena_objeto 	= 	$ncorr.'cboNU';
				$nu 			= 	$data[$cadena_objeto];
				
				//busca el nu antiguo
				$sql_na = "select sv_nu from sgyonley.sub_guiadev where sv_ncorr = '".$ncorr."'";
				$res_na = mysql_query($sql_na, $conexion);
				$nu_antiguo = @mysql_result($res_na,0,"sv_nu");
				
				$sql = "update sgyonley.sub_guiadev set 
							sv_nu 			= 	'".$nu."', 
							sv_conf_bodega	=	'SI',
							sv_fecha_conf	=	'".date("Y-m-d h:i:s")."',
							sv_usuario_conf	=	'".$usuario."',
							sv_nu_ant		=	'".$nu_antiguo."',
							sv_nu_conf		=	'".$nu."'
							
							where sv_ncorr  = 	'".$ncorr."'";
				
				$res = mysql_query($sql, $conexion);
				
				//$objResponse->addAlert("$ncorr $nu_antiguo $nu $sql");
			}
			
			$objResponse->addScript("alert('Se Han Confirmado $total Registro(s).')");

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
	
	$empresa 			= 	$data["OBLI-cboEmpresa"];
	$folio 				= 	$data["OBLI-txtFolio"];
	
	$objResponse->addScript("document.getElementById('divlistado').style.display='none';");
	
	// busca los registros
	$sql_ve = "select 
				a.sv_fecha as fecha,
				a.sv_folio as folio,
				a.sv_guiadv as guia,
				a.sv_codbus as codigo,
				a.sv_glosa as descripcion,
				a.sv_nu as nu,
				a.sv_cantidad as cantidad,
				a.sv_ncorr as ncorr
				
				from sgyonley.sub_guiadev a, sgyonley.d_guiadev b
				
				where
				a.sv_conf_bodega = 'NO' and
				a.sv_guiadv = b.gd_guia and
				a.sv_folio = b.gd_folio and
				b.tdev_ncorr = '1'
				
				
				order by sv_ncorr asc";
	
	/*
	$sql_ve = "select 
				a.sv_fecha as fecha,
				a.sv_folio as folio,
				a.sv_guiadv as guia,
				a.sv_codbus as codigo,
				a.sv_glosa as descripcion,
				a.sv_nu as nu,
				a.sv_cantidad as cantidad,
				a.sv_ncorr as ncorr
				
				from sgyonley.sub_guiadev a, sgyonley.d_guiadev b
				
				where
				a.sv_fecha < '2012-01-01' and
				a.sv_conf_bodega = 'SI' and
				a.sv_usuario_conf = '' and
				a.sv_nu_ant = '' and
				a.sv_nu_conf = '' and
				a.sv_fecha_conf = '0000-00-00 00:00:00' and
				a.sv_guiadv = b.gd_guia and
				b.tdev_ncorr = '1'
				
				order by sv_ncorr asc";
	*/
	
	$res_ve = mysql_query($sql_ve, $conexion);
	if (mysql_num_rows($res_ve) > 0){
		$arrRegistros	= 	array();
		$i = 1;
		while ($line_ve = mysql_fetch_row($res_ve)) {
			
			/*
			// actualiza como confirmado en bodega los registros anteriores al a�o 2012
			// solicitado por Javier 22/08/2012
			$guia 	= $line_ve[2];
			$codbus = $line_ve[3];
			
			$sql_g = "delete from sgyonley.sub_guiadev where sv_guiadv = '".$guia."' and sv_codbus = '".$codbus."'";
			$res_g = mysql_query($sql_g, $conexion);
			*/
			
			//BUSCA EL USUAIO, LA FECHA DE DIGITACION DE LA GUIA Y EL TIPO DE DEVOLUCION
			// SOLO DEVOLUCIONES TIPO = 1 (AFECTA BODEGA)
			$guia = $line_ve[2];
			$sql_g = "select tdev_ncorr, gd_usuario, gd_fechadig from sgyonley.d_guiadev where gd_guia = '".$guia."' order by gd_ncorr desc limit 1";
			$res_g = mysql_query($sql_g, $conexion);
			$tdev_ncorr 	= 	@mysql_result($res_g,0,"tdev_ncorr");
			$usuario 		= 	@mysql_result($res_g,0,"gd_usuario");
			$fecha_dig 		= 	@mysql_result($res_g,0,"gd_fechadig");
			
			array_push($arrRegistros, array("item"				=>	$i,
											"fecha" 			=> 	$line_ve[0],
											"fecha_dig"			=> 	$fecha_dig,
											"usuario"			=> 	$usuario,
											"folio" 			=> 	$line_ve[1],
											"guia" 				=> 	$line_ve[2],
											"codigo"			=> 	$line_ve[3],
											"descripcion" 		=> 	$line_ve[4],
											"nu" 				=> 	$line_ve[5],
											"cantidad" 			=> 	$line_ve[6],
											"ncorr"				=> 	$line_ve[7]));

			$i++;
			
		}
		
		$sql_e = "select empe_desc from sgyonley.empresas where empe_rut = '".$empresa."'";
		$res_e = mysql_query($sql_e, $conexion);
		$nombre_empresa = @mysql_result($res_e, 0, "empe_desc");
		
		// asigno las sesiones para el ordenamiento
		$_SESSION["alycar_matriz"] 			= 	$arrRegistros;
		$_SESSION["alycar_empresa"] 		= 	$nombre_empresa;
		$_SESSION["alycar_folio"] 			= 	$folio;
		$_SESSION["alycar_total_folios"] 	= 	$i - 1;
		
		$miSmarty->assign('EMPRESA', $nombre_empresa);
		$miSmarty->assign('FOLIO', $folio);
		$miSmarty->assign('TOTAL_FOLIOS', $i - 1);
		
		$miSmarty->assign('arrRegistros', $arrRegistros);
		$objResponse->addAssign("divabonos", "innerHTML", $miSmarty->fetch('sg_bodega_confirmar_devoluciones_list.tpl'));
		
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

$miSmarty->display('sg_bodega_confirmar_devoluciones.tpl');

?>

