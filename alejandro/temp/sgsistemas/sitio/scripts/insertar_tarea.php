<?php

$titulo = ($_GET['titulo']);
$responsable = ($_GET['responsable']);
$descripcion = ($_GET['descripcion']);
$inicio = ($_GET['inicio']);
$fin = ($_GET['fin']);
$color = ($_GET['area']);
$usua_id = ($_GET['usuario']);
$usua_password = ($_GET['password']);

include "../../includes/php/conf_bd.php"; //archivo de coneccion al servidor y base de datos

list($dia2,$mes2,$anio2) = explode('/', $inicio);$inicio = $anio2."-".$mes2."-".$dia2;
list($dia2,$mes2,$anio2) = explode('/', $fin);$fin = date("Y-m-d",mktime(0,0,0,$mes2,$dia2+1,$anio2));

	$sql_1 = "select * 
				from sgyonley.usuarios 
				where usua_id = '".$usua_id."' and 
					usua_password = '".$usua_password."'";
	$res_1 = mysql_query($sql_1, $conexion);
	if (mysql_num_rows($res_1) > 0){
	
		$sql = "insert into calendario(titulo,descripcion,responsable,inicio, fin, color)
					values('$titulo','$descripcion','$responsable','$inicio','$fin','$color')";
		$res = mysql_query($sql, $conexion);
		
		$id = mysql_insert_id();
	
		$sql_insert = "select * from calendario where calendario_ncorr = '".$id."'";
		$res_insert	= mysql_query($sql_insert,$conexion) or die(mysql_error());
		$row_insert = mysql_fetch_array($res_insert);
		$titulo = $row_insert['titulo'];
		$sql = "insert into historial_calendario (`accion`, `descripcion`, `fecha_dig`, `usuario`)
		values('INSERTAR','Se inserto tarea titulo $titulo','".date("Y-m-d H:i:s")."','".$usua_id."	')";
		$res = mysql_query($sql,$conexion);
	
		}

?>
