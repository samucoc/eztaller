<?php

header("Content-type: application/json");
$q = strtolower($_GET['term']);
include "../../includes/php/conf_bd.php"; //archivo de coneccion al servidor y base de datos
include "../../includes/php/validaciones.php"; //validaciones

$data = array();

$sql = "SELECT * 
        FROM Apoderados
        WHERE PaternoApoderado like '%".$q."%' 
            or MaternoApoderado like '%".$q."%'
			or NombresApoderado like '%".$q."%'
			or NumeroRutApoderado like '".$q."%'
			limit 0,10";
$res = mysql_query($sql, $conexion);
$i=0;        
while ($row = mysql_fetch_assoc($res)) {
	$ncorr_proveedor = $row['NumeroRutApoderado'];
	$rut_proveedor = $row['NumeroRutApoderado'];
	$id_proveedor = $row['PaternoApoderado'];
	$apellido_mat = $row['MaternoApoderado'];
	$nombre_proveedor = $row['NombresApoderado'];
	$data[$i] = array('id' => $rut_proveedor,
                      'rut' => $ncorr_proveedor,
                      'value' => utf8_encode($rut_proveedor.'-'.dv($rut_proveedor).' '.strtoupper ($id_proveedor).' '.strtoupper ($apellido_mat).' '.strtoupper ($nombre_proveedor)),
                      'name' => utf8_encode($rut_proveedor.'-'.dv($rut_proveedor).' '.strtoupper ($id_proveedor).' '.strtoupper ($apellido_mat).' '.strtoupper ($nombre_proveedor)));
        $i++;
        
}
echo str_replace('\u00d1', '\u00D1', json_encode($data));
?>