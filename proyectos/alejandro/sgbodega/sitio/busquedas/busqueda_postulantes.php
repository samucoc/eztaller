<?php

ob_start();
session_start();

header("Content-type: application/json");
$q = strtolower($_GET['term']);
include "../../includes/php/conf_bd.php"; //archivo de coneccion al servidor y base de datos

$data = array();
$anio					=	$_SESSION["sige_anio_escolar_vigente"];
$anio = $anio + 1;

$sql = "SELECT * 
        FROM Postulantes
			inner join Cursos
				on Postulantes.CodigoCurso = Cursos.CodigoCurso
        WHERE (		PaternoAlumno like '%".$q."%' and PeriodoPostulacion = '".$anio."')
            or (	MaternoAlumno like '%".$q."%' and PeriodoPostulacion = '".$anio."')
			or (	NombresAlumno like '%".$q."%' and PeriodoPostulacion = '".$anio."')
			or (	concat(PaternoAlumno,' ',MaternoAlumno) like '%".$q."%' and PeriodoPostulacion = '".$anio."')

		order by Cursos.CodigoCurso
			limit 0,20";
$res = mysql_query($sql, $conexion);
$i=0;        
while ($row = mysql_fetch_assoc($res)) {
	$ncorr_proveedor = $row['NumeroRutAlumno'];
	$rut_proveedor = $row['NumeroRutAlumno'];
	$id_proveedor = $row['PaternoAlumno'];
	$apellido_mat = $row['MaternoAlumno'];
	$nombre_proveedor = $row['NombresAlumno'];
	$curso = $row['NombreCurso'];
	$data[$i] = array('id' => $rut_proveedor,
                      'rut' => $ncorr_proveedor,
                      'value' => ($id_proveedor.' '.$apellido_mat.", ".$nombre_proveedor.' - '.$curso),
                      'name' => ($id_proveedor.' '.$apellido_mat.", ".$nombre_proveedor.' - '.$curso));
        $i++;
        
}
echo json_encode($data);
?>