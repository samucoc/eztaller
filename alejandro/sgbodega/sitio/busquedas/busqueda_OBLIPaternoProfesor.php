<?php
ob_start();
session_start();

header("Content-type: application/json; charset=UTF-8");
$q = strtolower($_GET['term']);
include "../../includes/php/conf_bd.php"; //archivo de coneccion al servidor y base de datos
$anio = $_SESSION["sige_anio_escolar_vigente"];


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
	$ncorr_proveedor = $row['NumeroRutProfesor'];
	$rut_proveedor = $row['NumeroRutProfesor'];
	$ncorr = $row['NumeroRutProfesor'];
	$id_proveedor = $row['PaternoProfesor'];
	$apellido_mat = $row['MaternoProfesor'];
	$nombre_proveedor = $row['NombresProfesor'];
	$data[$i] = array('id' => $rut_proveedor,
                      'rut' => $ncorr_proveedor,
                      'ncorr' => $ncorr,
                      'value' => utf8_encode($nombre_proveedor.' '.$id_proveedor.' '.$apellido_mat),
                      'name' => utf8_encode($nombre_proveedor.' '.$id_proveedor.' '.$apellido_mat));
        $i++;
        
}
echo str_replace('\u00d1', '\u00D1', json_encode($data));
?>