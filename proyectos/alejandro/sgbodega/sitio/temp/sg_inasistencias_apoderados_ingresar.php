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



$xajax->setRequestURI("sg_inasistencias_apoderados_ingresar.php");

$xajax->setCharEncoding("UTF8");

$xajax->decodeUTF8InputOn();





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

	

	$objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'anio','Periodos','','- - Seleccione - -','distinct AnoAcademico','AnoAcademico', ' where AnoAcademico = ".$_SESSION["sige_anio_escolar_vigente"]	."')");

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

           $objResponse->addCreate("$select","option",""); 		

			$objResponse->addAssign("$select","options[".$j."].value", $codigo);

			$objResponse->addAssign("$select","options[".$j."].text", $descripcion); 	

			

                while ($line = mysql_fetch_array($res)) {

			$j++;

			$objResponse->addCreate("$select","option",""); 		

			$objResponse->addAssign("$select","options[".$j."].value", $line[0]);

			$objResponse->addAssign("$select","options[".$j."].text", $line[1]); 	

			

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



function CargaMeses($data){

    global $conexion;

    $objResponse = new xajaxResponse('UTF8');

	

	$objResponse->addAssign("mes","innerHTML",""); 		

	

	$sql = "select InicioPeriodo as inicio, TerminoPeriodo as termino 

			from Periodos 

			where AnoAcademico = '".$data['anio']."' and Semestre = '".$data['semestre']."' ";

	$res = mysql_query($sql, $conexion);

	

	if (@mysql_num_rows($res) > 0) {

        $j=0;

        while ($line = mysql_fetch_array($res)) {

			

			$fecha1		= 	$line[0];

			$fecha2		=	$line[1];

				

			$sql_meses = "SELECT TIMESTAMPDIFF(MONTH, '".$fecha1."', '".$fecha2	."') as meses";

			$res_meses = mysql_query($sql_meses,$conexion);

			$row_meses = mysql_fetch_array($res_meses);

			$dias_dif = $row_meses['meses']+1;

			list($anio_1,$mes_1,$dia_1) = explode('-',$fecha1);

			for($i=0;$i<=$dias_dif;$i++){

				$mes_pos = date("m",mktime(0,0,0,$mes_1+$i,1,$data['anio']));

				$objResponse->addCreate("mes","option",""); 		

				$objResponse->addAssign("mes","options[".$i."].value", $mes_pos);

				$mes_ele="";

					switch($mes_pos){

						case '1' : $mes_ele = "Enero";

									break;

						case '2' : $mes_ele = "Febrero";

									break;

						case '3' : $mes_ele = "Marzo";

									break;

						case '4' : $mes_ele = "Abril";

									break;

						case '5' : $mes_ele = "Mayo";

									break;

						case '6' : $mes_ele = "Junio";

									break;

						case '7' : $mes_ele = "Julio";

									break;

						case '8' : $mes_ele = "Agosto";

									break;

						case '9' : $mes_ele = "Septiembre";

									break;

						case '10' : $mes_ele = "Octubre";

									break;

						case '11' : $mes_ele = "Noviembre";

									break;

						case '12' : $mes_ele = "Diciembre";

									break;

						default : break;

						}



				$objResponse->addAssign("mes","options[".$i."].text", $mes_ele); 	

				

				}



			

		}

	}

	

	return $objResponse->getXML();

}







function CargaListado($data){

	global $conexion;

	global $miSmarty;

	

    $objResponse = new xajaxResponse('UTF8');

	

	$Curso 					= 	$data["curso"];

	$Anio					=	$data['anio'];

	$arrRegistros			= 	array();

	$arrRegistrosDetalle	= 	array();

	$arrAlumnos				= 	array();

	



	$objResponse->addScript("document.getElementById('divlistado').style.display='none';");

	



	$sql_al = "select  distinct concat(`PaternoAlumno`,' ',`MaternoAlumno`,' , ',`NombresAlumno`) as nombre_alumno, 

							alumnos".$Anio.".NumeroRutAlumno, 

							NombreCurso, 

							NroLista

					from alumnos".$Anio."

						inner join Cursos

							on alumnos".$Anio.".CodigoCurso = Cursos.CodigoCurso

						inner join Matriculas

							on alumnos".$Anio.".NumeroRutAlumno = Matriculas.NumeroRutAlumno and

								Matriculas.Anio = '".$Anio."'

									where

					Cursos.CodigoCurso = '".$Curso."'

					order by NroLista 

					";

		

	$res_al = mysql_query($sql_al, $conexion) or die(mysql_error());



	

	array_push($arrAlumnos, array( 'rut_alumno' => '-----', 

									'nombre_alumno' => '-----' ));

	while ($line_al = mysql_fetch_row($res_al)) {

		$miSmarty->assign('periodo',$Anio);

		$miSmarty->assign('curso',$line_al[2]);

		array_push($arrAlumnos, array( 	'rut_alumno' => $line_al[1], 

										'nombre_alumno' => $line_al[0] ));

	}



	$sql_fechas = "select fecha, Observacion from ReunionesApoderados where Periodo = '".$Anio."'";

	$res_fechas = mysql_query($sql_fechas,$conexion);



	$total = mysql_num_rows($res_fechas);



	while($row_fechas = mysql_fetch_array($res_fechas)){



		array_push($arrRegistros, array( 'fecha' => $row_fechas['fecha'], 'title'=>$row_fechas['Observacion'] ));

		

		$sql_ve = "select  distinct concat(`PaternoAlumno`,' ',`MaternoAlumno`,' , ',`NombresAlumno`) as nombre_alumno, 

							alumnos".$Anio.".NumeroRutAlumno, 

							NombreCurso, 

							NroLista

					from alumnos".$Anio."

						inner join Cursos

							on alumnos".$Anio.".CodigoCurso = Cursos.CodigoCurso

						inner join Matriculas

							on alumnos".$Anio.".NumeroRutAlumno = Matriculas.NumeroRutAlumno and

								Matriculas.Anio = '".$Anio."'

									where

					Cursos.CodigoCurso = '".$Curso."'

					order by NroLista 

					";

		

		$res_ve = mysql_query($sql_ve, $conexion) or die(mysql_error());

		

		array_push($arrRegistrosDetalle, array( 'fecha' => $row_fechas['fecha'], 

												'rut_alumno' => '-----', 

												'nombre_alumno' => '-----' ));



		while ($line_ve = mysql_fetch_row($res_ve)) {



			$sql_asis = "select FechaInasistencia 

							from AsistenciasApoderados 

							where FechaInasistencia = '".$row_fechas['fecha']."' and 

									NumeroRutAlumno = '".$line_ve[1]."'";

			$res_asis = mysql_query($sql_asis,$conexion);

			$checked = '';

			if (mysql_num_rows($res_asis)>0){

				$checked = 'X';

			}

			array_push($arrRegistrosDetalle, array( 'fecha' 		=> $row_fechas['fecha'], 

													'rut_alumno' 	=> $line_ve[1], 

													'nombre_alumno' => $line_ve[0],

													'checked' 		=> $checked));



		}

	}



	array_push($arrRegistros, array( 'fecha' => 'promedio' ));

		

	array_push($arrRegistrosDetalle, array( 'fecha' => 'promedio', 

											'rut_alumno' => '-----', 

											'nombre_alumno' => '-----' ));



	$sql_ve = "select  distinct concat(`PaternoAlumno`,' ',`MaternoAlumno`,' , ',`NombresAlumno`) as nombre_alumno, 

						alumnos".$Anio.".NumeroRutAlumno, 

						NombreCurso, 

						NroLista

				from alumnos".$Anio."

					inner join Cursos

						on alumnos".$Anio.".CodigoCurso = Cursos.CodigoCurso

					inner join Matriculas

						on alumnos".$Anio.".NumeroRutAlumno = Matriculas.NumeroRutAlumno and

							Matriculas.Anio = '".$Anio."'

								where

				Cursos.CodigoCurso = '".$Curso."'

				order by NroLista 

				";



	$res_ve = mysql_query($sql_ve, $conexion) or die(mysql_error());

	while ($line_ve = mysql_fetch_row($res_ve)) {

		$sql_asis = "select FechaInasistencia

							from AsistenciasApoderados 

							where NumeroRutAlumno = '".$line_ve[1]."'";

		$res_asis = mysql_query($sql_asis,$conexion);

		$contador = mysql_num_rows($res_asis);



		$porc = $contador / $total * 100;

		array_push($arrRegistrosDetalle, array( 'fecha' 		=> 'promedio', 

												'rut_alumno' 	=> $line_ve[1], 

												'nombre_alumno' => $line_ve[0],

												'checked' 		=> $porc. ' %'));

	}

	



	$miSmarty->assign('arrAlumnos', $arrAlumnos);

	$miSmarty->assign('arrRegistros', $arrRegistros);

	$miSmarty->assign('arrRegistrosDetalle', $arrRegistrosDetalle);

	

	$objResponse->addAssign("divabonos", "innerHTML", $miSmarty->fetch('sg_inasistencias_apoderados_ingresar_list.tpl'));



	

	$objResponse->addScript("document.getElementById('divlistado').style.display='block';");

	

	

	return $objResponse->getXML();

}



function ConfirmarInasistencia($data,$rut_alumno,$fecha){

	global $conexion;

	

    $objResponse = new xajaxResponse('UTF8');



    $sql_asis = "select FechaInasistencia 

							from AsistenciasApoderados 

							where FechaInasistencia = '".$fecha."' and 

									NumeroRutAlumno = '".$rut_alumno."'";

	$res_asis = mysql_query($sql_asis,$conexion);

	$checked = '';

	if (mysql_num_rows($res_asis)>0){

		$sql = "delete from AsistenciasApoderados where NumeroRutAlumno = '$rut_alumno' and FechaInasistencia = '$fecha'";

		$res = mysql_query($sql,$conexion) or die(mysql_error());

	}else{

		$sql = "insert into AsistenciasApoderados(NumeroRutAlumno,FechaInasistencia) values ('$rut_alumno','$fecha')";

		$res = mysql_query($sql,$conexion) or die(mysql_error());

	}



	$objResponse->addScript("xajax_CargaListado(xajax.getFormValues('Form1'));");



	return $objResponse->getXML();

	}



function EliminarInasistencia($data,$rut_alumno,$fecha){

	global $conexion;

	

    $objResponse = new xajaxResponse('UTF8');



	$sql = "delete from AsistenciasApoderados where NumeroRutAlumno = '$rut_alumno' and FechaInasistencia = '$fecha'";

	$res = mysql_query($sql,$conexion) or die(mysql_error());



	$objResponse->addScript("xajax_CargaListado(xajax.getFormValues('Form1'));");

	

	return $objResponse->getXML();

	}



$xajax->registerFunction("CargaListado");

$xajax->registerFunction("ConfirmarInasistencia");

$xajax->registerFunction("EliminarInasistencia");

$xajax->registerFunction("MuestraRegistro");

$xajax->registerFunction("CargaPagina");

$xajax->registerFunction("CargaAsignaturas");

$xajax->registerFunction("CargaDesc");

$xajax->registerFunction("CargaSelect");

$xajax->registerFunction("CargaPeriodos");

$xajax->registerFunction("CargaMeses");



$xajax->processRequests();

$miSmarty->assign('xajax_js', $xajax->getJavascript());



$miSmarty->display('sg_inasistencias_apoderados_ingresar.tpl');



ob_flush();

?>



