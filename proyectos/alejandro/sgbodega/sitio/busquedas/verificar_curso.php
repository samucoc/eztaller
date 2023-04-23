<?php
session_start();

$CodigoCurso 		= $_GET['CodigoCurso'];

include "../../includes/php/conf_bd.php"; //archivo de coneccion al servidor y base de datos

$data 	= array();

$sql = "SELECT SituacionFinal
        FROM Cursos
        WHERE CodigoCurso = '".$CodigoCurso."'";
$res = mysql_query($sql, $conexion);
$row = mysql_fetch_array($res);
echo $row['SituacionFinal'];
?>