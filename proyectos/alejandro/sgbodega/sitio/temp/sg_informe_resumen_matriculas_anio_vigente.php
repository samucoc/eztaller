<?php
ob_start();
session_start();

require_once 'includes/xajax/xajax.inc.php'; //archivo de configuracion de ajax
include "../includes/php/conf_smarty.php";//archivo de configuracion de smarty
include "../includes/php/conf_bd.php"; //archivo de coneccion al servidor y base de datos
include "../includes/php/validaciones.php"; 
$xajax = new xajax();

$xajax->setRequestURI("sg_informe_resumen_matriculas_anio_vigente.php");
$xajax->setCharEncoding("UTF8");
$xajax->decodeUTF8InputOn();


function Grabar($data){
	global $conexion;
	global $miSmarty;
        
	$objResponse = new xajaxResponse('UTF8');

	$arrRegistros = array();

	$anio = $_SESSION["sige_anio_escolar_vigente"];
    $anio_siguiente = $anio+1;
	
	$total_1 = '0';	
	$total_2 = '0';	

	$miSmarty->assign('anio_actual',$anio);
	$miSmarty->assign('anio_siguiente',$anio_siguiente);

				$sql = "select NombreCurso, Cursos.CodigoCurso, Capacidad, count(a.Matriculado) as anio_actual
						from gescolcl_nmva_administracion.alumnos".$anio." a
							inner join gescolcl_nmva_administracion.Cursos
								on a.CodigoCurso = Cursos.CodigoCurso
							inner join gescolcl_nmva_administracion.Matriculas
								on a.NumeroRutAlumno = Matriculas.NumeroRutAlumno and
									Matriculas.Anio = '".$anio."' and 
									Matriculas.FechaRetiro = '0000-00-00'
						where 1 and a.Matriculado = '1' and Cursos.CodigoCurso in (500,70,60)
						order by Cursos.CodigoCurso";
				$res = mysql_query($sql,$conexion) or die(mysql_error());
				$row = mysql_fetch_array($res);
				$anio_siguiente_1 = 0;
				$anio_siguiente_2 = 0;

				$anio_siguiente_2  += floor($row['anio_actual']);
				
				$disponible = $row['Capacidad'] - $anio_siguiente_2;

				$cantidad_alumnos = $anio_siguiente_2;
				$total_1 += $row['Capacidad'];	
				$total_2 += $anio_siguiente_1;	
				$total_3 += $anio_siguiente_2;	
				$total_4 += $disponible;	
				$total_5 += $cantidad_alumnos;	

				array_push($arrRegistros, array(	"NombreCurso"	  		=> 	'PREKINDER',
													"Capacidad"	  			=> 	$row['Capacidad'],
													"anio_actual"	  		=> 	$anio_siguiente_1,
													"anio_siguiente"	  	=> 	$anio_siguiente_2,
													"cantidad_alumnos"	  	=> 	$cantidad_alumnos,
													"disponible"			=>	$disponible));
				

			$sql = "select NombreCurso, Cursos.CodigoCurso, Capacidad
					from gescolcl_nmva_administracion.alumnos".$anio." a
						inner join gescolcl_nmva_administracion.Cursos
							on a.CodigoCurso = Cursos.CodigoCurso
							inner join gescolcl_nmva_administracion.Matriculas
								on a.NumeroRutAlumno = Matriculas.NumeroRutAlumno and
									Matriculas.Anio = '".$anio."' and 
									Matriculas.FechaRetiro = '0000-00-00'
					where 1 and a.Matriculado = '1' and Cursos.CodigoCurso < 500 and Cursos.CodigoCurso not in (70,60)
					group by NombreCurso
					order by Cursos.CodigoCurso";
			$res = mysql_query($sql,$conexion) or die(mysql_error());
			$anio_siguiente_1 = 0;
			$anio_siguiente_2 = 0;

			while($row = mysql_fetch_array($res)){

				$sql_1 = "select NombreCurso, Cursos.CodigoCurso, count(a.Matriculado) as anio_actual
					from gescolcl_nmva_administracion.alumnos".$anio." a
						inner join gescolcl_nmva_administracion.Cursos
							on a.CodigoCurso = Cursos.CodigoCurso
							inner join gescolcl_nmva_administracion.Matriculas
								on a.NumeroRutAlumno = Matriculas.NumeroRutAlumno and
									Matriculas.Anio = '".$anio."' and 
									Matriculas.FechaRetiro = '0000-00-00'
					where 1 and 
						a.Matriculado = '1' and 
						Cursos.CodigoCurso = '".$row['CodigoCurso']."' and
						a.NuevoAntiguo = '1'
					group by NombreCurso
					order by Cursos.CodigoCurso";
				$res_1 = mysql_query($sql_1,$conexion) or die(mysql_error());
				$row_1 = mysql_fetch_array($res_1);

				$anio_siguiente_1  =$row_1['anio_actual'];

				list($nro,$nombre_curso,$nivel) = explode(' ',$row['NombreCurso']);

				if (($nro=='PREKINDER')||($nro=='KINDER')){
					$sql_1 = "select count(a.Matriculado) as anio_actual
						from gescolcl_nmva_administracion.alumnos".$anio." a
							inner join gescolcl_nmva_administracion.Cursos
								on a.CodigoCurso = Cursos.CodigoCurso
							inner join gescolcl_nmva_administracion.Matriculas
								on a.NumeroRutAlumno = Matriculas.NumeroRutAlumno and
									Matriculas.Anio = '".$anio."' and 
									Matriculas.FechaRetiro = '0000-00-00'
						where 1 and 
							a.Matriculado = '1' and 
							Cursos.NombreCurso like '".$nro." ADMISION' 
						group by NombreCurso";

						$res_1 = mysql_query($sql_1,$conexion) or die(mysql_error());
						$row_1 = mysql_fetch_array($res_1);

						if (($nivel=='A')||($nivel=='ALFA')||($nombre_curso=='ALFA')||($nombre_curso=='ALF')||($nivel=='ALF')||($nivel=='AL')){
							if ($row_1['anio_actual']=='3'){
								$anio_siguiente_2  += '2';
								}
							else{
								$anio_siguiente_2  += round($row_1['anio_actual'] / 2);
								}
							}
						else{
							if ($row_1['anio_actual']=='3'){
								$anio_siguiente_2  += '1';
								}
							else{
								$anio_siguiente_2  += floor($row_1['anio_actual'] / 2);
								}
							}	

						$sql_1 = "
								select count(a.Matriculado) as anio_actual
							from gescolcl_nmva_administracion.alumnos".$anio." a
								inner join gescolcl_nmva_administracion.Cursos
									on a.CodigoCurso = Cursos.CodigoCurso
							inner join gescolcl_nmva_administracion.Matriculas
								on a.NumeroRutAlumno = Matriculas.NumeroRutAlumno and
									Matriculas.Anio = '".$anio."' and 
									Matriculas.FechaRetiro = '0000-00-00'
							where 1 and 
								a.Matriculado = '1' and 
								Cursos.CodigoCurso = '".$row['CodigoCurso']."' and 
								a.NuevoAntiguo = '0'
							group by NombreCurso";
						$res_1 = mysql_query($sql_1,$conexion) or die(mysql_error());
						$row_1 = mysql_fetch_array($res_1);

						$anio_siguiente_2  += floor($row_1['anio_actual']);

					}
				else{
					$sql_1 = "select count(a.Matriculado) as anio_actual
						from gescolcl_nmva_administracion.alumnos".$anio." a
							inner join gescolcl_nmva_administracion.Cursos
								on a.CodigoCurso = Cursos.CodigoCurso
							inner join gescolcl_nmva_administracion.Matriculas
								on a.NumeroRutAlumno = Matriculas.NumeroRutAlumno and
									Matriculas.Anio = '".$anio."' and 
									Matriculas.FechaRetiro = '0000-00-00'
						where 1 and 
							a.Matriculado = '1' and 
							Cursos.NombreCurso like '".$nro." ".$nombre_curso." ADMISION' 
						group by NombreCurso";
					$res_1 = mysql_query($sql_1,$conexion) or die(mysql_error());
					$row_1 = mysql_fetch_array($res_1);

					if (($nivel=='A')||($nivel=='ALFA')||($nombre_curso=='ALFA')||($nombre_curso=='ALF')||($nivel=='ALF')||($nivel=='AL')){
						if ($row_1['anio_actual']=='3'){
							$anio_siguiente_2  += '2';
							}
						else{
							$anio_siguiente_2  += round($row_1['anio_actual'] / 2);
							}
						}
					else{
						if ($row_1['anio_actual']=='3'){
							$anio_siguiente_2  += '1';
							}
						else{
							$anio_siguiente_2  += floor($row_1['anio_actual'] / 2);
							}
						}	

				 	$sql_1 = "
						select count(a.Matriculado) as anio_actual
						from gescolcl_nmva_administracion.alumnos".$anio." a
							inner join gescolcl_nmva_administracion.Cursos
								on a.CodigoCurso = Cursos.CodigoCurso
							inner join gescolcl_nmva_administracion.Matriculas
								on a.NumeroRutAlumno = Matriculas.NumeroRutAlumno and
									Matriculas.Anio = '".$anio."' and 
									Matriculas.FechaRetiro = '0000-00-00'
						where 1 and 
							a.Matriculado = '1' and 
							Cursos.CodigoCurso = '".$row['CodigoCurso']."' and 
							a.NuevoAntiguo = '0'
						group by NombreCurso";
					$res_1 = mysql_query($sql_1,$conexion) or die(mysql_error());
					$row_1 = mysql_fetch_array($res_1);

					$anio_siguiente_2  += floor($row_1['anio_actual']);
						
					
					}
				

				
				$disponible = $row['Capacidad'] - $anio_siguiente_1 - $anio_siguiente_2;

				$cantidad_alumnos = $anio_siguiente_1 + $anio_siguiente_2;
				array_push($arrRegistros, array(	"NombreCurso"	  		=> 	$row['NombreCurso'],
													"Capacidad"	  			=> 	$row['Capacidad'],
													"anio_actual"	  		=> 	$anio_siguiente_1,
													"anio_siguiente"	  	=> 	$anio_siguiente_2,
													"cantidad_alumnos"	  	=> 	$cantidad_alumnos,
													"disponible"			=>	$disponible));

				$total_1 += $row['Capacidad'];	
				$total_2 += $anio_siguiente_1;	
				$total_3 += $anio_siguiente_2;	
				$total_4 += $disponible;	
				$total_5 += $cantidad_alumnos;	

				$anio_siguiente_1 = 0;
				$anio_siguiente_2 = 0;

				}

				array_push($arrRegistros, array(	"NombreCurso"	  		=> 	'Total General',
													"Capacidad"	  			=> 	$total_1,
													"anio_actual"	  		=> 	$total_2,
													"anio_siguiente"	  	=> 	$total_3,
													"cantidad_alumnos"	  	=> 	$total_5,
													"disponible"			=>	$total_4));

			$miSmarty->assign('arrRegistros', $arrRegistros);
			$objResponse->addAssign("divresultado", "innerHTML", $miSmarty->fetch('sg_informe_resumen_matriculas_list_2.tpl'));
	
	return $objResponse->getXML();
	
	}

$xajax->registerFunction("Grabar");

$xajax->processRequests();
$miSmarty->assign('xajax_js', $xajax->getJavascript());


$miSmarty->display('sg_informe_resumen_matriculas.tpl');


ob_flush();
?>
