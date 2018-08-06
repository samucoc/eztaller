<?php

$q = strtolower($_GET['rut']);
include "../../includes/php/conf_bd.php"; //archivo de coneccion al servidor y base de datos


$sql = "SELECT * 
        FROM `empresas` 
        WHERE `empe_rut` = '".$q."' 
           ";
$res = mysql_query($sql, $conexion);
$i=0;        
$row = mysql_fetch_assoc($res) ; 

echo $id_proveedor = $row['empe_desc'];
?>