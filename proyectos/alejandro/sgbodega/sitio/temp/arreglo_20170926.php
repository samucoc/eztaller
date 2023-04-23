<?php
session_start();

require_once 'includes/xajax/xajax.inc.php'; //archivo de configuracion de ajax
include "../includes/php/conf_smarty.php";//archivo de configuracion de smarty
include "../includes/php/conf_bd.php"; //archivo de coneccion al servidor y base de datos
include "../includes/php/validaciones.php"; //validaciones

$sql_001 = "SELECT max(NumeroNota) as NumeroNota,`AnoAcademico`, `Semestre`, `CodigoCurso`, `CodigoRamo` 
			FROM `Pruebas` 
			WHERE 	Semestre = '1' and 
					AnoAcademico = '2017'
			group by `AnoAcademico`, `Semestre`, `CodigoCurso`, `CodigoRamo`  ";
$res_001 = mysql_query($sql_001,$conexion) or die(mysql_error());
while($row_001 = mysql_fetch_array($res_001)){

	echo $sql_002 = "update Pruebas set 
					NumeroNota = NumeroNota - ".$row_001['NumeroNota']."
				where 	`AnoAcademico` 	= '".$row_001['AnoAcademico']."' and 
						`Semestre` 		= '2' and
						`CodigoCurso` 	= '".$row_001['CodigoCurso']."' and 
						`CodigoRamo`  	= '".$row_001['CodigoRamo']."' ";
	$res_002 = mysql_query($sql_002,$conexion) or die(mysql_error());

	}

?>