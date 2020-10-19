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



$xajax->setRequestURI("sg_informes_resumen_inasistencias.php");

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

	

	 $objResponse->addCreate("anio","option",""); 		

			$objResponse->addAssign("anio","options[0].value", $_SESSION["sige_anio_escolar_vigente"]);

			$objResponse->addAssign("anio","options[0].text", $_SESSION["sige_anio_escolar_vigente"]);



			

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

			$objResponse->addAssign("$select","options[".$j."].text", 'Todos'); 

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

	

	$sql = "select Semestre as codigo, NombrePeriodo as descripcion from Periodos where AnoAcademico = '".$data['anio']."'";

	$res = mysql_query($sql, $conexion);

	

	if (@mysql_num_rows($res) > 0) {

                $j=0;

            $objResponse->addCreate("semestre","option",""); 		

			$objResponse->addAssign("semestre","options[".$j."].value", '');

			$objResponse->addAssign("semestre","options[".$j."].text", 'Todos'); 

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

			for($i=0;$i<$dias_dif;$i++){

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

	

	$anio					=	$_SESSION["sige_anio_escolar_vigente"];

	$miSmarty->assign('anio', $anio);

		

	$Semestre				=	$data['semestre'];

	$Mes					=	$data['mes'];

	$arrRegistros	= 	array();

	$arrRegistrosDetalle	= 	array();

	$arrDias	= 	array();

	$arrCursos	= 	array();





	

	$objResponse->addScript("document.getElementById('divlistado').style.display='none';");

	

	$curso = $data['curso'];

	$and="";

	if (($curso!='')&&($curso!='Elija')&&($curso!='Todos')){

		$and .= " and CodigoCurso = '".$curso."'";

		$miSmarty->assign('curso', $curso);

		

		}

	$sql_ve = "select  NombreCurso, CodigoCurso

						from Cursos

				where

				Cursos.CodigoCurso < '399' $and

				";

	

	$res_ve = mysql_query($sql_ve, $conexion);



	$fecha1		= 	date("Y-m-d",mktime(0,0,0,$Mes,1,$Anio));

	$fecha2		=	date("Y-m-d",mktime(0,0,0,$Mes,date('t',mktime(0,0,0,$Mes,1,$Anio)),$Anio));

	

	$sql_fec 	= 	"SELECT DATEDIFF('".$fecha2."','".$fecha1."') as dias";

	$res_fec 	=	mysql_query($sql_fec,$conexion);

	$dias		=	@mysql_result($res_fec,0,"dias");

	

	$miSmarty->assign('cant_dias',$dias+1);

	for($z=1;$z<=$dias;$z++){

		array_push($arrDias, array("nro_dia" =>	$z)) ;

		}

	array_push($arrDias, array("nro_dia" =>	$dias+1)) ;

		

	if (mysql_num_rows($res_ve) > 0){

		$i = 1;

		while ($line_ve = mysql_fetch_row($res_ve)) {



			array_push($arrRegistros, array("item"					=>	$i, 

															"nombre_curso"			=> 	$line_ve[0], 

															"curso"					=> 	$line_ve[1]));

					

					$select_notas = "select COALESCE(count(NumeroRutAlumno),0) as contador, month(FechaInasistencia) as mes

									from Inasistencias

									where  NumeroRutAlumno in (select NumeroRutAlumno

																from alumnos".$anio."

																where CodigoCurso = '".$line_ve[1]."' )

											AND year(FechaInasistencia) = '".$anio."'

									group by year(FechaInasistencia),month(FechaInasistencia)";

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

		

		$objResponse->addAssign("divabonos", "innerHTML", $miSmarty->fetch('sg_informes_resumen_inasistencias_list.tpl'));

		

	}else{

		

		$objResponse->addAssign("divabonos", "innerHTML", "No Existen Registros".$sql_ve );

	}

	

	$objResponse->addScript("document.getElementById('divlistado').style.display='block';");

	

	

	return $objResponse->getXML();

}



function ConfirmarInasistencia($data,$rut_alumno,$fecha){

	global $conexion;

	

    $objResponse = new xajaxResponse('UTF8');



	$sql = "insert into Inasistencias(NumeroRutAlumno,FechaInasistencia) values ('$rut_alumno','$fecha')";

	$res = mysql_query($sql,$conexion) or die(mysql_error());



	$objResponse->addScript("xajax_CargaListado(xajax.getFormValues('Form1'));");



	return $objResponse->getXML();

	}



function EliminarInasistencia($data,$rut_alumno,$fecha){

	global $conexion;

	

    $objResponse = new xajaxResponse('UTF8');



	$sql = "delete from Inasistencias where NumeroRutAlumno = '$rut_alumno' and FechaInasistencia = '$fecha'";

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



$miSmarty->display('sg_informes_resumen_inasistencias.tpl');



ob_flush();

?>



