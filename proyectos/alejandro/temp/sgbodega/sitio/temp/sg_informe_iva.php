<?php
session_start();

require_once 'includes/xajax/xajax.inc.php'; //archivo de configuracion de ajax
include "../includes/php/conf_smarty.php";//archivo de configuracion de smarty
include "../includes/php/conf_bd.php"; //archivo de coneccion al servidor y base de datos
//include "../includes/php/conf_bd_antigua.php"; //archivo de coneccion al servidor de yonley
include "../includes/php/validaciones.php"; 

$xajax = new xajax();

$xajax->setRequestURI("sg_informe_iva.php");
$xajax->setCharEncoding("ISO-8859-1");
$xajax->decodeUTF8InputOn();

function Grabar($data){
	global $conexion;
	global $miSmarty;
	
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	$empresa		= 	$data["OBLIempresa"];
	$mes			= 	$data["OBLIcboMes"];
	$anio			= 	$data['OBLIcboAnio'];
	
	$objResponse->addScript("document.getElementById('divlistado').style.display='none';");
	
	                
	if ($empresa != '- - Seleccione - -'){
		$and .= " and empresa = '".$empresa."' " ;
	}
	if ($mes != ''){
		$and_1 .= " and mes = '".$mes."' " ;
	}
	if ($anio != ''){
		$and_1 .= " and anio = '".$anio."' " ;
	}
	if (($mes!='')&&($anio != '')){
		$and_2 =" and fecha between '".$anio."-".$mes."-1' and '".$anio."-".$mes."-31'";
		}
    //facturas ventas, boletas    
	$sql_ab = "select sum(neto) as neto, sum(iva) as iva, sum(neto)+sum(iva) as total
                    from facturas
                    where tipo_factura = 'VENTAS'
					        ".$and." ".$and_2."";
    $res_ab = mysql_query($sql_ab, $conexion) or die(mysql_error());
	$row_ab	= mysql_fetch_array($res_ab);
	
	$neto_venta_f = $row_ab['neto'];
	$iva_venta_f  = $row_ab['iva'];
	$total_venta_f = $row_ab['total'];
	
	$sql_ab = "select COALESCE(sum(neto),0) as neto, COALESCE(sum(iva),0) as iva, COALESCE(sum(neto)+sum(iva),0) as total
				from notas_credito 
				where tipo_nc = 'VENTAS'
						".$and." ".$and_2."";
	$res_ab = mysql_query($sql_ab, $conexion) or die(mysql_error());
	$row_ab	= mysql_fetch_array($res_ab);
	
	$neto_credito_venta = $row_ab['neto'];
	$iva_credito_venta  = $row_ab['iva'];
	$total_credito_venta = $row_ab['total'];

	$miSmarty->assign("neto_credito_venta", $neto_credito_venta);
	$miSmarty->assign("iva_credito_venta", $iva_credito_venta);
	$miSmarty->assign("total_credito_venta", $total_credito_venta);
	
	$sql_ab = "select COALESCE(sum(neto),0) as neto, COALESCE(sum(iva),0) as iva, COALESCE(sum(neto)+sum(iva),0) as total
				from notas_debito
				where tipo_nd = 'VENTAS'
						".$and." ".$and_2."";
	$res_ab = mysql_query($sql_ab, $conexion) or die(mysql_error());
	$row_ab	= mysql_fetch_array($res_ab);
	
	$neto_debito_venta = $row_ab['neto'];
	$iva_debito_venta  = $row_ab['iva'];
	$total_debito_venta = $row_ab['total'];

	$miSmarty->assign("neto_debito_venta", $neto_debito_venta);
	$miSmarty->assign("iva_debito_venta", $iva_debito_venta);
	$miSmarty->assign("total_debito_venta", $total_debito_venta);
	
	$sql_ab = "select sum(monto) as monto
				from boletas 
				where 1
						".$and." ".$and_2."";
	$res_ab = mysql_query($sql_ab, $conexion) or die(mysql_error());
	$row_ab	= mysql_fetch_array($res_ab);
	
	$neto_venta_b = $row_ab['monto']/1.19;
	$iva_venta_b = $row_ab['monto'] -  $row_ab['monto']/1.19;
	$total_venta_b = $row_ab['monto'];
	
	$neto_venta = $neto_venta_f+$neto_venta_b-$neto_credito_venta+$neto_debito_venta;
	$iva_venta = $iva_venta_f+$iva_venta_b-$iva_credito_venta+$iva_debito_venta;
	$total_venta = $total_venta_f+$total_venta_b-$total_credito_venta+$total_debito_venta;
	
	$miSmarty->assign("neto_venta", $neto_venta);
	$miSmarty->assign("iva_venta", $iva_venta);
	$miSmarty->assign("total_venta", $total_venta);
	
	//facturas compra  
	$sql_ab = "select COALESCE(sum(neto),0) as neto, COALESCE(sum(iva),0) as iva, COALESCE(sum(neto)+sum(iva),0) as total
                    from facturas
						inner join facturas_periodo
							on facturas.factura_ncorr = facturas_periodo.nro_factura
                    where tipo_factura = 'COMPRAS' and estado_factura='afecta'
					        ".$and." ".$and_1."";
    $res_ab = mysql_query($sql_ab, $conexion) or die(mysql_error()); 
	$row_ab	= mysql_fetch_array($res_ab);

	$neto_compra = $row_ab['neto'];
	$iva_compra  = $row_ab['iva'];
	$total_compra = $row_ab['total'];

	$miSmarty->assign("neto_compra", $neto_compra);
	$miSmarty->assign("iva_compra_1", $iva_compra);
	$miSmarty->assign("total_compra_1", $total_compra);
	
	$sql_ab = "select COALESCE(sum(neto),0) as neto, COALESCE(sum(iva),0) as iva, COALESCE(sum(neto)+sum(iva),0) as total
				from notas_credito 
					inner join nc_periodo
							on notas_credito.nc_ncorr = nc_periodo.nro_nota_credito
				where tipo_nc = 'COMPRAS'
						".$and." ".$and_1."";
	$res_ab = mysql_query($sql_ab, $conexion) or die(mysql_error());
	$row_ab	= mysql_fetch_array($res_ab);
	
	$neto_credito_compra = $row_ab['neto'];
	$iva_credito_compra  = $row_ab['iva'];
	$total_credito_compra = $row_ab['total'];

	$miSmarty->assign("neto_credito_compra", $neto_credito_compra);
	$miSmarty->assign("iva_credito_compra", $iva_credito_compra);
	$miSmarty->assign("total_credito_compra", $total_credito_compra);
	
	$sql_ab = "select COALESCE(sum(neto),0) as neto, COALESCE(sum(iva),0) as iva, COALESCE(sum(neto)+sum(iva),0) as total
				from notas_debito
					inner join nd_periodo
							on notas_debito.nd_ncorr = nd_periodo.nro_nota_debito
				where tipo_nd = 'COMPRAS'
						".$and." ".$and_2."";
	$res_ab = mysql_query($sql_ab, $conexion) or die(mysql_error());
	$row_ab	= mysql_fetch_array($res_ab);
	
	$neto_debito_compra = $row_ab['neto'];
	$iva_debito_compra  = $row_ab['iva'];
	$total_debito_compra = $row_ab['total'];

	$miSmarty->assign("neto_debito_compra", $neto_debito_compra);
	$miSmarty->assign("iva_debito_compra", $iva_debito_compra);
	$miSmarty->assign("total_debito_compra", $total_debito_compra);
	
	$sql_ab = "select COALESCE(sum(neto),0) as neto, COALESCE(sum(iva),0) as iva, COALESCE(sum(neto)+sum(iva),0) as total
                    from facturas
						inner join facturas_periodo
							on facturas.factura_ncorr = facturas_periodo.nro_factura
                    where tipo_factura = 'COMPRAS' and estado_factura='exenta'
					        ".$and." ".$and_1."";
	$res_ab = mysql_query($sql_ab, $conexion) or die(mysql_error()); 
	$row_ab	= mysql_fetch_array($res_ab);
	$exento_compra  = $row_ab['total'];
	$total_compra_ex = $row_ab['total'];
	
	$neto_compra_total = $neto_compra-$neto_credito_compra+$neto_debito_compra;
	$iva_compra_total = $iva_compra-$iva_credito_compra+$iva_debito_compra;
	$total_compra_total = $total_compra-$total_credito_compra+$total_debito_compra+$exento_compra;
	
	$miSmarty->assign("iva_compra", $iva_compra_total);
	$miSmarty->assign("exento_compra", $exento_compra);
	$miSmarty->assign("total_compra", $total_compra_total);
	
	$iva_resultado = $iva_venta - $iva_compra_total;
	
	$miSmarty->assign("iva_resultado",  $iva_resultado);
	//boletas de honorarios
	$sql_ab = "select COALESCE(sum(neto),0) as neto, COALESCE(sum(retencion),0) as iva, COALESCE(sum(neto)+sum(retencion),0) as total
                    from boletas_honorarios
                    where 1 
					        ".$and." ".$and_2."";
    $res_ab = mysql_query($sql_ab, $conexion) or die(mysql_error());
	$row_ab	= mysql_fetch_array($res_ab);
	$total_bh = $row_ab['iva'];
	$miSmarty->assign("total_bh", $total_bh);
	
	$sql_ab = "select monto
                    from ppm
                    where 1 
					        ".$and." ".$and_1."";
    $res_ab = mysql_query($sql_ab, $conexion) or die(mysql_error());
	$row_ab	= mysql_fetch_array($res_ab);
	$porcentaje_ppm = $row_ab['monto'];
	$miSmarty->assign("porcentaje_ppm", $porcentaje_ppm);

	
	
	
	
	$objResponse->addAssign("divabonos", "innerHTML", $miSmarty->fetch('sg_informe_iva_list.tpl'));
	
	$objResponse->addScript("document.getElementById('divlistado').style.display='block';");
		
	return $objResponse->getXML();
}

function Ordenar($data, $campo){
	global $conexion;
	global $miSmarty;
	
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	$orden_asc 	= 'ASC';
	$orden_desc = 'DESC';
	if ($_SESSION["alycar_orden"] == $campo.$orden_asc){
		$campo_orden 		= 	$campo.$orden_desc;
		$direccion_orden	=	$orden_desc;
	}else{
		$campo_orden 		= 	$campo.$orden_asc;
		$direccion_orden	=	$orden_asc;
	}		
	
	$arrRegistros = array();
	$arrRegistros = ordenar_matriz_multidimensionada($_SESSION["alycar_matriz"],$campo,$direccion_orden);
	$_SESSION["alycar_orden"] = $campo_orden;
	
	$_SESSION["alycar_matriz"] = $arrRegistros;
	
	$miSmarty->assign('arrRegistros', $arrRegistros);
	$objResponse->addAssign("divabonos", "innerHTML", $miSmarty->fetch('sg_informe_iva_list.tpl'));
	
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
	$ncorr_1 	= 	$data["$objeto2"];

        $sql = "select $campo1 as rut, $campo2 as descripcion from $tabla where $campo1 = '".$ncorr."' or $campo2 = '".$ncorr_1."'  ";
	
        $res = mysql_query($sql, $conexion);
	
	$objResponse->addAssign("$objeto1", "value", @mysql_result($res,0,"rut"));
	$objResponse->addAssign("$objeto2", "value", @mysql_result($res,0,"descripcion"));
	return $objResponse->getXML();
}
function CargaSelect($data, $select, $tabla, $codigo, $descripcion, $campo1, $campo2, $opt){
    global $conexion;
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	$objResponse->addAssign("$select","innerHTML",""); 		
	
        $sql = "select $campo1 as codigo, $campo2 as descripcion from $tabla $opt";
	$res = mysql_query($sql, $conexion);
	
        
	if (@mysql_num_rows($res) > 0) {
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

function Imprime(){
    global $conexion;
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	$objResponse->addScript("ImprimeDiv('divabonos');");
	
	return $objResponse->getXML();
}
function Eliminar($data,$ncorr){
    global $conexion;
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	$sql ="delete from boletas where boleta_ncorr = ".$ncorr;
	$res = mysql_query($sql,$conexion);
	
		$objResponse->addScript("alert('Registro Eliminado')");
		$objResponse->addScript("document.Form1.submit();");
	
	return $objResponse->getXML();
}
function CargaPagina($data){
    global $conexion;
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	// carga empresas
	$objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'OBLIempresa','sgyonley.empresas','','- - Seleccione - -','empe_rut','empe_desc', 'order by empe_rut desc')");
		
	return $objResponse->getXML();
}  
$xajax->registerFunction("MuestraRegistro");
$xajax->registerFunction("CargaPagina");
$xajax->registerFunction("CargaDesc");
$xajax->registerFunction("CargaSelect");
$xajax->registerFunction("Grabar");
$xajax->registerFunction("Eliminar");
$xajax->registerFunction("Ordenar");
$xajax->registerFunction("Imprime");

$xajax->processRequests();
$miSmarty->assign('xajax_js', $xajax->getJavascript());

$miSmarty->assign('COD_VENDEDOR', $_GET["cod_vendedor"]);
$miSmarty->assign('VENDEDOR', $_GET["nombre_vendedor"]);
$miSmarty->assign('DESDE', $_GET["desde"]);
$miSmarty->assign('HASTA', $_GET["hasta"]);

$miSmarty->display('sg_informe_iva.tpl');

?>

