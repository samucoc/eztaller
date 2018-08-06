<?php
session_start();
include "../../includes/php/conf_bd.php";
$id_carga = $_GET['id_carga'];

$sql = "select *
        from cargas_extras
        where ce_ncorr = ".$id_carga;
$res = mysql_query($sql,$conexion);
$row = mysql_fetch_array($res);

$carga_veh      = $row['ce_veh'];
$carga_pers     = $row['ce_pers'];
$carga_monto    = $row['ce_monto'];
$carga_fecha    = $row['ce_fecha'];

$sql = "insert into cargas_vehiculos (carga_veh,carga_pers,carga_monto,carga_fecha,carga_tipo,ce_ncorr, carga_usuario)
                    values ('".$carga_veh."','".$carga_pers."','".$carga_monto."','".$carga_fecha."','2','".$id_carga."','".$_SESSION["alycar_usuario"]."')";
$res = mysql_query($sql,$conexion);

header("Location: ../sg_combustible_ce_penau.php");
?>
