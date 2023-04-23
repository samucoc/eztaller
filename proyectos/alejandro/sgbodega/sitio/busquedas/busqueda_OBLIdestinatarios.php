<?php

header("Content-type: application/json");
$q = strtolower($_GET['term']);
include "../../includes/php/conf_bd.php"; //archivo de coneccion al servidor y base de datos

$data = array();

$sql = "SELECT * 
        FROM Profesores
        WHERE PaternoProfesor like '%".$q."%' 
            or MaternoProfesor like '%".$q."%'
			or NombresProfesor like '%".$q."%'
			limit 0,10";
$res = mysql_query($sql, $conexion);
$i=0;        
while ($row = mysql_fetch_assoc($res)) {
	$ncorr_proveedor = $row['EMailFuncionario'];
	$rut_proveedor = $row['EMailFuncionario'];
	$id_proveedor = $row['PaternoProfesor'];
	$apellido_mat = $row['MaternoProfesor'];
	$nombre_proveedor = $row['NombresProfesor'];
	$data[$i] = array('id' => $rut_proveedor,
                      'rut' => $ncorr_proveedor,
                      'value' => utf8_encode($nombre_proveedor.' '.$id_proveedor.' '.$apellido_mat),
                      'name' => utf8_encode($nombre_proveedor.' '.$id_proveedor.' '.$apellido_mat));
        $i++;
        
}
echo str_replace('\u00d1', 'Ñ',json_encode($data));