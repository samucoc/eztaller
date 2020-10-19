<?php
session_start();

include "../../includes/php/conf_bd.php"; //archivo de coneccion al servidor y base de datos
include "../../includes/php/validaciones.php"; //validaciones

$sql_01 = "select * 
			from alumnos".$_SESSION["sige_anio_escolar_vigente"]."
			where Matriculado = '1' 
			order by PaternoAlumno, MaternoAlumno, NombresAlumno";
$res_01 = mysql_query($sql_01,$conexion);
echo "<table>";
while($row_01 = mysql_fetch_array($res_01)){
	$rut_alumno = $row_01['NumeroRutAlumno'];
	$dv_alumno = $row_01['DigitoRutAlumno'];

		if ($dv_alumno==dv($rut_alumno)){}
		else {
	echo "<tr>";
		echo "<td>$rut_alumno</td>";
		echo "<td>$dv_alumno</td>";
		echo "<td>".dv($rut_alumno)."</td>";
			echo "<td>NO</td>";
	echo "</tr>";
		}
	
	}
echo "</table>";

?>