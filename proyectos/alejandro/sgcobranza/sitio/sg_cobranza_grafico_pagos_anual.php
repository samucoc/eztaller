<?php

ob_start();

session_start();



require_once 'includes/xajax/xajax.inc.php'; //archivo de configuracion de ajax

include "../includes/php/conf_smarty.php";//archivo de configuracion de smarty

include "../includes/php/conf_bd.php"; //archivo de coneccion al servidor y base de datos

//include "../includes/php/conf_bd_antigua.php"; //archivo de coneccion al servidor de yonley

include "../includes/php/validaciones.php"; 

/*

include "../includes/php/class.phpmailer.php";

include "../includes/php/class.pop3.php";

include "../includes/php/class.smtp.php";

include "../includes/php/PHPExcel.php";

include "../includes/php/PHPExcel/Reader/Excel2007.php";

*/

$xajax = new xajax();



$xajax->setRequestURI("sg_cobranza_grafico_pagos_anual.php");

$xajax->setCharEncoding("UTF8");

$xajax->decodeUTF8InputOn();



function CargaListado($data){

    global $conexion;

    global $miSmarty;

	$objResponse = new xajaxResponse('UTF8');



	$objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'anio','gescolcl_arcoiris_administracion.Periodos','','','distinct AnoAcademico','AnoAcademico', '')");



	return $objResponse->getXML();

}          



function CargaSelect($data, $select, $tabla, $codigo, $descripcion, $campo1, $campo2, $opt){

    global $conexion;

    $objResponse = new xajaxResponse('UTF8');

	

	$objResponse->addAssign("$select","innerHTML",""); 		

	

    $sql = "select $campo1 as codigo, $campo2 as descripcion from $tabla $opt";

    $res = mysql_query($sql, $conexion);

	

	if (@mysql_num_rows($res) > 0) {

                $j=0;

                while ($line = mysql_fetch_array($res)) {

			$objResponse->addCreate("$select","option",""); 		

			$objResponse->addAssign("$select","options[".$j."].value", $line[0]);

			$objResponse->addAssign("$select","options[".$j."].text", $line[1]); 	

			$j++;

		}

	}

	

	return $objResponse->getXML();

}

function Grabar($data){

    global $conexion;

    global $miSmarty;

	$objResponse = new xajaxResponse('UTF8');

	

	$anios = $data['anio'];

	$str_anios = '';

	foreach ($anios as $anio) {

		$str_anios .= ','.$anio;

	}

	$mes = $data['mes'];

	

	$arrRegistros = array();

	$arrRegistrosDetale = array();

	

	// $sql_boletas = "select distinct nombre

	// 				from gescolcl_arcoiris_administracion.Movimientos

	// 					inner join gescolcl_arcoiris_administracion.TipoPagoBoleta

	// 						on Movimientos.TipoPagoBoleta = TipoPagoBoleta.tpb_ncorr

	// 				where year(FechaBoleta) = '".$anio."' and month(FechaBoleta) = '".$mes."' 

	// 				group by FechaBoleta";

	// $res_boletas = mysql_query($sql_boletas,$conexion) or die(mysql_error());

	// while($row_boletas = mysql_fetch_array($res_boletas)){

	// 	array_push($arrRegistros,array(	'nombre'		=>	$row_boletas['nombre']

	// 									));

	// 	}

	



	// $sql_boletas = "select nombre, sum(ValorBoleta) as ValorBoleta, FechaBoleta

	// 				from gescolcl_arcoiris_administracion.Movimientos

	// 					inner join gescolcl_arcoiris_administracion.TipoPagoBoleta

	// 						on Movimientos.TipoPagoBoleta = TipoPagoBoleta.tpb_ncorr

	// 				where year(FechaBoleta) = '".$anio."' and month(FechaBoleta) = '".$mes."' 

	// 				group by FechaBoleta";

	// $res_boletas = mysql_query($sql_boletas,$conexion) or die(mysql_error());

	// while($row_boletas = mysql_fetch_array($res_boletas)){

	// 	array_push($arrRegistrosDetale,array(	'nombre'		=>	$row_boletas['nombre'],

	// 									'FechaBoleta'	=>	$row_boletas['FechaBoleta'],

	// 									'ValorBoleta'	=>	$row_boletas['ValorBoleta']

	// 									));

	// 	}



	// 	$miSmarty->assign('arrRegistrosDetale', $arrRegistrosDetale);

	// 	$miSmarty->assign('arrRegistros', $arrRegistros);

		

	$objResponse->addScript("showPopWin('sg_cobranza_visualizador_grafico_pagos_anual.php?anio=".substr($str_anios,1,strlen($str_anios))."', 'Estad&iacute;stica de Recaudaci&oacute;n Anual', 1200, 650, null);");

	

	return $objResponse->getXML();

}          



function Imprime(){

    global $conexion;

    $objResponse = new xajaxResponse('UTF8');

	

	$objResponse->addScript("ImprimeDiv('divabonos');");

	

	return $objResponse->getXML();

}



$xajax->registerFunction("CargaListado");

$xajax->registerFunction("CargaSelect");

$xajax->registerFunction("Grabar");

$xajax->registerFunction("Imprime");



$xajax->processRequests();

$miSmarty->assign('xajax_js', $xajax->getJavascript());



$miSmarty->assign('nro_boleta', $_GET["nro_boleta"]);



$miSmarty->display('sg_cobranza_grafico_pagos_anual.tpl');



?>



