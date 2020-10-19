<?php
session_start();
header("Content-type: application/json");
$q = strtolower($_GET['term']);
include "../../includes/php/conf_bd.php"; //archivo de coneccion al servidor y base de datos

$data = array();

$sql = "SET NAMES utf8";
$res = mysql_query($sql, $conexion);
$anio = $_SESSION["sige_anio_escolar_vigente"];
	

$sql = "SELECT * 
        FROM gescolcl_arcoiris_administracion.alumnos".$anio."
			inner join gescolcl_arcoiris_administracion.Cursos
				on alumnos".$anio.".CodigoCurso = Cursos.CodigoCurso
        WHERE PaternoAlumno like '%".$q."%' 
            or MaternoAlumno like '%".$q."%'
			or NombresAlumno like '%".$q."%'
			or concat(PaternoAlumno,' ',MaternoAlumno) like '%".$q."%'
			limit 0,10";
$res = mysql_query($sql, $conexion) or die(mysql_error());
$i=0;        
while ($row = mysql_fetch_assoc($res)) {
	$ncorr_proveedor = $row['NumeroRutAlumno'];
	$rut_proveedor = $row['NumeroRutAlumno'];
	$id_proveedor = $row['PaternoAlumno'];
	$apellido_mat = $row['MaternoAlumno'];
	$nombre_proveedor = $row['NombresAlumno'];
	$curso = $row['NombreCurso'];
	$data[$i] = array('id' => $rut_proveedor,
                      'rut' => $ncorr_proveedor,
                      'value' => ($id_proveedor.' '.$apellido_mat.' '.$nombre_proveedor.' - '.$curso),
                      'name' => ($id_proveedor.' '.$apellido_mat.' '.$nombre_proveedor.' - '.$curso));
        $i++;
        
}
echo json_encode($data);
?>