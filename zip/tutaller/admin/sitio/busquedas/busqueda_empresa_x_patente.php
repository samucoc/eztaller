<?php
$q = strtolower($_GET['patente']);
include "../../includes/php/conf_bd.php"; //archivo de coneccion al servidor y base de datos

$sql = "SELECT veh_emp, nombre
        FROM vehiculos
		inner join tipo_combustible
			on tipo_combustible.tip_com_ncorr = vehiculos.veh_tipo_comb
        WHERE `veh_patente` = '".$q."'
            ";
$res = mysql_query($sql, $conexion);
$salida="";
if (mysql_num_rows($res)>0){
    while ($row = mysql_fetch_array($res)) {
        $empresa = $row['veh_emp'];
        $sql_1 = "SELECT empe_desc
            FROM sgyonley.empresas
            WHERE empe_rut = '".$empresa."' ";
        $res_1 = mysql_query($sql_1, $conexion) or die(mysql_error());
        if (mysql_num_rows($res_1)>0){
            while ($row_1 = mysql_fetch_array($res_1)){
                $salida = $empresa." - ".$row_1['empe_desc'];
		echo $salida.'_'.$row['nombre'];
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
