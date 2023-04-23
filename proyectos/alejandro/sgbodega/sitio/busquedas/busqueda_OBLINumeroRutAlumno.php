<?php
session_start();
ini_set('display_errors', 1); 
error_reporting(E_ALL);

header("Content-type: application/json");
header('Content-Type: text/html; charset=utf8');

$q = strtolower($_GET['term']);
include "../../includes/php/conf_bd.php"; //archivo de coneccion al servidor y base de datos

$data = array();
$anio					=	$_SESSION["sige_anio_escolar_vigente"];

// if ($_GET['curso']!=''){
// 	$and = ' and Cursos.CodigoCurso = "'.$_GET['curso'].'" ' ;
// 	}

$sql = "
		select * from (SELECT  NumeroRutAlumno, PaternoAlumno, MaternoAlumno, NombresAlumno, NombreCurso
        FROM alumnos".$anio."
			inner join Cursos
				on alumnos".$anio.".CodigoCurso = Cursos.CodigoCurso
        WHERE PaternoAlumno like '".($q)."%'  $and

        union
        SELECT  NumeroRutAlumno, PaternoAlumno, MaternoAlumno, NombresAlumno, NombreCurso 
        FROM alumnos".$anio."
			inner join Cursos
				on alumnos".$anio.".CodigoCurso = Cursos.CodigoCurso
        WHERE MaternoAlumno like '".($q)."%'  $and

        union
        SELECT  NumeroRutAlumno, PaternoAlumno, MaternoAlumno, NombresAlumno, NombreCurso 
        FROM alumnos".$anio."
			inner join Cursos
				on alumnos".$anio.".CodigoCurso = Cursos.CodigoCurso
        WHERE NombresAlumno like '".($q)."%'  $and

        union
        SELECT NumeroRutAlumno, PaternoAlumno, MaternoAlumno, NombresAlumno, NombreCurso
        FROM alumnos".$anio."
			inner join Cursos
				on alumnos".$anio.".CodigoCurso = Cursos.CodigoCurso
        WHERE concat(PaternoAlumno,' ',MaternoAlumno) like '".($q)."%'  $and
			) as foo 
		limit 0,20";
$res = mysql_query($sql, $conexion) or die(mysql_error());
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