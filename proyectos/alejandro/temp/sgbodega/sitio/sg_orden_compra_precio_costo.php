<?php	
session_start();

require_once 'includes/xajax/xajax.inc.php'; //archivo de configuracion de ajax
include "../includes/php/conf_smarty.php";//archivo de configuracion de smarty
include "../includes/php/conf_bd.php"; //archivo de coneccion al servidor y base de datos
//include "../includes/php/conf_bd_antigua.php"; //archivo de coneccion al servidor de yonley
//include "../includes/php/sgbodega.php"; 
include "../includes/php/validaciones.php"; 

$xajax = new xajax();

$xajax->setRequestURI("sg_orden_compra_precio_costo.php");
$xajax->setCharEncoding("ISO-8859-1");
$xajax->decodeUTF8InputOn();

function Grabar($data){
	global $conexion;
	
    $objResponse = new xajaxResponse('ISO-8859-1');
	
		$codigo					= 	$data['txtCodProducto'];
		$precio_nuevo			= 	$data['precio_nuevo'];
		$precio_usado			= 	$data['precio_usado'];

    //grabar en el mantenedor tallasnew

    	$sql = "update sgbodega.tallasnew
    				set TA_COSTO_NUEVO = '".$precio_nuevo."',
    					TA_COSTO_USADO = '".$precio_usado."'
    			where TA_NCORR = '".$codigo."'";
    	$res = mysql_query($sql,$conexion);

    //grabar en el historial de producto

    	$sql = "select concat(ta_busqueda,' ',ta_descripcion) as descripcion 
    			from sgbodega.tallasnew
    			where TA_NCORR = '".$codigo."'";
    	$res = mysql_query($sql,$conexion);
    	$row = mysql_fetch_array($res);

    	$descripcion = $row['descripcion'];

    	$sql = "INSERT INTO `precio_costo_nuevo`(`codigo`, `descr`, `precio_neto`, `usuario`, `fecha_dig`) 
    			VALUES ('".$codigo."','".$descripcion."','".$precio_nuevo."','".$_SESSION['alycar_usuario']."','".date("Y-m-d H:i:s")."')";
    	$res = mysql_query($sql,$conexion);
    	
		$sql = "INSERT INTO `precio_costo_usado`(`codigo`, `descr`, `precio_neto`, `usuario`, `fecha_dig`) 
    			VALUES ('".$codigo."','".$descripcion."','".$precio_usado."','".$_SESSION['alycar_usuario']."','".date("Y-m-d H:i:s")."')";
    	$res = mysql_query($sql,$conexion);
    	
    	$objResponse->addAlert("Precio Costo Cambiado.");

		$nro_oc					= 	$data['nro_oc'];
		$fecha_cant_rec			= 	$data['fecha_cant_rec'];
		$factura				= 	$data['factura'];
		$guia_despacho			= 	$data['guia_despacho'];
		$OBLItxtCodVendedor		= 	$data['OBLItxtCodVendedor'];
		$OBLItxtDescVendedor	= 	$data['OBLItxtDescVendedor'];

		$obj1 	= 	$data['precio_nuevo'];
		$obj2 	= 	$data['cantidad'];
		
	
		//$objResponse->addScript("window.parent.xajax_MuestraRegistro(xajax.getFormValues('Form1'), 'txtNeto', '$obj1', 'txtCant', '$obj2')");
		

		$objResponse->addScript("window.parent.xajax_MuestraRegistro_1(xajax.getFormValues('Form1'),'".$codigo."' ,'".$descripcion."' ,'".$data['precio_nuevo']."')");
		
		//txtCodProducto
		//txtDescProducto
		//txtNeto
		
		$objResponse->addScript("window.parent.hidePopWin(true)");
		$objResponse->addScript("window.parent.getElementById('txtCant').focus()");
	
		//$objResponse->addScript("location.href='sg_orden_compra_detalle.php?nro_oc=".$nro_oc."&fecha_cant_rec=".$fecha_cant_rec."&factura=".$factura."&guia_despacho=".$guia_despacho."&OBLItxtCodVendedor=".$OBLItxtCodVendedor."&OBLItxtDescVendedor=".$OBLItxtDescVendedor."'");
	
	return $objResponse->getXML();
	}
	

function CargaPagina($data){
    global $conexion;
    global $miSmarty;

    $objResponse = new xajaxResponse('ISO-8859-1');
	
		$arrpcn 			= array();
		$arrpcu	 			= array();
		
		$codigo				= 	$data['txtCodProducto'];
		
   		$sql = "select * from sgbodega.tallasnew where TA_NCORR = '".$codigo."'";
    	$res = mysql_query($sql,$conexion);
    	$row = mysql_fetch_array($res);

    	$descripcion = $row['TA_BUSQUEDA'].' '.$row['TA_DESCRIPCION'];
    	$precio_nuevo = $row['TA_COSTO_NUEVO'];
		$precio_usado = $row['TA_COSTO_USADO'];
		$TA_FAMILIA = $row['TA_FAMILIA'];
		$TA_SUBFAMILIA = $row['TA_SUBFAMILIA'];

		$sql = "select * 
				from sgbodega.porcentaje_familias_subfamilias 
				where fam = '".$TA_FAMILIA."' and 
					subfam = '".$TA_SUBFAMILIA."'";
    	$res = mysql_query($sql,$conexion);
    	$row = mysql_fetch_array($res);

    	

		$objResponse->addAssign('txtCodProducto','value',$codigo);
		$objResponse->addAssign('txtDescProducto','value',$descripcion);
		$objResponse->addAssign('precio_actual_nuevo','value',$precio_nuevo);
		$objResponse->addAssign('precio_actual_usado','value',$precio_usado);		

		$sql = "select `codigo`, `descr`, `precio_neto`, `usuario`, `fecha_dig`
				from `precio_costo_nuevo`
				where codigo = '".$codigo."'";
		$res = mysql_query($sql,$conexion);
		while($row = mysql_fetch_array($res)){
			array_push($arrpcn, array("codigo"			=>	$row['codigo'],
										"descr"         	=> 	$row['descr'],
										"precio_neto"       => 	$row['precio_neto'],
										"usuario"         	=> 	$row['usuario'],
										"fecha_dig"         => 	$row['fecha_dig']));

			}

		$sql = "select `codigo`, `descr`, `precio_neto`, `usuario`, `fecha_dig`
				from `precio_costo_usado`
				where codigo = '".$codigo."'";
		$res = mysql_query($sql,$conexion);
		while($row = mysql_fetch_array($res)){
			array_push($arrpcu, array("codigo"			=>	$row['codigo'],
										"descr"         	=> 	$row['descr'],
										"precio_neto"       => 	$row['precio_neto'],
										"usuario"         	=> 	$row['usuario'],
										"fecha_dig"         => 	$row['fecha_dig']));

			}

		$miSmarty->assign('arrpcn', $arrpcn);
		$miSmarty->assign('arrpcu', $arrpcu);
		
		$objResponse->addAssign("divabonos", "innerHTML", $miSmarty->fetch('sg_orden_compra_precio_costo_list.tpl'));
	

	return $objResponse->getXML();
	}

function Volver($data){
    global $conexion;
    $objResponse = new xajaxResponse('ISO-8859-1');
	
		$nro_oc					= 	$data['nro_oc'];
		$fecha_cant_rec			= 	$data['fecha_cant_rec'];
		$factura				= 	$data['factura'];
		$guia_despacho			= 	$data['guia_despacho'];
		$OBLItxtCodVendedor		= 	$data['OBLItxtCodVendedor'];
		$OBLItxtDescVendedor	= 	$data['OBLItxtDescVendedor'];
		$objResponse->addScript("location.href='sg_orden_compra_detalle.php?nro_oc=".$nro_oc."&fecha_cant_rec=".$fecha_cant_rec."&factura=".$factura."&guia_despacho=".$guia_despacho."&OBLItxtCodVendedor=".$OBLItxtCodVendedor."&OBLItxtDescVendedor=".$OBLItxtDescVendedor."'");
	
	return $objResponse->getXML();
	}

function CargaDesc($data, $tabla, $campo1, $campo2, $objeto1, $objeto2, $c_and){
    global $conexion;
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	$ncorr 		= 	$data["$objeto1"];
	
	if ($tabla == 'sgbodega.tallas'){
		$sql = "select ta_ncorr, ta_descripcion, ta_busqueda, ta_venta, ta_venta2 from sgbodega.tallasnew where $campo1 = '".$ncorr."'";
		$res = mysql_query($sql, $conexion);
		
		$objResponse->addAssign("txtDescProducto", "value", @mysql_result($res,0,"ta_busqueda")." ".@mysql_result($res,0,"ta_descripcion"));
		
	}else{
		$sql = "select $campo2 as descripcion from $tabla where $campo1 = '".$ncorr."' $and";
		$res = mysql_query($sql, $conexion);
		$objResponse->addAssign("$objeto2", "value", @mysql_result($res,0,"descripcion"));
	}	
	$sql_detalle = "select *
					from sgcompras.oc_tiene_detalle
					where orden_compra_ncorr = '".$c_and."'
						and producto = '".$ncorr."'";
	$res_detalle = mysql_query($sql_detalle,$conexion) or die(mysql_error());
	$row_detalle = mysql_fetch_array($res_detalle);
	$objResponse->addAssign("precio", "value", $row_detalle['precio']);
	
	
	return $objResponse->getXML();
	}

function CalcularPrecioUsado($data){
    global $conexion;
    $objResponse = new xajaxResponse('ISO-8859-1');
	

	$codigo					= 	$data['txtCodProducto'];
		
   		$sql = "select * from sgbodega.tallasnew where TA_NCORR = '".$codigo."'";
    	$res = mysql_query($sql,$conexion);
    	$row = mysql_fetch_array($res);

    	$TA_FAMILIA = $row['TA_FAMILIA'];
		$TA_SUBFAMILIA = $row['TA_SUBFAMILIA'];

		$sql = "select porc
				from sgbodega.porcentaje_familias_subfamilias 
				where fam = '".$TA_FAMILIA."' and 
					subfam = '".$TA_SUBFAMILIA."'";
    	$res = mysql_query($sql,$conexion);
    	$row = mysql_fetch_array($res);
		$porc = $row['porc'];

    	$precio_nuevo = $data['precio_nuevo'];

    	$precio_usado = $precio_nuevo - round($precio_nuevo * $porc);

    $objResponse->addAlert("Recuerde editar el monto usado");
	$objResponse->addAssign("precio_usado", "value", $precio_usado);
	
	return $objResponse->getXML();
	}


$xajax->registerFunction("Grabar");
$xajax->registerFunction("CargaDesc");
$xajax->registerFunction("CargaPagina");
$xajax->registerFunction("Volver");
$xajax->registerFunction("CalcularPrecioUsado");

$xajax->processRequests();
$miSmarty->assign('xajax_js', $xajax->getJavascript());

$miSmarty->assign('nro_oc',$_GET['nro_oc']);
$miSmarty->assign('codigo',$_GET['codigo']);
$miSmarty->assign('cantidad',$_GET['cantidad']);

if (isset($_POST['fecha_cant_rec'])){
	$miSmarty->assign('fecha_cant_rec',$_POST['fecha_cant_rec']);
	}
else{
	$miSmarty->assign('fecha_cant_rec',$_GET['fecha_cant_rec']);
	}

if (isset($_POST['factura'])){
	$miSmarty->assign('factura',$_POST['factura']);
	}
else{
	$miSmarty->assign('factura',$_GET['factura']);
	}

if (isset($_POST['guia_despacho'])){
	$miSmarty->assign('guia_despacho',$_POST['guia_despacho']);
	}
else{
	$miSmarty->assign('guia_despacho',$_GET['guia_despacho']);
	}

if (isset($_POST['OBLItxtCodVendedor'])){
	$miSmarty->assign('OBLItxtCodVendedor',$_POST['OBLItxtCodVendedor']);
	}
else{
	$miSmarty->assign('OBLItxtCodVendedor',$_GET['OBLItxtCodVendedor']);
	}

if (isset($_POST['OBLItxtDescVendedor'])){
	$miSmarty->assign('OBLItxtDescVendedor',$_POST['OBLItxtDescVendedor']);
	}
else{
	$miSmarty->assign('OBLItxtDescVendedor',$_GET['OBLItxtDescVendedor']);
	}

$miSmarty->display('sg_orden_compra_precio_costo.tpl');

?>

