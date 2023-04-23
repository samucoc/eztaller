<?php

ob_start();

session_start();



require_once 'includes/xajax/xajax.inc.php'; //archivo de configuracion de ajax

include "../includes/php/conf_smarty.php";//archivo de configuracion de smarty

include "../includes/php/conf_bd.php"; //archivo de coneccion al servidor y base de datos

include "../includes/php/validaciones.php"; 

$xajax = new xajax();



$xajax->setRequestURI("sg_cumpleanos_alumnos.php");

$xajax->setCharEncoding("UTF8");

$xajax->decodeUTF8InputOn();





function Grabar($data){

	global $conexion;

	global $miSmarty;

        

	$objResponse = new xajaxResponse('UTF8');



	$mes = $data['mes'];

	$dia = $data['dia'];

	$anio = $_SESSION["sige_anio_escolar_vigente"];

    

	$arrRegistros = array();

    

    if (strlen(trim($mes))==1) $mes = '0'.$mes;

	if (strlen(trim($dia))==1) $dia = '0'.$dia;



		$sql = "SELECT PaternoAlumno, MaternoAlumno, NombresAlumno, CodigoCurso, FechaNacimiento, FotoAlumno

        		FROM gescolcl_arcoiris_administracion.alumnos".$anio."

        		where Month(FechaNacimiento) = '".$mes."' and Matriculado = '1'";

		$res = mysql_query($sql,$conexion) or die(mysql_error());

		while($row = mysql_fetch_array($res)){

			

					$fecha = $row['FechaNacimiento'];

					list($a,$m,$d) = explode('-',$fecha);



			$fecha = time() - strtotime($fecha);

			$edad = floor((($fecha / 3600) / 24) / 365);

							

			$sql_1 = "select NombreCurso from gescolcl_arcoiris_administracion.Cursos where CodigoCurso like '%".$row['CodigoCurso']."%'";

			$res_1 = mysql_query($sql_1,$conexion);

			$row_1 = mysql_fetch_array($res_1);





			array_push($arrRegistros, array(	"alumno"  => $row['PaternoAlumno'].' '.$row['MaternoAlumno'].', '.$row['NombresAlumno'],

												"fecha"   => $row['FechaNacimiento'],

												"curso"   => $row_1['NombreCurso'],

												"edad"    => $edad,

												"foto"    => $row['FotoAlumno'],

												'dia'	  => $d));

			}





		$arrRegistros = ordenar_matriz_multidimensionada($arrRegistros,'dia','ASC');

		$miSmarty->assign('anio', $_SESSION["sige_anio_escolar_vigente"]);

		$miSmarty->assign('arrRegistros', $arrRegistros);

		$objResponse->addAssign("divresultado", "innerHTML", $miSmarty->fetch('sg_cumpleanos_alumnos_list.tpl'));

			

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





$miSmarty->display('sg_cumpleanos_alumnos.tpl');





ob_flush();

?>

