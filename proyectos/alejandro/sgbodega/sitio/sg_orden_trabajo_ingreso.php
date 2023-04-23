<?php
ob_start();
session_start();

require_once 'includes/xajax/xajax.inc.php'; //archivo de configuracion de ajax
include "../includes/php/conf_smarty.php";//archivo de configuracion de smarty
include "../includes/php/conf_bd.php"; //archivo de coneccion al servidor y base de datos
include "../includes/php/validaciones.php"; 

$xajax = new xajax();

$xajax->setRequestURI("sg_orden_trabajo_ingreso.php");
$xajax->setCharEncoding("ISO-8859-1");
$xajax->decodeUTF8InputOn();

function Grabar($data){
	global $conexion;
	
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	$movim_bodega 	=	'1';
	$movim_tipo		=	2;
	$empe_rut		=	"";
	$movim_fecha_ingreso	=	$data["OBLItxtFechaInicio"];
	$movim_fecha_egreso		=	$data["OBLItxtFechaFin"];
	$vend_ncorr		=	$data["OBLI-txtCodCobrador"];
	$movim_obs		=	trim($data["txtObservacion"]);
	$usu_id			=	$_SESSION["alycar_usuario"];
	$mdet_codigo	=	$data["OBLItxtCodProducto"];
	$mdet_desc		=	$data["OBLItxtDescProducto"];
	$mdet_cantidad	=	$data["OBLItxtCant"];
	
	list($dia1,$mes1,$anio1) = explode('/', $movim_fecha_ingreso);
	$movim_fecha_ingreso = $anio1."-".$mes1."-".$dia1;
	
	list($dia2,$mes2,$anio2) = explode('/', $movim_fecha_egreso);
	$movim_fecha_egreso = $anio2."-".$mes2."-".$dia2;
	
	$ingresa = 'SI';
	
	if ($mdet_cantidad < 1){
		$objResponse->addScript("alert('Cantidad Incorrecta')");
		$ingresa = 'NO';
	}

	if ($ingresa == 'SI'){
		
		if (!isset($_SESSION["alycar_sgyonley_aumento_vendedor"])){
			$sql = "insert into orden_trabajo (movim_bodega,movim_tipo,empe_rut,movim_fecha_ingreso,movim_fecha_egreso,vend_ncorr,movim_obs,usu_id)
					values (
					'".$movim_bodega."','".$movim_tipo."','".$empe_rut."','".$movim_fecha_ingreso."','".$movim_fecha_egreso."','".$vend_ncorr."','".$movim_obs."','".$usu_id."')";
			
			$res = mysql_query($sql, $conexion) or die(mysql_error($conexion));
			
			
			$ncorr = mysql_insert_id($conexion); //mysql_insert_id($conexion);
			
			//$objResponse->addScript("alert('$ncorr')");
			
			$_SESSION["alycar_sgyonley_aumento_vendedor"] = $ncorr;
		}
		
		// ingresa el articulo
		$movim_ncorr		=	$_SESSION["alycar_sgyonley_aumento_vendedor"];
		
		$sql_001 = "select count(movim_ncorr) as contador
			    from orden_trabajo_detalle
			    where movim_ncorr = '".$movim_ncorr."'";
		$res_001 = mysql_query($sql_001,$conexion) or die(mysql_error($conexion));
		$row_001 = mysql_fetch_array($res_001);		
		$contador = $row_001['contador'];
		if ($contador<30){

			$sql_det = "insert into orden_trabajo_detalle (movim_ncorr,mdet_codigo,mdet_desc,mdet_cantidad) 
					
						values ('".$movim_ncorr."','".$mdet_codigo."','".$mdet_desc."','".$mdet_cantidad."')";
					
			//$objResponse->addAssign("divresultadoarticulos", "innerHTML", $sql_det);
		
			$res_det = mysql_query($sql_det, $conexion) or die(mysql_error($conexion));
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
	$movim_fecha_ingreso		=	$data["OBLItxtFechaInicio"];
	$movim_fecha_egreso		=	$data["OBLItxtFechaFin"];
	$vend_ncorr			=	$data["OBLI-txtCodCobrador"];
	$vendedor			=	$data["OBLI-txtDescCobrador"];
	$movim_obs			=	trim($data["txtObservacion"]);
	
	$ingresa = 'SI';
	
	if ($ingresa == 'SI'){
		if ($movim_fecha_ingreso == '00/00/0000' || $movim_fecha_ingreso == ''){
			$objResponse->addScript("alert('Fecha Ingreso Incorrecta')");
			$ingresa = 'NO';
		}
	}
	if ($ingresa == 'SI'){
		if ($movim_fecha_egreso == '00/00/0000' || $movim_fecha_egreso == ''){
			$objResponse->addScript("alert('Fecha Egreso Incorrecta')");
			$ingresa = 'NO';
		}
	}
	if ($ingresa == 'SI'){
		if (($vend_ncorr == '') OR ($vendedor == '')){
			$objResponse->addScript("alert('Cliente Incorrecto')");
			$ingresa = 'NO';
		}
	}
	if ($ingresa == 'SI'){
		if (!isset($_SESSION["alycar_sgyonley_aumento_vendedor"])){
			$objResponse->addScript("alert('No Se Han Ingresado Productos al Listado')");
			$ingresa = 'NO';
		}
	}
	
	if ($ingresa == 'SI'){
		
		$movim_ncorr =	$_SESSION["alycar_sgyonley_aumento_vendedor"];
		$sql = "update orden_trabajo set 
				movim_estado 	= 	'FINALIZADO',
				movim_fecha_dig	=	'".date("Y-m-d h:i:s")."'
				where
				movim_ncorr = '".$movim_ncorr."'";
		
		$res = mysql_query($sql, $conexion) or die(mysql_error($conexion));
		
		$objResponse->addScript("alert('Order de Trabajo Ingresado Correctamente, El Nro Asignado es: $movim_ncorr')");
		//$objResponse->addScript("location.href='sg_bodega_imp_guia.php?guia=$movim_ncorr'");
		$objResponse->addScript("window.document.Form1.submit();");
		$_SESSION["alycar_pag_regreso"] = 'sg_orden_trabajo_ingreso.php?ncorr='.$_SESSION["alycar_sgyonley_aumento_vendedor"];
		unset($_SESSION["alycar_sgyonley_aumento_vendedor"]);
		
	}
			
	return $objResponse->getXML();
}


function CargaPagina($data){
    global $conexion;
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	$ncorr = $data['ncorr'];

	if ($ncorr==''){
	
		}
	else{
		$sql_ing = "select 
					DATE_FORMAT(movim_fecha_ingreso,'%d/%m/%Y') as fecha_ingreso,
					DATE_FORMAT(movim_fecha_egreso,'%d/%m/%Y') as fecha_egreso,
					vend_ncorr as cliente,
					movim_obs as obs
					
				from orden_trabajo
				where movim_ncorr = '".$ncorr."'";
				
		$res_ing = mysql_query($sql_ing, $conexion) or die(mysql_error($conexion));
		if (mysql_num_rows($res_ing) > 0){
			$vend_ncorr		= 	@mysql_result($res_ing,0,"cliente");
			$fecha_ingreso 			= 	@mysql_result($res_ing,0,"fecha_ingreso");
			$fecha_egreso 			= 	@mysql_result($res_ing,0,"fecha_egreso");
			$obs 			= 	@mysql_result($res_ing,0,"obs");
		
			$objResponse->addAssign("OBLItxtFechaInicio", "value", $fecha_ingreso);
			$objResponse->addAssign("OBLItxtFechaFin", "value", $fecha_egreso);
		
			// busca el vendedor
			$sql = "select ve_codigo, ve_vendedor from clientes where ve_codigo = '".$vend_ncorr."'";
			$res = mysql_query($sql, $conexion);
			$objResponse->addAssign("OBLI-txtCodCobrador", "value", @mysql_result($res,0,"ve_codigo"));
			$objResponse->addAssign("OBLI-txtDescCobrador", "value", @mysql_result($res,0,"ve_vendedor"));
		
			$objResponse->addAssign("txtObservacion", "value", $obs);
	
			}
		$objResponse->addScript("document.getElementById('btnGrabar').style.display = 'none'");
		$objResponse->addScript("document.getElementById('btnNuevo').style.display = 'none'");
		}
	//  carga el listado
	$objResponse->addScript("xajax_CargaListado(xajax.getFormValues('Form1'))");
	
	return $objResponse->getXML();
}          

function CargaListado($data){
    global $conexion;
	global $miSmarty;
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	$objResponse->addAssign("divresultadoarticulos", "innerHTML", "");
	$ncorr="";
	if(isset($_SESSION["alycar_sgyonley_aumento_vendedor"]))
		$ncorr	=	$_SESSION["alycar_sgyonley_aumento_vendedor"];
	else
		$ncorr = $data['ncorr'];
	// busca si existe el encabezado.
	$sql_ing = "select 
					DATE_FORMAT(movim_fecha_ingreso,'%d/%m/%Y') as fecha_ingreso,
					DATE_FORMAT(movim_fecha_egreso,'%d/%m/%Y') as fecha_egreso,
					vend_ncorr as cliente,
					movim_obs as obs
					
				from orden_trabajo
				where movim_ncorr = '".$ncorr."'";
				
	$res_ing = mysql_query($sql_ing, $conexion) or die(mysql_error($conexion));
	if (mysql_num_rows($res_ing) > 0){
		$vend_ncorr		= 	@mysql_result($res_ing,0,"cliente");
		$fecha_ingreso 			= 	@mysql_result($res_ing,0,"fecha_ingreso");
		$fecha_egreso 			= 	@mysql_result($res_ing,0,"fecha_egreso");
		$obs 			= 	@mysql_result($res_ing,0,"obs");
	
		$objResponse->addAssign("OBLItxtFechaInicio", "value", $fecha_ingreso);
		$objResponse->addAssign("OBLItxtFechaFin", "value", $fecha_egreso);
	
		// busca el vendedor
		$sql = "select ve_codigo, ve_vendedor from clientes where ve_codigo = '".$vend_ncorr."'";
		$res = mysql_query($sql, $conexion);
		$objResponse->addAssign("OBLI-txtCodCobrador", "value", @mysql_result($res,0,"ve_codigo"));
		$objResponse->addAssign("OBLI-txtDescCobrador", "value", @mysql_result($res,0,"ve_vendedor"));
	
		$objResponse->addAssign("txtObservacion", "value", $obs);
		
	}	
	
	$sql = "select mdet_ncorr, mdet_codigo, mdet_desc, mdet_nu, mdet_cantidad, mdet_stock_vend_n,mdet_stock_vend_u,mdet_stock_bod_n,mdet_stock_bod_u
			from orden_trabajo_detalle
			where movim_ncorr = '".$ncorr."'";
			
	$res = mysql_query($sql, $conexion) or die(mysql_error($conexion));
	
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
		$objResponse->addAssign("divresultadoarticulos", "innerHTML", $miSmarty->fetch('sg_orden_trabajo_ingreso_list.tpl'));
		
	}	
	
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
	
	$objResponse->addScript("xajax_CargaDesc(xajax.getFormValues('Form1'), 'tallasnew', 'ta_ncorr', 'ta_descripcion', 'OBLItxtCodProducto', 'OBLItxtDescProducto', '');");
	
	return $objResponse->getXML();
}

function BuscaCliente($data, $campo1, $campo2){
    global $conexion;
    $objResponse = new xajaxResponse('ISO-8859-1');
	
    $empresa 		= 	$data["OBLIcboEmpresa"];
    
	$sql = "select VE_VENDEDOR
		from clientes
		where VE_CODIGO = '".$data[$campo1]."'";
	$res = mysql_query($sql, $conexion) or die(mysql_error($conexion));
	$row = mysql_fetch_array($res);
	$objResponse->addAssign($campo2,'value',$row['VE_VENDEDOR']);

    return $objResponse->getXML();

	}
function CargaDesc($data, $tabla, $campo1, $campo2, $objeto1, $objeto2, $c_and){
    global $conexion;
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	//mysql_select_db("sgyonley", $conexion);
	
	$ncorr 			= 	$data["$objeto1"];
	$empresa 		= 	$data["OBLIcboEmpresa"];
	$vendedor 		= 	$data["OBLI-txtCodCobrador"];
	
	if ($tabla == 'tallasnew'){
		$sql = "select ta_ncorr, ta_codigo, ta_descripcion, ta_busqueda, ta_venta from tallasnew where $campo1 = '".$ncorr."'";
		$res = mysql_query($sql, $conexion) or die(mysql_error($conexion));
		$codigo = @mysql_result($res,0,"ta_codigo");
		
		$objResponse->addAssign("OBLItxtDescProducto", "value", @mysql_result($res,0,"ta_busqueda")." ".@mysql_result($res,0,"ta_descripcion"));
		
	
	}else{
		
		$sql = "select $campo2 as descripcion 
				from $tabla 
				where $campo1 = '".$ncorr."'  ";
		$objResponse->addAlert($sql);
		$res = mysql_query($sql, $conexion) or die(mysql_error($conexion));
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
	
	$sql = "delete from orden_trabajo_detalle where mdet_ncorr = '".$ncorr."'";
	$res = mysql_query($sql, $conexion) or die(mysql_error($conexion));
	
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
$xajax->registerFunction("BuscaCliente");

$xajax->processRequests();

$miSmarty->assign('ncorr',$_GET['ncorr']);
$miSmarty->assign('xajax_js', $xajax->getJavascript());

$miSmarty->display('sg_orden_trabajo_ingreso.tpl');
ob_flush();
?>

