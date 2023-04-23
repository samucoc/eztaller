<?php

header("Content-type: application/json");
$q = strtolower($_GET['term']);
include "../../includes/php/conf_bd.php"; //archivo de coneccion al servidor y base de datos

$data = array();

$sql = "SELECT * 
        FROM sgyonley.empresas
        WHERE empe_desc like '%".$q."%' 
		 limit 0,10";
$res = mysql_query($sql, $conexion);
$i=0;        
while ($row = mysql_fetch_assoc($res)) {
	$rut_proveedor = $row['empe_rut'];
	$id_proveedor = $row['empe_desc'];
	$data[$i] = array('id' => $rut_proveedor,
                            'value' => utf8_encode($id_proveedor),
                            'name' => utf8_encode($id_proveedor)); 
    $i++;
}
echo json_encode($data);
?>