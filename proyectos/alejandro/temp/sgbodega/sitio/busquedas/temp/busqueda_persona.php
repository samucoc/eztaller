<?php

header("Content-type: application/json");
$q = strtolower($_GET['term']);
include "../../includes/php/conf_bd.php"; //archivo de coneccion al servidor y base de datos

$data = array();

$sql = "SELECT * 
        FROM sgcaja.trabajadores
        WHERE trab_nombres like '%".$q."%' 
            or trab_apellidos like '%".$q."%'
			limit 0,10";
$res = mysql_query($sql, $conexion);
$i=0;        
while ($row = mysql_fetch_assoc($res)) {
	$ncorr_proveedor = $row['trab_ncorr'];
	$rut_proveedor = $row['trab_rut'];
	$id_proveedor = $row['trab_apellidos'];
	$nombre_proveedor = $row['trab_nombres'];
	$data[$i] = array('id' => $rut_proveedor,
                      'ncorr' => $ncorr_proveedor,
                            'value' => $nombre_proveedor.' '.$id_proveedor,
                            'name' => $nombre_proveedor.' '.$id_proveedor);
        $i++;
        
}
echo json_encode($data);
?>