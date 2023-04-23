<?php

ob_start();

session_start();



require_once 'includes/xajax/xajax.inc.php'; //archivo de configuracion de ajax

include "../includes/php/conf_smarty.php";//archivo de configuracion de smarty

include "../includes/php/conf_bd.php"; //archivo de coneccion al servidor y base de datos

include "../includes/php/validaciones.php"; 

$xajax = new xajax();



$xajax->setRequestURI("sg_informes_autorizados_no_matriculados.php");

$xajax->setCharEncoding("UTF8");

$xajax->decodeUTF8InputOn();





function Grabar($data){

	global $conexion;

	global $miSmarty;

        

	$objResponse = new xajaxResponse('UTF8');



	$nivel = $data['nivel'];

	$arrRegistros = array();

	$anio = $_SESSION["sige_anio_escolar_vigente"];

    

		if ($nivel=='1'){

			$and = " alumnos".$anio.".CodigoCurso < '100' and ";

			}

		else if ($nivel=='2'){

			$and = " alumnos".$anio.".CodigoCurso between '100' and '299' and ";

			}

		else if ($nivel=='3'){

			$and = " alumnos".$anio.".CodigoCurso between '300' and '399' and ";

			}



		$sql_1 ="select NombreEstablecimiento, NumeroRutEstablecimiento, DireccionEstablecimiento, CiudadEstablecimiento

					from gescolcl_nmva_administracion.Establecimiento";

		$res_1 = mysql_query($sql_1,$conexion);

		$row_1 = mysql_fetch_array($res_1);



		$miSmarty->assign('nombre',$row_1['NombreEstablecimiento']);

		$miSmarty->assign('rut',$row_1['NumeroRutEstablecimiento'].'-'.dv($row_1['NumeroRutEstablecimiento']));

		$miSmarty->assign('direccion',$row_1['DireccionEstablecimiento']);

		$miSmarty->assign('ciudad',$row_1['CiudadEstablecimiento']);



		

		$sql = "select NroMatricula, alumnos".$anio.".NumeroRutAlumno, concat(PaternoAlumno, ' ',MaternoAlumno, ' ',NombresAlumno) as alumno, SexoAlumno, 

						date_format(FechaNacimiento, '%d/%m/%Y' ) as FechaNacimiento, NombreCurso, 

						date_format(Matriculas.Fecha, '%d/%m/%Y' ) as Fecha, DireccionParticularAlumno, 

						concat(PaternoApoderado, ' ',MaternoApoderado, ' ',NombresApoderado) as apoderado, TelefonoParticularApoderado

				from gescolcl_nmva_administracion.Matriculas

					inner join gescolcl_nmva_administracion.alumnos".$anio."

						on alumnos".$anio.".NumeroRutAlumno = Matriculas.NumeroRutAlumno

					inner join gescolcl_nmva_administracion.Apoderados

						on alumnos".$anio.".NumeroRutApoderado = Apoderados.NumeroRutApoderado

					inner join gescolcl_nmva_administracion.Cursos

						on alumnos".$anio.".CodigoCurso = Cursos.CodigoCurso

				where $and alumnos".$anio.".Matriculado = '0'

				order by Cursos.CodigoCurso, alumno";

		$res = mysql_query($sql,$conexion) or die(mysql_error());

		$i=1;

		while($row = mysql_fetch_array($res)){

			if ($row['SexoAlumno']=='1'){

				$sexo = 'Femenino';

			}

			else{

				$sexo = "Masculino";

			}	

			array_push($arrRegistros, array(	"NroMatricula" 	  	=> 	$i,

												"NumeroRutAlumno" 	=> 	$row['NumeroRutAlumno'].'-'.dv($row['NumeroRutAlumno']),

												"alumno" 	  		=> 	$row['alumno'],

												"SexoAlumno" 		=>  $sexo,

												"FechaNacimiento"	=> 	$row['FechaNacimiento'],

												"NombreCurso"	  		=> 	$row['NombreCurso'],

												"Fecha"	  		=> 	$row['Fecha'],

												"DireccionParticularAlumno"		  		=> 	$row['DireccionParticularAlumno'],

												"apoderado"	  	=> 	$row['apoderado'],

												"TelefonoParticularApoderado"	  		=> 	$row['TelefonoParticularApoderado']));

			$i++;

			}



			$miSmarty->assign('arrRegistros', $arrRegistros);

			$miSmarty->assign('total_alumnos', $i-1);

			$objResponse->addAssign("divresultado", "innerHTML", $miSmarty->fetch('sg_informes_autorizados_no_matriculados_list.tpl'));

			

	return $objResponse->getXML();

	

	}



$xajax->registerFunction("Grabar");



$xajax->processRequests();

$miSmarty->assign('xajax_js', $xajax->getJavascript());





$miSmarty->display('sg_informes_autorizados_no_matriculados.tpl');





ob_flush();

?>

