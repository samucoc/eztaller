<?php
session_set_cookie_params('18000'); // 5 HORAS
session_start();

/* EL CODIGO DEL PRODUCTO SE ARMAR� POR:
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

$xajax->setRequestURI("sg_bodega_devoluciones_proveedor.php");
$xajax->setCharEncoding("ISO-8859-1");
$xajax->decodeUTF8InputOn();

function Grabar($data){
	global $conexion;
	
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	$movim_bodega 		=	$_SESSION['alycar_sgyonley_bodega'];
	$movim_tipo			=	3;
	$empe_rut			=	$data["OBLIcboEmpresa"];
	$movim_fecha		=	$data["OBLItxtFecha"];
	$pr_rut				=	$data["OBLItxtCodProveedor"];
	$tdoc_ncorr			=	$data["OBLIcboTipoDocumento"];
	$movim_numdoc		=	$data["OBLINumDocumento"];
	$movim_obs			=	trim($data["txtObservacion"]);
	$usu_id				=	$_SESSION["alycar_sgyonley_usuario"];
	$mdet_codigo		=	$data["OBLItxtCodProducto"];
	$mdet_desc			=	$data["OBLItxtDescProducto"];
	$mdet_nu			=	$data["cboNU"];
	$mdet_valor			=	$data["OBLItxtValor"];
	$mdet_cantidad		=	$data["OBLItxtCant"];
	$mdet_subneto		=	$data["OBLItxtSubNeto"];
	$mdet_descuento		=	$data["OBLItxtDescuento"];
	$mdet_subtotal		=	$data["OBLItxtSubTotal"];
	
	list($dia1,$mes1,$anio1) = split('[/.-]', $movim_fecha);$movim_fecha = $anio1."-".$mes1."-".$dia1;
	
	$ingresa = 'SI';
	
	if ($mdet_cantidad < 1){
		$objResponse->addScript("alert('Cantidad Incorrecta')");
		$ingresa = 'NO';
	}
		// bloqueo los ingresos posteriores a la fecha de cierre.
	$sql_cierre			= 	"select cier_fecha as ultimocierre 
								from sgbodega.cierres
								order by cier_fecha desc limit 1";
	$res_cierre			= 	mysql_query($sql_cierre, $conexion);
	$ult_cierre 		= 	@mysql_result($res_cierre,0,"ultimocierre");
	
	$sql_dif 			=	"SELECT DATEDIFF('".$movim_fecha."','".$ult_cierre."') as dias_dif";
	$res_dif			=	mysql_query($sql_dif, $conexion);
	$dias_dif			=	@mysql_result($res_dif,0,"dias_dif");

	if ($dias_dif <= 0){
			$ingresa 	= 	"NO";
			$objResponse->addScript("alert('Fecha antes del cierre.')");
			unset($_SESSION["alycar_sgyonley_devolucion_proveedor"]);
			$objResponse->addScript("window.document.Form1.submit();");
			}
	if ($ingresa == 'SI'){
		
		if (!isset($_SESSION["alycar_sgyonley_devolucion_proveedor"])){
			$sql = "insert into sgcompras.movim (movim_bodega,movim_tipo,empe_rut,movim_fecha,pr_rut,movim_obs,usu_id)
					values (
					'".$movim_bodega."','".$movim_tipo."','".$empe_rut."','".$movim_fecha."','".$pr_rut."','".$movim_obs."','".$usu_id."')";
			
			$res = mysql_query($sql, $conexion);
			
			
			$ncorr = mysql_insert_id($conexion); //mysql_insert_id($conexion);
			
			//$objResponse->addScript("alert('$ncorr')");
			
			$_SESSION["alycar_sgyonley_devolucion_proveedor"] = $ncorr;
		}
		
		// ingresa el articulo
		$movim_ncorr		=	$_SESSION["alycar_sgyonley_devolucion_proveedor"];
		$sql_001 = "select count(movim_ncorr) as contador
			    from sgcompras.movim_detalle
			    where movim_ncorr = '".$movim_ncorr."'";
		$res_001 = mysql_query($sql_001,$conexion) or die(mysql_error());
		$row_001 = mysql_fetch_array($res_001);		
		$contador = $row_001['contador'];
		if ($contador<30){

			$sql_det = "insert into sgcompras.movim_detalle (movim_ncorr,mdet_codigo,mdet_desc,mdet_cantidad) 
					
						values ('".$movim_ncorr."','".$mdet_codigo."','".$mdet_desc."','".$mdet_cantidad."')";
					
			//$objResponse->addAssign("divresultadoarticulos", "innerHTML", $sql_det);
		
			$res_det = mysql_query($sql_det, $conexion) or die(mysql_error());
			$objResponse->addScript("xajax_CargaListado(xajax.getFormValues('Form1'))");
		
			$objResponse->addAssign("OBLItxtCodProducto", "value", '');
			$objResponse->addAssign("OBLItxtDescProducto", "value", '');
			$objResponse->addAssign("OBLItxtCant", "value", '');
		
			$objResponse->addScript("document.getElementById('OBLItxtCodProducto').focus();");
		}
		else{
			$objResponse->addAssign("OBLItxtCodProducto", "value", '');
			$objResponse->addAssign("OBLItxtDescProducto", "value", '');
			$objResponse->addAssign("OBLItxtCant", "value", '');
	
			$objResponse->addAlert("Ha excedido la cantidad de productos por guia.");

			}
		
	}			
	return $objResponse->getXML();
}
function ConfirmaIngreso($data){
	global $conexion;
	
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	$empe_rut			=	$data["OBLIcboEmpresa"];
	$movim_fecha		=	$data["OBLItxtFecha"];
	
	$ingresa = 'SI';
	
	if ($ingresa == 'SI'){
		if ($movim_fecha == ''){
			$objResponse->addScript("alert('Fecha Incorrecta')");
			$ingresa = 'NO';
		}
	}
	if ($ingresa == 'SI'){
		if (!isset($_SESSION["alycar_sgyonley_devolucion_proveedor"])){
			$objResponse->addScript("alert('No Se Han Ingresado Productos al Listado')");
			$ingresa = 'NO';
		}
	}
	
	// valido la fecha del movim
	if ($ingresa == 'SI'){
			list($dia1,$mes1,$anio1) = split('[/.-]', $movim_fecha);$movim_fecha = $anio1."-".$mes1."-".$dia1;
		
		$movim_ncorr =	$_SESSION["alycar_sgyonley_devolucion_proveedor"];
		
		$sql = "update sgcompras.movim set 
				movim_estado 	= 	'FINALIZADO',
				movim_fecha_dig	=	'".date("Y-m-d h:i:s")."'
				,
				movim_ncorr_ant = 	'".$movim_ncorr."'
				where
				movim_ncorr = '".$movim_ncorr."'";
		
		$res = mysql_query($sql, $conexion);
		
		$objResponse->addScript("alert('Devoluci�n Ingresada Correctamente, El N� Asignado es: $movim_ncorr')");
		
		$objResponse->addScript("location.href='sg_bodega_imp_guia.php?guia=$movim_ncorr'");
		$_SESSION["alycar_pag_regreso"] = 'sg_bodega_aumentos_vendedor.php?ncorr='.$_SESSION["alycar_sgyonley_devolucion_proveedor"];
		unset($_SESSION["alycar_sgyonley_devolucion_proveedor"]);
		
	}
			
	return $objResponse->getXML();
}

function CargaListado($data){
    global $conexion;
	global $miSmarty;
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	$objResponse->addAssign("divresultadoarticulos", "innerHTML", "");
	
	$ncorr="";
	if(isset($_SESSION["alycar_sgyonley_devolucion_proveedor"]))
		$ncorr	=	$_SESSION["alycar_sgyonley_devolucion_proveedor"];
	else
		$ncorr = $data['ncorr'];
	
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
				
	$res_ing = mysql_query($sql_ing, $conexion);
	if (mysql_num_rows($res_ing) > 0){
		$empe_rut 		= 	@mysql_result($res_ing,0,"empresa");
		$fecha 			= 	@mysql_result($res_ing,0,"fecha");
		$obs 			= 	@mysql_result($res_ing,0,"obs");
		
		// busca la empresa
		$sql = "select empe_desc from sgyonley.empresas where empe_rut = '".$empe_rut."'";
		$res = mysql_query($sql, $conexion);
		$empe_desc = mysql_result($res,0,"empe_desc");
		$objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'OBLIcboEmpresa','sgyonley.empresas','$empe_rut','$empe_desc','empe_rut', 'empe_desc', '')");
		
		$objResponse->addAssign("OBLItxtFecha", "value", $fecha);
		
		/*
		// busca el tipo documento
		$sql = "select tdoc_desc from tipos_documentos where tdoc_ncorr = '".$tdoc_ncorr."'";
		$res = mysql_query($sql, $conexion);
		$tdoc_desc = mysql_result($res,0,"tdoc_desc");
		$objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'OBLIcboTipoDocumento','tipos_documentos','$tdoc_ncorr','$tdoc_desc','tdoc_ncorr', 'tdoc_desc')");
		
		$objResponse->addAssign("OBLINumDocumento", "value", $num_doc);
		*/
		
		$objResponse->addAssign("txtObservacion", "value", $obs);
		$objResponse->addScript("document.getElementById('btnGrabar').style.display = 'none'");
		$objResponse->addScript("document.getElementById('btnNuevo').style.display = 'none'");
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
		$objResponse->addAssign("divresultadoarticulos", "innerHTML", $miSmarty->fetch('sg_bodega_devoluciones_proveedor_list.tpl'));
		
	}	
	
	return $objResponse->getXML();
}

function CargaPagina($data){
    global $conexion;
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	//  carga empresas
	$objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'OBLIcboEmpresa','sgyonley.empresas','','- - Seleccione - -','empe_rut', 'empe_desc', '')");
	
	//  carga el listado
	$objResponse->addScript("xajax_CargaListado(xajax.getFormValues('Form1'))");
	
	return $objResponse->getXML();
}          
function CargaSelect($data, $select, $tabla, $codigo, $descripcion, $campo1, $campo2){
    global $conexion;	
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	$objResponse->addAssign("$select","innerHTML",""); 		
	$sql = "select $campo1 as codigo, $campo2 as descripcion from $tabla ORDER BY $campo2 ASC";
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


function Nueva($data){
    global $conexion;
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	unset($_SESSION["alycar_sgyonley_devolucion_proveedor"]);
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
	
	//mysql_select_db("sgyonley", $conexion);
	
	$ncorr 		= 	$data["$objeto1"];
	
	if ($tabla == 'sgbodega.tallas'){
		$sql = "select ta_ncorr, ta_descripcion, ta_busqueda, ta_venta, ta_venta2 from sgbodega.tallasnew where $campo1 = '".$ncorr."'";
		$res = mysql_query($sql, $conexion);
		
		$objResponse->addAssign("OBLItxtDescProducto", "value", @mysql_result($res,0,"ta_busqueda")." ".@mysql_result($res,0,"ta_descripcion"));
		
		//$objResponse->addScript("xajax_CalculaTotalesLinea(xajax.getFormValues('Form1'))");
	
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

$miSmarty->display('sg_bodega_devoluciones_proveedor.tpl');

?>

