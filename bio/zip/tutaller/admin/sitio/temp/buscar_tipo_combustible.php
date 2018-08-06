<?php

$q = strtolower($_GET['tipo']);
include "../../includes/php/conf_bd.php"; //archivo de coneccion al servidor y base de datos


$sql = "SELECT * 
        FROM `tipo_combustible` 
        WHERE `tip_com_ncorr` = '".$q."' 
           ";
$res = mysql_query($sql, $conexion);
     
$row = mysql_fetch_assoc($res) ; 

echo $id_proveedor = $row['nombre'];
?>