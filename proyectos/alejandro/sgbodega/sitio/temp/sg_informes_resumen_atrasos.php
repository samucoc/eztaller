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



$xajax->setRequestURI("sg_informes_resumen_atrasos.php");

$xajax->setCharEncoding("UTF8");

$xajax->decodeUTF8InputOn();







function CargaPagina($data){

    global $conexion;

    $objResponse = new xajaxResponse('UTF8');

	

	 $objResponse->addCreate("anio","option",""); 		

			$objResponse->addAssign("anio","options[0].value", $_SESSION["sige_anio_escolar_vigente"]);

			$objResponse->addAssign("anio","options[0].text", $_SESSION["sige_anio_escolar_vigente"]);





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

            $objResponse->addCreate("semestre","option",""); 		

			$objResponse->addAssign("semestre","options[".$j."].value", '');

			$objResponse->addAssign("semestre","options[".$j."].text", 'Elija'); 

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

	

	$anio					=	$_SESSION["sige_anio_escolar_vigente"];

	$miSmarty->assign('anio', $anio);

	

	$arrRegistros	= 	array();

	$arrRegistrosDetalle	= 	array();

		

	$objResponse->addScript("document.getElementById('divlistado').style.display='none';");

	

	$sql_ve = "select  NombreCurso, CodigoCurso

						from Cursos

				where

				Cursos.CodigoCurso < '399' 

				";

	

	$res_ve = mysql_query($sql_ve, $conexion);



	if (mysql_num_rows($res_ve) > 0){

		$i = 1;

		while ($line_ve = mysql_fetch_row($res_ve)) {



					array_push($arrRegistros, array("item"					=>	$i, 

															"nombre_curso"			=> 	$line_ve[0], 

															"curso"					=> 	$line_ve[1]));

					

					$select_notas = "select COALESCE(count(NumeroRutAlumno),0) as contador, month(FechaAtraso) as mes

									from Atrasos

									where  NumeroRutAlumno in (select NumeroRutAlumno

																from alumnos".$anio."

																where CodigoCurso = '".$line_ve[1]."' )

											and year(FechaAtraso) = '".$anio."'

									group by year(FechaAtraso),month(FechaAtraso)";

					$res_notas = mysql_query($select_notas, $conexion) or die(mysql_error());

					$marzo=$abril=$mayo=$junio=$julio=$agosto=$septiembre=$noviembre=$octubre=$diciembre=$total='';

					while($row_notas = mysql_fetch_array($res_notas)){

						if ($row_notas['mes']=='3'){

							if ($row_notas['contador']!='0'){

								$marzo=$row_notas['contador'];

								$total += $marzo;

								}

							}

						if ($row_notas['mes']=='4'){

							if ($row_notas['contador']!='0'){

								$abril=$row_notas['contador'];

								$total += $abril;

								}

							}

						if ($row_notas['mes']=='5'){

							if ($row_notas['contador']!='0'){

								$mayo=$row_notas['contador'];

								$total += $mayo;

								}

							}

						if ($row_notas['mes']=='6'){

							if ($row_notas['contador']!='0'){

								$junio=$row_notas['contador'];

								$total += $junio;

								}

							}

						if ($row_notas['mes']=='7'){

							if ($row_notas['contador']!='0'){$julio=$row_notas['contador'];

							$total += $julio;}

							}

						if ($row_notas['mes']=='8'){

							if ($row_notas['contador']!='0'){$agosto=$row_notas['contador'];

							$total += $agosto;}

							}

						if ($row_notas['mes']=='9'){

							if ($row_notas['contador']!='0'){$septiembre=$row_notas['contador'];

							$total += $septiembre;}

							}

						if ($row_notas['mes']=='10'){

							if ($row_notas['contador']!='0'){$octubre=$row_notas['contador'];

							$total += $octubre;}

							}

						if ($row_notas['mes']=='11'){

							if ($row_notas['contador']!='0'){$noviembre=$row_notas['contador'];

							$total += $noviembre;}

							}

						if ($row_notas['mes']=='12'){

							if ($row_notas['contador']!='0'){$diciembre=$row_notas['contador'];

							$total += $diciembre;}

							}

						}

					

					array_push($arrRegistrosDetalle, array("item"					=>	$i, 

															"nombre_curso"			=> 	$line_ve[0], 

															"curso"					=> 	$line_ve[1],

															"marzo"				=>	$marzo,

															"abril"				=>	$abril,

															"mayo"				=>	$mayo,

															"junio"				=>	$junio,

															"julio"				=>	$julio,

															"agosto"				=>	$agosto,

															"septiembre"				=>	$septiembre,

															"octubre"				=>	$octubre,

															"noviembre"				=>	$noviembre,

															"diciembre"				=>	$diciembre,

															"total"				=>	$total

															));

					

					}



		$miSmarty->assign('arrRegistros', $arrRegistros);

		$miSmarty->assign('arrRegistrosDetalle', $arrRegistrosDetalle);



		$objResponse->addAssign("divabonos", "innerHTML", $miSmarty->fetch('sg_informes_resumen_atrasos_list.tpl'));

		

	}else{

		

		$objResponse->addAssign("divabonos", "innerHTML", "No Existen Registros".$sql_ve );

	}

	

	$objResponse->addScript("document.getElementById('divlistado').style.display='block';");

	

	

	return $objResponse->getXML();

}



function ConfirmarInasistencia($data,$rut_alumno,$fecha){

	global $conexion;

	

    $objResponse = new xajaxResponse('UTF8');



	$sql = "insert into Inasistencias(NumeroRutAlumno,FechaAtraso) values ('$rut_alumno','$fecha')";

	$res = mysql_query($sql,$conexion) or die(mysql_error());



	$objResponse->addScript("xajax_CargaListado(xajax.getFormValues('Form1'));");



	return $objResponse->getXML();

	}



function EliminarInasistencia($data,$rut_alumno,$fecha){

	global $conexion;

	

    $objResponse = new xajaxResponse('UTF8');



	$sql = "delete from Inasistencias where NumeroRutAlumno = '$rut_alumno' and FechaAtraso = '$fecha'";

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



$miSmarty->display('sg_informes_resumen_atrasos.tpl');



ob_flush();

?>



