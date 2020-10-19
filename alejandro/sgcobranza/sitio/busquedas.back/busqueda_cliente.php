<?php

header("Content-type: application/json");
$q = strtolower($_GET['term']);
include "../../includes/php/conf_bd.php"; //archivo de coneccion al servidor y base de datos

$data = array();

$sql = "SELECT * 
        FROM clientes
			WHERE rut like '%".$q."%'
			limit 0,10";
$res = mysql_query($sql, $conexion);
$i=0;        
while ($row = mysql_fetch_assoc($res)) {
	$id_proveedor = $row['cliente_ncorr'];
	$nombre_proveedor = $row['rut'];
	$data[$i] = array('id' => $id_proveedor,
                            'value' => $nombre_proveedor,
                            'name' => $nombre_proveedor);
        $i++;
        
}
echo json_encode($data);
?>