<?php
session_set_cookie_params('18000'); // 5 HORAS
session_start();

require_once 'includes/xajax/xajax.inc.php'; //archivo de configuracion de ajax
include "../includes/php/conf_smarty.php";//archivo de configuracion de smarty
include "../includes/php/conf_bd.php"; //archivo de coneccion al servidor y base de datos
//include "../includes/php/conf_bd_antigua.php"; //archivo de coneccion al servidor de yonley
include "../includes/php/validaciones.php"; 

$xajax = new xajax();

$xajax->setRequestURI("sg_bodega_imp_guia.php");
$xajax->setCharEncoding("ISO-8859-1");
$xajax->decodeUTF8InputOn();

function Grabar($data){
	global $conexion;
	global $miSmarty;
	
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	$guia		= 	$data["OBLI-txtGuia"];
	
	$objResponse->addScript("document.getElementById('divlistado').style.display='none';");
	
	$sql = "select
				a.movim_ncorr as guia,
				b.tmov_desc as movimiento,
				DATE_FORMAT(a.movim_fecha,'%d/%m/%Y') as fecha,
				a.movim_obs as obs,
				DATE_FORMAT(a.movim_fecha_dig,'%d/%m/%Y %T') as fecha_dig,
				a.usu_id as usuario,
				a.movim_tipo as movim_tipo,
				a.pr_rut as proveedor,
				a.movim_numdoc as doc,
				a.vend_ncorr as vendedor,
				a.empe_rut as empresa,
				a.movim_folio
				
				from sgbodega.movim a, sgyonley.tipos_movim b
					
				where
				a.movim_ncorr = '".$guia."' and a.movim_tipo = b.tmov_ncorr";
	
	$res = mysql_query($sql, $conexion);
	
	if (mysql_num_rows($res) > 0){
		$arrRegistros	= 	array();
		$i = 1;
		while ($line = mysql_fetch_row($res)) {
			
			$movim_tipo 	= 	$line[6];
			$proveedor 		= 	$line[7];
			$doc 			= 	$line[8];
			$vendedor		=	$line[9];
			$empresa		=	$line[10];
			$folio			=	$line[11];
			
			
			$sql_empresa  = "select empe_desc from empresas where empe_rut = '".$empresa."'";
			$res_empresa = mysql_query($sql_empresa,$conexion);
			$empresa_nombre = @mysql_result($res_empresa, 0,'empe_desc');
			
			//$objResponse->addScript("alert('$i')");
			
			array_push($arrRegistros, array("item"			=>	$i,
											"guia" 			=> 	$line[0],
											"movimiento" 	=> 	$line[1],
											"fecha" 		=> 	$line[2],
											"obs" 			=> 	$line[3],
											"fecha_dig" 	=> 	$line[4],
											"usuario" 		=> 	$line[5],
											"empresa" 		=> 	$empresa_nombre));
		
			$i++;
		}
		
		// busca el detalle de productos
		$sql = "select mdet_ncorr, mdet_codigo, mdet_desc, mdet_nu, mdet_valor, mdet_cantidad, mdet_subneto, mdet_descuento, mdet_subtotal
				from sgbodega.movim_detalle
				where movim_ncorr = '".$guia."'";
				
		$res = mysql_query($sql, $conexion);
		
		if (mysql_num_rows($res) > 0){
				
			$arrRegistrosDet 		= 	array();
			
			$total_valor 		= 	0;
			$total_cantidad 	= 	0;
			$total_subneto 		= 	0;
			$total_descuento 	= 	0;
			$total_subtotal 	= 	0;
			
			while ($line = mysql_fetch_row($res)) {
				
				$total_valor 		= 	$total_valor + $line[4];
				$total_cantidad 	= 	$total_cantidad + $line[5];
				$total_subneto 		= 	$total_subneto + $line[6];
				$total_descuento 	= 	$total_descuento + $line[7];
				$total_subtotal 	= 	$total_subtotal + $line[8];
				
				array_push($arrRegistrosDet, array("ncorr" 		=> 	$line[0],
												"codigo" 		=> 	$line[1], 
												"descripcion" 	=> 	$line[2], 
												"nu" 			=> 	$line[3],
												"valor"			=> 	$line[4], 
												"cantidad"		=> 	$line[5],  
												"subneto"		=> 	$line[6],
												"descuento"		=> 	$line[7],
												"subtotal"		=> 	$line[8]));
				
			}
		}	
		
		//busca al proveedor
		if (($movim_tipo == 1) OR ($movim_tipo == 3)){
			$sql_bdet = "select pr_razon from sgbodega.proveedor where pr_rut = '".$proveedor."'";
			$res_bdet = mysql_query($sql_bdet, $conexion);
			$proveedor = @mysql_result($res_bdet, 0, "pr_razon");
		}
		
		//busca al vendedor
		if (($movim_tipo == 2) OR ($movim_tipo == 4) OR ($movim_tipo == 6)){
			$sql_bdet = "select ve_vendedor from sgbodega.vendedores where ve_codigo = '".$vendedor."' and ve_empresa = '".$empresa."'";
			$res_bdet = mysql_query($sql_bdet, $conexion);
			$vendedor = @mysql_result($res_bdet, 0, "ve_vendedor");
		}
		
		//busca al trabajador
		if ($movim_tipo == 9){
			$sql_trab = "select movim_trabajador from sgbodega.movim where movim_ncorr = '".$guia."'";
			$res_trab = mysql_query($sql_trab, $conexion);
			$trabajador = @mysql_result($res_trab, 0, "movim_trabajador");
		}

		
		$miSmarty->assign('movim', $movim_tipo);
		$miSmarty->assign('proveedor', $proveedor);
		$miSmarty->assign('vendedor', $vendedor);
		$miSmarty->assign('trabajador', $trabajador);
		//$miSmarty->assign('empresa', $empresa_nombre);
		$miSmarty->assign('doc', $doc);
		$miSmarty->assign('folio', $folio);
		$miSmarty->assign('arrRegistros', $arrRegistros);
		$miSmarty->assign('arrRegistrosDet', $arrRegistrosDet);
		
		$miSmarty->assign('TOTAL_VALOR', $total_valor);
		$miSmarty->assign('TOTAL_CANTIDAD', $total_cantidad);
		$miSmarty->assign('TOTAL_SUBNETO', $total_subneto);
		$miSmarty->assign('TOTAL_DESCUENTO', $total_descuento);
		$miSmarty->assign('TOTAL_SUBTOTAL', $total_subtotal);
		
		$objResponse->addAssign("divabonos", "innerHTML", $miSmarty->fetch('sg_bodega_imp_guia_list.tpl'));
		
	}else{
		
		$objResponse->addAssign("divabonos", "innerHTML", "No Existen Registros");
	}
	
	
	$objResponse->addScript("document.getElementById('divlistado').style.display='block';");
	
	
	return $objResponse->getXML();
}

function CargaPagina($data){
    global $conexion;
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	$guia		= 	$data["OBLI-txtGuia"];
	
	if ($guia != ''){
		$objResponse->addScript("xajax_Grabar(xajax.getFormValues('Form1'))");
	}
	
	$objResponse->addScript("document.getElementById('OBLI-txtGuia').focus();");
	
	return $objResponse->getXML();
}          
function Volver($data){
	global $conexion;
	global $miSmarty;
	
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	$pag_regreso = $_SESSION["alycar_pag_regreso"];
	
	$objResponse->addScript("document.location.href='$pag_regreso'");
	
	return $objResponse->getXML();
}
function LlamaElimina($data){
	global $conexion;
	
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	$ncorr = $data["OBLI-txtGuia"];
	$objResponse->addScript("showPopWin('sg_bodega_elimina_guia_motivo.php?ncorr=$ncorr', 'Confirmar Eliminación', 530, 230, null);");
	
	return $objResponse->getXML();
}

$xajax->registerFunction("CargaPagina");
$xajax->registerFunction("Grabar");
$xajax->registerFunction("Volver");
$xajax->registerFunction("LlamaElimina");

$xajax->processRequests();
$miSmarty->assign('xajax_js', $xajax->getJavascript());

$miSmarty->assign('GUIA', $_GET["guia"]);

$miSmarty->display('sg_bodega_imp_guia.tpl');

?>

