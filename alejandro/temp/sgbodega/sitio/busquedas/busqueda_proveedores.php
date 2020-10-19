<?php

header("Content-type: application/json");
$q = strtolower($_GET['term']);
include "../../includes/php/conf_bd.php"; //archivo de coneccion al servidor y base de datos

$data = array();

$sql = "SELECT * 
        FROM sgbodega.proveedor
			WHERE PR_RAZON like '%".$q."%'
			limit 0,10";
$res = mysql_query($sql, $conexion);
$i=0;        
while ($row = mysql_fetch_assoc($res)) {
	$id_proveedor = $row['PR_NCORR'];
	$nombre_proveedor = $row['PR_RAZON'];
	$rut_proveedor = $row['PR_RUT'];
	$direccion_prov = $row['PR_DIRECCION'];
	$telefono_prov  = $row['PR_FONO1'];
	$email_prov 	= $row['PR_MAIL'];
	$nc_prov		= $row['PR_ATENCION'];
	$data[$i] = array('id' => $id_proveedor,
                            'value' => $nombre_proveedor,
                            'name' => $nombre_proveedor,
							'rut' => $rut_proveedor,
                            'direccion' => $direccion_prov,
							'fono1' => $telefono_prov,
                            'email' => $email_prov,
							'atencion' => $nc_prov);
        $i++;
        
}
echo json_encode($data);
?>