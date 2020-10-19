<?php
ob_start();
session_start();

require_once 'includes/xajax/xajax.inc.php'; //archivo de configuracion de ajax
include "../includes/php/conf_smarty.php";//archivo de configuracion de smarty
include "../includes/php/conf_bd.php"; //archivo de coneccion al servidor y base de datos
include "../includes/php/validaciones.php"; 
$xajax = new xajax();

$xajax->setRequestURI("sg_borrado_acta_periodo.php");
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

	$curso                     	=       $data['curso'];
    $anio 						= 		$data["anio"];
	 
	$objResponse->addScript("document.getElementById('divlistado').style.display='none';");
	
	$sql_esta = "select NombreEstablecimiento, RBD, Logo, Foto,
						concat(`NombresRepresentante`,' ',`PaternoRepresentante`,' ',`MaternoRepresentante`) as nombre_alumno, 
						DireccionEstablecimiento,
						NumeroDecreto, date_format(FechaDecreto, '%Y') as FechaDecreto, TipoEstablecimiento,
						RegionEstablecimiento,
						ProvinciaEstablecimiento

				from Establecimiento
				";
	$res_esta = mysql_query($sql_esta,$conexion) or die(mysql_error());
	$row_esta = mysql_fetch_array($res_esta);
	
	$rbd_establecimiento = $row_esta['RBD'];
	$NumeroDecreto = $row_esta['NumeroDecreto'];
	$FechaDecreto = $row_esta['FechaDecreto'];
	$RegionEstablecimiento = $row_esta['RegionEstablecimiento'];
	$ProvinciaEstablecimiento = $row_esta['ProvinciaEstablecimiento'];

	$sql_nombre_profe ="select 
				distinct
				DecretoPlanes,
				date_format(FechaDecretoPlanes, '%Y') as FechaDecretoPlanes,
				DecretoEvaluacion,
				date_format(FechaDecretoEvaluacion, '%Y') as FechaDecretoEvaluacion,
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

	$miSmarty->assign('decreto_planes',utf8_decode('N° ').$row_nombre_profe['DecretoPlanes'].' de '.$row_nombre_profe['FechaDecretoPlanes']);
	$miSmarty->assign('DecretoEvaluacion', utf8_decode('N° ').$row_nombre_profe['DecretoEvaluacion'].' de '.$row_nombre_profe['FechaDecretoEvaluacion']);
	$miSmarty->assign('NumeroDecreto', utf8_decode('N° ').$NumeroDecreto.' de '.$FechaDecreto);
	$miSmarty->assign('nombre_curso', $row_nombre_profe['NombreCurso']);
	$miSmarty->assign('RBD', $rbd_establecimiento);
	$miSmarty->assign('semestre', $semestre.' Semestre');
	$miSmarty->assign('anio', $anio);
	$miSmarty->assign('RegionEstablecimiento', $RegionEstablecimiento);
	$miSmarty->assign('ProvinciaEstablecimiento', $ProvinciaEstablecimiento);
	$miSmarty->assign('nombre_profe', $row_nombre_profe['nombre_profesor']);
	
	$sql_pd = "select 
				distinct
				Cursos.NombreCurso,
				concat(`PaternoProfesor`,' ',`MaternoProfesor`,' , ',`NombresProfesor`) as nombre_profesor, 
				alumnos".$anio.".NumeroRutAlumno,
				concat(`PaternoAlumno`,' ',`MaternoAlumno`,' , ',`NombresAlumno`) as nombre_alumno,
				Matriculas.NroMatricula	,
				Matriculas.NroLista	,
				date_format(alumnos".$anio.".FechaNacimiento,'%d/%m/%Y') as FechaNacimiento,
				sexo.n_letra	,
				Comunas.Comuna
				from Cursos
					left join Profesores
						on Cursos.ProfesorJefe = Profesores.NumeroRutProfesor 
					inner join alumnos".$anio."
						on alumnos".$anio.".CodigoCurso = Cursos.CodigoCurso
					left join Comunas
						on alumnos".$anio.".CodigoComuna = Comunas.CodigoComuna
					inner join sexo
						on alumnos".$anio.".SexoAlumno = sexo.sexo_ncorr
					inner join Matriculas
						on alumnos".$anio.".NumeroRutAlumno = Matriculas.NumeroRutAlumno and
							Matriculas.Anio = '".$anio."'
				where
					Cursos.CodigoCurso = '".$curso."' and alumnos".$anio.".Matriculado = '1'
				order by Matriculas.NroLista	"; 
	
	$res_pd = mysql_query($sql_pd, $conexion);
	if (mysql_num_rows($res_pd) > 0){
			$i 					= 	0;

			array_push($arrNotas, array("item"					=>	$i, 
											"rut_alumno"			=> 	'linea',
											"asignatura" 			=> 	'Rut',
											"CodigoRamo"			=>	'Rut',
											"nota"					=> 	'XXX'
											));
			array_push($arrNotas, array("item"					=>	$i, 
											"rut_alumno"			=> 	'linea',
											"asignatura" 			=> 	'Sexo',
											"CodigoRamo"			=>	'Sexo',
											"nota"					=> 	'XXX'
											));
			array_push($arrNotas, array("item"					=>	$i, 
											"rut_alumno"			=> 	'linea',
											"asignatura" 			=> 	'Fecha Nacimiento',
											"CodigoRamo"			=>	'Fecha Nacimiento',
											"nota"					=> 	'XXX'
											));
			array_push($arrNotas, array("item"					=>	$i, 
											"rut_alumno"			=> 	'linea',
											"asignatura" 			=> 	'Comuna',
											"CodigoRamo"			=>	'Comuna',
											"nota"					=> 	'XXX'
											));


			$sql_asignaturas = "select distinct Descripcion , Ramos.CodigoRamo
								from Asignaturas
									inner join Ramos 
										on Ramos.CodigoRamo = Asignaturas.CodigoRamo
								where Asignaturas.CodigoCurso = '".$curso."' and Asignaturas.CalculaPromedio <> '1'
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
											"asignatura" 			=> 	'P Parcial',
											"CodigoRamo"			=>	'P Parcial',
											"nota"					=> 	'XXX'
											));
			array_push($arrNotas, array("item"					=>	$i, 
											"rut_alumno"			=> 	'linea',
											"asignatura" 			=> 	'P Final',
											"CodigoRamo"			=>	'P Final',
											"nota"					=> 	'XXX'
											));
			array_push($arrNotas, array("item"					=>	$i, 
											"rut_alumno"			=> 	'linea',
											"asignatura" 			=> 	'Prom Insuf',
											"CodigoRamo"			=>	'Prom Insuf',
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
											"asignatura" 			=> 	'Sit Final',
											"CodigoRamo"			=>	'Sit Final',
											"nota"					=> 	'XXX'
											));
			array_push($arrNotas, array("item"					=>	$i, 
											"rut_alumno"			=> 	'linea',
											"asignatura" 			=> 	'Obs',
											"CodigoRamo"			=>	'Obs',
											"nota"					=> 	'XXX'
											));
						
			array_push($arrRegistros, array("item"					=>	$i, 
										"NroLista"				=>  'Nro. Lista', 
										"nombre_alumno"			=> 	'Nombre Alumno', 
										"rut_alumno"			=> 	'linea'
										));


			while ($line_pd = mysql_fetch_row($res_pd)) {
				array_push($arrNotas, array("item"					=>	$i, 
												"rut_alumno"			=> 	$line_pd[2],
												"asignatura" 			=> 	'Rut',
												"CodigoRamo"			=>	'Rut',
												"curso" 				=> 	$curso,
												"anio"					=> 	$anio,
												"semestre"				=>	$semestre,
												"nota"					=> 	$line_pd[2].'-'.dv($line_pd[2]),
												"negro"					=>	'1'
												));
				array_push($arrNotas, array("item"					=>	$i, 
												"rut_alumno"			=> 	$line_pd[2],
												"asignatura" 			=> 	'Sexo',
												"CodigoRamo"			=>	'Sexo',
												"curso" 				=> 	$curso,
												"anio"					=> 	$anio,
												"semestre"				=>	$semestre,
												"nota"					=> 	$line_pd[7],
												"negro"					=>	'1'
												));
				array_push($arrNotas, array("item"					=>	$i, 
												"rut_alumno"			=> 	$line_pd[2],
												"asignatura" 			=> 	'Fecha Nacimiento',
												"CodigoRamo"			=>	'Fecha Nacimiento',
												"curso" 				=> 	$curso,
												"anio"					=> 	$anio,
												"semestre"				=>	$semestre,
												"nota"					=> 	$line_pd[6],
												"negro"					=>	'1'
												));
				array_push($arrNotas, array("item"					=>	$i, 
												"rut_alumno"			=> 	$line_pd[2],
												"asignatura" 			=> 	'Comuna',
												"CodigoRamo"			=>	'Comuna',
												"curso" 				=> 	$curso,
												"anio"					=> 	$anio,
												"semestre"				=>	$semestre,
												"nota"					=> 	$line_pd[8],
												"negro"					=>	'1'
												));

				$sql_asignaturas = "select distinct Descripcion , Ramos.CodigoRamo
								from Asignaturas
									inner join Ramos 
										on Ramos.CodigoRamo = Asignaturas.CodigoRamo
								where Asignaturas.CodigoCurso = '".$curso."' and Asignaturas.CalculaPromedio <> '1'
								order by Asignaturas.NumeroOrden";
				$res_asignaturas = mysql_query($sql_asignaturas,$conexion) or die(mysql_error());

				$k = 0;
				$promedio = 0;
				$rojos = 0;
				$sum = 0;
				$l = 0;

				while($row_asignaturas = mysql_fetch_array($res_asignaturas)){
						
						
							$sql_nfa = "SELECT distinct `NumeroRutAlumno`, `AnoAcademico`, `CodigoCurso`, 
												`CodigoRamo`, `NotaFinalCurso` 
										FROM `NotasFinalesAsignaturas` 
										WHERE NumeroRutAlumno = '".$line_pd[2]."' and 
											CodigoRamo = '".$row_asignaturas['CodigoRamo']."' and
											AnoAcademico = '".$anio."' and 
											NotaFinalCurso > 0";
							$res_nfa = mysql_query($sql_nfa,$conexion);
								$row_nfa = mysql_fetch_array($res_nfa);
								$prom_total = $row_nfa['NotaFinalCurso'];

								if (mysql_num_rows($res_nfa)>0){
									$sum+=$prom_total;
									$l++;
								}	
								
								array_push($arrNotas, array("rut_alumno"			=> 	$line_pd[2],
															"asignatura" 			=> 	$row_asignaturas['CodigoRamo'],
															"curso" 				=> 	$curso,
															"anio"					=> 	$anio,
															"nota"					=> 	$prom_total,
															"negro"					=>	'0'
															));
								if ( round($prom_total,1)<4){
									$rojos++;
								}
							
						}
						$promedio = $sum/$l;

						$p_parcial = round($promedio,3,PHP_ROUND_HALF_UP);
						$p_temp = round($p_parcial,2,PHP_ROUND_HALF_UP);
						$p_final = round($p_temp,1,PHP_ROUND_HALF_UP);

						

						array_push($arrNotas, array("rut_alumno"			=> 	$line_pd[2],
														"asignatura" 			=> 	'P Parcial',
														"CodigoRamo"			=>	'P Parcial',
														"curso" 				=> 	$curso,
														"anio"					=> 	$anio,
														"nota"					=> 	str_replace('.', ',', $p_temp),
														"negro"					=>	'0'
														));

						array_push($arrNotas, array("rut_alumno"			=> 	$line_pd[2],
														"asignatura" 			=> 	'P Final',
														"CodigoRamo"			=>	'P Final',
														"curso" 				=> 	$curso,
														"anio"					=> 	$anio,
														"nota"					=> 	str_replace('.', ',',$p_final),
														"negro"					=>	'0'
														));

						array_push($arrNotas, array("rut_alumno"			=> 	$line_pd[2],
														"asignatura" 			=> 	'Prom Insuf',
														"CodigoRamo"			=>	'Prom Insuf',
														"curso" 				=> 	$curso,
														"anio"					=> 	$anio,
														"nota"					=> 	str_replace('.', ',', round($rojos,0)),
														"negro"					=>	'0'
														));

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

							$asistencia = $line_ve[0];
					
							}

						
						$sql_inasistencia = "select count(FechaInasistencia) as ina
											 from Inasistencias
											 where NumeroRutAlumno = '".$line_pd[2]."' and Year(FechaInasistencia) = '".$anio."'";
						$res_inasistencia = mysql_query($sql_inasistencia,$conexion) or die(mysql_error());
						$row_inasistencia = mysql_fetch_array($res_inasistencia);
						$inasistencia = $row_inasistencia['ina'];
						
						$porc_ina = 100-(($inasistencia*100)/$asistencia);
						$porc_ina = number_format($porc_ina , 2 , "." , ",");
						
						$sql_situacion = "select nombre , ObservacionSituacion
											from TiposSituaciones
												inner join SituacionFinal
													on SituacionFinal.Situacion = TiposSituaciones.ts_ncorr
											where AnoAcademico = '".$anio."' and NumeroRutAlumno = '".$line_pd[2]."'
										";
						$res_situacion = mysql_query($sql_situacion,$conexion);
						$row_situacion = mysql_fetch_array($res_situacion);

						$obs_sf = $row_situacion['ObservacionSituacion'];
						
						$sql_fr = "select date_format(FechaRetiro,'%d-%m-%Y') as FechaRetiro
									from Matriculas
									where NumeroRutAlumno = '".$line_pd[2]."'
										and Anio = '".$anio."'";
						$res_fr = mysql_query($sql_fr,$conexion);
						$row_fr = mysql_fetch_array($res_fr);

						if ($row_fr['FechaRetiro']!='00-00-0000'){
							$obs_sf = $row_fr['FechaRetiro'];
							$row_situacion['nombre'] = 'Retirado';
							}



						array_push($arrNotas, array("item"					=>	$i, 
														"rut_alumno"			=> 	$line_pd[2],
														"asignatura" 			=> 	'Asis',
														"CodigoRamo"			=>	'Asis',
														"curso" 				=> 	$curso,
														"anio"					=> 	$anio,
														"nota"					=> 	$porc_ina,
														"negro"					=>	'1'
														));
					
						array_push($arrNotas, array("item"					=>	$i, 
														"rut_alumno"			=> 	$line_pd[2],
														"asignatura" 			=> 	'Sit Final',
														"CodigoRamo"			=>	'Sit Final',
														"curso" 				=> 	$curso,
														"anio"					=> 	$anio,
														"nota"					=> 	$row_situacion['nombre'],
														"negro"					=>	'1'
														));
					
						array_push($arrNotas, array("item"					=>	$i, 
														"rut_alumno"			=> 	$line_pd[2],
														"asignatura" 			=> 	'Obs',
														"CodigoRamo"			=>	'Obs',
														"curso" 				=> 	$curso,
														"anio"					=> 	$anio,
														"nota"					=> 	($obs_sf),
														"negro"					=>	'1'
														));
					


					array_push($arrRegistros, array("NroLista"				=> 	$line_pd[5], 
													"nombre_alumno"			=> 	$line_pd[3], 
													"rut_alumno"			=> 	$line_pd[2]
														));
				}

			
			$sql_asignaturas = "select distinct Descripcion , Ramos.CodigoRamo
								from Asignaturas
									inner join Ramos 
										on Ramos.CodigoRamo = Asignaturas.CodigoRamo
								where Asignaturas.CodigoCurso = '".$curso."'
								order by Asignaturas.NumeroOrden";
			$res_asignaturas = mysql_query($sql_asignaturas,$conexion) or die(mysql_error());
			while($row_asignaturas = mysql_fetch_array($res_asignaturas)){
				array_push($arrRamos, array("asignatura" 			=> 	$row_asignaturas['Descripcion'],
											"CodigoRamo"			=>	$row_asignaturas['CodigoRamo']
											));
				}	 

		       
		//var_dump($arrRegistros);
		// asigno las sesiones para el ordenamiento
		$_SESSION["alycar_matriz"] 				= 	$arrRegistros;
		

		$miSmarty->assign('arrRegistros', $arrRegistros);
		$miSmarty->assign('arrNotas', $arrNotas);
		$miSmarty->assign('arrRamos', $arrRamos);
		
		//$objResponse->addScript("xajax_Ordenar(xajax.getFormValues('Form1'), 'familia');");
		
		$objResponse->addAssign("divabonos", "innerHTML", $miSmarty->fetch('sg_borrado_acta_periodo_list.tpl'));
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
	$objResponse->addAssign("divabonos", "innerHTML", $miSmarty->fetch('sg_borrado_acta_periodo_list.tpl'));
	
	
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
	
	$where  = '"%ADMISION%"';
    $where_1  = '"%EGRESADO%"';
    $where_2  = '"%PROCESO%"';
            
	$objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'curso','Cursos','','- - Seleccione - -','CodigoCurso','NombreCurso', 'where NombreCurso not like ".$where." and NombreCurso not like ".$where_1." and NombreCurso not like ".$where_2." and CodigoCurso in (select distinct CodigoCurso from SituacionFinal where AnoAcademico = ".$_SESSION["sige_anio_escolar_vigente"]." )  ')");
	$objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'anio','Periodos','','- - Seleccione - -','distinct AnoAcademico','AnoAcademico', ' where AnoAcademico = ".$_SESSION["sige_anio_escolar_vigente"]." ')");
	
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


$miSmarty->display('sg_borrado_acta_periodo.tpl');


ob_flush();
?>

