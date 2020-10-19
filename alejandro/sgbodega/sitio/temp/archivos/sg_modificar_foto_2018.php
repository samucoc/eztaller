<?php
session_start();

include "../../includes/php/conf_bd.php"; //archivo de coneccion al servidor y base de datos
include "../../includes/php/validaciones.php"; //validaciones

$sql_01 = "select * 
			from alumnos".$_SESSION["sige_anio_escolar_vigente"]."
			where Matriculado = '1' 
			order by PaternoAlumno, MaternoAlumno, NombresAlumno";
$res_01 = mysql_query($sql_01,$conexion);
while($row_01 = mysql_fetch_array($res_01)){
	$rut_alumno = $row_01['NumeroRutAlumno'];
	$dv_alumno = $row_01['DigitoRutAlumno'];

	$sql_update = "update alumnos".$_SESSION["sige_anio_escolar_vigente"]."
					set FotoAlumno = 'uploads/fotos_alumnos/".number_format($rut_alumno,0,',','.')."-".$dv_alumno.".jpg'
					where NumeroRutAlumno = '".$rut_alumno."'";
	$res_update = mysql_query($sql_update,$conexion);

	}


?>