<?php

ob_start();

session_start();



require_once 'includes/xajax/xajax.inc.php'; //archivo de configuracion de ajax

include "../includes/php/conf_smarty.php";//archivo de configuracion de smarty

include "../includes/php/conf_bd.php"; //archivo de coneccion al servidor y base de datos

include "../includes/php/validaciones.php"; 

$xajax = new xajax();



$xajax->setRequestURI("sg_cumpleanos_funcionarios.php");

$xajax->setCharEncoding("UTF8");

$xajax->decodeUTF8InputOn();





function Grabar($data){

	global $conexion;

	global $miSmarty;

        

	$objResponse = new xajaxResponse('UTF8');



	$mes = $data['mes'];

	$dia = $data['dia'];

	$arrRegistros = array();

    

	if (strlen(trim($mes))==1) $mes = '0'.$mes;

	if (strlen(trim($dia))==1) $dia = '0'.$dia;

	

		$sql = "SELECT * 

        		FROM gescolcl_arcoiris_administracion.Profesores

        		where Month(FechaNacimientoProfesor) = '".$mes."' or FechaNacimientoProfesor like '%/".$mes."/%' ";

		$res = mysql_query($sql,$conexion) or die(mysql_error());

		while($row = mysql_fetch_array($res)){

			list($d,$m,$a) = explode('/',$row['FechaNacimientoProfesor']);

			if (isset($m)){

					$fecha = $a.'-'.$m.'-'.$d;

					$dia = $d;

					}

			else{

					$fecha = $row['FechaNacimientoProfesor'];

					list($a,$m,$d) = explode('-',$fecha);

				}



			array_push($arrRegistros, array(	"alumno"  => $row['PaternoProfesor'].' '.$row['MaternoProfesor'].', '.$row['NombresProfesor'],

												"fecha"  => $fecha,

												'dia'	 => $d));

			}

			$arrRegistros = ordenar_matriz_multidimensionada($arrRegistros,'dia','ASC');

			$miSmarty->assign('arrRegistros', $arrRegistros);

			$miSmarty->assign('anio', $_SESSION["sige_anio_escolar_vigente"]);

			$objResponse->addAssign("divresultado", "innerHTML", $miSmarty->fetch('sg_cumpleanos_funcionarios_list.tpl'));

			

	return $objResponse->getXML();

	

	}



function CargaPagina($data){

	global $conexion;

	global $miSmarty;

        

	$objResponse = new xajaxResponse('UTF8');



	$dia = (int)(date("d"));

	$mes = (int)(date("m"));



	$objResponse->addAssign('dia', 'value', $dia);

	$objResponse->addAssign('mes', 'value', $mes);



	return $objResponse->getXML();

	

	}



$xajax->registerFunction("Grabar");

$xajax->registerFunction("CargaPagina");



$xajax->processRequests();

$miSmarty->assign('xajax_js', $xajax->getJavascript());





$miSmarty->display('sg_cumpleanos_funcionarios.tpl');





ob_flush();

?>

