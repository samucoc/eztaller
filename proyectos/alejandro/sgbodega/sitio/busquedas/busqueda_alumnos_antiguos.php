<?php
session_start();

header("Content-type: application/json");
header('Content-Type: text/html; charset=utf8');

$q = strtolower($_GET['term']);
include "../../includes/php/conf_bd.php"; //archivo de coneccion al servidor y base de datos

$data = array();
$anio					=	$_SESSION["sige_anio_escolar_vigente"];

$sql = "SELECT * 
        FROM alumnos".$anio."
			inner join Cursos
				on alumnos".$anio.".CodigoCurso = Cursos.CodigoCurso
			inner join Matriculas 
				on alumnos".$anio.".NumeroRutAlumno = Matriculas.NumeroRutAlumno and 
					Matriculas.Anio = ".$anio." and 
					Matriculas.FechaRetiro = '0000-00-00'
        WHERE (PaternoAlumno like '".($q)."%' )
            or (MaternoAlumno like '".($q)."%' )
			or (NombresAlumno like '".($q)."%' )
			or (concat(PaternoAlumno,' ',MaternoAlumno) like '".($q)."%' )

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
echo str_replace('\u00d1', 'Ñ', json_encode($data));