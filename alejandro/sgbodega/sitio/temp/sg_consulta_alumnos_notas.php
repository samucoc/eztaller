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



$xajax->setRequestURI("sg_consulta_alumnos_notas.php");

$xajax->setCharEncoding("UTF8");

$xajax->decodeUTF8InputOn();



function ConfirmarNotas($data){

	global $conexion;

	

    $objResponse = new xajaxResponse('UTF8');

	

	$seleccion 	= 	$data['seleccion'];

	$ingresa 	= 	'SI';

	

	if (count($seleccion) > 0){

		if ($ingresa == 'SI'){

			$total = count($seleccion);

			foreach ($data['seleccion'] as $ncorr) {

				$nota = $data['nota_'.$ncorr];

				$arr_nota = explode("_",$ncorr);//{$arrRegistros[registros].rut_alumno}_{$arrRegistros[registros].asignatura}_{$arrRegistros[registros].anio}_{$arrRegistros[registros].curso}_{$arrRegistros[registros].semestre_{$arrRegistros[registros].prueba}

				$select_notas = "select max(NumeroNota) as maximo

								from NotasAlumnos".$anio."

								where  NumeroRutAlumno = '".$arr_nota[0]."' and 

										CodigoCurso = '".$arr_nota[3]."' and 

										CodigoRamo = '".$arr_nota[1]."' and  

										AnoAcademico = '".$arr_nota[2]."' and  

										Semestre = '".$arr_nota[4]."'";

				$res_notas = mysql_query($select_notas, $conexion) or die(mysql_error());

				$row_notas = mysql_fetch_array($res_notas);

				$nro_nota = $row_notas['maximo'] + 1;

				list($dia1,$mes1,$anio1) = explode('-', $data['fecha_'.$ncorr]);

				$fecha_prueba = $anio1.'-'.$mes1.'-'.$dia1;

				$observacion = $data['observacion_'.$ncorr];

				if (($nota<=7)){

					if (($nota!='')){

						$sql_1 = "INSERT INTO `NotasAlumnos".$anio."`(`NumeroRutAlumno`, `AnoAcademico`, `CodigoCurso`, `CodigoRamo`, 

															 `Semestre`, `NumeroNota`, `Prueba`, `Nota`) 

								VALUES ('".$arr_nota[0]."','".$arr_nota[2]."','".$arr_nota[3]."','".$arr_nota[1]."',

										'".$arr_nota[4]."','".$nro_nota."','".$arr_nota[5]."','".$nota."')";

						$res_1 = mysql_query($sql_1,$conexion) or die(mysql_error()); 

						}

					}

				else{

					$objResponse->addAlert("Error al ingresar Nota");	

					}

				}

			}

		}

		

	$objResponse->addScript("xajax_CargaListado(xajax.getFormValues('Form1'))");	

	

    return $objResponse->getXML();

}





function MuestraRegistro($data, $campo1, $campo2, $obj1, $obj2){

	global $conexion;

	

        $objResponse = new xajaxResponse('UTF8');

	

	$objResponse->addAssign("$obj1", "value", $campo1);

	$objResponse->addAssign("$obj2", "value", $campo2);

	if ($obj1 == 'OBLI-txtCodCobrador'){

        	$objResponse->addScript("xajax_CalcularCupo(xajax.getFormValues('Form1'))");

        

            }

	return $objResponse->getXML();

}



function CargaPagina($data){

    global $conexion;

    $objResponse = new xajaxResponse('UTF8');

	

	// carga empresas

	$objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'curso','Cursos','','- - Seleccione - -','CodigoCurso','NombreCurso', '')");

	$objResponse->addScript("xajax_CargaListado(xajax.getFormValues('Form1'))");

	

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

                while ($line = mysql_fetch_array($res)) {

			$objResponse->addCreate("$select","option",""); 		

			$objResponse->addAssign("$select","options[".$j."].value", $line[0]);

			$objResponse->addAssign("$select","options[".$j."].text", $line[1]); 	

			$j++;

		}

	}

	

	return $objResponse->getXML();	

	

	}

function CargaPruebas($data,$codigo_asignaturas){

	global $conexion;

    $objResponse = new xajaxResponse('UTF8');

	

	$select 				= 'pruebas';

	$codigo_curso 			= $data['curso'];

	$anio 					= $data['anio'];

	$semestre 			= $data['semestre'];

	

	$objResponse->addAssign("$select","innerHTML",""); 		

	

	$sql = "select prueba_ncorr as codigo, DescripcionPrueba as descripcion 

			from Pruebas 

			where CodigoRamo = '".$codigo_asignaturas."'  and  

				CodigoCurso = '".$codigo_curso."'  and

				AnoAcademico = '".$anio."' and 

				Semestre = '".$semestre."'";

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

function CargaDesc($data, $tabla, $campo1, $campo2, $objeto1, $objeto2, $c_and){

    global $conexion;

    $objResponse = new xajaxResponse('UTF8');

	

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



function CargaListado($data){

	global $conexion;

	global $miSmarty;

	

    $objResponse = new xajaxResponse('UTF8');

	

	$anio = $_SESSION["sige_anio_escolar_vigente"];



			$objResponse->addAssign("anio","innerHTML",""); 		

	

            $objResponse->addCreate("anio","option",""); 		

			$objResponse->addAssign("anio","options[0].value", '0');

			$objResponse->addAssign("anio","options[0].text", 'Elija');



            $objResponse->addCreate("anio","option",""); 		

			$objResponse->addAssign("anio","options[1].value", $_SESSION["sige_anio_escolar_vigente"]);

			$objResponse->addAssign("anio","options[1].text", $_SESSION["sige_anio_escolar_vigente"]);



	$semestre				=	$data['semestre'];

	if ($anio==''){

		$select_max  ="select PeriodoEstablecimiento,SemestreEstablecimiento

								from Establecimiento

							";

		$res_max = mysql_query($select_max,$conexion)or die(mysql_error());

		$row_max = mysql_fetch_array($res_max);

		$anio					=	$row_max['PeriodoEstablecimiento'];

		$semestre				=	$row_max['SemestreEstablecimiento'];

		}

	$rut					=	$data['rut'];

	

	$miSmarty->assign('nombre_semestre',$semestre.' - '.$anio);

	

			$select_max  ="select CodigoRamo, count(NumeroNota) as maximo

								from Pruebas

							where  Pruebas.CodigoCurso in (select CodigoCurso 

													from alumnos".$anio." 

													where NumeroRutAlumno = '".$rut."' ) and 

									Pruebas.AnoAcademico = '".$anio."' and  

									Pruebas.Semestre = '".$semestre."'

					group by CodigoRamo";

			$res_max = mysql_query($select_max,$conexion)or die(mysql_error());

			$maximo = 0;

			while($row_max = mysql_fetch_array($res_max)){

				if ($maximo < $row_max['maximo']) $maximo = $row_max['maximo'];

				}

			$miSmarty->assign('notas_ingresadas',$maximo);

			

			



	

	$objResponse->addScript("document.getElementById('divlistado').style.display='none';");

	

	$select_nombre_alumno = "select concat(PaternoAlumno, ' ', MaternoAlumno, ' ', NombresAlumno) as nombre_alumno, 

									NombreCurso, Cursos.CodigoCurso

							from alumnos".$anio." 

							inner join Cursos

									on alumnos".$anio.".CodigoCurso = Cursos.CodigoCurso

							where NumeroRutAlumno = '".$rut."'";

	$res_nombre_alumno = mysql_query($select_nombre_alumno,$conexion) or die(mysql_error());

	$row_RA = mysql_fetch_array($res_nombre_alumno);

	

	$miSmarty->assign("nombre_alumno",$row_RA['nombre_alumno']);

	$miSmarty->assign("nombre_curso",$row_RA['NombreCurso']);

	$codigo_curso = $row_RA['CodigoCurso'];



	$objResponse->addAssign('alumno','innerHTML',' - '.$row_RA['nombre_alumno'].' - '.$row_RA['NombreCurso']);

			

	// busca los registros

	$sql_ve = "select  distinct Ramos.CodigoRamo, Ramos.Descripcion

				from alumnos".$anio."

					inner join Asignaturas

						on Asignaturas.CodigoCurso = alumnos".$anio.".CodigoCurso 

					inner join Ramos

						on Ramos.CodigoRamo	= Asignaturas.CodigoRamo 

				where Asignaturas.CodigoCurso in (select CodigoCurso 

													from alumnos".$anio." 

													where NumeroRutAlumno = '".$rut."')

				order by Asignaturas.NumeroOrden";

	

	$res_ve = mysql_query($sql_ve, $conexion);

	if (mysql_num_rows($res_ve) > 0){

		$arrRegistros	= 	array();

		$arrRegistrosDetalle	= 	array();

		$i = 1;

		while ($line_ve = mysql_fetch_row($res_ve)) {

			array_push($arrRegistros, array("item"					=>	$i, 

											"codigo_asignatura"		=>	$line_ve[0],

											"nombre_asignatura"		=> 	$line_ve[1]

											));

			$i++;

			$select_max  ="select CodigoRamo, count(NumeroNota) as maximo

								from Pruebas

							where  Pruebas.CodigoCurso in (select CodigoCurso 

													from alumnos".$anio." 

													where NumeroRutAlumno = '".$rut."' ) and 

									Pruebas.AnoAcademico = '".$anio."' and  

									Pruebas.Semestre = '".$semestre."'

					group by CodigoRamo";

			$res_max = mysql_query($select_max,$conexion)or die(mysql_error());

			$maximo = 0;

			while($row_max = mysql_fetch_array($res_max)){

				if ($maximo < $row_max['maximo']) $maximo = $row_max['maximo'];

				}

			$j=1;

			$k=0;

			$total = 0;

				

			for($o=1;$o<=$maximo;$o++){



				$select_notas = "select Nota

								from NotasAlumnos

									inner join Pruebas

										on Pruebas.NumeroNota = NotasAlumnos.NumeroNota and 

											Pruebas.CodigoCurso = '".$codigo_curso."' and 

											Pruebas.CodigoRamo = '".$line_ve[0]."' and  

											Pruebas.AnoAcademico = '".$anio."' and  

											Pruebas.Semestre = '".$semestre."' 

								where  NotasAlumnos.NumeroRutAlumno = '".$rut."' and 

										NotasAlumnos.CodigoCurso = '".$codigo_curso."' and 

										NotasAlumnos.CodigoRamo = '".$line_ve[0]."' and  

										NotasAlumnos.AnoAcademico = '".$anio."' and  

										NotasAlumnos.Semestre = '".$semestre."' and

										Pruebas.NumeroNota = '".$o."'

										";

				$res_notas = mysql_query($select_notas, $conexion) or die(mysql_error());

				if (mysql_num_rows($res_notas)>0){

					while($row_notas = mysql_fetch_array($res_notas)){

						array_push($arrRegistrosDetalle, array("item"		=>	$j, 

													"rut_alumno"			=> 	$rut, 

													"nota"					=>	$row_notas[0], 

													"codigo_asignatura"		=>	$line_ve[0]

													));

						$total += str_replace(',', '.', $row_notas[0]);

						$j++;

						if ($row_notas[0]>0){

							$k++;

							}

						}

					}

				else{

					array_push($arrRegistrosDetalle, array("item"		=>	$j, 

													"rut_alumno"			=> 	$rut, 

													"nota"					=>	'-', 

													"codigo_asignatura"		=>	$line_ve[0]

													));



					}

				}

			if ($k>0){

				$promedio = $total/$k;

				}

			else{

				$promedio=0;

				}

			

			$promedio = $total/$k;				

			array_push($arrRegistrosDetalle, array("item"					=>	$j, 

															"rut_alumno"			=> 	$line_ve[1], 

															"nota"					=>	number_format($promedio,1,".","," ), 

															"codigo_asignatura"			=>	$line_ve[0]));

			

			}

		$miSmarty->assign('arrRegistros', $arrRegistros);

		$miSmarty->assign('arrRegistrosDetalle', $arrRegistrosDetalle);

		

		$objResponse->addAssign("divabonos", "innerHTML", $miSmarty->fetch('sg_alumnos_notas_list.tpl'));

		

	}else{

		

		$objResponse->addAssign("divabonos", "innerHTML", "No Existen Registros");

	}

	

	$objResponse->addScript("document.getElementById('divlistado').style.display='block';");

	

	

	return $objResponse->getXML();

}

function ModificarNota($data,$rut_alumno,$asignatura,$anio,$curso,$semestre,$prueba,$nro_nota){

	global $conexion;

	

    $objResponse = new xajaxResponse('UTF8');



	$objResponse->addScript("showPopWin('sg_notas_actualizar.php?rut_alumno=".$rut_alumno."&asignatura=".$asignatura."&anio=".$anio."&curso=".$curso."&semestre=".$semestre."&prueba=".$prueba."&nro_nota=".$nro_nota."', 'Actualizar Nota', 800, 600, null);");



	return $objResponse->getXML();

	}



function CargaPeriodos($data){

    global $conexion;

    $objResponse = new xajaxResponse('UTF8');

	

	$objResponse->addAssign("semestre","innerHTML",""); 		

	

	$sql = "select Semestre as codigo, NombrePeriodo as descripcion from Periodos where AnoAcademico = '".$_SESSION["sige_anio_escolar_vigente"]."'";

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

$xajax->registerFunction("CargaListado");

$xajax->registerFunction("ConfirmarNotas");

$xajax->registerFunction("MuestraRegistro");

$xajax->registerFunction("ModificarNota");

$xajax->registerFunction("CargaPagina");

$xajax->registerFunction("CargaAsignaturas");

$xajax->registerFunction("CargaPruebas");

$xajax->registerFunction("CargaDesc");

$xajax->registerFunction("CargaSelect");

$xajax->registerFunction("CargaPeriodos");



$xajax->processRequests();

$miSmarty->assign('xajax_js', $xajax->getJavascript());

$miSmarty->assign('rut', $_GET['rut']);



$miSmarty->display('sg_consulta_alumnos_notas.tpl');



ob_flush();

?>



