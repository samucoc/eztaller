<?php
$q = strtolower($_GET['patente']);
$fecha_1 = strtolower($_GET['fecha']);
include "../../includes/php/conf_bd.php"; //archivo de coneccion al servidor y base de datos

$sql = "SELECT * 
        FROM `persona_tiene_cupos` 
        WHERE `rut_pers` = '".$q."'
        order by ptc_ncorr desc, anio desc, mes desc
        limit 0,1
            ";
$res = mysql_query($sql, $conexion);

if (mysql_num_rows($res)>0){
    while ($row = mysql_fetch_array($res)) {
        $cupo = $row['cupo'];
        
        $arr_fecha = explode('/',$fecha_1);
        $mes = $arr_fecha[1];
        $nro_fecha  = mktime(0, 0, 0, $mes, $arr_fecha[0],   $arr_fecha[2]);
        $cant_dias = date("t",$nro_fecha);
        $fecha_inicio   =   $arr_fecha[2].'-'.$mes.'-1';
        $fecha_termino  =   $arr_fecha[2].'-'.$mes.'-'.$cant_dias;
        
        $sql_1 ="SELECT sum(carga_monto) as montos
                 FROM `cargas_vehiculos` 
                 WHERE (carga_pers = '".$q."' 
                     and carga_fecha between '".$fecha_inicio."' and '".$fecha_termino."'
					 and carga_tipo = 1)
					 ";
        $res_1 = mysql_query($sql_1, $conexion);
        $carga = 0;
        while ($row_1 = mysql_fetch_array($res_1)){
        	$carga = $carga + $row_1['montos'];
        	}
        $sql_1 ="SELECT sum(carga_monto) as montos
                 FROM `cargas_vehiculos` 
                 WHERE (carga_pers = '".$q."' 
                     and carga_fecha between '".$fecha_inicio."' and '".$fecha_termino."'
                     and carga_tipo in (5,6))
                     ";
        $res_1 = mysql_query($sql_1, $conexion);
        $carga_1 = 0;
        while ($row_1 = mysql_fetch_array($res_1)){
            $carga_1 = $carga_1 + $row_1['montos'];
            }
        
        $arr_fecha = explode('/',$fecha_1);
        $mes = $arr_fecha[1]-1;
        $fecha_inicio   =   $arr_fecha[2].'-'.$mes.'-16';
        $fecha_termino  =   $arr_fecha[2].'-'.$arr_fecha[1].'-15';
        
        
        $sql_1 ="SELECT sum(carga_monto) as montos
                 FROM `cargas_vehiculos` 
                 WHERE (carga_pers = '".$q."' 
                     and carga_fecha between '".$fecha_inicio."' and '".$fecha_termino."'
                     and carga_tipo in (4))
                     ";
        $res_1 = mysql_query($sql_1, $conexion);
        $carga_2 = 0;
        while ($row_1 = mysql_fetch_array($res_1)){
            $carga_2 = $carga_2 + $row_1['montos'];
            }
        
        echo $cupo = $cupo - ($carga + $carga_1+ $carga_2);
    }
}else{
    echo "Sin asignacion";
}
?>
