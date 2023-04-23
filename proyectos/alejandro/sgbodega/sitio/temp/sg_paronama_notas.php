<?php

ob_start();

session_start();



require_once 'includes/xajax/xajax.inc.php'; //archivo de configuracion de ajax

include "../includes/php/conf_smarty.php";//archivo de configuracion de smarty

include "../includes/php/conf_bd.php"; //archivo de coneccion al servidor y base de datos

include "../includes/php/validaciones.php"; 

$xajax = new xajax();



$xajax->setRequestURI("sg_paronama_notas.php");

$xajax->setCharEncoding("UTF8");

$xajax->decodeUTF8InputOn();



function Enviar($data,$arrRegistros){



}



function Grabar($data){

	global $conexion;

	global $miSmarty;

        set_time_limit(100000);

        

	$objResponse = new xajaxResponse('UTF8');

	

	$arrRegistros		= 	array();

	$arrNotas			= 	array();

	$arrRamos			=	array();

	$arrPromCursos		=	[];



	$curso                     	=       $data['curso'];

    $anio 						= 		$data["anio"];

	$semestre                   =       $data['semestre'];

     

	$objResponse->addScript("document.getElementById('divlistado').style.display='none';");

	

	$sql_nombre_profe ="select 

				distinct

				Cursos.NombreCurso,

				concat(`PaternoProfesor`,' ',`MaternoProfesor`,' , ',`NombresProfesor`) as nombre_profesor

				from Cursos

					left join Profesores

						on Cursos.ProfesorJefe = Profesores.NumeroRutProfesor 

				where

					Cursos.CodigoCurso = '".$curso."'

				";

	$res_nombre_profe = mysql_query($sql_nombre_profe,$conexion) or die(mysql_error());

	$row_nombre_profe = mysql_fetch_array($res_nombre_profe);



	$miSmarty->assign('nombre_curso', $row_nombre_profe['NombreCurso']);

	$miSmarty->assign('semestre', $semestre.' Semestre');

	$miSmarty->assign('anio', $anio);

	$miSmarty->assign('nombre_profe', $row_nombre_profe['nombre_profesor']);

	

	$sql_pd = "select 

				distinct

				Cursos.NombreCurso,

				concat(`PaternoProfesor`,' ',`MaternoProfesor`,' , ',`NombresProfesor`) as nombre_profesor, 

				alumnos".$anio.".NumeroRutAlumno,

				concat(`PaternoAlumno`,' ',`MaternoAlumno`,' , ',`NombresAlumno`) as nombre_alumno,

				Matriculas.NroMatricula	,

				Matriculas.NroLista	

				from Cursos

					left join Profesores

						on Cursos.ProfesorJefe = Profesores.NumeroRutProfesor 

					inner join alumnos".$anio."

						on alumnos".$anio.".CodigoCurso = Cursos.CodigoCurso

					inner join Matriculas

						on alumnos".$anio.".NumeroRutAlumno = Matriculas.NumeroRutAlumno and

							Matriculas.Anio = '".$anio."'

				where

					Cursos.CodigoCurso = '".$curso."' and alumnos".$anio.".Matriculado = '1'

				order by Matriculas.NroLista	"; 

	

	$res_pd = mysql_query($sql_pd, $conexion);

	if (mysql_num_rows($res_pd) > 0){

			$i 					= 	0;



			$sql_asignaturas = "select distinct Descripcion , Ramos.CodigoRamo

								from Asignaturas

									inner join Ramos 

										on Ramos.CodigoRamo = Asignaturas.CodigoRamo

								where Asignaturas.CodigoCurso = '".$curso."'

								order by Asignaturas.NumeroOrden";

			$res_asignaturas = mysql_query($sql_asignaturas,$conexion) or die(mysql_error());

			while($row_asignaturas = mysql_fetch_array($res_asignaturas)){

				array_push($arrNotas, array("item"					=>	$i, 

											"rut_alumno"			=> 	'linea',

											"asignatura" 			=> 	$row_asignaturas['Descripcion'],

											"CodigoRamo"			=>	$row_asignaturas['CodigoRamo'],

											"nota"					=> 	'XXX'

											));

				}	 



			array_push($arrNotas, array("item"					=>	$i, 

											"rut_alumno"			=> 	'linea',

											"asignatura" 			=> 	'Promedio',

											"CodigoRamo"			=>	'Promedio',

											"nota"					=> 	'XXX'

											));

			

			array_push($arrNotas, array("item"					=>	$i, 

											"rut_alumno"			=> 	'linea',

											"asignatura" 			=> 	'Asis',

											"CodigoRamo"			=>	'Asis',

											"nota"					=> 	'XXX'

											));

			array_push($arrNotas, array("item"					=>	$i, 

											"rut_alumno"			=> 	'linea',

											"asignatura" 			=> 	'Atrasos',

											"CodigoRamo"			=>	'Atrasos',

											"nota"					=> 	'XXX'

											));

			array_push($arrNotas, array("item"					=>	$i, 

											"rut_alumno"			=> 	'linea',

											"asignatura" 			=> 	'HV(+)',

											"CodigoRamo"			=>	'HV(+)',

											"nota"					=> 	'XXX'

											));

			array_push($arrNotas, array("item"					=>	$i, 

											"rut_alumno"			=> 	'linea',

											"asignatura" 			=> 	'HV(-)',

											"CodigoRamo"			=>	'HV(-)',

											"nota"					=> 	'XXX'

											));

						

			array_push($arrRegistros, array("item"					=>	$i, 

										"NroLista"				=>  'Nro. Lista', 

										"nombre_alumno"			=> 	'Nombre Alumno', 

										"rut_alumno"			=> 	'linea'

										));





			while ($line_pd = mysql_fetch_row($res_pd)) {

				$sql_asignaturas = "select distinct Descripcion , Ramos.CodigoRamo

								from Asignaturas

									inner join Ramos 

										on Ramos.CodigoRamo = Asignaturas.CodigoRamo

								where Asignaturas.CodigoCurso = '".$curso."'

								order by Asignaturas.NumeroOrden";

				$res_asignaturas = mysql_query($sql_asignaturas,$conexion) or die(mysql_error());

				$k = 0;

				$promedio = 0;



				while($row_asignaturas = mysql_fetch_array($res_asignaturas)){

					$sql_notas = "select avg(Nota) as promedio, CodigoCurso, CodigoRamo, Semestre, NumeroRutAlumno

									from NotasAlumnos

									where CodigoRamo = '".$row_asignaturas['CodigoRamo']."' and 

										  NumeroRutAlumno = '".$line_pd[2]."' and 

										  AnoAcademico = '".$anio."' and  

										  Semestre = '".$semestre."' and

										  Nota > 0

									group by Semestre, CodigoCurso, CodigoRamo, NumeroRutAlumno";

					$res_notas = mysql_query($sql_notas,$conexion) or die(mysql_error());

					if (mysql_num_rows($res_notas)==0){

						array_push($arrNotas, array("rut_alumno"			=> 	$line_pd[2],

													"asignatura" 			=> 	$row_asignaturas['CodigoRamo'],

													"curso" 				=> 	$curso,

													"anio"					=> 	$anio,

													"semestre"				=>	$semestre,

													"nota"					=> 	'0',

													"negro"					=>	'0'

													));

						$arrPromCursos[$curso][$row_asignaturas['CodigoRamo']][$line_pd[2]] = 0;

						}

					else{

						while ($row_notas = mysql_fetch_array($res_notas)) {

							array_push($arrNotas, array("rut_alumno"			=> 	$row_notas['NumeroRutAlumno'],

													"asignatura" 			=> 	$row_notas['CodigoRamo'],

													"curso" 				=> 	$row_notas['CodigoCurso'],

													"anio"					=> 	$anio,

													"semestre"				=>	$semestre,

													"nota"					=> 	str_replace('.', ',', round($row_notas['promedio'],1)),

													"negro"					=>	'0'

													));

							$arrPromCursos[$row_notas['CodigoCurso']][$row_notas['CodigoRamo']][$row_notas['NumeroRutAlumno']] = round($row_notas['promedio'],1);

							$promedio = $promedio + $row_notas['promedio'];

							$k++;	

							}

						}

					}

					$sql_notas = "select avg(Nota) as promedio, CodigoRamo

									from NotasAlumnos

									where NumeroRutAlumno = '".$line_pd[2]."' and 

										  AnoAcademico = '".$anio."' and  

										  Semestre = '".$semestre."' and

										  Nota > 0 

											group by CodigoRamo

											HAVING avg(Nota) > 0";

					$res_notas = mysql_query($sql_notas,$conexion) or die(mysql_error());

					$sum = 0;

					$l = 0;

					while($row_notas = mysql_fetch_array($res_notas)){

						$sum = $sum + round($row_notas['promedio'],1);

						$l++;

						}

					$promedio = $sum/$l;

					array_push($arrNotas, array("rut_alumno"			=> 	$line_pd[2],

													"asignatura" 			=> 	'Promedio',

													"CodigoRamo"			=>	'Promedio',

													"curso" 				=> 	$curso,

													"anio"					=> 	$anio,

													"semestre"				=>	$semestre,

													"nota"					=> 	str_replace('.', ',', round($promedio,1)),

													"negro"					=>	'0'

													));



					$sql_asistencia = "SELECT DiasPeriodo as cantidad

										from Periodos 

										where AnoAcademico = '".$anio."' and Semestre = '".$semestre."'";

					$res_asistencia = mysql_query($sql_asistencia,$conexion) or die(mysql_error());

					$row_asistencia = mysql_fetch_array($res_asistencia);

					$asistencia = $row_asistencia['cantidad'];

					

					$sql_inasistencia = "select count(FechaInasistencia) as ina

										 from Inasistencias

										 where NumeroRutAlumno = '".$line_pd[2]."' and Year(FechaInasistencia) = '".$anio."'";

					$res_inasistencia = mysql_query($sql_inasistencia,$conexion) or die(mysql_error());

					$row_inasistencia = mysql_fetch_array($res_inasistencia);

					$inasistencia = $row_inasistencia['ina'];

					

					$porc_ina = 100-(($inasistencia*100)/$asistencia);

					$porc_ina = number_format($porc_ina , 2 , "." , ",");

					

					$sql_atrasos = "select count(FechaAtraso) as ina

											 from Atrasos

										 where NumeroRutAlumno = '".$line_pd[2]."' and Year(FechaAtraso) = '".$anio."'";

					$res_atrasos = mysql_query($sql_atrasos,$conexion) or die(mysql_error());

					$row_atrasos = mysql_fetch_array($res_atrasos);

					$atrasos = $row_atrasos['ina'];

						

					$sql_positiva = "select count(TipoHojaVida) as ina

											 from HojasDeVida

										 where NumeroRutAlumno = '".$line_pd[2]."' and TipoHojaVida = 0 and Year(FechaHojaVida) = '".$anio."'";

					$res_positiva = mysql_query($sql_positiva,$conexion) or die(mysql_error());

					$row_positiva = mysql_fetch_array($res_positiva);

					$positiva = $row_positiva['ina'];

						

					$sql_negativa = "select count(TipoHojaVida) as ina

											 from HojasDeVida

										 where NumeroRutAlumno = '".$line_pd[2]."' and TipoHojaVida = 1 and Year(FechaHojaVida) = '".$anio."'";

					$res_negativa = mysql_query($sql_negativa,$conexion) or die(mysql_error());

					$row_negativa = mysql_fetch_array($res_negativa);

					$negativa = $row_negativa['ina'];



					array_push($arrNotas, array("item"					=>	$i, 

													"rut_alumno"			=> 	$line_pd[2],

													"asignatura" 			=> 	'Asis',

													"CodigoRamo"			=>	'Asis',

													"curso" 				=> 	$curso,

													"anio"					=> 	$anio,

													"semestre"				=>	$semestre,

													"nota"					=> 	str_replace('.', ',', round($porc_ina,1)),

													"negro"					=>	'1'

													));

					array_push($arrNotas, array("item"					=>	$i, 

													"rut_alumno"			=> 	$line_pd[2],

													"asignatura" 			=> 	'Atrasos',

													"CodigoRamo"			=>	'Atrasos',

													"curso" 				=> 	$curso,

													"anio"					=> 	$anio,

													"semestre"				=>	$semestre,

													"nota"					=> 	$atrasos,

													"negro"					=>	'1'

													));

					array_push($arrNotas, array("item"					=>	$i, 

													"rut_alumno"			=> 	$line_pd[2],

													"asignatura" 			=> 	'HV(+)',

													"CodigoRamo"			=>	'HV(+)',

													"curso" 				=> 	$curso,

													"anio"					=> 	$anio,

													"semestre"				=>	$semestre,

													"nota"					=> 	$positiva,

													"negro"					=>	'1'

													));

					array_push($arrNotas, array("item"					=>	$i, 

													"rut_alumno"			=> 	$line_pd[2],

													"asignatura" 			=> 	'HV(-)',

													"CodigoRamo"			=>	'HV(-)',

													"curso" 				=> 	$curso,

													"anio"					=> 	$anio,

													"semestre"				=>	$semestre,

													"nota"					=> 	$negativa,

													"negro"					=>	'1'

													));

						







					array_push($arrRegistros, array("NroLista"				=> 	$line_pd[5], 

													"nombre_alumno"			=> 	$line_pd[3], 

													"rut_alumno"			=> 	$line_pd[2]

													));

					

				}



			foreach ($arrPromCursos as $key_curso => $cursos) {

				foreach ($cursos as $key_ramos => $ramos) {

					foreach ($ramos as $key_alumno => $values) {

						$arrPromCursos[$key_curso][$key_ramos][$key_alumno]	= round($values,1);

					}

				}

			}



			array_push($arrRegistros, array("item"					=>	$i, 

										"NroLista"				=>  '---', 

										"nombre_alumno"			=> 	'Promedio General', 

										"rut_alumno"			=> 	'linea_1'

										));



			$sql_asignaturas = "select distinct Descripcion , Ramos.CodigoRamo

								from Asignaturas

									inner join Ramos 

										on Ramos.CodigoRamo = Asignaturas.CodigoRamo

								where Asignaturas.CodigoCurso = '".$curso."'

								order by Asignaturas.NumeroOrden";

			$res_asignaturas = mysql_query($sql_asignaturas,$conexion) or die(mysql_error());

			while($row_asignaturas = mysql_fetch_array($res_asignaturas)){

			

				$a = array_filter($arrPromCursos[$curso][$row_asignaturas['CodigoRamo']]);

				$prom = array_sum($arrPromCursos[$curso][$row_asignaturas['CodigoRamo']])/count($a);

				array_push($arrNotas, array("item"					=>	$i, 

											"rut_alumno"			=> 	'linea_1',

											"asignatura" 			=> 	$row_asignaturas['Descripcion'],

											"CodigoRamo"			=>	$row_asignaturas['CodigoRamo'],

											"curso" 				=> 	$curso,

											"anio"					=> 	$anio,

											"semestre"				=>	$semestre,

											"nota"					=> 	str_replace('.', ',', round($prom,1))

											));

	

			}



			

			

			$sql_asignaturas = "select distinct Descripcion , Ramos.CodigoRamo

								from Asignaturas

									inner join Ramos 

										on Ramos.CodigoRamo = Asignaturas.CodigoRamo

								where Asignaturas.CodigoCurso = '".$curso."'

								order by Asignaturas.NumeroOrden";

			$res_asignaturas = mysql_query($sql_asignaturas,$conexion) or die(mysql_error());

			$o = 0;

			$proms = 0;

			while($row_asignaturas = mysql_fetch_array($res_asignaturas)){

				$a = array_filter($arrPromCursos[$curso][$row_asignaturas['CodigoRamo']]);

				$prom = array_sum($arrPromCursos[$curso][$row_asignaturas['CodigoRamo']])/count($a);

				$proms = $proms + round($prom,1);

				$o = $o + 1;

				array_push($arrRamos, array("asignatura" 			=> 	$row_asignaturas['Descripcion'],

											"CodigoRamo"			=>	$row_asignaturas['CodigoRamo'],

											"nota"					=> 	str_replace('.', ',', round($prom,1))

											));

				}	

			array_push($arrNotas, array("item"					=>	$i, 

										"rut_alumno"			=> 	'linea_1',

										"asignatura" 			=> 	'Promedio General',

										"CodigoRamo"			=>	'----',

										"nota"					=> 	str_replace('.', ',', round($proms/$o,1))

											)); 

			array_push($arrRamos, array("asignatura" 			=> 	'Promedio General',

										"CodigoRamo"			=>	'----',

										"nota"					=> 	str_replace('.', ',', round($proms/$o,1))

										));

				

    		$sql_inasistencia = "select count(FechaInasistencia) as ina

								 from Inasistencias

								 where NumeroRutAlumno in (select 

																	alumnos".$anio.".NumeroRutAlumno

															from alumnos".$anio."

															where alumnos".$anio.".CodigoCurso = '".$curso."') and 

										Year(FechaInasistencia) = '".$anio."'";

			$res_inasistencia = mysql_query($sql_inasistencia,$conexion) or die(mysql_error());

			$row_inasistencia = mysql_fetch_array($res_inasistencia);

			$inasistencia = $row_inasistencia['ina'];

			

			$sql_asistencia = "SELECT DiasPeriodo as cantidad

								from Periodos 

								where AnoAcademico = '".$anio."' and Semestre = '".$semestre."'";

			$res_asistencia = mysql_query($sql_asistencia,$conexion) or die(mysql_error());

			$row_asistencia = mysql_fetch_array($res_asistencia);

			$asistencia = $row_asistencia['cantidad'];

	

			$porc_ina = 100-((($inasistencia/mysql_num_rows($res_pd))*100)/$asistencia);

			$porc_ina = number_format($porc_ina , 2 , "." , ",");

					

			$sql_atrasos = "select count(FechaAtraso) as ina

									 from Atrasos

								 where NumeroRutAlumno in (select alumnos".$anio.".NumeroRutAlumno

															from alumnos".$anio."

															where alumnos".$anio.".CodigoCurso = '".$curso."') and 

										Year(FechaAtraso) = '".$anio."'";

			$res_atrasos = mysql_query($sql_atrasos,$conexion) or die(mysql_error());

			$row_atrasos = mysql_fetch_array($res_atrasos);

			$atrasos = $row_atrasos['ina'];

					

			array_push($arrRamos, array("asignatura" 			=> 	'Inasistencias',

										"CodigoRamo"			=>	'----',

										"nota"					=> 	str_replace('.', ',', round($porc_ina,1)).' %'

										));

			array_push($arrNotas, array("item"					=>	$i, 

										"rut_alumno"			=> 	'linea_1',

										"asignatura" 			=> 	'Inasistencias',

										"CodigoRamo"			=>	'----',

										"nota"					=> 	str_replace('.', ',', round($porc_ina,1)).' %'

										)); 

				

    		array_push($arrRamos, array("asignatura" 			=> 	'Atrasos',

										"CodigoRamo"			=>	'----',

										"nota"					=> 	str_replace('.', ',', round($atrasos/mysql_num_rows($res_pd),1))

										));

				

    		





		//var_dump($arrRegistros);

		// asigno las sesiones para el ordenamiento

		$_SESSION["alycar_matriz"] 				= 	$arrRegistros;

		



		$miSmarty->assign('arrRegistros', $arrRegistros);

		$miSmarty->assign('arrNotas', $arrNotas);

		$miSmarty->assign('arrRamos', $arrRamos);

		

		//$objResponse->addScript("xajax_Ordenar(xajax.getFormValues('Form1'), 'familia');");

		

		$objResponse->addAssign("divabonos", "innerHTML", $miSmarty->fetch('sg_paronama_notas_list.tpl'));

		//$objResponse->addAssign("divabonos", "innerHTML", $sql_saumentos);

		

	}else{

		

		$objResponse->addAssign("divabonos", "innerHTML", "No Existen Registros");

	}

	

	$objResponse->addScript("document.getElementById('divlistado').style.display='block';");

	$objResponse->addScript("para()");

        Enviar($data,$arrRegistros);

	return $objResponse->getXML();

}

function Ordenar($data, $campo){

	global $conexion;

	global $miSmarty;

	

    $objResponse = new xajaxResponse('UTF8');

	

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

	

	$miSmarty->assign('arrRegistros', $arrRegistros);

	$objResponse->addAssign("divabonos", "innerHTML", $miSmarty->fetch('sg_paronama_notas_list.tpl'));

	

	

	return $objResponse->getXML();

}



function MuestraRegistro($data, $campo1, $campo2, $obj1, $obj2){

	global $conexion;

	

        $objResponse = new xajaxResponse('UTF8');

	

        $objResponse->addAssign("$obj1", "value", $campo1);

	$objResponse->addAssign("$obj2", "value", $campo2);

	$objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'cboFamilia','sgbodega.familias','','Todas','fa_codigo', 'fa_nombre', '')");

	//$objResponse->addScript("xajax_CargaSubFamilias(xajax.getFormValues('Form1'))");

        return $objResponse->getXML();

}



function CargaDesc($data, $tabla, $campo1, $campo2, $objeto1, $objeto2, $c_and){

    global $conexion;

    $objResponse = new xajaxResponse('UTF8');

	

	//mysql_select_db("sgyonley", $conexion);

	

	$ncorr 		= 	$data["$objeto1"];

	

	if (($tabla == 'sgbodega.tallas') OR ($tabla == 'sgbodega.tallasnew')){

		$sql = "select ta_ncorr, ta_descripcion, ta_busqueda, ta_venta from sgbodega.tallasnew where $campo1 = '".$ncorr."'";

		$res = mysql_query($sql, $conexion);

		

		$objResponse->addAssign("OBLI-txtDescProducto", "value", @mysql_result($res,0,"ta_busqueda")." ".@mysql_result($res,0,"ta_descripcion"));

                $objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'cboFamilia','sgbodega.familias','','Todas','fa_codigo', 'fa_nombre', '')");

	

		//$objResponse->addScript("xajax_CalculaTotalesLinea(xajax.getFormValues('Form1'))");

	

	}else{

		

		$sql = "select $campo2 as descripcion from $tabla where $campo1 = '".$ncorr."' $and";

		$res = mysql_query($sql, $conexion);

		$objResponse->addAssign("$objeto2", "value", @mysql_result($res,0,"descripcion"));

	}	

	

	return $objResponse->getXML();

}

function CargaSelect($data, $select, $tabla, $codigo, $descripcion, $campo1, $campo2, $opt){

    global $conexion;

    $objResponse = new xajaxResponse('UTF8');

	

	$objResponse->addAssign("$select","innerHTML",""); 		

	$sql = "select $campo1 as codigo, $campo2 as descripcion from ".$tabla." $opt";

	$res = mysql_query($sql, $conexion);

	if (mysql_num_rows($res) > 0) {

			$j=0;

			$objResponse->addCreate("$select","option",""); 		

                    $objResponse->addAssign("$select","options[0].value", $codigo);

                    $objResponse->addAssign("$select","options[0].text", $descripcion); 	

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



function CargaSubFamilias($data){

    global $conexion;	

    $objResponse = new xajaxResponse('UTF8');

	

	$familia	=	$data["cboFamilia"];

	

        $objResponse->addAssign("OBLI-txtCodProducto", "value", "");

	$objResponse->addAssign("OBLI-txtDescProducto", "value", "");

	

	$objResponse->addAssign("cboSubFamilia","innerHTML",""); 		

	

	if 	($familia != 'Todas' &&  $familia != ''){

		$sql = "select SF_SUBCODIGO as codigo, SF_NOMBRE as descripcion from sgbodega.subfamilias WHERE SF_CODIGO = '".$familia."' ORDER BY SF_NOMBRE ASC";

	}else{

		$sql = "select SF_SUBCODIGO as codigo, SF_NOMBRE as descripcion from sgbodega.subfamilias WHERE SF_CODIGO != '' group by SF_NOMBRE ORDER BY SF_NOMBRE ASC";

	}	

		$res = mysql_query($sql, $conexion);

		if (mysql_num_rows($res) > 0) {

			$objResponse->addCreate("cboSubFamilia","option",""); 		

			$objResponse->addAssign("cboSubFamilia","options[0].value", '');

			$objResponse->addAssign("cboSubFamilia","options[0].text", 'Todas'); 	

			$j = 1;

			while ($line = mysql_fetch_array($res)) {

				$objResponse->addCreate("cboSubFamilia","option",""); 		

				$objResponse->addAssign("cboSubFamilia","options[".$j."].value", $line[0]);

				$objResponse->addAssign("cboSubFamilia","options[".$j."].text", $line[1]); 	

				$j++;

			}

		}

	//}

	

	return $objResponse->getXML();

}



function CargaPagina($data){

    global $conexion;

    $objResponse = new xajaxResponse('UTF8');

	

	// carga empresas

	$objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'curso','Cursos','','- - Seleccione - -','CodigoCurso','NombreCurso', '')");

	$objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'anio','Periodos','','- - Seleccione - -','distinct AnoAcademico','AnoAcademico', ' where AnoAcademico = ".$_SESSION["sige_anio_escolar_vigente"]	."')");

	

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



function LlamaDetalle($data, $codigo, $descripcion){

    global $conexion;

    $objResponse = new xajaxResponse('UTF8');

	

	$fecha_desde		= 	$data["OBLI-txtFechaDesde"];

	$fecha_hasta		= 	$data["OBLI-txtFechaHasta"];

	$cobrador			= 	$data["OBLI-txtCodCobrador"];

	$nombre_cobrador	= 	$data["OBLI-txtDescCobrador"];

	$empresa 			= 	$data["OBLI-cboEmpresa"];

	$ult_guia 			= 	$data["txtUltGuia"];

	

	list($dia1,$mes1,$anio1) = split('[/.-]', $fecha_desde);$fecha1 	= $anio1."-".$mes1."-".$dia1;

	list($dia2,$mes2,$anio2) = split('[/.-]', $fecha_hasta);$fecha2 	= $anio2."-".$mes2."-".$dia2;

	

	$objResponse->addScript("showPopWin('sg_existencia_movimientos_vendedor_detalle.php?codigo=$codigo&descripcion=$descripcion&fecha1=$fecha1&fecha2=$fecha2&cobrador=$cobrador&empresa=$empresa', '$codigo $descripcion', 700, 280, null);");

	

	return $objResponse->getXML();

}

function Imprime(){

    global $conexion;

    $objResponse = new xajaxResponse('UTF8');

	

	$objResponse->addScript("ImprimeDiv('divabonos');");

	

	return $objResponse->getXML();

}



$xajax->registerFunction("MuestraRegistro");

$xajax->registerFunction("Grabar");

$xajax->registerFunction("Ordenar");

$xajax->registerFunction("CargaPagina");

$xajax->registerFunction("CargaPeriodos");

$xajax->registerFunction("CargaDesc");

$xajax->registerFunction("CargaSelect");

$xajax->registerFunction("LlamaDetalle");

$xajax->registerFunction("CargaSubFamilias");

$xajax->registerFunction("Imprime");



$xajax->processRequests();

$miSmarty->assign('xajax_js', $xajax->getJavascript());





$miSmarty->display('sg_paronama_notas.tpl');





ob_flush();

?>



