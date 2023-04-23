<?php

header("Content-type: application/json");
$q = strtolower($_GET['term']);
include "../../includes/php/conf_bd.php"; //archivo de coneccion al servidor y base de datos

$data = array();

$sql = "SELECT * 
        FROM sggeneral.trabajadores
        WHERE nombres like '%".$q."%' 
            or apellido_pat like '%".$q."%'
			or apellido_mat like '%".$q."%'
			limit 0,10";
$res = mysql_query($sql, $conexion);
$i=0;        
while ($row = mysql_fetch_assoc($res)) {
	$ncorr_proveedor = $row['ncorr'];
	$rut_proveedor = $row['rut'];
	$id_proveedor = $row['apellido_pat'];
	$apellido_mat = $row['apellido_mat'];
	$nombre_proveedor = $row['nombres'];
	$data[$i] = array('id' => $rut_proveedor,
                      'ncorr' => $ncorr_proveedor,
                            'value' => $nombre_proveedor.' '.$id_proveedor.' '.$apellido_mat,
                            'name' => $nombre_proveedor.' '.$id_proveedor.' '.$apellido_mat);
        $i++;
        
}
echo json_encode($data);
?>