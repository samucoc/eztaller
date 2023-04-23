<?php
ob_start();
session_start();

header("Content-type: application/json; charset=UTF-8");
$q = strtolower($_GET['term']);
include "../../includes/php/conf_bd.php"; //archivo de coneccion al servidor y base de datos
$anio = $_SESSION["sige_anio_escolar_vigente"];


$data = array();

$sql = "SELECT distinct PaternoAlumno
        FROM alumnos".$anio."
        WHERE PaternoAlumno like '%".$q."%' 
            limit 0,20";
$res = mysql_query($sql, $conexion);
$i=0;        
while ($row = mysql_fetch_assoc($res)) {
	$ncorr_proveedor = $row['NumeroRutAlumno'];
	$rut_proveedor = $row['NumeroRutAlumno'];
	$id_proveedor = $row['PaternoAlumno'];
	$apellido_mat = $row['MaternoAlumno'];
	$nombre_proveedor = $row['NombresAlumno'];
	$data[$i] = array('id' => ($id_proveedor),
                      'rut' => ($id_proveedor),
                      'value' => ($id_proveedor),
                      'name' => ($id_proveedor));
        $i++;
        
}
echo str_replace('\u00d1', '\u00D1', json_encode($data));
?>