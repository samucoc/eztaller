<?php
include "../../includes/php/conf_bd.php";
$id_carga = $_GET['id_carga'];

$sql = "delete from cargas_vehiculos 
          where carga_ncorr = ".$id_carga;
$res = mysql_query($sql,$conexion);
        
header("Location: ../sg_informe_cargas_ingresadas.php");
?>
