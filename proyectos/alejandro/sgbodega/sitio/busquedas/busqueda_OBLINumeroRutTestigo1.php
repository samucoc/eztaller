<?php
ob_start();
session_start();

header("Content-type: application/json");
$q = strtolower($_GET['term']);
include "../../includes/php/conf_bd.php"; //archivo de coneccion al servidor y base de datos
$anio = $_SESSION["sige_anio_escolar_vigente"];
    
$data = array();

$sql = "SELECT * 
        FROM alumnos".$anio."
        WHERE PaternoAlumno like '%".$q."%' 
            or MaternoAlumno like '%".$q."%'
			or NombresAlumno like '%".$q."%'
		order by PaternoAlumno, MaternoAlumno, NombresAlumno
			limit 0,20";
$res = mysql_query($sql, $conexion);
$i=0;        
while ($row = mysql_fetch_assoc($res)) {
	$ncorr_proveedor = $row['NumeroRutAlumno'];
	$rut_proveedor = $row['NumeroRutAlumno'];
	$id_proveedor = $row['PaternoAlumno'];
	$apellido_mat = $row['MaternoAlumno'];
	$nombre_proveedor = $row['NombresAlumno'];
	$data[$i] = array('id' => $rut_proveedor,
                      'rut' => $ncorr_proveedor,
                      'value' => utf8_encode($id_proveedor.' '.$apellido_mat.', '.$nombre_proveedor),
                      'name' => utf8_encode($id_proveedor.' '.$apellido_mat.', '.$nombre_proveedor));
        $i++;
        
}
echo str_replace('\u00d1', 'Ñ',json_encode($data));