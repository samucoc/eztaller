<?php

header("Content-type: application/json");
$q = strtolower($_GET['term']);
include "../../includes/php/conf_bd.php"; //archivo de coneccion al servidor y base de datos

$data = array();

$sql = "SELECT * 
        FROM `usuarios` 
        WHERE `usu_login` like '%".$q."%' 
		limit 0,10";
$res = mysql_query($sql, $conexion);
$i=0;        
while ($row = mysql_fetch_assoc($res)) {
	$rut_proveedor = $row['usu_login'];
	$id_proveedor = $row['usu_nombre'];
	$nombre_proveedor = $row['usu_nombre'];
	$data[$i] = array('id' => $usu_login,
                            'value' => $id_proveedor,
                            'name' => $nombre_proveedor);
        $i++;
        
}
echo json_encode($data);
?>