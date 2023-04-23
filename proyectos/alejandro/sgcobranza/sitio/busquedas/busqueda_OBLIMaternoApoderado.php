<?php

header("Content-type: application/json");
$q = strtolower($_GET['term']);
include "../../includes/php/conf_bd.php"; //archivo de coneccion al servidor y base de datos

$data = array();

$sql = "SELECT * 
        FROM gescolcl_arcoiris_administracion.Apoderados
        WHERE MaternoApoderado like '%".$q."%' 
			limit 0,10";
$res = mysql_query($sql, $conexion);
$i=0;        
while ($row = mysql_fetch_assoc($res)) {
	$ncorr_proveedor = $row['NumeroRutApoderado'];
	$rut_proveedor = $row['NumeroRutApoderado'];
	$nombre_proveedor = $row['MaternoApoderado'];
	$data[$i] = array('id' => $rut_proveedor,
                      'rut' => $ncorr_proveedor,
                      'value' => ($nombre_proveedor),
                      'name' => ($nombre_proveedor));
        $i++;
        
}
echo json_encode($data);
?>