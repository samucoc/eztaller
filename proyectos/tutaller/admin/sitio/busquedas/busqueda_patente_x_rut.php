<?php
$q = strtolower($_GET['rut']);
include "../../includes/php/conf_bd.php"; //archivo de coneccion al servidor y base de datos

$sql = "SELECT * 
        FROM `personas_tienen_vehiculos` 
        WHERE `rut` = '".$q."'
			and patente is not null
            ";
$res = mysql_query($sql, $conexion);

if (mysql_num_rows($res)>0){
    while ($row = mysql_fetch_array($res)) {
        echo $rut = $row['patente'];
        }
}else{
    echo "Sin asignacion";
}
?>
