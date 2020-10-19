<?php

$id = ($_GET['tarea']);
$usua_id = ($_GET['usuario']);
$usua_password = ($_GET['password']);


include "../../includes/php/conf_bd.php"; //archivo de coneccion al servidor y base de datos
$sql_1 = "select *
from sgyonley.usuarios
where usua_id = '".$usua_id."' and
usua_password = '".$usua_password."'";
$res_1 = mysql_query($sql_1, $conexion);
if (mysql_num_rows($res_1) > 0){

	$sql_insert = "select * from calendario where calendario_ncorr = '".$id."'";
	$res_insert	= mysql_query($sql_insert,$conexion) or die(mysql_error());
	$row_insert = mysql_fetch_array($res_insert);
	$titulo = $row_insert['titulo'];
	$sql = "insert into historial_calendario (`accion`, `descripcion`, `fecha_dig`, `usuario`)
	values('ELiminar','Se Elimino tarea titulo $titulo','".date("Y-m-d H:i:s")."','".$usua_id."')";
	$res = mysql_query($sql,$conexion);
	
	
	
	$sql = "delete from calendario where calendario_ncorr = '".$id."'";
	$res = mysql_query($sql, $conexion);

		}
	

?>
