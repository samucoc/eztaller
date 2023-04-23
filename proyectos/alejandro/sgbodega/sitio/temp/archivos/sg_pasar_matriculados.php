<?php
session_start();

include "../../includes/php/conf_bd.php"; //archivo de coneccion al servidor y base de datos
include "../../includes/php/validaciones.php"; //validaciones

	$sql_del = "delete from Matriculas where Anio = '".$_SESSION["sige_anio_escolar_vigente"]."'";
	$res_del = mysql_query($sql_del,$conexion);


	$i=1;
	$sql_22 = "select CodigoCurso
				from Cursos
				where CodigoCurso < 100 ";
	$res_22 = mysql_query($sql_22,$conexion);
	while($row_22 = mysql_fetch_array($res_22)){
		$j= 1;
		$sql_01 = "select * 
					from alumnos".$_SESSION["sige_anio_escolar_vigente"]."
					where Matriculado = '1' and CodigoCurso = '".$row_22['CodigoCurso']."'
					order by PaternoAlumno, MaternoAlumno, NombresAlumno";
		$res_01 = mysql_query($sql_01,$conexion);
		while($row_01 = mysql_fetch_array($res_01)){
			$sql_insert = 'INSERT INTO `Matriculas`( `NumeroRutAlumno`, `Anio`, `Fecha`, `CodigoCurso`, `NroMatricula`, `NroLista`) 
							VALUES ("'.$row_01['NumeroRutAlumno'].'","'.$_SESSION["sige_anio_escolar_vigente"].'","'.$_SESSION["sige_anio_escolar_vigente"].'-03-01",
									"'.$row_01['CodigoCurso'].'","'.$i.'","'.$j.'")';
			$res_insert = mysql_query($sql_insert,$conexion);
			$i++;
			$j++;
			}
		}

	$i=1;
	$sql_22 = "select CodigoCurso
				from Cursos
				where CodigoCurso >= 100 and CodigoCurso < 300";
	$res_22 = mysql_query($sql_22,$conexion);
	while($row_22 = mysql_fetch_array($res_22)){
		$j= 1;
		$sql_01 = "select * 
					from alumnos".$_SESSION["sige_anio_escolar_vigente"]."
					where Matriculado = '1' and CodigoCurso = '".$row_22['CodigoCurso']."'
					order by PaternoAlumno, MaternoAlumno, NombresAlumno";
		$res_01 = mysql_query($sql_01,$conexion);
		while($row_01 = mysql_fetch_array($res_01)){
			$sql_insert = 'INSERT INTO `Matriculas`( `NumeroRutAlumno`, `Anio`, `Fecha`, `CodigoCurso`, `NroMatricula`, `NroLista`) 
							VALUES ("'.$row_01['NumeroRutAlumno'].'","'.$_SESSION["sige_anio_escolar_vigente"].'","'.$_SESSION["sige_anio_escolar_vigente"].'-03-01",
									"'.$row_01['CodigoCurso'].'","'.$i.'","'.$j.'")';
			$res_insert = mysql_query($sql_insert,$conexion);
			$i++;
			$j++;
			}
		}

	$i=1;
	$sql_22 = "select CodigoCurso
				from Cursos
				where CodigoCurso >= 300 ";
	$res_22 = mysql_query($sql_22,$conexion);
	while($row_22 = mysql_fetch_array($res_22)){
		$j= 1;
		$sql_01 = "select * 
					from alumnos".$_SESSION["sige_anio_escolar_vigente"]."
					where Matriculado = '1' and CodigoCurso = '".$row_22['CodigoCurso']."'
					order by PaternoAlumno, MaternoAlumno, NombresAlumno";
		$res_01 = mysql_query($sql_01,$conexion);
		while($row_01 = mysql_fetch_array($res_01)){
			$sql_insert = 'INSERT INTO `Matriculas`( `NumeroRutAlumno`, `Anio`, `Fecha`, `CodigoCurso`, `NroMatricula`, `NroLista`) 
							VALUES ("'.$row_01['NumeroRutAlumno'].'","'.$_SESSION["sige_anio_escolar_vigente"].'","'.$_SESSION["sige_anio_escolar_vigente"].'-03-01",
									"'.$row_01['CodigoCurso'].'","'.$i.'","'.$j.'")';
			$res_insert = mysql_query($sql_insert,$conexion);
			$i++;
			$j++;
			}
		}

header("location: ../principal.php");


?>