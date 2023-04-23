<?php
session_set_cookie_params('18000'); // 5 HORAS
session_start();

/* EL CODIGO DEL PRODUCTO SE ARMARÁ POR:
- COD. MARCA
- COD. FAMILIA
- COD. SUBFAMILIA
- COD. CLASIFICACION
- COD. TRAMO
- COD. ARTICULO
*/

require_once 'includes/xajax/xajax.inc.php'; //archivo de configuracion de ajax
include "../includes/php/conf_smarty.php";//archivo de configuracion de smarty
include "../includes/php/conf_bd.php"; //archivo de coneccion al servidor y base de datos
//include "../includes/php/conf_bd_antigua.php"; //archivo de coneccion al servidor de yonley
include "../includes/php/validaciones.php"; 

$xajax = new xajax();

$xajax->setRequestURI("sg_bodega_traspaso.php");
$xajax->setCharEncoding("ISO-8859-1");
$xajax->decodeUTF8InputOn();

function Grabar($data){
	global $conexion;
	
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	$movim_bodega_tras	=	$_SESSION['alycar_sgyonley_bodega'];
	$movim_tipo			=	8;
	$empe_rut			=	"";
	$movim_fecha		=	$data["OBLItxtFecha"];
	$movim_bodega		=	$data["OBLIcboBodega"];
	$pr_rut				=	"";
	$tdoc_ncorr			=	"";
	$movim_numdoc		=	"";
	$movim_obs			=	trim($data["txtObservacion"]);
	$usu_id				=	$_SESSION["alycar_usuario"];
	$mdet_codigo		=	$data["OBLItxtCodProducto"];
	$mdet_desc			=	$data["OBLItxtDescProducto"];
	$mdet_nu			=	"";
	$mdet_valor			=	"";
	$mdet_cantidad		=	$data["OBLItxtCant"];
	$mdet_subneto		=	"";
	$mdet_descuento		=	"";
	$mdet_subtotal		=	"";
	
	list($dia1,$mes1,$anio1) = explode('/', $movim_fecha);$movim_fecha = $anio1."-".$mes1."-".$dia1;
	
	$ingresa = 'SI';
	
	if ($mdet_cantidad < 1){
		$objResponse->addScript("alert('Cantidad Incorrecta')");
		$ingresa = 'NO';
	}
	
	if ($ingresa == 'SI'){
		
		if (!isset($_SESSION["alycar_sgyonley_traspaso"])){
			$sql = "insert into sgcompras.movim (movim_bodega,movim_bodega_tras,movim_tipo,empe_rut,movim_fecha,pr_rut,tdoc_ncorr,movim_numdoc,movim_obs,usu_id)
					values (
					'".$movim_bodega."','".$movim_bodega_tras."','".$movim_tipo."','".$empe_rut."','".$movim_fecha."','".$pr_rut."','".$tdoc_ncorr."','".$movim_numdoc."',
					'".$movim_obs."','".$usu_id."')";
			
			$res = mysql_query($sql, $conexion) or die(mysql_error());
			$ncorr = mysql_insert_id($conexion);
			
			$_SESSION["alycar_sgyonley_traspaso"] = $ncorr;
		}
		
		// ingresa el articulo
		$movim_ncorr		=	$_SESSION["alycar_sgyonley_traspaso"];
		
		$sql_det = "insert into sgcompras.movim_detalle (movim_ncorr,mdet_codigo,mdet_desc,mdet_nu,mdet_valor,mdet_cantidad,
					mdet_subneto,mdet_descuento,mdet_subtotal) 
					values ('".$movim_ncorr."','".$mdet_codigo."','".$mdet_desc."','".$mdet_nu."','".$mdet_valor."','".$mdet_cantidad."',
					'".$mdet_subneto."','".$mdet_descuento."','".$mdet_subtotal."')";
					
		$res_det = mysql_query($sql_det, $conexion) or die(mysql_error());
		
		$objResponse->addScript("xajax_CargaListado(xajax.getFormValues('Form1'))");
		
		$objResponse->addAssign("OBLItxtCodProducto", "value", '');
		$objResponse->addAssign("OBLItxtDescProducto", "value", '');
		$objResponse->addAssign("OBLItxtCant", "value", '');
		
		$objResponse->addScript("document.getElementById('OBLItxtCodProducto').focus();");
	
	}
			
	return $objResponse->getXML();
}
function ConfirmaIngreso($data){
	global $conexion;
	
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	$movim_fecha		=	$data["OBLItxtFecha"];
	$pr_rut				=	"";
	$proveedor			=	"";
	$tdoc_ncorr			=	"";
	$movim_numdoc		=	"";
	$movim_obs			=	trim($data["txtObservacion"]);
	
	$ingresa = 'SI';
	
	if ($ingresa == 'SI'){
		if ($movim_fecha == ''){
			$objResponse->addScript("alert('Fecha Incorrecta')");
			$ingresa = 'NO';
		}
	}
	if ($ingresa == 'SI'){
		if (!isset($_SESSION["alycar_sgyonley_traspaso"])){
			$objResponse->addScript("alert('No Se Han Ingresado Productos al Listado')");
			$ingresa = 'NO';
		}
	}
	
	// valido la fecha del movim
	if ($ingresa == 'SI'){
		list($dia1,$mes1,$anio1) = explode('/', $movim_fecha);$movim_fecha = $anio1."-".$mes1."-".$dia1;
		
		$movim_ncorr =	$_SESSION["alycar_sgyonley_traspaso"];
		
		$sql = "update sgcompras.movim set 
				movim_fecha_dig	=	'".date("Y-m-d h:i:s")."'
				where
				movim_ncorr = '".$movim_ncorr."'";
		
		$res = mysql_query($sql, $conexion);
		
		
		
		$objResponse->addScript("alert('Traspaso Ingresado Correctamente, El Nº Asignado es: $movim_ncorr')");
		
		$objResponse->addScript("location.href='sg_bodega_imp_guia.php?guia=$movim_ncorr'");
		$_SESSION["alycar_pag_regreso"] = 'sg_bodega_devoluciones_vendedor.php?ncorr='.$_SESSION["alycar_sgyonley_traspaso"];
				
		unset($_SESSION["alycar_sgyonley_traspaso"]);
		
	}
			
	return $objResponse->getXML();
}

function CargaListado($data){
    global $conexion;
	global $miSmarty;
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	$objResponse->addAssign("divresultadoarticulos", "innerHTML", "");
	
	$ncorr ="";
	if(isset($_SESSION["alycar_sgyonley_traspaso"]))
		$ncorr	=	$_SESSION["alycar_sgyonley_traspaso"];
	
	// busca si existe el encabezado.
	
	$sql_ing = "select 
					empe_rut as empresa,
					DATE_FORMAT(movim_fecha,'%d/%m/%Y') as fecha,
					pr_rut as rut_proveedor,
					tdoc_ncorr as cod_doc,
					movim_numdoc as num_doc,
					movim_obs as obs
					
				from sgcompras.movim
				where movim_ncorr = '".$ncorr."'";
				
	$res_ing = mysql_query($sql_ing, $conexion) or die(mysql_error());
	if (mysql_num_rows($res_ing) > 0){
		$empe_rut 		= 	@mysql_result($res_ing,0,"empresa");
		$pr_rut 		= 	@mysql_result($res_ing,0,"rut_proveedor");
		$fecha 			= 	@mysql_result($res_ing,0,"fecha");
		$tdoc_ncorr 	= 	@mysql_result($res_ing,0,"cod_doc");
		$num_doc 		= 	@mysql_result($res_ing,0,"num_doc");
		$obs 			= 	@mysql_result($res_ing,0,"obs");
		
		$objResponse->addAssign("OBLItxtFecha", "value", $fecha);
		
		$objResponse->addAssign("txtObservacion", "value", $obs);
	
	}	
	
	$sql = "select mdet_ncorr, mdet_codigo, mdet_desc, mdet_nu, mdet_valor, mdet_cantidad, mdet_subneto, mdet_descuento, mdet_subtotal
			from sgcompras.movim_detalle
			where movim_ncorr = '".$ncorr."'";
			
	$res = mysql_query($sql, $conexion);
	
	if (mysql_num_rows($res) > 0){
			
		$arrRegistros 		= 	array();
		
		while ($line = mysql_fetch_row($res)) {
			
			array_push($arrRegistros, array("ncorr" 		=> 	$line[0],
											"codigo" 		=> 	$line[1], 
											"descripcion" 	=> 	$line[2], 
											"nu" 			=> 	$line[3],
											"valor"			=> 	$line[4], 
											"cantidad"		=> 	$line[5],  
											"subneto"		=> 	$line[6],
											"descuento"		=> 	$line[7],
											"subtotal"		=> 	$line[8]));
			
		}
		
		$miSmarty->assign('arrRegistros', $arrRegistros);
		$objResponse->addAssign("divresultadoarticulos", "innerHTML", $miSmarty->fetch('sg_bodega_traspaso_list.tpl'));
		
	}	
	
	return $objResponse->getXML();
}

function CargaPagina($data){
    global $conexion;
    $objResponse = new xajaxResponse('ISO-8859-1');
	$where = 'where bodega_ncorr <> "'.$_SESSION["alycar_sgyonley_bodega"].'"';
	//  carga sgbodega.bodegas
	$objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'OBLIcboBodega','sgbodega.bodegas','','- - Seleccione - -','bodega_ncorr', 'nombre', ' $where ')");
	
	//  carga el listado
	$objResponse->addScript("xajax_CargaListado(xajax.getFormValues('Form1'))");
	
	return $objResponse->getXML();
}          
function CargaSelect($data, $select, $tabla, $codigo, $descripcion, $campo1, $campo2,$opt){
    global $conexion;	
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	$objResponse->addAssign("$select","innerHTML",""); 		
	$sql = "select $campo1 as codigo, $campo2 as descripcion from $tabla $opt ORDER BY $campo2 ASC";
	$res = mysql_query($sql, $conexion) or die(mysql_error());
	
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


function Nueva($data){
    global $conexion;
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	unset($_SESSION["alycar_sgyonley_traspaso"]);
	$objResponse->addScript("window.document.Form1.submit();");

	return $objResponse->getXML();
}
function MuestraRegistro($data, $campo1, $campo2, $obj1, $obj2){
	global $conexion;
	
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	$objResponse->addAssign("$obj1", "value", $campo1);
	$objResponse->addAssign("$obj2", "value", $campo2);
	
	return $objResponse->getXML();
}

function CargaDesc($data, $tabla, $campo1, $campo2, $objeto1, $objeto2, $c_and){
    global $conexion;
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	$ncorr 		= 	$data["$objeto1"];
	
	if ($tabla == 'sgbodega.tallasnew'){
		$sql = "select a.ta_ncorr, a.ta_busqueda as ta_busqueda, a.ta_descripcion as ta_descripcion from 
				sgbodega.tallasnew a where 
				a.ta_ncorr = '".$ncorr."'
				
				group by a.ta_ncorr";
		$res = mysql_query($sql, $conexion) or die(mysql_error());
		
		$objResponse->addAssign("OBLItxtDescProducto", "value", @mysql_result($res,0,"ta_busqueda")." ".@mysql_result($res,0,"ta_descripcion"));
		
	}else{
		
		$sql = "select $campo2 as descripcion from $tabla where $campo1 = '".$ncorr."' $and";
		$res = mysql_query($sql, $conexion);
		$objResponse->addAssign("$objeto2", "value", @mysql_result($res,0,"descripcion"));
	}	
	
	return $objResponse->getXML();
}
function CalculaTotalesLinea($data){
	global $conexion;
	
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	return $objResponse->getXML();
}
function EliminarItem($data, $ncorr){
	global $conexion;
	
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	$sql = "delete from sgcompras.movim_detalle where mdet_ncorr = '".$ncorr."'";
	$res = mysql_query($sql, $conexion);
	
	$objResponse->addScript("xajax_CargaListado(xajax.getFormValues('Form1'))");

	return $objResponse->getXML();
}

$xajax->registerFunction("CargaPagina");
$xajax->registerFunction("Nueva");
$xajax->registerFunction("CargaListado");
$xajax->registerFunction("MuestraRegistro");
$xajax->registerFunction("CargaSelect");
$xajax->registerFunction("CargaDesc");
$xajax->registerFunction("CalculaTotalesLinea");
$xajax->registerFunction("Grabar");
$xajax->registerFunction("EliminarItem");
$xajax->registerFunction("ConfirmaIngreso");

$xajax->processRequests();
$miSmarty->assign('xajax_js', $xajax->getJavascript());
$miSmarty->assign('BODEGA',$_SESSION['alycar_sgyonley_bodega_nombre']);
$miSmarty->assign('NRO_BODEGA',$_SESSION['alycar_sgyonley_bodega']);
$miSmarty->display('sg_bodega_traspaso.tpl');

?>

