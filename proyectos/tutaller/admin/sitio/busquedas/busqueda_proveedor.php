<?php

header("Content-type: application/json");
$q = strtolower($_GET['term']);
include "../../includes/php/conf_bd.php"; //archivo de coneccion al servidor y base de datos

$data = array();

$sql = "SELECT * 
        FROM `proveedor` 
        WHERE `PR_RAZON` like '%".$q."%' 
		limit 0,10";
$res = mysql_query($sql, $conexion);
$i=0;        
while ($row = mysql_fetch_assoc($res)) {
	$rut_proveedor = $row['PR_RUT'];
	$nombre_proveedor = $row['PR_RAZON'];
	$data[$i] = array('id' => $rut_proveedor,
                            'value' => strtoupper($nombre_proveedor),
                            'name' => strtoupper($nombre_proveedor));
        $i++;
        
}
echo json_encode($data);
?>