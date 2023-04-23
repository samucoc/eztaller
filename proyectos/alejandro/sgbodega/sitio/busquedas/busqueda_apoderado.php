<?php

header("Content-type: application/json");
$q = strtolower($_GET['term']);
include "../../includes/php/conf_bd.php"; //archivo de coneccion al servidor y base de datos

$data = array();

$sql = "SELECT * 
        FROM Apoderados
		WHERE PaternoApoderado like '%".$q."%' 
            or MaternoApoderado like '%".$q."%'
			or NombresApoderado like '%".$q."%'
			or concat(PaternoApoderado,' ',MaternoApoderado) like '%".$q."%'
			limit 0,10";
$res = mysql_query($sql, $conexion);
$i=0;        
while ($row = mysql_fetch_assoc($res)) {
	$ncorr_proveedor = $row['NumeroRutApoderado'];
	$rut_proveedor = $row['NumeroRutApoderado'];
	$id_proveedor = $row['PaternoApoderado'];
	$apellido_mat = $row['MaternoApoderado'];
	$nombre_proveedor = $row['NombresApoderado'];
	$direccion = $row['DireccionParticularApoderado'];
	$telefono = $row['TelefonoParticularApoderado'];
	$movil = $row['TelefonoMovilApoderado'];
	$correo = $row['EMailApoderado'];
	$data[$i] = array('id' => $rut_proveedor,
                      'rut' => $ncorr_proveedor,
                      'value' => utf8_decode($nombre_proveedor.' '.$id_proveedor.' '.$apellido_mat.' - '.$curso),
                      'name' => utf8_decode($nombre_proveedor.' '.$id_proveedor.' '.$apellido_mat.' - '.$curso),
                      'direccion' => ($direccion),
                  		'telefono' => ($telefono),
                  		'movil' => ($movil),
                  		'correo' => ($correo)
                  );
        $i++;
        
}
echo json_encode($data);
?>