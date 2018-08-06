<?php

header("Content-type: application/json");
$q = strtolower($_GET['term']);
include "../../includes/php/conf_bd.php"; //archivo de coneccion al servidor y base de datos

$data = array();

    $sql = "SELECT distinct trep_ncorr, nombre, especificaciones
        FROM `repuestos` 
        	inner join tipo_repuestos
        		on tipo_repuestos.tipo_repuesto = repuestos.repu_ncorr
        WHERE tipo_repuestos.especificaciones like '%".$q."%' or repuestos.nombre like '%".$q."%'
		limit 0,10";
$res = mysql_query($sql, $conexion);
$i=0;        
while ($row = mysql_fetch_assoc($res)) {
	$rut_proveedor = $row['trep_ncorr'];
	$nombre_proveedor = utf8_encode($row['nombre'].' - '.$row['especificaciones']);
	$data[$i] = array('id' => $rut_proveedor,
                            'value' => strtoupper($nombre_proveedor),
                            'name' => strtoupper($nombre_proveedor));
        $i++;
        
}
echo json_encode($data);
?>