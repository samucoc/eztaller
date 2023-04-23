<?php
ob_start();
session_start();

require_once 'includes/xajax/xajax.inc.php'; //archivo de configuracion de ajax
include "../includes/php/conf_smarty.php";//archivo de configuracion de smarty
include "../includes/php/conf_bd.php"; //archivo de coneccion al servidor y base de datos
include "../includes/php/validaciones.php"; 

$xajax = new xajax();
$xajax->setRequestURI("sg_panorama_semestral_asistencia.php");
$xajax->setCharEncoding("UTF8");
$xajax->decodeUTF8InputOn();

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
	if (($curso=='370')||($curso=='380')){
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

		$asistencia = $DiasPeriodo + $DiasPeriodo4medio;
		}
	else{
		$sql_ve = "select sum(DiasPeriodo) as contador
					from Periodos
					where AnoAcademico = '".$anio."'
					";
		
		$res_ve = mysql_query($sql_ve, $conexion);	
		$line_ve = mysql_fetch_row($res_ve);

		$asistencia  = $line_ve[0];
		}
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
	$miSmarty->assign('semestre', $asistencia);
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
					Cursos.CodigoCurso = '".$curso."'  and Matriculas.FechaRetiro = '0000-00-00'
				order by Matriculas.NroLista	"; 

	$res_pd = mysql_query($sql_pd, $conexion);

	if (mysql_num_rows($res_pd) > 0){
			$i 					= 	0;
			array_push($arrNotas, array("item"					=>	$i, 
											"rut_alumno"			=> 	'linea',
											"asignatura" 			=> 	'Falt',
											"CodigoRamo"			=>	'Falt',
											"nota"					=> 	'XXX'
											));

			array_push($arrNotas, array("item"					=>	$i, 
											"rut_alumno"			=> 	'linea',
											"asignatura" 			=> 	'Just',
											"CodigoRamo"			=>	'Just',
											"nota"					=> 	'XXX'
											));

			array_push($arrNotas, array("item"					=>	$i, 
											"rut_alumno"			=> 	'linea',
											"asignatura" 			=> 	'Asis',
											"CodigoRamo"			=>	'Asis',
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
				
				$sql_inasistencia = "select count(FechaInasistencia) as ina
									 from Inasistencias
									 where NumeroRutAlumno = '".$line_pd[2]."' and Year(FechaInasistencia) = '".$anio."'";

				$res_inasistencia = mysql_query($sql_inasistencia,$conexion) or die(mysql_error());
				$row_inasistencia = mysql_fetch_array($res_inasistencia);
				$inasistencia = $row_inasistencia['ina'];

				array_push($arrNotas, array("item"					=>	$i, 
											"rut_alumno"			=> 	$line_pd[2],
											"asignatura" 			=> 	'Falt',
											"CodigoRamo"			=>	'Falt',
											"curso" 				=> 	$curso,
											"anio"					=> 	$anio,
											"semestre"				=>	$semestre,
											"nota"					=> 	$inasistencia,
											"negro"					=>	'1'
											));

				$sql_just = "SELECT TIMESTAMPDIFF(DAY, InicioJusti, TerminoJusti)+1 AS sum_dias_trans
										from Justificativos_Inasistencias
										where NumeroRutAlumno = '".$line_pd[2]."' and Year(InicioJusti) = '".$anio."'";
				$res_just = mysql_query($sql_just,$conexion) or die(mysql_error());
				$just = '';
				while ($row_just = mysql_fetch_array($res_just)){
					$just += $row_just['sum_dias_trans'];
				}
				
				array_push($arrNotas, array("item"					=>	$i, 
											"rut_alumno"			=> 	$line_pd[2],
											"asignatura" 			=> 	'Just',
											"CodigoRamo"			=>	'Just',
											"curso" 				=> 	$curso,
											"anio"					=> 	$anio,
											"semestre"				=>	$semestre,
											"nota"					=> 	$just,
											"negro"					=>	'1'
											));

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
												"negro"					=>	$porc_ina > '85' ? '1': '0'
												));



				array_push($arrRegistros, array("NroLista"				=> 	$line_pd[5], 
												"nombre_alumno"			=> 	$line_pd[3], 
												"rut_alumno"			=> 	$line_pd[2]
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

				if (($curso=='370')||($curso=='380')){
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

					$asistencia = $DiasPeriodo + $DiasPeriodo4medio;
					}
				else{
					$sql_ve = "select sum(DiasPeriodo) as contador
								from Periodos
								where AnoAcademico = '".$anio."'
								";
					
					$res_ve = mysql_query($sql_ve, $conexion);	
					$line_ve = mysql_fetch_row($res_ve);

					$asistencia  = $line_ve[0];
					}

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

	    		}

			//var_dump($arrRegistros);

			// asigno las sesiones para el ordenamiento

			$_SESSION["alycar_matriz"] 				= 	$arrRegistros;
			$miSmarty->assign('arrRegistros', $arrRegistros);
			$miSmarty->assign('arrNotas', $arrNotas);
			$miSmarty->assign('arrRamos', $arrRamos);
			//$objResponse->addScript("xajax_Ordenar(xajax.getFormValues('Form1'), 'familia');");
			$objResponse->addAssign("divabonos", "innerHTML", $miSmarty->fetch('sg_panorama_semestral_asistencia_list.tpl'));

			//$objResponse->addAssign("divabonos", "innerHTML", $sql_saumentos);
	}else{

		$objResponse->addAssign("divabonos", "innerHTML", "No Existen Registros");

	}

	$objResponse->addScript("document.getElementById('divlistado').style.display='block';");

	$objResponse->addScript("para()");

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

	$objResponse->addAssign("divabonos", "innerHTML", $miSmarty->fetch('sg_panorama_semestral_asistencia_list.tpl'));

	

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

function EnivarPDF($data){
	global $conexion;
	
    $objResponse = new xajaxResponse('UTF8');

	$curso                     	=       $data['curso'];
    $anio 						= 		$data["anio"];
	$semestre                   =       $data['semestre'];

	$objResponse->addScript("showPopWin('sg_envia_panorama_semestral_asistencia.php?curso=$curso&anio=$anio&semestre=$semestre', 'Enviar PDF', 600, 200, null);");

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
$xajax->registerFunction("EnivarPDF");



$xajax->processRequests();

$miSmarty->assign('xajax_js', $xajax->getJavascript());



$miSmarty->display('sg_panorama_semestral_asistencia.tpl');



ob_flush();

?>



