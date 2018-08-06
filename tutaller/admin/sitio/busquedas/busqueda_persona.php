<?php

header("Content-type: application/json");
$q = strtolower($_GET['term']);
include "../../includes/php/conf_bd.php"; //archivo de coneccion al servidor y base de datos

$data = array();

$sql = "SELECT * 
        FROM `personas` 
        WHERE (`pers_nombre` like '".$q."%'  )
            or (`pers_ape_pat` like '".$q."%' )    
		limit 0,10";
$res = mysql_query($sql, $conexion);
$i=0;        
while ($row = mysql_fetch_assoc($res)) {
	$rut_proveedor = $row['pers_rut'];
	$id_proveedor = utf8_encode($row['pers_ape_pat']);
	$name_proveedor = utf8_encode($row['pers_ape_mat']);
	$nombre_proveedor = utf8_encode($row['pers_nombre']);
	$data[$i] = array('id' => $rut_proveedor,
                            'value' => $nombre_proveedor.' '.$id_proveedor.' '.$name_proveedor,
                            'name' => $nombre_proveedor.' '.$id_proveedor.' '.$name_proveedor);
        $i++;
        
}
echo json_encode($data);
?>