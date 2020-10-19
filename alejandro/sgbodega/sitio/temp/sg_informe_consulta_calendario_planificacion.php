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



$xajax->setRequestURI("sg_informe_consulta_calendario_planificacion.php");

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

								from NotasAlumnos

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

						$sql_1 = "INSERT INTO `NotasAlumnos`(`NumeroRutAlumno`, `AnoAcademico`, `CodigoCurso`, `CodigoRamo`, 

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

	

	$objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'asignaturas','Ramos','','- - Seleccione - -','CodigoRamo','Descripcion', '')");



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



function CargaListado($data){

	global $conexion;

	global $miSmarty;

	

    $objResponse = new xajaxResponse('UTF8');

	

    $arrRegistros = array();



    $fecha_inicio = $data['txtFecha1'];

    list($d,$m,$a) = explode('/', $fecha_inicio);

    $fecha_inicio = $a.'-'.$m.'-'.$d;



    $fecha_fin = $data['txtFecha2'];

	list($d,$m,$a) = explode('/', $fecha_fin);

    $fecha_fin = $a.'-'.$m.'-'.$d;



    $curso = $data['curso'];

    if (($curso!='')&&($curso!='Elija')){



    	$and = ' and Cursos.CodigoCurso = "'.$curso.'" ';



    	}



	$asignaturas = $data['asignaturas'];

    if (($asignaturas!='')&&($asignaturas!='Elija')){



    	$and .= ' and Ramos.CodigoRamo = "'.$asignaturas.'" ';



    	}





    $sql_busca = "select Cursos.NombreCurso, Ramos.Descripcion, 

    					concat(PaternoProfesor,' ',MaternoProfesor,' , ',NombresProfesor) as profesor,

    					NumeroNota, date_format(FechaPrueba, '%d/%m/%Y') as FechaPrueba, DescripcionPrueba, DescripcionPlazo,

    					insuficiente, suficiente, bueno, muy_bueno

    				from gescolcl_nmva_administracion.Pruebas

    					inner join gescolcl_nmva_administracion.Cursos

    						on Cursos.CodigoCurso = Pruebas.CodigoCurso

						inner join gescolcl_nmva_administracion.Ramos

							on Ramos.CodigoRamo = Pruebas.CodigoRamo

						inner join gescolcl_nmva_administracion.Profesores

							on Pruebas.NumeroRutProfesor = Profesores.NumeroRutProfesor

						inner join gescolcl_nmva_administracion.PlazoPruebas

							on Pruebas.CodigoPlazo = PlazoPruebas.CodigoPlazo

					where FechaPrueba between '".$fecha_inicio."' and '".$fecha_fin."'	$and

					order by FechaPrueba, Cursos.CodigoCurso";



	$res_busca = mysql_query($sql_busca,$conexion);



	while($row_busca = mysql_fetch_array($res_busca)){

		$total = $row_busca['insuficiente'] + $row_busca['suficiente'] + $row_busca['bueno'] + $row_busca['muy_bueno'];



		$row_busca['insuficiente'] = round(($row_busca['insuficiente']/$total)*100);

		$row_busca['suficiente'] =  round(($row_busca['suficiente']/$total)*100);

		$row_busca['bueno'] =  round(($row_busca['bueno']/$total)*100);

		$row_busca['muy_bueno'] =  round(($row_busca['muy_bueno']/$total)*100);



		array_push($arrRegistros, array(	"NombreCurso"			=> 	$row_busca['NombreCurso'], 

											"Descripcion"			=> 	$row_busca['Descripcion'],

											"profesor" 				=> 	$row_busca['profesor'],

											"NumeroNota" 			=> 	$row_busca['NumeroNota'],

											"FechaPrueba"			=> 	$row_busca['FechaPrueba'],

											"DescripcionPrueba"		=>	$row_busca['DescripcionPrueba'],

											"DescripcionPlazo"		=> 	$row_busca['DescripcionPlazo'],

											"insuficiente"		=> 	$row_busca['insuficiente'],

											"suficiente"		=> 	$row_busca['suficiente'],

											"bueno"				=> 	$row_busca['bueno'],

											"muy_bueno"			=> 	$row_busca['muy_bueno']

											));

			





		}

	

	$miSmarty->assign('arrRegistros', $arrRegistros);

	$objResponse->addAssign("divabonos", "innerHTML", $miSmarty->fetch('sg_informe_consulta_calendario_planificacion_list.tpl'));		



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

	

	$sql = "select Semestre as codigo, NombrePeriodo as descripcion from Periodos where AnoAcademico = '".$data['anio']."'";

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



$miSmarty->display('sg_informe_consulta_calendario_planificacion.tpl');



ob_flush();

?>



