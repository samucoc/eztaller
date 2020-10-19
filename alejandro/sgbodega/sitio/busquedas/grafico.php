<?php

header("Content-type: application/json");
include "../../includes/php/conf_bd.php"; //archivo de coneccion al servidor y base de datos

$Anio = $_GET['anio'];
$Semestre = $_GET['periodo'];


 $sql_ve = "SELECT * FROM Periodos where AnoAcademico = '".$Anio."' and Semestre = '".$Semestre."'";
	
	$res_ve = mysql_query($sql_ve, $conexion);

	$row_ve = mysql_fetch_array($res_ve);

	$fecha1		= 	$row_ve['InicioPeriodo'];
	$fecha2		=	$row_ve['TerminoPeriodo'];
	$cant_dias 	=	$row_ve['DiasPeriodo'];
	
			
		$select_notas = "select COALESCE(count(Inasistencias.NumeroRutAlumno),0) as inasistencia, Cursos.CodigoCurso, NombreCurso
						from Inasistencias
							inner join alumnos
								on alumnos.NumeroRutAlumno = Inasistencias.NumeroRutAlumno
							inner join Cursos
								on Cursos.CodigoCurso = alumnos.CodigoCurso
						where FechaInasistencia between '".$fecha1."' and '".$fecha2."'
						group by CodigoCurso";
		$res_notas = mysql_query($select_notas, $conexion) or die(mysql_error());
		$atraso = "NO";
		$datos[0] = array('curso','porcentaje');
		$i=1;
		while($row_notas = mysql_fetch_array($res_notas)){
			$porcentaje = round((100 - (($row_notas['inasistencia']*100)/$cant_dias)));
			$datos[$i] = array($row_notas['NombreCurso'],$porcentaje);		
			$i++;
			}
				

echo json_encode($datos);

?>