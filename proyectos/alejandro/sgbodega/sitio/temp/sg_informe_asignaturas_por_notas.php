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



$xajax->setRequestURI("sg_informe_asignaturas_por_notas.php");

$xajax->setCharEncoding("UTF8");

$xajax->decodeUTF8InputOn();



$anio = $_SESSION["sige_anio_escolar_vigente"];



function Grabar($data){

	global $conexion;

	global $miSmarty;

	

    $objResponse = new xajaxResponse('UTF8');

    

	$anio					=	$data['anio'];

	$curso					=	$data['curso'];

	$semestre				=	$data['semestre'];

	$asignatura				=	$data['asignaturas'];



	$arrRegistrosDetalle    = [];

	$arrRegistros 		    = [];



	$select_notas = "select NombreCurso

					from Cursos

					where CodigoCurso = '".$curso."'";

	$res_notas = mysql_query($select_notas, $conexion) or die(mysql_error());

	$row_notas = mysql_fetch_array($res_notas);

	$miSmarty->assign('nombre_semestre',$row_notas['NombreCurso'].' - '.$semestre.' Semestre');



	$select_notas = "select Descripcion

					from Ramos

					where CodigoRamo = '".$asignatura."'";

	$res_notas = mysql_query($select_notas, $conexion) or die(mysql_error());

	$row_notas = mysql_fetch_array($res_notas);

	$miSmarty->assign('nombre_asignatura',$row_notas['Descripcion']);



	$select_notas = "select max(NumeroNota) as maximo

					from gescolcl_nmva_administracion.NotasAlumnos 

					where AnoAcademico = '".$anio."' and  

						  Semestre = '".$semestre."' and 

						  CodigoRamo = '".$asignatura."' and 

						  CodigoCurso = '".$curso."'";

						  

	$res_notas = mysql_query($select_notas, $conexion) or die(mysql_error());

	$row_notas = mysql_fetch_array($res_notas);

	$miSmarty->assign('notas_ingresadas',$row_notas['maximo']);



	$objResponse->addScript("document.getElementById('divlistado').style.display='none';");

	

	$select_nombre_alumno = "select concat(PaternoAlumno, ' ', MaternoAlumno, ' ', NombresAlumno) as nombre_alumno,

									alumnos".$anio.".NumeroRutAlumno

							from alumnos".$anio."

								inner join Matriculas

									on alumnos".$anio.".NumeroRutAlumno = Matriculas.NumeroRutAlumno and

										Matriculas.Anio = '".$anio."'  

							where alumnos".$anio.".CodigoCurso = '".$curso."'

							order by Matriculas.NroLista";

	$res_nombre_alumno = mysql_query($select_nombre_alumno,$conexion) or die(mysql_error());



	while ($line_ve = mysql_fetch_row($res_nombre_alumno)) {

		array_push($arrRegistros, array("item"					=>	$i, 

										"NumeroRutAlumno"		=>	$line_ve[1],

										"nombre_alumno"			=> 	$line_ve[0]

										));

		$i++;

		

		$select_notas = "select Nota

						from gescolcl_nmva_administracion.NotasAlumnos

						where  NumeroRutAlumno = '".$line_ve[1]."' and 

								CodigoRamo = '".$asignatura."' and  

								CodigoCurso = '".$curso."' and  

								AnoAcademico = '".$anio."' and  

								Semestre = '".$semestre."'";

		$res_notas = mysql_query($select_notas, $conexion) or die(mysql_error());

		$j=1;

		$k=0;

		$total = 0;

		$promedio = 0;

		while($row_notas = mysql_fetch_array($res_notas)){

			array_push($arrRegistrosDetalle, array( "item"		=>	$j, 

													"nombre_alumno"			=> 	$line_ve[0], 

													"nota"					=>	$row_notas[0], 

													"NumeroRutAlumno"		=>	$line_ve[1]

													));

			$total = $row_notas[0] + $total;

			$j++;

			if ($row_notas[0]>0){

				$k++;

				}

			}

		if ($k>0){

			$promedio = $total/$k;

			}

		else{

			$promedio=0;

			}

		array_push($arrRegistrosDetalle, array( "item"					=>	$j, 

												"nombre_alumno"			=> 	$line_ve[0], 

												"nota"					=>	round($promedio,1),

												"NumeroRutAlumno"		=> 	$line_ve[1]

												));

		

		}



	// var_dump($arrRegistros);

	// var_dump($arrRegistrosDetalle);

	$miSmarty->assign('arrRegistros', $arrRegistros);

	$miSmarty->assign('arrRegistrosDetalle', $arrRegistrosDetalle);

		

	$objResponse->addAssign("divabonos", "innerHTML", $miSmarty->fetch('sg_informe_asignaturas_por_notas_list.tpl'));

	

	

	$objResponse->addScript("document.getElementById('divlistado').style.display='block';");

	



	return $objResponse->getXML();



}



function CargaPagina($data){

	global $conexion;

	global $miSmarty;

	

    $objResponse = new xajaxResponse('UTF8');



	// carga empresas

	$objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'curso','Cursos','','- - Seleccione - -','CodigoCurso','NombreCurso', '')");

	$objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'anio','Periodos','','- - Seleccione - -','distinct AnoAcademico','AnoAcademico', ' where AnoAcademico = ".$_SESSION["sige_anio_escolar_vigente"]	."')");





	return $objResponse->getXML();

}



function CargaSelect($data, $select, $tabla, $codigo, $descripcion, $campo1, $campo2, $opt){

    global $conexion;

    $objResponse = new xajaxResponse('UTF8');

	

	$objResponse->addAssign("$select","innerHTML",""); 		

	

        if ($tabla != 'personas'){

            $sql = "select $campo1 as codigo, $campo2 as descripcion from $tabla $opt";

        }

        else{

            $sql = "select $campo1 as codigo, concat(pers_ape_pat,' ',pers_nombre) as descripcion from $tabla $opt";

        }

	$res = mysql_query($sql, $conexion);

	

	if (@mysql_num_rows($res) > 0) {

                $j=0;

            $objResponse->addCreate("$select","option",""); 		

			$objResponse->addAssign("$select","options[".$j."].value", '0');

			$objResponse->addAssign("$select","options[".$j."].text", 'Elija'); 

			$j++;	

                while ($line = mysql_fetch_array($res)) {

			$objResponse->addCreate("$select","option",""); 		

			$objResponse->addAssign("$select","options[".$j."].value", $line[0]);

			$objResponse->addAssign("$select","options[".$j."].text", $line[1]); 	

			$j++;

		}

	}

	

	return $objResponse->getXML();

}



function CargaPeriodos($data){

    global $conexion;

    $objResponse = new xajaxResponse('UTF8');

	

	$objResponse->addAssign("semestre","innerHTML",""); 		

	$anio = $_SESSION["sige_anio_escolar_vigente"];



	$sql = "select Semestre as codigo, NombrePeriodo as descripcion from Periodos where AnoAcademico = '".$anio."'";

	$res = mysql_query($sql, $conexion);

	

	if (@mysql_num_rows($res) > 0) {

                $j=0;

            $objResponse->addCreate("semestre","option",""); 		

			$objResponse->addAssign("semestre","options[".$j."].value", '0');

			$objResponse->addAssign("semestre","options[".$j."].text", 'Elija'); 

			$j++;	

                while ($line = mysql_fetch_array($res)) {

			$objResponse->addCreate("semestre","option",""); 		

			$objResponse->addAssign("semestre","options[".$j."].value", $line[0]);

			$objResponse->addAssign("semestre","options[".$j."].text", $line[1]); 	

			$j++;

		}

	}

	

	return $objResponse->getXML();

}



function CargaAsignaturas($data){



	global $conexion;

    $objResponse = new xajaxResponse('UTF8');

	

	$select 		= 'asignaturas';

	$codigo_curso 	= $data['curso'];

	

	$objResponse->addAssign("$select","innerHTML",""); 		

	

	$sql = "select CodigoRamo as codigo, Descripcion as descripcion 

			from Ramos 

			where CodigoRamo in (select CodigoRamo

								from Asignaturas

								where CodigoCurso = '".$codigo_curso."')";

	$res = mysql_query($sql, $conexion);

	

	if (@mysql_num_rows($res) > 0) {

               $j=0;

            $objResponse->addCreate("$select","option",""); 		

			$objResponse->addAssign("$select","options[".$j."].value", '');

			$objResponse->addAssign("$select","options[".$j."].text", 'Elija'); 

			$j++;	

                 while ($line = mysql_fetch_array($res)) {

			$objResponse->addCreate("$select","option",""); 		

			$objResponse->addAssign("$select","options[".$j."].value", $line[0]);

			$objResponse->addAssign("$select","options[".$j."].text", $line[1]); 	

			$j++;

		}

	}

	

	return $objResponse->getXML();	

}



$xajax->registerFunction("Grabar");

$xajax->registerFunction("CargaPagina");

$xajax->registerFunction("CargaSelect");

$xajax->registerFunction("CargaAsignaturas");

$xajax->registerFunction("CargaPeriodos");





$xajax->processRequests();

$miSmarty->assign('xajax_js', $xajax->getJavascript());

$miSmarty->assign('rut_alumno', substr($_GET['rut_alumno'],0,8));



$miSmarty->display('sg_informe_asignaturas_por_notas.tpl');



ob_flush();

?>





