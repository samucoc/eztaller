<?php

$q = strtolower($_GET['rut']);
include "../../includes/php/conf_bd.php"; //archivo de coneccion al servidor y base de datos

$sql = "SELECT * 
        FROM `persona_tiene_cupos` 
        WHERE `rut_pers` = '".$q."'
        order by ptc_ncorr desc, anio desc, mes desc
		limit 0,1";
$res = mysql_query($sql, $conexion);

if (mysql_num_rows($res)>0){
while ($row = mysql_fetch_array($res)) {
    echo $row['cupo'];
    }
}else{
    echo "0";
}
?>
