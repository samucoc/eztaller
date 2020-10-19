<?php
ob_start();
session_start();

include "../../includes/php/conf_bd.php"; //archivo de coneccion al servidor y base de datos


	global $conexion;
	$arrRegistros = array();

	$anio = $_SESSION["sige_anio_escolar_vigente"];
    $anio_siguiente = $anio+1;
			$total_1 = '0';	
			$total_2 = '0';	


		$sql = "select NombreCurso, Cursos.CodigoCurso, count(a.Matriculado) as anio_actual, Capacidad
				from gescolcl_test.alumnos".$anio." a
					inner join gescolcl_test.Cursos
						on a.CodigoCurso = Cursos.CodigoCurso
				where 1 and a.Matriculado = '1'
				group by NombreCurso
				order by Cursos.CodigoCurso";
		$res = mysql_query($sql,$conexion) or die(mysql_error());
		while($row = mysql_fetch_array($res)){

			$sql_1 = "select NombreCurso, Cursos.CodigoCurso, count(a.Matriculado) as anio_actual
				from gescolcl_test.alumnos".$anio_siguiente." a
					inner join gescolcl_test.Cursos
						on a.CodigoCurso = Cursos.CodigoCurso
				where 1 and a.Matriculado = '1' and Cursos.CodigoCurso = '".$row['CodigoCurso']."'
				group by NombreCurso
				order by Cursos.CodigoCurso";
			$res_1 = mysql_query($sql_1,$conexion) or die(mysql_error());
			$row_1 = mysql_fetch_array($res_1);

			$anio_siguiente_1  =$row_1['anio_actual'];

			list($nro,$nombre_curso,$nivel) = explode(' ',$row['NombreCurso']);

			if (($nro=='PREKINDER')||($nro=='KINDER')){
				$sql_1 = "select count(a.Matriculado) as anio_actual
					from gescolcl_test.alumnos".$anio_siguiente." a
						inner join gescolcl_test.Cursos
							on a.CodigoCurso = Cursos.CodigoCurso
					where 1 and a.Matriculado = '1' and Cursos.NombreCurso like '".$nro." ADMISION'
					group by NombreCurso
					order by Cursos.CodigoCurso";
				
				}
			else
				{
				$sql_1 = "select count(a.Matriculado) as anio_actual
					from gescolcl_test.alumnos".$anio_siguiente." a
						inner join gescolcl_test.Cursos
							on a.CodigoCurso = Cursos.CodigoCurso
					where 1 and a.Matriculado = '1' and Cursos.NombreCurso like '".$nro." ".$nombre_curso." ADMISION'
					group by NombreCurso
					order by Cursos.CodigoCurso";
				}
			$res_1 = mysql_query($sql_1,$conexion) or die(mysql_error());
			$row_1 = mysql_fetch_array($res_1);

			if (($nivel=='A')||($nivel=='ALFA')||($nombre_curso=='ALFA')||($nombre_curso=='ALF')||($nivel=='ALF')||($nivel=='AL')){
				if ($row_1['anio_actual']=='3'){
					$anio_siguiente_2  = '2';
					}
				else{
					$anio_siguiente_2  = round($row_1['anio_actual'] / 2);
					}
				}
			else{
				if ($row_1['anio_actual']=='3'){
					$anio_siguiente_2  = '1';
					}
				else{
					$anio_siguiente_2  = floor($row_1['anio_actual'] / 2);
					}
				}

			$disponible = $row['Capacidad'] - $anio_siguiente_1 - $anio_siguiente_2;

			array_push($arrRegistros, array(	"NombreCurso"	  		=> 	$row['NombreCurso'],
												"Capacidad"	  			=> 	$row['Capacidad'],
												"anio_actual"	  		=> 	$anio_siguiente_1,
												"anio_siguiente"	  	=> 	$anio_siguiente_2,
												"disponible"			=>	$disponible));

			$total_1 += $row['Capacidad'];	
			$total_2 += $anio_siguiente_1;	
			$total_3 += $anio_siguiente_2;	
			$total_4 += $disponible;	

			}


			array_push($arrRegistros, array(	"NombreCurso"	  		=> 	'Total General',
												"Capacidad"	  			=> 	$total_1,
												"anio_actual"	  		=> 	$total_2,
												"anio_siguiente"	  	=> 	$total_3,
												"disponible"			=>	$total_4));

			

?>