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



$xajax->setRequestURI("sg_profesores_HojaVida.php");

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

								from Notasalumnos".$anio."

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

						$sql_1 = "INSERT INTO `Notasalumnos".$anio."`(`NumeroRutAlumno`, `AnoAcademico`, `CodigoCurso`, `CodigoRamo`, 

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





	$fecha1					=	$data['fecha1'];

	if ($fecha1==''){

		$sql = "select InicioPeriodo as inicio

			from Periodos 

			where AnoAcademico in (select PeriodoEstablecimiento from Establecimiento) and 

				  Semestre in (select SemestreEstablecimiento from Establecimiento) ";

		$res = mysql_query($sql, $conexion);

		$row = mysql_fetch_array($res);

		$fecha1 = $row['inicio'];

		}

	$fecha2					=	$data['fecha2'];

	if ($fecha2==''){		

		$sql = "select TerminoPeriodo as inicio

			from Periodos 

			where AnoAcademico in (select PeriodoEstablecimiento from Establecimiento) and 

				  Semestre in (select SemestreEstablecimiento from Establecimiento) ";

		$res = mysql_query($sql, $conexion);

		$row = mysql_fetch_array($res);

		$fecha2 = $row['inicio'];

		}

	$rut					=	$data['rut'];

	

	list($dia1,$mes1,$anio1) = explode('-', $fecha1);

    $fecha1 	= $anio."-".$mes1."-".$anio1;

                                    

	list($dia1,$mes1,$anio1) = explode('-', $fecha2);

	$fecha2 	= $anio."-".$mes1."-".$anio1;

                                    

	

	$objResponse->addScript("document.getElementById('divlistado').style.display='none';");

	

	$select_nombre_alumno = "select concat(PaternoAlumno, ' ', MaternoAlumno, ' ', NombresAlumno) as nombre_alumno, NombreCurso

							from alumnos".$anio." 

							inner join Cursos

									on alumnos".$anio.".CodigoCurso = Cursos.CodigoCurso

							where NumeroRutAlumno = '".$rut."'";

	$res_nombre_alumno = mysql_query($select_nombre_alumno,$conexion) or die(mysql_error());

	$row_RA = mysql_fetch_array($res_nombre_alumno);

	

	$miSmarty->assign("nombre_alumno",$row_RA['nombre_alumno']);

	$miSmarty->assign("nombre_curso",$row_RA['NombreCurso']);

	$objResponse->addAssign('alumno','innerHTML',' - '.$row_RA['nombre_alumno'].' - '.$row_RA['NombreCurso']);

				

		

	// busca los registros

	$sql_ve = "select FechaHojaVida, DescripcionHojaVida, ObservacionHojaVida, TipoHojaVidaProfesores.nombre, 

						DescripcionMotivo

				from HojasDeVidaProfesores

					inner join TipoHojaVidaProfesores

						on HojasDeVidaProfesores.TipoHojaVida = TipoHojaVidaProfesores.thv_ncorr

					inner join MotivoAnotacionesProfesores

						on MotivoAnotacionesProfesores.CodigoMotivo = HojasDeVidaProfesores.CodigoMotivo

				where NumeroRutProfesor = '".$rut."' and FechaHojaVida between '".$fecha1."' and '".$fecha2."'

				order by FechaHojaVida";

	

	$res_ve = mysql_query($sql_ve, $conexion);

	if (mysql_num_rows($res_ve) > 0){

		$arrRegistros	= 	array();

		$i = 1;

		while ($line_ve = mysql_fetch_row($res_ve)) {



			$sql_001 = "select Descripcion 

						from Ramos 

						where CodigoRamo = '".$line_ve[5]."'";

			$res_001 = mysql_query($sql_001, $conexion);

			$row_001 = mysql_fetch_array($res_001);





			array_push($arrRegistros, array("item"					=>	$i, 

											"FechaHojaVida"			=>	$line_ve[0],

											"DescripcionHojaVida"	=>	$line_ve[1],

											"ObservacionHojaVida"	=>	$line_ve[2],

											"nombre"				=>	$line_ve[3],

											"DescripcionMotivo"		=>	$line_ve[4],

											"ramo"					=>	$row_001['Descripcion']

											));

			$i++;

			

			}

		$miSmarty->assign('arrRegistros', $arrRegistros);

		

		$objResponse->addAssign("divabonos", "innerHTML", $miSmarty->fetch('sg_profesores_HojaVida_list.tpl'));

		

	}else{

		

		$objResponse->addAssign("divabonos", "innerHTML", "No Existen Registros");

	}

	

	$objResponse->addScript("document.getElementById('divlistado').style.display='block';");

	

	

	return $objResponse->getXML();

}



// function ModificarNota($data,$rut_alumno,$asignatura,$anio,$curso,$semestre,$prueba,$nro_nota){

// 	global $conexion;

	

//     $objResponse = new xajaxResponse('UTF8');



// 	$objResponse->addScript("showPopWin('sg_notas_actualizar.php?rut_alumno=".$rut_alumno."&asignatura=".$asignatura."&anio=".$anio."&curso=".$curso."&semestre=".$semestre."&prueba=".$prueba."&nro_nota=".$nro_nota."', 'Actualizar Nota', 800, 600, null);");



// 	return $objResponse->getXML();

// 	}



$xajax->registerFunction("CargaListado");

$xajax->registerFunction("ConfirmarNotas");

$xajax->registerFunction("MuestraRegistro");

$xajax->registerFunction("ModificarNota");

$xajax->registerFunction("CargaPagina");

$xajax->registerFunction("CargaAsignaturas");

$xajax->registerFunction("CargaPruebas");

$xajax->registerFunction("CargaDesc");

$xajax->registerFunction("CargaSelect");



$xajax->processRequests();

$miSmarty->assign('xajax_js', $xajax->getJavascript());

$miSmarty->assign('rut', $_GET['rut']);



$miSmarty->display('sg_profesores_HojaVida.tpl');



ob_flush();

?>



