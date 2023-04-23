<?php
session_set_cookie_params('18000'); // 5 HORAS
session_start();

require_once 'includes/xajax/xajax.inc.php'; //archivo de configuracion de ajax
include "../includes/php/conf_smarty.php";//archivo de configuracion de smarty
include "../includes/php/conf_bd.php"; //archivo de coneccion al servidor y base de datos
//include "../includes/php/conf_bd_antigua.php"; //archivo de coneccion al servidor de yonley
include "../includes/php/validaciones.php"; 

$xajax = new xajax();

$xajax->setRequestURI("sg_bodega_consulta_movimientos.php");
$xajax->setCharEncoding("ISO-8859-1");
$xajax->decodeUTF8InputOn();

function Grabar($data){
	global $conexion;
	global $miSmarty;
	
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	$fecha_desde		= 	$data["OBLI-txtFechaDesde"];
	$fecha_hasta		= 	$data["OBLI-txtFechaHasta"];
	$movim_tipo			= 	$data["cboMovimiento"];
	
	$objResponse->addScript("document.getElementById('divlistado').style.display='none';");
	
	list($dia1,$mes1,$anio1) = split('[/.-]', $fecha_desde);$fecha1 	= $anio1."-".$mes1."-".$dia1;
	list($dia2,$mes2,$anio2) = split('[/.-]', $fecha_hasta);$fecha2 	= $anio2."-".$mes2."-".$dia2;

	$movimiento = 'Todos';
	
	if (($movim_tipo != '') && ($movim_tipo != 'Todos')){
		if ($movim_tipo != '5'){
			$and = " and a.movim_tipo = '".$movim_tipo."'";
			//busca el movimiento    
			$sql_m = "select tmov_desc from tipos_movim where tmov_ncorr = '".$movim_tipo."'";
			$res_m = mysql_query($sql_m, $conexion);
			$movimiento = @mysql_result($res_m,0,"tmov_desc");
		}else{
			$and = " and a.movim_tipo = '".$movim_tipo."'";
			$movimiento = "Aumento Por Devolucion de Cliente";
		}
	}
		
	$sql = "select
				a.movim_ncorr as guia,
				b.tmov_desc as movimiento,
				DATE_FORMAT(a.movim_fecha,'%d/%m/%Y') as fecha,
				a.movim_obs as obs,
				DATE_FORMAT(a.movim_fecha_dig,'%d/%m/%Y %T') as fecha_dig,
				a.usu_id as usuario
				
				from sgbodega.movim a, sgyonley.tipos_movim b
					
				where
				a.movim_fecha >= '".$fecha1."' and a.movim_fecha <= '".$fecha2."' and
				a.movim_estado = 'FINALIZADO' and
				a.movim_tipo = b.tmov_ncorr $and order by a.movim_fecha asc, a.movim_ncorr asc";
	
	$res = mysql_query($sql, $conexion);
	
	$arrRegistros	= 	array();
	$i = 1;
	$encontro = 'NO';
	
	if (mysql_num_rows($res) > 0){
		$encontro = 'SI';
		while ($line = mysql_fetch_row($res)) {
			
			// muestra el regitro solo si tiene articulos
			
			array_push($arrRegistros, array("item"			=>	$i,
											"guia" 			=> 	$line[0],
											"movimiento" 	=> 	$line[1],
											"fecha" 		=> 	$line[2],
											"obs" 			=> 	$line[3],
											"fecha_dig" 	=> 	$line[4],
											"usuario" 		=> 	$line[5]));
		
			$i++;
		}
	}
	
	if (($movim_tipo == '') OR ($movim_tipo == 'Todos') OR ($movim_tipo == '5')){
		// busca los movimientos por devoluciones 
		$sql_ve = "select 
					a.gd_guia as guia,
					concat('Aumento Por Devolucion de Cliente') as movim,
					DATE_FORMAT(a.gd_fecha,'%d/%m/%Y') as fecha,
					concat('MOVIMIENTO REALIZADO POR EXISTENCIA') as obs,
					DATE_FORMAT(a.gd_fechadig,'%d/%m/%Y %H:%i:%s') as fecha_dig,
					a.gd_usuario as usuario
					
					from d_guiadev a, sub_guiadev b
					
					where
					a.gd_fecha >= '".$fecha1."' and a.gd_fecha <= '".$fecha2."' and
					a.gd_usuario != '' and
					a.gd_guia = b.sv_guiadv and
					b.sv_conf_bodega = 'SI'
					
					group by a.gd_guia order by a.gd_fecha";
		
		$res_ve = mysql_query($sql_ve, $conexion);
		if (mysql_num_rows($res_ve) > 0){
			$encontro = 'SI';
			while ($line_ve = mysql_fetch_row($res_ve)) {
				array_push($arrRegistros, array("item"			=>	$i,
												"guia" 			=> 	$line_ve[0],
												"movimiento" 	=> 	$line_ve[1],
												"fecha" 		=> 	$line_ve[2],
												"obs" 			=> 	$line_ve[3],
												"fecha_dig" 	=> 	$line_ve[4],
												"usuario" 		=> 	$line_ve[5]));
			
				$i++;
			}
		}
	}	
	
	$miSmarty->assign('DESDE', $fecha_desde);
	$miSmarty->assign('HASTA', $fecha_hasta);
	$miSmarty->assign('MOVIMIENTO', $movimiento);
	$miSmarty->assign('TOTAL_MOVIM', $i - 1);
	$miSmarty->assign('arrRegistros', $arrRegistros);
	
	if ($encontro == 'SI'){
		$objResponse->addAssign("divabonos", "innerHTML", $miSmarty->fetch('sg_bodega_consulta_movimientos_list.tpl'));
	}else{
		$objResponse->addAssign("divabonos", "innerHTML", "No Existen Registros");
	}
	
	$objResponse->addScript("document.getElementById('divlistado').style.display='block';");
	
	
	return $objResponse->getXML();
}

function CargaPagina($data){
    global $conexion;
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	//  carga tipos de movimientos
	$objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'cboMovimiento','tipos_movim','','Todos','tmov_ncorr', 'tmov_desc')");
	
	$objResponse->addScript("document.getElementById('OBLI-txtFechaDesde').focus();");

	return $objResponse->getXML();
}          
function CargaSelect($data, $select, $tabla, $codigo, $descripcion, $campo1, $campo2){
    global $conexion;	
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	$objResponse->addAssign("$select","innerHTML",""); 		
	$sql = "select $campo1 as codigo, $campo2 as descripcion from $tabla ORDER BY $campo1 ASC";
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

$xajax->registerFunction("CargaPagina");
$xajax->registerFunction("CargaSelect");
$xajax->registerFunction("Grabar");

$xajax->processRequests();
$miSmarty->assign('xajax_js', $xajax->getJavascript());

$miSmarty->assign('COD_VENDEDOR', $_GET["cod_vendedor"]);
$miSmarty->assign('VENDEDOR', $_GET["nombre_vendedor"]);
$miSmarty->assign('DESDE', $_GET["desde"]);
$miSmarty->assign('HASTA', $_GET["hasta"]);

$miSmarty->display('sg_bodega_consulta_movimientos.tpl');

?>

