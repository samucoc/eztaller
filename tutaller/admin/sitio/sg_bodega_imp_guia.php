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
	$movim_bodega 		=	$_SESSION['alycar_sgyonley_bodega'];
	$movim_tipo 	= 	"";
	$proveedor 		= 	"";
	$doc 			= 	"";
	$vendedor		=	"";
	$empresa		=	"";
	$folio			=	"";
	$factura		=	"";
	$guia_despacho		=	"";
	$bodega			=	"";
	$oc			=	"";
			
	
	$objResponse->addScript("document.getElementById('divlistado').style.display='none';");
	
	$sql = "select
				a.movim_ncorr_ant as guia,
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
				a.movim_folio,
				a.movim_guia,
				d.nombre,
				a.patente as patente
				
				from sgcopec.movim a
					inner join sgyonley.tipos_movim b
						on a.movim_tipo = b.tmov_ncorr
					inner join sgbodega.bodegas d
						on a.movim_bodega = d.bodega_ncorr
				where
				a.movim_ncorr_ant = '".$guia."' and 
				a.movim_estado = 'FINALIZADO' 
	
				limit 0,1";
	
	$res = mysql_query($sql, $conexion);
	$guia_actual = "";
	//$objResponse->addAlert($sql);
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
			$guia_cp		=	$line[12];
			$factura		=	$line[13];
			$guia_despacho		=	$line[14];
			$bodega			=	$line[15];
			$oc			=	$line[16];
			$patente			=	$line[17];
			
				
			$sql_empresa  = "select empe_desc from sgyonley.empresas where empe_rut = '".$empresa."'";
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
		if ($movim_tipo == 9){
			$and = " and movim_conf_bodega=1 ";
			}
		$sql_ga = "select 
				a.movim_ncorr as guia_actual
				from sgcopec.movim a
				where
				a.movim_ncorr_ant = '".$guia."'
				
		";
		$res_ga = mysql_query($sql_ga,$conexion) or die(mysql_error());
		$guia_actual = "";
		while ($row_ga = mysql_fetch_array($res_ga)){
			$guia_actual .= ','.$row_ga['guia_actual'];
		}
		// busca el detalle de productos
		$sql = "select mdet_ncorr, mdet_codigo, mdet_desc, mdet_nu, mdet_valor, mdet_cantidad, mdet_subneto, mdet_descuento, mdet_subtotal
				from sgcopec.movim_detalle
				where movim_ncorr in (".substr($guia_actual,1).")
				$and";
					
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
			$proveedor = $proveedor.' - '.@mysql_result($res_bdet, 0, "pr_razon");
		}
		
		//busca al vendedor
		if (($movim_tipo == 2) OR ($movim_tipo == 4) OR ($movim_tipo == 6)){
			
			$sql = "SELECT *
			FROM `personas`
			WHERE pers_rut like '".$vendedor."'
			";
			$res = mysql_query($sql, $conexion);
			$row = mysql_fetch_assoc($res);
				
			$id_proveedor = utf8_encode($row['pers_ape_pat']);
			$name_proveedor = utf8_encode($row['pers_ape_mat']);
			$nombre_proveedor = utf8_encode($row['pers_nombre']);
				
			$vendedor = $vendedor.' - '.$nombre_proveedor.' '.$id_proveedor.' '.$name_proveedor;
		}
		
		//busca al trabajador
		$trabajador="";
		if (($movim_tipo == '9')||($movim_tipo == '10')){
			echo $sql_trab = "select tra_nombre 
						from yonleycp.trabajadores 
						where tra_ncorr in (select tra_ncorr
										from yonleycp.cuentas
										where cue_ncorr = '".$guia_cp."')";
			$res_trab = mysql_query($sql_trab, $conexion) or die(mysql_error());
			$row_trab = mysql_fetch_array($res_trab);
			$trabajador = $row_trab['tra_nombre'];
			}

		
		$miSmarty->assign('movim', $movim_tipo);
		$miSmarty->assign('proveedor', $proveedor);
		$miSmarty->assign('vendedor', $vendedor);
		$miSmarty->assign('patente', $patente);
		$miSmarty->assign('trabajador', $trabajador);
		$miSmarty->assign('empresa', $empresa_nombre);
		$miSmarty->assign('doc', $doc);
		$miSmarty->assign('folio', $folio);
		$miSmarty->assign('factura', $factura);
		$miSmarty->assign('oc', $oc);
		$miSmarty->assign('bodega', $bodega);
		$miSmarty->assign('guia_despacho', $guia_despacho);
		$miSmarty->assign('guia_despacho', $guia_despacho);
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
	$objResponse->addScript("showPopWin('sg_bodega_elimina_guia_motivo.php?ncorr=$ncorr', 'Confirmar Eliminaci�n', 530, 230, null);");
	
	return $objResponse->getXML();
}

$xajax->registerFunction("CargaPagina");
$xajax->registerFunction("Grabar");
$xajax->registerFunction("Volver");
$xajax->registerFunction("LlamaElimina");

$xajax->processRequests();
$miSmarty->assign('xajax_js', $xajax->getJavascript());

if (isset($_GET["guia"]))
$miSmarty->assign('GUIA', $_GET["guia"]);

$miSmarty->display('sg_bodega_imp_guia.tpl');

?>

