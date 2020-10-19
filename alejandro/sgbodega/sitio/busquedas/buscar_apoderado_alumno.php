<?php
include "../../includes/php/conf_bd.php"; //archivo de coneccion al servidor y base de datos

$alumno = strtolower($_GET['NumeroRutAlumno']);
$periodo = strtolower($_GET['periodo']);

$data = array();

$sql = "SELECT * 
        FROM Apoderados
		WHERE NumeroRutApoderado in (select NumeroRutApoderado
										from alumnos".$periodo."
										where NumeroRutAlumno = '".$alumno."')";
$res = mysql_query($sql, $conexion);
$i=0;        
$row = mysql_fetch_assoc($res);
	$ncorr_proveedor = $row['NumeroRutApoderado'];
	$rut_proveedor = $row['NumeroRutApoderado'];
	$id_proveedor = $row['PaternoApoderado'];
	$apellido_mat = $row['MaternoApoderado'];
	$nombre_proveedor = $row['NombresApoderado'];
	echo utf8_decode($nombre_proveedor.' '.$id_proveedor.' '.$apellido_mat);
        
?>