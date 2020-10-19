<?php

ob_start();

session_start();



require_once 'includes/xajax/xajax.inc.php'; //archivo de configuracion de ajax

include "../includes/php/conf_smarty.php";//archivo de configuracion de smarty

include "../includes/php/conf_bd.php"; //archivo de coneccion al servidor y base de datos

//include "../includes/php/conf_bd_antigua.php"; //archivo de coneccion al servidor de yonley

//include "../includes/php/sgbodega.php"; 

include "../includes/php/validaciones.php"; 



$xajax = new xajax();



$xajax->setRequestURI("sg_cursos_malla_curricular.php");

$xajax->setCharEncoding("UTF8");

$xajax->decodeUTF8InputOn();





function CargaListado($data){

	global $conexion;

	global $miSmarty;

	

    $objResponse = new xajaxResponse('UTF8');

	

	$curso	=	$data['curso'];

	

	$sql = "SELECT Ramos.CodigoRamo, Asignaturas.NumeroOrden, Ramos.Descripcion , Cursos.NombreCurso,

					concat(PaternoProfesor,' ',MaternoProfesor,' ',NombresProfesor)	 as profesor, Asignaturas.CodigoRamoRECH

			FROM `Asignaturas`

				inner join Profesores

					on Asignaturas.Profesor = Profesores.NumeroRutProfesor 

				inner join Ramos

					on Asignaturas.CodigoRamo = Ramos.CodigoRamo 

				inner join Cursos

					on Asignaturas.CodigoCurso = Cursos.CodigoCurso

			where Asignaturas.CodigoCurso = '".$curso."'

			order by NumeroOrden";

	$res = mysql_query($sql,$conexion) or die(mysql_error());

	$arrRegistros = array();

	while($row= mysql_fetch_array($res)){

		$miSmarty->assign('nombre_curso', $row['NombreCurso']);



		array_push($arrRegistros, array(	"curso"		=>	$row['NombreCurso'],

											"numero"		=>	$row['NumeroOrden'],

											"Descripcion"		=>	$row['Descripcion'],

											"profesor"		=>	$row['profesor'],

											"RECH"		=>	$row['CodigoRamoRECH']

											));



		}

	$miSmarty->assign('arrRegistros', $arrRegistros);



	$objResponse->addAssign("divabonos", "innerHTML", $miSmarty->fetch('sg_cursos_malla_curricular_list.tpl'));

	

	return $objResponse->getXML();

	}







$xajax->registerFunction("CargaListado");



$xajax->processRequests();

$miSmarty->assign('xajax_js', $xajax->getJavascript());

$miSmarty->assign('curso', $_GET['curso']);



$miSmarty->display('sg_cursos_malla_curricular.tpl');



ob_flush();

?>



