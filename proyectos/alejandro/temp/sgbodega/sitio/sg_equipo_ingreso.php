<?php
session_start();

require_once 'includes/xajax/xajax.inc.php'; //archivo de configuracion de ajax
include "../includes/php/conf_smarty.php";//archivo de configuracion de smarty
include "../includes/php/conf_bd.php"; //archivo de coneccion al servidor y base de datos
//include "../includes/php/conf_bd_antigua.php"; //archivo de coneccion al servidor de yonley
include "../includes/php/validaciones.php"; 

$xajax = new xajax();

$xajax->setRequestURI("sg_equipo_ingreso.php");
$xajax->setCharEncoding("ISO-8859-1");
$xajax->decodeUTF8InputOn();

function BuscarFolio($data){
	global $conexion;
	global $miSmarty;
	
    $objResponse = new xajaxResponse('ISO-8859-1');
		
	$folio			= 	$data["folio"];
	// busca los productos
	$sql_pd = "select
				vdet_ncorr as ncorr,
				arti_codigo_largo as codigo,
				arti_desc as descripcion,
				arti_nu as nu,
				sum(vent_cant) as cantidad,
				vent_valor_venta as precio,
				sum(vent_sub_total) as total,
				vent_ncorr as folio
			
				FROM 
				sgyonley.ventas_detalle_antigua
			
				WHERE
				vent_ncorr = '".$folio."'
				
				group by vent_ncorr, arti_codigo_largo";
	
	$res_pd = mysql_query($sql_pd, $conexion);
	$i = 1;
	$arrProductos = array();
	while ($line_pd = mysql_fetch_row($res_pd)) {
		
		$cantidad 		= $line_pd[4];
		$precio 		= $line_pd[5];
		$total_pd 		= $line_pd[6];
		
		// verifica las devoluciones.
		$sql_dev = "select sum(sv_cantidad) as cantidad, sv_folio, sv_codbus from sub_guiadev where sv_folio = '".$folio."' and sv_codbus = '".$line_pd[1]."'
					group by sv_folio, sv_codbus";
		
		$res_dev = mysql_query($sql_dev, $conexion);
		$can_dev = @mysql_result($res_dev, 0, "cantidad");
		
		if ($can_dev > 0){
			$cantidad = $cantidad - $can_dev;
			$total_pd = $cantidad * $precio;
		}
		
		//$objResponse->addScript("alert('$cantidad $can_dev')");
		
		if ($cantidad > 0){
			array_push($arrProductos, array("ncorr"			=> 	$line_pd[0],
											"item"			=>	$i,
											"codigo" 		=> 	$line_pd[1],
											"descripcion" 	=> 	$line_pd[2],
											"nu" 			=> 	$line_pd[3],
											"cantidad"		=> 	$cantidad));
			
			$i++;
		}
	}
	$objResponse->addScript("document.getElementById('divlistado').style.display='block';");
	$objResponse->addScript("document.getElementById('divcontenedor_detalle').style.display='block';");
	$miSmarty->assign('arrProductos', $arrProductos);
	$objResponse->addAssign("divproductos", "innerHTML", $miSmarty->fetch('sg_equipo_ingreso_list.tpl'));
	
	return $objResponse->getXML();
}

function GrabarLinea($data,$ncorr,$codigo,$cantidad){
	global $conexion;
	
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	$cod_equipo = $codigo;
	
	$sql_producto = "SELECT concat(TA_BUSQUEDA,' ',TA_DESCRIPCION) as nombre
					 FROM  sgbodega.tallasnew
					 where TA_NCORR = '".$cod_equipo."'";
	$res_producto = mysql_query($sql_producto,$conexion);
	$row_producto = mysql_fetch_array($res_producto);
	$nombre_producto = $row_producto['nombre'];
		
	$objResponse->addAssign("OBLIcodproducto", "value", $cod_equipo);
	$objResponse->addAssign("OBLItxtproducto", "value", $nombre_producto);
	$objResponse->addAssign("OBLItxtcantidad", "value", $cantidad 	);
	
	return $objResponse->getXML();
	}

function Grabar($data){
	global $conexion;
    $objResponse = new xajaxResponse('ISO-8859-1');

	$folio = $data['folio'];
	$fecha_ingreso_bodega = $data['OBLItxtFechaRevision'];
	$producto = $data['OBLIcodproducto'];
	$detalle  = $data['OBLItxtproducto'];
	$cantidad = $data['OBLItxtcantidad'];
	
	if ($producto!=''){
		list($dia1,$mes1,$anio1) = split('[/.-]', $fecha_ingreso_bodega);$fecha_ingreso_bodega 	= $anio1."-".$mes1."-".$dia1;
		
		$sql_001 = "insert into sgcompras.servicio_tecnico (folio,fecha_ingreso_bodega,fecha_digitacion,usuario_digitacion, estado)
						values('".$folio."','".$fecha_ingreso_bodega."','".date('Y-m-d H:i:s')."', '".$_SESSION['alycar_usuario']."','1')";
		$res_001 = mysql_query($sql_001,$conexion);
		$id = mysql_insert_id();
		
		$sql_001 = "insert into sgcompras.st_equipos (st_ncorr,cod_equipo,cantidad)
						values('".$id."','".$producto."','".$cantidad."')";
		$res_001 = mysql_query($sql_001,$conexion);
		
		$movim_bodega 		=	$_SESSION['alycar_sgyonley_bodega'];
		$sql = "insert into sgcompras.movim (movim_bodega,movim_tipo,movim_fecha,vend_ncorr,movim_obs,usu_id)
				values (
				'".$movim_bodega."','1','".$fecha_ingreso_bodega."','".$movim_obs."','".$_SESSION['alycar_usuario']."')";
		$res = mysql_query($sql, $conexion);
		
		$ncorr = mysql_insert_id($conexion); //mysql_insert_id($conexion);
			
		$sql_det = "insert into sgcompras.movim_detalle (movim_ncorr,mdet_codigo,mdet_desc,mdet_cantidad) 
					
					values ('".$movim_ncorr."','".$producto."','".$detalle."','".$cantidad."')";
		$res_det = mysql_query($sql_det, $conexion);
		
		
		$objResponse->addAlert("Servicio Tecnico grabado correctamente");
		$objResponse->addScript("window.document.Form1.submit();");
		}
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
	$objResponse->addAssign("divabonos", "innerHTML", $miSmarty->fetch('sg_informe_boletas_list.tpl'));
	
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
$xajax->registerFunction("BuscarFolio");
$xajax->registerFunction("GrabarLinea");
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

$miSmarty->display('sg_equipo_ingreso.tpl');

?>

