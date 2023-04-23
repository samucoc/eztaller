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
include "busca_stock_producto.php"; 

$xajax = new xajax();

$xajax->setRequestURI("sg_bodega_aumentos_vendedor.php");
$xajax->setCharEncoding("ISO-8859-1");
$xajax->decodeUTF8InputOn();

function Grabar($data){
	global $conexion;
	
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	
	$movim_tipo			=	2;
	$empe_rut			=	$data["OBLIcboEmpresa"];
	$movim_fecha		=	$data["OBLItxtFecha"];
	$vend_ncorr			=	$data["OBLI-txtCodCobrador"];
	$movim_obs			=	trim($data["txtObservacion"]);
	$usu_id				=	$_SESSION["alycar_sgyonley_usuario"];
	$mdet_codigo		=	$data["OBLItxtCodProducto"];
	$mdet_desc			=	$data["OBLItxtDescProducto"];
	$mdet_nu			=	$data["cboNU"];
	$mdet_cantidad		=	$data["OBLItxtCant"];
	$mdet_stock_vend_n	=	$data["OBLItxtStockVendedorN"];
	$mdet_stock_vend_u	=	$data["OBLItxtStockVendedorU"];
	$mdet_stock_bod_n	=	$data["OBLItxtStockBodegaN"];
	$mdet_stock_bod_u	=	$data["OBLItxtStockBodegaU"];
	
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
			unset($_SESSION["alycar_sgyonley_aumento_vendedor"]);
			$objResponse->addAlert("window.document.Form1.submit();");
		
		}
/*	############	ACTIVAR ESTE CODIGO PARA EL SISTEMA DE EXISTENCIA	####################################################
	// verifico que el movimiento se tenga fecha anterior a la del ultimo inventario del vendedor
	if ($ingresa == 'SI'){
		
		$tiene_inv = VerificaCierreInv($empe_rut,$vend_ncorr,$vent_fecha);
		if ($tiene_inv != 'NO'){
			$objResponse->addScript("alert('Fecha Incorrecta, el vendedor tiene un cierre el $tiene_inv')");
			$ingresa = "NO";
		}
	}	
*/	############	FIN		################################################################################################
	
	if ($ingresa == 'SI'){
		
		if (!isset($_SESSION["alycar_sgyonley_aumento_vendedor"])){
			$sql = "insert into sgbodega.movim (movim_tipo,empe_rut,movim_fecha,vend_ncorr,movim_obs,usu_id)
					values (
					'".$movim_tipo."','".$empe_rut."','".$movim_fecha."','".$vend_ncorr."','".$movim_obs."','".$usu_id."')";
			
			$res = mysql_query($sql, $conexion);
			
			
			$ncorr = mysql_insert_id($conexion); //mysql_insert_id($conexion);
			
			//$objResponse->addScript("alert('$ncorr')");
			
			$_SESSION["alycar_sgyonley_aumento_vendedor"] = $ncorr;
		}
		
		// ingresa el articulo
		$movim_ncorr		=	$_SESSION["alycar_sgyonley_aumento_vendedor"];
		
		
		$sql_det = "insert into sgbodega.movim_detalle (movim_ncorr,mdet_codigo,mdet_desc,mdet_nu,mdet_cantidad,
					mdet_stock_vend_n,mdet_stock_vend_u,mdet_stock_bod_n,mdet_stock_bod_u) 
					
					values ('".$movim_ncorr."','".$mdet_codigo."','".$mdet_desc."','".$mdet_nu."','".$mdet_cantidad."',
					'".$mdet_stock_vend_n."','".$mdet_stock_vend_u."','".$mdet_stock_bod_n."','".$mdet_stock_bod_u."')";
					
		//$objResponse->addAssign("divresultadoarticulos", "innerHTML", $sql_det);
		
		$res_det = mysql_query($sql_det, $conexion);
		$objResponse->addScript("xajax_CargaListado(xajax.getFormValues('Form1'))");
		
		$objResponse->addAssign("OBLItxtCodProducto", "value", '');
		$objResponse->addAssign("OBLItxtDescProducto", "value", '');
		$objResponse->addAssign("OBLItxtCant", "value", '');
		$objResponse->addAssign("OBLItxtStockVendedorN", "value", '0');
		$objResponse->addAssign("OBLItxtStockVendedorU", "value", '0');
		$objResponse->addAssign("OBLItxtStockBodegaN", "value", '0');
		$objResponse->addAssign("OBLItxtStockBodegaU", "value", '0');
		
		$objResponse->addScript("document.getElementById('OBLItxtCodProducto').focus();");
	
	}
			
	return $objResponse->getXML();
}

function CargaListado($data){
    global $conexion;
	global $miSmarty;
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	$objResponse->addAssign("divresultadoarticulos", "innerHTML", "");
	
	$ncorr	=	$_SESSION["alycar_sgyonley_aumento_vendedor"];
	
	// busca si existe el encabezado.
	$sql_ing = "select 
					empe_rut as empresa,
					DATE_FORMAT(movim_fecha,'%d/%m/%Y') as fecha,
					vend_ncorr as vendedor,
					movim_obs as obs
					
				from sgbodega.movim
				where movim_ncorr = '".$ncorr."'";
				
	$res_ing = mysql_query($sql_ing, $conexion);
	if (mysql_num_rows($res_ing) > 0){
		$empe_rut 		= 	@mysql_result($res_ing,0,"empresa");
		$vend_ncorr		= 	@mysql_result($res_ing,0,"vendedor");
		$fecha 			= 	@mysql_result($res_ing,0,"fecha");
		$obs 			= 	@mysql_result($res_ing,0,"obs");
		
		// busca la empresa
		$sql = "select empe_desc from empresas where empe_rut = '".$empe_rut."'";
		$res = mysql_query($sql, $conexion);
		$empe_desc = @mysql_result($res,0,"empe_desc");
		$objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'OBLIcboEmpresa','empresas','$empe_rut','$empe_desc','empe_rut', 'empe_desc', '')");
		
		$objResponse->addAssign("OBLItxtFecha", "value", $fecha);
		
		// busca el vendedor
		$sql = "select ve_codigo, ve_vendedor from sgbodega.vendedores where ve_codigo = '".$vend_ncorr."'";
		$res = mysql_query($sql, $conexion);
		$objResponse->addAssign("OBLI-txtCodCobrador", "value", @mysql_result($res,0,"ve_codigo"));
		$objResponse->addAssign("OBLI-txtDescCobrador", "value", @mysql_result($res,0,"ve_vendedor"));
		
		$objResponse->addAssign("txtObservacion", "value", $obs);
	
	}	
	
	$sql = "select mdet_ncorr, mdet_codigo, mdet_desc, mdet_nu, mdet_cantidad, mdet_stock_vend_n,mdet_stock_vend_u,mdet_stock_bod_n,mdet_stock_bod_u
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
											"cantidad"		=> 	$line[4],  
											"stock_vend_n"	=> 	$line[5],
											"stock_vend_u"	=> 	$line[6],
											"stock_bod_n"	=> 	$line[7],
											"stock_bod_u"	=> 	$line[8]));
			
		}
		
		$miSmarty->assign('arrRegistros', $arrRegistros);
		$objResponse->addAssign("divresultadoarticulos", "innerHTML", $miSmarty->fetch('sg_bodega_aumentos_vendedor_list.tpl'));
		
	}	
	
	return $objResponse->getXML();
}

function ConfirmaIngreso($data){
	global $conexion;
	
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	$empe_rut			=	$data["OBLIcboEmpresa"];
	$movim_fecha		=	$data["OBLItxtFecha"];
	$vend_ncorr			=	$data["OBLI-txtCodCobrador"];
	$vendedor			=	$data["OBLI-txtDescCobrador"];
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
		if (($vend_ncorr == '') OR ($vendedor == '')){
			$objResponse->addScript("alert('Vendedor Incorrecto')");
			$ingresa = 'NO';
		}
	}
	if ($ingresa == 'SI'){
		if (!isset($_SESSION["alycar_sgyonley_aumento_vendedor"])){
			$objResponse->addScript("alert('No Se Han Ingresado Productos al Listado')");
			$ingresa = 'NO';
		}
	}
	
	// valido la fecha del movim
	if ($ingresa == 'SI'){
		$ingresa = BloqueaMovim($movim_fecha);
		if ($ingresa == 'NO'){
			$objResponse->addScript("alert('Fecha Movimiento Incorrecta.')");
			unset($_SESSION["alycar_sgyonley_aumento_vendedor"]);
			$objResponse->addScript("window.document.Form1.submit();");
		
		}else{
			list($dia1,$mes1,$anio1) = split('[/.-]', $movim_fecha);$movim_fecha = $anio1."-".$mes1."-".$dia1;
		}
	}
	// fin validacion de fecha
	
	if ($ingresa == 'SI'){
		
		$movim_ncorr =	$_SESSION["alycar_sgyonley_aumento_vendedor"];
		
		$sql = "update sgbodega.movim set 
				movim_estado 	= 	'FINALIZADO',
				movim_fecha_dig	=	'".date("Y-m-d h:i:s")."'
				where
				movim_ncorr = '".$movim_ncorr."'";
		
		$res = mysql_query($sql, $conexion);
		
		$sql_det = "select mdet_codigo, mdet_desc, mdet_nu, mdet_cantidad from sgbodega.movim_detalle where movim_ncorr = '".$movim_ncorr."'";
		$res_det = mysql_query($sql_det, $conexion);
		if (mysql_num_rows($res_det) > 0){
			while ($line_det = mysql_fetch_row($res_det)) {
				$codigo = $line_det[0];
				
				//busca el BV_CODBUS
				$sql_cod = "select ta_codigo from sgbodega.tallasnew where ta_ncorr = '".$codigo."'";
				$res_cod = mysql_query($sql_cod, $conexion);
				
				$BV_CODBUS 			= 	@mysql_result($res_cod,0,"ta_codigo");
				$BV_EMPRESA 		= 	$empe_rut;
				$BV_VENDEDOR		=	$vend_ncorr;
				$BV_GLOSA			=	$line_det[1];
				$NU					=	$line_det[2];
				$BV_STOCKNUEVO		=	0;
				$BV_STOCKUSADO		=	0;
				$STOCK_BODEGA_NUEVO = 	0;
				$STOCK_BODEGA_USADO = 	0;
				
				if ($NU == 'N'){
					$BV_STOCKNUEVO 		= $line_det[3];
					$STOCK_BODEGA_NUEVO = $line_det[3];
				}
				if ($NU == 'U'){
					$BV_STOCKUSADO = $line_det[3];
					$STOCK_BODEGA_USADO = $line_det[3];
				}
				
				// actualiza el stock del vendedor
				$sql_p = "select BV_CODBUS,BV_STOCKNUEVO,BV_STOCKUSADO from sgbodega.bodvendedor where BV_EMPRESA = '".$BV_EMPRESA."' and BV_VENDEDOR = '".$BV_VENDEDOR."' and BV_CODBUS = '".$BV_CODBUS."'";
				$res_p = mysql_query($sql_p, $conexion);
				if (mysql_num_rows($res_p) > 0){
					$BV_STOCKNUEVO = $BV_STOCKNUEVO + @mysql_result($res_p,0,"BV_STOCKNUEVO");
					$BV_STOCKUSADO = $BV_STOCKUSADO + @mysql_result($res_p,0,"BV_STOCKUSADO");
					
					$sql_ing = "update sgbodega.bodvendedor set
								BV_CODBUS		=	'".$BV_CODBUS."',
								BV_GLOSA		=	'".$BV_GLOSA."',
								BV_STOCKNUEVO	=	'".$BV_STOCKNUEVO."',
								BV_STOCKUSADO	=	'".$BV_STOCKUSADO."'
								
								where 
								BV_EMPRESA = '".$BV_EMPRESA."' and BV_VENDEDOR = '".$BV_VENDEDOR."' and BV_CODBUS = '".$BV_CODBUS."'";
					$res_ing = mysql_query($sql_ing, $conexion);
				}else{
					$sql_ing = "insert into sgbodega.bodvendedor 
								(BV_EMPRESA,BV_VENDEDOR,BV_CODBUS,BV_GLOSA,BV_STOCKNUEVO,BV_STOCKUSADO)
								
								values 
								('".$BV_EMPRESA."','".$BV_VENDEDOR."','".$BV_CODBUS."','".$BV_GLOSA."','".$BV_STOCKNUEVO."',
								'".$BV_STOCKUSADO."')";
					$res_ing = mysql_query($sql_ing, $conexion);
				}
				// fin actualizacion de stock del vendedor
				
				// actualiza el stock en bodega
				$sql = "select TA_STOCK1 as stock_nuevo, TA_STOCKUSA as stock_usado from sgbodega.tallasnew where TA_CODIGO = '".$BV_CODBUS."' and TA_EMPRESA = '".$BV_EMPRESA."'";
				$res = mysql_query($sql, $conexion);
				if (mysql_num_rows($res) > 0){
					$stock_bodega_nuevo = @mysql_result($res,0,"stock_nuevo") - $STOCK_BODEGA_NUEVO;
					$stock_bodega_usado = @mysql_result($res,0,"stock_usado") - $STOCK_BODEGA_USADO;
					
					$sql_upb = "update sgbodega.tallasnew set TA_STOCK1 = '".$stock_bodega_nuevo."', TA_STOCKUSA = '".$stock_bodega_usado."'
								where TA_CODIGO = '".$BV_CODBUS."' and TA_EMPRESA = '".$BV_EMPRESA."'";
					$res_upb = mysql_query($sql_upb, $conexion);
					
				}
				//fin de actualizacion de stock en bodega.
			
			
			}
		}
		
		$objResponse->addScript("alert('Aumento a Vendedor Ingresado Correctamente, El Nº Asignado es: $movim_ncorr')");
		
		unset($_SESSION["alycar_sgyonley_aumento_vendedor"]);
		$objResponse->addScript("window.document.Form1.submit();");
		
	}
			
	return $objResponse->getXML();
}


function CargaPagina($data){
    global $conexion;
    $objResponse = new xajaxResponse('ISO-8859-1');
	
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
	
	unset($_SESSION["alycar_sgyonley_aumento_vendedor"]);
	$objResponse->addScript("window.document.Form1.submit();");

	return $objResponse->getXML();
}
function MuestraRegistro($data, $campo1, $campo2, $obj1, $obj2){
	global $conexion;
	
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	$objResponse->addAssign("$obj1", "value", $campo1);
	$objResponse->addAssign("$obj2", "value", $campo2);
	
	$objResponse->addScript("xajax_CargaDesc(xajax.getFormValues('Form1'), 'sgbodega.tallasnew', 'ta_ncorr', 'ta_descripcion', 'OBLItxtCodProducto', 'OBLItxtDescProducto', '');");
	
	return $objResponse->getXML();
}

function CargaDesc($data, $tabla, $campo1, $campo2, $objeto1, $objeto2, $c_and){
    global $conexion;
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	//mysql_select_db("sgyonley", $conexion);
	
	$ncorr 			= 	$data["$objeto1"];
	$empresa 		= 	$data["OBLIcboEmpresa"];
	$vendedor 		= 	$data["OBLI-txtCodCobrador"];
	$stockbodega_n 	= 	StockBodega($empresa, $ncorr, "N"); // funcion dinamica
	$stockbodega_u 	= 	StockBodega($empresa, $ncorr, "U"); // funcion dinamica	
	$stockvend_n 	= 	StockVendedor($empresa, $ncorr, $vendedor, "N"); // funcion dinamica
	$stockvend_u 	= 	StockVendedor($empresa, $ncorr, $vendedor, "U"); // funcion dinamica	
	
	if (($tabla == 'sgbodega.tallas') OR ($tabla == 'sgbodega.tallasnew')){
		$sql = "select ta_ncorr, ta_codigo, ta_descripcion, ta_busqueda, ta_venta from sgbodega.tallasnew where $campo1 = '".$ncorr."'";
		$res = mysql_query($sql, $conexion);
		$codigo = @mysql_result($res,0,"ta_codigo");
		
		$objResponse->addAssign("OBLItxtDescProducto", "value", @mysql_result($res,0,"ta_busqueda")." ".@mysql_result($res,0,"ta_descripcion"));
		
		// busca el stock en bodega
		$objResponse->addAssign("OBLItxtStockBodegaN", "value", $stockbodega_n);
		$objResponse->addAssign("OBLItxtStockBodegaU", "value", $stockbodega_u);
		
		// busca el stock del vendedor
		$objResponse->addAssign("OBLItxtStockVendedorN", "value", $stockvend_n);
		$objResponse->addAssign("OBLItxtStockVendedorU", "value", $stockvend_u);
		
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

$miSmarty->display('sg_bodega_aumentos_vendedor.tpl');

?>

