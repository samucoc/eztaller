<?php
$q = strtolower($_GET['patente']);
include "../../includes/php/conf_bd.php"; //archivo de coneccion al servidor y base de datos

$sql = "SELECT * 
        FROM `personas_tienen_vehiculos` 
        WHERE `patente` = '".$q."'
			and rut is not null
            ";
$res = mysql_query($sql, $conexion);

if (mysql_num_rows($res)>0){
    while ($row = mysql_fetch_array($res)) {
        echo $rut = $row['rut'];
	}
}else{
    echo "Sin asignacion";
}
?>
