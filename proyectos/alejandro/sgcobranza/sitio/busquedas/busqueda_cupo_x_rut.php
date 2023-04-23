<?php
$q = strtolower($_GET['patente']);
include "../../includes/php/conf_bd.php"; //archivo de coneccion al servidor y base de datos

$sql = "SELECT * 
        FROM `persona_tiene_cupos` 
        WHERE `rut_pers` = '".$q."'
        order by fecha desc
        limit 0,1
            ";
$res = mysql_query($sql, $conexion);

if (mysql_num_rows($res)>0){
    while ($row = mysql_fetch_array($res)) {
        $cupo = $row['cupo'];
        $fecha = $row['fecha'];
        $arr_fecha = explode('-',$fecha);
        
        $nro_fecha  = mktime(0, 0, 0, $arr_fecha[1], $arr_fecha[2],   $arr_fecha[0]);
        $cant_dias = date("t",$nro);
        $fecha_inicio   =   $arr_fecha[0].'-'.$arr_fecha[1].'-1';
        $fecha_termino  =   $arr_fecha[0].'-'.$arr_fecha[1].'-'.$cant_dias;
        
        $sql_1 ="SELECT sum(carga_monto) as montos
                 FROM `cargas_vehiculos` 
                 WHERE carga_pers = '".$q."' 
                     and carga_fecha between '".$fecha_inicio."' and '".$fecha_termino."'";
        $res_1 = mysql_query($sql_1, $conexion);
        $carga = 0;
        while ($row_1 = mysql_fetch_array($res_1)){
            $carga = $carga + $row_1['montos'];
        }
        echo $cupo = $cupo - $carga;
    }
}else{
    echo "Sin asignacion";
}
?>
