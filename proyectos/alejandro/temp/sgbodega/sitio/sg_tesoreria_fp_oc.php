<?php	
session_start();

require_once 'includes/xajax/xajax.inc.php'; //archivo de configuracion de ajax
include "../includes/php/conf_smarty.php";//archivo de configuracion de smarty
include "../includes/php/conf_bd.php"; //archivo de coneccion al servidor y base de datos
//include "../includes/php/conf_bd_antigua.php"; //archivo de coneccion al servidor de yonley
//include "../includes/php/sgbodega.php"; 
include "../includes/php/validaciones.php"; 

$xajax = new xajax();

$xajax->setRequestURI("sg_tesoreria_fp_oc.php");
$xajax->setCharEncoding("ISO-8859-1");
$xajax->decodeUTF8InputOn();

function Grabar($data){
	global $conexion;
	
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	$monto_total 		= $data['monto_total'];
	$neto 				= $data['neto'];
	$iva 				= $data['iva'];
	$nro_oc				= $data['nro_oc'];
	$forma_pago			= $data['forma_pago_h'];
	
	$cant_arr = explode(',',$data['arr_cant']);
	$tot_monto = 0;
	for($i=0;$i<count($cant_arr);$i++){
		$tot_monto = $tot_monto + $cant_arr[$i];
		}
	if ($tot_monto == $monto_total){
		if ($forma_pago == '2'){
			$arr_repuesto 		= explode(',',$data['arr_repuesto']);
			$arr_nom_repuesto 	= explode(',',$data['arr_nom_repuesto']);
			$arr_cant 			= explode(',',$data['arr_cant']);
			$arr_banco 			= explode(',',$data['arr_banco']);
			$arr_nro_cuenta		= explode(',',$data['arr_nro_cuenta']);
			$id = $nro_oc;
			
			$sql_busca = "select nro_cuotas
							from sgcompras.ordenes_compras
							where orden_compra_ncorr = '".$id."'";
			$res_busca = mysql_query($sql_busca,$conexion) or die(mysql_error());
			$row_busca = mysql_fetch_array($res_busca);
			
			$nro_cuotas = $row_busca['nro_cuotas'];
			
			if (($nro_cuotas == count($arr_repuesto))){
				$sql_3 = "delete from sgcompras.oc_tiene_cheques where orden_compra_ncorr = '".$nro_oc."'";
				$res_3 = mysql_query($sql_3,$conexion);
				for($i=0; $i< count($arr_repuesto); $i++){
					
					list($dia1,$mes1,$anio1) = explode('/', $arr_nom_repuesto[$i]);	
					$fecha	= $anio1."-".$mes1."-".$dia1;
					
					$sql_2 = "
						INSERT INTO sgcompras.oc_tiene_cheques(`orden_compra_ncorr`, `nro_cheque`, `fecha`, `valor`, `banco`, `nro_cuenta`)  
						values ('".$id."', '".$arr_repuesto[$i]."', '".$fecha."', '".$arr_cant[$i]."', '".$arr_banco[$i]."', '".$arr_nro_cuenta[$i]."')"	;
					$res_2 = mysql_query($sql_2,$conexion) or die(mysql_error());
					}
				$sql_1 = "update sgcompras.ordenes_compras
						set monto_total = '$monto_total', 
							neto		= '$neto', 
							iva 		= '$iva',
							forma_pago  = '$forma_pago',
							estado		= 'AUTORIZADO-FP'
					where orden_compra_ncorr = '".$nro_oc."'";
				$res_1 = mysql_query($sql_1,$conexion) or die(mysql_error());
				$objResponse->addScript("alert('Registro Grabado Correctamente.')");
				$objResponse->addScript("document.Form1.submit();");
				}
			else{
				$objResponse->addAlert("Nro de documentos no cuadra con la cantidad de cheques.");
				}
			}
		if ($forma_pago == '3'){
			$banco 	= $data['banco_tc'];
			$tipo	= $data['tipo_tc'];
			$cuotas	= $data['cuotas_tc'];
			
				$sql_3 = "delete from sgcompras.oc_tiene_tc where oc_ncorr = '".$nro_oc."'";
				$res_3 = mysql_query($sql_3,$conexion);
				
				$sql_2 = "
					INSERT INTO sgcompras.oc_tiene_tc(`oc_ncorr`, `banco`, `tipo_tarj_cred`, `cuotas`) 
					values ('".$id."', '".$banco."', '".$tipo."', '".$cuotas."')"	;
				$res_2 = mysql_query($sql_2,$conexion) or die(mysql_error());
				$sql_1 = "update sgcompras.ordenes_compras
						set monto_total = '$monto_total', 
							neto		= '$neto', 
							iva 		= '$iva',
							forma_pago  = '$forma_pago',
							estado		= 'AUTORIZADO-FP'
					where orden_compra_ncorr = '".$nro_oc."'";
				$res_1 = mysql_query($sql_1,$conexion) or die(mysql_error());
			$objResponse->addScript("alert('Registro Grabado Correctamente.')");
			$objResponse->addScript("document.Form1.submit();");
			}
		if ($forma_pago == '4'){
			$banco 	= $data['banco_tr'];
			$nro	= $data['nro_tr'];
			
				$sql_3 = "delete from sgcompras.oc_tiene_transferencias where oc_ncorr = '".$nro_oc."'";
				$res_3 = mysql_query($sql_3,$conexion);
				
				$sql_2 = "
					INSERT INTO sgcompras.oc_tiene_transferencias(`oc_ncorr`, `banco`, `nro_transferencia` ) 
					values ('".$id."', '".$banco."', '".$nro."')"	;
				$res_2 = mysql_query($sql_2,$conexion) or die(mysql_error());
				$sql_1 = "update sgcompras.ordenes_compras
						set monto_total = '$monto_total', 
							neto		= '$neto', 
							iva 		= '$iva',
							forma_pago  = '$forma_pago',
							estado		= 'AUTORIZADO-FP'
					where orden_compra_ncorr = '".$nro_oc."'";
				$res_1 = mysql_query($sql_1,$conexion) or die(mysql_error());
			$objResponse->addScript("alert('Registro Grabado Correctamente.')");
			$objResponse->addScript("document.Form1.submit();");
			}
				
		}
	else{
		$objResponse->addScript("alert('Total de montos de los cheques no cuadra con el monto total.')");
		}
	return $objResponse->getXML();
	}

function Imprimir($data,$id){
	global $conexion;
	
    $objResponse = new xajaxResponse('ISO-8859-1');
	$oc_ncorr = $id;
	$objResponse->addScript("showPopWin('sg_orden_compra_imprime.php?oc_ncorr=$oc_ncorr', 'Imprime Orden Compra', 800, 600, null);");
	$objResponse->addScript("document.getElementById('btnGrabar').style.display='none';");
	return $objResponse->getXML();
	}

function CargaPagina($data){
	global $conexion;
	global $miSmarty;
	
    $objResponse = new xajaxResponse('ISO-8859-1');
	$sql_ab = "select *
                    from sgcompras. ordenes_compras
                    where estado in ('AUTORIZADO')
                    ";
    $res_ab = mysql_query($sql_ab, $conexion) or die(mysql_error());
	if (mysql_num_rows($res_ab) > 0){
		$arrRegistros	= 	array();
		$i = 1;
                while ($line_ab_1 = mysql_fetch_array($res_ab)){
                    
					$sql = "SELECT * 
							FROM sgbodega.proveedor
								WHERE PR_NCORR = '".$line_ab_1['proveedor']."'";
					$res = mysql_query($sql, $conexion);
					$row = mysql_fetch_array($res);
					$proveedor = $row['PR_RAZON'];
                    array_push($arrRegistros, array("item"	=>	$i,
                                                    "nro_oc"    => 	$line_ab_1['orden_compra_ncorr'],
                                                    "proveedor" => 	$proveedor,
						    'monto'	=>  $line_ab_1['monto_total']));
                    $i++;
                    
                    } 
		$miSmarty->assign('arrRegistros', $arrRegistros);
		$objResponse->addAssign("divabonos", "innerHTML", $miSmarty->fetch('sg_tesoreria_fp_oc_list.tpl'));
		
	}else{
		
		$objResponse->addAssign("divabonos", "innerHTML", "No Existen Registros");
	}
	
	$objResponse->addScript("document.getElementById('divlistado').style.display='block';");
	
	
	return $objResponse->getXML();
	}
function CargaDesc($data, $tabla, $campo1, $campo2, $objeto1, $objeto2, $c_and){
    global $conexion;
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	$ncorr 		= 	$data["$objeto1"];
	
	if ($tabla == 'sgbodega.tallas'){
		$sql = "select ta_ncorr, ta_descripcion, ta_busqueda, ta_venta, ta_venta2 from sgbodega.tallasnew where $campo1 = '".$ncorr."'";
		$res = mysql_query($sql, $conexion);
		
		$nu		=	$data["cboNU"];
		
		$objResponse->addAssign("txtDescProducto", "value", @mysql_result($res,0,"ta_busqueda")." ".@mysql_result($res,0,"ta_descripcion"));
		
	}else{
		$sql = "select $campo2 as descripcion from $tabla where $campo1 = '".$ncorr."' $and";
		$res = mysql_query($sql, $conexion);
		$objResponse->addAssign("$objeto2", "value", @mysql_result($res,0,"descripcion"));
	}	
	
	return $objResponse->getXML();
	}
	
	function CargaSelect($data, $select, $tabla, $codigo, $descripcion, $campo1, $campo2, $opt){
		global $conexion;
		$objResponse = new xajaxResponse('ISO-8859-1');
		
		$objResponse->addAssign("$select","innerHTML",""); 		
		
			$sql = "select $campo1 as codigo, $campo2 as descripcion from $tabla $opt";
		$res = mysql_query($sql, $conexion);
		
			
		if (@mysql_num_rows($res) > 0) {
			$j = 0;
					while ($line = mysql_fetch_array($res)) {
				$objResponse->addCreate("$select","option",""); 		
				$objResponse->addAssign("$select","options[".$j."].value", $line[0]);
				$objResponse->addAssign("$select","options[".$j."].text", $line[1]); 	
				$j++;
			}
		}
		
		return $objResponse->getXML();
	}

function LlamaMantenedorVxC($data){
	global $conexion;
	
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	$_SESSION["alycar_volver"]			=	'si';
	$_SESSION["alycar_pagina_volver"]	=   'sg_tesoreria_fp_oc.php';
	
    $objResponse->addScript("document.location.href='sg_mant_tablas.php?tbl=proveedores'");
	 
	return $objResponse->getXML();
}
function Nuevo($data){
    global $conexion;
    $objResponse = new xajaxResponse('ISO-8859-1');

	if (isset($_SESSION["alycar_orden_compra_id"])){
		$sql_1 = "delete from sgcompras.ordenes_compras
					where orden_compra_ncorr = '".$_SESSION["alycar_orden_compra_id"]."'";
		$res_1 = mysql_query($sql_1,$conexion) or die(mysql_error());
		}
	unset($_SESSION["alycar_orden_compra_id"]);
		
	$objResponse->addScript("window.document.Form1.submit();");
	
	return $objResponse->getXML();
}

function Buscar($data,$id){
    global $conexion;
    $objResponse = new xajaxResponse('ISO-8859-1');

	$nro_oc	= $id;

	$sql_busca = "select monto_total , neto, iva ,forma_pago, documento, proveedor
					from sgcompras.ordenes_compras
					where orden_compra_ncorr = '".$nro_oc."'";
	$res_busca = mysql_query($sql_busca,$conexion);
	$row_busca = mysql_fetch_array($res_busca);
	
	$sql = "SELECT * 
			FROM sgbodega.proveedor
				WHERE PR_NCORR = '".$row_busca['proveedor']."'";
	$res = mysql_query($sql, $conexion);
	$row = mysql_fetch_array($res);

	$objResponse->addAssign("nro_oc", "value", $id);
	$objResponse->addAssign("txtnro_oc", "innerHTML", $id);
	$objResponse->addAssign("monto_total", "value", $row_busca['monto_total']);
	$objResponse->addAssign("neto", "value", $row_busca['neto']);
	$objResponse->addAssign("iva", "value", $row_busca['iva']);
	$objResponse->addAssign('proveedor','innerHTML',$row['PR_RAZON']);
	
	$forma_pago = $row_busca['forma_pago'];
	
	if ($forma_pago==1){
		$objResponse->addAssign('forma_pago','innerHTML','Efectivo');
		$objResponse->addAssign('forma_pago_h','value','1');
		$objResponse->addScript("document.getElementById('2').style.display='none';");
		$objResponse->addScript("document.getElementById('4').style.display='none';");
		$objResponse->addScript("document.getElementById('3').style.display='none';");
		}
	elseif ($forma_pago==2){
		$objResponse->addAssign('forma_pago','innerHTML','Cheque');
		$objResponse->addAssign('forma_pago_h','value','2');
		$objResponse->addScript("document.getElementById('2').style.display='table-row';");
		$objResponse->addScript("document.getElementById('4').style.display='none';");
		$objResponse->addScript("document.getElementById('3').style.display='none';");
		}
	elseif ($forma_pago==3){
		$objResponse->addAssign('forma_pago','innerHTML','Tarjeta de Credito');
		$objResponse->addAssign('forma_pago_h','value','3');
		$objResponse->addScript("document.getElementById('3').style.display='table-row';");
		$objResponse->addScript("document.getElementById('2').style.display='none';");
		$objResponse->addScript("document.getElementById('4').style.display='none';");
		}
	elseif ($forma_pago==4){
		$objResponse->addAssign('forma_pago','innerHTML','Transferencia');
		$objResponse->addAssign('forma_pago_h','value','4');
		$objResponse->addScript("document.getElementById('4').style.display='table-row';");
		$objResponse->addScript("document.getElementById('3').style.display='none';");
		$objResponse->addScript("document.getElementById('2').style.display='none';");
		}
	elseif ($forma_pago==5){
		$objResponse->addAssign('forma_pago','innerHTML','Pago Pendiente');
		$objResponse->addAssign('forma_pago_h','value','5');
		}
	
	
	return $objResponse->getXML();
}
function BuscarOc($data,$id){
	global $conexion;
	
    $objResponse = new xajaxResponse('ISO-8859-1');
	$oc_ncorr = $id;
	$objResponse->addScript("showPopWin('sg_orden_compra_imprime.php?oc_ncorr=$oc_ncorr', 'Imprime Orden Compra', 900, 650, null);");
	//$objResponse->addScript("document.getElementById('btnGrabar').style.display='none';");
	return $objResponse->getXML();
	}

function CargaCtasCtes($data){
    global $conexion;
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	$select 		= 	"nro_cuenta_cheque";
	$banc_ncorr 	=	$data["banco_cheque"];
	
	$objResponse->addAssign("$select","innerHTML",""); 		
	$sql = "select CaId, CaNumero from sgbanco.cuentas where banc_ncorr = '".$banc_ncorr."'";
	$res = mysql_query($sql, $conexion) or die(mysql_error());
	
	if (mysql_num_rows($res) > 0) {
		$j = 0;
		while ($line = mysql_fetch_array($res)) {
			$objResponse->addCreate("$select","option",""); 		
			$objResponse->addAssign("$select","options[".$j."].value", $line[0]);
			$objResponse->addAssign("$select","options[".$j."].text", $line[1]); 	
			$j++;
		}
	}
	
	return $objResponse->getXML();
}

$xajax->registerFunction("Grabar");
$xajax->registerFunction("Buscar");
$xajax->registerFunction("BuscarOc");
$xajax->registerFunction("Nuevo");
$xajax->registerFunction("Imprimir");
$xajax->registerFunction("CargaDesc");
$xajax->registerFunction("CargaSelect");
$xajax->registerFunction("CargaPagina");
$xajax->registerFunction("CargaCtasCtes");
$xajax->registerFunction("LlamaMantenedorVxC");

$xajax->processRequests();
$miSmarty->assign('xajax_js', $xajax->getJavascript());

$miSmarty->display('sg_tesoreria_fp_oc.tpl');

?>

