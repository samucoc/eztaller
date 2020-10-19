<?php

header("Content-type: application/json");
$q = strtolower($_GET['term']);
include "../../includes/php/conf_bd.php"; //archivo de coneccion al servidor y base de datos

$data = array();

$sql = "SELECT * 
        FROM Postulantes
        WHERE PaternoAlumno like '%".$q."%' 
            or MaternoAlumno like '%".$q."%'
			or NombresAlumno like '%".$q."%'
			limit 0,10";
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
                      'value' => $nombre_proveedor.' '.$id_proveedor.' '.$apellido_mat,
                      'name' => $nombre_proveedor.' '.$id_proveedor.' '.$apellido_mat);
        $i++;
        
}
echo json_encode($data);
?>