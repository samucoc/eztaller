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

$xajax->setRequestURI("sg_bodega_aumentos.php");
$xajax->setCharEncoding("ISO-8859-1");
$xajax->decodeUTF8InputOn();

function Grabar($data){
	global $conexion;
	
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	$movim_tipo			=	1;
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
								from cierres_inventarios
								order by cier_fecha desc limit 1";
	$res_cierre			= 	mysql_query($sql_cierre, $conexion);
	$ult_cierre 		= 	@mysql_result($res_cierre,0,"ultimocierre");
	
	$sql_dif 			=	"SELECT DATEDIFF('".$movim_fecha."','".$ult_cierre."') as dias_dif";
	$res_dif			=	mysql_query($sql_dif, $conexion);
	$dias_dif			=	@mysql_result($res_dif,0,"dias_dif");

	if ($dias_dif < 0){
			$ingresa 	= 	"NO";
			$objResponse->addScript("alert('Fecha antes del cierre.')");
			unset($_SESSION["alycar_sgyonley_aumento"]);
			$objResponse->addScript("window.document.Form1.submit();");
		}
		
	if ($ingresa == 'SI'){
		
		if (!isset($_SESSION["alycar_sgyonley_aumento"])){
			$sql = "insert into sgbodega.movim (movim_tipo,empe_rut,movim_fecha,pr_rut,tdoc_ncorr,movim_numdoc,movim_obs,usu_id)
					values (
					'".$movim_tipo."','".$empe_rut."','".$movim_fecha."','".$pr_rut."','".$tdoc_ncorr."','".$movim_numdoc."',
					'".$movim_obs."','".$usu_id."')";
			
			$res = mysql_query($sql, $conexion);
			$ncorr = mysql_insert_id($conexion);
			
			$_SESSION["alycar_sgyonley_aumento"] = $ncorr;
		}
		
		// ingresa el articulo
		$movim_ncorr		=	$_SESSION["alycar_sgyonley_aumento"];
		
		$sql_det = "insert into sgbodega.movim_detalle (movim_ncorr,mdet_codigo,mdet_desc,mdet_nu,mdet_valor,mdet_cantidad,
					mdet_subneto,mdet_descuento,mdet_subtotal) 
					values ('".$movim_ncorr."','".$mdet_codigo."','".$mdet_desc."','".$mdet_nu."','".$mdet_valor."','".$mdet_cantidad."',
					'".$mdet_subneto."','".$mdet_descuento."','".$mdet_subtotal."')";
					
		$res_det = mysql_query($sql_det, $conexion);
		
		$objResponse->addScript("xajax_CargaListado(xajax.getFormValues('Form1'))");
		
		$objResponse->addAssign("OBLItxtCodProducto", "value", '');
		$objResponse->addAssign("OBLItxtDescProducto", "value", '');
		$objResponse->addAssign("OBLItxtValor", "value", '');
		$objResponse->addAssign("OBLItxtCant", "value", '');
		$objResponse->addAssign("OBLItxtSubNeto", "value", '');
		$objResponse->addAssign("OBLItxtDescuento", "value", '0');
		$objResponse->addAssign("OBLItxtSubTotal", "value", '');
		
		$objResponse->addScript("document.getElementById('OBLItxtCodProducto').focus();");
	
	}
			
	return $objResponse->getXML();
}
function ConfirmaIngreso($data){
	global $conexion;
	
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	$empe_rut			=	$data["OBLIcboEmpresa"];
	$movim_fecha		=	$data["OBLItxtFecha"];
	$pr_rut				=	$data["OBLItxtCodProveedor"];
	$proveedor			=	$data["OBLItxtDescProveedor"];
	$tdoc_ncorr			=	$data["OBLIcboTipoDocumento"];
	$movim_numdoc		=	$data["OBLINumDocumento"];
	$movim_obs			=	trim($data["txtObservacion"]);
	
	$ingresa = 'SI';
	
	if ($ingresa == 'SI'){
		if (($empe_rut == '') OR ($empe_rut == '- - Seleccione - -')){
			$objResponse->addScript("alert('Empresa Incorrecta')");
			$ingresa = 'NO';
		}
	}
	if ($ingresa == 'SI'){
		if ($movim_fecha == ''){
			$objResponse->addScript("alert('Fecha Incorrecta')");
			$ingresa = 'NO';
		}
	}
	if ($ingresa == 'SI'){
		if (($pr_rut == '') OR ($proveedor == '')){
			$objResponse->addScript("alert('Proveedor Incorrecto')");
			$ingresa = 'NO';
		}
	}
	if ($ingresa == 'SI'){
		if (($tdoc_ncorr == '') OR ($tdoc_ncorr == '- - Seleccione - -')){
			$objResponse->addScript("alert('Tipo Documento Incorrecto')");
			$ingresa = 'NO';
		}
	}
	if ($ingresa == 'SI'){
		if ($movim_numdoc == ''){
			$objResponse->addScript("alert('N� Documento Incorrecto')");
			$ingresa = 'NO';
		}
	}
	if ($ingresa == 'SI'){
		if (!isset($_SESSION["alycar_sgyonley_aumento"])){
			$objResponse->addScript("alert('No Se Han Ingresado Productos al Listado')");
			$ingresa = 'NO';
		}
	}
	
	// valido la fecha del movim
	if ($ingresa == 'SI'){
		$ingresa = BloqueaMovim($movim_fecha);
		if ($ingresa == 'NO'){
			$objResponse->addScript("alert('Fecha Movimiento Incorrecta.')");
			unset($_SESSION["alycar_sgyonley_aumento"]);
			$objResponse->addScript("window.document.Form1.submit();");
		}else{
			list($dia1,$mes1,$anio1) = split('[/.-]', $movim_fecha);$movim_fecha = $anio1."-".$mes1."-".$dia1;
		}
	}
	// fin validacion de fecha
	
	if ($ingresa == 'SI'){
		
		$movim_ncorr =	$_SESSION["alycar_sgyonley_aumento"];
		
		$sql = "update sgbodega.movim set 
				movim_estado 	= 	'FINALIZADO',
				movim_fecha_dig	=	'".date("Y-m-d h:i:s")."'
				,
				movim_ncorr_ant = 	'".$movim_ncorr."'
				where
				movim_ncorr = '".$movim_ncorr."'";
		
		$res = mysql_query($sql, $conexion);
		
		// actualiza el valor de venta del producto ta_venta (valor nuevo) ta_venta2 (valor usuado)
		$sql_det = "select mdet_codigo, mdet_nu, mdet_valor, mdet_cantidad from sgbodega.movim_detalle where movim_ncorr = '".$movim_ncorr."'";
		$res_det = mysql_query($sql_det, $conexion);
		if (mysql_num_rows($res_det) > 0){
			while ($line_det = mysql_fetch_row($res_det)) {
				$codigo 			= 	$line_det[0];
				$nu					=	$line_det[1];
				$valor				=	$line_det[2];
				$valor_nuevo 		= 	0;
				$valor_usado 		= 	0;
				$cantidad_nuevo 	= 	0;
				$cantidad_usado 	= 	0;
				
				if ($nu == 'N'){
					$valor_nuevo 	= $valor;
					$cantidad_nuevo = $line_det[3];
				}
				if ($nu == 'U'){
					$valor_usado 	= $valor;
					$cantidad_usado = $line_det[3];
				}
				
				//actualiza los precios del articulo
				$sql_tallas = "update sgbodega.tallas set
								ta_venta 	= '".$valor_nuevo."',
								ta_venta2 	= '".$valor_usado."'
								
								where
								ta_ncorr = '".$codigo."'";
				
				$res_tallas = mysql_query($sql_tallas, $conexion);
				// fin de actualizacion de precios
				
				//busca y actualiza el stock en bodega
				$sql = "select TA_STOCK1 as stock_nuevo, TA_STOCKUSA as stock_usado from sgbodega.tallas where TA_NCORR = '".$codigo."'";
				$res = mysql_query($sql, $conexion);
				if (mysql_num_rows($res) > 0){
					$stock_bodega_nuevo = @mysql_result($res,0,"stock_nuevo") + $cantidad_nuevo;
					$stock_bodega_usado = @mysql_result($res,0,"stock_usado") + $cantidad_usado;
					
					$sql_upb = "update sgbodega.tallas set TA_STOCK1 = '".$stock_bodega_nuevo."', TA_STOCKUSA = '".$stock_bodega_usado."'
								where TA_NCORR = '".$codigo."'";
					$res_upb = mysql_query($sql_upb, $conexion);
					
				}
				//fin de actualizacion de stock en bodega.
				
			}
		}
		
		$objResponse->addScript("alert('Aumento Ingresado Correctamente, El N� Asignado es: $movim_ncorr')");
		
		unset($_SESSION["alycar_sgyonley_aumento"]);
		$objResponse->addScript("window.document.Form1.submit();");
		
	}
			
	return $objResponse->getXML();
}

function CargaListado($data){
    global $conexion;
	global $miSmarty;
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	$objResponse->addAssign("divresultadoarticulos", "innerHTML", "");
	
	$ncorr	=	$_SESSION["alycar_sgyonley_aumento"];
	
	// busca si existe el encabezado.
	$sql_ing = "select 
					empe_rut as empresa,
					DATE_FORMAT(movim_fecha,'%d/%m/%Y') as fecha,
					pr_rut as rut_proveedor,
					tdoc_ncorr as cod_doc,
					movim_numdoc as num_doc,
					movim_obs as obs
					
				from sgbodega.movim
				where movim_ncorr = '".$ncorr."'";
				
	$res_ing = mysql_query($sql_ing, $conexion);
	if (mysql_num_rows($res_ing) > 0){
		$empe_rut 		= 	@mysql_result($res_ing,0,"empresa");
		$pr_rut 		= 	@mysql_result($res_ing,0,"rut_proveedor");
		$fecha 			= 	@mysql_result($res_ing,0,"fecha");
		$tdoc_ncorr 	= 	@mysql_result($res_ing,0,"cod_doc");
		$num_doc 		= 	@mysql_result($res_ing,0,"num_doc");
		$obs 			= 	@mysql_result($res_ing,0,"obs");
		
		// busca la empresa
		$sql = "select empe_desc from empresas where empe_rut = '".$empe_rut."'";
		$res = mysql_query($sql, $conexion);
		$empe_desc = @mysql_result($res,0,"empe_desc");
		$objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'OBLIcboEmpresa','empresas','$empe_rut','$empe_desc','empe_rut', 'empe_desc', '')");
		
		$objResponse->addAssign("OBLItxtFecha", "value", $fecha);
		
		// busca el proveedor
		$sql = "select pr_razon from sgbodega.proveedor where pr_rut = '".$pr_rut."'";
		$res = mysql_query($sql, $conexion);
		$pr_razon = @mysql_result($res,0,"pr_razon");
		$objResponse->addAssign("OBLItxtCodProveedor", "value", $pr_rut);
		$objResponse->addAssign("OBLItxtDescProveedor", "value", $pr_razon);
		
		// busca el tipo documento
		$sql = "select tdoc_desc from tipos_documentos where tdoc_ncorr = '".$tdoc_ncorr."'";
		$res = mysql_query($sql, $conexion);
		$tdoc_desc = @mysql_result($res,0,"tdoc_desc");
		$objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'OBLIcboTipoDocumento','tipos_documentos','$tdoc_ncorr','$tdoc_desc','tdoc_ncorr', 'tdoc_desc')");
		
		$objResponse->addAssign("OBLINumDocumento", "value", $num_doc);
		$objResponse->addAssign("txtObservacion", "value", $obs);
	
	}	
	
	$sql = "select mdet_ncorr, mdet_codigo, mdet_desc, mdet_nu, mdet_valor, mdet_cantidad, mdet_subneto, mdet_descuento, mdet_subtotal
			from sgbodega.movim_detalle
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
		$objResponse->addAssign("divresultadoarticulos", "innerHTML", $miSmarty->fetch('sg_bodega_aumentos_list.tpl'));
		
	}	
	
	return $objResponse->getXML();
}

function CargaPagina($data){
    global $conexion;
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	//  carga tipos documentos
	$objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'OBLIcboTipoDocumento','tipos_documentos','','- - Seleccione - -','tdoc_ncorr', 'tdoc_desc')");

	//  carga empresas
	$objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'OBLIcboEmpresa','empresas','','- - Seleccione - -','empe_rut', 'empe_desc', '')");
	
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
	
	unset($_SESSION["alycar_sgyonley_aumento"]);
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
	
	if (($tabla == 'sgbodega.tallas') OR ($tabla == 'sgbodega.tallasnew')){
		$sql = "select ta_ncorr, ta_descripcion, ta_busqueda, ta_venta from sgbodega.tallasnew where $campo1 = '".$ncorr."'";
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
	
	$valor	 		= 	$data["OBLItxtValor"];
	$cantidad 		= 	$data["OBLItxtCant"];
	$descuento 		= 	$data["OBLItxtDescuento"];
	
	if (($valor != '') && ($cantidad != '')){
		$objResponse->addAssign("OBLItxtSubNeto", "value", $valor * $cantidad);
	}
	if (($valor != '') && ($cantidad != '') && ($descuento != '')){
		
		$objResponse->addAssign("OBLItxtSubTotal", "value", ($valor * $cantidad) - $descuento);
	}
	
	return $objResponse->getXML();
}
function EliminarItem($data, $ncorr){
	global $conexion;
	
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	$sql = "delete from sgbodega.movim_detalle where mdet_ncorr = '".$ncorr."'";
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

$miSmarty->display('sg_bodega_aumentos.tpl');

?>

