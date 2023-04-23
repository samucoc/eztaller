<?php

header("Content-type: application/json");
$q = strtolower($_GET['term']);
include "../../includes/php/conf_bd.php"; //archivo de coneccion al servidor y base de datos

$data = array();

$sql = "SELECT * 
        FROM `vehiculos` 
        WHERE `veh_patente` like '%".$q."%'";
$res = mysql_query($sql, $conexion);
$i=0;        
while ($row = mysql_fetch_assoc($res)) {
	$rut_proveedor = $row['veh_patente'];
	$id_proveedor = $row['veh_patente'];
	$nombre_proveedor = $row['veh_patente'];
	$data[$i] = array('id' => $rut_proveedor,
                            'value' => $nombre_proveedor,
                            'name' => $nombre_proveedor);
        $i++;
}
echo json_encode($data);
?>