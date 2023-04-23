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
        $rut = $row['rut'];
        $sql_1 = "SELECT * 
            FROM `personas` 
            WHERE `pers_rut` = '".$rut."' ";
        $res_1 = mysql_query($sql_1, $conexion) or die(mysql_error());
        if (mysql_num_rows($res_1)>0){
            while ($row_1 = mysql_fetch_array($res_1)){
                echo $row_1['pers_nombre']." ".$row_1['pers_ape_pat'];
                }
            }
        else{
            echo "Sin asignacion";
            }
        }
}else{
    echo "Sin asignacion";
}
?>
