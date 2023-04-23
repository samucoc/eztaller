<?php
ob_start();
session_start();

require_once 'includes/xajax/xajax.inc.php'; //archivo de configuracion de ajax
include "../includes/php/conf_smarty.php";//archivo de configuracion de smarty
include "../includes/php/conf_bd.php"; //archivo de coneccion al servidor y base de datos
include "../includes/php/validaciones.php"; 
$xajax = new xajax();

$xajax->setRequestURI("sg_panorama_anual_periodo.php");
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

    $t_p_final = $t_rojos = $t_porc_ina = $t_atrasos = $t_positiva = $t_negativa = 	0;
	 
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
				Matriculas.NroLista	,
				date_format(alumnos".$anio.".FechaNacimiento,'%d/%m/%Y') as FechaNacimiento,
				alumnos".$anio.".SexoAlumno	,
				Comunas.Comuna
				from Cursos
					left join Profesores
						on Cursos.ProfesorJefe = Profesores.NumeroRutProfesor 
					inner join alumnos".$anio."
						on alumnos".$anio.".CodigoCurso = Cursos.CodigoCurso
					left join Comunas
						on alumnos".$anio.".CodigoComuna = Comunas.CodigoComuna
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
											"asignatura" 			=> 	'Promedio',
											"CodigoRamo"			=>	'Promedio',
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
								where Asignaturas.CodigoCurso = '".$curso."' and Asignaturas.CalculaPromedio <> '1'
								order by Asignaturas.NumeroOrden";
				$res_asignaturas = mysql_query($sql_asignaturas,$conexion) or die(mysql_error());

				$k = 0;
				$promedio = 0;
				$rojos = 0;
				$sum = 0;
				$l = 0;

				while($row_asignaturas = mysql_fetch_array($res_asignaturas)){
					if (($curso=='310')||($curso=='320')||($curso=='330')||($curso=='340')){
						if ($row_asignaturas['CodigoRamo']=='ENAT'){
							$sql_semestres = "select Semestre
										from Periodos
										where AnoAcademico = '".$anio."'";
							$res_semestres = mysql_query($sql_semestres,$conexion);
							while($row_semestres = mysql_fetch_array($res_semestres)){
								$semestre = $row_semestres['Semestre'];
								$sql_notas = "select avg(Nota) as promedio, CodigoCurso, CodigoRamo, Semestre, NumeroRutAlumno
												from NotasAlumnos
												where CodigoRamo in ('BIO','FIS','QUIM') and 
													  NumeroRutAlumno = '".$line_pd[2]."' and 
													  AnoAcademico = '".$anio."' and  
													  Semestre = '".$row_semestres['Semestre']."' and
													  Nota > 0
												group by Semestre, CodigoCurso, NumeroRutAlumno";
								$res_notas = mysql_query($sql_notas,$conexion) or die(mysql_error());
								if (mysql_num_rows($res_notas)==0){
									array_push($arrNotas, array("rut_alumno"			=> 	$line_pd[2],
																"asignatura" 			=> 	'ENAT',
																"curso" 				=> 	$curso,
																"anio"					=> 	$anio,
																"semestre"				=>	$row_semestres['Semestre'],
																"nota"					=> 	'0',
																"negro"					=>	'0'
																));

									}
								else{
									while ($row_notas = mysql_fetch_array($res_notas)) {
										array_push($arrNotas, array("rut_alumno"			=> 	$row_notas['NumeroRutAlumno'],
																"asignatura" 			=> 	'ENAT',
																"curso" 				=> 	$row_notas['CodigoCurso'],
																"anio"					=> 	$anio,
																"semestre"				=>	$semestre,
																"nota"					=> 	str_replace('.', ',', round($row_notas['promedio'],1)),
																"negro"					=>	'0'
																));
										}
									}
								}
								$sql_notas = "select avg(Nota) as promedio, CodigoCurso, CodigoRamo, Semestre, NumeroRutAlumno
												from NotasAlumnos
												where CodigoRamo in ('BIO','FIS','QUIM') and 
													  NumeroRutAlumno = '".$line_pd[2]."' and 
													  AnoAcademico = '".$anio."' and  
													  Nota > 0
												group by CodigoCurso, NumeroRutAlumno";
								$res_notas = mysql_query($sql_notas,$conexion) or die(mysql_error());
								if (mysql_num_rows($res_notas)==0){
									array_push($arrNotas, array("rut_alumno"			=> 	$line_pd[2],
																"asignatura" 			=> 	'ENAT',
																"curso" 				=> 	$curso,
																"anio"					=> 	$anio,
																"semestre"				=>	$row_semestres['Semestre'],
																"nota"					=> 	'0',
																"negro"					=>	'0'
																));

									}
								else{
									while ($row_notas = mysql_fetch_array($res_notas)) {
										$ww = count($arrNotas) - 1;
										$ww_ant = $ww - 1;
										$promedio_1  = str_replace(',', '.', $arrNotas[$ww_ant]['nota']);
										$promedio_2  = str_replace(',', '.', $arrNotas[$ww]['nota']);

										$prom_total = $promedio_1 + $promedio_2;

										if (($promedio_2>0)&&($promedio_1>0))
											$prom_total = $prom_total/2;
										
										$prom_total = round($prom_total,1,PHP_ROUND_HALF_UP);

										$sql_bonifica = "select bonifica, criterio, bonificacion
															from Asignaturas
															where bonifica = '0' and
																CodigoRamo = '".$row_asignaturas['CodigoRamo']."' and
																CodigoCurso = '".$curso."'
															";
										$res_bonifica = mysql_query($sql_bonifica,$conexion);
										if (mysql_num_rows($res_bonifica)>0){
											$row_bonifica = mysql_fetch_array($res_bonifica);
											$criterio = $row_bonifica['criterio'];
											$bonificacion = $row_bonifica['bonificacion'];
											if ($prom_total>=$criterio){
												$bonificacion = $bonificacion/10;
												$prom_total = $prom_total+ $bonificacion;
												}
											if ($prom_total>'7')$prom_total='7';
											}
			
										$prom_total = round($prom_total,1,PHP_ROUND_HALF_UP);

										$sum = $sum + $prom_total;
										$l++;
										array_push($arrNotas, array("rut_alumno"			=> 	$row_notas['NumeroRutAlumno'],
																"asignatura" 			=> 	'ENAT',
						 										"curso" 				=> 	$curso,
																"anio"					=> 	$anio,
																"semestre"				=>	$semestre,
																"nota"				=> 	str_replace('.', ',', round($prom_total,1,PHP_ROUND_HALF_UP)),
																"negro"					=>	'0'
																));
										if ( round($prom_total,1,PHP_ROUND_HALF_UP)<4){									
											$rojos++;
											}
										}
									}		
								}
							else{
								$sql_semestres = "select Semestre
													from Periodos
													where AnoAcademico = '".$anio."'";
								$res_semestres = mysql_query($sql_semestres,$conexion);
								while($row_semestres = mysql_fetch_array($res_semestres)){
									$semestre = $row_semestres['Semestre'];
									$sql_notas = "select avg(Nota) as promedio, CodigoCurso, CodigoRamo, Semestre, NumeroRutAlumno
													from NotasAlumnos
													where CodigoRamo = '".$row_asignaturas['CodigoRamo']."' and 
														  NumeroRutAlumno = '".$line_pd[2]."' and 
														  AnoAcademico = '".$anio."' and  
														  Semestre = '".$row_semestres['Semestre']."' and
														  Nota > 0
													group by Semestre, CodigoCurso, CodigoRamo, NumeroRutAlumno";
									$res_notas = mysql_query($sql_notas,$conexion) or die(mysql_error());
									if (mysql_num_rows($res_notas)==0){
										array_push($arrNotas, array("rut_alumno"			=> 	$line_pd[2],
																	"asignatura" 			=> 	$row_asignaturas['CodigoRamo'],
																	"curso" 				=> 	$curso,
																	"anio"					=> 	$anio,
																	"semestre"				=>	$row_semestres['Semestre'],
																	"nota"					=> 	'0',
																	"negro"					=>	'0'
																	));

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
											}
										}
									}
									$sql_notas = "select avg(Nota) as promedio, CodigoCurso, CodigoRamo, Semestre, NumeroRutAlumno
													from NotasAlumnos
													where CodigoRamo = '".$row_asignaturas['CodigoRamo']."' and 
														  NumeroRutAlumno = '".$line_pd[2]."' and 
														  AnoAcademico = '".$anio."' and  
														  Nota > 0
													group by CodigoCurso, CodigoRamo, NumeroRutAlumno";
									$res_notas = mysql_query($sql_notas,$conexion) or die(mysql_error());
									if (mysql_num_rows($res_notas)==0){
										array_push($arrNotas, array("rut_alumno"			=> 	$line_pd[2],
																	"asignatura" 			=> 	$row_asignaturas['CodigoRamo'],
																	"curso" 				=> 	$curso,
																	"anio"					=> 	$anio,
																	"semestre"				=>	$row_semestres['Semestre'],
																	"nota"					=> 	'0',
																	"negro"					=>	'0'
																	));

										}
									else{
										while ($row_notas = mysql_fetch_array($res_notas)) {
											$ww = count($arrNotas) - 1;
											$ww_ant = $ww - 1;
											$promedio_1  = str_replace(',', '.', $arrNotas[$ww_ant]['nota']);
											$promedio_2  = str_replace(',', '.', $arrNotas[$ww]['nota']);

											$prom_total = $promedio_1 + $promedio_2;

											if (($promedio_2>0)&&($promedio_1>0))
												$prom_total = $prom_total/2;
											
											$prom_total = round($prom_total,1,PHP_ROUND_HALF_UP);

											$sql_bonifica = "select bonifica, criterio, bonificacion
																from Asignaturas
																where bonifica = '0' and
																	CodigoRamo = '".$row_asignaturas['CodigoRamo']."' and
																	CodigoCurso = '".$curso."'
																";
											$res_bonifica = mysql_query($sql_bonifica,$conexion);
											if (mysql_num_rows($res_bonifica)>0){
												$row_bonifica = mysql_fetch_array($res_bonifica);
												$criterio = $row_bonifica['criterio'];
												$bonificacion = $row_bonifica['bonificacion'];
												if ($prom_total>=$criterio){
													$bonificacion = $bonificacion/10;
													$prom_total = $prom_total+ $bonificacion;
													}
												if ($prom_total>'7')$prom_total='7';
												}
				
											$prom_total = round($prom_total,1,PHP_ROUND_HALF_UP);

											$sum = $sum + $prom_total;
											$l++;
											array_push($arrNotas, array("rut_alumno"			=> 	$row_notas['NumeroRutAlumno'],
																	"asignatura" 			=> 	$row_asignaturas['CodigoRamo'],
							 										"curso" 				=> 	$curso,
																	"anio"					=> 	$anio,
																	"semestre"				=>	$semestre,
																	"nota"				=> 	str_replace('.', ',', round($prom_total,1,PHP_ROUND_HALF_UP)),
																	"negro"					=>	'0'
																	));
											if ( round($prom_total,1,PHP_ROUND_HALF_UP)<4){									
												$rojos++;
												}
											}
										}
									}
							}
					else{
						$sql_semestres = "select Semestre
											from Periodos
											where AnoAcademico = '".$anio."'";
						$res_semestres = mysql_query($sql_semestres,$conexion);
						while($row_semestres = mysql_fetch_array($res_semestres)){
							$semestre = $row_semestres['Semestre'];
							$sql_notas = "select avg(Nota) as promedio, CodigoCurso, CodigoRamo, Semestre, NumeroRutAlumno
											from NotasAlumnos
											where CodigoRamo = '".$row_asignaturas['CodigoRamo']."' and 
												  NumeroRutAlumno = '".$line_pd[2]."' and 
												  AnoAcademico = '".$anio."' and  
												  Semestre = '".$row_semestres['Semestre']."' and
												  Nota > 0
											group by Semestre, CodigoCurso, CodigoRamo, NumeroRutAlumno";
							$res_notas = mysql_query($sql_notas,$conexion) or die(mysql_error());
							if (mysql_num_rows($res_notas)==0){
								array_push($arrNotas, array("rut_alumno"			=> 	$line_pd[2],
															"asignatura" 			=> 	$row_asignaturas['CodigoRamo'],
															"curso" 				=> 	$curso,
															"anio"					=> 	$anio,
															"semestre"				=>	$row_semestres['Semestre'],
															"nota"					=> 	'0',
															"negro"					=>	'0'
															));

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
									}
								}
							}
							$sql_notas = "select avg(Nota) as promedio, CodigoCurso, CodigoRamo, Semestre, NumeroRutAlumno
											from NotasAlumnos
											where CodigoRamo = '".$row_asignaturas['CodigoRamo']."' and 
												  NumeroRutAlumno = '".$line_pd[2]."' and 
												  AnoAcademico = '".$anio."' and  
												  Nota > 0
											group by CodigoCurso, CodigoRamo, NumeroRutAlumno";
							$res_notas = mysql_query($sql_notas,$conexion) or die(mysql_error());
							if (mysql_num_rows($res_notas)==0){
								array_push($arrNotas, array("rut_alumno"			=> 	$line_pd[2],
															"asignatura" 			=> 	$row_asignaturas['CodigoRamo'],
															"curso" 				=> 	$curso,
															"anio"					=> 	$anio,
															"semestre"				=>	$row_semestres['Semestre'],
															"nota"					=> 	'0',
															"negro"					=>	'0'
															));

								}
							else{
								while ($row_notas = mysql_fetch_array($res_notas)) {
									$ww = count($arrNotas) - 1;
									$ww_ant = $ww - 1;
									$promedio_1  = str_replace(',', '.', $arrNotas[$ww_ant]['nota']);
									$promedio_2  = str_replace(',', '.', $arrNotas[$ww]['nota']);

									$prom_total = $promedio_1 + $promedio_2;

									if (($promedio_2>0)&&($promedio_1>0))
										$prom_total = $prom_total/2;
									
									$prom_total = round($prom_total,1,PHP_ROUND_HALF_UP);

									$sql_bonifica = "select bonifica, criterio, bonificacion
														from Asignaturas
														where bonifica = '0' and
															CodigoRamo = '".$row_asignaturas['CodigoRamo']."' and
															CodigoCurso = '".$curso."'
														";
									$res_bonifica = mysql_query($sql_bonifica,$conexion);
									if (mysql_num_rows($res_bonifica)>0){
										$row_bonifica = mysql_fetch_array($res_bonifica);
										$criterio = $row_bonifica['criterio'];
										$bonificacion = $row_bonifica['bonificacion'];
										if ($prom_total>=$criterio){
											$bonificacion = $bonificacion/10;
											$prom_total = $prom_total+ $bonificacion;
											}
										if ($prom_total>'7')$prom_total='7';
										}
		
									$prom_total = round($prom_total,1,PHP_ROUND_HALF_UP);

									$sum = $sum + $prom_total;
									$l++;
									array_push($arrNotas, array("rut_alumno"			=> 	$row_notas['NumeroRutAlumno'],
															"asignatura" 			=> 	$row_asignaturas['CodigoRamo'],
					 										"curso" 				=> 	$curso,
															"anio"					=> 	$anio,
															"semestre"				=>	$semestre,
															"nota"				=> 	str_replace('.', ',', round($prom_total,1,PHP_ROUND_HALF_UP)),
															"negro"					=>	'0'
															));
									if ( round($prom_total,1,PHP_ROUND_HALF_UP)<4){									
										$rojos++;
										}
									}
								}
							}
						}
						
						$promedio = $sum/$l;

						$p_parcial = round($promedio,3,PHP_ROUND_HALF_UP);
						$p_temp = round($p_parcial,2,PHP_ROUND_HALF_UP);
						$p_final = round($p_temp,1,PHP_ROUND_HALF_UP);



						array_push($arrNotas, array("rut_alumno"			=> 	$line_pd[2],
														"asignatura" 			=> 	'Promedio',
														"CodigoRamo"			=>	'Promedio',
														"curso" 				=> 	$curso,
														"anio"					=> 	$anio,
														"semestre"				=>	$semestre,
														"nota"					=> 	str_replace('.', ',', round($p_final,1,PHP_ROUND_HALF_UP)),
														"negro"					=>	'0'
														));

						$t_p_final += $p_final;
						
						array_push($arrNotas, array("rut_alumno"			=> 	$line_pd[2],
														"asignatura" 			=> 	'Prom Insuf',
														"CodigoRamo"			=>	'Prom Insuf',
														"curso" 				=> 	$curso,
														"anio"					=> 	$anio,
														"semestre"				=>	$semestre,
														"nota"					=> 	str_replace('.', ',', round($rojos,0)),
														"negro"					=>	'0'
														));
						$t_rojos += $rojos;
						

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
														"nota"					=> 	str_replace('.', ',', $porc_ina),
														"negro"					=>	'1'
														));
						$t_porc_ina += $porc_ina;

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
						$t_atrasos += $atrasos;
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
						$t_positiva += $positiva;
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
						$t_negativa += $negativa;
							


					$i++;
					array_push($arrRegistros, array("NroLista"				=> 	$line_pd[5], 
													"nombre_alumno"			=> 	$line_pd[3], 
													"rut_alumno"			=> 	$line_pd[2]
														));
				}

			
			$sql_asignaturas = "select distinct Descripcion , Ramos.CodigoRamo
								from Asignaturas
									inner join Ramos 
										on Ramos.CodigoRamo = Asignaturas.CodigoRamo
								where Asignaturas.CodigoCurso = '".$curso."' and CalculaPromedio <> '1'
								order by Asignaturas.NumeroOrden";
			$res_asignaturas = mysql_query($sql_asignaturas,$conexion) or die(mysql_error());
			while($row_asignaturas = mysql_fetch_array($res_asignaturas)){
				array_push($arrRamos, array("asignatura" 			=> 	$row_asignaturas['Descripcion'],
											"CodigoRamo"			=>	$row_asignaturas['CodigoRamo']
											));
				}	 
			if (($curso=='310')||($curso=='320')||($curso=='330')||($curso=='340')){
				array_push($arrRamos, array("asignatura" 			=> 	'Ciencias Naturales',
											"CodigoRamo"			=>	'ENAT'
											));
				}

		array_push($arrRegistros, array("NroLista"				=> 	'--' ,
										"nombre_alumno"			=> 	'RESUMEN DEL CURSO', 
										"rut_alumno"			=> 	'Promedios',
										'derecha'				=> 	'1'
										));

			$sql_asignaturas = "select distinct Descripcion , Ramos.CodigoRamo
								from Asignaturas
									inner join Ramos 
										on Ramos.CodigoRamo = Asignaturas.CodigoRamo
								where Asignaturas.CodigoCurso = '".$curso."' and Asignaturas.CalculaPromedio <> '1'
								order by Asignaturas.NumeroOrden";
			$res_asignaturas = mysql_query($sql_asignaturas,$conexion) or die(mysql_error());
			while($row_asignaturas = mysql_fetch_array($res_asignaturas)){
				

					$sql_notas = "select avg(Nota) as promedio, CodigoCurso, CodigoRamo, Semestre
									from NotasAlumnos
									where CodigoRamo = '".$row_asignaturas['CodigoRamo']."' and 
										  CodigoCurso = '".$curso."' and 
										  AnoAcademico = '".$anio."' and  
										  Nota > 0
									group by AnoAcademico, Semestre, CodigoCurso, CodigoRamo";
					$res_notas = mysql_query($sql_notas,$conexion) or die(mysql_error());
					while ($row_notas = mysql_fetch_array($res_notas)) {
						array_push($arrNotas, array("rut_alumno"			=> 	'Promedios',
													"asignatura" 			=> 	$row_asignaturas['CodigoRamo'],
													"curso" 				=> 	$curso,
													"anio"					=> 	$anio,
													"semestre"				=>	$row_notas['Semestre'],
													"nota"					=> 	str_replace('.', ',', round($row_notas['promedio'],1,PHP_ROUND_HALF_UP)),
													"negro"					=>	'0'
													));
						}
								

					$sql_notas = "select avg(Nota) as promedio, CodigoCurso, CodigoRamo
									from NotasAlumnos
									where CodigoRamo = '".$row_asignaturas['CodigoRamo']."' and 
										  CodigoCurso = '".$curso."' and 
										  AnoAcademico = '".$anio."' and  
										  Nota > 0
									group by AnoAcademico, CodigoCurso, CodigoRamo";
					$res_notas = mysql_query($sql_notas,$conexion) or die(mysql_error());
					while ($row_notas = mysql_fetch_array($res_notas)) {
						array_push($arrNotas, array("rut_alumno"			=> 	'Promedios',
													"asignatura" 			=> 	$row_asignaturas['CodigoRamo'],
													"curso" 				=> 	$curso,
													"anio"					=> 	$anio,
													"semestre"				=>	'P',
													"nota"					=> 	str_replace('.', ',', round($row_notas['promedio'],1,PHP_ROUND_HALF_UP)),
													"negro"					=>	'0'
													));
						}
				}	 

		$t_p_final = $t_p_final / $i;
		array_push($arrNotas, array("item"					=>	$i, 
									"rut_alumno"			=> 	'Promedios',
									"asignatura" 			=> 	'Promedio',
									"CodigoRamo"			=>	'Promedio',
									"curso" 				=> 	$curso,
									"anio"					=> 	$anio,
									"semestre"				=>	$semestre,
									"nota"					=> 	str_replace('.', ',', round($t_p_final,1,PHP_ROUND_HALF_UP)),
									"negro"					=>	'0'
									));
		array_push($arrNotas, array("rut_alumno"			=> 	'Promedios',
									"asignatura" 			=> 	'Prom Insuf',
									"CodigoRamo"			=>	'Prom Insuf',
									"curso" 				=> 	$curso,
									"anio"					=> 	$anio,
									"semestre"				=>	$semestre,
									"nota"					=> 	str_replace('.', ',', round($t_rojos,0)),
									"negro"					=>	'0'
									));
						
		$t_porc_ina = $t_porc_ina / $i;
			array_push($arrNotas, array("item"					=>	$i, 
											"rut_alumno"			=> 	'Promedios',
											"asignatura" 			=> 	'Asis',
											"CodigoRamo"			=>	'Asis',
											"curso" 				=> 	$curso,
											"anio"					=> 	$anio,
											"semestre"				=>	$semestre,
											"nota"					=> 	str_replace('.', ',', number_format($t_porc_ina , 2 , "." , ",")),
											"negro"					=>	'1'
											));

			array_push($arrNotas, array("item"					=>	$i, 
											"rut_alumno"			=> 	'Promedios',
											"asignatura" 			=> 	'Atrasos',
											"CodigoRamo"			=>	'Atrasos',
											"curso" 				=> 	$curso,
											"anio"					=> 	$anio,
											"semestre"				=>	$semestre,
											"nota"					=> 	$t_atrasos,
											"negro"					=>	'1'
											));
			array_push($arrNotas, array("item"					=>	$i, 
											"rut_alumno"			=> 	'Promedios',
											"asignatura" 			=> 	'HV(+)',
											"CodigoRamo"			=>	'HV(+)',
											"curso" 				=> 	$curso,
											"anio"					=> 	$anio,
											"semestre"				=>	$semestre,
											"nota"					=> 	$t_positiva,
											"negro"					=>	'1'
											));
			array_push($arrNotas, array("item"					=>	$i, 
											"rut_alumno"			=> 		'Promedios',
											"asignatura" 			=> 	'HV(-)',
											"CodigoRamo"			=>	'HV(-)',
											"curso" 				=> 	$curso,
											"anio"					=> 	$anio,
											"semestre"				=>	$semestre,
											"nota"					=> 	$t_negativa,
											"negro"					=>	'1'
											));

		//var_dump($arrRegistros);
		// asigno las sesiones para el ordenamiento
		$_SESSION["alycar_matriz"] 				= 	$arrRegistros;
		

		$miSmarty->assign('arrRegistros', $arrRegistros);
		$miSmarty->assign('arrNotas', $arrNotas);
		$miSmarty->assign('arrRamos', $arrRamos);
		
		//$objResponse->addScript("xajax_Ordenar(xajax.getFormValues('Form1'), 'familia');");
		
		$objResponse->addAssign("divabonos", "innerHTML", $miSmarty->fetch('sg_panorama_anual_periodo_list.tpl'));
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
	$objResponse->addAssign("divabonos", "innerHTML", $miSmarty->fetch('sg_panorama_anual_periodo_list.tpl'));
	
	
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
	
	$objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'curso','Cursos','','- - Seleccione - -','CodigoCurso','NombreCurso', '')");
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

$miSmarty->display('sg_panorama_anual_periodo.tpl');


ob_flush();
?>

