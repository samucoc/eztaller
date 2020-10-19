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



$xajax->setRequestURI("sg_informe_asistencia_por_alumno.php");

$xajax->setCharEncoding("UTF8");

$xajax->decodeUTF8InputOn();



function Grabar($data){

	global $conexion;

	global $miSmarty;	

	

    $objResponse = new xajaxResponse('UTF8');

	

	$anio = $_SESSION["sige_anio_escolar_vigente"];





	$fecha1					=	$anio.'-01-01';

	$fecha2					=	$anio.'-12-31';

	$rut   					=	$data['OBLIRutAlumno'];

	$curso 					= 	$data['curso'];

	

	$objResponse->addScript("document.getElementById('divlistado').style.display='none';");

	

	if ($rut!=''){

		$select_nombre_alumno = "	select concat(PaternoAlumno, ' ', MaternoAlumno, ' ', NombresAlumno) as nombre_alumno, 

											NombreCurso,

											NumeroRutAlumno,

											Cursos.CodigoCurso

									from alumnos".$anio." 

									inner join Cursos

											on alumnos".$anio.".CodigoCurso = Cursos.CodigoCurso

									where NumeroRutAlumno = '".$rut."'";

		}

	if (($curso!='')&&($curso!='- - Seleccione - -')){

		$select_nombre_alumno = "	select concat(PaternoAlumno, ' ', MaternoAlumno, ' ', NombresAlumno) as nombre_alumno, 

											NombreCurso,

											NumeroRutAlumno

									from alumnos".$anio." 

									inner join Cursos

											on alumnos".$anio.".CodigoCurso = Cursos.CodigoCurso

									where Cursos.CodigoCurso = '".$curso."'";

		}

	$res_nombre_alumno = mysql_query($select_nombre_alumno,$conexion) or die(mysql_error());

	$arrRegistros	= 	array();

		

	while($row_RA = mysql_fetch_array($res_nombre_alumno)){

		

		array_push($arrRegistros, array("item"					=>	$row_RA['NombreCurso'], 

										"FechaInasistencia"		=>	$row_RA['nombre_alumno']

										));



		$rut = $row_RA['NumeroRutAlumno'];



		$sql_ve = "select DATE_FORMAT(FechaInasistencia, '%d-%m-%Y')

					from Inasistencias

						

					where NumeroRutAlumno = '".$rut."' and FechaInasistencia between '".$fecha1."' and '".$fecha2."'

					order by FechaInasistencia";

		

		$res_ve = mysql_query($sql_ve, $conexion);

		$i = 1;

		array_push($arrRegistros, array("item"					=>	$i, 

											"FechaInasistencia"		=>	"Inasistencias"

											));

		if (mysql_num_rows($res_ve)==0){

			array_push($arrRegistros, array("item"					=>	'', 

											"FechaInasistencia"		=>	"No existen registros"

											));

			

			}

		else{

			while ($line_ve = mysql_fetch_row($res_ve)) {

				array_push($arrRegistros, array("item"					=>	$i, 

												"FechaInasistencia"		=>	$line_ve[0]

												));

				$i++;

				

				}

			}

		$i=1;

		$sql_ve = "select DATE_FORMAT(FechaAtraso, '%d-%m-%Y')

					from Atrasos

						

					where NumeroRutAlumno = '".$rut."' and FechaAtraso between '".$fecha1."' and '".$fecha2."'

					order by FechaAtraso";

		

		$res_ve = mysql_query($sql_ve, $conexion);

		$i=1;

				array_push($arrRegistros, array("item"					=>	$i, 

												"FechaInasistencia"		=>	"Atrasos"

												));

		if (mysql_num_rows($res_ve)==0){

			array_push($arrRegistros, array("item"					=>	'', 

											"FechaInasistencia"		=>	"No existen registros"

											));

			

			}

		else{

			while ($line_ve = mysql_fetch_row($res_ve)) {

				array_push($arrRegistros, array("item"					=>	$i, 

												"FechaInasistencia"		=>	$line_ve[0]

												));

				$i++;

				}

			}



		$sql_ve = "select count(FechaInasistencia) as contador

					from Inasistencias

					where NumeroRutAlumno = '".$rut."' and FechaInasistencia between '".$fecha1."' and '".$fecha2."'

					";

		

		$res_ve = mysql_query($sql_ve, $conexion);	

		$line_ve = mysql_fetch_row($res_ve);

		array_push($arrRegistros, array("item"					=>	"Total Inasistencias", 

										"FechaInasistencia"		=>	$line_ve[0]

										));



		$tot_inasistencias = $line_ve[0];



		$CodigoCurso = $row_RA['CodigoCurso'];



		$porc_inasis_nominal = $sum = 0;



		if (($CodigoCurso=='370')||($CodigoCurso=='380')){

			$sql_ve = "select DiasPeriodo as contador

						from Periodos

						where AnoAcademico = '".$anio."' and Semestre = '1'

						";

			

			$res_ve = mysql_query($sql_ve, $conexion);	

			$line_ve = mysql_fetch_row($res_ve);



			$DiasPeriodo = $line_ve[0];



			$sql_ve = "select DiasPeriodo4medio as contador

						from Periodos

						where AnoAcademico = '".$anio."' and Semestre = '2'

						";

			

			$res_ve = mysql_query($sql_ve, $conexion);	

			$line_ve = mysql_fetch_row($res_ve);



			$DiasPeriodo4medio = $line_ve[0];



			$sum = $DiasPeriodo + $DiasPeriodo4medio;



			$porc_inasis_nominal = 100 - round(($tot_inasistencias*100)/$sum,2);





			}

		else{



			$sql_ve = "select sum(DiasPeriodo) as contador

						from Periodos

						where AnoAcademico = '".$anio."'

						";

			

			$res_ve = mysql_query($sql_ve, $conexion);	

			$line_ve = mysql_fetch_row($res_ve);



			$sum  = $line_ve[0];

			$porc_inasis_nominal = 100 - round(($tot_inasistencias*100)/$line_ve[0],2);

	

			}



		array_push($arrRegistros, array("item"					=>	"Total Dias Trabajados Nominal", 

										"FechaInasistencia"		=>	$sum 

										));

		

		array_push($arrRegistros, array("item"					=>	"% Asistencia Nominal", 

										"FechaInasistencia"		=>	$porc_inasis_nominal 

										));



		$sql_ve = "select count(FechaAtraso) as contador

					from Atrasos

					where NumeroRutAlumno = '".$rut."' and FechaAtraso between '".$fecha1."' and '".$fecha2."'

					";

		

		$res_ve = mysql_query($sql_ve, $conexion);	

		$line_ve = mysql_fetch_row($res_ve);

		array_push($arrRegistros, array("item"					=>	"Total Atrasos", 

										"FechaInasistencia"		=>	$line_ve[0]

										));



		}



		$miSmarty->assign('arrRegistros', $arrRegistros);

		

		$objResponse->addAssign("divabonos", "innerHTML", $miSmarty->fetch('sg_informe_asistencia_por_alumnos_list.tpl'));

	

	$objResponse->addScript("document.getElementById('divlistado').style.display='block';");

	

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

        $objResponse->addCreate("$select","option",""); 		

		$objResponse->addAssign("$select","options[".$j."].value", $codigo);

		$objResponse->addAssign("$select","options[".$j."].text", $descripcion); 	

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



function CargaPagina($data){

    global $conexion;

    $objResponse = new xajaxResponse('UTF8');

	

	$objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'curso','gescolcl_nmva_administracion.Cursos','','- - Seleccione - -','CodigoCurso','NombreCurso', '')");

	

	return $objResponse->getXML();



	}  



function EnivarPDF($data){

	global $conexion;

	

    $objResponse = new xajaxResponse('UTF8');



	$alumno                     =       $data['OBLIRutAlumno'];

        

	$objResponse->addScript("showPopWin('sg_envia_asistencia_por_alumno.php?alumno=$alumno', 'Enviar PDF', 600, 200, null);");



	return $objResponse->getXML();

	}







$xajax->registerFunction("Grabar");

$xajax->registerFunction("CargaSelect");

$xajax->registerFunction("CargaPagina");

$xajax->registerFunction("EnivarPDF");



$xajax->processRequests();

$miSmarty->assign('xajax_js', $xajax->getJavascript());



$miSmarty->display('sg_informe_asistencia_por_alumnos.tpl');



ob_flush();

?>



