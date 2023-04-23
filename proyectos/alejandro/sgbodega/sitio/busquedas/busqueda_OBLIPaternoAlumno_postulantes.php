<?php

header("Content-type: application/json; charset=UTF-8");
$q = strtolower($_GET['term']);
include "../../includes/php/conf_bd.php"; //archivo de coneccion al servidor y base de datos

$data = array();

$sql = "SELECT distinct PaternoAlumno
        FROM Postulantes
        WHERE PaternoAlumno like '%".$q."%' 
            limit 0,10";
$res = mysql_query($sql, $conexion);
$i=0;        
while ($row = mysql_fetch_assoc($res)) {
	$ncorr_proveedor = $row['NumeroRutAlumno'];
	$rut_proveedor = $row['NumeroRutAlumno'];
	$id_proveedor = $row['PaternoAlumno'];
	$apellido_mat = $row['MaternoAlumno'];
	$nombre_proveedor = $row['NombresAlumno'];
	$data[$i] = array('id' => utf8_encode($id_proveedor),
                      'rut' => utf8_encode($id_proveedor),
                      'value' => utf8_encode($id_proveedor),
                      'name' => utf8_encode($id_proveedor));
        $i++;
        
}
echo str_replace('\u00d1', '\u00D1', json_encode($data));
?>